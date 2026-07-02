<?php

namespace App\Livewire\Pages\Admin\Alianzas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Alianza;
use Illuminate\Support\Str;

class CreateAlianza extends Component
{
    use WithFileUploads;

    public $titulo;
    public $imagen;
    public $enlace;
    public $descripcion;
    public $categoria;
    public $activo = true;
    public $orden = 0;

    // Opciones predefinidas para la categoría (clave => etiqueta)
    public $categoriaOptions = [
        'colegio de profesionales' => 'Colegio de Profesionales',
        'universidad e instituto' => 'Universidad e Instituto',
        'empresas' => 'Empresas',
    ];

    public $imageFileExt;
    public $imageFileSize;

    public function mount()
    {
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
        return [
            'titulo'        => 'required|string|max:255',
            'imagen'        => 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024,
            'enlace'        => 'nullable|url|max:255',
            'descripcion'   => 'nullable|string|max:224',
            'categoria'    => 'nullable|in:' . implode(',', array_keys($this->categoriaOptions)),
            'activo'        => 'boolean',
            'orden'         => 'nullable|integer|min:0',
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

        if ($this->imagen) {
            $random = Str::random(30);
            $ext = $this->imagen->getClientOriginalExtension();
            $this->imagen->storeAs('public/optionbuilder/uploads', $random . '.' . $ext);
            $validated['imagen'] = 'optionbuilder/uploads/' . $random . '.' . $ext;
        }

        $validated['orden'] = $validated['orden'] ?? 0;

        Alianza::create($validated);

        return redirect()->route('admin.alianzas-listing');
    }

    public function updatedImagen()
    {
        $this->validate([
            'imagen' => 'required|mimes:' . $this->imageFileExt . '|max:' . $this->imageFileSize * 1024,
        ]);
    }

    public function updateActivo($checked)
    {
        $this->activo = (bool) $checked;
    }
}
