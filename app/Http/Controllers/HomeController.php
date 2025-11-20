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

        return view('vistas.view.pages.home', [
            'featuredTutors' => $featuredTutors,
            'alianzas' => $alianzas,
            'totalUsers' => $counts['totalUsers'],
            'totalEstudiantes' => $counts['studentCount'],
            'totalTutores' => $counts['tutorCount']

        ]);
    }

    public function nosotros()
    {
        // Obtener alianzas
        $alianzas = $this->siteService->getAlliances();

        return view('vistas.view.pages.nosotros', [
            'alianzas' => $alianzas
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

    public function buscar(Request $request){

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
}
