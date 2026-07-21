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
use Illuminate\Support\Facades\Auth;

class TutoriasDetalles extends Component
{
    use WithFileUploads;

    public $selectedBookingId = null;
    public $newMaterial = null;
    public $firstBooking = null;
    public $mostrarBotonSubida = false;


    public const STATUS_ACCEPTED = 1;
public const STATUS_PENDING = 2;
public const STATUS_NOT_COMPLETED = 3;
public const STATUS_OBSERVED = 4;
public const STATUS_COMPLETED = 5;

public function getStatusNameAttribute(): string
{
    return match ((int) $this->status) {
        self::STATUS_ACCEPTED => 'Aceptado',
        self::STATUS_PENDING => 'Pendiente',
        self::STATUS_NOT_COMPLETED => 'No completado',
        self::STATUS_OBSERVED => 'Observado',
        self::STATUS_COMPLETED => 'Completado',
        default => 'Estado desconocido',
    };
}
    // Puedes pasar este array de 5 datos al montar el componente
    public function mount()
{
    $firstBooking = $this->getBookingsByRol()->first();

    if ($firstBooking) {
        $this->selectedBookingId = $firstBooking->id;
        $this->firstBooking = $firstBooking->id;
    }
}
    
    // public function mount()
    // {
    //     // Si hay reservas, seleccionamos automáticamente la primera por defecto
    //     $firstBooking = $this->getBookingsByRol()->first();
    //     if ($firstBooking) {
    //         $this->selectedBookingId = $firstBooking->id;
    //         $this->firstBooking = $firstBooking->id; // Guardamos el ID de la primera reserva
    //     }
    // }

    public function getBookingsByRol()
{
    $user = Auth::user();

    if (!$user) {
        return collect();
    }

    $service = app(SlotBookingService::class);

    if ($user->hasRole('student')) {
        return $service->getStudentUpcomingTutorias();
    }

    if ($user->hasRole('tutor')) {
        return $service->getSlotBookingsTutor();
    }

    return collect();
}
    // public function getBookingsByRol(){
    //     if(auth()->user()->hasRole("student")) {
    //         return (new SlotBookingService())->getStudentUpcomingTutorias();
    //     }elseif(auth()->user()->hasRole("tutor")) {
    //         return (new SlotBookingService())->getSlotBookingsTutor();
    //     }
    // }
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

    return $this->getBookingsByRol()
        ->firstWhere('id', $this->selectedBookingId);
}
    // public function getSelectedBookingProperty()
    // {
    //     if (!$this->selectedBookingId) {
    //             return null;
    //         }
            
    //     return $this->getBookingsByRol()->firstWhere('id', $this->selectedBookingId);
    // }

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
    $booking = $this->getBookingsByRol()
        ->firstWhere('id', $id);

    if (!$booking) {
        abort(403, 'No tienes acceso a esta tutoría.');
    }

    $this->selectedBookingId = $booking->id;
    $this->mostrarBotonSubida = false;

    $this->reset('newMaterial');
}
    
    // public function selectBooking($id)
    // {
    //     $this->selectedBookingId = $id;
    //     $this->mostrarBotonSubida = null;
    //     // dd($this->getBookingsByRol()->firstWhere('id', $this->selectedBookingId)->attachments );
    //     $this->reset('newMaterial'); // Limpiar el input de carga
    // }

    
    public function UserData($iduser){
        return  User::find($iduser)->profile()->first();    

    }
#[On('archivo-agregado')]
public function saveFileEvent(
    $archivo_temporal = null,
    $description = null
) {
    $booking = $this->getBookingsByRol()
        ->firstWhere('id', $this->selectedBookingId);

    if (!$booking) {
        abort(403, 'No tienes acceso a esta tutoría.');
    }

    $serviceAttachment = app(AttachmentsService::class);

    $serviceAttachment->createAttachment(
        $booking,
        $archivo_temporal,
        $description
    );

    $this->reset('newMaterial');
    $this->mostrarBotonSubida = false;

    $this->dispatch('ReservacionConfirmada');
}
    // #[On('archivo-agregado')]
    // public function saveFileEvent($archivo_temporal=null, $description=null){
    //     // dd("Llego",$archivo_temporal, $description);    
    //     $booking = SlotBooking::find($this->selectedBookingId);
    //     $serviceAttachment = app(AttachmentsService::class);
    //     if ($booking) {
    //         // Si ya tenía un material subido anteriormente, lo borramos del disco
    //         $serviceAttachment->createAttachment($booking, $archivo_temporal, $description);
    //         // Actualizar la base de datos con la ruta exacta tal como se ve en tu captura
            
    //         $this->reset('newMaterial');
    //     }
    // }


    // Descargar el archivo actual
    public function downloadMaterial(Attachment $file)
{
    $booking = $this->getBookingsByRol()
        ->firstWhere('id', $this->selectedBookingId);

    if (!$booking) {
        abort(403, 'No tienes acceso a esta tutoría.');
    }

    $fileBelongsToBooking = $booking->attachments()
        ->where('id', $file->id)
        ->exists();

    if (!$fileBelongsToBooking) {
        abort(403, 'El archivo no pertenece a esta tutoría.');
    }

    if (
        !$file->path ||
        !Storage::disk('public')->exists($file->path)
    ) {
        return null;
    }

    return Storage::disk('public')->download(
        $file->path,
        $file->original_name
    );
}

    // Eliminar el archivo de apoyo actual
    
    public function deleteMaterial($idFile)
{
    $booking = $this->getBookingsByRol()
        ->firstWhere('id', $this->selectedBookingId);

    if (!$booking) {
        abort(403, 'No tienes acceso a esta tutoría.');
    }

    $fileBelongsToBooking = $booking->attachments()
        ->where('id', $idFile)
        ->exists();

    if (!$fileBelongsToBooking) {
        abort(403, 'El archivo no pertenece a esta tutoría.');
    }

    $serviceAttachment = app(AttachmentsService::class);

    $serviceAttachment->deleteAttachment($idFile);

    $this->dispatch('ReservacionConfirmada');
}
    // public function deleteMaterial($idFile) #Falta probar 16 de julion 2 am
    // {
    //     // dd($idFile,"id file");
    //     $booking = SlotBooking::find($this->selectedBookingId);
    //     $serviceAttachment = (new AttachmentsService());
    //     if ($booking) {
    //         $serviceAttachment->deleteAttachment($idFile);
    //     }
    // }

    public function render()
    {
        return view('livewire.tutorias-detalles', [
            'slotBookings' => $this->bookings,
            'selectedBooking' => $this->selectedBooking,
        ])->layout('layouts.app');;
    }

}
