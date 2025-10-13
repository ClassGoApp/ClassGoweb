<?php

namespace App\Http\Controllers;

use App\Models\Conferences;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use App\Models\UserSubject;
use App\Services\SiteService;
use App\Services\CountUserService;
use App\Repositories\TutorRepository;




use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $siteService;
    protected $countUserService;

    protected $tutorRepository;

    public function __construct(SiteService $siteService,  CountUserService $countUserService, TutorRepository $tutorRepository)
    {
        $this->siteService = $siteService;
        $this->countUserService = $countUserService;
        $this->tutorRepository = $tutorRepository;
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

    public function tutor($slug)
    {
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
        $conferencias = Conferences::where('user_id', $tutor->id)->get();
        $materias = array_unique($materias);
        $grupos = array_unique($grupos);

        return view('vistas.view.pages.tutor', [
            'tutor' => $tutor,
            'materias' => $materias,
            'grupos' => $grupos,
            'conferencias' => $conferencias
        ]);
    }

    public function buscarTutor()
    {
        return view('vistas.view.pages.buscartutor');
    }

    public function buscar(Request $request){

        //Obtener parámetros de la URL (incluído 'page' automáticamente por Laravel)
        $search = $request->input('search');
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
