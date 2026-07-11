<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FcmService
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

    public function sendNotification($fcmToken, $title, $body, $data = [])
    {
        try {
            Log::info('FcmService: Enviando notificación', [
                'fcm_token_length' => strlen($fcmToken),
                'fcm_token_preview' => substr($fcmToken, 0, 20) . '...',
                'title' => $title,
                'body' => $body,
                'data' => $data
            ]);

            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            Log::info('FcmService: Mensaje creado, enviando a Firebase');

            $result = $this->messaging->send($message);

            Log::info('FcmService: Notificación enviada exitosamente', [
                'result' => $result
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('FcmService: Error al enviar notificación', [
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function sendNotificationToTokens(array $fcmTokens, $title, $body, $data = []): array
    {
        $results = [];

        foreach ($fcmTokens as $fcmToken) {
            try {
                $result = $this->sendNotification($fcmToken, $title, $body, $data);

                $results[] = [
                    'token' => $fcmToken,
                    'success' => true,
                    'result' => $result,
                    'remove_token' => false,
                ];
            } catch (\Throwable $e) {
                $removeToken = $this->shouldRemoveTokenFromException($e);

                Log::warning('FcmService: Error en token individual', [
                    'fcm_token_preview' => substr($fcmToken, 0, 20) . '...',
                    'error' => $e->getMessage(),
                    'error_class' => get_class($e),
                    'remove_token' => $removeToken,
                ]);

                $results[] = [
                    'token' => $fcmToken,
                    'success' => false,
                    'error' => $e->getMessage(),
                    'error_class' => get_class($e),
                    'remove_token' => $removeToken,
                ];
            }
        }

        return $results;
    }

    private function shouldRemoveTokenFromException(\Throwable $e): bool
    {
        $message = strtolower($e->getMessage());

        if (str_contains($message, 'invalid registration token') ||
            str_contains($message, 'not registered') ||
            str_contains($message, 'requested entity was not found') ||
            str_contains($message, 'unregistered') ||
            str_contains($message, 'registration token is not a valid fcm registration token')) {
            return true;
        }

        return false;
    }
} 