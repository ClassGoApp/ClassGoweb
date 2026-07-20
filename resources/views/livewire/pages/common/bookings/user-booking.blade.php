<div>
    <div class="am-profile-setting">
        @slot('title')
            {{ __('sidebar.bookings') }}
        @endslot

        <!-- Botón Nueva Reserva (solo para estudiantes) -->
        @role('student')
            <div class="reserva-modal" style=" margin-bottom: 24px;">
                <button class="js-open-booking btn btn-primary" style="background:#219EBC;padding: 12px 24px; font-weight: 600;" data-translate="student_bookings_new_booking">
                     Nueva Reserva
                </button>
            </div>
        @endrole

        @role('tutor')
            @include('livewire.pages.tutor.manage-sessions.tabs')
        @endrole
        <div wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter"
            class="am-booking-wrapper am-upcomming-booking @role('student') am-student-booking @endrole"
            x-data="{
                form: @entangle('form'),
                charLeft: 500,
                showModal: false,
                selectedTutoria: {},
                tutorInfo: {},
                init() {
                    this.showModal = false;
                    this.selectedTutoria = {};
                    this.updateCharLeft();
                    // Escuchar cambios de Livewire para resetear el modal
                    Livewire.hook('effect', () => {
                        this.showModal = false;
                    });
                },
                updateCharLeft() {
                    let maxLength = 500;
                    if (this.form.comment.length > maxLength) {
                        this.form.comment = this.form.comment.substring(0, maxLength);
                    }
                    this.charLeft = maxLength - this.form.comment.length;
                },
                openModal(tutoria) {
                    this.selectedTutoria = tutoria;
                    this.showModal = true;

                    setTimeout(() => {
                        document.dispatchEvent(new CustomEvent('studentBookingModalOpened'));
                    }, 50);
                },
                closeModal() {
                    this.showModal = false;
                    this.selectedTutoria = {};
                }
            }">
            <!--Upcomming Bookings-->
            <div class="am-booking-calander">
                <div class="am-booking-calander_header">
                    <div class="am-booking-dates-slot" style="display: flex; justify-content: center;">
                        <div class="am-booking-calander-day">
                            <a href="#"
                                @if ($disablePrevious) disabled @else wire:click="previousBookings" @endif>
                                <i class="am-icon-chevron-left"></i>
                            </a>
                            <span @if ($isCurrent) disabled @else wire:click="jumpToDate()" @endif
                                data-translate="student_bookings_current_{{ $showBy }}">
                                {{ __('calendar.current_' . $showBy) }}
                            </span>
                            <a href="#" wire:click="nextBookings">
                                <i class="am-icon-chevron-right"></i>
                            </a>
                        </div>
                        <div class="am-booking-calander-date flatpicker" wire:ignore>
                            <x-text-input id="flat-picker" />
                        </div>
                    </div>
                    <div class="am-booking-filters-wrapper">
                        <div class="am-inputicon">
                            <input type="text" wire:model.live.debounce.250ms="filter.keyword"
                                placeholder="{{ __('taxonomy.search_here') }}"
                                data-placeholder-key="student_bookings_search_here"
                                class="form-control" />
                            <a href="#">
                                <i class="am-icon-search-02"></i>
                            </a>
                        </div>
                        <div class="am-booking-filter-wrapper">
                            <form class="am-itemdropdown_list am-filter-list dropdown-menu"
                                aria-labelledby="dropdownMenuLink" x-on:submit.prevent x-data="{
                                    selectedValues: [],
                                    init() {
                                        const selectElement = document.getElementById('filter_subject_group');
                                        const updateSelectedValues = () => {
                                            this.selectedValues = Array.from(selectElement.selectedOptions)
                                                .filter(option => option.value)
                                                .map(option => ({
                                                    value: option.value,
                                                    text: option.text,
                                                    price: option.getAttribute('data-price')
                                                }));
                                        };
                                        $(selectElement).select2().on('change', updateSelectedValues);
                                        updateSelectedValues();
                                    },
                                    removeValue(value) {
                                        const selectElement = document.getElementById('filter_subject_group');
                                        const optionToDeselect = Array.from(selectElement.options).find(option => option.value === value);
                                        if (optionToDeselect) {
                                            optionToDeselect.selected = false;
                                            $(selectElement).trigger('change');
                                        }
                                    },
                                    submitFilter() {
                                        let filters = {}
                                        const selectSbj = document.getElementById('filter_subject_group');
                                        const selectType = document.getElementById('type_fiter');
                                        filters.type = $(selectType).select2('val');
                                        filters.subject_group_ids = $(selectSbj).select2('val');
                                        @this.set('filter', filters);
                                    }
                                }">
                                <fieldset>
                                    <div class="form-group">
                                        <label>{{ __('calendar.session_type_placeholder') }}</label>
                                        <span class="am-select am-filter-select" wire:ignore>
                                            <select id="type_fiter" data-componentid="@this"
                                                data-parent=".am-filter-list" class="am-select2" data-searchable="false"
                                                data-wiremodel="filter.type">
                                                <option value="*">{{ __('calendar.show_all_type') }}</option>
                                                <option value="one">{{ __('calendar.one') }}</option>

                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('calendar.subject_placeholder') }}</label>
                                        <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                            <select id="filter_subject_group" data-componentid="@this"
                                                data-parent=".am-filter-list" class="am-select2"
                                                data-class="subject-dropdown-select2" data-format="custom"
                                                data-searchable="true" data-wiremodel="filter.subject_group_ids"
                                                data-placeholder="{{ __('calendar.subject_placeholder') }}" multiple>
                                                <option label="{{ __('calendar.subject_placeholder') }}"></option>
                                                @if (!empty($subjectGroups))
                                                    @foreach ($subjectGroups as $group)
                                                        <optgroup label="{{ $group['group_name'] }}">
                                                            @foreach ($group['subjects'] as $subject)
                                                                <option value="{{ $subject['id'] }}"
                                                                    data-price="{{ isset($subject['hour_rate']) ? formatAmount($subject['hour_rate']) : '' }}">
                                                                    {{ $subject['subject_name'] }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </span>
                                    </div>
                                    <template x-if="selectedValues.length > 0">
                                        <ul class="am-subject-tag-list">
                                            <template x-for="(subject, index) in selectedValues">
                                                <li>
                                                    <a href="javascript:void(0)" class="am-subject-tag"
                                                        @click="removeValue(subject.value)">
                                                        <span x-text="`${subject.text} (${subject.price})`"></span>
                                                        <i class="am-icon-multiply-02"></i>
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                    <button class="am-btn"
                                        @click="submitFilter()">{{ __('general.apply_filter') }}</button>
                                </fieldset>
                            </form>
                        </div>
                        <ul class="am-session-slots am-session-slots-sm" role="tablist">
                            <li>
                                <button @class(['active' => $showBy == 'daily'])
                                    @if ($showBy != 'daily') wire:click="switchShow('daily')" @endif
                                    aria-selected="true"
                                    wire:loading.class="am-btn_disable">
                                    <span data-translate="student_bookings_daily">
                                        {{ __('calendar.daily') }}
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button @class(['active' => $showBy == 'weekly'])
                                    @if ($showBy != 'weekly') wire:click="switchShow('weekly')" @endif
                                    aria-selected="false"
                                    wire:loading.class="am-btn_disable">
                                    <span data-translate="student_bookings_weekly">
                                        {{ __('calendar.weekly') }}
                                    </span>
                                </button>
                            </li>
                            <li>
                                <button @class(['active' => $showBy == 'monthly'])
                                    @if ($showBy != 'monthly') wire:click="switchShow('monthly')" @endif
                                    aria-selected="false"
                                    wire:loading.class="am-btn_disable">
                                    <span data-translate="student_bookings_monthly">
                                        {{ __('calendar.monthly') }}
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="am-section-load" wire:loading.flex
                    wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                    <p data-translate="student_bookings_loading">
                        {{ __('general.loading') }}
                    </p>
                </div>
                <div wire:loading.class="d-none" class="am-booking-calander_body"
                    wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                    <div class="tab-content">
                        @php
                            $statusColors = [
                                'pendiente' => '#FACC15', // amarillo
                                'aceptado' => '#22C55E', // verde
                                'no_completado' => '#64748B', // gris
                                'no completado' => '#64748B',
                                'rechazado' => '#FF9800', // naranja
                                'completado' => '#3B82F6', // azul
                            ];

                            $statusMap = [
                                1 => __('calendar.status_accepted'),
                                2 => __('calendar.status_pending'),
                                3 => __('calendar.status_not_completed'),
                                4 => __('calendar.status_observed'),
                                5 => __('calendar.status_completed'),

                                'pendiente' => __('calendar.status_pending'),
                                'aceptado' => __('calendar.status_accepted'),
                                'no_completado' => __('calendar.status_not_completed'),
                                'no completado' => __('calendar.status_not_completed'),
                                'rechazado' => __('calendar.status_rejected'),
                                'completado' => __('calendar.status_completed'),
                            ];
                        @endphp
                        @if ($showBy == 'daily')
                            @php
                                $selectedDay = parseToUserTz($currentDate)->toDateString();
                                $bookingsSelectedDay = $upcomingBookings[$selectedDay] ?? [];
                            @endphp
                            <div class="tab-pane fade show active" id="dailytab"
                                wire:key="dailytab-{{ $selectedDay }}">
                                <table class="am-booking-clander-daily" wire:key="table-{{ $selectedDay }}">
                                    <thead>
                                        <th>
                                            {{ parseToUserTz($currentDate)->translatedFormat('F j, Y') }}
                                            GMT {{ parseToUserTz($currentDate)->format('P') }}
                                        </th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $startOfDay = \Carbon\Carbon::parse($selectedDay);
                                            if (!empty($visibleStartTime)) {
                                                [$vh, $vm] = explode(':', $visibleStartTime);
                                                $vm = (int)$vm >= 30 ? 30 : 0; // redondear a la franja de 30 minutos
                                                $startTime = $startOfDay->copy()->setTime((int)$vh, $vm, 0);
                                            } else {
                                                $startTime = $startOfDay->copy()->setTime(0, 0, 0);
                                            }
                                            $endTime = $startOfDay->copy()->setTime(23, 59, 0);
                                        @endphp
                                        @while ($startTime <= $endTime)
                                            @php
                                                $slotStart = $startTime->copy();
                                                $slotEnd = $startTime->copy()->addMinutes(30);
                                            @endphp
                                            <tr>
                                                <td>{{ $startTime->format('h:i A') }}</td>
                                                <td>
                                                    <div
                                                        style="display: flex; flex-direction: column; gap: 4px; width: 100%;">
                                                        @foreach ($bookingsSelectedDay as $booking)
                                                            @if (is_array($booking) && isset($booking['start_time']))
                                                                @php
                                                                    $bookingStart = \Carbon\Carbon::parse(
                                                                        $booking['start_time'],
                                                                    );
                                                                @endphp
                                                                @if ($bookingStart >= $slotStart && $bookingStart < $slotEnd)
                                                                    <div style="background: {{ $statusColors[strtolower(trim($booking['status']))] ?? '#FACC15' }} !important; color:black;padding:5px;border-radius:5px; cursor:pointer; width: 100%;"
                                                                        @click="openModal({
                                                                estado: @js($statusMap[$booking['status_num']] ?? $booking['status_num']),
                                                                hora_inicio: @js(\Carbon\Carbon::parse($booking['start_time'])->format('H:i')),
                                                                hora_fin: @js(\Carbon\Carbon::parse($booking['end_time'])->format('H:i')),
                                                                fecha: @js(\Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d')),
                                                                materia: @js($booking['subject_name']),
                                                                meeting_link: @js($booking['meeting_link'] ?? '')
                                                            })">
                                                                        {{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $startTime = $startTime->copy()->addMinutes(30); @endphp
                                        @endwhile
                                    </tbody>
                                </table>
                            </div>
                        @elseif($showBy == 'weekly')
                            <div class="tab-pane fade show active" id="weeklytab">
                                <div style="overflow-x:auto; width:100%;">
                                    <table class="am-booking-weekly-clander" style="min-width:900px; width:100%;">
                                        <thead>
                                            <tr>
                                                @php
                                                    $weekStart = $currentDate->copy()->startOfWeek($startOfWeek);
                                                    $weekEnd = $currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek));
                                                    $d = $weekStart->copy();
                                                @endphp
                                                @while($d->lte($weekEnd))
                                                    <th style="min-width:120px;">
                                                        <div class="    -title">
                                                            <strong data-student-booking-date
                                                                data-date="{{ $d->toDateString() }}"
                                                                data-format="day-month">
                                                                {{ $d->format('j F') }}
                                                            </strong>

                                                            <span data-student-booking-date
                                                                data-date="{{ $d->toDateString() }}"
                                                                data-format="weekday-short">
                                                                {{ $d->format('D') }}
                                                            </span>
                                                        </div>
                                                    </th>
                                                    @php $d->addDay(); @endphp
                                                @endwhile
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @php $d = $weekStart->copy(); @endphp
                                                @while($d->lte($weekEnd))
                                                    <td style="min-width:120px; vertical-align:top;">
                                                        <div class="am-weekly-slots_wrap">
                                                            <div class="am-weekly-slots">
                                                                @if (isset($upcomingBookings[$d->toDateString()]))
                                                                    @foreach ($upcomingBookings[$d->toDateString()] as $booking)
                                                                        <div style="background:{{ $statusColors[strtolower(trim($booking['status']))] ?? '#FACC15' }} !important;color:black;padding:5px 8px;border-radius:5px;margin-bottom:5px; font-size:14px; cursor:pointer;"
                                                                            @click="openModal({
                                                                    estado: @js($statusMap[$booking['status_num']] ?? $booking['status_num']),
                                                                    hora_inicio: @js(\Carbon\Carbon::parse($booking['start_time'])->format('H:i')),
                                                                    hora_fin: @js(\Carbon\Carbon::parse($booking['end_time'])->format('H:i')),
                                                                    fecha: @js(\Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d')),
                                                                    materia: @js($booking['subject_name']),
                                                                    meeting_link: @js($booking['meeting_link'] ?? '')
                                                                })">
                                                                            <span data-translate="student_bookings_status"></span>
                                                                            
                                                                            <b>{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}</b><br>
                                                                            {{ \Carbon\Carbon::parse($booking['start_time'])->format('h:i a') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($booking['end_time'])->format('h:i a') }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <span class="am-emptyslot" data-translate="student_bookings_no_sessions">
                                                                        {{ __('calendar.no_sessions') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @php $d->addDay(); @endphp
                                                @endwhile
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($showBy == 'monthly')
                            <div class="tab-pane fade show active" id="monthlytab">
                                <table class="am-monthly-session-table">
                                    <thead>
                                        <tr>
                                            @foreach ($days as $day)
                                                <th>{{ $day['short_name'] }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $origStart = $currentDate->copy()->firstOfMonth()->startOfWeek($startOfWeek);
                                            $endOfCalendar = $currentDate->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($startOfWeek));
                                            if (!empty($earliestDate)) {
                                                $earliest = \Carbon\Carbon::parse($earliestDate)->startOfWeek($startOfWeek);
                                                $startOfCalendar = $earliest->gt($origStart) ? $earliest->copy() : $origStart->copy();
                                            } else {
                                                $startOfCalendar = $origStart->copy();
                                            }
                                        @endphp
                                        @while ($startOfCalendar <= $endOfCalendar)
                                            <tr>
                                                @for ($i = 0; $i < 7; $i++)
                                                    @php $totalBookings=0; @endphp
                                                    <td @class([
                                                        'am-outside-calendar' =>
                                                            $startOfCalendar->format('m') != $currentDate->format('m'),
                                                    ])>
                                                        <div class="am-monthly-session-title">
                                                            <span
                                                                @class(['current-date' => $startOfCalendar->isToday()])>{{ parseToUserTz($startOfCalendar)->format('j') }}</span>
                                                            @if (isset($upcomingBookings[$startOfCalendar->toDateString()]))
                                                                @foreach ($upcomingBookings[$startOfCalendar->toDateString()] as $booking)
                                                                    @php $totalBookings += 1; @endphp
                                                                @endforeach
                                                                <em>{{ $totalBookings }}<span data-translate="student_bookings_tutoring_plural">Tutorías</span></em>
                                                            @endif
                                                        </div>
                                                        @if (isset($upcomingBookings[$startOfCalendar->toDateString()]))
                                                            <div
                                                                style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 4px;">
                                                                @foreach ($upcomingBookings[$startOfCalendar->toDateString()] as $index => $booking)
                                                                    @php
                                                                        $now = \Carbon\Carbon::now(getUserTimezone());
                                                                        $start = \Carbon\Carbon::parse(
                                                                            $booking['start_time'],
                                                                            getUserTimezone(),
                                                                        );
                                                                        $showLink = $now->greaterThanOrEqualTo($start);
                                                                        if ($showLink && request()->has('debug')) {
                                                                            dd([
                                                                                'now' => $now,
                                                                                'start' => $start,
                                                                                'meeting_link' =>
                                                                                    $booking['meeting_link'] ?? null,
                                                                            ]);
                                                                        }
                                                                    @endphp
                                                                    <div style="background: {{ $statusColors[strtolower(trim($booking['status']))] ?? '#FACC15' }} !important; color: #222; padding:5px; border-radius:5px; cursor:pointer;"
                                                                        @click="openModal({
                                                        estado: @js($statusMap[$booking['status_num']] ?? $booking['status_num']),
                                                        hora_inicio: @js(\Carbon\Carbon::parse($booking['start_time'])->format('H:i')),
                                                        hora_fin: @js(\Carbon\Carbon::parse($booking['end_time'])->format('H:i')),
                                                        fecha: @js(\Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d')),
                                                        materia: @js($booking['subject_name']),
                                                        meeting_link: @js($booking['meeting_link'] ?? '')
                                                    })">
                                                                        <span data-translate="student_bookings_status"></span>
                                                                        <b>{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}</b><br>
                                                                        {{ \Carbon\Carbon::parse($booking['start_time'])->format('h:i a') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($booking['end_time'])->format('h:i a') }}
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                    @php $startOfCalendar->addDay(); @endphp
                                                @endfor
                                            </tr>
                                        @endwhile
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <x-no-record :image="asset('images/session.png')" :title="__('calendar.no_sessions')" :description="__('calendar.no_session_desc')" />
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal de detalles de tutoría -->
            <div x-show="showModal && selectedTutoria && Object.keys(selectedTutoria).length > 0" class="am-modal-overlay" x-transition x-cloak>
                <div
                    style="
                    background: #fff; 
                    border-radius: 12px; 
                    padding: 24px 30px; 
                    max-width: 400px; 
                    width: 100%; 
                    box-shadow: 0 10px 25px rgba(0,0,0,0.15); 
                    display: flex; 
                    flex-direction: column; 
                    align-items: stretch;
                    position: relative;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    color: #333;
                    ">
                    <h3
                        style="font-size: 1.4rem; font-weight: 600; margin-bottom: 20px; text-align: center; color: #222; "
    data-translate="student_bookings_details">
                        Detalles de la tutoría
                    </h3>

                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_status">Estado:</strong> <span x-text="selectedTutoria.estado" style="color: #007BFF;"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_date">Fecha:</strong> <span x-text="selectedTutoria.fecha"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_start_time">Hora inicio:</strong> <span x-text="selectedTutoria.hora_inicio"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_end_time">Hora fin:</strong> <span x-text="selectedTutoria.hora_fin"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_subject">Materia:</strong> <span x-text="selectedTutoria.materia"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong data-translate="student_bookings_link">Link de la tutoría:</strong>
                        <template x-if="selectedTutoria.meeting_link">
                            <a :href="selectedTutoria.meeting_link" target="_blank"
                                style="color: #007BFF; text-decoration: underline; word-break: break-all;">
                                <span x-text="selectedTutoria.meeting_link"></span>
                            </a>
                        </template>
                        <template x-if="!selectedTutoria.meeting_link">
                            <span style="color: #888;" data-translate="student_bookings_not_available">No disponible</span>
                        </template>
                    </p>
                    <!-- Más campos aquí -->

                    <button @click="closeModal"
                        style="
                        margin-top: 24px; 
                        padding: 10px 20px; 
                        background-color: #007BFF; 
                        color: white; 
                        border: none; 
                        border-radius: 6px; 
                        cursor: pointer; 
                        font-weight: 600;
                        transition: background-color 0.3s ease;
                    "
                        onmouseover="this.style.backgroundColor='#0056b3'"
                        onmouseout="this.style.backgroundColor='#007BFF'" data-translate="student_bookings_close">
                        Cerrar
                    </button>
                </div>
            </div>

            <x-completion />
            <x-dispute-reason-popup :booking="$userBooking" :disputeReason="$disputeReason" :description="$description" :selectedReason="$selectedReason" />
            <x-booking-detail-modal :currentBooking="$currentBooking" wire:key="{{ time() }}" />
        </div>
        <!-- WIZARD DE RESERVAS (solo estudiantes) -->
        @role('student')
            @include('components.booking._booking-wizard')
        @endrole
    </div>
</div>
@push('styles')
    @vite(['public/css/flatpicker.css', 'public/css/flatpicker-month-year-plugin.css'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        .am-modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .am-booking-clander-daily td {
            height: auto !important;
            vertical-align: top;
            padding-top: 6px;
            padding-bottom: 6px;
        }
        
    </style>
@endpush
@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script defer src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
    <script defer src="{{ asset('js/weekSelect.min.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
@endpush

@script
    <script>
        let flatpickrInstance = null;

        function translateStudentBookingsDateText(text) {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (!text || lang === 'en') {
                return text;
            }

            const months = {
                es: {
                    January: 'enero',
                    February: 'febrero',
                    March: 'marzo',
                    April: 'abril',
                    May: 'mayo',
                    June: 'junio',
                    July: 'julio',
                    August: 'agosto',
                    September: 'septiembre',
                    October: 'octubre',
                    November: 'noviembre',
                    December: 'diciembre'
                },
                pt: {
                    January: 'janeiro',
                    February: 'fevereiro',
                    March: 'março',
                    April: 'abril',
                    May: 'maio',
                    June: 'junho',
                    July: 'julho',
                    August: 'agosto',
                    September: 'setembro',
                    October: 'outubro',
                    November: 'novembro',
                    December: 'dezembro'
                }
            };

            const selectedMonths = months[lang] || months.es;

            return text.replace(
                /\b(January|February|March|April|May|June|July|August|September|October|November|December)\b/g,
                (month) => selectedMonths[month] || month
            );
        }

        initFlatPicker('daily', 'today');

        $wire.dispatch('initSelect2', {
            target: '.am-select2'
        });

        document.addEventListener('initCalendarJs', (event) => {
            setTimeout(() => {
                initFlatPicker(event.detail.showBy, event.detail.currentDate, event.detail.range);
            }, 100);
        });

        function getFlatpickrLocale() {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (lang === 'es' && flatpickr?.l10ns?.es) {
                return flatpickr.l10ns.es;
            }

            if (lang === 'pt' && flatpickr?.l10ns?.pt) {
                return flatpickr.l10ns.pt;
            }

            return 'default';
        }

        function initFlatPicker(showBy, currentDate, range = []) {
            if (flatpickrInstance) {
                flatpickrInstance.destroy();
            }
            let config = {
                defaultDate: currentDate,
                disableMobile: true,
                locale: getFlatpickrLocale(),
                onChange: function(selectedDates, dateStr, instance) {
                    @this.call('jumpToDate', dateStr);
                }
            };
            if (showBy == 'daily') {
                config = {
                    ...config,
                    altInput: true,
                    altFormat: "F j, Y",
                    dateFormat: "Y-m-d"
                };
                @role('tutor')
                    config = {
                        ...config,
                        minDate: @js(\Carbon\Carbon::now(getUserTimezone())->toDateString())
                    }
                @endrole ()
            } else if (showBy == 'weekly') {
                config = {
                    ...config,
                    defaultDate: parseDateRange(currentDate),
                    minDate: @js(\Carbon\Carbon::now(getUserTimezone())->toDateString()),
                    plugins: [
                        new weekSelect({
                            weekStart: @js($startOfWeek)
                        })
                    ],
                    dateFormat: 'Y-m-d',
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.input.value = translateStudentBookingsDateText(currentDate)
                    }
                };
            } else {
                config = {
                    ...config,
                    plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: "F, Y",
                        })
                    ],
                };
            }
            flatpickrInstance = flatpickr($(`#flat-picker`), config);
        }

        function parseDateRange(dateRangeStr) {
            const [range, year] = dateRangeStr.split(' ');
            const [startStr, endStr] = range.split('-');

            const monthMap = {
                January: 0,
                February: 1,
                March: 2,
                April: 3,
                May: 4,
                June: 5,
                July: 6,
                August: 7,
                September: 8,
                October: 9,
                November: 10,
                December: 11
            };

            const parseDate = (str) => {
                const parts = str.trim().split(' ');
                return new Date(year, monthMap[parts[0]], parts[1]);
            };

            try {
                const startDate = parseDate(startStr);
                const endDate = parseDate(endStr);

                if (isNaN(startDate) || isNaN(endDate)) {
                    throw new Error('Invalid date');
                }

                return {
                    start: startDate.toISOString().split('T')[0],
                    end: endDate.toISOString().split('T')[0]
                };
            } catch {
                return null;
            }
        }

        function studentBookingsText(key, fallback = '') {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (typeof translations === 'undefined') {
                return fallback;
            }

            const t = translations[lang] || translations.es;

            return t[key] || fallback;
        }

        function applyStudentBookingsPlaceholders() {
            document.querySelectorAll('[data-placeholder-key]').forEach((element) => {
                const key = element.getAttribute('data-placeholder-key');
                const fallback = element.getAttribute('placeholder') || '';

                element.setAttribute('placeholder', studentBookingsText(key, fallback));
            });
        }

        function getStudentBookingsLocale() {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            const locales = {
                es: 'es-BO',
                en: 'en-US',
                pt: 'pt-BR'
            };

            return locales[lang] || 'es-BO';
        }

        function capitalizeStudentBookingText(text) {
            if (!text) {
                return text;
            }

            return text.charAt(0).toUpperCase() + text.slice(1);
        }

        function applyStudentBookingsDates() {
            const locale = getStudentBookingsLocale();

            document.querySelectorAll('[data-student-booking-date]').forEach((element) => {
                const dateValue = element.getAttribute('data-date');
                const format = element.getAttribute('data-format');

                if (!dateValue) {
                    return;
                }

                const date = new Date(`${dateValue}T12:00:00`);

                if (Number.isNaN(date.getTime())) {
                    return;
                }

                if (format === 'day-month') {
                    const day = new Intl.DateTimeFormat(locale, {
                        day: 'numeric'
                    }).format(date);

                    const month = new Intl.DateTimeFormat(locale, {
                        month: 'long'
                    }).format(date);

                    element.textContent = `${day} ${capitalizeStudentBookingText(month)}`;
                }

                if (format === 'weekday-short') {
                    const weekday = new Intl.DateTimeFormat(locale, {
                        weekday: 'short'
                    }).format(date).replace('.', '');

                    element.textContent = capitalizeStudentBookingText(weekday);
                }
            });
        }

            function applyStudentBookingsTranslations() {
                const lang = localStorage.getItem('selectedLanguage') || 'es';

                applyStudentBookingsPlaceholders();
                applyStudentBookingsDates();

                if (typeof selectLanguage === 'function') {
                    selectLanguage(lang, false);
                }
            }

            document.addEventListener('DOMContentLoaded', applyStudentBookingsTranslations);
            document.addEventListener('livewire:navigated', applyStudentBookingsTranslations);
            document.addEventListener('studentBookingModalOpened', applyStudentBookingsTranslations);

            document.addEventListener('languageChanged', () => {
                applyStudentBookingsPlaceholders();
                applyStudentBookingsDates();

                if (typeof initFlatPicker === 'function') {
                    initFlatPicker(@js($showBy), @js($currentDate));

                    setTimeout(() => {
                        applyStudentBookingsDates();
                    }, 100);
                }
            });
    </script>
@endscript
