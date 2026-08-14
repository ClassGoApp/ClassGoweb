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
use Illuminate\Support\Facades\Mail;
use App\Models\Coupon;
use App\Services\CuponesService;
use App\Models\UserCoupon;
use App\Models\SlotBooking;
use App\Services\BookingNotificationService;
use \Illuminate\Support\Str;
use App\Services\FcmService;

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
        // Mismos campos que muestra la web (tutor/estudiante = first_name + last_name de profiles,
        // materia = subject->name, archivos = attachments count).
        $bookings = \App\Models\SlotBooking::where('tutor_id', $id)
            ->orWhere('student_id', $id)
            ->with([
                'tutor:profiles.id,profiles.user_id,profiles.first_name,profiles.last_name',
                'student:profiles.id,profiles.user_id,profiles.first_name,profiles.last_name',
                'subject:id,name',
            ])
            ->withCount('attachments')
            ->orderBy('start_time')
            ->get();

        $data = $bookings->map(function ($booking) {
            $tutorName = $booking->tutor
                ? trim(($booking->tutor->first_name ?? '') . ' ' . ($booking->tutor->last_name ?? ''))
                : 'Tutor';
            $studentName = $booking->student
                ? trim(($booking->student->first_name ?? '') . ' ' . ($booking->student->last_name ?? ''))
                : 'Estudiante';
            if ($tutorName === '') {
                $tutorName = 'Tutor';
            }
            if ($studentName === '') {
                $studentName = 'Estudiante';
            }

            $booking->tutor_name = $tutorName;
            $booking->student_name = $studentName;
            $booking->subject_name = $booking->subject?->name;

            return $booking->makeHidden(['tutor', 'student', 'subject']);
        });

        return response()->json($data);
    }

    //Metodo auxiliar para crear la reserva
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

    public function storeSlotBooking(Request $request, CuponesService $cuponesService)
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
                // Notificar al correo empresarial (MAIL_ADMIN) que un estudiante solicitó una materia sin tutores registrados
                $adminEmail = env('MAIL_ADMIN') ?: config('mail.from.admin');
                if ($adminEmail) {
                    try {
                        Mail::send(
                            'emails.admin-solicitud-horario',
                            [
                                'studentName'   => $studentName,
                                'studentEmail'  => $student->email ?? '',
                                'subjectName'   => $subjectName,
                                'preferredDate' => $formattedDate,
                                'preferredTime' => $preferredTime,
                                'note'          => $note,
                                'requestDate'   => $requestDate,
                            ],
                            function ($message) use ($adminEmail, $subjectName) {
                                $message->to($adminEmail)
                                        ->subject("🗓️ Nueva solicitud de materia sin tutores: {$subjectName}");
                            }
                        );
                        Log::info("solicitarTutor API: Correo enviado a admin ({$adminEmail}) por materia sin tutores: {$subjectName}");
                    } catch (\Throwable $e) {
                        Log::error('solicitarTutor API: error al notificar al correo empresarial por materia sin tutores: ' . $e->getMessage());
                    }
                }

                return response()->json([
                    'success' => false,
                    'message' => 'No hay tutores registrados para esta materia.',
                ]);
            }

            $tutors = User::whereIn('id', $tutorIds)->get();
        }

        foreach ($tutors as $tutor) {
            try {
                $tutorToken = Str::random(40);
                $studentToken = Str::random(40);

                // Calcular duración de forma dinámica a partir del rango
                $durationStr = '20 min';
                if (strpos($preferredTime, '-') !== false) {
                    try {
                        $parts = explode('-', $preferredTime);
                        $startC = Carbon::parse($preferredDate . ' ' . trim($parts[0]));
                        $endC   = Carbon::parse($preferredDate . ' ' . trim($parts[1]));
                        if ($endC->lt($startC)) {
                            $endC->addDay();
                        }
                        $diffMins = (int) abs($startC->diffInMinutes($endC));
                        if ($diffMins > 0) {
                            if ($diffMins == 60) {
                                $durationStr = '1 hora';
                            } elseif ($diffMins == 120) {
                                $durationStr = '2 horas';
                            } elseif ($diffMins < 60) {
                                $durationStr = "{$diffMins} min";
                            } else {
                                $hrs = (int) floor($diffMins / 60);
                                $mins = $diffMins % 60;
                                $durationStr = "{$hrs}h" . ($mins > 0 ? " {$mins}m" : "");
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::warning('Api solicitarTutor parse duration error: ' . $e->getMessage());
                    }
                }

                //Obtner tutor
                $tutorProfile = DB::table('profiles')->where('user_id', $tutor->id)->first();
                $tutorName = ($tutorProfile ? trim(($tutorProfile->first_name ?? '') . ' ' . ($tutorProfile->last_name ?? '')) : '') ?: ($tutor->name ?? 'Tutor');

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

                // Obtener TODOS los tokens FCM activos del tutor
                $tutorTokens = DB::table('fcm_tokens')
                    ->where('user_id', $tutor->id)
                    ->whereNotNull('token')
                    ->where('token', '!=', '')
                    ->pluck('token')
                    ->unique()
                    ->toArray();

                if (!empty($tutorTokens)) {
                    $fcmService = new FcmService();
                    $fcmService->sendNotificationToTokens(
                        $tutorTokens,
                        'Nueva solicitud de tutoría',
                        "El estudiante {$studentName} te ha solicitado una tutoría de {$subjectName}.",
                        [
                            'type' => 'solicitud_tutor_personalizada',
                            'screen' => 'solicitud_detalle',
                            'data_tutor' => json_encode([
                                'id' => $tutor->id,
                                'nombre' => $studentName,
                                'materia' => $subjectName,
                                'date' => $preferredDate,
                                'time' => $preferredTime,
                                'duration' => $durationStr,
                                'note' => $note,
                                'token' => $tutorToken,
                            ]),
                        ]
                    );
                }
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
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.'], 404);
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

        return response()->json([
            'success'       => true,
            'request'       => $request,
            'role'          => $role,
            'student'       => $student,
            'tutor'         => $tutor,
            'subject'       => $subject,
            'formattedDate' => $formattedDate,
            'token'         => $token,
            'isSlotBooked'  => $isSlotBooked,
            'meetingLink'   => $meetingLink
        ]);
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
             // Obtener TODOS los tokens FCM activos del destinatario
                $recipientTokens = DB::table('fcm_tokens')
                    ->where('user_id', $recipient->id)
                    ->whereNotNull('token')
                    ->where('token', '!=', '')
                    ->pluck('token')
                    ->unique()
                    ->toArray();

                if (!empty($recipientTokens)) {
                    $recipientToken = ($role === 'tutor') ? $tRequest->student_token : $tRequest->tutor_token;
                    $fcmService = new FcmService();
                    $fcmService->sendNotificationToTokens(
                        $recipientTokens,
                        'Solicitud de tutoría rechazada',
                        "La solicitud de tutoría de {$subjectName} fue rechazada por {$senderName}.",
                        [
                            'type' => 'solicitud_tutor_personalizada',
                            'screen' => 'solicitud_detalle',
                            'data_tutor' => json_encode([
                                'id' => $tRequest->id,
                                'token' => $recipientToken,
                                'status' => 'rejected',
                            ]),
                        ]
                    );
                }
        } catch (\Throwable $e) {
            Log::error("rejectNegotiation error: " . $e->getMessage());
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

        // Enviar notificación push (FCM)
        try {
            $recipient = ($role === 'tutor') ? $student : $tutor;
            $recipientToken = ($role === 'tutor') ? $tRequest->student_token : $tRequest->tutor_token;
            $senderName = ($role === 'tutor') ? ($tutor->full_name ?: ($tutor->name ?? 'Tutor')) : ($student->full_name ?: ($student->name ?? 'Estudiante'));
            $body = ($role === 'tutor') 
                ? "El tutor {$senderName} ha aceptado tu solicitud de tutoría de {$subjectName}."
                : "El estudiante {$senderName} ha aceptado tu propuesta de tutoría de {$subjectName}.";

            $recipientTokens = DB::table('fcm_tokens')
                ->where('user_id', $recipient->id)
                ->whereNotNull('token')
                ->where('token', '!=', '')
                ->pluck('token')
                ->unique()
                ->toArray();

            if (!empty($recipientTokens)) {
                $fcmService = new FcmService();
                $fcmService->sendNotificationToTokens(
                    $recipientTokens,
                    'Propuesta de tutoría aceptada',
                    $body,
                    [
                        'type' => 'solicitud_tutor_personalizada',
                        'screen' => 'solicitud_detalle',
                        'data_tutor' => json_encode([
                            'id' => $tRequest->id,
                            'token' => $recipientToken,
                            'status' => 'accepted',
                        ]),
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("acceptNegotiation FCM error: " . $e->getMessage());
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

        // Enviar notificación push (FCM)
        try {
            $recipientTokens = DB::table('fcm_tokens')
                ->where('user_id', $recipient->id)
                ->whereNotNull('token')
                ->where('token', '!=', '')
                ->pluck('token')
                ->unique()
                ->toArray();

            if (!empty($recipientTokens)) {
                $fcmService = new FcmService();
                $fcmService->sendNotificationToTokens(
                    $recipientTokens,
                    'Nueva contrapropuesta de tutoría',
                    "{$senderName} ha enviado una contrapropuesta para la tutoría de {$subjectName}.",
                    [
                        'type' => 'solicitud_tutor_personalizada',
                        'screen' => 'solicitud_detalle',
                        'data_tutor' => json_encode([
                            'id' => $tRequest->id,
                            'token' => $recipientToken,
                            'status' => $newStatus,
                            'date' => $request->counter_date,
                            'time' => $request->counter_time,
                            'duration' => $request->counter_duration,
                            'note' => $request->note ?? '',
                        ]),
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error("counterNegotiation FCM error: " . $e->getMessage());
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

