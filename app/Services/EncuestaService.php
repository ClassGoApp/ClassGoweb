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

    /**
     * Calcular porcentaje de éxito en búsqueda
     * Question_1 = 1 (encontró fácilmente), 0 (no encontró fácilmente)
     */
    public function calcularExitoBusqueda()
    {
        $total = Encuesta::count();
        
        if ($total === 0) {
            return 0;
        }

        $exitosos = Encuesta::where('Question_1', 1)->count();
        
        return round(($exitosos / $total) * 100, 1);
    }

    /**
     * Calcular promedio de recomendación
     * Question_2 = Calificación de 1 a 5 estrellas
     */
    public function calcularPromedioRecomendacion()
    {
        $promedio = Encuesta::avg('Question_2');
        
        if ($promedio === null) {
            return 0;
        }

        return round($promedio, 1);
    }

    /**
     * Calcular porcentaje de usuarios detractores
     * Detractores = Usuarios que calificaron con 1 o 2 estrellas
     */
    public function calcularUsuariosDetractores()
    {
        $total = Encuesta::count();
        
        if ($total === 0) {
            return 0;
        }

        $detractores = Encuesta::whereIn('Question_2', [1, 2])->count();
        
        return round(($detractores / $total) * 100, 1);
    }

    /**
     * Obtener el comentario negativo más frecuente
     * Analiza Question_3 de usuarios con calificación baja (1-2)
     */
    public function obtenerFocoMejora()
    {
        // Obtener comentarios de usuarios detractores (1-2 estrellas)
        $comentarios = Encuesta::whereIn('Question_2', [1, 2])
            ->whereNotNull('Question_3')
            ->where('Question_3', '!=', '')
            ->pluck('Question_3');

        if ($comentarios->isEmpty()) {
            return 'N/A';
        }

        // Análisis simple: tomar el comentario más reciente de un detractor
        // En una implementación más avanzada, podrías usar NLP para categorizar
        $comentarioReciente = Encuesta::whereIn('Question_2', [1, 2])
            ->whereNotNull('Question_3')
            ->where('Question_3', '!=', '')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($comentarioReciente && $comentarioReciente->Question_3) {
            // Limitar a 100 caracteres
            return strlen($comentarioReciente->Question_3) > 100 
                ? substr($comentarioReciente->Question_3, 0, 97) . '...'
                : $comentarioReciente->Question_3;
        }

        return 'N/A';
    }

    /**
     * Obtener métricas completas del resumen
     */
    public function obtenerMetricasResumen()
    {
        return [
            'exito_busqueda' => $this->calcularExitoBusqueda(),
            'promedio_recomendacion' => $this->calcularPromedioRecomendacion(),
            'usuarios_detractores' => $this->calcularUsuariosDetractores(),
            'foco_mejora' => $this->obtenerFocoMejora(),
        ];
    }

    /**
     * Obtener datos para gráfico de últimos 7 días
     */
    public function obtenerEncuestasPorDia()
    {
        $datos = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i);
            $count = Encuesta::whereDate('created_at', $fecha)->count();
            
            $datos[] = [
                'fecha' => $fecha->format('d/m'),
                'count' => $count
            ];
        }

        return $datos;
    }

    /**
     * Obtener datos para gráfico de últimos 6 meses
     */
    public function obtenerEncuestasPorMes()
    {
        $datos = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $count = Encuesta::whereYear('created_at', $fecha->year)
                           ->whereMonth('created_at', $fecha->month)
                           ->count();
            
            $datos[] = [
                'mes' => $fecha->locale('es')->isoFormat('MMM'),
                'count' => $count
            ];
        }

        return $datos;
    }
}