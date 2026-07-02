<?php

namespace App\Livewire\Pages\Admin\Alianzas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Models\Alianza;

class Alianzas extends Component
{
    use WithPagination;

    public $search = '';
    public $sortby = 'desc';
    public $perPage = 10;

    public $selectedAlianzas = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->perPage = setting('_general.per_page_record') ?? 10;
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.alianzas', [
            'alianzas' => $this->alianzas,
        ]);
    }

    #[Computed]
    public function alianzas()
    {
        $query = Alianza::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('titulo', 'LIKE', "%{$this->search}%")
                  ->orWhere('enlace', 'LIKE', "%{$this->search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$this->search}%")
                    ->orWhere('categoria', 'LIKE', "%{$this->search}%");
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
            $this->selectedAlianzas = $this->alianzas->pluck('id')->toArray();
        } else {
            $this->selectedAlianzas = [];
        }
    }

    public function updatedSelectedAlianzas()
    {
        $this->selectAll = false;
    }

    #[On('delete-alianza')]
    public function delete($params = [])
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        if (!empty($params['id'])) {
            Alianza::findOrFail($params['id'])->delete();
            $message = __('general.deleted_alianza');
        } elseif (!empty($this->selectedAlianzas)) {
            Alianza::whereIn('id', $this->selectedAlianzas)->delete();
            $message = __('general.deleted_alianza');
        } else {
            return;
        }

        $this->selectedAlianzas = [];
        $this->dispatch('showAlertMessage', type: 'success', message: $message ?? __('general.deleted_alianza'));
    }

    public function toggleStatus($id)
    {
        $alianza = Alianza::findOrFail($id);
        $alianza->activo = !$alianza->activo;
        $alianza->save();
    }
}
