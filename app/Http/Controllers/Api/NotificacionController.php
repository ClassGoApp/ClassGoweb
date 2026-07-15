<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\FcmToken;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    protected $messaging;
    public function __construct()
    {
        try {
            $credentialsPath = config('services.firebase.credentials') ?? env('FIREBASE_CREDENTIALS');
            
            if ($credentialsPath) {
                $credentialsPath = ltrim($credentialsPath, './\\');
            }

            $fullPath = $credentialsPath ? base_path($credentialsPath) : null;

            Log::info('FcmService: Inicializando Firebase', [
                'credentials_path' => $credentialsPath,
                'full_path' => $fullPath,
                'is_file' => $fullPath ? is_file($fullPath) : false,
                'file_size' => ($fullPath && is_file($fullPath)) ? filesize($fullPath) : 'N/A'
            ]);

            if (!$fullPath || !is_file($fullPath)) {
                throw new \Exception("Archivo de credenciales de Firebase no encontrado o no es un archivo válido: {$fullPath}");
            }

            $factory = (new Factory)->withServiceAccount($fullPath);
            $this->messaging = $factory->createMessaging();

            Log::info('FcmService: Firebase inicializado correctamente');

        } catch (\Exception $e) {
            Log::error('FcmService: Error al inicializar Firebase', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    public function enviarATutores(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'type' => 'required|string',
            'screen' => 'required|string',
        ]);

        try {
            $messaging = $this->messaging;

            $only = $request->only;
            if ($only) {
                $tokens = $request->tokens;
                return $this->enviarNotificacionPrivada($tokens, $messaging, $request);
            }

            $message = CloudMessage::withTarget('topic', 'tutor')
                ->withNotification(Notification::create(
                    $request->title,
                    $request->body
                ))
                ->withData([
                    'type' => $request->type,
                    'screen' => $request->screen,
                    'data_tutor' => json_encode($request->data_tutor ?? ''),
                ]);

            $result = $messaging->send($message);

            return response()->json([
                'ok' => true,
                'message' => 'Notificación enviada al topic tutores',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('Error enviando notificación a tutores', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error al enviar la notificación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Funcion Privada
    private function enviarNotificacionPrivada($tokens, $messaging, $request)
    {
        try {
            // Asegurarnos de que $tokens sea un array
            if (is_string($tokens)) {
                $decoded = json_decode($tokens, true);
                $tokens = is_array($decoded) ? $decoded : [$tokens];
            }

            $tokens = array_values(array_filter($tokens, fn($token) => !empty($token)));

            if (empty($tokens)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'No hay tokens válidos para enviar'
                ], 400);
            }

            Log::info('NotificacionController: Iniciando envío privado de notificación', [
                'token_count' => count($tokens),
                'title' => $request->title,
                'body' => $request->body,
                'type' => $request->type,
            ]);

            if (count($tokens) === 1) {
                try {
                    $message = CloudMessage::withTarget('token', $tokens[0])
                        ->withNotification(Notification::create(
                            $request->title,
                            $request->body
                        ))
                        ->withData([
                            'type' => $request->type,
                            'screen' => $request->screen,
                            'data_tutor' => json_encode($request->data_tutor ?? ''),
                        ]);

                    $result = $messaging->send($message);

                    return response()->json([
                        'ok' => true,
                        'message' => 'Notificación enviada a los tutores seleccionados',
                        'result' => $result
                    ]);
                } catch (\Exception $e) {
                    if ($this->shouldRemoveTokenFromErrorMessage($e->getMessage())) {
                        FcmToken::where('token', $tokens[0])->delete();
                        Log::warning('NotificacionController: Token FCM inválido eliminado', [
                            'token_preview' => substr($tokens[0], 0, 20) . '...',
                            'error' => $e->getMessage(),
                            'user' => 'private_send'
                        ]);
                    }

                    return response()->json([
                        'ok' => false,
                        'message' => 'Error al enviar notificación a token individual',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            $message = CloudMessage::new()
                ->withNotification(Notification::create(
                    $request->title,
                    $request->body
                ))
                ->withData([
                    'type' => $request->type,
                    'screen' => $request->screen,
                    'data_tutor' => json_encode($request->data_tutor ?? ''),
                ]);

            $result = $messaging->sendMulticast($message, $tokens);
            $this->handleMulticastFailures($result, $tokens);

            return response()->json([
                'ok' => true,
                'message' => 'Notificación enviada a los tutores seleccionados',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al inicializar el servicio de mensajería',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function handleMulticastFailures($result, array $tokens): void
    {
        if (!method_exists($result, 'failures')) {
            return;
        }

        foreach ($result->failures()->getItems() as $failure) {
            $token = $failure->target()->value();
            $errorMessage = $failure->error()->getMessage();
            $errorClass = get_class($failure->error());
            $shouldRemove = $this->shouldRemoveTokenFromErrorMessage($errorMessage) || $this->shouldRemoveTokenFromErrorClass($errorClass);

            if ($shouldRemove) {
                FcmToken::where('token', $token)->delete();
                Log::warning('NotificacionController: Token FCM inválido eliminado tras sendMulticast', [
                    'token_preview' => substr($token, 0, 20) . '...',
                    'error' => $errorMessage,
                    'error_class' => $errorClass,
                ]);
            } else {
                Log::warning('NotificacionController: FCM failure registrado', [
                    'token_preview' => substr($token, 0, 20) . '...',
                    'error' => $errorMessage,
                    'error_class' => $errorClass,
                ]);
            }
        }
    }

    private function shouldRemoveTokenFromErrorMessage(string $message): bool
    {
        $lower = strtolower($message);

        if (str_contains($lower, 'invalid registration token') ||
            str_contains($lower, 'not registered') ||
            str_contains($lower, 'requested entity was not found') ||
            str_contains($lower, 'unregistered') ||
            str_contains($lower, 'registration token is not a valid fcm registration token')) {
            return true;
        }

        return false;
    }

    private function shouldRemoveTokenFromErrorClass(string $errorClass): bool
    {
        return in_array($errorClass, [
            'Kreait\\Firebase\\Exception\\Messaging\\NotFound',
            'Kreait\\Firebase\\Exception\\Messaging\\InvalidArgument',
            'Kreait\\Firebase\\Exception\\Messaging\\InvalidMessage',
            'Kreait\\Firebase\\Exception\\Messaging\\Unregistered',
        ], true);
    }
    public function enviarNotificacionMasiva(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'type' => 'nullable|string',
            'data' => 'nullable|array'
        ]);

        try {
            $messaging = $this->messaging;

            if ($request->type == 'only') {
                // Obtener los tokens a partir de una lista de email de la base de datos
                $emails = $request->emails;
                if (empty($emails)) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'No se encontraron emails'
                    ], 404);
                }
                $tokens = DB::table('users')
                    ->join('fcm_tokens', 'users.id', '=', 'fcm_tokens.user_id')
                    ->whereIn('users.email', $emails)
                    ->whereNotNull('fcm_tokens.token')
                    ->where('fcm_tokens.token', '!=', '')
                    ->pluck('fcm_tokens.token')
                    ->toArray();
                return $this->enviarNotificacionPrivada($tokens, $messaging, $request);
            }

            if ($request->type == 'tutor') {
                $tokens = DB::table('fcm_tokens')
                    ->join('model_has_roles', 'fcm_tokens.user_id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', 2)
                    ->whereNotNull('fcm_tokens.token')
                    ->where('fcm_tokens.token', '!=', '')
                    ->pluck('fcm_tokens.token')
                    ->toArray();

                if (empty($tokens)) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'No se encontraron tutores con tokens FCM válidos'
                    ], 404);
                }
            } else if ($request->type == 'estudiante') {
                $tokens = DB::table('fcm_tokens')
                    ->join('model_has_roles', 'fcm_tokens.user_id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', 3)
                    ->whereNotNull('fcm_tokens.token')
                    ->where('fcm_tokens.token', '!=', '')
                    ->pluck('fcm_tokens.token')
                    ->toArray();

                if (empty($tokens)) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'No se encontraron estudiantes con tokens FCM válidos'
                    ], 404);
                }
            } else {
                // Enviar la notificación a través del topic mass_notification
                $message = CloudMessage::withTarget('topic', 'mass_notification')
                    ->withNotification(Notification::create(
                        $request->title,
                        $request->body
                    ))
                    ->withData([
                        'type' => $request->type ?? 'general',
                        'screen' => $request->screen ?? 'feed',
                        'data' => json_encode($request->data ?? ''),
                    ]);

                $result = $messaging->send($message);

                return response()->json([
                    'ok' => true,
                    'message' => 'Notificación enviada al topic mass_notification',
                    'result' => $result
                ]);
            }

            // Preparar el request para enviarNotificacionGenerica
            $request->merge([
                'title' => $request->title,
                'body' => $request->body,
                'tokens' => $tokens,
                'type' => $request->type ?? 'general',
                'screen' => $request->screen ?? 'feed',
                'data' => $request->data ?? []
            ]);

            return $this->enviarNotificacionGenerica($request);

        } catch (\Exception $e) {
            Log::error('Error en enviarAEstudiantes (masivo)', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error al procesar el envío masivo a estudiantes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function enviarNotificacionGenerica(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'type' => 'required|string',
            'screen' => 'required|string',
        ]);
        if (empty($request->tokens)) {
            return response()->json([
                'ok' => false,
                'message' => 'No hay tokens válidos para enviar'
            ], 400);
        }
        try {

            $messaging = $this->messaging;
            $tokens = $request->tokens;
            // Asegurarnos de que $tokens sea un array
            if (is_string($tokens)) {
                $decoded = json_decode($tokens, true);
                $tokens = is_array($decoded) ? $decoded : [$tokens];
            }

            if (count($tokens) === 1) {
                try {
                    $message = CloudMessage::withTarget('token', $tokens[0])
                        ->withNotification(Notification::create(
                            $request->title,
                            $request->body
                        ))
                        ->withData([
                            'type' => $request->type,
                            'screen' => $request->screen,
                            'data' => json_encode($request->data ?? ''),
                        ]);
                    $result = $messaging->send($message);
                } catch (\Exception $e) {
                    if ($this->shouldRemoveTokenFromErrorMessage($e->getMessage()) || $this->shouldRemoveTokenFromErrorClass(get_class($e))) {
                        FcmToken::where('token', $tokens[0])->delete();
                        Log::warning('NotificacionController: Token FCM inválido eliminado en enviarNotificacionGenerica', [
                            'token_preview' => substr($tokens[0], 0, 20) . '...',
                            'error' => $e->getMessage(),
                            'error_class' => get_class($e),
                        ]);
                    }

                    return response()->json([
                        'ok' => false,
                        'message' => 'Error al enviar notificación a token individual',
                        'error' => $e->getMessage()
                    ], 500);
                }
            } else {
                $message = CloudMessage::new()
                    ->withNotification(Notification::create(
                        $request->title,
                        $request->body
                    ))
                    ->withData([
                        'type' => $request->type,
                        'screen' => $request->screen,
                        'data' => json_encode($request->data ?? ''),
                    ]);

                $result = $messaging->sendMulticast($message, $tokens);
                $this->handleMulticastFailures($result, $tokens);
            }

            $failures = [];

            if (method_exists($result, 'failures')) {
                foreach ($result->failures()->getItems() as $failure) {
                    $failures[] = [
                        'token' => $failure->target()->value(),
                        'error' => $failure->error()->getMessage(),
                    ];
                }
            }

            return response()->json([
                'ok' => true,
                'message' => 'Proceso de envío terminado',
                'success_count' => method_exists($result, 'successes') ? $result->successes()->count() : null,
                'failure_count' => method_exists($result, 'failures') ? $result->failures()->count() : null,
                'valid_tokens' => count($tokens),
                'failures' => $failures,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al enviar la notificación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}