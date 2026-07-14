<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SlotBooking;
use App\Models\User;
use App\Services\ImagenesService;
use App\Services\SlotBookingService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class TutoriasDetalles extends Component
{
    use WithFileUploads;

    public $selectedBookingId = null;
    public $newMaterial = null;
    public $firstBooking = null;

    // Puedes pasar este array de 5 datos al montar el componente
    public function mount()
    {
        // Si hay reservas, seleccionamos automáticamente la primera por defecto
        $firstBooking = $this->getBookingsByRol()->first();
        if ($firstBooking) {
            $this->selectedBookingId = $firstBooking->id;
            $this->firstBooking = $firstBooking->id; // Guardamos el ID de la primera reserva
        }
    }
    public function getBookingsByRol(){
        if(auth()->user()->hasRole("student")) {
            return (new SlotBookingService())->getStudentUpcomingTutorias();
        }elseif(auth()->user()->hasRole("tutor")) {
            return (new SlotBookingService())->getSlotBookingsTutor();
        }
    }
    // Propiedad computada para obtener las reservas (cargando relaciones de materia y tutor si las tienes)
    public function getBookingsProperty()
    {
        return $this->getBookingsByRol();
    }

    // Obtener la reserva seleccionada actualmente
    public function getSelectedBookingProperty()
    {
        if (!$this->selectedBookingId) {
                return null;
            }
        return $this->getBookingsByRol()->firstWhere('id', $this->selectedBookingId);
    }

    // Cambiar la sesión activa en el panel derecho
    public function selectBooking($id)
    {
        $this->selectedBookingId = $id;
        $this->reset('newMaterial'); // Limpiar el input de carga
    }

    // Subir un nuevo archivo de apoyo y actualizar la columna 'supporting_material'
    public function updatedNewMaterial(ImagenesService $imagenesService)
    {
        $this->validate([
            'newMaterial' => 'required|file|max:5120|mimes:pdf,xlsx,doc,docx,png,jpg,jpeg', // Máx 5MB
        ]);

        
        
    }
    
    public function UserData($iduser){
        return  User::find($iduser)->profile()->first();    

    }

    #[On('archivo-agregado')]
    public function saveFileEvent($archivo_temporal=null, $description=null){
        // dd("Llego",$archivo_temporal, $description);    
        $booking = SlotBooking::find($this->selectedBookingId);

        if ($booking) {
            // Si ya tenía un material subido anteriormente, lo borramos del disco
            if ($booking->supporting_material && Storage::disk('public')->exists($booking->supporting_material)) {
                Storage::disk('public')->delete($booking->supporting_material);
            }
            
            // Actualizar la base de datos con la ruta exacta tal como se ve en tu captura
            $booking->update([
                'supporting_material' => $archivo_temporal["supporting_material"]??null,
                "originName"=> $archivo_temporal["originName"]??null,
                "extencion"=> $archivo_temporal["extencion"]??null,
                'description'=> $description,
            ]);

            $this->reset('newMaterial');
        }
    }


    // Descargar el archivo actual
    public function downloadMaterial()
    {
        $booking = $this->selectedBooking;
        
        if ($booking && $booking->supporting_material && Storage::disk('public')->exists($booking->supporting_material)) {
            return Storage::disk('public')->download(
                $booking->supporting_material, 
                $booking->originName
            );
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
                'supporting_material' => null,
                'description'=> null,
                'originName'=> null,
                'extencion'=> null,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tutorias-detalles', [
            'slotBookings' => $this->bookings,
            'selectedBooking' => $this->selectedBooking,
        ])->layout('layouts.app');;
    }

}
