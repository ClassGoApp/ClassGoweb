<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleCalender;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    /**
     * Obtener URL de autenticación para Google Calendar
     * 
     * @return JsonResponse
     */
    public function getAuthUrl(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            // Crear servicio con URL específica para móvil
            $googleCalendarService = new GoogleCalender($user);
            
            // Sobrescribir la redirect_uri para móvil
            $clientCredentials = [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => 'https://www.classgoapp.com/api/google-calendar/callback', // URL específica para móvil
                'scopes' => [\Google\Service\Calendar::CALENDAR]
            ];
            
            $client = new \Google\Client($clientCredentials);
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            
            // Incluir user_id en el state para el callback
            $state = base64_encode($user->id);
            $client->setState($state);
            
            $authUrl = $client->createAuthUrl();
            
            return response()->json([
                'success' => true,
                'auth_url' => $authUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener URL de autenticación Google Calendar', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    /**
     * Callback público para Google Calendar (sin autenticación)
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    
    public function handleCallback(Request $request)
    {
        try {
            $code = $request->input('code');
            $error = $request->input('error');
            $state = $request->input('state');

            $isMobile = !empty($state);
            
            // 1. Verificar si hay error (usuario canceló)
            if ($error) {
                Log::warning('Usuario canceló la conexión con Google Calendar', [
                    'error' => $error,
                    'error_description' => $request->input('error_description'),
                    'is_mobile' => $isMobile
                ]);

                return redirect()->route('profile.edit')
                    ->with('error', __('passwords.google_calendar_cancelled'));
            }
            
            // 2. Verificar si hay código
            if (empty($code)) {
                Log::error('Código de autorización no proporcionado en callback', [
                    'is_mobile' => $isMobile,
                    'has_state' => !empty($state)
                ]);
                
                return redirect()->route('profile.edit')
                    ->with('error', __('passwords.google_calendar_no_code'));
            }
            
            // 3. Validar que el código sea una cadena válida
            if (!is_string($code) || strlen($code) < 10) {
                Log::error('Código de autorización inválido', [
                    'code_type' => gettype($code),
                    'code_length' => is_string($code) ? strlen($code) : 0
                ]);
                
                return redirect()->route('profile.edit')
                    ->with('error', __('passwords.google_calendar_invalid_code'));
            }
            
            Log::info('Google Calendar callback recibido', [
                'code_length' => strlen($code),
                'state' => $state,
                'is_mobile' => $isMobile
            ]);
            
            // 4. Si hay un state (user_id), procesar el token
            if ($state) {
                try {
                    $userId = base64_decode($state);
                    
                    if (!$userId || !is_numeric($userId)) {
                        Log::error('State inválido en callback', [
                            'state' => $state,
                            'decoded' => $userId
                        ]);
                        return redirect()->route('profile.edit')
                            ->with('error', 'Estado de autorización inválido');
                    }
                    
                    $user = \App\Models\User::find($userId);
                    
                    if (!$user) {
                        Log::error('Usuario no encontrado en callback', [
                            'user_id' => $userId
                        ]);
                        return redirect()->route('profile.edit')
                            ->with('error', 'Usuario no encontrado');
                    }
                    
                    // Crear instancia del servicio con el usuario
                    $googleCalendarService = new \App\Services\GoogleCalender();
                    $googleCalendarService->setUser($user);
                    
                    // Obtener el token usando el servicio
                    $tokenResponse = $googleCalendarService->getAccessTokenInfo($code);
                    
                    // Verificar si hubo error en el servicio
                    if ($tokenResponse['status'] !== Response::HTTP_OK) {
                        Log::error('Error al obtener token desde el servicio', [
                            'status' => $tokenResponse['status'],
                            'message' => $tokenResponse['message'],
                            'user_id' => $userId
                        ]);
                        
                        return redirect()->route('profile.edit')
                            ->with('error', $tokenResponse['message'] ?? 'Error al obtener token de Google');
                    }
                    
                    $tokenInfo = $tokenResponse['data'];
                    
                    // Guardar token
                    $userService = new \App\Services\UserService($user);
                    $userService->setAccountSetting('google_access_token', $tokenInfo);
                    
                    // Obtener información del calendario
                    $clientCredentials = [
                        'client_id' => config('services.google.client_id'),
                        'client_secret' => config('services.google.client_secret'),
                        'redirect_uri' => config('services.callback.url'),
                        'scopes' => [\Google\Service\Calendar::CALENDAR]
                    ];
                    
                    $client = new \Google\Client($clientCredentials);
                    $client->setAccessToken($tokenInfo);
                    $service = new \Google\Service\Calendar($client);
                    
                    try {
                        $calendar = $service->calendarList->get('primary');
                        
                        $calendarInfo = [
                            'id' => $calendar->getId(),
                            'summary' => $calendar->getSummary(),
                            'minutes' => 30
                        ];
                        
                        $userService->setAccountSetting('google_calendar_info', $calendarInfo);
                        
                        Log::info('Google Calendar conectado exitosamente', [
                            'user_id' => $userId,
                            'calendar_id' => $calendar->getId()
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('Error al obtener información del calendario', [
                            'error' => $e->getMessage(),
                            'user_id' => $userId
                        ]);
                    }
                    
                    return redirect()->route('profile.edit')
                        ->with('success', __('passwords.connect_calender'));
                    
                } catch (\Exception $e) {
                    Log::error('Error al procesar token en callback', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'state' => $state
                    ]);
                    return redirect()->route('profile.edit')
                        ->with('error', 'Error al procesar la conexión');
                }
            }
            
            // Si no hay state, redirigir a perfil
            return redirect()->route('profile.edit')
                ->with('info', 'Código recibido, complete la configuración');
            
        } catch (\Exception $e) {
            Log::error('Error en handleCallback de Google Calendar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('profile.edit')
                ->with('error', 'Error del servidor al conectar Google Calendar');
        }
    }

    /**
     * Callback para conectar Google Calendar desde móvil
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function connectCalendar(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $code = $request->input('code');
            
            if (!$code) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código de autorización no proporcionado'
                ], 400);
            }

            // Usar la misma configuración que en getAuthUrl
            $clientCredentials = [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => 'https://www.classgoapp.com/api/google-calendar/callback',
                'scopes' => [\Google\Service\Calendar::CALENDAR]
            ];
            
            $client = new \Google\Client($clientCredentials);
            $tokenInfo = $client->fetchAccessTokenWithAuthCode($code);
            
            // Guardar token en account settings
            $userService = new UserService($user);
            $userService->setAccountSetting('google_access_token', $tokenInfo);
            
            // Obtener información del calendario primario
            $client->setAccessToken($tokenInfo);
            $service = new \Google\Service\Calendar($client);
            $calendar = $service->calendarList->get('primary');
            
            $calendarInfo = [
                'id' => $calendar->getId(),
                'summary' => $calendar->getSummary(),
                'minutes' => 30 // Valor por defecto
            ];
            
            $userService->setAccountSetting('google_calendar_info', $calendarInfo);

            return response()->json([
                'success' => true,
                'message' => 'Google Calendar conectado exitosamente',
                'data' => [
                    'calendar_info' => $calendarInfo,
                    'connected' => true
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al conectar Google Calendar', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al conectar Google Calendar'
            ], 500);
        }
    }

    /**
     * Verificar estado de conexión con Google Calendar
     * 
     * @return JsonResponse
     */
    public function getConnectionStatus(): JsonResponse
    {
        try {
            $user = Auth::user();
            $userService = new UserService($user);
            $accountSettings = $userService->getAccountSetting();
            
            $isConnected = !empty($accountSettings['google_access_token']);
            $calendarInfo = $accountSettings['google_calendar_info'] ?? null;
            
            return response()->json([
                'success' => true,
                'data' => [
                    'connected' => $isConnected,
                    'calendar_info' => $calendarInfo,
                    'has_valid_token' => $isConnected && !empty($accountSettings['google_access_token']['access_token'])
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al verificar estado de Google Calendar', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al verificar estado de conexión'
            ], 500);
        }
    }

    /**
     * Crear evento en Google Calendar
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function createEvent(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'timezone' => 'nullable|string|default:UTC'
            ]);

            $user = Auth::user();
            $googleCalendarService = new GoogleCalender($user);
            
            $eventData = [
                'title' => $request->title,
                'description' => $request->description ?? '',
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'timezone' => $request->timezone ?? 'UTC'
            ];

            $result = $googleCalendarService->createEvent($eventData);
            
            if ($result['status'] === 200) {
                return response()->json([
                    'success' => true,
                    'message' => 'Evento creado exitosamente',
                    'data' => [
                        'event_id' => $result['data']->getId(),
                        'event_link' => $result['data']->getHtmlLink(),
                        'start_time' => $result['data']->getStart()->getDateTime(),
                        'end_time' => $result['data']->getEnd()->getDateTime()
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Error al crear evento'
                ], $result['status']);
            }

        } catch (\Exception $e) {
            Log::error('Error al crear evento en Google Calendar', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al crear evento'
            ], 500);
        }
    }

    /**
     * Eliminar evento de Google Calendar
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteEvent(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'event_id' => 'required|string'
            ]);

            $user = Auth::user();
            $googleCalendarService = new GoogleCalender($user);
            
            $result = $googleCalendarService->deleteEvent($request->event_id);
            
            if ($result['status'] === 200) {
                return response()->json([
                    'success' => true,
                    'message' => 'Evento eliminado exitosamente'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Error al eliminar evento'
                ], $result['status']);
            }

        } catch (\Exception $e) {
            Log::error('Error al eliminar evento de Google Calendar', [
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar evento'
            ], 500);
        }
    }

    /**
     * Desconectar Google Calendar
     * 
     * @return JsonResponse
     */
    public function disconnect(): JsonResponse
    {
        try {
            $user = Auth::user();
            $userService = new UserService($user);
            
            // Eliminar tokens y configuración
            $userService->setAccountSetting('google_access_token', null);
            $userService->setAccountSetting('google_calendar_info', null);

            return response()->json([
                'success' => true,
                'message' => 'Google Calendar desconectado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al desconectar Google Calendar', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al desconectar Google Calendar'
            ], 500);
        }
    }
}

