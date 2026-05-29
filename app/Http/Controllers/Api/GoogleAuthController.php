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
use Illuminate\Support\Facades\DB;
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
            // Usar URL específica que coincide con Google Cloud (con www)
            $redirectUri = 'https://www.classgoapp.com/api/auth/google/callback';

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
            // Usar URL específica que coincide con Google Cloud (con www)
            $redirectUri = 'https://www.classgoapp.com/api/auth/google/callback';

            // Log para debugging
            Log::info('Google Auth Callback - Redirect URI', [
                'redirect_uri' => $redirectUri,
                'code' => $code
            ]);

            $socialUser = Socialite::driver('google')
                ->redirectUrl($redirectUri)
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

    /**
     * Iniciar sesión con Google usando ID Token desde móvil
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function loginWithGoogleIdToken(Request $request): JsonResponse
    {
        try {
            if (empty(setting('_api.enable_social_login'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'El login social no está habilitado'
                ], 403);
            }

            $idToken = $request->input('id_token');
            $role = $request->input('role');
            if (!$idToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Token no proporcionado'
                ], 400);
            }

            // Verificar el ID Token
            $client = new \Google_Client();
            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID Token inválido o expirado'
                ], 401);
            }

            $googleId = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'] ?? '';

            DB::beginTransaction();

            // Buscar o crear usuario
            $user = User::where('provider_id', $googleId)
                ->where('provider', 'google')
                ->first();

            if (!$user) {
                $existingUser = User::where('email', $email)->first();

                if ($existingUser) {
                    $existingUser->update([
                        'provider' => 'google',
                        'provider_id' => $googleId,
                    ]);
                    $user = $existingUser;
                } else if (!empty($role) && $role != null) {
                    $user = User::create([
                        'email' => $email,
                        'provider' => 'google',
                        'provider_id' => $googleId,
                        'password' => bcrypt(Str::random(20)),
                        'email_verified_at' => now(),
                        'status' => 0,
                    ]);
                    if ($role == 'student')
                        $user->assignRole('student');
                    else if ($role == 'tutor')
                        $user->assignRole('tutor');
                    else
                        $user->assignRole('student');

                    // Crear perfil básico con el nombre obtenido de Google
                    $nameParts = explode(' ', $name, 2);
                    $firstName = $nameParts[0] ?? $name;
                    $lastName = $nameParts[1] ?? '';

                    $slug = Str::slug($firstName . ' ' . $lastName);
                    if (empty($slug)) {
                        $slug = Str::random(10);
                    }
                    $originalSlug = $slug;
                    $counter = 1;
                    while (\App\Models\Profile::where('slug', $slug)->exists()) {
                        $slug = $originalSlug . '-' . $counter;
                        $counter++;
                    }

                    $user->profile()->create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'slug' => $slug,
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Usuario no encontrado en el sistema'
                    ], 403);
                }

            }

            // Cargar relaciones necesarias para que coincida con AuthController::login
            $user->load([
                'profile:id,user_id,first_name,last_name,gender,recommend_tutor,intro_video,native_language,verified_at,slug,image,tagline,description,phone_number,price,created_at,updated_at',
                'address:country_id,state_id,city,address',
                'roles',
                'userWallet:id,user_id,amount'
            ]);

            // Asegurar que el campo available_for_tutoring esté disponible
            $user->available_for_tutoring = $user->available_for_tutoring ?? true;

            // Eliminar token anterior de la aplicación móvil si existe
            $user->tokens()->where('name', 'lernen')->delete();

            // Crear token de acceso para la API (con nombre lernen para coincidir con login normal)
            $token = $user->createToken('lernen', ['*'], now()->addDays(7))->plainTextToken;

            // Verificar si necesita completar perfil
            $profile = (new ProfileService($user->id))->getUserProfile();
            $needsProfileCompletion = empty($profile);

            DB::commit();

            // Importante: Devolver los datos con el formato EXACTO del login normal
            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión con Google exitoso',
                'data' => [
                    'token' => $token,
                    'user' => new \App\Http\Resources\UserResource($user),
                    'needs_profile_completion' => $needsProfileCompletion
                ]
            ]);

        } catch (Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            Log::error('Error en login con Google ID Token', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al iniciar sesión con Google: ' . $e->getMessage()
            ], 500);
        }
    }
}

