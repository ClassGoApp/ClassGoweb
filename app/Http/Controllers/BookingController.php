<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Coupon;
use App\Services\CuponesService;
use Illuminate\Database\QueryException;
use App\Models\UserCoupon;
use Illuminate\Support\Facades\Storage;
use App\Services\SlotBookingService;
use App\Services\interfaces;
use App\Models\SlotBooking;
use App\Services\BookingNotificationService;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use \Illuminate\Support\Str;


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

    /**
     * MULTI-SLOT: Obtener horarios pero verificando si están bloqueados en caché o en DB.
     */
    public function getSlotsMulti(Request $request, $tutorId)
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

            // Bookings ya realizados (status 0, 1)
            $busyBookings = DB::table('slot_bookings')
                ->where('tutor_id', (int)$tutorId)
                ->whereIn('status', [0, 1])
                ->where('start_time', '>=', $today)
                ->get(['user_subject_slot_id', 'start_time', 'end_time']);

            $now = now();
            $stepMinutes = 20;

            $out = [];
            
            // Evaluamos bloque a bloque
            foreach ($baseSlots as $slot) {
                $dateStr = Carbon::parse($slot->date)->format('Y-m-d');

                $rangeStart = Carbon::parse($dateStr . ' ' . $slot->start_time);
                $rangeEnd   = Carbon::parse($dateStr . ' ' . $slot->end_time);

                $cursor = $rangeStart->copy();

                while ($cursor->copy()->addMinutes($stepMinutes)->lte($rangeEnd)) {
                    $segStart = $cursor->copy();
                    $segEnd   = $cursor->copy()->addMinutes($stepMinutes);

                    if ($segEnd->lte($now) || ($segStart->lte($now) && $segEnd->gt($now))) {
                        $cursor->addMinutes($stepMinutes);
                        continue; // Pasado
                    }

                    $startFormatted = $segStart->format('H:i');
                    $endFormatted = $segEnd->format('H:i');
                    $id = $slot->id . '|' . $startFormatted . '|' . $endFormatted;

                    // 1. Verificamos DB (busy set puede ser más complejo, verificaremos superposición)
                    $isBusy = false;
                    foreach ($busyBookings as $b) {
                        $bStart = Carbon::parse($b->start_time);
                        $bEnd = Carbon::parse($b->end_time);
                        if ($segStart->lt($bEnd) && $segEnd->gt($bStart)) {
                            $isBusy = true;
                            break;
                        }
                    }

                    if ($isBusy) {
                        $cursor->addMinutes($stepMinutes);
                        continue;
                    }

                    // 2. Verificamos Caché (Hold status)
                    $cacheKey = "booking_lock:{$tutorId}:{$dateStr}:{$startFormatted}:{$endFormatted}";
                    $isLocked = Cache::has($cacheKey);

                    // Sólo mandamos los que NO están ocupados (o los mandamos con un flag si quisiéramos)
                    // Como el requerimiento dice: "La vista del paso 2 debe mostrar únicamente los bloques realmente disponibles"
                    if (!$isLocked) {
                        $out[] = [
                            'id' => $id,
                            'date' => $dateStr,
                            'duracion' => $stepMinutes,
                            'available' => true,
                            'status' => 'disponible' // 'disponible'
                        ];
                    }

                    $cursor->addMinutes($stepMinutes);
                }
            }

            return response()->json([
                'success' => true,
                'slots' => $out
            ]);

        } catch (\Exception $e) {
            Log::error('getSlotsMulti error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los horarios'
            ], 500);
        }
    }

    /**
     * MULTI-SLOT: Poner slots en "espera" temporal (15 min) en caché
     */
    public function holdSlotsMulti(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required',
            'slots' => 'required|array',
            'date' => 'required'
        ]);

        $studentId = Auth::id();
        $tutorId = $request->tutor_id;
        $dateStr = $request->date;
        $slots = $request->slots; // arreglo de strings con formato "15|12:00|12:20"

        $lockedKeys = [];

        try {
            foreach ($slots as $slotId) {
                $parts = explode('|', $slotId);
                if (count($parts) !== 3) continue;

                $startFormatted = $parts[1];
                $endFormatted = $parts[2];

                $cacheKey = "booking_lock:{$tutorId}:{$dateStr}:{$startFormatted}:{$endFormatted}";

                // Intentamos meter en caché por 15 mins sin sobreescribir si ya existe
                $added = Cache::add($cacheKey, $studentId, now()->addMinutes(15));
                
                if (!$added) {
                    // Si encontramos UNO que no pudimos bloquear, otro usuario lo tiene
                    // Si el candado es NUESTRO, técnicamente pasaría (pero Cache::add devuelve false si existe)
                    // Entonces evaluamos a quién le pertenece:
                    if (Cache::get($cacheKey) == $studentId) {
                        $lockedKeys[] = $cacheKey; // Ya lo teníamos bloqueado, continuamos
                    } else {
                        // Liberamos lo que llegamos a bloquear
                        foreach ($lockedKeys as $k) {
                            Cache::forget($k);
                        }
                        return response()->json([
                            'success' => false,
                            'message' => "El horario de {$startFormatted} a {$endFormatted} acaba de ser seleccionado por otro estudiante."
                        ]);
                    }
                } else {
                    $lockedKeys[] = $cacheKey;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Horarios reservados temporalmente'
            ]);

        } catch (\Exception $e) {
            foreach ($lockedKeys as $k) {
                Cache::forget($k);
            }
            return response()->json([
                'success' => false,
                'message' => 'Error bloqueando el horario.'
            ], 500);
        }
    }

    /**
     * MULTI-SLOT: Liberar slots en caché
     */
    public function releaseSlotsMulti(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required',
            'slots' => 'required|array',
            'date' => 'required'
        ]);

        $studentId = Auth::id();
        $tutorId = $request->tutor_id;
        $dateStr = $request->date;
        $slots = $request->slots;

        foreach ($slots as $slotId) {
            $parts = explode('|', $slotId);
            if (count($parts) !== 3) continue;

            $startFormatted = $parts[1];
            $endFormatted = $parts[2];

            $cacheKey = "booking_lock:{$tutorId}:{$dateStr}:{$startFormatted}:{$endFormatted}";

            if (Cache::get($cacheKey) == $studentId) {
                Cache::forget($cacheKey);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * MULTI-SLOT: Guardar la reserva finalmente
     */
    public function storeMultiBooking(Request $request, CuponesService $cuponesService)
    {
        Log::info('reservar-multi data:', $request->all());
        $request->validate([
            'subject_id'          => 'required|exists:subjects,id',
            'tutor_id'            => 'required|exists:users,id',
            'slots'               => 'required|array',
            'slot_date'           => 'required',
            'coupon_id'           => 'nullable|exists:coupons,id',
            'is_free'             => 'nullable|in:0,1',
            'comprobante'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tutor_request_token' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $studentId = Auth::id();
            $user      = $request->user();
            $tutorId   = (int) $request->tutor_id;
            $dateStr   = $request->slot_date;
            $slots     = $request->slots;

            if (count($slots) === 0 || count($slots) > 6) {
                DB::rollBack();
                Log::warning('reservar-multi check: count($slots) = ' . count($slots));
                return response()->json(['success' => false, 'message' => 'Cantidad de bloques inválida.'], 400);
            }

            // Extraemos info de los slots
            // Asumimos que los slots vienen ordenados cronológicamente
            $firstSlot = explode('|', $slots[0]);
            $lastSlot = explode('|', end($slots));
            
            $baseSlotId = (int) $firstSlot[0];
            $reqStart = $firstSlot[1]; // e.g. 12:00
            $reqEnd = $lastSlot[2];    // e.g. 13:00

            $startAt = Carbon::parse($dateStr . ' ' . $reqStart . ':00');
            $endAt   = Carbon::parse($dateStr . ' ' . $reqEnd . ':00');

            if ($endAt->lte($startAt) || $endAt->lte(now())) {
                DB::rollBack();
                Log::warning('reservar-multi check: Rango horario inválido o en el pasado. startAt: ' . $startAt->toDateTimeString() . ', endAt: ' . $endAt->toDateTimeString() . ', now: ' . now()->toDateTimeString());
                return response()->json(['success' => false, 'message' => 'Rango horario inválido o en el pasado'], 400);
            }

            // Evitar doble reserva (status 0/1) revisando intersecciones
            $exists = DB::table('slot_bookings')
                ->where('tutor_id', $tutorId)
                ->whereIn('status', [0, 1])
                ->where(function($query) use ($startAt, $endAt) {
                    $query->where('start_time', '<', $endAt->toDateTimeString())
                          ->where('end_time', '>', $startAt->toDateTimeString());
                })->exists();

            if ($exists) {
                DB::rollBack();
                Log::warning('reservar-multi check: Horario ya reservado para tutor: ' . $tutorId);
                return response()->json([
                    'success' => false,
                    'message' => 'Parte de este horario ya ha sido reservado por otro estudiante o no está disponible.'
                ], 400);
            }

            $userSubject = DB::table('user_subject')
                ->where('user_id', $tutorId)
                ->where('subject_id', (int) $request->subject_id)
                ->where('status', 'active')
                ->first();

            if (!$userSubject) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'El tutor no tiene esta materia activa'], 422);
            }

            // Precio base (por hora = 3 bloques, o por fracción?).
            // En storeBooking lo multiplicaba? No, en storeBooking era "El precio base...". Asumimos que el precio base es por los 20 min. O que el paso 3 mandó el calculation
            // Mejor cálculo en server:
            $precioBaseHr = (float) DB::table('profiles')
                ->where('user_id', $tutorId)
                ->value('price');

            if ($precioBaseHr <= 0) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'El tutor no tiene precio configurado'], 422);
            }

            // Cálculo precioBase por totalBlocks: Asumiendo que 1 bloque = el precio devuelto por getTutors (que en _booking-wizard suma el basePrice * bloqueos? Wait, el frontend en el paso 3 recalcTotals solo multiplicaba appliedDiscountPct? 
            // Ojo: En _booking-wizard original basaba todo en currentPrice = basePrice * descuento. 
            // Esto implica que $precioBaseHr equivale a 1 bloque. 
            // Multiplicamos por la cantidad de bloques
            $precioBase = $precioBaseHr * count($slots);

            // CUPÓN (validar)
            $couponId     = $request->coupon_id;
            $couponCodigo = null;
            $descuentoPct = 0;

            if ($couponId) {
                $cupon = Coupon::find($couponId);

                if (!$cupon || ($cupon->estado ?? null) !== 'activo' || (!empty($cupon->fecha_caducidad) && $cupon->fecha_caducidad < now()->toDateString())) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Cupón inválido o vencido'], 422);
                }
                $couponCodigo = (string) $cupon->codigo;
                if ($cuponesService->verificaUsoCupon($couponCodigo, $user)) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'No puedes usar este cupón'], 422);
                }
                $descuentoPct = max(0, min(100, (float) ($cupon->descuento ?? 0)));
            }

            $precioFinal = $precioBase * (1 - ($descuentoPct / 100));
            if ($precioFinal < 0) $precioFinal = 0;

            $isFreeComputed = $precioFinal <= 0.0001;

            $paymentStatus  = $isFreeComputed ? 2 : 1;
            $paymentMethod  = $isFreeComputed ? 'free' : 'transfer';
            $paymentMessage = $isFreeComputed
                ? 'Clase gratuita (cupón 100%) - confirmada automáticamente'
                : 'Pago pendiente de verificación';

            $image_url = null;
            if ($isFreeComputed) {
                $image_url = 'qr/tutoria_gratis.png';
            } else {
                $file = $request->file('comprobante');
                if (!$file) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Falta comprobante'], 422);
                }
                $filename = uniqid() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $dest = public_path('storage/qr');
                if (!file_exists($dest)) mkdir($dest, 0775, true);
                $file->move($dest, $filename);
                $image_url = 'qr/' . $filename;
            }

            $metaData = [
                'date'        => $dateStr,
                'start'       => $reqStart,
                'end'         => $reqEnd,
                'slots'       => $slots,
                'coupon_id'   => $couponId,
                'coupon_code' => $couponCodigo,
                'discount_pct' => $descuentoPct,
                'base_price'  => $precioBase,
                'final_price' => $precioFinal,
                'is_free'     => $isFreeComputed ? 1 : 0,
            ];

            // Crear la reserva única usando el método privado
            $booking = $this->createBooking(
                $studentId,
                $tutorId,
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
            $bookingId = $booking->id;

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
                'image_url'       => $image_url,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            if ($couponId && $couponCodigo) {
                $pivot = UserCoupon::where('coupon_id', (int) $couponId)->where('user_id', (int) $user->id)->first();
                if (!$pivot) {
                    $cuponesService->canjeaCupon($couponCodigo, $user);
                    $pivot = UserCoupon::where('coupon_id', (int) $couponId)->where('user_id', (int) $user->id)->first();
                }
                if (!$pivot || ($pivot->estado ?? null) !== 'activo' || (int) $pivot->cantidad <= 0) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'No puedes usar este cupón (ya fue usado).'], 422);
                }
                $cuponesService->cuponCanjeado($couponCodigo, $user);
            }

            // Liberar holds de caché ya que se convirtió en reserva real
            foreach ($slots as $slotId) {
                $parts = explode('|', $slotId);
                if (count($parts) !== 3) continue;
                Cache::forget("booking_lock:{$tutorId}:{$dateStr}:{$parts[1]}:{$parts[2]}");
            }

            if ($request->filled('tutor_request_token')) {
                DB::table('tutor_requests')
                    ->where('student_token', $request->tutor_request_token)
                    ->update([
                        'status'     => 'paid',
                        'updated_at' => now()
                    ]);
            }

            DB::commit();
            
            return response()->json([
                'success'    => true,
                'message'    => 'Reserva múltiple creada exitosamente',
                'booking_id' => $bookingId
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validación fallida',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeMultiBooking error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la reserva múltiple',
                'debug'   => app()->environment('local') ? $e->getMessage() : null,
            ], 500);
        }
    }
        /**
     * Envía un correo a todos los tutores de una materia
     * cuando no hay tutores disponibles para reservar.
     */
    public function solicitarTutor(Request $request)
    {
        $request->validate([
            'subject_id'     => 'required|integer|exists:subjects,id',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|string|max:30',
            'note'           => 'nullable|string|max:300',
            'tutor_id'       => 'nullable|integer|exists:users,id',
        ]);

        $subjectId     = (int) $request->subject_id;
        $preferredDate = $request->preferred_date;
        $preferredTime = $request->preferred_time;
        $note          = $request->note ?? '';
        $student       = Auth::user();

        // Nombre de la materia
        $subject = DB::table('subjects')->where('id', $subjectId)->first();
        if (!$subject) {
            return response()->json(['success' => false, 'message' => 'Materia no encontrada.'], 404);
        }

        if ($request->filled('tutor_id')) {
            $tutors = User::where('id', (int) $request->tutor_id)->get();
            if ($tutors->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tutor no encontrado.',
                ], 404);
            }
        } else {
            // Obtener tutores que tengan esa materia para notificarles
            $tutorIds = DB::table('user_subject')
                ->where('subject_id', $subjectId)
                ->pluck('user_id')
                ->unique()
                ->values();

            if ($tutorIds->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay tutores registrados para esta materia.',
                ]);
            }

            $tutors = User::whereIn('id', $tutorIds)->get();
        }

        $sent         = 0;
        $errors       = 0;
        $dashboardUrl = url('/tutor/bookings');
        $requestDate  = now()->format('d/m/Y H:i');
        $subjectName  = $subject->name;
        $studentProfile = DB::table('profiles')->where('user_id', $student->id)->first();
        $studentName = ($studentProfile ? trim(($studentProfile->first_name ?? '') . ' ' . ($studentProfile->last_name ?? '')) : '') ?: ($student->name ?? 'Un estudiante');

        // Formatear fecha para mostrar
        try {
            $formattedDate = Carbon::parse($preferredDate)->translatedFormat('l d \d\e F \d\e Y');
        } catch (\Throwable $e) {
            $formattedDate = $preferredDate;
        }

        foreach ($tutors as $tutor) {
            try {
                $tutorToken = Str::random(40);
                $studentToken = Str::random(40);

                // Calcular duración de forma dinámica a partir del rango
                $durationStr = '20 min';
                if (strpos($preferredTime, ' - ') !== false) {
                    try {
                        list($startStr, $endStr) = explode(' - ', $preferredTime);
                        $startC = Carbon::parse($startStr);
                        $endC = Carbon::parse($endStr);
                        $diffMins = $endC->diffInMinutes($startC);
                        if ($diffMins == 20) $durationStr = '20 min';
                        elseif ($diffMins == 40) $durationStr = '40 min';
                        elseif ($diffMins == 60) $durationStr = '1 hora';
                        elseif ($diffMins == 80) $durationStr = '1h 20m';
                        elseif ($diffMins == 100) $durationStr = '1h 40m';
                        elseif ($diffMins == 120) $durationStr = '2 horas';
                    } catch (\Throwable $e) {
                        // fallback
                    }
                }

                // Guardar en la base de datos
                DB::table('tutor_requests')->insert([
                    'student_id'       => $student->id,
                    'tutor_id'         => $tutor->id,
                    'subject_id'       => $subjectId,
                    'status'           => 'pending',
                    'current_date'     => $preferredDate,
                    'current_time'     => $preferredTime,
                    'current_duration' => $durationStr,
                    'note'             => $note,
                    'student_token'    => $studentToken,
                    'tutor_token'      => $tutorToken,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                // Obtener tutor name
                $tutorProfile = DB::table('profiles')->where('user_id', $tutor->id)->first();
                $tutorName = ($tutorProfile ? trim(($tutorProfile->first_name ?? '') . ' ' . ($tutorProfile->last_name ?? '')) : '') ?: 'Tutor';

                $actionUrl = route('tutor-request.negotiate', ['token' => $tutorToken]);

                Mail::send(
                    'emails.solicitar-tutor',
                    [
                        'tutorName'     => $tutorName,
                        'subjectName'   => $subjectName,
                        'requestDate'   => $requestDate,
                        'preferredDate' => $formattedDate,
                        'preferredTime' => $preferredTime,
                        'note'          => $note,
                        'studentName'   => $studentName,
                        'dashboardUrl'  => $dashboardUrl,
                        'actionUrl'     => $actionUrl,
                    ],
                    function ($message) use ($tutor, $subjectName) {
                        $message->to($tutor->email)
                                ->subject("📚 Solicitud de tutoría: {$subjectName}");
                    }
                );
                $sent++;
            } catch (\Throwable $e) {
                Log::error("solicitarTutor: error al enviar correo a {$tutor->email}: " . $e->getMessage());
                $errors++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Solicitud enviada a {$sent} tutor(es) de {$subjectName}.",
            'sent'    => $sent,
            'errors'  => $errors,
        ]);
    }

    public function showNegotiation($token)
    {
        $request = DB::table('tutor_requests')
            ->where('tutor_token', $token)
            ->orWhere('student_token', $token)
            ->first();

        if (!$request) {
            abort(404, 'Solicitud no encontrada.');
        }

        $role = ($request->tutor_token === $token) ? 'tutor' : 'student';

        $student = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $request->student_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $tutor = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $request->tutor_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name', 'profiles.price')
            ->first();
        $subject = DB::table('subjects')->where('id', $request->subject_id)->first();

        try {
            $formattedDate = Carbon::parse($request->current_date)->translatedFormat('l d \d\e F \d\e Y');
        } catch (\Throwable $e) {
            $formattedDate = $request->current_date;
        }

        // Verificar si el horario ya fue reservado en la base de datos
        $isSlotBooked = false;
        $meetingLink = null;
        if (in_array($request->status, ['accepted', 'countered_by_tutor', 'paid'])) {
            try {
                $durationMins = 20;
                $dur = strtolower($request->current_duration);
                if (strpos($dur, '20') !== false) $durationMins = 20;
                elseif (strpos($dur, '40') !== false) $durationMins = 40;
                elseif (strpos($dur, '1 hora') !== false || $dur === '1h' || strpos($dur, '60') !== false) $durationMins = 60;
                elseif (strpos($dur, '1h 20') !== false || strpos($dur, '1h 20m') !== false || strpos($dur, '80') !== false) $durationMins = 80;
                elseif (strpos($dur, '1h 40') !== false || strpos($dur, '1h 40m') !== false || strpos($dur, '100') !== false) $durationMins = 100;
                elseif (strpos($dur, '2 hora') !== false || $dur === '2h' || strpos($dur, '120') !== false) $durationMins = 120;

                $timeStr = trim($request->current_time);
                if (strpos($timeStr, ' - ') !== false) {
                    list($startStr, $endStr) = explode(' - ', $timeStr);
                } else {
                    $startStr = $timeStr;
                }

                $startStr = trim($startStr);
                if (preg_match('/^(\d+):(\d+)\s*(AM|PM)$/i', $startStr, $matches)) {
                    $hours = (int)$matches[1];
                    $minutes = (int)$matches[2];
                    $ampm = strtoupper($matches[3]);
                    if ($ampm === 'PM' && $hours !== 12) $hours += 12;
                    if ($ampm === 'AM' && $hours === 12) $hours = 0;
                } else {
                    list($hours, $minutes) = explode(':', $startStr);
                    $hours = (int)$hours;
                    $minutes = (int)$minutes;
                }

                $startAt = Carbon::parse($request->current_date)->setTime($hours, $minutes, 0);
                $endAt = $startAt->copy()->addMinutes($durationMins);

                if ($request->status === 'paid') {
                    $booking = DB::table('slot_bookings')
                        ->where('student_id', $request->student_id)
                        ->where('tutor_id', $request->tutor_id)
                        ->where('start_time', $startAt->toDateTimeString())
                        ->first();
                    if ($booking) {
                        $meetingLink = $booking->meeting_link;
                    }
                } else {
                    $isSlotBooked = DB::table('slot_bookings')
                        ->where('tutor_id', $request->tutor_id)
                        ->whereIn('status', [0, 1])
                        ->where(function($query) use ($startAt, $endAt) {
                            $query->where('start_time', '<', $endAt->toDateTimeString())
                                  ->where('end_time', '>', $startAt->toDateTimeString());
                        })->exists();
                }
            } catch (\Throwable $e) {
                // Ignore parse errors, default false
            }
        }

        return view('vistas.view.pages.solicitud-tutor', compact('request', 'role', 'student', 'tutor', 'subject', 'formattedDate', 'token', 'isSlotBooked', 'meetingLink'));
    }

    public function rejectNegotiation($token)
    {
        $tRequest = DB::table('tutor_requests')
            ->where('tutor_token', $token)
            ->orWhere('student_token', $token)
            ->first();

        if (!$tRequest || in_array($tRequest->status, ['rejected', 'accepted'])) {
            return response()->json(['success' => false, 'message' => 'Solicitud no válida o ya finalizada.'], 422);
        }

        $role = ($tRequest->tutor_token === $token) ? 'tutor' : 'student';

        DB::table('tutor_requests')->where('id', $tRequest->id)->update([
            'status'     => 'rejected',
            'updated_at' => now(),
        ]);

        $student = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->student_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $tutor = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->tutor_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $subject = DB::table('subjects')->where('id', $tRequest->subject_id)->first();
        $subjectName = $subject->name;

        $recipient = ($role === 'tutor') ? $student : $tutor;
        $senderName = ($role === 'tutor') ? ($tutor->full_name ?: ($tutor->name ?? 'Tutor')) : ($student->full_name ?: ($student->name ?? 'Estudiante'));

        try {
            Mail::send(
                'emails.solicitud-tutor-rechazada',
                [
                    'recipientName' => $recipient->full_name ?: ($recipient->name ?? 'Usuario'),
                    'senderName'    => $senderName,
                    'subjectName'   => $subjectName,
                ],
                function ($message) use ($recipient, $subjectName) {
                    $message->to($recipient->email)
                            ->subject("❌ Solicitud de tutoría rechazada: {$subjectName}");
                }
            );
        } catch (\Throwable $e) {
            Log::error("rejectNegotiation mail error: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Solicitud rechazada con éxito.']);
    }

    public function acceptNegotiation($token)
    {
        $tRequest = DB::table('tutor_requests')
            ->where('tutor_token', $token)
            ->orWhere('student_token', $token)
            ->first();

        if (!$tRequest || in_array($tRequest->status, ['rejected', 'accepted'])) {
            return response()->json(['success' => false, 'message' => 'Solicitud no válida o ya finalizada.'], 422);
        }

        $role = ($tRequest->tutor_token === $token) ? 'tutor' : 'student';

        DB::table('tutor_requests')->where('id', $tRequest->id)->update([
            'status'     => 'accepted',
            'updated_at' => now(),
        ]);

        $student = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->student_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $tutor = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->tutor_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $subject = DB::table('subjects')->where('id', $tRequest->subject_id)->first();
        $subjectName = $subject->name;

        // Si el tutor acepta, notificar al estudiante con su student_token
        if ($role === 'tutor') {
            $actionUrl = route('tutor-request.negotiate', ['token' => $tRequest->student_token]) . '?open_payment=1';
            try {
                Mail::send(
                    'emails.solicitud-tutor-aceptada',
                    [
                        'studentName'   => $student->full_name ?: ($student->name ?? 'Estudiante'),
                        'tutorName'     => $tutor->full_name ?: ($tutor->name ?? 'Tutor'),
                        'subjectName'   => $subjectName,
                        'preferredDate' => $tRequest->current_date,
                        'preferredTime' => $tRequest->current_time,
                        'actionUrl'     => $actionUrl,
                    ],
                    function ($message) use ($student, $subjectName) {
                        $message->to($student->email)
                                ->subject("✅ ¡Propuesta de tutoría aceptada!: {$subjectName}");
                    }
                );
            } catch (\Throwable $e) {
                Log::error("acceptNegotiation mail error: " . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'message' => 'Solicitud aceptada con éxito.']);
    }

    public function counterNegotiation(Request $request, $token)
    {
        $request->validate([
            'counter_date'     => 'required|date|after_or_equal:today',
            'counter_time'     => 'required|string|max:50',
            'counter_duration' => 'required|string|max:50',
            'note'             => 'nullable|string|max:300',
        ]);

        $tRequest = DB::table('tutor_requests')
            ->where('tutor_token', $token)
            ->orWhere('student_token', $token)
            ->first();

        if (!$tRequest || in_array($tRequest->status, ['rejected', 'accepted'])) {
            return response()->json(['success' => false, 'message' => 'Solicitud no válida o ya finalizada.'], 422);
        }

        $role = ($tRequest->tutor_token === $token) ? 'tutor' : 'student';
        $newStatus = ($role === 'tutor') ? 'countered_by_tutor' : 'countered_by_student';

        DB::table('tutor_requests')->where('id', $tRequest->id)->update([
            'status'           => $newStatus,
            'current_date'     => $request->counter_date,
            'current_time'     => $request->counter_time,
            'current_duration' => $request->counter_duration,
            'note'             => $request->note ?? '',
            'updated_at'       => now(),
        ]);

        $student = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->student_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $tutor = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', $tRequest->tutor_id)
            ->select('users.*', DB::raw("TRIM(CONCAT(COALESCE(profiles.first_name,''), ' ', COALESCE(profiles.last_name,''))) as full_name"), 'profiles.first_name', 'profiles.last_name')
            ->first();

        $subject = DB::table('subjects')->where('id', $tRequest->subject_id)->first();
        $subjectName = $subject->name;

        $recipient = ($role === 'tutor') ? $student : $tutor;
        $recipientToken = ($role === 'tutor') ? $tRequest->student_token : $tRequest->tutor_token;
        $senderName = ($role === 'tutor') ? ($tutor->full_name ?: ($tutor->name ?? 'Tutor')) : ($student->full_name ?: ($student->name ?? 'Estudiante'));

        $actionUrl = route('tutor-request.negotiate', ['token' => $recipientToken]);

        try {
            Mail::send(
                'emails.solicitud-tutor-contraoferta',
                [
                    'recipientName'   => $recipient->full_name ?: ($recipient->name ?? 'Usuario'),
                    'senderName'      => $senderName,
                    'subjectName'     => $subjectName,
                    'counterDate'     => $request->counter_date,
                    'counterTime'     => $request->counter_time,
                    'counterDuration' => $request->counter_duration,
                    'note'            => $request->note ?? '',
                    'actionUrl'       => $actionUrl,
                ],
                function ($message) use ($recipient, $subjectName) {
                    $message->to($recipient->email)
                            ->subject("🔄 Nueva contrapropuesta de tutoría: {$subjectName}");
                }
            );
        } catch (\Throwable $e) {
            Log::error("counterNegotiation mail error: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Contrapropuesta enviada con éxito.']);
    }

    public function getCounterDetails($token)
    {
        $tRequest = DB::table('tutor_requests')->where('student_token', $token)->first();

        if (!$tRequest) {
            return response()->json(['success' => false, 'message' => 'Propuesta no encontrada.'], 404);
        }

        if (in_array($tRequest->status, ['rejected'])) {
            return response()->json(['success' => false, 'message' => 'Esta propuesta ya fue rechazada.'], 422);
        }

        $tutor = DB::table('users')->where('id', $tRequest->tutor_id)->first();
        $subject = DB::table('subjects')->where('id', $tRequest->subject_id)->first();

        $price = (float) DB::table('profiles')->where('user_id', $tRequest->tutor_id)->value('price');

        return response()->json([
            'success'          => true,
            'tutor_id'         => $tRequest->tutor_id,
            'tutor_name'       => $tutor->name ?? (isset($tutor->first_name) ? $tutor->first_name : 'Tutor'),
            'subject_id'       => $tRequest->subject_id,
            'subject_name'     => $subject->name,
            'counter_date'     => $tRequest->current_date,
            'counter_time'     => $tRequest->current_time,
            'counter_duration' => $tRequest->current_duration,
            'price'            => $price,
            'status'           => $tRequest->status,
        ]);
    }
}
