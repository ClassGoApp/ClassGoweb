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
