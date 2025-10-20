<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecommendedTutor\RecommendedTutorResource;
use App\Http\Resources\FindTutors\TutorCollection;
use App\Http\Resources\TutorDetail\TutorDetailResource;
use App\Http\Resources\TutorSlots\TutorSlotResource;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserSubject;
use App\Models\Subject;
use App\Services\BookingService;
use App\Services\ProfileService;
use App\Services\SiteService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TutorController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $token = request()->bearerToken();
        $sanctumToken = PersonalAccessToken::findToken($token) ?? null;

        if (!empty($sanctumToken) && $sanctumToken->expires_at && Carbon::parse($sanctumToken->expires_at)->isFuture()) {
            $this->middleware('auth:sanctum');
        }
    }

    public function getRecommendedTutors()
    {
        $recommendedTutors  = (new SiteService)->getRecommendedTutors(['order_by' => 'ratings', 'total' => 10]);
        $tutors             =  $this->getFavouriateTutors($recommendedTutors);
        return $this->success(data: RecommendedTutorResource::collection($tutors));
    }

    public function findTutots(Request $request)
    {
        try {
            // Log de los parámetros recibidos
            Log::info('Parámetros de búsqueda:', [
                'keyword' => $request->keyword,
                'tutor_name' => $request->tutor_name,
                'group_id' => $request->group_id,
                'min_courses' => $request->min_courses,
                'min_rating' => $request->min_rating,
                'instant' => $request->instant,
                'page' => $request->page
            ]);

            // Consulta base
            $query = User::whereHas('roles', function($q) {
                $q->where('name', 'tutor');
            })->with(['profile', 'subjects'])
              ->whereHas('profile', function($q) {
                  $q->whereNotNull('verified_at');
              })
              ->where('available_for_tutoring', true); // Solo tutores disponibles

            // Filtro por keyword (búsqueda en nombre de materia)
            if ($request->filled('keyword')) {
                $keyword = trim($request->keyword);
                $query->whereHas('subjects', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            }

            // Filtro por tutor_name (búsqueda en nombre del tutor)
            if ($request->filled('tutor_name')) {
                $tutorName = trim($request->tutor_name);
                $query->whereHas('profile', function($q) use ($tutorName) {
                    $q->where(function($subQ) use ($tutorName) {
                        $subQ->where('first_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere('last_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$tutorName}%");
                    });
                });
            }

            // Filtro por group_id (categoría de materia)
            if ($request->filled('group_id')) {
                $query->whereHas('subjects', function($q) use ($request) {
                    $q->where('subject_group_id', $request->group_id);
                });
            }

            // Filtro por min_courses (número mínimo de cursos completados)
            if ($request->filled('min_courses')) {
                $minCourses = (int) $request->min_courses;
                $query->whereHas('companyCourseUsers', function($q) use ($minCourses) {
                    $q->where('status', 'completed');
                }, '>=', $minCourses);
            }

            // Filtro por min_rating (calificación mínima)
            if ($request->filled('min_rating')) {
                $minRating = (float) $request->min_rating;
                // Solo aplicar filtro si min_rating es mayor que 0
                if ($minRating > 0) {
                    $query->whereHas('reviews', function($q) use ($minRating) {
                        $q->select('tutor_id')
                          ->groupBy('tutor_id')
                          ->havingRaw('AVG(rating) >= ?', [$minRating]);
                    });
                }
            }

            // Filtro para tutoría instantánea
            if ($request->filled('instant') && $request->instant === 'true') {
                $now = now();
                $currentTime = $now->format('H:i:s');
                $currentDate = $now->format('Y-m-d');
                
                // Filtrar tutores que tengan slots en la fecha y hora actual
                $query->whereHas('userSubjectSlots', function($q) use ($currentTime, $currentDate) {
                    $q->where('date', $currentDate)
                      ->where('start_time', '<=', $currentTime)
                      ->where('end_time', '>=', $currentTime);
                });
                
                Log::info('Filtro de tutoría instantánea aplicado', [
                    'current_date' => $currentDate,
                    'current_time' => $currentTime
                ]);
            }

            // Ordenar por el nombre del tutor (usando el perfil relacionado)
            $query->join('profiles', 'users.id', '=', 'profiles.user_id')
                  ->orderBy('profiles.first_name', 'asc')
                  ->select('users.*');

            // Log del conteo de resultados
            $count = $query->count();
            Log::info('Número de tutores encontrados: ' . $count);

            // Paginación
            $perPage = 10; // Puedes hacer esto configurable
            $page = $request->filled('page') ? (int) $request->page : 1;
            
            $tutors = $query->paginate($perPage, ['*'], 'page', $page);
            
            $tutors->getCollection()->transform(function ($tutor) use ($request) {
                $tutor = $this->getFavouriateTutors($tutor);
                // Agregar el conteo de cursos completados
                $tutor->completed_courses_count = $tutor->getCompletedCoursesCount();
                
                // Si es tutoría instantánea, agregar información de slots disponibles
                if ($request->filled('instant') && $request->instant === 'true') {
                    $now = now();
                    $currentTime = $now->format('H:i:s');
                    $currentDate = $now->format('Y-m-d');
                    
                    $availableSlots = $tutor->userSubjectSlots()
                        ->where('date', $currentDate)
                        ->where('start_time', '<=', $currentTime)
                        ->where('end_time', '>=', $currentTime)
                        ->get();
                    
                    $tutor->available_instant_slots = $availableSlots;
                    $tutor->available_instant_slots_count = $availableSlots->count();
                }
                
                return $tutor;
            });

            return $this->success(data: new TutorCollection($tutors));

        } catch (\Exception $e) {
            Log::error('Error en findTutots: ' . $e->getMessage());
            return $this->error(message: 'Error al buscar tutores: ' . $e->getMessage());
        }
    }

    public function getTutorDetail($slug)
    {
        $profile = Profile::whereSlug($slug)->first();
 
        if(!$profile){
            return $this->error(message: 'Tutor not found.',code: Response::HTTP_NOT_FOUND);
        }

        $tutor   = (new SiteService)->getTutorDetail($slug);

        if (!$tutor) {
            return $this->error(message: 'Tutor profile not verified.',code: Response::HTTP_UNAUTHORIZED);
        }

        $tutor      = $this->getFavouriateTutors($tutor);
        return $this->success(data: new TutorDetailResource($tutor));
    }

    public function getTutorAvailableSlots(Request $request)
    {
        $userId         = $request->user_id;
        $userTimeZone   = $request->user_time_zone;
        $filter         = $request->filter ?? [];
        $type           = $request->type;

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startDate  = Carbon::parse($request->start_date)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
            $endDate    = Carbon::parse($request->start_date)->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        }

        else {
            $startDate  =   Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
            $endDate    =   Carbon::now()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
        }

        if ($type == 'prev') {
            $startDate = Carbon::parse($startDate)->subDays(7)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->subDays(7)->format('Y-m-d');
        } elseif ($type == 'next') {
            $startDate = Carbon::parse($startDate)->addDays(7)->format('Y-m-d');
            $endDate = Carbon::parse($endDate)->addDays(7)->format('Y-m-d');
        }

        $dateRange = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59"
        ];

        if (empty($userId)) {
            return $this->error(data: null,message: 'Invalid parameters.',code: Response::HTTP_BAD_REQUEST);
        }

        $tutor = User::where('id', $userId)->first();

        if (!$tutor) {
            return $this->error(data: null,message: 'Tutor not found.',code: Response::HTTP_NOT_FOUND);
        }

        if ($tutor->role !== 'tutor') {
            return $this->error(data: null,message: 'Unauthorized access.',code: Response::HTTP_FORBIDDEN);
        }

        $bookingService = new BookingService();
        $availableSlots = $bookingService->getTutorAvailableSlots($userId, $userTimeZone, $dateRange, $filter);
        $userSlot = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59"
        ];

        foreach ($availableSlots as $date => $slots) {
            $formattedDate = Carbon::parse($date)->format('d M Y');
            $userSlot[$formattedDate] = TutorSlotResource::collection($slots);
        }

        return $this->success(data: $userSlot);
    }

    public function slotDetail($id)
    {
        $booking = \App\Models\SlotBooking::with(['tutor', 'slot', 'subject'])->find($id);
        if (!$booking) {
            return $this->error(data: null, message: __('api.booking_not_found'), code: 404);
        }
        return $this->success(data: new \App\Http\Resources\SlotBookingResource($booking));
    }

    public function getFavouriateTutors($tutors)
    {
        $favoritesTutor = [];
        if (Auth::check() && Auth::user()) {
            try {
                $user           = Auth::user();
                $userService    = new UserService($user);
                $favoritesTutor = $userService->getFavouriteUsers()->get(['favourite_user_id'])?->pluck('favourite_user_id')->toArray();
            } catch (\Exception $e) {
                Log::error('Error obteniendo favoritos del usuario: ' . $e->getMessage());
                $favoritesTutor = [];
            }
        }

        if (is_array($tutors) || $tutors instanceof \Illuminate\Support\Collection) {
            $usersWithFavorites = $tutors->map(function ($user) use ($favoritesTutor) {
            $user->is_favorite  = in_array($user->id, $favoritesTutor);
            return $user;
        });
        } else {
            $user                   = $tutors;
            $user->is_favorite      = in_array($user->id, $favoritesTutor);
            $usersWithFavorites     = $user;
        }
        return $usersWithFavorites;
    }

    public function getStates(Request $request)
    {
        $countryId = $request?->country_id;
        $profileService = new ProfileService();
        $states = $profileService->countryStates($countryId);
        if($states->isEmpty()){
            return $this->error(data: null,message: __('api.no_states_found'),code: Response::HTTP_NOT_FOUND);
        }else{
            return $this->success(data: $states,message: __('api.states_fetched_successfully'));
        }
    }

    /**
     * API: Obtener tutores verificados con materias registradas
     * GET /api/verified-tutors
     */
    public function getVerifiedTutorsWithSubjects(Request $request)
    {
        try {
            // Log de los parámetros recibidos
            Log::info('Parámetros de búsqueda verified-tutors:', [
                'keyword' => $request->keyword,
                'tutor_name' => $request->tutor_name,
                'group_id' => $request->group_id,
                'subject_id' => $request->subject_id,
                'min_courses' => $request->min_courses,
                'min_rating' => $request->min_rating,
                'page' => $request->page
            ]);

            // Consulta base - Solo tutores verificados con materias registradas
            $query = User::whereHas('roles', function($q) {
                $q->where('name', 'tutor');
            })->with(['profile', 'subjects'])
              ->whereHas('profile', function($q) {
                  $q->whereNotNull('verified_at');
              })
              ->whereHas('subjects'); // Solo tutores con materias registradas

            // Filtro por keyword (búsqueda en nombre de materia)
            if ($request->filled('keyword')) {
                $keyword = trim($request->keyword);
                $query->whereHas('subjects', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            }

            // Filtro por tutor_name (búsqueda en nombre del tutor)
            if ($request->filled('tutor_name')) {
                $tutorName = trim($request->tutor_name);
                $query->whereHas('profile', function($q) use ($tutorName) {
                    $q->where(function($subQ) use ($tutorName) {
                        $subQ->where('first_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere('last_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$tutorName}%");
                    });
                });
            }

            // Filtro por group_id (categoría de materia)
            if ($request->filled('group_id')) {
                $query->whereHas('subjects', function($q) use ($request) {
                    $q->where('subject_group_id', $request->group_id);
                });
            }

            // Filtro por subject_id (materia específica)
            if ($request->filled('subject_id')) {
                $query->whereHas('subjects', function($q) use ($request) {
                    $q->where('subjects.id', $request->subject_id);
                });
            }

            // Filtro por min_courses (número mínimo de cursos completados)
            if ($request->filled('min_courses')) {
                $minCourses = (int) $request->min_courses;
                $query->whereHas('companyCourseUsers', function($q) use ($minCourses) {
                    $q->where('status', 'completed');
                }, '>=', $minCourses);
            }

            // Filtro por min_rating (calificación mínima)
            if ($request->filled('min_rating')) {
                $minRating = (float) $request->min_rating;
                // Solo aplicar filtro si min_rating es mayor que 0
                if ($minRating > 0) {
                    $query->whereHas('reviews', function($q) use ($minRating) {
                        $q->select('tutor_id')
                          ->groupBy('tutor_id')
                          ->havingRaw('AVG(rating) >= ?', [$minRating]);
                    });
                }
            }



            // Ordenar por el nombre del tutor (usando el perfil relacionado)
            $query->join('profiles', 'users.id', '=', 'profiles.user_id')
                  ->orderBy('profiles.first_name', 'asc')
                  ->select('users.*');

            // Log del conteo de resultados
            $count = $query->count();
            Log::info('Número de tutores verificados encontrados: ' . $count);

            // Paginación
            $perPage = 10; // Puedes hacer esto configurable
            $page = $request->filled('page') ? (int) $request->page : 1;
            
            $tutors = $query->paginate($perPage, ['*'], 'page', $page);

            $tutors->getCollection()->transform(function ($tutor) {
                $tutor = $this->getFavouriateTutors($tutor);
                // Agregar el conteo de cursos completados
                $tutor->completed_courses_count = $tutor->getCompletedCoursesCount();
                
                return $tutor;
            });

            return $this->success(data: new \App\Http\Resources\FindTutors\TutorCollection($tutors));

        } catch (\Exception $e) {
            Log::error('Error en getVerifiedTutorsWithSubjects: ' . $e->getMessage());
            return $this->error(message: 'Error al buscar tutores verificados: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener la ruta de la foto de perfil de los tutores verificados
     * GET /api/verified-tutors-photos
     */
    public function getVerifiedTutorsPhotos(Request $request)
    {
        try {
            $query = \App\Models\User::whereHas('roles', function($q) {
                $q->where('name', 'tutor');
            })
            ->whereHas('profile', function($q) {
                $q->whereNotNull('verified_at');
            })
            ->with(['profile' => function($q) {
                $q->select('id', 'user_id', 'image', 'first_name', 'last_name');
            }]);

            if ($request->filled('tutor_id')) {
                $query->where('id', $request->tutor_id);
            }

            $tutors = $query->get();

            $result = $tutors->map(function($tutor) {
                $rutaBD = $tutor->profile ? $tutor->profile->image : null;
                $url = $rutaBD ? url('public/storage/' . $rutaBD) : null;
                $fullName = $tutor->profile ? trim($tutor->profile->first_name . ' ' . $tutor->profile->last_name) : 'N/A';
                
                return [
                    'id' => $tutor->id,
                    'name' => $fullName,
                    'first_name' => $tutor->profile ? $tutor->profile->first_name : null,
                    'last_name' => $tutor->profile ? $tutor->profile->last_name : null,
                    'profile_image' => $url,
                    'profile_image_db_path' => $rutaBD,
                    'available_for_tutoring' => $tutor->available_for_tutoring
                ];
            });

            return $this->success($result, 'Fotos de perfil de tutores verificados obtenidas exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error en getVerifiedTutorsPhotos: ' . $e->getMessage());
            return $this->error(message: 'Error al obtener fotos de tutores verificados: ' . $e->getMessage());
        }
    }

    /**
     * API: Obtener información detallada de slots instantáneos disponibles para un tutor
     * GET /api/tutor/{id}/instant-slots
     */
    public function getInstantSlots($tutorId)
    {
        try {
            $tutor = User::whereHas('roles', function($q) {
                $q->where('name', 'tutor');
            })->whereHas('profile', function($q) {
                $q->whereNotNull('verified_at');
            })->find($tutorId);

            if (!$tutor) {
                return $this->error(message: 'Tutor no encontrado', code: Response::HTTP_NOT_FOUND);
            }

            $now = now();
            $currentTime = $now->format('H:i:s');
            $currentDate = $now->format('Y-m-d');

            $instantSlots = $tutor->userSubjectSlots()
                ->where('date', $currentDate)
                ->where('start_time', '<=', $currentTime)
                ->where('end_time', '>=', $currentTime)
                ->with(['user.profile'])
                ->get();

            $result = [
                'tutor' => [
                    'id' => $tutor->id,
                    'name' => $tutor->profile ? $tutor->profile->full_name : 'N/A',
                    'image' => $tutor->profile ? url('public/storage/' . $tutor->profile->image) : null,
                ],
                'current_time' => $now->format('Y-m-d H:i:s'),
                'available_slots' => $instantSlots->map(function($slot) {
                    return [
                        'id' => $slot->id,
                        'start_time' => $slot->start_time,
                        'end_time' => $slot->end_time,
                        'duration' => $slot->duracion,
                        'session_fee' => $slot->session_fee,
                        'description' => $slot->description,
                        'date' => $slot->date,
                    ];
                }),
                'total_available_slots' => $instantSlots->count()
            ];

            return $this->success($result, 'Slots instantáneos obtenidos exitosamente');
        } catch (\Exception $e) {
            Log::error('Error en getInstantSlots: ' . $e->getMessage());
            return $this->error(message: 'Error al obtener slots instantáneos: ' . $e->getMessage());
        }
    }

    /**
     * API: Cambiar disponibilidad del tutor para dar tutorías
     * PUT /api/user/{id}/tutoring-availability
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTutoringAvailability(Request $request, $id)
    {
        try {
            // Validar los datos de entrada
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'available_for_tutoring' => 'required|integer|in:0,1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Buscar el usuario
            $user = User::find($id);
            if (!$user) {
                return $this->error(
                    data: null,
                    message: 'Usuario no encontrado',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            // Verificar que el usuario sea un tutor
            if (!$user->hasRole('tutor')) {
                return $this->error(
                    data: null,
                    message: 'Solo los tutores pueden cambiar su disponibilidad',
                    code: Response::HTTP_FORBIDDEN
                );
            }

            // Obtener el valor actual
            $oldValue = $user->available_for_tutoring;
            $newValue = $request->available_for_tutoring;

            // Actualizar el campo
            $user->available_for_tutoring = $newValue;
            $result = $user->save();

            if (!$result) {
                return $this->error(
                    data: null,
                    message: 'Error al actualizar la disponibilidad',
                    code: Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            // Log del cambio
            Log::info('Disponibilidad del tutor actualizada', [
                'user_id' => $user->id,
                'email' => $user->email,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'status_text' => $newValue ? 'Disponible' : 'No disponible'
            ]);

            // Devolver respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Disponibilidad del tutor actualizada correctamente',
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'available_for_tutoring' => $user->available_for_tutoring,
                    'status_text' => $user->available_for_tutoring ? 'Disponible' : 'No disponible',
                    'previous_value' => $oldValue
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al actualizar disponibilidad del tutor: ' . $e->getMessage());
            return $this->error(
                data: null,
                message: 'Error interno del servidor',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * API: Obtener tutores disponibles con lógica condicional:
     * - Si available_for_tutoring = true: mostrar sin importar slots
     * - Si available_for_tutoring = false: solo mostrar si tiene slots disponibles ahora
     * GET /api/available-tutors
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableTutors(Request $request)
    {
        try {
            // Log de los parámetros recibidos
            Log::info('Parámetros de búsqueda available-tutors:', [
                'keyword' => $request->keyword,
                'tutor_name' => $request->tutor_name,
                'group_id' => $request->group_id,
                'subject_id' => $request->subject_id,
                'min_courses' => $request->min_courses,
                'min_rating' => $request->min_rating,
                'page' => $request->page
            ]);

            // Log de la lógica de disponibilidad aplicada
            $now = now();
            $currentTime = $now->format('H:i:s');
            $currentDate = $now->format('Y-m-d');
            
            Log::info('Lógica de disponibilidad aplicada:', [
                'current_date' => $currentDate,
                'current_time' => $currentTime,
                'logic' => 'available_for_tutoring=true OR (available_for_tutoring=false AND has_current_slots)'
            ]);

            // Consulta base - Solo tutores con rol 'tutor', verificados y con materias registradas
            $query = User::whereHas('roles', function($q) {
                $q->where('name', 'tutor');
            })->with(['profile', 'subjects'])
              ->whereHas('profile', function($q) {
                  $q->whereNotNull('verified_at');
              })
              ->whereHas('subjects'); // Solo tutores con materias registradas

            // Lógica condicional para disponibilidad:
            // 1. Si available_for_tutoring = true: mostrar sin importar slots
            // 2. Si available_for_tutoring = false: solo mostrar si tiene slots disponibles ahora
            $now = now();
            $currentTime = $now->format('H:i:s');
            $currentDate = $now->format('Y-m-d');

            $query->where(function($q) use ($currentTime, $currentDate) {
                // Condición 1: available_for_tutoring = true
                $q->where('available_for_tutoring', true)
                  // O condición 2: available_for_tutoring = false pero tiene slots disponibles ahora
                  ->orWhere(function($subQ) use ($currentTime, $currentDate) {
                      $subQ->where('available_for_tutoring', false)
                           ->whereHas('userSubjectSlots', function($slotQ) use ($currentTime, $currentDate) {
                               $slotQ->where('date', $currentDate)
                                    ->where('start_time', '<=', $currentTime)
                                    ->where('end_time', '>=', $currentTime);
                           });
                  });
            });

            // Filtro por keyword (búsqueda en nombre de materia)
            if ($request->filled('keyword')) {
                $keyword = trim($request->keyword);
                $query->whereHas('subjects', function($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            }

            // Filtro por tutor_name (búsqueda en nombre del tutor)
            if ($request->filled('tutor_name')) {
                $tutorName = trim($request->tutor_name);
                $query->whereHas('profile', function($q) use ($tutorName) {
                    $q->where(function($subQ) use ($tutorName) {
                        $subQ->where('first_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere('last_name', 'LIKE', "%{$tutorName}%")
                             ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$tutorName}%");
                    });
                });
            }

            // Filtro por group_id (categoría de materia)
            if ($request->filled('group_id')) {
                $query->whereHas('subjects', function($q) use ($request) {
                    $q->where('subject_group_id', $request->group_id);
                });
            }

            // Filtro por subject_id (materia específica)
            if ($request->filled('subject_id')) {
                $query->whereHas('subjects', function($q) use ($request) {
                    $q->where('subjects.id', $request->subject_id);
                });
            }

            // Filtro por min_courses (número mínimo de cursos completados)
            if ($request->filled('min_courses')) {
                $minCourses = (int) $request->min_courses;
                $query->whereHas('companyCourseUsers', function($q) use ($minCourses) {
                    $q->where('status', 'completed');
                }, '>=', $minCourses);
            }

            // Filtro por min_rating (calificación mínima)
            if ($request->filled('min_rating')) {
                $minRating = (float) $request->min_rating;
                // Solo aplicar filtro si min_rating es mayor que 0
                if ($minRating > 0) {
                    $query->whereHas('reviews', function($q) use ($minRating) {
                        $q->select('tutor_id')
                          ->groupBy('tutor_id')
                          ->havingRaw('AVG(rating) >= ?', [$minRating]);
                    });
                }
            }

            // Ordenar por el nombre del tutor (usando el perfil relacionado)
            $query->join('profiles', 'users.id', '=', 'profiles.user_id')
                  ->orderBy('profiles.first_name', 'asc')
                  ->select('users.*');

            // Log del conteo de resultados
            $count = $query->count();
            Log::info('Número de tutores disponibles encontrados: ' . $count);

            // Paginación
            $perPage = 10; // Puedes hacer esto configurable
            $page = $request->filled('page') ? (int) $request->page : 1;
            
            $tutors = $query->paginate($perPage, ['*'], 'page', $page);
            
            $tutors->getCollection()->transform(function ($tutor) {
                $tutor = $this->getFavouriateTutors($tutor);
                // Agregar el conteo de cursos completados
                $tutor->completed_courses_count = $tutor->getCompletedCoursesCount();
                
                return $tutor;
            });

                         return $this->success(data: new \App\Http\Resources\FindTutors\TutorCollection($tutors));
 
         } catch (\Exception $e) {
             Log::error('Error en getAvailableTutors: ' . $e->getMessage());
             return $this->error(message: 'Error al obtener tutores disponibles: ' . $e->getMessage());
         }
     }
 
     /**
      * API: Obtener un tutor disponible para una materia específica
      * GET /api/tutor-for-subject/{subject_id}
      * @param Request $request
      * @param int $subject_id
      * @return \Illuminate\Http\JsonResponse
      */
     public function getTutorForSubject(Request $request, $subject_id)
     {
         try {
             // Log de los parámetros recibidos
             Log::info('Búsqueda de tutor para materia:', [
                 'subject_id' => $subject_id,
                 'current_time' => now()->format('Y-m-d H:i:s')
             ]);
 
             // Verificar que la materia existe
             $subject = Subject::find($subject_id);
             if (!$subject) {
                 return $this->error(
                     data: null,
                     message: 'Materia no encontrada',
                     code: Response::HTTP_NOT_FOUND
                 );
             }
 
             // Obtener fecha y hora actual
             $now = now();
             $currentTime = $now->format('H:i:s');
             $currentDate = $now->format('Y-m-d');
 
             // Consulta para encontrar un tutor que cumpla las condiciones:
             // 1. Sea tutor con perfil verificado
             // 2. Tenga la materia específica registrada
             // 3. Cumpla la lógica de disponibilidad:
             //    - Si available_for_tutoring = true: mostrar sin importar slots
             //    - Si available_for_tutoring = false: solo mostrar si tiene slots disponibles ahora
             $tutor = User::whereHas('roles', function($q) {
                 $q->where('name', 'tutor');
             })->with(['profile', 'subjects'])
               ->whereHas('profile', function($q) {
                   $q->whereNotNull('verified_at');
               })
               ->whereHas('subjects', function($q) use ($subject_id) {
                   $q->where('subjects.id', $subject_id);
               })
               ->where(function($q) use ($currentTime, $currentDate) {
                   // Condición 1: available_for_tutoring = true
                   $q->where('available_for_tutoring', true)
                     // O condición 2: available_for_tutoring = false pero tiene slots disponibles ahora
                     ->orWhere(function($subQ) use ($currentTime, $currentDate) {
                         $subQ->where('available_for_tutoring', false)
                              ->whereHas('userSubjectSlots', function($slotQ) use ($currentTime, $currentDate) {
                                  $slotQ->where('date', $currentDate)
                                       ->where('start_time', '<=', $currentTime)
                                       ->where('end_time', '>=', $currentTime);
                              });
                     });
               })
               ->first(); // Solo obtener el primer tutor que cumpla las condiciones
 
             if (!$tutor) {
                 return $this->error(
                     data: null,
                     message: 'No se encontró ningún tutor disponible para esta materia en este momento',
                     code: Response::HTTP_NOT_FOUND
                 );
             }
 
             // Agregar información adicional al tutor
             $tutor = $this->getFavouriateTutors($tutor);
             $tutor->completed_courses_count = $tutor->getCompletedCoursesCount();
             $tutor->subject_requested = $subject->name;
             $tutor->subject_id_requested = $subject_id;
 
             // Log del tutor encontrado
             Log::info('Tutor encontrado para materia:', [
                 'tutor_id' => $tutor->id,
                 'tutor_name' => $tutor->profile ? $tutor->profile->first_name . ' ' . $tutor->profile->last_name : 'N/A',
                 'subject_id' => $subject_id,
                 'subject_name' => $subject->name,
                 'available_for_tutoring' => $tutor->available_for_tutoring,
                 'current_time' => $now->format('Y-m-d H:i:s')
             ]);
 
             // Devolver respuesta exitosa
             return response()->json([
                 'success' => true,
                 'message' => 'Tutor encontrado exitosamente',
                 'data' => [
                     'tutor' => [
                         'id' => $tutor->id,
                         'email' => $tutor->email,
                         'first_name' => $tutor->profile ? $tutor->profile->first_name : null,
                         'last_name' => $tutor->profile ? $tutor->profile->last_name : null,
                         'full_name' => $tutor->profile ? $tutor->profile->first_name . ' ' . $tutor->profile->last_name : 'N/A',
                         'image' => $tutor->profile ? url('public/storage/' . $tutor->profile->image) : null,
                         'available_for_tutoring' => $tutor->available_for_tutoring,
                         'completed_courses_count' => $tutor->completed_courses_count,
                         'is_favorite' => $tutor->is_favorite ?? false
                     ],
                     'subject' => [
                         'id' => $subject->id,
                         'name' => $subject->name
                     ],
                     'search_time' => $now->format('Y-m-d H:i:s')
                 ]
             ], 200);
 
         } catch (\Exception $e) {
             Log::error('Error en getTutorForSubject: ' . $e->getMessage());
             return $this->error(
                 data: null,
                 message: 'Error al buscar tutor para la materia: ' . $e->getMessage(),
                 code: Response::HTTP_INTERNAL_SERVER_ERROR
             );
         }
     }
 }
