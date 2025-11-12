<?php

namespace App\Livewire\Pages\Admin\Alianzas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Alianza;
use Illuminate\Support\Str;

class UpdateAlianza extends Component
{
    use WithFileUploads;

    public $alianzaId;
    public $alianza;

    public $titulo;
    public $imagen; // new upload
    public $enlace;
    public $descripcion;
    public $activo = true;
    public $orden = 0;

    public $imageFileExt;
    public $imageFileSize;

    public function mount()
    {
        $this->alianzaId = request()->route('id');
        $this->alianza = Alianza::findOrFail($this->alianzaId);

        $this->titulo = $this->alianza->titulo;
        $this->enlace = $this->alianza->enlace;
        $this->descripcion = $this->alianza->descripcion;
        $this->activo = (bool) $this->alianza->activo;
        $this->orden = $this->alianza->orden;

        $this->imageFileExt = setting('_general.allowed_image_extensions') ?? 'jpg,png,jpeg,webp';
        $this->imageFileSize = (int) (setting('_general.max_image_size') ?? '5');
    }

    #[Layout('layouts.admin-app')]
    public function render()
    {
        return view('livewire.pages.admin.create-alianza');
    }

    public function rules(): array
    {
        $rules = [
            'titulo'        => 'required|string|max:255',
            'enlace'        => 'nullable|url|max:255',
            'descripcion'   => 'nullable|string',
            'activo'        => 'boolean',
            'orden'         => 'nullable|integer|min:0',
        ];

        if (empty($this->alianza->imagen)) {
            $rules['imagen'] = 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024;
        } else {
            $rules['imagen'] = 'nullable|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024;
        }

        return $rules;
    }

    public function update()
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $validated = $this->validate();

        if ($this->imagen) {
            $random = Str::random(30);
            $ext = $this->imagen->getClientOriginalExtension();
            $this->imagen->storeAs('public/optionbuilder/uploads', $random . '.' . $ext);
            $validated['imagen'] = 'optionbuilder/uploads/' . $random . '.' . $ext;
        }

        $this->alianza->update($validated);

        return redirect()->route('admin.alianzas-listing');
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'nullable|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024,
        ]);
    }

    public function updateActivo($checked)
    {
        $this->activo = (bool) $checked;
    }
}
