<?php

namespace App\Livewire\Pages\Admin\Recruitment;

use App\Models\Recruitment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class RecruitmentListing extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    protected $paginationTheme = 'bootstrap';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $recruitment = Recruitment::findOrFail($id);
        if ($recruitment->cv_path) {
            Storage::disk('public')->delete($recruitment->cv_path);
        }
        $recruitment->delete();
        session()->flash('success', 'Postulación eliminada correctamente.');
    }

    public function updateStatus($id, $status)
    {
        $recruitment = Recruitment::findOrFail($id);
        $recruitment->update(['status' => $status]);
        session()->flash('success', 'Estado actualizado.');
    }

    public function render()
    {
        $recruitments = Recruitment::query()
            ->when($this->search, function($query) {
                $query->where('full_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.admin.recruitment.recruitment-listing', [
            'recruitments' => $recruitments
        ])->layout('layouts.admin-app');
    }
}
