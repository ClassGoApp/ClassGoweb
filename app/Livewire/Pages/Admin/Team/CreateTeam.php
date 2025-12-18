<?php

namespace App\Livewire\Pages\Admin\Team;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\TeamMember;
use Illuminate\Support\Str;

class CreateTeam extends Component
{
    use WithFileUploads;

    public $name;
    public $last_name;
    public $role;
    public $photo;
    public $platform;
    public $platform_link;
    public $order = 0;
    
    // Estado activo por defecto
    public $status = true;

    public $imageFileExt;
    public $imageFileSize;

    public function mount()
    {
        // VISTA VISUAL: Definimos esto para que el texto en pantalla muestre "webp" al usuario.
        $this->imageFileExt = 'jpg,png,jpeg,gif,webp';
        
        $this->imageFileSize = (int) (setting('_general.max_image_size') ?? '5');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.team.create-team');
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'role'          => 'required|string|max:255',
            
            // VALIDACIÓN EXPLÍCITA: Escribimos manualmente las extensiones permitidas.
            // Esto anula cualquier configuración restrictiva que venga de la base de datos.
            'photo'         => 'required|mimes:jpg,jpeg,png,gif,webp|max:' . ($this->imageFileSize * 1024),
            
            'platform'      => 'nullable|string|max:100',
            'platform_link' => 'nullable|url|max:255',
            'order'         => 'nullable|integer|min:0',
            'status'        => 'boolean',
        ];
    }

    public function store()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $validated = $this->validate();

        if ($this->photo) {
            $random = Str::random(30);
            $ext = $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('public/optionbuilder/uploads', $random . '.' . $ext);
            $validated['photo'] = 'optionbuilder/uploads/' . $random . '.' . $ext;
        }

        // Aseguramos valores por defecto si vienen vacíos
        $validated['order'] = $validated['order'] ?? 0;
        
        TeamMember::create($validated);

        return redirect()->route('admin.team-listing');
    }

    public function updatedPhoto()
    {
        // VALIDACIÓN EN TIEMPO REAL: También forzada manualmente.
        $this->validate([
            'photo' => 'required|mimes:jpg,jpeg,png,gif,webp|max:' . ($this->imageFileSize * 1024),
        ]);
    }
}