<?php

namespace App\Livewire\Promociones;

use App\Models\Coupon;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Cupones extends Component
{
    use WithPagination;
    public $search = '';
    public $form = [
        'nombre'          => '',
        'codigo'          => '',
        'fecha_caducidad' => '',
        'estado'          => '',
        'descuento'       => null,
        'cantidad'        => null,
        'referencia'      => '',
    ];

    public $formMultiple = [
        'nombre'          => '',
        'fecha_caducidad' => '',
        'estado'          => '',
        'descuento'       => null,
        'cantidad_generar'=> null,
    ];

    public $exportFilters = [
        'nombre' => '',
        'fecha' => '',
    ];
     /*** NUEVO: estado para acciones ***/
    public $selectedId = null;
    public $action = null;              // 'delete' | 'toggle'
    public $newFechaCaducidad = null;   // edita fecha
    public $filterUser = null;
    protected function rules()
    {
        return [
            'form.nombre'          => 'required|string|max:255',
            'form.codigo'          => ['required','string','max:8'],
            // si puede ir vacía:
            'form.fecha_caducidad' => 'nullable|date|after_or_equal:today',
            'form.estado'          => ['required', Rule::in(['activo','inactivo'])],
            'form.descuento'       => 'required|numeric|min:0|max:999999.99',
            'form.cantidad'        => 'required|integer|min:0',
            // aceptas 0 y negativos en tu lógica -> sin min
            'form.referencia'      => 'required|integer',
        ];
    }
   

    protected $messages = [
        'form.codigo.unique' => 'El código ya existe.',
        'form.fecha_caducidad.after_or_equal' => 'La fecha debe ser hoy o futura.',
    ];
    #[Layout('layouts.admin-app')]
    public function render()
    {
       $q = Coupon::query()
            ->when($this->search, fn($qq) =>
                $qq->where(function($w){
                    $w->where('nombre','like',"%{$this->search}%")
                      ->orWhere('codigo','like',"%{$this->search}%")
                      ->orWhere('referencia','like',"%{$this->search}%");
                })
            )
            ->when($this->filterUser === 'active', fn($qq) => $qq->where('estado','activo'))
            ->when($this->filterUser === 'inactive', fn($qq) => $qq->where('estado','inactivo'))
            ->latest('id');

        $cupones = $q->paginate(10);
        return view('livewire.promociones.cupones', compact('cupones'));
    }

     /*********** ACCIONES ***********/
    public function openConfirm(int $id, string $action) // 'delete' o 'toggle'
    {
        $this->selectedId = $id;
        $this->action     = $action;
        $this->dispatch('open-bs-modal', id: 'confirmModal');  // JS mostrará el modal
    }
    public function generarCodigoUnico()
    {
        do {
            $letras = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
            $numeros = substr(str_shuffle("0123456789"), 0, 4);
            $codigo = $letras . $numeros;
        } while (Coupon::where('codigo', $codigo)->exists());

        return $codigo;
    }

    public function saveCoupon()
    {
        $this->validate();

        Coupon::create([
            'nombre'          => $this->form['nombre'],
            'codigo'          => $this->form['codigo'],
            'fecha_caducidad' => $this->form['fecha_caducidad'],
            'estado'          => $this->form['estado'],
            'descuento'       => $this->form['descuento'],
            'cantidad'        => $this->form['cantidad'],
            'referencia'      => $this->form['referencia'],
        ]);

        $this->dispatch('toast', type:'success', message: __('general.saved_ok'));
        $this->reset('form');
        $this->dispatch('close-bs-modal', id: 'tb-add-user');
    }

    public function saveMultipleCoupons()
    {
        $this->validate([
            'formMultiple.nombre'          => 'required|string|max:255',
            'formMultiple.fecha_caducidad' => 'nullable|date|after_or_equal:today',
            'formMultiple.estado'          => ['required', Rule::in(['activo','inactivo'])],
            'formMultiple.descuento'       => 'required|numeric|min:0|max:999999.99',
            'formMultiple.cantidad_generar'=> 'required|integer|min:2|max:500',
        ]);

        $creados = 0;

        for ($i = 0; $i < $this->formMultiple['cantidad_generar']; $i++) {
            $exito = false;
            $intentos = 0;
            $maxIntentos = 3;

            while (!$exito && $intentos < $maxIntentos) {
                try {
                    Coupon::create([
                        'nombre'          => $this->formMultiple['nombre'],
                        'codigo'          => $this->generarCodigoUnico(),
                        'fecha_caducidad' => $this->formMultiple['fecha_caducidad'],
                        'estado'          => $this->formMultiple['estado'],
                        'descuento'       => $this->formMultiple['descuento'],
                        'cantidad'        => 1,
                        'referencia'      => 0,
                    ]);
                    // Si se crea sin arrojar excepción, marcamos éxito
                    $exito = true;
                    $creados++;
                } catch (\Illuminate\Database\QueryException $e) {
                    // Validamos si la excepción fue por restricción Unique de la BD: 
                    // código SQLSTATE 23000 o código driver 1062/19 (MySQL/SQLite)
                    if ($e->getCode() == '23000' || (isset($e->errorInfo[1]) && in_array($e->errorInfo[1], [1062, 19]))) {
                        $intentos++;
                        // El ciclo while volverá a iterar para intentar guardar un nuevo código para este mismo progreso en el for
                    } else {
                        // Si el error no es por código duplicado, la base de datos tiene otro problema grave.
                        throw $e;
                    }
                }
            }
        }

        if ($creados < $this->formMultiple['cantidad_generar']) {
            $this->dispatch('toast', type:'warning', message: "Se han creado $creados de los {$this->formMultiple['cantidad_generar']} cupones. Hubo exceso de colisiones.");
        } else {
            $this->dispatch('toast', type:'success', message: __('general.saved_ok'));
        }
        
        $this->reset('formMultiple');
        $this->dispatch('close-bs-modal', id: 'tb-add-multiple');
    }

    public function exportarWord()
    {
        if (!class_exists('\PhpOffice\PhpWord\PhpWord')) {
            $this->dispatch('toast', type:'error', message: 'Fijate que falte la librería PhpWord. Instálala con composer require phpoffice/phpword');
            return;
        }

        $query = Coupon::query();

        if (!empty($this->exportFilters['nombre'])) {
            $query->where('nombre', 'like', '%' . $this->exportFilters['nombre'] . '%');
        }

        if (!empty($this->exportFilters['fecha'])) {
            $query->whereDate('fecha_caducidad', $this->exportFilters['fecha']);
        }

        $cupones = $query->latest('id')->get();

        if ($cupones->isEmpty()) {
            $this->dispatch('toast', type:'error', message: 'No hay cupones para descargar con esos filtros.');
            return;
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $section->addText('Codigos de Cupones Generados', ['name' => 'Arial', 'size' => 16, 'bold' => true]);
        
        if (!empty($this->exportFilters['nombre']) || !empty($this->exportFilters['fecha'])) {
            $filtros = "Filtros aplicados: ";
            if (!empty($this->exportFilters['nombre'])) $filtros .= "Nombre: ".$this->exportFilters['nombre']." | ";
            if (!empty($this->exportFilters['fecha'])) $filtros .= "Fecha: ".$this->exportFilters['fecha'];
            $section->addText($filtros, ['size' => 10, 'italic' => true]);
        }
        
        $section->addTextBreak(1);

        $contador = 1;
        foreach ($cupones as $c) {
            $section->addText($contador . " - " . $c->codigo, ['name' => 'Courier New', 'size' => 12]);
            $contador++;
        }

        $fileName = 'cupones_'.date('Ymd_His').'.docx';
        $tempPath = storage_path('app/public/' . $fileName);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempPath);

        $this->dispatch('close-bs-modal', id: 'tb-export-word');

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
    public function performConfirmedAction()
    {
        $coupon = Coupon::findOrFail($this->selectedId);

        if ($this->action === 'delete') {
            $coupon->delete();
            $this->dispatch('toast', type:'success', message: __('general.deleted_ok'));
        }

        if ($this->action === 'toggle') {
            $coupon->estado = $coupon->estado === 'activo' ? 'inactivo' : 'activo';
            $coupon->save();
            $this->dispatch('toast', type:'success', message: __('general.updated_ok'));
        }

        $this->reset(['selectedId','action']);
        $this->dispatch('close-bs-modal', id: 'confirmModal');
    }
    public function openFecha(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->selectedId        = $coupon->id;
        $this->newFechaCaducidad = optional($coupon->fecha_caducidad)->format('Y-m-d');
        $this->dispatch('open-bs-modal', id: 'fechaModal');
    }

    public function saveFecha()
    {
        $this->validate([
            'newFechaCaducidad' => ['nullable','date'],
        ]);

        $coupon = Coupon::findOrFail($this->selectedId);
        $coupon->fecha_caducidad = $this->newFechaCaducidad ? Carbon::parse($this->newFechaCaducidad) : null;
        $coupon->save();

        $this->dispatch('toast', type:'success', message: __('general.updated_ok'));
        $this->reset(['selectedId','newFechaCaducidad']);
        $this->dispatch('close-bs-modal', id: 'fechaModal');
    }
    public function referencia($valor)
    {
        if ($valor == 0) {
            return "Administrador";
        } elseif ($valor < 0) {
            return "De un Solo Uso";
        } else {
            $usuario = User::where('id', $valor)->first();

            return $usuario?->profile->first_name . ' ' . $usuario?->profile->last_name ?? 'Usuario no encontrado';
        }
    }
}
