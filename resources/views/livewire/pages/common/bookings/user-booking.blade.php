<div>
    <div class="am-profile-setting">
        @slot('title')
            {{ __('sidebar.bookings') }}
        @endslot

        <!-- Botón Nueva Reserva (solo para estudiantes) -->
        @role('student')
            <div class="reserva-modal" style=" margin-bottom: 24px;">
                <button class="js-open-booking btn btn-primary" style="background:#219EBC;padding: 12px 24px; font-weight: 600;">
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
                    var self = this;
                    Livewire.hook('effect', function() {
                        self.showModal = false;
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
                    if (tutoria.status_num === 7 && '{{ optional(Auth::user())->role }}' === 'student') {
                        const container = document.getElementById('tutor-payment-details');
                        if (container) container.textContent = 'Cargando datos de pago...';
                        fetch('/student/booking/tutor-payment/' + tutoria.tutor_id)
                            .then(function(res) { return res.json(); })
                            .then(function(data) {
                                if (data.success && data.payment) {
                                    let html = '';
                                    if (data.payment.bank) {
                                        const b = data.payment.bank;
                                        html += '<strong>Banco:</strong> ' + (b.bank_name || '') + '<br>' +
                                                 '<strong>Cuenta:</strong> ' + (b.account_number || '') + '<br>' +
                                                 '<strong>Titular:</strong> ' + (b.account_holder || '') + '<br>' +
                                                 '<strong>Documento:</strong> ' + (b.holder_id || '') + '<br>';
                                    } else {
                                        html += 'El tutor no tiene datos bancarios registrados.<br>';
                                    }
                                    if (data.payment.qr_url) {
                                        html += '<div style=\'margin-top: 10px; text-align: center;\'>' +
                                                    '<img src=\'' + data.payment.qr_url + '\' style=\'max-width: 120px; border: 1px solid #ccc; border-radius: 4px;\'>' +
                                                 '</div>';
                                    }
                                    if (container) container.innerHTML = html;
                                } else {
                                    if (container) container.textContent = 'No se pudieron cargar los datos de pago.';
                                }
                            })
                            .catch(function(err) {
                                if (container) container.textContent = 'Error al cargar datos de pago.';
                            });
                    }
                },
                closeModal() {
                    this.showModal = false;
                    this.selectedTutoria = {};
                },
                async submitReceipt(bookingId) {
                    const fileInput = document.getElementById('receipt-file-input');
                    if (!fileInput || !fileInput.files[0]) {
                        alert('Por favor selecciona un archivo.');
                        return;
                    }
                    const formData = new FormData();
                    formData.append('comprobante', fileInput.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    try {
                        const res = await fetch('/student/bookings/' + bookingId + '/receipt', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await res.json();
                        if (data.success) {
                            alert('Comprobante subido exitosamente. La tutoría ha sido confirmada.');
                            window.location.reload();
                        } else {
                            alert(data.message || 'Error al subir el comprobante.');
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Error al enviar el archivo.');
                    }
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
                            <span @if ($isCurrent) disabled @else wire:click="jumpToDate()" @endif>
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
                                placeholder="{{ __('taxonomy.search_here') }}" class="form-control" />
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
                                    wire:loading.class="am-btn_disable">{{ __('calendar.daily') }}</button>
                            </li>
                            <li>
                                <button @class(['active' => $showBy == 'weekly'])
                                    @if ($showBy != 'weekly') wire:click="switchShow('weekly')" @endif
                                    aria-selected="false"
                                    wire:loading.class="am-btn_disable">{{ __('calendar.weekly') }}</button>
                            </li>
                            <li>
                                <button @class(['active' => $showBy == 'monthly'])
                                    @if ($showBy != 'monthly') wire:click="switchShow('monthly')" @endif
                                    aria-selected="false"
                                    wire:loading.class="am-btn_disable">{{ __('calendar.monthly') }}</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="am-section-load" wire:loading.flex
                    wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                    <p>{{ __('general.loading') }}</p>
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
                                'pendiente de pago' => '#8B5CF6', // morado
                            ];

                            $statusMap = [
                                1 => 'Aceptado',
                                2 => 'Pendiente',
                                3 => 'No completado',
                                4 => 'Observado',
                                5 => 'Completado',
                                7 => 'Pendiente de pago',
                                'pendiente' => 'Pendiente',
                                'aceptado' => 'Aceptado',
                                'no_completado' => 'No completado',
                                'no completado' => 'No completado',
                                'rechazado' => 'Rechazado',
                                'completado' => 'Completado',
                                'pendiente de pago' => 'Pendiente de pago',
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
                                        <tr>
                                            <th>{{ __('calendar.time') }}</th>
                                            <th>{{ parseToUserTz($currentDate)->format('F j, Y \G\M\T P') }}</th>
                                        </tr>
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
                                                                estado: '{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}',
                                                                hora_inicio: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('H:i') }}',
                                                                hora_fin: '{{ \Carbon\Carbon::parse($booking['end_time'])->format('H:i') }}',
                                                                fecha: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d') }}',
                                                                id: '{{ $booking['id'] }}',
                                                                 status_num: {{ $booking['status_num'] }},
                                                                 student_id: {{ $booking['student_id'] }},
                                                                 tutor_id: {{ $booking['tutor_id'] }},
                                                                 materia: '{{ $booking['subject_name'] }}',
                                                                meeting_link: '{{ $booking['meeting_link'] ?? '' }}'
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
                                                            <strong>{{ $d->format('j F') }}</strong>
                                                            <span>{{ $d->format('D') }}</span>
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
                                                                    estado: '{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}',
                                                                    hora_inicio: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('H:i') }}',
                                                                    hora_fin: '{{ \Carbon\Carbon::parse($booking['end_time'])->format('H:i') }}',
                                                                    fecha: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d') }}',
                                                                    id: '{{ $booking['id'] }}',
                                                                                 status_num: {{ $booking['status_num'] }},
                                                                                 student_id: {{ $booking['student_id'] }},
                                                                                 tutor_id: {{ $booking['tutor_id'] }},
                                                                                 materia: '{{ $booking['subject_name'] }}',
                                                                    meeting_link: '{{ $booking['meeting_link'] ?? '' }}'
                                                                })">
                                                                            Estado:
                                                                            <b>{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}</b><br>
                                                                            {{ \Carbon\Carbon::parse($booking['start_time'])->format('h:i a') }}
                                                                            -
                                                                            {{ \Carbon\Carbon::parse($booking['end_time'])->format('h:i a') }}
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <span
                                                                        class="am-emptyslot">{{ __('calendar.no_sessions') }}</span>
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
                                                                <em> {{ $totalBookings }} Tutorías </em>
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
                                                        estado: '{{ $statusMap[$booking['status_num']] ?? $booking['status_num'] }}',
                                                        hora_inicio: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('H:i') }}',
                                                        hora_fin: '{{ \Carbon\Carbon::parse($booking['end_time'])->format('H:i') }}',
                                                        fecha: '{{ \Carbon\Carbon::parse($booking['start_time'])->format('Y-m-d') }}',
                                                        id: '{{ $booking['id'] }}',
                                                         status_num: {{ $booking['status_num'] }},
                                                         student_id: {{ $booking['student_id'] }},
                                                         tutor_id: {{ $booking['tutor_id'] }},
                                                         materia: '{{ $booking['subject_name'] }}',
                                                        meeting_link: '{{ $showLink ? $booking['meeting_link'] ?? '' : '' }}'
                                                    })">
                                                                        Estado:
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
                        style="font-size: 1.4rem; font-weight: 600; margin-bottom: 20px; text-align: center; color: #222;">
                        Detalles de la tutoría
                    </h3>

                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Estado:</strong> <span x-text="selectedTutoria.estado" style="color: #007BFF;"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Fecha:</strong> <span x-text="selectedTutoria.fecha"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Hora inicio:</strong> <span x-text="selectedTutoria.hora_inicio"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Hora fin:</strong> <span x-text="selectedTutoria.hora_fin"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Materia:</strong> <span x-text="selectedTutoria.materia"></span>
                    </p>
                    <p style="margin: 8px 0; font-size: 1rem;">
                        <strong>Link de la tutoría:</strong>
                        <template x-if="selectedTutoria.meeting_link">
                            <a :href="selectedTutoria.meeting_link" target="_blank"
                                style="color: #007BFF; text-decoration: underline; word-break: break-all;">
                                <span x-text="selectedTutoria.meeting_link"></span>
                            </a>
                        </template>
                        <template x-if="!selectedTutoria.meeting_link">
                            <span style="color: #888;">No disponible</span>
                        </template>
                    </p>
                    <!-- Acciones del Tutor si está Pendiente (estado 2) -->
                    <template x-if="selectedTutoria.status_num === 2 && '{{ optional(Auth::user())->role }}' === 'tutor'">
                        <div style="margin-top: 16px; display: flex; gap: 10px; width: 100%;">
                            <button @click="$wire.tutorAccept(selectedTutoria.id)"
                                style="flex: 1; padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                Aceptar
                            </button>
                            <button @click="$wire.tutorReject(selectedTutoria.id)"
                                style="flex: 1; padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                Rechazar
                            </button>
                        </div>
                    </template>

                    <!-- Acciones del Estudiante si está Pendiente de pago (estado 7) -->
                    <template x-if="selectedTutoria.status_num === 7 && '{{ optional(Auth::user())->role }}' === 'student'">
                        <div style="margin-top: 16px; border-top: 1px solid #eee; padding-top: 16px;">
                            <p style="color: #856404; background: #fff3cd; padding: 10px; border-radius: 6px; font-size: 0.9rem; margin-bottom: 12px;">
                                ⚠️ <strong>Acción Requerida:</strong> Por favor realiza la transferencia a los datos bancarios del tutor y sube tu comprobante de pago a continuación.
                            </p>

                            <!-- Datos Bancarios del Tutor -->
                            <div style="background: #f8f9fa; border: 1px solid #dee2e6; padding: 12px; border-radius: 6px; margin-bottom: 12px; font-size: 0.85rem;">
                                <h5 style="margin: 0 0 6px 0; font-weight: 600;">Datos de Pago del Tutor:</h5>
                                <div id="tutor-payment-details">Cargando datos de pago...</div>
                            </div>

                            <form @submit.prevent="submitReceipt(selectedTutoria.id)" enctype="multipart/form-data">
                                <div style="margin-bottom: 12px;">
                                    <label style="display:block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px;">Comprobante de pago (JPG, PNG, PDF):</label>
                                    <input type="file" id="receipt-file-input" required class="form-control" style="font-size: 0.85rem;">
                                </div>
                                <button type="submit" style="width: 100%; padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    Subir Comprobante y Confirmar
                                </button>
                            </form>
                        </div>
                    </template>

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
                        onmouseout="this.style.backgroundColor='#007BFF'">
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
    <script defer src="{{ asset('js/weekSelect.min.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
