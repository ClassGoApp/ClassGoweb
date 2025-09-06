<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Iniciar autenticación con Google para móvil
     * 
     * @return JsonResponse
     */
    public function getGoogleAuthUrl(): JsonResponse
    {
        try {
            if (empty(setting('_api.enable_social_login'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'El login social no está habilitado'
                ], 403);
            }

            // Para móvil, necesitamos una URL personalizada
            $redirectUri = config('app.url') . '/api/auth/google/callback';
            
            $authUrl = Socialite::driver('google')
                ->redirectUrl($redirectUri)
                ->stateless()
                ->getTargetUrl();

            return response()->json([
                'success' => true,
                'auth_url' => $authUrl,
                'redirect_uri' => $redirectUri
            ]);

        } catch (Exception $e) {
            Log::error('Error al generar URL de autenticación Google', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al generar URL de autenticación'
            ], 500);
        }
    }

    /**
     * Callback para autenticación con Google desde móvil
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function handleGoogleCallback(Request $request): JsonResponse
    {
        try {
            if (empty(setting('_api.enable_social_login'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'El login social no está habilitado'
                ], 403);
            }

            // Obtener el código de autorización
            $code = $request->input('code');
            if (!$code) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código de autorización no proporcionado'
                ], 400);
            }

            // Intercambiar código por token
            $socialUser = Socialite::driver('google')
                ->redirectUrl(config('app.url') . '/api/auth/google/callback')
                ->stateless()
                ->user();

            // Buscar o crear usuario
            $user = $this->findOrCreateUser($socialUser);

            // Crear token de acceso para la API
            $token = $user->createToken('mobile-app')->plainTextToken;

            // Verificar si necesita completar perfil
            $profile = (new ProfileService($user->id))->getUserProfile();
            $needsProfileCompletion = empty($profile);

            return response()->json([
                'success' => true,
                'message' => 'Autenticación exitosa',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'provider' => $user->provider,
                        'provider_id' => $user->provider_id,
                        'role' => $user->roles()->first()?->name ?? 'student',
                        'needs_profile_completion' => $needsProfileCompletion
                    ],
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Error en callback de Google Auth', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error en la autenticación con Google'
            ], 500);
        }
    }

    /**
     * Buscar usuario existente o crear uno nuevo
     * 
     * @param object $socialUser
     * @return User
     */
    private function findOrCreateUser($socialUser): User
    {
        // Buscar usuario por provider_id
        $user = User::where('provider_id', $socialUser->getId())
            ->where('provider', 'google')
            ->first();

        if (!$user) {
            // Buscar usuario existente por email
            $existingUser = User::where('email', $socialUser->getEmail())->first();

            if ($existingUser) {
                // Actualizar usuario existente con datos del provider
                $existingUser->update([
                    'provider' => 'google',
                    'provider_id' => $socialUser->getId(),
                ]);
                $user = $existingUser;
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider' => 'google',
                    'provider_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(20)),
                    'email_verified_at' => now(),
                    'status' => 0,
                ]);
            }
        }

        return $user;
    }

    /**
     * Desconectar cuenta de Google
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function disconnectGoogle(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            
            $user->update([
                'provider' => null,
                'provider_id' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cuenta de Google desconectada exitosamente'
            ]);

        } catch (Exception $e) {
            Log::error('Error al desconectar Google', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al desconectar la cuenta de Google'
            ], 500);
        }
    }
}

