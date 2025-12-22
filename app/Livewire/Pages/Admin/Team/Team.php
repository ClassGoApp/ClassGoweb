<?php

namespace App\Livewire\Pages\Admin\Team;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\TeamMember;

class Team extends Component
{
    use WithPagination;

    public $search = '';
    public $sortby = 'desc';
    public $perPage = 10;

    public $selectedTeams = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.team.team', [
            'teams' => $this->teams,
        ]);
    }

    #[Computed]
    public function teams()
    {
        $query = TeamMember::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', "%{$this->search}%")
                  ->orWhere('last_name', 'LIKE', "%{$this->search}%")
                  ->orWhere('role', 'LIKE', "%{$this->search}%");
            });
        }

        return $query->orderBy('id', $this->sortby)->paginate($this->perPage);
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedTeams = $this->teams->pluck('id')->toArray();
        } else {
            $this->selectedTeams = [];
        }
    }

    public function updatedSelectedTeams()
    {
        $this->selectAll = false;
    }

    #[On('delete-team')]
    public function delete($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!empty($params['id'])) {
            TeamMember::findOrFail($params['id'])->delete();
            $message = 'Miembro eliminado correctamente';
        } elseif (!empty($this->selectedTeams)) {
            TeamMember::whereIn('id', $this->selectedTeams)->delete();
            $message = 'Miembros eliminados correctamente';
        } else {
            return;
        }

        $this->selectedTeams = [];
        $this->dispatch('showAlertMessage', type: 'success', message: $message);
    }

    // --- NUEVO: Cambio de estado rápido desde la tabla ---
    public function toggleStatus($id)
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $member = TeamMember::findOrFail($id);
        $member->status = !$member->status; // Invierte el valor (true a false y viceversa)
        $member->save();

        $this->dispatch('showAlertMessage', type: 'success', message: 'Estado actualizado correctamente.');
    }
}