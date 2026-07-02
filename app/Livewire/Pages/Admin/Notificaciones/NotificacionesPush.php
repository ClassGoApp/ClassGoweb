<?php

namespace App\Livewire\Pages\Admin\Notificaciones;

use Livewire\Component;
use App\Http\Controllers\Api\NotificacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificacionesPush extends Component
{
    // General Notification Fields
    public $title = '';
    public $body = '';
    public $type = 'general';
    public $screen = 'feed';
    public $customData = ''; // JSON string or text

    // Targets for Massive Send
    public $targetType = 'all'; // all, tutor, estudiante

    // Targets for Specific Send
    public $specificTokens = ''; // Comma-separated or JSON list of tokens

    // Response Tracking
    public $apiResponse = null;
    public $errorMessage = null;

    public function sendMassive()
    {
        $this->resetResponses();

        $this->validate([
            'title' => 'required|string|min:3',
            'body' => 'required|string|min:5',
            'targetType' => 'required|string',
        ]);

        try {
            $controller = app(NotificacionController::class);
            
            $dataArray = [];
            if (!empty($this->customData)) {
                $decoded = json_decode($this->customData, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $dataArray = $decoded;
                } else {
                    $dataArray = ['message' => $this->customData];
                }
            }

            $request = new Request([
                'title' => $this->title,
                'body' => $this->body,
                'type' => $this->targetType,
                'screen' => $this->screen,
                'data' => $dataArray
            ]);

            $response = $controller->enviarNotificacionMasiva($request);
            $responseData = json_decode($response->getContent(), true);

            if ($response->getStatusCode() === 200 && ($responseData['ok'] ?? false)) {
                $this->apiResponse = $responseData;
                session()->flash('success', '¡Notificación masiva procesada correctamente!');
            } else {
                $this->errorMessage = $responseData['message'] ?? 'Error desconocido al enviar notificación.';
                if (isset($responseData['error'])) {
                    $this->errorMessage .= ' Detalle: ' . $responseData['error'];
                }
            }

        } catch (\Exception $e) {
            Log::error('Admin Push Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    public function sendSpecific()
    {
        $this->resetResponses();

        $this->validate([
            'title' => 'required|string|min:3',
            'body' => 'required|string|min:5',
            'specificTokens' => 'required|string',
        ]);

        try {
            $controller = app(NotificacionController::class);

            // Clean up tokens
            $tokens = array_filter(array_map('trim', explode(',', $this->specificTokens)));

            if (empty($tokens)) {
                $this->errorMessage = 'Por favor ingresa al menos un token FCM válido.';
                return;
            }

            $dataArray = [];
            if (!empty($this->customData)) {
                $decoded = json_decode($this->customData, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $dataArray = $decoded;
                } else {
                    $dataArray = ['message' => $this->customData];
                }
            }

            $request = new Request([
                'title' => $this->title,
                'body' => $this->body,
                'tokens' => $tokens,
                'type' => $this->type,
                'screen' => $this->screen,
                'data' => $dataArray
            ]);

            $response = $controller->enviarNotificacionGenerica($request);
            $responseData = json_decode($response->getContent(), true);

            if ($response->getStatusCode() === 200 && ($responseData['ok'] ?? false)) {
                $this->apiResponse = $responseData;
                session()->flash('success', '¡Notificación directa enviada correctamente!');
            } else {
                $this->errorMessage = $responseData['message'] ?? 'Error al enviar la notificación directa.';
                if (isset($responseData['error'])) {
                    $this->errorMessage .= ' Detalle: ' . $responseData['error'];
                }
            }

        } catch (\Exception $e) {
            Log::error('Admin Specific Push Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->errorMessage = 'Error: ' . $e->getMessage();
        }
    }

    private function resetResponses()
    {
        $this->apiResponse = null;
        $this->errorMessage = null;
    }

    public function render()
    {
        // Get user counts with FCM tokens for reference
        $totalUsersWithToken = DB::table('fcm_tokens')
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        $tutorsWithToken = DB::table('fcm_tokens')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'fcm_tokens.user_id')
            ->where('model_has_roles.role_id', 2)
            ->distinct('fcm_tokens.user_id')
            ->count('fcm_tokens.user_id');

        $studentsWithToken = DB::table('fcm_tokens')
            ->join('model_has_roles', 'fcm_tokens.user_id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)
            ->distinct('fcm_tokens.user_id')
            ->count('fcm_tokens.user_id');
        
        $guestsWithToken = DB::table('fcm_tokens')
            ->whereNull('user_id')
            ->count('id');

        return view('livewire.pages.admin.notificaciones.notificaciones-push', [
            'totalUsersWithToken' => $totalUsersWithToken,
            'tutorsWithToken' => $tutorsWithToken,
            'studentsWithToken' => $studentsWithToken,
            'guestsWithToken' => $guestsWithToken,
        ])->layout('layouts.admin-app');
    }
}
