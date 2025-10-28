<?php

namespace App\Http\Controllers;
use App\Services\FloatingService;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

class FloatingButtonController extends Controller
{
    protected $floatingService;

    public function __construct(FloatingService $floatingService)
    {
        $this->middleware('auth'); // Solo usuarios autenticados
        $this->floatingService = $floatingService;
    }

    /**
     * Obtener conteo de tutorías aceptadas para el tutor
     */
    public function getTutoriasAceptadas(): JsonResponse
    {
        try {
            // Verificar que sea tutor
            if (!auth()->user()->hasRole('tutor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado - Solo tutores'
                ], 403);
            }

            $count = $this->floatingService->getTutoriasAceptadasCount();
            
            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => 'Tutorías aceptadas obtenidas exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tutorías aceptadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener datos para el floating button (método más general)
     */
    public function getData(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            if ($user->hasRole('tutor')) {
                $count = $this->floatingService->getTutoriasAceptadasCount();
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'user_type' => 'tutor',
                        'tutorias_aceptadas' => $count,
                        'user_name' => $user->first_name
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'user_type' => 'other',
                        'tutorias_aceptadas' => 0
                    ]
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos'
            ], 500);
        }
    }

}
