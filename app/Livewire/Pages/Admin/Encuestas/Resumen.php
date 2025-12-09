<?php

namespace App\Livewire\Pages\Admin\Encuestas;

use App\Services\EncuestaService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Resumen extends Component
{
    public $metricas = [];
    public $estadisticas = [];
    public $encuestasPorDia = [];
    public $encuestasPorMes = [];
    public $distribucionUsuarios = [];

    public function mount(EncuestaService $encuestaService)
    {
        // Cargar métricas del resumen
        $this->metricas = $encuestaService->obtenerMetricasResumen();
        
        // Cargar estadísticas generales
        $this->estadisticas = $encuestaService->obtenerEstadisticas();
        
        // Cargar datos para gráficos
        $this->encuestasPorDia = $encuestaService->obtenerEncuestasPorDia();
        $this->encuestasPorMes = $encuestaService->obtenerEncuestasPorMes();
        $this->distribucionUsuarios = $encuestaService->obtenerDistribucionUsuarios();
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.encuestas.resumen');
    }
}
