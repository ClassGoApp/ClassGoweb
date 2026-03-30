<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlotBookingResource;
use App\Models\User;
use App\Services\BookingService;
use App\Services\SlotBookingService;
use App\Http\Resources\SubjectGroupResource;
use App\Services\SubjectService;
use App\Http\Resources\SubjectResource;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;
use App\Services\CuponesService;
use App\Models\UserCoupon;

class BookingController extends Controller
{
    use ApiResponser;
    public float $porcentaje = 0.0;
    public float $montoFinal = 0.0;
    public float $descuento = 0.0;
    public $cuponesUsuario = [];
    public $cuponCode = '';
    public Carbon $currentDate;
    public $paymentReceipt;

    public function getUpComingBooking(Request $request)
    {
        $filter         = $request->filter ?? [];
        $showBy         = $request->show_by;
        $type           = $request->type;

        $user = User::where('id', Auth::user()->id)->first();

        if (!$user) {
            return $this->error(data: null,message: __('api.user_not_found'),code: Response::HTTP_NOT_FOUND);
        }

        if($showBy == 'daily'){
            if (!empty($request->start_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->format('Y-m-d');
                $endDate    = Carbon::parse($request->end_date,getUserTimezone())->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->format('Y-m-d');

            }

        } else if($showBy == 'weekly'){
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                $endDate    = Carbon::parse($request->start_date,getUserTimezone())->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->endOfWeek(Carbon::SATURDAY)->format('Y-m-d');
            }
        } else {
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $startDate  = Carbon::parse($request->start_date,getUserTimezone())->firstOfMonth()->format('Y-m-d');
                $endDate    = Carbon::parse($request->start_date,getUserTimezone())->lastOfMonth()->format('Y-m-d');
            }
            else {
                $startDate  =   Carbon::now(getUserTimezone())->firstOfMonth()->format('Y-m-d');
                $endDate    =   Carbon::now(getUserTimezone())->lastOfMonth()->format('Y-m-d');
            }
        }

        if ($type == 'prev' && $showBy == 'daily') {
            $startDate  = Carbon::parse($startDate)->subDays()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subDays()->format('Y-m-d');
        } elseif ($type == 'next' && $showBy == 'daily' ) {
            $startDate  = Carbon::parse($startDate)->addDays()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addDays()->format('Y-m-d');
        } elseif ($type == 'prev' && $showBy == 'weekly') {
            $startDate  = Carbon::parse($startDate)->subWeek()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subWeek()->format('Y-m-d');
        } elseif ($type == 'next'  && $showBy == 'weekly') {
            $startDate  = Carbon::parse($startDate)->addWeek()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addWeek()->format('Y-m-d');
        } elseif ($type == 'prev') {
            $startDate  = Carbon::parse($startDate)->subMonth()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->subMonth()->format('Y-m-d');
        } elseif ($type == 'next') {
            $startDate  = Carbon::parse($startDate)->addMonth()->format('Y-m-d');
            $endDate    = Carbon::parse($endDate)->addMonth()->format('Y-m-d');
        }

        $dateRange = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59",
        ];

        $bookingService = new BookingService(Auth::user());
        $upcomingBookings = $bookingService->getUserBookings($dateRange, $showBy, $filter);
        $userSlot = [
            'start_date'    => $startDate." 00:00:00",
            'end_date'      => $endDate." 23:59:59"
        ];

        foreach ($upcomingBookings as $date => $slots) {
           $userSlot[$date] = SlotBookingResource::collection($slots);
        }

        return $this->success(data: $userSlot);
    }

    public function getSubjectGroups()
    {
        $subjectGroups = (new subjectService)->getSubjectGroups();
        return $this->success(data: SubjectGroupResource::collection($subjectGroups));
    }

    public function getSubjects()
    {
        $subjects = (new subjectService)->getSubjects();
        return $this->success(data: SubjectResource::collection($subjects));
    }

    public function getUserBookingsById($id, Request $request)
    {
        // Buscar tutorías donde el usuario sea tutor o estudiante
        $bookings = \App\Models\SlotBooking::where('tutor_id', $id)
            ->orWhere('student_id', $id)
            ->orderBy('start_time')
            ->get();
        return response()->json($bookings);
    }

    public function storeSlotBooking(Request $request, CuponesService $cuponesService)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'tutor_id' => 'required|exists:users,id',
            'user_subject_slot_id' => 'nullable|exists:user_subject_slots,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'session_fee' => 'required|numeric',
            'booked_at' => 'nullable|date',
            'calendar_event_id' => 'nullable|string',
            'meeting_link' => 'nullable|string',
            'status' => 'nullable|integer',
            'meta_data' => 'nullable|array',
            'subject_id' => 'nullable|exists:subjects,id'
        ]);

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
            $studentId = $request->student_id;
            $user = User::find($studentId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

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

    public function storePaymentSlotBooking(Request $request)
    {
        $validated = $request->validate([
            'slot_booking_id' => 'required|exists:slot_bookings,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Guardar la imagen directamente en public/storage/uploads/bookings con un nombre aleatorio
        $randomName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
        $destinationPath = public_path('storage/uploads/bookings');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $request->file('image')->move($destinationPath, $randomName);
        $relativePath = 'uploads/bookings/' . $randomName;

        $paymentSlotBooking = \App\Models\PaymentSlotBooking::create([
            'slot_booking_id' => $validated['slot_booking_id'],
            'image_url' => $relativePath,
        ]);
        return response()->json($paymentSlotBooking, 201);
    }

}
