<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Exception as GoogleServiceException;
use Google_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class GoogleCalender
{

    protected $clientCredentials;
    protected $userAccountSettings = null;
    protected $userService;

    public function __construct($user = null)
    {

        //dd( config('services.callback.url')) ;
        $this->clientCredentials = [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.callback.url'),
            'scopes' => [Calendar::CALENDAR]
        ];
       // dd($this->clientCredentials);
       // $this->userService = new UserService($user);
       // $this->userAccountSettings = $this->userService->getAccountSetting();
        //dd($this->userAccountSettings, "aver que es esto");
    }

    /* public function getAuthUrl() {
        //dd('llega aca en el servicio');
        try {
            if (empty($this->clientCredentials['client_id']) || empty($this->clientCredentials['client_secret'])) {
                return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.keys_missing')];
            }        

            $client = new Client($this->clientCredentials);
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            $auth_url = $client->createAuthUrl();
            return ['status' => Response::HTTP_OK, 'url' => $auth_url];
        } catch (Exception $ex) {
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    } */



 
    public function setUser(User $user)
    {
        $this->user = $user;
        $this->userService = new UserService($this->user);
        $this->userAccountSettings = $this->userService->getAccountSetting();
        return $this; // Permite encadenar métodos: (new GoogleCalender())->setUser($user)->createEvent(...)
    }    


    public function getAuthUrl()
    {
        try {
            $client = new Client($this->clientCredentials);

            // La redirect_uri ya está configurada en el constructor a través de 
            // 'redirect_uri' => config('services.google.redirect_uri')
            // No es necesario establecerla aquí de nuevo.

            $client->setAccessType('offline');
            $client->setPrompt('consent');
            $auth_url = $client->createAuthUrl();
            //dd($auth_url);
            return ['status' => Response::HTTP_OK, 'url' => $auth_url];
        } catch (Exception $ex) {
            //dd('llega al catch', $ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    public function getAccessTokenInfo($code)
    {
        // Validar ANTES de intentar usar el código
        if (empty($code) || !is_string($code)) {
            Log::error('Código de autorización inválido', [
                'code_is_empty' => empty($code),
                'code_type' => gettype($code)
            ]);
            
            // En lugar de lanzar excepción, retornar error
            return [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Código de autorización inválido o vacío'
            ];
        }

        try {
            $client = new Client($this->clientCredentials);
            $tokenInfo = $client->fetchAccessTokenWithAuthCode($code);
            
            // Verificar si Google devolvió un error
            if (isset($tokenInfo['error'])) {
                Log::error('Error al obtener token de Google', [
                    'error' => $tokenInfo['error'],
                    'error_description' => $tokenInfo['error_description'] ?? 'Sin descripción'
                ]);
                
                return [
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => $tokenInfo['error_description'] ?? $tokenInfo['error']
                ];
            }
            
            return [
                'status' => Response::HTTP_OK,
                'data' => $tokenInfo
            ];
            
        } catch (\Exception $e) {
            Log::error('Excepción al obtener access token', [
                'message' => $e->getMessage(),
                'code_length' => !empty($code) ? strlen($code) : 0
            ]);
            
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function verifyToken()
    {
        $this->userService = new UserService($this->user);
        $this->userAccountSettings = $this->userService->getAccountSetting();
        $isTokenExpired = $this->isTokenExpired($this->userAccountSettings['google_access_token']);
        if ($isTokenExpired) {
            $this->userAccountSettings['google_access_token'] = $this->refreshAccessToken($this->userAccountSettings['google_access_token']['refresh_token']);
            $this->userService->setAccountSetting('google_access_token', $this->userAccountSettings['google_access_token']);
        }
    }

    public function refreshAccessToken($refreshToken)
    {
        $client = new Client($this->clientCredentials);
        return $client->fetchAccessTokenWithRefreshToken($refreshToken);
    }

    public function isTokenExpired($tokenArray)
    {
        $client = new Google_Client();
        $client->setAccessToken($tokenArray);
        return $client->isAccessTokenExpired();
    }

    public function getUserPrimaryCalendar($token)
    {
        try {
            $client = new Google_Client();
            $client->setAccessToken($token);
            $service = new Calendar($client);
            $primaryCalendar = array();
            $calendar = $service->calendars->get('primary');
            $primaryCalendar = [
                'id' => $calendar->getId(),
                'summary' => $calendar->getSummary(),
                'description' => $calendar->getDescription(),
                'timezone' => $calendar->getTimeZone(),
            ];
            return ['status' => Response::HTTP_OK, 'data' => $primaryCalendar];
        } catch (GoogleServiceException $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    public function updateCalendarNotificationSettings($minutes)
    {
        $this->userService = new UserService($this->user);
        $this->userAccountSettings = $this->userService->getAccountSetting();
        try {
            $this->verifyToken();
            $client = new Google_Client();
            $client->setAccessToken($this->userAccountSettings['google_access_token']);
            $service = new Calendar($client);
            $calendars = $service->calendarList->listCalendarList();
            $updatedCalendar = null;
            foreach ($calendars as $calendar) {
                if ($calendar->getPrimary()) {
                    if (!empty($minutes)) {
                        $calendar->setDefaultReminders([
                            ['method' => 'email', 'minutes' => $minutes],
                            ['method' => 'popup', 'minutes' => $minutes],
                        ]);
                    } else {
                        $calendar->setDefaultReminders([]);
                    }
                    $updatedCalendar = $service->calendarList->update($calendar->getId(), $calendar);
                    break;
                }
            }
            return ['status' => Response::HTTP_OK, 'data' => $updatedCalendar];
        } catch (GoogleServiceException $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }
    /**
     * Create Event Function
     * @param array $eventData[
     *      'title',
     *      'description',
     *      'start_time',
     *      'end_time',
     *      'timezone'
     * ]
     */
    public function createEvent($eventData)
    {

        $this->userService = new UserService($this->user);
        $this->userAccountSettings = $this->userService->getAccountSetting();
        try {
            if (!empty($this->userAccountSettings['google_calendar_info']['id'])) {
                $this->verifyToken();
                $client = new Google_Client();
                $client->setAccessToken($this->userAccountSettings['google_access_token']);
                $service = new Calendar($client);
                $event = new Event([
                    'summary' => $eventData['title'],
                    'description' => $eventData['description'],
                    'start' => [
                        'dateTime' => $eventData['start_time'],
                        'timeZone' => $eventData['timezone']
                    ],
                    'end' => [
                        'dateTime' => $eventData['end_time'],
                        'timeZone' => $eventData['timezone']
                    ]
                ]);
                $event = $service->events->insert($this->userAccountSettings['google_calendar_info']['id'], $event);
                return ['status' => Response::HTTP_OK, 'data' => $event];
            }
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.no_calendar')];
        } catch (Exception $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }

    /**
     * Delete Event
     * @param string $eventId
     */

    public function deleteEvent($eventId)
    {

        $this->userService = new UserService($this->user);
        $this->userAccountSettings = $this->userService->getAccountSetting();

        try {
            if (!empty($this->userAccountSettings['google_calendar_info']['id'])) {
                $this->verifyToken();
                $client = new Google_Client();
                $client->setAccessToken($this->userAccountSettings['google_access_token']);
                $service = new Calendar($client);
                $service->events->delete($this->userAccountSettings['google_calendar_info']['id'], $eventId);
                return ['status' => Response::HTTP_OK, 'message' => __('passwords.event_deleted')];
            }
            return ['status' => Response::HTTP_BAD_REQUEST, 'message' => __('passwords.no_calendar')];
        } catch (Exception $ex) {
            Log::info($ex);
            return ['status' => $ex->getCode(), 'message' => $ex->getMessage()];
        }
    }
}
if ($user) {
    Log::info('🔷 Procesando token para usuario', [
        'user_id' => $userId
    ]);
    
    // Crear instancia del servicio
    $googleCalendarService = new \App\Services\GoogleCalender();
    $googleCalendarService->setUser($user);
    
    Log::emergency('🔥 ANTES DE OBTENER TOKEN', [
        'user_id' => $userId,
        'code' => $code ? substr($code, 0, 20) . '...' : 'NULL',
        'code_is_empty' => empty($code),
        'code_length' => $code ? strlen($code) : 0
    ]);
    
    // Obtener el token usando el servicio (que tiene validación)
    $tokenResponse = $googleCalendarService->getAccessTokenInfo($code);
    
    Log::emergency('🔥 DESPUÉS DE OBTENER TOKEN', [
        'status' => $tokenResponse['status'] ?? 'sin status',
        'tiene_data' => isset($tokenResponse['data']),
        'tiene_message' => isset($tokenResponse['message']),
        'message' => $tokenResponse['message'] ?? 'sin mensaje'
    ]);
    
    // ⚠️ CRÍTICO: Verificar el status ANTES de continuar
    if ($tokenResponse['status'] !== \Symfony\Component\HttpFoundation\Response::HTTP_OK) {
        Log::error('❌ Error al obtener token desde el servicio', [
            'status' => $tokenResponse['status'],
            'message' => $tokenResponse['message'],
            'user_id' => $userId
        ]);
        
        // Limpiar cualquier token anterior
        $userService = new \App\Services\UserService($user);
        $userService->setAccountSetting('google_access_token', null);
        $userService->setAccountSetting('google_calendar_info', null);
        
        // NO continuar si hay error
        if ($isMobile) {
            return redirect('https://classgoapp.com/calendar-error?error=invalid_code');
        } else {
            return redirect()->route('profile.edit')
                ->with('error', $tokenResponse['message'] ?? 'Código de autorización inválido');
        }
    }
    
    // Solo continuar si status es OK
    $tokenInfo = $tokenResponse['data'];
    
    Log::info('💾 Token VÁLIDO obtenido, guardando...', [
        'user_id' => $userId,
        'has_access_token' => isset($tokenInfo['access_token']),
        'has_refresh_token' => isset($tokenInfo['refresh_token'])
    ]);
    
    // Guardar token en account settings
    $userService = new \App\Services\UserService($user);
    $userService->setAccountSetting('google_access_token', $tokenInfo);
    
    // Obtener información del calendario primario
    try {
        $clientCredentials = [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => 'https://www.classgoapp.com/api/google-calendar/callback',
            'scopes' => [\Google\Service\Calendar::CALENDAR]
        ];
        
        $client = new \Google\Client($clientCredentials);
        $client->setAccessToken($tokenInfo);
        $service = new \Google\Service\Calendar($client);
        $calendar = $service->calendarList->get('primary');
        
        $calendarInfo = [
            'id' => $calendar->getId(),
            'summary' => $calendar->getSummary(),
            'minutes' => 30
        ];
        
        $userService->setAccountSetting('google_calendar_info', $calendarInfo);
        
        Log::info('✅ Google Calendar conectado exitosamente', [
            'user_id' => $userId,
            'calendar_id' => $calendar->getId(),
            'calendar_name' => $calendar->getSummary()
        ]);
        
        // Redirigir según el origen
        if ($isMobile) {
            return redirect('https://classgoapp.com/calendar-success?connected=true');
        } else {
            return redirect()->route('profile.edit')
                ->with('success', __('passwords.connect_calender'));
        }
        
    } catch (\Exception $calendarException) {
        Log::error('💥 Error al obtener información del calendario', [
            'error' => $calendarException->getMessage(),
            'user_id' => $userId
        ]);
        
        // El token ya está guardado, solo falló obtener el calendario
        if ($isMobile) {
            return redirect('https://classgoapp.com/calendar-success?connected=true&partial=true');
        } else {
            return redirect()->route('profile.edit')
                ->with('warning', 'Conectado pero no se pudo obtener información del calendario');
        }
    }
}
