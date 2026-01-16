<?php

namespace App\Livewire\Pages\Admin\Team;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\TeamMember;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UpdateTeam extends Component
{
    use WithFileUploads;

    public $teamId;
    public $teamMember;

    public $name;
    public $last_name;
    public $role;
    public $photo; // Nueva foto si se sube
    public $platform;
    public $platform_link;
    public $order = 1;
    
    // NUEVO: Variable de estado
    public $status;

    public $imageFileExt;
    public $imageFileSize;

    public function mount($id)
    {
        $this->teamId = $id;
        $this->teamMember = TeamMember::findOrFail($this->teamId);

        // Cargar datos existentes
        $this->name = $this->teamMember->name;
        $this->last_name = $this->teamMember->last_name;
        $this->role = $this->teamMember->role;
        $this->platform = $this->teamMember->platform;
        $this->platform_link = $this->teamMember->platform_link;
        $this->order = $this->teamMember->order;
        
        // Cargar estado desde BD (convertir a bool)
        $this->status = (bool) $this->teamMember->status;

        // MODIFICACIÓN 1: Forzamos la lista de extensiones visuales
        // Ignoramos la base de datos para asegurar que 'webp' se muestre en la interfaz
        $this->imageFileExt = 'jpg,png,jpeg,gif,webp';
        
        $this->imageFileSize = (int) (setting('_general.max_image_size') ?? '5');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        // Reutilizamos la vista create-team pasando el modelo
        return view('livewire.pages.admin.team.create-team', [
            'teamMember' => $this->teamMember
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'role'          => 'required|string|max:255',
            'platform'      => 'nullable|string|max:100',
            'platform_link' => 'nullable|url|max:255',
            'order'         => 'nullable|integer|min:1',
            'status'        => 'boolean',
        ];

        // MODIFICACIÓN 2: Validación "Hardcoded" (Manual)
        // Foto requerida solo si no existe una anterior, pero siempre permitiendo webp
        $extensions = 'mimes:jpg,jpeg,png,gif,webp';
        $maxSize = 'max:' . ($this->imageFileSize * 1024);

        if (empty($this->teamMember->photo)) {
            $rules['photo'] = 'required|' . $extensions . '|' . $maxSize;
        } else {
            $rules['photo'] = 'nullable|' . $extensions . '|' . $maxSize;
        }

        return $rules;
    }

    public function update() // Renombrado de store() a update() ya que es edición
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $validated = $this->validate();

        // Lógica de imagen
        if ($this->photo) {
            // Borrar imagen anterior si existe físicamente
            if ($this->teamMember->photo && Storage::exists('public/'.$this->teamMember->photo)) {
                Storage::delete('public/'.$this->teamMember->photo);
            }

            $random = Str::random(30);
            $ext = $this->photo->getClientOriginalExtension();
            $this->photo->storeAs('public/optionbuilder/uploads', $random . '.' . $ext);
            $validated['photo'] = 'optionbuilder/uploads/' . $random . '.' . $ext;
        }

        $this->teamMember->update($validated);

        return redirect()->route('admin.team-listing');
    }

    public function updatedPhoto()
    {
        // MODIFICACIÓN 3: Validación en tiempo real forzada
        $this->validate([
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif,webp|max:' . ($this->imageFileSize * 1024),
        ]);
    }
}