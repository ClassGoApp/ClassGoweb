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

    public function getPrerequisitesAuthUrl()
{
    try {
        $credentials = $this->clientCredentials;

        /*
         * Cambiamos solamente la ruta de retorno para el modal.
         * No modifica el callback anterior.
         */
        $credentials['redirect_uri'] = route(
            'google.prerequisites.callback'
        );

        $client = new Client($credentials);

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return [
            'status' => Response::HTTP_OK,
            'url' => $client->createAuthUrl(),
        ];
    } catch (Exception $ex) {
        Log::error(
            'Error al generar URL de Google Calendar para prerrequisitos',
            [
                'message' => $ex->getMessage(),
            ]
        );

        return [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $ex->getMessage(),
        ];
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

    public function getPrerequisitesAccessTokenInfo($code)
{
    if (empty($code) || !is_string($code)) {
        return [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => 'Código de autorización inválido o vacío',
        ];
    }

    try {
        $credentials = $this->clientCredentials;

        $credentials['redirect_uri'] = route(
            'google.prerequisites.callback'
        );

        $client = new Client($credentials);

        $tokenInfo = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($tokenInfo['error'])) {
            return [
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $tokenInfo['error_description']
                    ?? $tokenInfo['error'],
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'data' => $tokenInfo,
        ];
    } catch (\Exception $e) {
        Log::error(
            'Error al obtener token para prerrequisitos',
            [
                'message' => $e->getMessage(),
            ]
        );

        return [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
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
