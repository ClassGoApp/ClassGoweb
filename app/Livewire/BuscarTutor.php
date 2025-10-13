<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Subject;
use App\Services\SiteService;


class BuscarTutor extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
     public $page = 1;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $paginationTheme = 'tailwind'; // O 'bootstrap' si usas Bootstrap

    public function updatingSearch()
    {
        $this->resetPage();
    }

   // class BuscarTutor extends Component

    public function getFilteredProfiles(SiteService $siteService)
    {
        // Si la búsqueda está vacía, devuelve un paginador vacío para ahorrar recursos
        if (empty($this->search)) {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage, 1);
        }
        
        \Log::info('Buscando tutores con search:', ['search' => $this->search]);
        $result = $siteService->getTutorDato($this->perPage, $this->search);
        
        \Log::info('Total de tutores encontrados:', ['total' => $result->total()]);
        return $result;
    }

    public function render(SiteService $siteService)
    {
        $profiles = $this->getFilteredProfiles($siteService);

        return view('livewire.buscar-tutor', compact('profiles'))
            ->layout('vistas.view.layouts.app');
    }
} 