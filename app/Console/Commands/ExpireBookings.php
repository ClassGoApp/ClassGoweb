<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SlotBooking;
use App\Services\BookingNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expira las solicitudes de tutoría virtual no aceptadas a las 4 horas, y las aceptadas sin pago a las 4 horas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $fourHoursAgo = $now->copy()->subHours(4);
        $notificationService = app(BookingNotificationService::class);

        // 1. Expira las solicitudes en estado 'Pendiente' (2)
        // Tutor no confirmó la tutoría en 4 horas
        $pendingBookings = SlotBooking::whereNull('user_subject_slot_id')
            ->where('status', 2)
            ->where('booked_at', '<=', $fourHoursAgo)
            ->get();

        foreach ($pendingBookings as $booking) {
            try {
                $booking->status = 4; // Rechazado
                $booking->save();

                // Notificar al estudiante que el tutor no respondió
                $notificationService->sendTutorExpiredNotification($booking);

                Log::info("Booking ID {$booking->id} expirado por falta de aceptación del tutor.");
            } catch (\Exception $e) {
                Log::error("Error al expirar reserva pendiente {$booking->id}: " . $e->getMessage());
            }
        }

        // 2. Expira las solicitudes en estado 'Pendiente de pago' (7)
        // Estudiante no pagó la tutoría en 4 horas desde la aceptación
        $acceptedBookings = SlotBooking::whereNull('user_subject_slot_id')
            ->where('status', 7)
            ->get();

        foreach ($acceptedBookings as $booking) {
            try {
                $meta = json_decode($booking->meta_data, true) ?: [];
                $acceptedAtStr = $meta['accepted_at'] ?? null;

                if ($acceptedAtStr) {
                    $acceptedAt = Carbon::parse($acceptedAtStr);
                    if ($acceptedAt->lte($fourHoursAgo)) {
                        $booking->status = 4; // Rechazado
                        $booking->save();

                        // Notificar al estudiante y tutor que expiró por falta de pago
                        $notificationService->sendStudentExpiredNotification($booking);

                        Log::info("Booking ID {$booking->id} expirado por falta de pago del estudiante.");
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error al expirar reserva aceptada {$booking->id}: " . $e->getMessage());
            }
        }

        $this->info('Proceso de expiración de reservas finalizado.');
    }
}
