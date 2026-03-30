<?php

namespace App\Http\Controllers;

use App\Models\Conferences;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Models\UserSubject;
use App\Services\SiteService;
use App\Services\CountUserService;
use App\Repositories\TutorRepository;
use App\Services\SlotBookingService;
use App\Models\TeamMember;

use App\Models\Encuesta;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $siteService;
    protected $countUserService;
    protected $slotBookingService;

    protected $tutorRepository;

    public function __construct(SiteService $siteService,  CountUserService $countUserService, TutorRepository $tutorRepository, SlotBookingService $slotBookingService)
    {
        $this->siteService = $siteService;
        $this->countUserService = $countUserService;
        $this->tutorRepository = $tutorRepository;
        $this->slotBookingService = $slotBookingService;
    }

    public function index()
    {
        //Obtener un counter de los usuarios
        $counts = $this->countUserService->getUserCounts();

        // Obtener tutores destacados
        $featuredTutors = $this->siteService->featuredTutors();


        // Obtener alianzas
        $alianzas = $this->siteService->getAlliances();

        // obtener team
        $teamGroups = TeamMember::where('status', true)
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('order');
        $count_tutorinstant = $this->countTutorsWithAcceptedTerms();
        return view('vistas.view.pages.home', [
            'featuredTutors' => $featuredTutors,
            'alianzas' => $alianzas,
            'totalUsers' => $counts['totalUsers'],
            'totalEstudiantes' => $counts['studentCount'],
            'totalTutores' => $counts['tutorCount'],
            'teamGroups' => $teamGroups,
            'Tutores_instant_disponibles' => $count_tutorinstant,

        ]);
    }

    public function nosotros()
    {
        // Obtener alianzas
        $alianzas = $this->siteService->getAlliances();

        // obtener team
        $teamGroups = TeamMember::where('status', true)
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('order');

        return view('vistas.view.pages.nosotros', [
            'alianzas' => $alianzas,
            'teamGroups' => $teamGroups
        ]);
    }

    /**
     *  Redirecciona a la vista del perfil del tutor
     */
    public function tutor($slug)
    {
        $tutorias = $this->slotBookingService->getStudentUpcomingTutorias();

        $tutor = $this->siteService->getTutorDetail($slug);
        if (!$tutor) {
            abort(404, 'Tutor no encontrado');
        }
        // Extraer materias y grupos
        $materias = [];
        $grupos = [];
        if ($tutor->userSubjects) {
            foreach ($tutor->userSubjects as $userSubject) {
                if ($userSubject->subject) {
                    $materias[] = $userSubject->subject->name;
                    if ($userSubject->subject->group) {
                        $grupos[] = $userSubject->subject->group->name;
                    }
                }
            }
        }
        // $conferencias = Conferences::where('user_id', $tutor->id)->get();
        $materias = array_unique($materias);
        $grupos = array_unique($grupos);

        //Obtener Reseñas
        $reviewData = $this->tutorRepository->getTutorReviewsWithStats($tutor->id);

        // Verificar si el estudiante tiene una tutoría con este tutor
        $tienetutoriaConEsteTutor = $tutorias->where('tutor_id', $tutor->id)->isNotEmpty();

        // Verificación correcta
        if ($tienetutoriaConEsteTutor) {
            $reservas = $tutorias->where('tutor_id', $tutor->id);
        } else {
            $reservas = null;
        }

        return view('vistas.view.pages.tutor', [
            'reservas' => $reservas,
            'tutor' => $tutor,
            'materias' => array_unique($materias),
            'grupos' => array_unique($grupos),
            'reviews' => $reviewData['reviews'],
            'avgRating' => $reviewData['stats']['avgRating'],
            'totalReviews' => $reviewData['stats']['totalReviews'],
            'ratingDistribution' => $reviewData['stats']['distribution'],
            'canReview' => auth()->check() ?
                $this->tutorRepository->canUserReviewTutor(auth()->id(), $tutor->id) :
                false
        ]);
    }

    /**
     * Almacena una nueva reseña
     */
    public function storeReview(Request $request, $tutorId)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        if (!$this->tutorRepository->canUserReviewTutor(auth()->id(), $tutorId)) {
            return back()->with('error', 'No puedes reseñar a este tutor nuevamente.');
        }

        $result = $this->tutorRepository->createReview([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'tutor_id' => $tutorId,
            'reviewer_id' => auth()->id()
        ]);

        return back()->with(
            $result['success'] ? 'success' : 'error',
            $result['message']
        );
    }

    public function buscarTutor()
    {
        return view('vistas.view.pages.buscartutor');
    }

    public function buscar(Request $request)
    {

        //Obtener parámetros de la URL (incluído 'page' automáticamente por Laravel)
        // $search = $request->input('search');
        $search = null;
        $perPage = 50;

        $tutors = $this->tutorRepository->getFeaturedTutors($perPage, $search);
        $topSubjects = $this->tutorRepository->getTopSevenSubjects(); //lOS SIETE GRUPOS CON MÁS TUTORES

        // Pasar la colección paginada a la vista
        return view('vistas.view.pages.buscar', [
            'tutors' => $tutors,
            'searchTerm' => $search,
            'topSubjects' => $topSubjects,
        ]);
    }
    public function storeEncuesta(Request $request)
    {
        $user = Auth::user();
        $contactValue = $request->Contact;

        // VERIFICACIÓN CORRECTA SEGÚN TU MODELO USER.PHP
        if ($user) {
            // Usamos la relación profile() definida en la línea 86 de User.php
            // Y accedemos a phone_number (según tu captura de base de datos anterior)
            if ($user->profile && $user->profile->phone_number) {
                $contactValue = $user->profile->phone_number;
            }
        }

        $rules = [
            'Question_1' => 'required|boolean',
            'Question_2' => 'required|integer',
            // Question_3 es opcional, no necesita regla
        ];

        // Solo validamos que el Contact sea obligatorio/único si es GUEST.
        // Si es AUTH, asumimos que ya lo validamos antes o confiamos en la BD de usuarios.
        if (!$user) {
            $rules['Contact'] = 'required|string|max:20|unique:encuesta,Contact';
        } else {
            // Opcional: Verificar que el usuario no haya contestado ya (por ID)
            $yaContesto = \App\Models\Encuesta::where('IdUser', $user->id)->exists();
            if ($yaContesto) {
                return response()->json(['success' => false, 'message' => 'Ya has realizado esta encuesta anteriormente.'], 422);
            }
        }

        $request->validate($rules, [
            'Contact.unique' => 'Este número ya tiene un cupón activo.',
            'Contact.required' => 'El contacto es obligatorio.',
        ]);

        // 3. Guardar
        try {
            \App\Models\Encuesta::create([
                'Question_1' => $request->Question_1,
                'Question_2' => $request->Question_2,
                'Question_3' => $request->Question_3,
                'Contact'    => $contactValue, // Usamos la variable calculada arriba
                'IdUser'     => $user ? $user->id : null,
            ]);

            return response()->json(['success' => true, 'message' => '¡Encuesta guardada con éxito!'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }



    public function acceptTerms(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false], 403);
        }

        $role = $request->input('role');

        if (!in_array($role, ['student', 'tutor'], true)) {
            return response()->json(['success' => false, 'message' => 'Rol inválido'], 422);
        }

        $hasRole = $user->roles()->where('name', $role)->exists();
        if (!$hasRole) {
            return response()->json(['success' => false, 'message' => 'No autorizado para este rol'], 403);
        }

        $user->terms_accepted_at = now();
        $user->save();

        return response()->json(['success' => true]);
    }

    public function countTutorsWithAcceptedTerms(): int
    {
        return DB::table('users')
            ->join('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                    ->where('model_has_roles.model_type', '=', User::class);
            })
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'tutor')
            ->whereNotNull('users.terms_accepted_at')
            ->count();
    }
}
