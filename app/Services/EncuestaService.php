<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Encuesta;


class EncuestaService {

    /**
     * Obtener todas las encuestas con paginación
     */
    public function obtenerEncuestas($search = '', $perPage = 10)
    {
        return Encuesta::query()
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('Question_1', 'like', '%' . $search . '%')
                      ->orWhere('Question_2', 'like', '%' . $search . '%')
                      ->orWhere('Question_3', 'like', '%' . $search . '%')
                      ->orWhere('Contact', 'like', '%' . $search . '%')
                      ->orWhere('IdUser', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Obtener una encuesta específica por ID
     */
    public function obtenerEncuestaPorId($id)
    {
        return Encuesta::find($id);
    }

    /**
     * Obtener encuestas por usuario
     */
    public function obtenerEncuestasPorUsuario($userId)
    {
        return Encuesta::where('IdUser', $userId)->get();
    }

    /**
     * Contar total de encuestas
     */
    public function contarEncuestas()
    {
        return Encuesta::count();
    }

     /**
     * Obtener estadísticas de respuestas
     */
    public function obtenerEstadisticas()
    {
        return [
            'total' => Encuesta::count(),
            'hoy' => Encuesta::whereDate('created_at', Carbon::today())->count(),
            'esta_semana' => Encuesta::whereBetween('created_at', [
                Carbon::now()->startOfWeek(), 
                Carbon::now()->endOfWeek()
            ])->count(),
            'este_mes' => Encuesta::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
    }
}