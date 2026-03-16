<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Coupon;
use App\Services\CuponesService;
use Illuminate\Database\QueryException;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Storage;
use App\Services\SlotBookingService;
use App\Services\interfaces;
use App\Models\SlotBooking;
use App\Services\BookingNotificationService;


class BookingController extends Controller
{
    protected $slotBookingService;

    public function __construct(SlotBookingService $slotBookingService)
    {
        $this->slotBookingService = $slotBookingService;
    }
    /**
     * GET /student/booking/materias?institution=colegio|universidad|instituto
     */
    public function getSubjects(Request $request)
    {
        try {
            $institution = strtolower(trim((string) $request->query('institution')));

            if ($institution === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Se requiere institution'
                ], 400);
            }



            $map = [
                'colegio'     => 1000,
                'universidad' => 3000,
                'instituto'   => 2000,
            ];

            if (!isset($map[$institution])) {
                return response()->json([
                    'success' => true,
                    'subjects' => []
                ]);
            }

            $rootId = $map[$institution];



            $subjectsQuery = DB::table('subjects')
                ->select('id', 'name')
                ->whereNull('deleted_at')
                ->where('status', 'active');

            if ($rootId === 1000) {
                // COLEGIO: 1 nivel (hijos directos)
                $groupIds = DB::table('subject_groups')
                    ->whereNull('deleted_at')
                    ->where('status', 'active')
                    ->where('id_padre', $rootId)
                    ->pluck('id');

                $subjectsQuery->whereIn('subject_group_id', $groupIds);
            } else {
                // UNIVERSIDAD / INSTITUTO: 2 niveles (nietos)

                $childIds = DB::table('subject_groups')
                    ->whereNull('deleted_at')
                    ->where('status', 'active')
                    ->where('id_padre', $rootId)
                    ->pluck('id');

                // nietos (hijos de los hijos)
                $grandChildIds = DB::table('subject_groups')
                    ->whereNull('deleted_at')
                    ->where('status', 'active')
                    ->whereIn('id_padre', $childIds)
                    ->pluck('id');

                $subjectsQuery->whereIn('subject_group_id', $grandChildIds);
            }

