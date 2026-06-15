<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
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

            if (count($tokens) === 1) {
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
            } else {
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
            }

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
                    ->whereIn('email', $emails)
                    ->whereNotNull('fcm_token')
                    ->where('fcm_token', '!=', '')
                    ->pluck('fcm_token')
                    ->toArray();
                return $this->enviarNotificacionPrivada($tokens, $messaging, $request);
            }

            if ($request->type == 'tutor') {
                $tokens = DB::table('users')
                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->where('model_has_roles.role_id', 2)
                    ->whereNotNull('users.fcm_token')
                    ->where('users.fcm_token', '!=', '')
                    ->pluck('users.fcm_token')
                    ->toArray();

                if (empty($tokens)) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'No se encontraron tutores con tokens FCM válidos'
                    ], 404);
                }
            } else if ($request->type == 'estudiante') {
                $tokens = DB::table('users')
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.role_id', '=', '3')
                    ->whereNotNull('users.fcm_token')
                    ->where('users.fcm_token', '!=', '')
                    ->pluck('users.fcm_token')
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
            }

            $failures = [];

            foreach ($result->failures()->getItems() as $failure) {
                $failures[] = [
                    'token' => $failure->target()->value(),
                    'error' => $failure->error()->getMessage(),
                ];
            }

            return response()->json([
                'ok' => true,
                'message' => 'Proceso de envío terminado',
                'success_count' => $result->successes()->count(),
                'failure_count' => $result->failures()->count(),
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