<?php

namespace App\Livewire\Pages\Admin\Encuestas;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Resumen extends Component
{
    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.encuestas.resumen');
    }
}
