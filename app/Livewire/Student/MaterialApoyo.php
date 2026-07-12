<?php


namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SlotBooking;
use App\Models\User;
use App\Services\SlotBookingService;
use Illuminate\Support\Facades\Storage;

class MaterialApoyo extends Component
{
    use WithFileUploads;

    public $selectedBookingId = null;
    public $newMaterial = null;

    // Puedes pasar este array de 5 datos al montar el componente
    public function mount()
    {
        // Si hay reservas, seleccionamos automáticamente la primera por defecto
        if(auth()->user()->hasRole("student")) {
            $firstBooking = $this->getBookingsProperty()->first();
            if ($firstBooking) {
                $this->selectedBookingId = $firstBooking->id;
            }
        }elseif(auth()->user()->hasRole("tutor")) {
            $firstBooking = $this->getBookingsTutor()->first();
            if ($firstBooking) {
                $this->selectedBookingId = $firstBooking->id;
            }
        }
    }

    public function getBookingsTutor(){
        return (new SlotBookingService())->getSlotBookingByUserId();
    }
    // Propiedad computada para obtener las reservas (cargando relaciones de materia y tutor si las tienes)
    public function getBookingsProperty()
    {
        return (new SlotBookingService())->getStudentUpcomingTutorias();
    }

    // Obtener la reserva seleccionada actualmente
    public function getSelectedBookingProperty()
    {
        if (!$this->selectedBookingId) {
                return null;
            }
        if(auth()->user()->hasRole("student")) {

            return $this->getBookingsProperty()->firstWhere('id', $this->selectedBookingId);

        } elseif(auth()->user()->hasRole("tutor")) {
            
            return $this->getBookingsTutor()->firstWhere('id', $this->selectedBookingId);
        };

        
    }

    // Cambiar la sesión activa en el panel derecho
    public function selectBooking($id)
    {
        $this->selectedBookingId = $id;
        $this->reset('newMaterial'); // Limpiar el input de carga
    }

    // Subir un nuevo archivo de apoyo y actualizar la columna 'supporting_material'
    public function updatedNewMaterial()
    {
        $this->validate([
            'newMaterial' => 'required|file|max:10240|mimes:pdf,doc,docx,png,jpg,jpeg', // Máx 10MB
        ]);

        $booking = SlotBooking::find($this->selectedBookingId);

        if ($booking) {
            // Si ya tenía un material subido anteriormente, lo borramos del disco
            if ($booking->supporting_material && Storage::disk('public')->exists($booking->supporting_material)) {
                Storage::disk('public')->delete($booking->supporting_material);
            }

            // Guardar el nuevo archivo en la carpeta 'materiales_apoyo' en el storage público
            $path = $this->newMaterial->store('materiales_apoyo', 'public');

            // Actualizar la base de datos con la ruta exacta tal como se ve en tu captura
            $booking->update([
                'supporting_material' => $path
            ]);

            $this->reset('newMaterial');
        }
    }
    public function UserData($iduser){
        return  User::find($iduser)->profile()->first();    

    }
    // Descargar el archivo actual
    public function downloadMaterial()
    {
        $booking = $this->selectedBooking;
        
        if ($booking && $booking->supporting_material && Storage::disk('public')->exists($booking->supporting_material)) {
            return Storage::disk('public')->download($booking->supporting_material);
        }
    }

    // Eliminar el archivo de apoyo actual
    public function deleteMaterial()
    {
        $booking = SlotBooking::find($this->selectedBookingId);

        if ($booking && $booking->supporting_material) {
            // Borrar físicamente del storage
            if (Storage::disk('public')->exists($booking->supporting_material)) {
                Storage::disk('public')->delete($booking->supporting_material);
            }

            // Dejar el campo nulo en la BD
            $booking->update([
                'supporting_material' => null
            ]);
        }
    }

    public function render()
    {
        return view('livewire.student.material-apoyo', [
            'slotBookings' => $this->bookings,
            'selectedBooking' => $this->selectedBooking,
        ])->layout('layouts.app');;
    }
}