<?php

namespace App\Livewire\Admin;

use App\Models\SlotBooking;
use App\Services\GoogleMeetService;
use App\Services\SlotBookingService;
use App\Services\MailService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class TutoriasTable extends Component
{
    use WithPagination;

    public $tutor = '';
    public $student = '';
    public $status = '';
    public $perPage = 10;
    public $showModal = false;
    public $modalTutoriaId;
    public $modalStatus;
    public $fecha; // Para una sola fecha
    public $fecha_inicio;
    public $fecha_fin;
    public $modalPaymentStatus;
    public $modalPaymentMethod;
    public $modalPaymentMessage;
    public $modalPaymentId;
    public $successMessage = '';
    public $errorMessage = '';


    public function updating($property)
    {
        if (in_array($property, ['tutor', 'student', 'status'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = SlotBooking::with(['tutor', 'student', 'paymentSlotBooking', 'payment']);
        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->tutor) {
            $query->whereHas('tutor', function ($q) {
                $q->where('first_name', 'like', '%' . $this->tutor . '%');
            });
        }

        if ($this->student) {
            $query->whereHas('student', function ($q) {
                $q->where('first_name', 'like', '%' . $this->student . '%');
            });
        }

        if ($this->status) {
            $this->status = $this->estado($this->status);
            $query->where('status', $this->status);
        }

        // Filtro por una sola fecha
        if ($this->fecha) {
            $query->whereDate('start_time', $this->fecha);
        } elseif ($this->fecha_inicio && $this->fecha_fin) {
            $query->whereBetween('start_time', [$this->fecha_inicio, $this->fecha_fin . ' 23:59:59']);
        }
        $tutorias = $query->orderByDesc('start_time')->paginate($this->perPage);

        return view('livewire.admin.tutorias-table', compact('tutorias'));
    }



    public function estado($status)
    {
        switch ($status) {
            case 'pendiente':
                return 2;
            case 'aceptado':
                return 1;
            case 'no_completado':
                return 3;
            case 'rechazado':
                return 4;
            case 'completado':
                return 5;
            default:
                return 'Desconocido';
        }

    }

    public function abrirModalTutoria($id, $status)
    {
        $map = [
            1 => 'aceptado',
            2 => 'pendiente',
            3 => 'no_completado',
            4 => 'rechazado',
            5 => 'completado',
        ];
        $this->modalTutoriaId = $id;
        $this->modalStatus = $map[$status] ?? 'pendiente';
    }

    public function updateStatus()
    {
        $tutoria = SlotBooking::find($this->modalTutoriaId);
        if ($tutoria) {
            // Guardar el estado anterior para el evento
            $oldStatus = $tutoria->status;
            
            $estados = [
                'aceptado' => 1,
                'pendiente' => 2,
                'no_completado' => 3,
                'rechazado' => 4,
                'completado' => 5,
                'cursando' => 6,
            ];
            $nuevoStatus = $this->modalStatus;
            if (!is_numeric($nuevoStatus)) {
                $nuevoStatus = $estados[strtolower($nuevoStatus)] ?? 2;
            }
            $tutoria->status = $nuevoStatus;
            $link = null;
            
            // Si el nuevo estado es 'Aceptada' (1), crear reunión Zoom y enviar correos
            if ($nuevoStatus == 1) {
                $link = $this->tutoriaaceptada($tutoria);
                $tutoria->meeting_link = $link;
            }
            
            // Guardar el estado en la base de datos
            $tutoria->save();
            
            // Emitir evento de broadcasting para la app móvil
            event(new \App\Events\SlotBookingStatusChanged($tutoria->id, $nuevoStatus));
            
            Log::info('TutoriasTable: Estado actualizado y evento emitido', [
                'tutoria_id' => $tutoria->id,
                'old_status' => $oldStatus,
                'new_status' => $nuevoStatus,
                'meeting_link' => $link
            ]);
        }
        $this->dispatch('cerrar-modal-tutoria');
    }


    public function tutoriaaceptada($tutoria)
    {
        $reservaservice = new SlotBookingService();
        $link = $reservaservice->generarlink($tutoria);
          return $link;
    }

    public function clearFilters()
    {
        $this->reset(['tutor', 'student', 'fecha', 'fecha_inicio', 'fecha_fin', 'status']);
    }

    public function abrirModalPagoTutor($tutoria)
    {
        $bookingId = is_array($tutoria) ? $tutoria['id'] : $tutoria->id;
        $pago = \App\Models\SlotPayment::where('slot_booking_id', $bookingId)->first();
        if ($pago) {
            $this->modalPaymentId = $pago->id;
            $this->modalPaymentStatus = $pago->status;
            $this->modalPaymentMethod = $pago->payment_method;
            $this->modalPaymentMessage = $pago->message;
        }
    }

    public function updatePayment()
    {

        try {
            $pago = \App\Models\SlotPayment::find($this->modalPaymentId);
            //dd($pago,"adahsgdas");
            if ($pago) {
                $estadoActual = (int) $pago->status;
                $nuevoEstado = (int) $this->modalPaymentStatus;
                // Definir transiciones válidas
                $transicionesValidas = [
                    1 => [2, 3], // pendiente -> pagado u observado
                    3 => [2, 4], // observado -> pagado o cancelado
                ];
                // Si la transición no es válida, mostrar error y salir
                if (
                    ($estadoActual !== $nuevoEstado) && (
                        !isset($transicionesValidas[$estadoActual]) ||
                        !in_array($nuevoEstado, $transicionesValidas[$estadoActual])
                    )
                ) {
                    $this->errorMessage = 'Transición de estado no válida.';

                    $this->dispatch('cerrar-modal-pago-tutor');
                    $this->dispatch('mostrar-modal-error', ['message' => $this->errorMessage]);
                    return;
                }
                $pago->status = $nuevoEstado;
                $pago->payment_method = $this->modalPaymentMethod;
                $pago->message = $this->modalPaymentMessage;
                $pago->save();
                $this->dispatch('cerrar-modal-pago-tutor');
            }
            $this->successMessage = 'Pago actualizado correctamente.';
            $this->dispatch('mostrar-modal-success', ['message' => $this->successMessage]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el pago: ' . $e->getMessage());
            $this->dispatch('mostrar-mensaje-error', ['message' => 'Error al actualizar el pago.']);
        }
    }

    public function cerrarModalTutoria()
    {
        $this->showModal = false;
    }
}
