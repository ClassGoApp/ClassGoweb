<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class NotificacionController extends Controller
{
    protected $messaging;
    public function __construct()
    {
        try {
            $credentialsPath = env('FIREBASE_CREDENTIALS');
            $fullPath = base_path($credentialsPath);
            
            Log::info('FcmService: Inicializando Firebase', [
                'credentials_path' => $credentialsPath,
                'full_path' => $fullPath,
                'file_exists' => file_exists($fullPath),
                'file_size' => file_exists($fullPath) ? filesize($fullPath) : 'N/A'
            ]);
            
            if (!file_exists($fullPath)) {
                throw new \Exception("Archivo de credenciales de Firebase no encontrado: {$fullPath}");
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
        ]);

        try {
            $messaging = app(Messaging::class);
            $message = CloudMessage::withTarget('topic', 'tutor')
            ->withNotification(Notification::create(
                $request->title,
                $request->body
            ))
            ->withData([
                'tipo' => 'solicitud_tutor',
                'screen' => 'solicitud_tutor',
            ]);

            $result = $messaging->send($message);

            return response()->json([
                'ok' => true,
                'message' => 'Notificación enviada al topic tutores',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'message' => 'Error al inicializar el servicio de mensajería',
                'error' => $e->getMessage()
            ], 500);
        }

        //$messaging = app(Messaging::class);

    }
    public function enviarAEstudiantes(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        try {
            $messaging = app(Messaging::class);
            $message = CloudMessage::withTarget('topic', 'student')
            ->withNotification(Notification::create(
                $request->title,
                $request->body
            ))
            ->withData([
                'tipo' => 'nueva_publicacion',
                'screen' => 'feed',
            ]);

            $result = $messaging->send($message);

            return response()->json([
                'ok' => true,
                'message' => 'Notificación enviada al topic estudiantes',
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
}