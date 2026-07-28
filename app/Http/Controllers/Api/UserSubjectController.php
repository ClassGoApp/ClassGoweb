<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserSubject;
use App\Models\Subject;
use App\Models\SubjectGroup;
use App\Services\SubjectService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserSubjectController extends Controller
{
    use ApiResponser;

    protected $subjectService;

    public function __construct()
    {
        // No inicializar SubjectService aquí para evitar errores con usuarios no autenticados
    }

    /**
     * Método de prueba para verificar que el controlador funciona
     */
    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'UserSubjectController funcionando correctamente',
            'timestamp' => now(),
            'controller' => 'UserSubjectController'
        ]);
    }

    /**
     * Método de prueba para simular el store
     */
    public function testStore(Request $request)
    {
        Log::info('UserSubjectController::testStore - Iniciando', [
            'request_data' => $request->all(),
            'method' => $request->method(),
            'url' => $request->url(),
            'headers' => $request->headers->all()
        ]);

        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'subject_id' => 'required|integer|exists:subjects,id',
                'description' => 'nullable|string|max:1000',
                'price' => 'nullable|numeric|min:0|max:999999.99',
            ]);

            Log::info('UserSubjectController::testStore - Validación exitosa', [
                'validated_data' => $validated
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Test store funcionando correctamente',
                'data' => $validated,
                'timestamp' => now()
            ]);

        } catch (\Exception $e) {
            Log::error('UserSubjectController::testStore - Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error en test store: ' . $e->getMessage(),
                'timestamp' => now()
            ], 500);
        }
    }

    /**
     * Obtener todas las materias del tutor autenticado
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Consulta simple sin relaciones para depurar
        $query = UserSubject::query();

        // Filtrar por user_id si se especifica
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $query->join('subjects', 'user_subject.subject_id', '=', 'subjects.id')
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

        // Agregar logs para depuración
        Log::info('UserSubject Query:', [
            'user_id' => $request->get('user_id'),
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $userSubjects = $query->select('user_subject.*')->get();

        // Log del resultado
        Log::info('UserSubjects Result:', [
            'count' => $userSubjects->count(),
            'data' => $userSubjects->toArray()
        ]);

        // Si no hay resultados, devolver información de depuración
        if ($userSubjects->isEmpty()) {
            return $this->success(
                data: [],
                message: 'No se encontraron materias. Debug info: user_id=' . $request->get('user_id') . ', total records=' . UserSubject::count()
            );
        }

        // Cargar la relación después de obtener los datos
        $userSubjects->load(['subject' => function($query) {
            $query->select('id', 'name', 'subject_group_id');
        }]);

        $userSubjects = $userSubjects->map(function($userSubject) {
            return [
                'id' => $userSubject->id,
                'user_id' => $userSubject->user_id,
                'subject_id' => $userSubject->subject_id,
                'description' => $userSubject->description,
                'image' => $userSubject->image,
                'price' => $userSubject->price,
                'status' => $userSubject->status,
                'subject' => $userSubject->subject ? [
                    'id' => $userSubject->subject->id,
                    'name' => $userSubject->subject->name,
                    'subject_group_id' => $userSubject->subject->subject_group_id
                ] : null
            ];
        });

        return $this->success(
            data: $userSubjects,
            message: 'Materias obtenidas exitosamente'
        );
    }

    /**
     * Obtener una materia específica del tutor
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userSubject = UserSubject::where('id', $id)
            ->with(['subject' => function($query) {
                $query->select('id', 'name', 'subject_group_id');
            }])
            ->first();

        if (!$userSubject) {
            return $this->error(
                data: null,
                message: 'Materia no encontrada',
                code: Response::HTTP_NOT_FOUND
            );
        }

        return $this->success(
            data: $userSubject,
            message: 'Materia obtenida exitosamente'
        );
    }

    /**
     * Agregar una nueva materia al tutor
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('UserSubjectController::store - Iniciando', [
            'request_data' => $request->all(),
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'route_public' => true,
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'subject_id' => 'required|integer|exists:subjects,id',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072', // 3MB max
                'price' => 'nullable|numeric|min:0|max:999999.99', // Precio opcional, máximo 6 dígitos enteros y 2 decimales
            ]);

            Log::info('UserSubjectController::store - Validación exitosa', [
                'validated_data' => $validated
            ]);

            // Verificar que la materia no esté ya asignada al usuario
            $existingSubject = UserSubject::where('user_id', $validated['user_id'])
                ->where('subject_id', $validated['subject_id'])
                ->first();

            if ($existingSubject) {
                Log::warning('UserSubjectController::store - Materia ya existe', [
                    'user_id' => $validated['user_id'],
                    'subject_id' => $validated['subject_id']
                ]);
                
                return $this->error(
                    message: 'El usuario ya tiene esta materia asignada',
                    data: null,
                    code: Response::HTTP_CONFLICT
                );
            }

            // Procesar imagen si se proporciona
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('subjects', 'public');
            }

            $userSubjectData = [
                'user_id' => $validated['user_id'],
                'subject_id' => $validated['subject_id'],
                'description' => $validated['description'] ?? null,
                'image' => $imagePath,
                'price' => $validated['price'] ?? null,
                'status' => 'active'
            ];

            Log::info('UserSubjectController::store - Creando registro', [
                'userSubjectData' => $userSubjectData
            ]);

            $userSubject = UserSubject::create($userSubjectData);

            Log::info('UserSubjectController::store - Registro creado', [
                'userSubject_id' => $userSubject->id
            ]);

            // Cargar la relación con la materia para la respuesta
            $userSubject->load(['subject' => function($query) {
                $query->select('id', 'name', 'subject_group_id');
            }]);

            return $this->success(
                data: $userSubject,
                message: 'Materia agregada exitosamente',
                code: Response::HTTP_CREATED
            );

        } catch (\Exception $e) {
            Log::error('UserSubjectController::store - Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->error(
                message: 'Error al crear materia: ' . $e->getMessage(),
                data: null,
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Actualizar una materia del tutor
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userSubject = UserSubject::where('id', $id)->first();

        if (!$userSubject) {
            return $this->error(
                data: null,
                message: 'Materia no encontrada',
                code: Response::HTTP_NOT_FOUND
            );
        }

        $validated = $request->validate([
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072', // 3MB max
            'price' => 'nullable|numeric|min:0|max:999999.99', // Precio opcional, máximo 6 dígitos enteros y 2 decimales
            'status' => 'nullable|in:active,inactive'
        ]);

        // Procesar nueva imagen si se proporciona
        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($userSubject->image && Storage::disk('public')->exists($userSubject->image)) {
                Storage::disk('public')->delete($userSubject->image);
            }
            
            $imagePath = $request->file('image')->store('subjects', 'public');
            $validated['image'] = $imagePath;
        }

        $userSubject->update($validated);

        // Cargar la relación con la materia para la respuesta
        $userSubject->load(['subject' => function($query) {
            $query->select('id', 'name', 'subject_group_id');
        }]);

        return $this->success(
            data: $userSubject,
            message: 'Materia actualizada exitosamente'
        );
    }

    /**
     * Eliminar una materia del tutor
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userSubject = UserSubject::where('id', $id)->first();

        if (!$userSubject) {
            return $this->error(
                data: null,
                message: 'Materia no encontrada',
                code: Response::HTTP_NOT_FOUND
            );
        }

        // Eliminar imagen si existe
        if ($userSubject->image && Storage::disk('public')->exists($userSubject->image)) {
            Storage::disk('public')->delete($userSubject->image);
        }

        $userSubject->delete();

        return $this->success(
            data: null,
            message: 'Materia eliminada exitosamente'
        );
    }

    /**
     * Obtener grupos de materias disponibles
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubjectGroups()
    {
        $subjectGroups = SubjectGroup::select('id', 'name')
            ->where('status', 'active')
            ->whereHas('subjects', fn($q) => $q->where('status', 'active'))
            ->orderByRaw("
                CASE
                    WHEN id = 3000 OR id_padre = 3000 THEN 0
                    WHEN id = 2000 OR id_padre = 2000 THEN 1
                    WHEN id = 1000 OR id_padre = 1000 THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('name')
            ->get();

        return $this->success(
            data: $subjectGroups,
            message: 'Grupos de materias obtenidos exitosamente'
        );
    }

    /**
     * Obtener materias por grupo
     *
     * @param int $groupId
     * @return \Illuminate\Http\Response
     */
    public function getSubjectsByGroup($groupId)
    {
        $subjects = Subject::where('subject_group_id', $groupId)
            ->where('status', 'active')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return $this->success(
            data: $subjects,
            message: 'Materias del grupo obtenidas exitosamente'
        );
    }

    /**
     * Obtener materias disponibles para el tutor (excluyendo las que ya tiene)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableSubjects(Request $request)
    {
        $groupId = $request->get('group_id');
        $keyword = $request->get('keyword');
        $userId = $request->get('user_id');

        $query = Subject::where('subjects.status', 'active');

        // Filtrar por grupo si se especifica
        if ($groupId) {
            $query->where('subject_group_id', $groupId);
        }

        // Filtrar por palabra clave si se especifica
        if ($keyword) {
            $query->where('subjects.name', 'LIKE', "%{$keyword}%");
        }

        // Excluir materias que ya tiene el usuario (si se especifica user_id)
        if ($userId) {
            $userSubjectIds = UserSubject::where('user_id', $userId)
                ->pluck('subject_id')
                ->toArray();

            if (!empty($userSubjectIds)) {
                $query->whereNotIn('id', $userSubjectIds);
            }
        }

        $subjects = $query->select('subjects.id', 'subjects.name', 'subjects.subject_group_id')
            ->leftJoin('subject_groups as sg', 'subjects.subject_group_id', '=', 'sg.id')
            ->leftJoin('subject_groups as parent', 'sg.id_padre', '=', 'parent.id')
            ->with(['group' => function($query) {
                $query->select('id', 'name');
            }])
            ->orderByRaw("
                CASE
                    WHEN sg.id = 3000 OR sg.id_padre = 3000 OR parent.id_padre = 3000 THEN 0
                    WHEN sg.id = 2000 OR sg.id_padre = 2000 OR parent.id_padre = 2000 THEN 1
                    WHEN sg.id = 1000 OR sg.id_padre = 1000 OR parent.id_padre = 1000 THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('subjects.name')
            ->paginate($request->get('per_page', 20));

        return $this->success(
            data: $subjects,
            message: 'Materias disponibles obtenidas exitosamente'
        );
    }

    /**
     * Eliminar materia del tutor (eliminar relación user_subject)
     *
     * @param int $tutor_id
     * @param int $subject_id
     * @return \Illuminate\Http\Response
     */
    public function removeTutorSubject($tutor_id, $subject_id)
    {
        // Buscar la relación específica entre el tutor y la materia
        $userSubject = UserSubject::where('user_id', $tutor_id)
            ->where('subject_id', $subject_id)
            ->first();

        if (!$userSubject) {
            return $this->error(
                data: null,
                message: 'La materia no está asignada a este tutor',
                code: Response::HTTP_NOT_FOUND
            );
        }

        // Eliminar imagen si existe
        if ($userSubject->image && Storage::disk('public')->exists($userSubject->image)) {
            Storage::disk('public')->delete($userSubject->image);
        }

        // Eliminar la relación
        $userSubject->delete();

        return $this->success(
            data: null,
            message: 'Materia eliminada del tutor exitosamente'
        );
    }
} 