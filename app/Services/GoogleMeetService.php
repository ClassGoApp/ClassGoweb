<?php


namespace App\Services;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use App\Models\User;
use App\Models\AccountSetting;
use Carbon\Carbon;
use Exception; 

use Illuminate\Support\Facades\Log;


class GoogleMeetService
{



    public function createMeeting($meetingData)
    {
        /* $validated = $meetingData->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
        ]); */
        //dd('prueba');
        $title = $meetingData['title'] ?? 'Tutoría';
        $description = $meetingData['description'] ?? 'Sesión de tutoría';
        $start_date_time = $meetingData['start_time'] ?? now()->addMinutes(10)->format('Y-m-d H:i:s');
        $end_date_time = $meetingData['end_time'] ?? now()->addMinutes(40)->format('Y-m-d H:i:s');
        $timezone = $meetingData['timezone'] ?? 'UTC';


        $client = new Google_Client();
        $client->setAuthConfig(base_path('app/credentials/credential.json'));
        $client->setAccessToken([
            'access_token' => env('GOOGLE_ADMIN_ACCESS_TOKEN'),
            'refresh_token' => env('GOOGLE_ADMIN_REFRESH_TOKEN'),
        ]);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken(env('GOOGLE_ADMIN_REFRESH_TOKEN'));
        }

        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $title,
            'description' => $description,
            'start' => [
                'dateTime' => Carbon::parse($start_date_time)->toRfc3339String(),
                'timeZone' => 'UTC',
            ],
            'end' => [
                'dateTime' => Carbon::parse($end_date_time)->toRfc3339String(),
                'timeZone' => $timezone,
            ],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'random-string',
                ],
            ],
        ]);

        $calendarId = 'primary';

        $event = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);
        return $event->getHangoutLink();
    }




    /**
     * Crea una reunión de Google Meet en el calendario del usuario especificado.
     *
     * @param array $meetingData Datos de la reunión (title, description, start_time, etc.)
     * @param \App\Models\User $user El usuario (tutor) para quien se crea la reunión.
     * @return string|null El enlace a la reunión de Google Meet, o null si falla.
     */
    // public function createMeetingPorTutor(array $meetingData, User $user): ?string
    // {
    //     // --- PASO 1: Validar que el usuario tenga tokens ---
    //     if (empty($user->google_token) || empty($user->google_refresh_token)) {
    //         // Lanza una excepción o maneja el error como prefieras.
    //         // El usuario no ha conectado su cuenta de Google o no tiene refresh token.
    //         throw new Exception('El usuario no tiene los tokens de Google necesarios.');
    //     }

    //     // --- PASO 2: Configurar el cliente de Google con las credenciales de la app ---
    //     $client = new Google_Client();
    //     // Usamos las credenciales de la app (client_id, client_secret) que están en config/services.php
    //     $client->setClientId(config('services.google.client_id'));
    //     $client->setClientSecret(config('services.google.client_secret'));
    //     $client->setRedirectUri(config('services.google.redirect'));

    //     // --- PASO 3: Establecer los tokens específicos del usuario ---
    //     $client->setAccessToken($user->google_token);

    //     // --- PASO 4: Refrescar el token si ha expirado Y GUARDAR EL NUEVO ---
    //     if ($client->isAccessTokenExpired()) {
    //         $newAccessToken = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);

    //         // ¡CRUCIAL! Actualiza el usuario en la base de datos con el nuevo token.
    //         $user->update([
    //             'google_token' => $newAccessToken['access_token'],
    //             'google_token_expires_at' => now()->addSeconds($newAccessToken['expires_in']),
    //             // El refresh token a veces cambia, es bueno re-guardarlo si viene en la respuesta.
    //             'google_refresh_token' => $newAccessToken['refresh_token'] ?? $user->google_refresh_token,
    //         ]);
    //     }

    //     // --- PASO 5: Crear el evento (tu lógica original) ---
    //     $service = new Google_Service_Calendar($client);

    //     $event = new Google_Service_Calendar_Event([
    //         'summary' => $meetingData['title'] ?? 'Tutoría ClassGo',
    //         'description' => $meetingData['description'] ?? 'Sesión de tutoría programada a través de ClassGo.',
    //         'start' => [
    //             'dateTime' => Carbon::parse($meetingData['start_time'])->toRfc3339String(),
    //             'timeZone' => $meetingData['timezone'] ?? 'UTC',
    //         ],
    //         'end' => [
    //             'dateTime' => Carbon::parse($meetingData['end_time'])->toRfc3339String(),
    //             'timeZone' => $meetingData['timezone'] ?? 'UTC',
    //         ],
    //         'conferenceData' => [
    //             'createRequest' => [
    //                 'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
    //                 'requestId' => 'classgo-' . uniqid(), // Un ID único para la solicitud
    //             ],
    //         ],
    //     ]);

    //     $calendarId = 'primary';
    //     $createdEvent = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

    //     return $createdEvent->getHangoutLink();
    // }




    /**
     * Crea una reunión de Google Meet en el calendario del usuario especificado.
     *
     * @param array $meetingData Datos de la reunión (title, description, start_time, etc.)
     * @param \App\Models\User $user El usuario (tutor) para quien se crea la reunión.
     * @return string|null El enlace a la reunión de Google Meet, o null si falla.
     */
    public function createMeetingPorTutord(array $meetingData, User $user): ?string
    {
        $client = $this->getAuthenticatedClientForUser($user);

        // --- PASO 5: Crear el evento (tu lógica original) ---
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $meetingData['title'] ?? 'Tutoría ClassGo',
            'description' => $meetingData['description'] ?? 'Sesión de tutoría programada a través de ClassGo.',
            'start' => [
                'dateTime' => Carbon::parse($meetingData['start_time'])->toRfc3339String(),
                'timeZone' => $meetingData['timezone'] ?? 'UTC',
            ],
            'end' => [
                'dateTime' => Carbon::parse($meetingData['end_time'])->toRfc3339String(),
                'timeZone' => $meetingData['timezone'] ?? 'UTC',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'classgo-' . uniqid(), // Un ID único para la solicitud
                ],
            ],
        ]);

        $calendarId = 'primary';
        $createdEvent = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        return $createdEvent->getHangoutLink();
    }

    /**
     * Obtiene un Google_Client autenticado para el usuario, refrescando el token si expiró
     * y preservando siempre el refresh_token. Marca reconexión solo ante invalid_grant.
     */
    public function getAuthenticatedClientForUser(User $user, bool $forceRefresh = false): Google_Client
    {
        $tokenSetting = AccountSetting::where('user_id', $user->id)
            ->where('meta_key', 'google_access_token')
            ->first();

        if (!$tokenSetting || empty($tokenSetting->meta_value)) {
            throw new Exception('El usuario no tiene los tokens de Google necesarios.');
        }

        $metaValue = is_string($tokenSetting->meta_value)
            ? json_decode($tokenSetting->meta_value, true)
            : $tokenSetting->meta_value;

        $tokenData = (is_array($metaValue) && isset($metaValue['data'])) ? $metaValue['data'] : $metaValue;

        if (!is_array($tokenData) || empty($tokenData['refresh_token'])) {
            Log::error('Refresh token missing after extraction', ['user_id' => $user->id]);
            throw new Exception('El usuario no tiene los tokens de Google necesarios o falta el refresh token.');
        }

        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setAccessToken($tokenData);

        if ($forceRefresh || $client->isAccessTokenExpired()) {
            $newAccessToken = $client->fetchAccessTokenWithRefreshToken($tokenData['refresh_token']);

            if (!is_array($newAccessToken) || isset($newAccessToken['error'])) {
                $errorCode = is_array($newAccessToken) ? ($newAccessToken['error'] ?? 'unknown_error') : 'invalid_response';

                // Solo marcar reconexión si Google confirma definitivamente que el token fue revocado/caducado
                if ($errorCode === 'invalid_grant') {
                    AccountSetting::updateOrCreate(
                        ['user_id' => $user->id, 'meta_key' => 'google_calendar_needs_reconnect'],
                        ['meta_value' => [
                            'needs_reconnect' => true,
                            'reason' => 'invalid_grant',
                            'detected_at' => now()->toIso8601String(),
                        ]]
                    );
                }

                throw new Exception('Error al refrescar el token de Google: ' . $errorCode);
            }

            // Conservar siempre el refresh_token anterior si Google no lo reenvía
            $newAccessToken['refresh_token'] = $newAccessToken['refresh_token'] ?? $tokenData['refresh_token'];

            $tokenSetting->meta_value = $newAccessToken;
            $tokenSetting->save();

            // Limpiar bandera de reconexión si el refresh funcionó
            AccountSetting::where('user_id', $user->id)
                ->where('meta_key', 'google_calendar_needs_reconnect')
                ->update(['meta_value' => null]);

            $client->setAccessToken($newAccessToken);
        }

        return $client;
    }





    public function createMeetingConCredencialesApi(array $meetingData): ?string
    {
        // Supongamos que obtienes el registro de la tabla account_settings
        $tokenSetting = AccountSetting::where('user_id', 1)
            ->where('meta_key', 'google_access_token')
            ->first();

        if (!$tokenSetting) {
            throw new \Exception('No se encontró el token.');
        }

        // Decodifica el JSON si es string
        if (is_string($tokenSetting->meta_value)) {
            $tokenData = json_decode($tokenSetting->meta_value, true);
        } else {
            $tokenData = $tokenSetting->meta_value;
        }

        if (empty($tokenData['refresh_token'])) {
            throw new \Exception('Falta el refresh token.');
        }

        $client = new \Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $client->setAccessToken($tokenData);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($tokenData['refresh_token']);
            $newAccessToken = $client->getAccessToken();
            // Opcional: guardar el nuevo token en la base de datos
            $tokenSetting->meta_value = $newAccessToken;
            $tokenSetting->save();
        }

        $service = new \Google_Service_Calendar($client);

        $event = new \Google_Service_Calendar_Event([
            'summary' => $meetingData['title'] ?? 'Tutoría ClassGo',
            'description' => $meetingData['description'] ?? 'Sesión de tutoría programada a través de ClassGo.',
            'start' => [
                'dateTime' => \Carbon\Carbon::parse($meetingData['start_time'])->toRfc3339String(),
                'timeZone' => $meetingData['timezone'] ?? 'UTC',
            ],
            'end' => [
                'dateTime' => \Carbon\Carbon::parse($meetingData['end_time'])->toRfc3339String(),
                'timeZone' => $meetingData['timezone'] ?? 'UTC',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                    'requestId' => 'classgo-' . uniqid(),
                ],
            ],
        ]);

        $calendarId = 'primary';
        $createdEvent = $service->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

        return $createdEvent->getHangoutLink();
    }
}