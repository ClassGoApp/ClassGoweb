<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\SlotBooking;

class CompleteSlotBookings extends Command
{
    /**
     * The name and signature of the console command cambio para subir.
     *
     * @var string
     */
    protected $signature = 'app:complete-slot-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Completa las reservas que han terminado';

    /**
     * Execute the console command. cambios 
     */
    public function handle()
    {
        //Log::info('Comando CompleteSlotBookings ejecutado');
        $now = Carbon::now();
        $bookings = SlotBooking::where('status', 1) // 1 = Active
            ->whereNotNull('end_time')
            ->where('end_time', '<', $now->subMinutes(3)) // end_time + 2 minutos
            ->get();
        foreach ($bookings as $booking) {
            $booking->status = 5; // 5 = Completed
            $booking->save();

            $tutor_id = $booking->tutor_id;
            $tutor = User::find($tutor_id);

            $adminEmail = config('mail.from.admin');
            $user = Auth::user();
            $contenido = "tutoria completada para el tutor {$tutor->profile->first_name} - {$tutor->profile->last_name}  ({$tutor->email}) de fecha {$booking->end_time}";

            try {
                \Mail::raw($contenido, function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('Tutoria Completada, Pago Pendiente');
                });
               
            } catch (\Exception $e) {
                Log::error("Error al enviar correo para la reserva {$booking->id}: " . $e->getMessage());
            }
            //Log::info("Reserva {$booking->id} completada");
        }
        $this->info('Proceso de completar reservas finalizado');
    }
}
