<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\UserSubject;
use App\Services\SiteService;
use App\Services\CountUserService;



use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $siteService;
    protected $countUserService;

    public function __construct(SiteService $siteService,  CountUserService $countUserService)
    {
        $this->siteService = $siteService;
        $this->countUserService = $countUserService;
    }

    public function index(){
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

    public function nosotros() {
    // Obtener alianzas
    $alianzas = $this->siteService->getAlliances();

    return view('vistas.view.pages.nosotros', [
        'alianzas' => $alianzas
    ]);
    }

    public function tutor($slug){
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
        $materias = array_unique($materias);
        $grupos = array_unique($grupos);
        return view('vistas.view.pages.tutor', [
            'tutor' => $tutor,
            'materias' => $materias,
            'grupos' => $grupos,
        ]);
    }

    public function buscarTutor(){
        return view('vistas.view.pages.buscartutor');
    }
}
