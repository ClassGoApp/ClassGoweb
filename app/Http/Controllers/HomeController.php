<?php

namespace App\Http\Controllers;

use App\Models\Conferences;
use App\Models\User;
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
    public function enrollStudent(  $conferenceId, $studentId)
    {        
        return DB::transaction(function () use ($conferenceId, $studentId) {
            $conference = Conferences::lockForUpdate()->findOrFail($conferenceId);
            $student    = User::where('role', 'student')->findOrFail($studentId);

            // Verificar si ya está inscrito
            $already = DB::table('conference_student')
                ->where('conference_id', $conference->id)
                ->where('student_id', $student->id)
                ->exists();

            if ($already) {
                return ['ok' => true, 'message' => 'El estudiante ya está inscrito.'];
            }

            // **Asegurar cupo atómicamente**
            // Intento incrementar solo si aún hay cupo
            $updated = DB::table('conferences')
                ->where('id', $conference->id)
                ->whereColumn('enrolled_students', '<', 'ability')
                ->update([
                    'enrolled_students' => DB::raw('enrolled_students + 1'),
                ]);

            if ($updated === 0) {
                return ['ok' => false, 'message' => 'No hay cupos disponibles.'];
            }

            // Crear la inscripción en el pivot
            DB::table('conference_student')->insert([
                'conference_id' => $conference->id,
                'student_id'    => $student->id,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return ['ok' => true, 'message' => 'Inscripción exitosa.'];
        });
    }
}
