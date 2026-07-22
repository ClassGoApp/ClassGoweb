<?php


namespace App\Services;

use App\Services\interfaces;
use App\Models\User;
use App\Models\SlotBooking;
use App\Models\UserSubjectSlot;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleMeetService;
use App\Services\BookingNotificationService;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Collection;
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

   

public function getSlotBookingsTutor(): Collection
{
    $user = Auth::user();

    if (!$user || !$user->hasRole('tutor')) {
        return collect();
    }

    return SlotBooking::query()
        ->where('tutor_id', $user->id)
        ->whereIn('status', [
            1, // Aceptado
            2, // Pendiente
            4, // Observado
        ])
        ->where('end_time', '>=', now())
        ->with([
            'subject',
            'attachments',
        ])
        ->orderBy('start_time', 'asc')
        ->get();
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

        // --- ENVIAR NOTIFICACIÓN ---
        $notificationService = app(BookingNotificationService::class);
        $notificationService->handleStatusChangeNotification($booking, '', $booking->status);


        // if ($session_fee == 0) {
        //     $this->aceptartutoria($booking);
        // }
        return $booking;
    }

    public function crearReservaContinua($studentId, $tutorId, $subjectId, array $fechas, $session_fee, $materialProcesado, $description)
    {
        Log::info('DEBUG crearReservaContinua - entrada', [
            'student_id' => $studentId,
            'tutor_id' => $tutorId,
            'subject_id' => $subjectId,
            'session_fee' => $session_fee,
            'fechas' => $fechas,
            'count' => count($fechas),
        ]);

        if (empty($fechas)) {
            throw new \Exception('No se recibieron fechas para crear la reserva.');
        }

        $fechas = array_values(array_unique($fechas));
        sort($fechas);

        Log::info('DEBUG crearReservaContinua - fechas ordenadas', [
            'fechas_ordenadas' => $fechas,
            'count' => count($fechas),
        ]);

        if (count($fechas) > 1) {
            for ($i = 1; $i < count($fechas); $i++) {
                $anterior = \Carbon\Carbon::parse($fechas[$i - 1]);
                $actual = \Carbon\Carbon::parse($fechas[$i]);

                $diff = (int) $anterior->diffInMinutes($actual);

                Log::info('DEBUG crearReservaContinua - validando continuidad', [
                    'anterior' => $anterior->format('Y-m-d H:i:s'),
                    'actual' => $actual->format('Y-m-d H:i:s'),
                    'diff' => $diff,
                ]);

                if ($diff !== 20) {
                    throw new \Exception('Las fechas seleccionadas no forman un bloque continuo de 20 minutos.');
                }
            }
        }

        $startTime = \Carbon\Carbon::parse($fechas[0]);
        $endTime = $startTime->copy()->addMinutes(count($fechas) * 20);

        Log::info('DEBUG crearReservaContinua - rango final', [
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s'),
            'bloques' => count($fechas),
        ]);
        // dd($materialProcesado, $materialProcesado["originName"], ["explode"=> explode(".", $materialProcesado["originName"] )[0] ]);
        // $materialProcesado["originName"]= explode(".", $materialProcesado["originName"] )[0];
        $booking = new SlotBooking();
        $booking->student_id = $studentId;
        $booking->tutor_id = $tutorId;
        $booking->subject_id = $subjectId;
        $booking->session_fee = $session_fee;
        $booking->start_time = $startTime->format('Y-m-d H:i:s');
        $booking->end_time = $endTime->format('Y-m-d H:i:s');
        $booking->booked_at = now();
        $booking->user_subject_slot_id = null;
        $booking->status = 1;

    

        Log::info('DEBUG crearReservaContinua - antes de generar link', [
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
        ]);

        $link = $this->generarlink($booking);
        $booking->meeting_link = $link;

        Log::info('DEBUG crearReservaContinua - link generado', [
            'meeting_link' => $link,
        ]);

        $booking->save();

        Log::info('DEBUG crearReservaContinua - booking guardado', [
            'booking_id' => $booking->id,
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
        ]);

        $notificationService = app(BookingNotificationService::class);
        $notificationService->handleStatusChangeNotification($booking, '', $booking->status);

        Log::info('DEBUG crearReservaContinua - notificacion enviada', [
            'booking_id' => $booking->id,
            'status' => $booking->status,
        ]);

        return $booking;
    }

    public function crearReservasMultiples($studentId, $tutorId, $subjectId, array $fechas, $session_fee)
    {
        $bookings = [];

        foreach ($fechas as $fechaString) {
            $startTime = \Carbon\Carbon::parse($fechaString);
            $endTime = $startTime->copy()->addMinutes(20);

            $booking = new SlotBooking();
            $booking->student_id = $studentId;
            $booking->tutor_id = $tutorId;
            $booking->subject_id = $subjectId;

            // El fee se lo pasamos tal cual (el total sumado que viene del controller)
            // pero solo a la primera reserva para no duplicar ingresos en reportes, 
            // o lo divides entre count($fechas). Aquí lo pondremos en la primera:
            $booking->session_fee = (empty($bookings)) ? $session_fee : 0;

            $booking->start_time = $fechaString;
            $booking->end_time = $endTime->format('Y-m-d H:i:s');
            $booking->booked_at = now();
            $booking->status = 1;

            $link = $this->generarlink($booking);
            $booking->meeting_link = $link;
            $booking->save();

            // Notificación
            $notificationService = app(BookingNotificationService::class);
            $notificationService->handleStatusChangeNotification($booking, '', $booking->status);

            $bookings[] = $booking;
        }

        return $bookings;
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

    public function getStudentUpcomingTutorias(): Collection
{
    $user = Auth::user();

    if (!$user || !$user->hasRole('student')) {
        return collect();
    }

    return SlotBooking::query()
        ->where('student_id', $user->id)
        ->whereIn('status', [
            1, // Aceptado
            2, // Pendiente
            4, // Observado
        ])
        ->where('end_time', '>=', now())
        ->with([
            'subject',
            'attachments',
        ])
        ->orderBy('start_time', 'asc')
        ->get();
}
    // public function getStudentUpcomingTutorias()
    // {
    //     $user = Auth::user();

    //     if (!$user || !$user->hasRole('student')) {
    //         return collect();
    //     }

    //     return SlotBooking::with(["attachments"])->where('student_id', $user->id)
    //         ->where('status', '!=', 3)
    //         ->where(function ($query) {
    //             $query->where('start_time', '>=', now())
    //                 ->orWhere(function ($q) {
    //                     $q->where('start_time', '<=', now())
    //                         ->where('end_time', '>=', now());
    //                 });
    //         })
    //         ->orderBy('start_time', 'asc')
    //         ->limit(5)
    //         ->get();
    // }

    public function getTotalCommission()
    {
        $total = SlotBooking::where('status', '!=', 1)
            ->where('status', '!=', 2)
            ->where('status', '!=', 3)
            ->sum('session_fee');

        return $total * 0.20; //20% de comision
    }
}
