<?php

namespace App\Livewire\Pages\Common\Bookings;

use App\Jobs\CompleteBookingJob;
use App\Livewire\Forms\Student\Booking\RatingForm;
use App\Models\Day;
use App\Services\BookingService;
use App\Services\SubjectService;
use App\Services\WalletService;
use Illuminate\Support\Str; 
use App\Models\SlotBooking;
use App\Models\User;
use App\Jobs\SendNotificationJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\DisputeService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class UserBooking extends Component
{

    public $currentDate, $showBy, $days, $startOfWeek;
    public $disablePrevious, $isCurrent = false;
    public $dateRange = [];
    public $subjectGroups, $upcomingBookings, $currentBooking;
    public $filter = [];
    public $visibleStartTime = null;
    public $earliestDate = null;
    public RatingForm $form;
    public $activeRoute;
    public $disputeReason = '';
    public $userBooking;
    public $description = '';
    public $selectedReason = '';
    public $bookings = [];
    protected $bookingService, $subjectService, $disputeService;
    public function boot() {
        $this->bookingService = new BookingService(Auth::user());
        $this->subjectService  = new SubjectService(Auth::user());
        $this->disputeService = new DisputeService(Auth::user());
    }

    public function mount() {
        $this->disputeReason = setting('_dispute_setting.dispute_reasons') ?? [];
        if (is_array($this->disputeReason) && !empty($this->disputeReason)) {
            $this->disputeReason = array_column($this->disputeReason, 'dispute_reason', 'id');
        } else {
            $this->disputeReason = [];
        }
        $this->showBy   = 'daily';
        $this->startOfWeek = (int) (setting('_lernen.start_of_week') ?? Carbon::SUNDAY);
        $this->currentDate = parseToUserTz(Carbon::now());
        $this->days = Day::get($this->startOfWeek);
        $this->getRange();
        $this->subjectGroups = $this->subjectService->getSubjectsByUserRole();
        $this->dispatchSessionMessages();
        $this->activeRoute = Route::currentRouteName();

        // Obtener las reservas del usuario logueado
        $this->bookings = SlotBooking::getBookingsByStudent(Auth::id())->map(function($booking) {
            return [
                'title' => $booking->status,
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => $booking->status === 'confirmed' ? 'green' : ($booking->status === 'pending' ? 'orange' : 'red')
            ];
        });
        //dd($this->bookings, "aver");
    }

    #[Layout('layouts.app')]
   public function render()
{
    // Cargar reservas desde la BD en memoria (mismas relaciones que se usan en la vista)
    $query = SlotBooking::with(['subject', 'tutor', 'booker'])->orderBy('start_time');

    if (Auth::user()->role == 'tutor') {
        $query->where('tutor_id', Auth::id());
        // Nota: BookingService aplica más restricciones por estado para tutor; aquí dejamos la carga completa y
        // aplicamos los filtros en memoria a continuación.
    } elseif (Auth::user()->role == 'student') {
        $query->where('student_id', Auth::id());
    } else {
        $this->upcomingBookings = [];
        return view('livewire.pages.common.bookings.user-booking', [
            'bookings' => $this->bookings,
            'upcomingBookings' => $this->upcomingBookings,
            'currentDate' => $this->currentDate,
        ]);
    }

    // Aplicar siempre el rango de fechas calculado (daily/weekly/monthly) para limitar los resultados visibles
    if (!empty($this->dateRange['start_date']) && !empty($this->dateRange['end_date'])) {
        $query->where('start_time', '>=', $this->dateRange['start_date']);
        $query->where('end_time', '<=', $this->dateRange['end_date']);
    }

    $bookings = $query->get();

    // Aplicar filtros en memoria según la propiedad $this->filter enviada desde la vista
    $filters = is_array($this->filter) ? $this->filter : [];

    $filtered = $bookings->filter(function ($booking) use ($filters) {
        // Filtrado por palabra clave (busca en materia y nombres de tutor/estudiante y estado)
        if (!empty($filters['keyword'])) {
            $kw = mb_strtolower(trim($filters['keyword']));
            $subject = mb_strtolower($booking->subject->name ?? '');
            $tutorName = mb_strtolower(trim((($booking->tutor->first_name ?? '') . ' ' . ($booking->tutor->last_name ?? ''))));
            $studentName = mb_strtolower(trim((($booking->booker->first_name ?? '') . ' ' . ($booking->booker->last_name ?? ''))));
            $status = mb_strtolower((string)($booking->status ?? ''));

            if (str_contains($subject, $kw) === false && str_contains($tutorName, $kw) === false && str_contains($studentName, $kw) === false && str_contains($status, $kw) === false) {
                return false;
            }
        }

        // Filtrado por materia (array de ids)
        if (!empty($filters['subject_group_ids']) && is_array($filters['subject_group_ids'])) {
            // Los valores vienen como strings desde select2; convertir a enteros para comparar con subject_id
            $ids = array_map('intval', $filters['subject_group_ids']);
            if (empty($booking->subject_id) || !in_array((int)$booking->subject_id, $ids, true)) {
                return false;
            }
        }

        // Filtrado por tipo de sesión (si está disponible en meta_data)
        if (!empty($filters['type']) && $filters['type'] !== '*') {
            $type = $filters['type'];
            $metaType = $booking->meta_data['session_type'] ?? $booking->meta_data['type'] ?? null;
            if ($metaType !== null && (string)$metaType !== (string)$type) {
                return false;
            }
        }

        return true;
    })->values();

    // Determinar el primer elemento filtrado para centrar/recortar la vista
    if ($filtered->isNotEmpty()) {
        $first = $filtered->sortBy(function ($b) {
            return $b->start_time;
        })->first();
        $firstTz = parseToUserTz($first->start_time);
        $firstDate = $firstTz->toDateString();
        $this->earliestDate = $firstDate;

        if ($this->showBy == 'daily') {
            // Centrar el día y mostrar a partir de la franja de la primera reserva
            $this->currentDate = $firstTz;
            $this->visibleStartTime = $firstTz->format('H:i');
        } else {
            // Para weekly/monthly centraremos el calendario en la fecha del primer elemento
            $this->currentDate = Carbon::createFromFormat('Y-m-d', $firstDate, getUserTimezone());
            $this->visibleStartTime = null;
        }
    } else {
        $this->visibleStartTime = null;
        $this->earliestDate = null;
    }

    // Agrupar y transformar a array plano por fecha
    $grouped = [];
    foreach ($filtered as $booking) {
        $date = parseToUserTz($booking->start_time)->toDateString();
        if (!isset($grouped[$date])) {
            $grouped[$date] = [];
        }
        $array = $booking->toArray();
        $array['subject_name'] = $booking->subject->name ?? '';
        $array['status_num'] = $booking->getRawOriginal('status');
        $grouped[$date][] = $array;
    }

    $this->upcomingBookings = $grouped;

    return view('livewire.pages.common.bookings.user-booking', [
        'bookings' => $this->bookings,
        'upcomingBookings' => $this->upcomingBookings,
        'currentDate' => $this->currentDate,
    ]);
}

    protected function dispatchSessionMessages() {
        if (session('error')) {
            $this->dispatch('showAlertMessage', type: 'error',  message: session('error'));
        }
        if (session('success')) {
            $this->dispatch('showAlertMessage', type: 'success', message: session('success'));
        }
        if (session('rescheduled_msg')) {
            $this->dispatch('showAlertMessage', type: 'success' , message: session('rescheduled_msg'));
        }
    }

    public function switchShow($showBy) {
        $this->showBy = $showBy;
        $this->currentDate = parseToUserTz(Carbon::now());
        $this->filter = [];
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $showBy, currentDate: $this->getDateFormat());
    }

    public function jumpToDate($date=null) {
        if (!empty($date)) {
            if (in_array($this->showBy, ['daily', 'weekly'])) {
                $format = 'Y-m-d';
            } else {
                $format = 'd F, Y';
                $date = "01 $date";
            }
            $this->currentDate = Carbon::createFromFormat($format, $date, getUserTimezone());
        } else {
            $this->currentDate = parseToUserTz(Carbon::now());
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }
    public function showCompletePopup($booking) {
        $this->dispatch('toggleModel', id: 'confirm-complete-popup', action: 'show');
        $this->userBooking = $booking;
    }

    public function completeBooking() {
        $booking = $this->bookingService->getBookingById($this->userBooking['id']);
        if($booking->status != 'active' || Carbon::parse($booking->end_time)->isFuture()) {
            $this->dispatch('showAlertMessage', type: 'error',  message: __('calendar.unable_to_complete_booking'));
        }
        $this->bookingService->updateBooking($booking, ['status' => 'completed']);
        (new WalletService())->makePendingFundsAvailable($booking->tutor_id, ($booking->session_fee - $booking?->orderItem?->platform_fee), $booking?->orderItem?->order_id);
        dispatch(new CompleteBookingJob($booking));
        $this->dispatch('toggleModel', id: 'confirm-complete-popup', action: 'hide');
        $this->dispatch('showAlertMessage', type: 'success',  message: __('calendar.booking_completed'));
    }

    public function nextBookings() {
        if ($this->showBy == 'daily') {
            $this->currentDate->addDay();
        } elseif ($this->showBy == 'weekly') {
            $this->currentDate->addWeek();
        } else {
            $this->currentDate->addMonth();
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }

    public function previousBookings() {
        if ($this->showBy == 'daily') {
            $this->currentDate->subDay();
        } elseif ($this->showBy == 'weekly') {
            $this->currentDate->subWeek();
        } else {
            $this->currentDate->subMonth();
        }
        $this->getRange();
        $this->dispatch('initCalendarJs', showBy: $this->showBy, currentDate: $this->getDateFormat());
    }

    public function showBookingDetail($id) {
        $this->currentBooking = $this->bookingService->getBookingDetail($id);
        $this->dispatch('toggleModel', id: 'session-detail', action: 'show');
    }

    public function syncWithGoogleCalendar() {
        if (Auth::user() && Auth::user()->role == 'tutor') {
            $sucess = $this->bookingService->createSlotEventGoogleCalendar(booking: $this->currentBooking, updateMeetingLink: true);
            [$type, $message] = $sucess ? ['success', __('calendar.sync_success')] : ['error', __('calendar.sync_error')];
        } elseif (Auth::user() && Auth::user()->role == 'student') {
            $sucess = $this->bookingService->createBookingEventGoogleCalendar($this->currentBooking);
            [$type, $message] = $sucess ? ['success', __('calendar.sync_success')] : ['error', __('calendar.sync_error')];
        } else {
            [$type, $message] = ['error', __('general.not_allowed')];
        }
        $this->dispatch('toggleModel', id: 'session-detail', action: 'hide');
        $this->dispatch('showAlertMessage', type: $type,  message: $message);
    }

    public function submitReview() {
        $this->form->validateData();
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        $reviewAdded = $this->bookingService->addBookingReview($this->form->bookingId, $this->form->only(['rating', 'comment']));
        if ($reviewAdded) {
            $this->dispatch('showAlertMessage', type: 'success',  message: __('general.alert_success_msg'));
        } else {
            $this->dispatch('showAlertMessage', type: 'error',  message: __('general.error_msg'));
        }
        $this->dispatch('toggleModel', id: 'review-modal', action: 'hide');
    }

    protected function getRange(){
        $start = $end = null;
        $this->disablePrevious = $this->isCurrent = false;
        $now = Carbon::now(getUserTimezone());
        if ($this->showBy == 'daily') {
            $start = $this->currentDate->toDateString()." 00:00:00";
            $end = $this->currentDate->toDateString()." 23:59:59";
            if ($this->currentDate->isSameDay($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        } elseif ($this->showBy == 'weekly') {
            $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek)->toDateString()." 00:00:00";
            $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek))->toDateString()." 23:59:59";
            if ($this->currentDate->isSameWeek($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        } else {
            $start = $this->currentDate->copy()->firstOfMonth()->startOfWeek($this->startOfWeek)->toDateString()." 00:00:00";
            $end = $this->currentDate->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($this->startOfWeek))->toDateString()." 23:59:59";
            if ($this->currentDate->isSameMonth($now)) {
                if (Auth::user()->role == 'tutor') {
                    $this->disablePrevious = true;
                }
                $this->isCurrent = true;
            }
        }
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $start, getUserTimezone());
        $endDate   = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $end, getUserTimezone());
        $this->dateRange['start_date']  = parseToUTC($startDate);
        $this->dateRange['end_date']    = parseToUTC($endDate);
    }

    protected function getDateFormat() {
        if ($this->showBy == 'daily') {
           return $this->currentDate->toDateString();
        } elseif ($this->showBy == 'weekly') {
            $start = $this->currentDate->copy()->startOfWeek($this->startOfWeek);
            $end = $this->currentDate->copy()->endOfWeek(getEndOfWeek($this->startOfWeek));
            return $start->format('F') . " ". $start->format('d') . " - " . $end->format('F') . " ". $end->format('d') . " " . $end->format('Y');
        } else {
            return $this->currentDate->format('F, Y');
        }
    }
    
    public function closeCompletePopup() {
        $this->dispatch('toggleModel', id: 'confirm-complete-popup', action: 'hide');
        $this->resetErrorBag();
        $this->description = ''; 
        $this->selectedReason = '';
        $this->dispatch('toggleModel', id: 'dispute-reason-popup', action: 'show');
    }
    
    public function saveDisputeReason($bookingId, $studentId, $tutorId, $sessionDateTime) {

        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        
        $booking = $this->bookingService->getBookingById($bookingId);
        $this->validate([
            'selectedReason'    => 'required',
            'description'       => 'required'
        ]);

        $adminUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        $responsibleBy  = Auth::id() == $studentId ? $tutorId : $studentId;
        $creatorBy      = Auth::id() == $studentId ? $studentId : $tutorId;

        $data = [
            'uuid'              => 'DIS-'. Str::random(6),
            'disputable_id'     => $bookingId,
            'disputable_type'   => SlotBooking::class,
            'responsible_by'    => $responsibleBy,
            'creator_by'        => $creatorBy,
            'dispute_reason'    => $this->selectedReason,
            'dispute_detail'    => $this->description
        ];

        $dispute = $this->disputeService->createDispute($data);

        $emailData = [
            'studentName'       => Auth::user()->profile->first_name . ' ' . Auth::user()->profile->last_name,
            'tutorName'         => User::find($tutorId)->profile->first_name . ' ' . User::find($tutorId)->profile->last_name,
            'sessionDateTime'   => $sessionDateTime,
            'disputeReason'     => $this->selectedReason,
        ];
        dispatch(new SendNotificationJob('disputeReason',$adminUser, $emailData));
        $this->bookingService->updateBooking($booking, ['status' => 'disputed']);
        $formattedSessionDateTime = \Carbon\Carbon::parse($emailData['sessionDateTime'])->format('F j, Y, g:i A');
        $disputeMessage = setting('_dispute_setting.dispute_message') ?? '';
        $disputeMessage = str_replace('tutorName:', $emailData['tutorName'], $disputeMessage);
        $disputeMessage = str_replace('formattedSessionDateTime:', $formattedSessionDateTime, $disputeMessage);
        $this->disputeService->sendMessage($dispute->id, $disputeMessage, "student");
        $this->dispatch('toggleModel', id: 'dispute-reason-popup', action: 'hide');
        $this->dispatch('showAlertMessage', type: 'success',  message: __('calendar.dispute_success_msg'));
    }
}
