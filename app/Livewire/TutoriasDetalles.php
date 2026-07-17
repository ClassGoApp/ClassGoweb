<?php

namespace App\Livewire;

use App\Models\Attachment;
use App\Services\AttachmentsService;
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
    public $mostrarBotonSubida = false;

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
    
    // Reseteamos el botón dinámico cuando el usuario cambie de tutoría seleccionada
    

    // Obtener la reserva seleccionada actualmente
    public function getSelectedBookingProperty()
    {
        if (!$this->selectedBookingId) {
                return null;
            }
            
        return $this->getBookingsByRol()->firstWhere('id', $this->selectedBookingId);
    }

    // ESCUCHADOR: Cuando el modal termine de guardar o actualizar, forzamos la reactividad
    #[On('ReservacionConfirmada')]
    public function refrescarTutorias()
    {
        if ($this->selectedBooking) {
            // Esto limpia la caché de Eloquent y recarga los attachments reales de la BD
            $this->selectedBooking->refresh(); 
        }
        // Ocultamos el botón dinámico generado tras completar la acción
        $this->mostrarBotonSubida = false; 
    }


    // Cambiar la sesión activa en el panel derecho
    public function selectBooking($id)
    {
        $this->selectedBookingId = $id;
        $this->mostrarBotonSubida = null;
        // dd($this->getBookingsByRol()->firstWhere('id', $this->selectedBookingId)->attachments );
        $this->reset('newMaterial'); // Limpiar el input de carga
    }

    
    public function UserData($iduser){
        return  User::find($iduser)->profile()->first();    

    }

    #[On('archivo-agregado')]
    public function saveFileEvent($archivo_temporal=null, $description=null){
        // dd("Llego",$archivo_temporal, $description);    
        $booking = SlotBooking::find($this->selectedBookingId);
        $serviceAttachment = app(AttachmentsService::class);
        if ($booking) {
            // Si ya tenía un material subido anteriormente, lo borramos del disco
            $serviceAttachment->createAttachment($booking, $archivo_temporal, $description);
            // Actualizar la base de datos con la ruta exacta tal como se ve en tu captura
            
            $this->reset('newMaterial');
        }
    }


    // Descargar el archivo actual
    public function downloadMaterial(Attachment $file)
    {   
        if ($file && $file->path && Storage::disk('public')->exists($file->path)) {
            return Storage::disk('public')->download(
                $file->path, 
                $file->original_name
            );
        }
    }

    // Eliminar el archivo de apoyo actual
    public function deleteMaterial($idFile) #Falta probar 16 de julion 2 am
    {
        // dd($idFile,"id file");
        $booking = SlotBooking::find($this->selectedBookingId);
        $serviceAttachment = (new AttachmentsService());
        if ($booking) {
            $serviceAttachment->deleteAttachment($idFile);
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
