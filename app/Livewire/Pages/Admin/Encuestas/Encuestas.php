<?php

namespace App\Livewire\Pages\Admin\Encuestas;
use App\Models\Encuesta;
use App\Services\EncuestaService;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Encuestas extends Component
{
    use WithPagination;
    protected $encuestaService;

    //propiedades publicas
    public $search = '';
    public $sortby = 'desc';
    public $perPage = 10;
    public $estadisticas = [];
    protected $queryString = [
        'search' => ['except' => ''],
        'sortby' => ['except' => 'desc']
    ];

    public function boot(EncuestaService $encuestaService){
        $this->encuestaService = $encuestaService;
    }

    public function mount(){
        $this->estadisticas = $this->encuestaService->obtenerEstadisticas();
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        // Obtener encuestas con búsqueda y paginación
        $encuestas = Encuesta::query()
            ->with('user.profile:id,user_id,first_name,last_name') // Cargar relación de usuario con perfil
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('Question_1', 'like', '%' . $this->search . '%')
                      ->orWhere('Question_2', 'like', '%' . $this->search . '%')
                      ->orWhere('Question_3', 'like', '%' . $this->search . '%')
                      ->orWhere('Contact', 'like', '%' . $this->search . '%')
                      ->orWhere('IdUser', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', $this->sortby)
            ->paginate($this->perPage);

        return view('livewire.pages.admin.encuestas.encuestas', [
            'encuestas' => $encuestas,
            'estadisticas' => $this->estadisticas
        ]);
    }

    // Método para resetear búsqueda
    public function limpiarBusqueda()
    {
        $this->reset(['search']);
    }

    // Método para ver detalle de encuesta
    public function verDetalle($id)
    {
        $encuesta = $this->encuestaService->obtenerEncuestaPorId($id);
        
        if ($encuesta) {
            $this->dispatch('showSurveyDetail', [
                'id' => $encuesta->id,
                'userId' => $encuesta->IdUser,
                'question1' => $encuesta->Question_1,
                'question2' => $encuesta->Question_2,
                'question3' => $encuesta->Question_3,
                'contact' => $encuesta->Contact,
                'date' => $encuesta->created_at->format('d/m/Y H:i'),
            ]);
        }
    }

    public function estadisticasEncuestas(){
        return view('livewire.pages.admin.encuestas.resumen', [
            'estadisticas' => $this->estadisticas
        ]);
    }
}
