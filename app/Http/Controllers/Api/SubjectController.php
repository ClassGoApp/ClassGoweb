<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\SubjectGroup;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    use ApiResponser;

    /**
     * Obtener todas las materias
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Subject::select('subjects.id', 'subjects.name')
            ->leftJoin('subject_groups as sg', 'subjects.subject_group_id', '=', 'sg.id')
            ->leftJoin('subject_groups as parent', 'sg.id_padre', '=', 'parent.id')
            ->orderByRaw("
                CASE
                    WHEN sg.id = 3000 OR sg.id_padre = 3000 OR parent.id_padre = 3000 THEN 0
                    WHEN sg.id = 2000 OR sg.id_padre = 2000 OR parent.id_padre = 2000 THEN 1
                    WHEN sg.id = 1000 OR sg.id_padre = 1000 OR parent.id_padre = 1000 THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('subjects.name');

        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = trim($request->keyword);
            
            if (strlen($keyword) > 0 && strlen($keyword) <= 100) {
                $keyword = Str::lower($this->removeAccents($keyword));
                $query->where(function($q) use ($keyword) {
                    $q->whereRaw('LOWER(subjects.name) LIKE ?', ['%' . $keyword . '%'])
                      ->orWhereRaw('LOWER(subjects.name) LIKE ?', ['%' . $this->removeAccents($keyword) . '%']);
                });
            }
        }

        $perPage = $request->get('per_page', 20);
        $subjects = $query->paginate($perPage);
        return $this->success($subjects, 'Materias obtenidas exitosamente');
    }

    /**
     * Elimina acentos de una cadena
     *
     * @param string $string
     * @return string
     */
    private function removeAccents($string)
    {
        if (empty($string)) {
            return '';
        }

        $unwanted_array = array(
            'á'=>'a', 'à'=>'a', 'ã'=>'a', 'â'=>'a', 'ä'=>'a',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e',
            'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i',
            'ó'=>'o', 'ò'=>'o', 'õ'=>'o', 'ô'=>'o', 'ö'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u',
            'ý'=>'y', 'ÿ'=>'y',
            'ñ'=>'n',
            'Á'=>'A', 'À'=>'A', 'Ã'=>'A', 'Â'=>'A', 'Ä'=>'A',
            'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E',
            'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I',
            'Ó'=>'O', 'Ò'=>'O', 'Õ'=>'O', 'Ô'=>'O', 'Ö'=>'O',
            'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U',
            'Ý'=>'Y',
            'Ñ'=>'N'
        );
        return strtr($string, $unwanted_array);
    }

    public function getSubjectName($id)
    {
        $subject = \App\Models\Subject::find($id);
        if (!$subject) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }
        return response()->json([
            'id' => $subject->id,
            'name' => $subject->name
        ]);
    }

    public function getSubjectsInstitution(Request $request)
    {
        try {
            $institution = strtolower(trim((string) $request->query('institution','')));

            if (empty($institution)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Se requiere institution'
                ], 400);
            }

            
            $map = [
                'colegio'     => 1000,
                'universidad' => 2000,
                'instituto'   => 3000,
            ];

            if (!isset($map[$institution])) {
                return response()->json([
                    'success' => true,
                    'subjects' => []
                ]);
            }

            $rootId = $map[$institution];


            $subjectsQuery = Subject::select('id', 'name')
                ->whereNull('deleted_at')
                ->where('status', 'active');

            if ($rootId === 1000) {
                // COLEGIO: 1 nivel (hijos directos)
                $groupIds = SubjectGroup::whereNull('deleted_at')
                    ->where('status', 'active')
                    ->where('id_padre', $rootId)
                    ->pluck('id');

                $subjectsQuery->whereIn('subject_group_id', $groupIds);
            } else {
                // UNIVERSIDAD / INSTITUTO: 2 niveles (nietos)
               
                $childIds = SubjectGroup::whereNull('deleted_at')
                    ->where('status', 'active')
                    ->where('id_padre', $rootId)
                    ->pluck('id');

                // nietos (hijos de los hijos)
                $grandChildIds = SubjectGroup::whereNull('deleted_at')
                    ->where('status', 'active')
                    ->whereIn('id_padre', $childIds)
                    ->pluck('id');

                $subjectsQuery->whereIn('subject_group_id', $grandChildIds);
            }

            $subjects = $subjectsQuery
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'subjects' => $subjects
            ]);
        } catch (\Exception $e) {
            //Log::error('getSubjects error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar materias'
            ], 500);
        }
    }
}