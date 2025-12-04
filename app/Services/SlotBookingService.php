<?php


namespace App\Services;

use App\Services\interfaces;
use App\Models\User;
use App\Models\SlotBooking;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleMeetService;

class SlotBookingService implements interfaces\ISlotBookingService
{

    public function getSlotBookingByUserId(): \Illuminate\Database\Eloquent\Builder
    {
        $user = Auth::user();
        if ($user->hasRole('student')) {
            return SlotBooking::where('student_id', $user->id)
                ->orderBy('start_time', 'desc');
        } else {
            return SlotBooking::where('tutor_id', $user->id)
                ->orderBy('start_time', 'desc');
        }
    }

    public function bookSlot($slotId, $userId, $additionalData = [])
    {
        // Implementación de la lógica para reservar un slot
    }

    public function tiempoLibreTutor($tutorId)
    {
        return UserSubjectSlot::where('user_id', $tutorId)->get();
    }

    public function crearReserva($studentId, $tutorId, $subjectId, $fecha, $session_fee)
    {

        $startTime = \Carbon\Carbon::parse($fecha);
        $endTime = $startTime->copy()->addMinutes(20);
        // Crear la reserva
        $booking = new SlotBooking();
        //$booking->user_subject_slot_id = $slotId;
        $booking->student_id = $studentId;
        $booking->tutor_id = $tutorId;
        $booking->subject_id = $subjectId;
        $booking->session_fee = $session_fee;
        $booking->start_time = $fecha; // Asignar la fecha completa
        $booking->end_time = $endTime->format('Y-m-d H:i:s');     // Convertir de vuelta a string para la BD
        $booking->booked_at = now();
        $booking->user_subject_slot_id = null; // Asignar el ID del slot creado
        $booking->status = 1; // Estado inicial
  

        $link = $this->generarlink($booking);
        $booking->meeting_link = $link;
        $booking->save();


        // if ($session_fee == 0) {
        //     $this->aceptartutoria($booking);
        // }
        return $booking;
    }




    // public function aceptartutoria($tutoria)
    // {
    //     $tutoria->status = 1; // Cambiar el estado a 'aceptado'
    //     $link = $this->generarlink($tutoria);
    //     $tutoria->meeting_link = $link;
    //     $tutoria->save();
    // }
    public function aceptartutoria($tutoria)
    {
        $tutoria->status = 1; // Cambiar el estado a 'aceptado'
        $link = $this->generarlink($tutoria);
        $tutoria->meeting_link = $link;
        $tutoria->save();
    }



    public function generarlink($tutoria)
    {
        $googlemeetservice = new GoogleMeetService;
        // Formatear la fecha correctamente para Zoom (ISO 8601)
        $startTimeCarbon = \Carbon\Carbon::parse($tutoria->start_time, 'America/La_Paz');
        $durationInMinutes = 20;
        $meetingData = [
            'topic' => 'Tutoría',
            'agenda' => 'Sesión de tutoría',
            'start_time' => $startTimeCarbon->toIso8601String(),
            'end_time' => $startTimeCarbon->copy()->addMinutes($durationInMinutes)->toIso8601String(),
            'timezone' => 'America/La_Paz',
            'duration' => 20, // Duración en minutos
        ];
        $user = User::find($tutoria->tutor_id);
        //$link = $googlemeetservice->createMeetingPorTutord($meetingData, $user);
        try {
            // $link= $googlemeetservice->createMeetingConCredencialesApi($meetingData);
            $link = $googlemeetservice->createMeetingPorTutord($meetingData, $user);

        } catch (\Exception $e) {
            \Log::error('Error al crear la reunión de Google Meet: ' . $e->getMessage());
            $link = null; // O manejar el error según sea necesario
        }
        // COMENTADO: Se envían correos desde BookingNotificationService para evitar duplicados
        // $mailService = new MailService();
        // $mailService->sendTutoriaNotification($tutoria, $link);
        return $link;
    }

    /**
     *  Para extraer las proximas tutorías del estudiante
     */
    public function getStudentUpcomingTutorias()
    {
        $user = Auth::user();
        
        if (!$user || !$user->hasRole('student')) {
            return collect();
        }
        
        return SlotBooking::where('student_id', $user->id)
            ->where('status', '!=', 3)
            ->where(function($query) {
                $query->where('start_time', '>=', now())
                    ->orWhere(function($q) {
                        $q->where('start_time', '<=', now())
                            ->where('end_time', '>=', now());
                    });
            })
            ->orderBy('start_time', 'asc')
            ->limit(5)
            ->get();    
    }
}