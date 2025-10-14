<?php

namespace App\Livewire;

use App\Models\Personal;
use Livewire\Component;

class GestionPersonal extends Component
{

    public $personal;
    
    public function mount()
    {
        $this->personal = Personal::all();
    }

    public function render()
    {
        return view('livewire.gestion-personal', [
            'personal' => $this->personal
        ]);
    }
}
