<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSubject;
use App\Models\UserReview;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TutorRepository
{
    /**
     * Obtiene y pagina los tutores destacados, aplicando filtros y orden personalizado.
     *
     * @param int $perPage Número de resultados por página.
     * @param string|null $search Término de búsqueda.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFeaturedTutors(int $perPage = 12, ?string $search = null): LengthAwarePaginator
    {
        // 1. Obtener IDs de usuarios con el rol 'tutor'.
        $tutorIds = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('roles.name', 'tutor')
            ->pluck('model_has_roles.model_id');

        $query = User::whereIn('id', $tutorIds)
            // Filtros base obligatorios
            ->whereHas('profile', function ($q) {
                $q->whereNotNull('verified_at')
                  ->whereNotNull('first_name')
                  ->whereNotNull('last_name');
            })
            // Aseguramos que el tutor tenga un grupo registrado
            ->whereHas('userSubjects.subject.group');

        // 2. Lógica de Búsqueda Dinámica
        if ($search) {
            $query->where(function ($query) use ($search) {
                $searchLower = strtolower($search);

                // Buscar por Nombre/Apellido (profile)
                $query->whereHas('profile', function ($q) use ($searchLower) {
                    $q->where(DB::raw('LOWER(first_name)'), 'like', "%$searchLower%")
                      ->orWhere(DB::raw('LOWER(last_name)'), 'like', "%$searchLower%")
                      ->orWhereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", ["%$searchLower%"])
                      ->orWhereRaw("LOWER(CONCAT(last_name, ' ', first_name)) LIKE ?", ["%$searchLower%"]);
                })
                // O buscar por Materia (subjects)
                ->orWhereHas('userSubjects.subject', function ($q) use ($searchLower) {
                    $q->where(DB::raw('LOWER(name)'), 'like', "%$searchLower%");
                })
                // O buscar por Grupo (subject_groups)
                ->orWhereHas('userSubjects.subject.group', function ($q) use ($searchLower) {
                    $q->where(DB::raw('LOWER(name)'), 'like', "%$searchLower%");
                });
            });
        }

        // 3. Carga de Relaciones y Agregaciones (with, withAvg, withCount)
        $query->with([
            'profile:id,user_id,first_name,last_name,price,slug,image,description,native_language,tagline',
            'languages:id,name',
            'userSubjects.subject.group:id,name', // Solo cargamos el nombre del grupo
        ])
        ->withAvg('ratings as avg_rating', 'rating')
        ->withCount('ratings as total_reviews');

        // 4. Lógica de Ordenamiento
        $query->orderByRaw(
            "CASE WHEN EXISTS (\n            SELECT 1 FROM profiles p WHERE p.user_id = users.id AND p.first_name = ? AND p.last_name = ?\n        ) THEN 0 ELSE 1 END",
            ['Gabriel', 'Alpiry Hurtado']
        );
        $query->inRandomOrder(); 
        
        // ->orderByDesc('avg_rating');

        // 5. Paginación y Obtención
        return $query->paginate($perPage);
    }

    // Obtener las 7 materias más populares entre los tutores
    public function getTopSevenSubjects(): \Illuminate\Support\Collection
    {
        return UserSubject::select('subject_id')
            // Contar y nombrar la columna de conteo
            ->selectRaw('COUNT(subject_id) as total_registros')
            // Agrupar por el ID de la materia
            ->groupBy('subject_id')
            // Ordenar por el conteo (descendente)
            ->orderByDesc('total_registros')
            // Limitar a los 7 primeros
            ->limit(7)
            ->with('subject:id,name') // Cargar la relación de materia para obtener el nombre
            // Ejecutar la consulta y obtener la colección
            ->get();
    }

    //Obtención de comentarios del tutor
    public function getTutorReviews($tutorId)
    {
        return UserReview::where('user_id', $tutorId)
            ->with(['review', 'reviewer.profile'])
            ->whereHas('review', function($q) {
                $q->where('status', 'active');
            })
            ->latest()
            ->get()
            ->map(function($userReview) {
                return [
                    'id' => $userReview->id,
                    'rating' => $userReview->review->rating,
                    'comment' => $userReview->review->comment,
                    'created_at' => $userReview->created_at,
                    'reviewer' => [
                        'name' => $userReview->reviewer->profile->first_name . ' ' . $userReview->reviewer->profile->last_name,
                        'image' => $userReview->reviewer->profile->image ?? null
                    ]
                ];
            });
    }
}