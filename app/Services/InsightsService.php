<?php

namespace App\Services;

use App\Casts\BookingStatus;
use App\Models\SlotBooking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * InsightsService
 *
 * FUENTE DE VERDAD: slot_payments + slot_bookings
 *
 * El sistema ClassGo gestiona tutorías directamente en slot_bookings (sin pasar por
 * el flujo traditional orders/order_items/user_wallet_details que quedó vacío).
 * Este servicio lee los datos monetarios desde slot_payments, que es la tabla
 * donde el BookingController registra cada pago al crear una reserva.
 *
 * Reglas de negocio:
 *  - Platform Earnings  = SUM(slot_payments.amount) excluyendo reservas Rechazadas (status=4)
 *  - Platform Commission = Platform Earnings × tasa de comisión (setting '_lernen.commission', default 10%)
 *  - Tutor Payouts      = SUM de pagos confirmados (status=2) × (1 - tasa comisión)
 *  - Pending Payouts    = SUM de pagos pendientes (status=1) × (1 - tasa comisión)
 */
class InsightsService
{
    /**
     * Lee la tasa de comisión desde los settings del sistema.
     * Devuelve un decimal entre 0 y 1 (ej: 10% → 0.10).
     */
    private function getPlatformCommissionRate(): float
    {
        $pct = (float) (setting('_lernen.commission') ?? 20);
        return max(0.0, min(100.0, $pct)) / 100;
    }

    /**
     * Platform Earnings: total recaudado por la plataforma a partir de pagos de tutorías.
     *
     * Incluye: status=1 (Pendiente verificación) + status=2 (Pagado) + status=3 (Observado).
     * Excluye: status=4 (Cancelado) y reservas rechazadas (slot_bookings.status = 4).
     */
    public function getPlatformEarnings($revenueStartDate = null, $revenueEndDate = null): float
    {
        $query = DB::table('slot_payments')
            ->join('slot_bookings', 'slot_payments.slot_booking_id', '=', 'slot_bookings.id')
            ->whereNotIn('slot_payments.status', [4])       // excluir pago Cancelado
            ->whereNotIn('slot_bookings.status', [4]);      // excluir reserva Rechazada

        if (!empty($revenueStartDate) && !empty($revenueEndDate)) {
            $query->whereBetween('slot_payments.created_at', [
                $revenueStartDate . ' 00:00:00',
                $revenueEndDate . ' 23:59:59',
            ]);
        }

        return (float) $query->sum('slot_payments.amount');
    }

    /**
     * Tutor Earnings (Payouts): lo que corresponde pagar o ya se pagó a los tutores.
     *
     * @param string $type
     *   'add'               → pagos ya confirmados (slot_payments.status = 2)
     *   'pending_available' → pagos pendientes de verificación (slot_payments.status = 1)
     */
    public function getTutorEarnings($type, $revenueStartDate = null, $revenueEndDate = null): float
    {
        $commissionRate = $this->getPlatformCommissionRate();

        // Mapeo: qué status de slot_payments corresponde a cada tipo
        $statusMap = [
            'add' => 2,   // Pagado
            'pending_available' => 1,   // Pendiente de verificación
        ];

        $paymentStatus = $statusMap[$type] ?? 2;

        $query = DB::table('slot_payments')
            ->join('slot_bookings', 'slot_payments.slot_booking_id', '=', 'slot_bookings.id')
            ->where('slot_payments.status', $paymentStatus)
            ->whereNotIn('slot_bookings.status', [4]);      // excluir reserva Rechazada

        if (!empty($revenueStartDate) && !empty($revenueEndDate)) {
            $query->whereBetween('slot_payments.created_at', [
                $revenueStartDate . ' 00:00:00',
                $revenueEndDate . ' 23:59:59',
            ]);
        }

        $subtotal = (float) $query->sum('slot_payments.amount');

        return round($subtotal * (1 - $commissionRate), 2);
    }

    /**
     * @deprecated Usar getTutorEarnings('pending_available') en su lugar.
     */
    public function getTutorPendingEarnings(): float
    {
        return $this->getTutorEarnings('pending_available');
    }

    /**
     * Platform Commission: monto que retiene la plataforma.
     *
     * Fórmula: getPlatformEarnings() × tasa_comisión
     */
    public function getPlatformCommission($revenueStartDate = null, $revenueEndDate = null): float
    {
        $commissionRate = $this->getPlatformCommissionRate();
        $total = $this->getPlatformEarnings($revenueStartDate, $revenueEndDate);
        return round($total * $commissionRate, 2);
    }

    /**
     * Conteo de sesiones de slot_bookings filtradas por status y rango de fechas.
     */
    public function getSessions($statuses = [], $sessionStartDate = null, $sessionEndDate = null): int
    {
        $statusValues = [];
        foreach ($statuses as $status) {
            if (isset(BookingStatus::$statuses[$status])) {
                $statusValues[] = BookingStatus::$statuses[$status];
            }
        }

        if (!empty($sessionStartDate) && !empty($sessionEndDate)) {
            return SlotBooking::whereBetween('start_time', [
                $sessionStartDate . ' 00:00:00',
                $sessionEndDate . ' 23:59:59',
            ])->whereIn('status', $statusValues)->count();
        }

        return SlotBooking::whereIn('status', $statusValues)->count();
    }

    /**
     * Usuarios con roles dados, opcionalmente filtrados por mes.
     *
     * @param string[] $roles       ['tutor', 'student']
     * @param string|null $dateRange  'current_month' | 'last_month' | null
     */
    public function getUsers($roles = [], $dateRange = null)
    {
        $query = User::query();

        if (!empty($roles)) {
            $query->whereHas('roles', function ($q) use ($roles) {
                $q->whereIn('name', $roles);
            });
        }

        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });

        if ($dateRange === 'current_month') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        } elseif ($dateRange === 'last_month') {
            $query->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year);
        }

        return $query->get();
    }
}
