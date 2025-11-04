<?php

namespace App\Services;
use App\Models\User;
use App\Models\SlotBooking;
use Illuminate\Support\Facades\Auth;
class FloatingService {
    /**
     * Servicio para notificacion Floating button en el home
     */
    public function getTutoriasAceptadasCount(?User $user = null): int
    {
        $user = $user ?: Auth::user();
        
        // Verificar que sea tutor
        if (!$user || !$user->hasRole('tutor')) {
            return 0;
        }

        return SlotBooking::where('tutor_id', $user->id)
            ->where('status', 1) // 1 = aceptado según tu BD
            ->where('start_time', '>', now()) // Solo fechas futuras
            ->count();
    }

}