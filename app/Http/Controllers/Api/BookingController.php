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
use App\Services\BookingNotificationService;
use Illuminate\Support\Facades\Log;
use App\Services\PagosTutorReservaService;
use App\Services\interfaces\ICuponesService;
use App\Services\ImagenesService;
use App\Models\PaymentSlotBooking;

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

    public function storeSlotBooking(Request $request)
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

        $slotBooking = \App\Models\SlotBooking::create($validated);
        $pagostutorreserva = new PagosTutorReservaService();
        $sessionFee = $this->montoFinal;
        $service = $this->cuponservice ?? app(ICuponesService::class);
        $this->currentDate = Carbon::now();
        $isAugustPromotion = $this->currentDate->month === 9;

        // Si no se proporcionó meeting_link en la request, generarlo usando SlotBookingService
        if (empty($validated['meeting_link'])) {
            $slotService = new SlotBookingService();
            // generarlink espera un objeto con al menos start_time y tutor_id
            $meetingSource = new \stdClass();
            $meetingSource->start_time = $slotBooking->start_time;
            $meetingSource->tutor_id = $slotBooking->tutor_id;
            $link = $slotService->generarlink($meetingSource);
            if ($link) {
                $slotBooking->meeting_link = $link;
                $slotBooking->save();
            }
        }

        if ($this->porcentaje != null || $this->porcentaje != 0) {
                $sessionFee = $sessionFee - ($sessionFee * $this->porcentaje / 100);
        }

        if (!empty($this->cuponCode)) {
                $service->cuponCanjeado($this->cuponCode, auth()->user());
                $this->cuponesUsuario = $service->todosLosCupones(auth()->user());
        }

        if ($this->porcentaje == 100 || $isAugustPromotion) {
            // Usar imagen por defecto para promoción
            $path = 'qr/77b1a7da.jpg'; // Imagen por defecto
        } else {
            // Guardar imagen del usuario
            $imageService = app(ImagenesService::class);
            $path = $imageService->guardarqrEstudianteReserva($this->paymentReceipt);
        }

        // Enviar notificación (inspirado en crearReserva)
        try {
            $notificationService = app(BookingNotificationService::class);
            $notificationService->handleStatusChangeNotification($slotBooking, '', $slotBooking->status);
        } catch (\Throwable $e) {
            Log::error('Notification error: ' . $e->getMessage());
            // No fallar la reserva por error en notificación
        }

        // 3. Crear registro de pago
        PaymentSlotBooking::create([
            'slot_booking_id' => $slotBooking->id,
            'image_url' => $path,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // 4. Crear registro de pago del tutor
        $pagostutorreserva->create(
            slot_booking_id: $slotBooking->id,
            payment_date: now(),
            amount: 10,
            message: ''
        );

        return response()->json($slotBooking, 201);
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