@endpush

@script
    <script>
        let flatpickrInstance = null;
        initFlatPicker('daily', 'today');
        $wire.dispatch('initSelect2', {
            target: '.am-select2'
        })
        document.addEventListener('initCalendarJs', (event) => {
            setTimeout(() => {
                initFlatPicker(event.detail.showBy, event.detail.currentDate, event.detail.range);
            }, 100);
        })

        function initFlatPicker(showBy, currentDate, range = []) {
            if (flatpickrInstance) {
                flatpickrInstance.destroy();
            }
            let config = {
                defaultDate: currentDate,
                disableMobile: true,
                onChange: function(selectedDates, dateStr, instance) {
                    @this.call('jumpToDate', dateStr);
                }
            }
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
                @endrole
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
                        instance.input.value = currentDate
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

            const parseDate = (str) => new Date(`${monthMap[str.split(' ')[0]]}/${str.split(' ')[1]}/${year}`);

            try {
                const startDate = parseDate(startStr);
                const endDate = parseDate(endStr);
                if (isNaN(startDate) || isNaN(endDate)) throw new Error('Invalid date');
                return {
                    start: startDate.toISOString().split('T')[0],
                    end: endDate.toISOString().split('T')[0]
                };
            } catch {
                return null;
            }
        }
    </script>
@endscript
