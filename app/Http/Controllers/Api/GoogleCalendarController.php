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
            // ===== LOGS DE DEBUG TEMPORAL =====
            Log::emergency('🔴 CALLBACK COMPLETO', [
                'url' => $request->fullUrl(),
                'todos_params' => $request->all(),
                'tiene_code' => $request->has('code'),
                'tiene_error' => $request->has('error'),
                'valor_code' => $request->input('code'),
                'valor_error' => $request->input('error'),
            ]);

            $code = $request->input('code');
            $error = $request->input('error');
            $state = $request->input('state');
            
            // Determinar si es móvil o web basado en el state
            $isMobile = !empty($state);

            // VALIDAR ERROR PRIMERO (usuario canceló)
            if ($error || $request->has('error')) {
                Log::warning('🔴 Usuario CANCELÓ la conexión', [
                    'error' => $error,
                    'error_description' => $request->input('error_description'),
                    'state' => $state,
                    'is_mobile' => $isMobile
                ]);
                
                // Si hay state, limpiar cualquier token anterior
                if ($state) {
                    try {
                        $userId = base64_decode($state);
                        if ($userId && is_numeric($userId)) {
                            $user = \App\Models\User::find($userId);
                            if ($user) {
                                $userService = new \App\Services\UserService($user);
                                $userService->setAccountSetting('google_access_token', null);
                                $userService->setAccountSetting('google_calendar_info', null);
                                
                                Log::info('🧹 Tokens limpiados tras cancelación', [
                                    'user_id' => $userId
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Error al limpiar tokens', ['error' => $e->getMessage()]);
                    }
                }
                
                // Redirigir según el origen
                if ($isMobile) {
                    // Para móvil: deep link
                    return redirect('https://classgoapp.com/calendar-error?error=' . urlencode($error) . '&cancelled=true');
                } else {
                    // Para web: configuración de perfil
                    return redirect()->route('profile.edit')
                        ->with('error', __('passwords.google_calendar_cancelled'));
                }
            }
            
            // VALIDAR CÓDIGO VACÍO
            if (empty($code) || !$code) {
                Log::error('🔴 Código vacío o no proporcionado', [
                    'has_code' => $request->has('code'),
                    'code_value' => $code,
                    'state' => $state,
                    'is_mobile' => $isMobile
                ]);
                
                // También limpiar tokens si hay state
                if ($state) {
                    try {
                        $userId = base64_decode($state);
                        if ($userId && is_numeric($userId)) {
                            $user = \App\Models\User::find($userId);
                            if ($user) {
                                $userService = new \App\Services\UserService($user);
                                $userService->setAccountSetting('google_access_token', null);
                                $userService->setAccountSetting('google_calendar_info', null);
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Error al limpiar tokens por código vacío', ['error' => $e->getMessage()]);
                    }
                }
                
                // Redirigir según el origen
                if ($isMobile) {
                    return redirect('https://classgoapp.com/calendar-error?error=no_code');
                } else {
                    return redirect()->route('profile.edit')
                        ->with('error', __('passwords.google_calendar_no_code'));
                }
            }
            
            // Log para debugging
            Log::info('✅ Google Calendar callback VÁLIDO recibido', [
                'code_length' => strlen($code),
                'state' => $state,
                'is_mobile' => $isMobile
            ]);
            
            // Si hay un state (user_id), procesar el token directamente
            if ($state) {
                try {
                    $userId = base64_decode($state);
                    
                    if ($userId && is_numeric($userId)) {
                        $user = \App\Models\User::find($userId);
                        
                        if ($user) {
                            Log::info('🔷 Procesando token para usuario', [
                                'user_id' => $userId
                            ]);
                            
                            // Procesar el token
                            $clientCredentials = [  
                                'client_id' => config('services.google.client_id'),
                                'client_secret' => config('services.google.client_secret'),
                                'redirect_uri' => 'https://www.classgoapp.com/api/google-calendar/callback',
                                'scopes' => [\Google\Service\Calendar::CALENDAR]
                            ];
                            
                            $client = new \Google\Client($clientCredentials);
                            
                            try {
                                $tokenInfo = $client->fetchAccessTokenWithAuthCode($code);
                                
                                if (!empty($tokenInfo['error'])) {
                                    Log::error('❌ Error al obtener token de Google', [
                                        'error' => $tokenInfo['error'],
                                        'user_id' => $userId
                                    ]);
                                    
                                    if ($isMobile) {
                                        return redirect('https://classgoapp.com/calendar-error?error=token_error');
                                    } else {
                                        return redirect()->route('profile.edit')
                                            ->with('error', __('passwords.google_calendar_token_error'));
                                    }
                                }
                                
                                Log::info('💾 Token obtenido, guardando...', [
                                    'user_id' => $userId,
                                    'has_access_token' => isset($tokenInfo['access_token'])
                                ]);
                                
                                // Guardar token en account settings
                                $userService = new \App\Services\UserService($user);
                                $userService->setAccountSetting('google_access_token', $tokenInfo);
                                
                                // Obtener información del calendario primario
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
                                    'calendar_id' => $calendar->getId()
                                ]);
                                
                                // Redirigir según el origen
                                if ($isMobile) {
                                    return redirect('https://classgoapp.com/calendar-success?connected=true');
                                } else {
                                    return redirect()->route('profile.edit')
                                        ->with('success', __('passwords.connect_calender'));
                                }
                                
                            } catch (\Exception $tokenException) {
                                Log::error('💥 Excepción al obtener token', [
                                    'error' => $tokenException->getMessage(),
                                    'user_id' => $userId
                                ]);
                                
                                if ($isMobile) {
                                    return redirect('https://classgoapp.com/calendar-error?error=token_exception');
                                } else {
                                    return redirect()->route('profile.edit')
                                        ->with('error', 'Error al obtener token de Google Calendar');
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('💥 Error al procesar token en callback', [
                        'error' => $e->getMessage(),
                        'state' => $state,
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    if ($isMobile) {
                        return redirect('https://classgoapp.com/calendar-error?error=processing_error');
                    } else {
                        return redirect()->route('profile.edit')
                            ->with('error', 'Error al procesar la conexión con Google Calendar');
                    }
                }
            }
            
            // Si no hay state, es desde web - redirigir a perfil
            Log::warning('⚠️ Callback sin state válido (posiblemente desde web)', [
                'has_state' => !empty($state),
                'code_length' => strlen($code)
            ]);
            
            return redirect()->route('profile.edit')
                ->with('info', 'Código recibido, complete la configuración');
            
        } catch (\Exception $e) {
            Log::error('💥 Error en handleCallback de Google Calendar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Intentar determinar si es móvil
            $isMobile = !empty($request->input('state'));
            
            if ($isMobile) {
                return redirect('https://classgoapp.com/calendar-error?error=server_error');
            } else {
                return redirect()->route('profile.edit')
                    ->with('error', 'Error del servidor al conectar Google Calendar');
            }
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