            $subjects = $subjectsQuery
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'subjects' => $subjects
            ]);
        } catch (\Exception $e) {
            Log::error('getSubjects error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar materias'
            ], 500);
        }
    }



    /**
     * GET /student/booking/tutores?subject_id=ID
     */

    public function getTutors(Request $request)
    {
        try {
            $subjectId = (int) $request->query('subject_id');

            if (!$subjectId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Se requiere el ID de la materia'
                ], 400);
            }

            $now = now();
            $today = $now->toDateString();
            $timeNow = $now->format('H:i:s');

            $tutors = DB::table('user_subject as us')
                ->join('users as u', 'us.user_id', '=', 'u.id')
                ->join('profiles as p', 'p.user_id', '=', 'u.id')
                ->where('us.subject_id', $subjectId)
                ->where('us.status', 'active')


                ->where('u.status', 1)
                ->whereNotNull('u.email_verified_at')
                ->where('u.available_for_tutoring', 1)

                // precio desde profiles
                ->whereNotNull('p.price')
                ->where('p.price', '>', 0)


                ->whereExists(function ($q) use ($today, $timeNow) {
                    $q->select(DB::raw(1))
                        ->from('user_subject_slots as s')
                        ->whereColumn('s.user_id', 'u.id')
                        ->where(function ($w) use ($today, $timeNow) {
                            $w->where('s.date', '>', $today)
                                ->orWhere(function ($w2) use ($today, $timeNow) {
                                    $w2->where('s.date', '=', $today)
                                        ->where('s.end_time', '>', $timeNow);
                                });
                        });
                })

                ->select(
                    'p.id as profile_id',
                    'u.id as user_id',
                    DB::raw("TRIM(CONCAT(COALESCE(p.first_name,''),' ',COALESCE(p.last_name,''))) as full_name"),
                    'p.image as image',
                    DB::raw("CAST(p.price AS DECIMAL(10,2)) as price")
                )
                ->groupBy('p.id', 'u.id', 'p.first_name', 'p.last_name', 'p.image', 'p.price')
                ->orderBy('p.first_name')
                ->get()
                ->map(function ($t) {
                    $t->image_url = $t->image ? asset('storage/' . ltrim($t->image, '/')) : null;
                    $t->price = (float) $t->price;
                    return $t;
                });

            return response()->json([
                'success' => true,
                'tutors' => $tutors
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al obtener tutores: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar tutores'
            ], 500);
        }
    }





    /**
     * GET /student/booking/horarios/{tutorId}
     *
     * Retorna slots de 20 min: id = "baseSlotId|HH:MM|HH:MM"
     * y marca available=false si:
     *  - ya está reservado (pending/active)
     *  - ya pasó (fecha/hora en el pasado)
     */
    public function getSlots(Request $request, $tutorId)
    {
        try {
            $today = now()->startOfDay();


            $baseSlots = DB::table('user_subject_slots')
                ->where('user_id', (int)$tutorId)
                ->where('date', '>=', $today)
                ->orderBy('date')
                ->orderBy('start_time')
                ->get(['id', 'date', 'start_time', 'end_time']);

            if ($baseSlots->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'slots' => []
                ]);
            }


            $busyBookings = DB::table('slot_bookings')
                ->where('tutor_id', (int)$tutorId)
                ->whereIn('status', [0, 1])
                ->where('start_time', '>=', $today)
                ->get(['user_subject_slot_id', 'start_time', 'end_time']);


            $busySet = [];
            foreach ($busyBookings as $b) {
                $st = Carbon::parse($b->start_time);
                $en = Carbon::parse($b->end_time);
                $key = $b->user_subject_slot_id . '|' . $st->format('H:i') . '|' . $en->format('H:i') . '|' . $st->format('Y-m-d');
                $busySet[$key] = true;
            }


            $now = now();
            $stepMinutes = 20;

            $out = [];

            foreach ($baseSlots as $slot) {
                $dateStr = Carbon::parse($slot->date)->format('Y-m-d');

                $rangeStart = Carbon::parse($dateStr . ' ' . $slot->start_time);
                $rangeEnd   = Carbon::parse($dateStr . ' ' . $slot->end_time);

                $cursor = $rangeStart->copy();

                while ($cursor->copy()->addMinutes($stepMinutes)->lte($rangeEnd)) {
                    $segStart = $cursor->copy();
                    $segEnd   = $cursor->copy()->addMinutes($stepMinutes);


                    if ($segEnd->lte($now)) {
                        $cursor->addMinutes($stepMinutes);
                        continue;
                    }


                    if ($segStart->lte($now) && $segEnd->gt($now)) {
                        $cursor->addMinutes($stepMinutes);
                        continue;
                    }


                    $busyKey = $slot->id . '|' . $segStart->format('H:i') . '|' . $segEnd->format('H:i') . '|' . $dateStr;
                    if (isset($busySet[$busyKey])) {
                        $cursor->addMinutes($stepMinutes);
                        continue;
                    }

                    $id = $slot->id . '|' . $segStart->format('H:i') . '|' . $segEnd->format('H:i');


                    $out[] = [
                        'id' => $id,
                        'date' => $dateStr,
                        'duracion' => $stepMinutes,
                        'available' => true,
                    ];

                    $cursor->addMinutes($stepMinutes);
                }
            }

            return response()->json([
                'success' => true,
                'slots' => $out
            ]);
        } catch (\Exception $e) {
            Log::error('getSlots error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los horarios'
            ], 500);
        }
    }


    public function validarCupon(Request $request, CuponesService $cuponesService)
    {
        try {
            $codigo = trim((string) $request->input('codigo', ''));
            $user = $request->user();

            if ($codigo === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingresa un cupón',
                ], 422);
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autenticado',
                ], 401);
            }


            $cupon = Coupon::where('codigo', $codigo)->first();
            if (!$cupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cupón inválido',
                ], 404);
            }


            if (($cupon->estado ?? null) !== 'activo') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cupón inactivo',
                ], 422);
            }


            if (!empty($cupon->fecha_caducidad) && $cupon->fecha_caducidad < now()->toDateString()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cupón vencido',
                ], 422);
            }


            if ($cuponesService->verificaUsoCupon($codigo, $user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes usar este cupón',
                ], 422);
            }


            $descuentoPct = (float) ($cupon->descuento ?? 0);
            $descuentoDecimal = max(0, min(1, $descuentoPct / 100));

            return response()->json([
                'success' => true,
                'coupon_id' => $cupon->id,
                'descuento' => $descuentoDecimal,
                'message' => "Cupón aplicado: {$descuentoPct}% de descuento",
            ]);
        } catch (\Throwable $e) {
            Log::error('validateCoupon error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al validar cupón',
                'debug' => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }



    public function getTutorPayment($tutor_id)
    {
        try {
            $bankRow = DB::table('user_payout_methods')
                ->where('user_id', $tutor_id)
                ->where('payout_method', 'bank')
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->first();

            $bank = null;
            if ($bankRow && $bankRow->payout_details) {
                $bank = json_decode($bankRow->payout_details, true);
            }

            $qrRow = DB::table('user_payout_methods')
                ->where('user_id', $tutor_id)
                ->where('payout_method', 'QR')
                ->where('status', 'active')
                ->whereNull('deleted_at')
                ->first();

            return response()->json([
                'success' => true,
                'payment' => [
                    'bank'   => $bank,
                    'qr_url' => `/storage/qr/Qr-pagos.png`, // Ruta genérica para el QR de pagos (debe existir en public/storage/qr/Qr-pagos.png)
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('getTutorPayment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los métodos de pago.'
            ], 500);
        }
    }

    /**
     * Método privado para crear la reserva, adaptado de crearReserva.
     * Usa el modelo SlotBooking (Eloquent) para consistencia.
     */
    private function createBooking($studentId, $tutorId, $subjectId, $baseSlotId, $startAt, $endAt, $sessionFee, $metaData = [], $couponId = null, $couponCode = null, $discountPct = 0, $basePrice = 0, $finalPrice = 0, $isFree = false)
    {
        // Crear la reserva usando el modelo (inspirado en crearReserva)
        $booking = new SlotBooking();
        $booking->student_id = $studentId;
        $booking->tutor_id = $tutorId;
        $booking->subject_id = $subjectId;
        $booking->user_subject_slot_id = $baseSlotId;  // Usar el slot base calculado
        $booking->session_fee = $sessionFee;
        $booking->start_time = $startAt->toDateTimeString();  // Usar startAt calculado
        $booking->end_time = $endAt->toDateTimeString();      // Usar endAt calculado
        $booking->booked_at = now();
        $booking->status = 1;  // Estado inicial
        $booking->meta_data = json_encode($metaData);  // Incluir meta_data de storeBooking

        // Generar link de reunión (usando SlotBookingService, como en storeBooking)
        $slotBookingService = app(SlotBookingService::class);
        $meetLink = $slotBookingService->generarlink($booking);
        $booking->meeting_link = $meetLink;

        $booking->save();  // Guardar con Eloquent

        // Enviar notificación (inspirado en crearReserva)
        try {
            $notificationService = app(BookingNotificationService::class);
            $notificationService->handleStatusChangeNotification($booking, '', $booking->status);
        } catch (\Throwable $e) {
            Log::error('Notification error: ' . $e->getMessage());
            // No fallar la reserva por error en notificación
        }

        return $booking;
    }

    public function storeBooking(Request $request, CuponesService $cuponesService)
    {
        $request->validate([
            'subject_id'  => 'required|exists:subjects,id',
            'tutor_id'    => 'required|exists:users,id',
            'slot_id'     => 'required|string', // "15|12:00|12:20"
            'coupon_id'   => 'nullable|exists:coupons,id',
            'is_free'     => 'nullable|in:0,1',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $studentId = Auth::id();
            $user      = $request->user();

            // slot_id = "15|12:00|12:20"
            $parts = explode('|', (string) $request->slot_id);
            if (count($parts) !== 3) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'slot_id inválido'], 400);
            }

            [$baseSlotId, $reqStart, $reqEnd] = $parts;
            $baseSlotId = (int) $baseSlotId;

            if (!$baseSlotId || !$reqStart || !$reqEnd) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'slot_id inválido'], 400);
            }

            $baseSlot = DB::table('user_subject_slots')->where('id', $baseSlotId)->first();
            if (!$baseSlot) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Horario base no encontrado'], 404);
            }

            $dateStr = Carbon::parse($baseSlot->date)->format('Y-m-d');
            $startAt = Carbon::parse($dateStr . ' ' . $reqStart . ':00');
            $endAt   = Carbon::parse($dateStr . ' ' . $reqEnd . ':00');

            if ($endAt->lte($startAt)) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Rango horario inválido'], 400);
            }

            if ($endAt->lte(now())) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Ese horario ya pasó'], 400);
            }

            // Evitar doble reserva (status 0/1)
            $exists = DB::table('slot_bookings')
                ->where('tutor_id', (int) $request->tutor_id)
                ->where('user_subject_slot_id', $baseSlotId)
                ->whereIn('status', [0, 1])
                ->where('start_time', $startAt->toDateTimeString())
                ->where('end_time', $endAt->toDateTimeString())
                ->exists();

            if ($exists) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Este horario ya ha sido reservado por otro estudiante'
                ], 400);
            }

            // 1) Validar que tutor tiene esa materia activa
            $userSubject = DB::table('user_subject')
                ->where('user_id', (int) $request->tutor_id)
                ->where('subject_id', (int) $request->subject_id)
                ->where('status', 'active')
                ->first();

            if (!$userSubject) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'El tutor no tiene esta materia activa'
                ], 422);
            }

            // 2) Precio desde profiles.price
            $precioBase = (float) DB::table('profiles')
                ->where('user_id', (int) $request->tutor_id)
                ->value('price');

            if ($precioBase <= 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'El tutor no tiene precio configurado'
                ], 422);
            }

            // =========================
            // CUPÓN (validar)
            // =========================
            $couponId     = $request->input('coupon_id');
            $couponCodigo = null;
            $descuentoPct = 0;

            if ($couponId) {
                $cupon = Coupon::find($couponId);

                if (!$cupon) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Cupón inválido'], 422);
                }

                if (($cupon->estado ?? null) !== 'activo') {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Cupón inactivo'], 422);
                }

                if (!empty($cupon->fecha_caducidad) && $cupon->fecha_caducidad < now()->toDateString()) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Cupón vencido'], 422);
                }

                $couponCodigo = (string) $cupon->codigo;


                if ($cuponesService->verificaUsoCupon($couponCodigo, $user)) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'No puedes usar este cupón'], 422);
                }

                $descuentoPct = (float) ($cupon->descuento ?? 0);
                $descuentoPct = max(0, min(100, $descuentoPct));
            }


            $precioFinal = $precioBase * (1 - ($descuentoPct / 100));
            if ($precioFinal < 0) $precioFinal = 0;

            $isFreeComputed = $precioFinal <= 0.0001;


            $bookingStatus  =  1;
            $paymentStatus  = $isFreeComputed ? 2 : 1;
            $paymentMethod  = $isFreeComputed ? 'free' : 'transfer';
            $paymentMessage = $isFreeComputed
                ? 'Clase gratuita (cupón 100%) - confirmada automáticamente'
                : 'Pago pendiente de verificación';


            $image_url = null;

            if ($isFreeComputed) {
                // Tu genérica ya existe en public/storage/qr/tutoria_gratis.png
                $image_url = 'qr/tutoria_gratis.png';
            } else {
                $file = $request->file('comprobante');
                if (!$file) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Falta comprobante'], 422);
                }

                $original = preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $filename = uniqid() . '_' . $original;

                $dest = public_path('storage/qr');
                if (!file_exists($dest)) {
                    mkdir($dest, 0775, true);
                }


                $file->move($dest, $filename);


                $image_url = 'qr/' . $filename;
            }


            $metaData = [
                'date'        => $dateStr,
                'start'       => $reqStart,
                'end'         => $reqEnd,
                'coupon_id'   => $couponId,
                'coupon_code' => $couponCodigo,
                'discount_pct' => $descuentoPct,
                'base_price'  => $precioBase,
                'final_price' => $precioFinal,
                'is_free'     => $isFreeComputed ? 1 : 0,
            ];

            // Crear la reserva usando el método adaptado (en lugar de DB::table)
            $booking = $this->createBooking(
                $studentId,
                (int) $request->tutor_id,
                (int) $request->subject_id,
                $baseSlotId,
                $startAt,
                $endAt,
                $precioFinal,
                $metaData,
                $couponId,
                $couponCodigo,
                $descuentoPct,
                $precioBase,
                $precioFinal,
                $isFreeComputed
            );

            $bookingId = $booking->id;  // Obtener ID del modelo

            




            DB::table('slot_payments')->insert([
                'slot_booking_id' => $bookingId,
                'payment_date'    => now()->toDateString(),
                'payment_method'  => $paymentMethod,
                'amount'          => $precioFinal,
                'status'          => $paymentStatus,
                'message'         => $paymentMessage,
                'receipt_pdf'     => $image_url,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);


            DB::table('payment_slot_bookings')->insert([
                'slot_booking_id' => $bookingId,
                'image_url'       => $image_url,   // <-- AQUÍ se guarda "qr/xxx.png" o "qr/tutoria_gratis.png"
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);


            if ($couponId && $couponCodigo) {

                $pivot = UserCoupon::where('coupon_id', (int) $couponId)
                    ->where('user_id', (int) $user->id)
                    ->first();

                if (!$pivot) {
                    $cuponesService->canjeaCupon($couponCodigo, $user);

                    $pivot = UserCoupon::where('coupon_id', (int) $couponId)
                        ->where('user_id', (int) $user->id)
                        ->first();
                }

                if (!$pivot || ($pivot->estado ?? null) !== 'activo' || (int) $pivot->cantidad <= 0) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes usar este cupón (ya fue usado).'
                    ], 422);
                }

                $cuponesService->cuponCanjeado($couponCodigo, $user);
            }

            DB::commit();
            return response()->json([
                'success'    => true,
                'message'    => 'Reserva creada exitosamente',
                'booking_id' => $bookingId
            ]);

            DB::commit();
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validación fallida',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeBooking error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la reserva',
                'debug'   => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
