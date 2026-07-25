<div>
    <div class="am-profile-setting am-managesessions_wrap">
        @slot('title')
            {{ __('calendar.title') }}
        @endslot
        @include('livewire.pages.tutor.manage-sessions.tabs')
        <div class="am-section-load" wire:loading.flex wire:target="updatedCurrentMonth,jumpToDate,updatedCurrentYear,previousMonthCalendar,nextMonthCalendar">
            <p data-translate="general_loading">{{ __('general.loading') }}</p>
        </div>
        <div class="am-booking-wrapper">
            <div class="am-booking-calander">
                <div class="am-booking-calander_header">
                    <h1 data-translate="calendar_title">{{ __('calendar.title') }}</h1>
                    <div>
                        <div class="am-booking-filters-wrapper">
                            <div class="am-booking-calander-day">
                                <i wire:click="previousMonthCalendar('{{ $currentDate }}')">
                                    <i class="am-icon-chevron-left"></i>
                                </i>
                                <span style="margin: 0 10px; font-weight: bold;">
                                    {{ parseToUserTz($currentDate)->translatedFormat('F Y') }}
                                </span>
                                <i wire:click="nextMonthCalendar('{{ $currentDate }}')">
                                    <i class="am-icon-chevron-right"></i>
                                </i>
                            </div>
                            

                            

                            <button class="am-btn" wire:click="addSessionForm">
                                <span data-translate="calendar_add_new_session">
                                    {{ __('calendar.add_new_session') }}
                                </span>
                                <i class="am-icon-plus-02"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="am-booking-calander_body">
                    <table class="am-full-calander">
                        <thead>
                            <tr>
                                @foreach ($days as $day)
                                    <th class="{{ (setting('_lernen.start_of_week') ?? \Carbon\Carbon::SUNDAY) == $day['week_day'] ? 'am-calendar_offday' : '' }}">{{ $day['short_name'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @while ($startOfCalendar <= $endOfCalendar)
                                <tr>
                                    @for ($i = 0; $i < 7; $i++)
                                        <td>
                                            <a
                                                wire:key="calendar-cell-{{ parseToUserTz($startOfCalendar)->toDateString() }}"
                                                @if(empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]))
                                                    href="#"
                                                    x-on:click="$wire.dispatch('toggleModel', {id:'booking-modal',action:'show'})"
                                                @else
                                                    href="#"
                                                @endif
                                                @class([
                                                    'am-full-calander-days',
                                                    'am-active' => parseToUserTz($startOfCalendar)->isToday(),
                                                    'am-outside-calendar' => parseToUserTz($startOfCalendar)->format('m') != parseToUserTz($currentDate)->format('m'),
                                                    'am-empty-slots' => empty($availableSlots[$startOfCalendar->toDateString()])
                                                ])
                                            >
                                            @if(!empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]))
                                                <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 4px;">
                                                    @foreach($availableSlots[parseToUserTz($startOfCalendar)->toDateString()] as $slot)
                                                        <div 
                                                            class="am-slot-label" 
                                                            style="background: #27ae60; color: #fff; border-radius: 6px; margin-bottom: 2px; padding: 2px 8px; cursor:pointer; font-size: 13px; font-weight: 500;"
                                                            wire:click="loadSlotForEdit({{ $slot->id }})"
                                                        >
                                                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <span class="am-custom-tooltip">
                                                    {{ parseToUserTz($startOfCalendar)->format('j') }}
                                                </span>
                                            @else
                                                <span class="am-custom-tooltip">
                                                    {{ parseToUserTz($startOfCalendar)->format('j') }}
                                                </span>
                                            @endif
                                            </a>
                                        </td>
                                        @php
                                            $startOfCalendar->addDay();
                                        @endphp
                                    @endfor
                                </tr>
                            @endwhile
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL NUEVO UNICO -->
            <div id="new-booking-modal" class="modal fade" tabindex="-1" aria-labelledby="newBookingModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newBookingModalLabel" data-translate="calendar_add_session">
                                {{ __('calendar.add_session') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                 aria-label="Cerrar" data-translate-aria-label="general_close"></button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="addSession" autocomplete="off">
                                <div class="row">
                                    

                                    <!-- Campo de Fechas con calendario emergente -->
                                    <div class="col-md-6 mb-3">
                                        <label for="date_range_new" class="form-label" data-translate="calendar_start_end_date">
                                            {{ __('calendar.start_end_date') }}
                                        </label>

                                        <input type="text" id="date_range_new" class="form-control flatpickr-date"
                                            wire:model="form.date_range"
                                            placeholder="Selecciona fecha"
                                            data-translate-placeholder="calendar_select_date"
                                            data-min-date="today">
                                        <x-input-error field_name="form.date_range" />
                                    </div>

                                    <!-- Campo de Hora de Inicio -->
                                    <div class="col-md-6 mb-3">
                                        <label for="start_time_new" class="form-label" data-translate="calendar_start_time">
                                            Hora Inicio
                                        </label>

                                        <input type="text" id="start_time_new" class="form-control flatpickr-time"
                                            wire:model="form.start_time"
                                            placeholder="Selecciona hora de inicio"
                                            data-translate-placeholder="calendar_select_start_time">
                                        <x-input-error field_name="form.start_time" />
                                    </div>

                                    <!-- Campo de Hora de Fin -->
                                    <div class="col-md-6 mb-3">
                                        <label for="end_time_new" class="form-label" data-translate="calendar_end_time">
                                            Hora Fin
                                        </label>

                                        <input type="text" id="end_time_new" class="form-control flatpickr-time"
                                            wire:model="form.end_time"
                                            placeholder="Selecciona hora de fin"
                                            data-translate-placeholder="calendar_select_end_time">
                                        <x-input-error field_name="form.end_time" />
                                        @if($errors->has('form.end_time'))
                                            <div class="alert alert-danger text-center mt-2">
                                                {{ $errors->first('form.end_time') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-12 mb-3 mt-3">
                                        <label class="form-label fw-bold text-center w-100" data-translate="calendar_select_available_days">
                                            Seleccione los días que está disponible
                                        </label>
                                        
                                        <div class="d-flex justify-content-center gap-3 mt-2 custom-day-selector">
                                                @php
                                                    $daysOfWeek = [
                                                        0 => ['key' => 'calendar_day_sunday_short', 'label' => 'Dom'],
                                                        1 => ['key' => 'calendar_day_monday_short', 'label' => 'Lun'],
                                                        2 => ['key' => 'calendar_day_tuesday_short', 'label' => 'Mar'],
                                                        3 => ['key' => 'calendar_day_wednesday_short', 'label' => 'Mié'],
                                                        4 => ['key' => 'calendar_day_thursday_short', 'label' => 'Jue'],
                                                        5 => ['key' => 'calendar_day_friday_short', 'label' => 'Vie'],
                                                        6 => ['key' => 'calendar_day_saturday_short', 'label' => 'Sáb'],
                                                    ];
                                                @endphp

                                                @foreach($daysOfWeek as $index => $day)
                                                    <div class="day-item">
                                                        <input type="checkbox" id="day_{{ $index }}" value="{{ $index }}"
                                                            wire:model="form.selected_days" class="d-none day-checkbox">

                                                        <label for="day_{{ $index }}" class="day-circle"
                                                            data-translate="{{ $day['key'] }}">
                                                            {{ $day['label'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                        </div>
                                        
                                        <div class="text-center mt-2">
                                            <x-input-error field_name="form.selected_days" />
                                        </div>
                                    </div>

                                </div>

                                <!-- Botones de Acción -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-loading">
                                        <span data-translate="general_save_update">{{ __('general.save_update') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- MODAL PARA DETALLE Y EDICIÓN DE SLOT -->
            <div wire:ignore.self class="modal fade" id="edit-session" tabindex="-1" aria-labelledby="slotDetailModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="slotDetailModalLabel" data-translate="calendar_edit_session">
                                Editar sesión
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar" data-translate-aria-label="general_close"></button>
                        </div>
                        <div class="modal-body">
                            @if($slotHasBookings)
                                <div class="alert alert-warning text-center mb-3">
                                    <span data-translate="calendar_slot_has_bookings_warning">
                                        Este horario ya tiene tutorías reservadas y no puede ser editado ni eliminado.
                                    </span>
                                </div>
                            @endif
                            <form wire:submit.prevent="editSession" autocomplete="off">
                                <div class="row">
                                    <!-- Mostrar la fecha de la reserva seleccionada como texto -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" data-translate="calendar_booking_date">
                                            Fecha de la reserva
                                        </label>
                                        <input type="text" class="form-control text-center" wire:model="form.form_date" readonly>
                                        <x-input-error field_name="form.form_date" />
                                    </div>
                                    <!-- Campo de Hora de Inicio -->
                                    <div class="col-md-6 mb-3">
                                        <label for="start_time_new" class="form-label" data-translate="calendar_start_time">
                                            Hora Inicio
                                        </label>

                                        <input type="text" id="start_time_new" class="form-control flatpickr-time"
                                            wire:model="form.start_time"
                                            placeholder="Selecciona hora de inicio"
                                            data-translate-placeholder="calendar_select_start_time">
                                        <x-input-error field_name="form.start_time" />
                                    </div>
                                    <!-- Campo de Hora de Fin -->
                                    <div class="col-md-6 mb-3">
                                        <label for="end_time_new" class="form-label" data-translate="calendar_end_time">
                                            Hora Fin
                                        </label>

                                        <input type="text" id="end_time_new" class="form-control flatpickr-time"
                                            wire:model="form.end_time"
                                            placeholder="Selecciona hora de fin"
                                            data-translate-placeholder="calendar_select_end_time">
                                        <x-input-error field_name="form.end_time" />
                                    </div>
                                </div>
                                <!-- Botones de Acción -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-loading" @if($slotHasBookings) disabled @endif>
                                        <span data-translate="general_save_update">{{ __('general.save_update') }}</span>
                                    </button>
                                    <button type="button" class="btn btn-danger" wire:click="deleteSession" @if($slotHasBookings) disabled @endif>
                                        <span data-translate="calendar_delete_booking">Eliminar reserva</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @vite([
        'public/css/flatpicker.css',
        'public/summernote/summernote-lite.min.css'
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <script>
        // Función compatible para emitir eventos Livewire
        function emitLivewireEvent(event, ...params) {
            if (window.Livewire && typeof window.Livewire.emit === 'function') {
                window.Livewire.emit(event, ...params);
            } else if (window.livewire && typeof window.livewire.emit === 'function') {
                window.livewire.emit(event, ...params);
            }
        }

        document.addEventListener('shown.bs.modal', function (event) {

            const selectedLang = localStorage.getItem('selectedLanguage') || 'es';

            const flatpickrLocale =
                selectedLang === 'pt' ? 'pt' :
                selectedLang === 'es' ? 'es' :
                'default';

            if (event.target.id === 'new-booking-modal') {
                flatpickr('#date_range_new', {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    locale: flatpickrLocale,
                });
                flatpickr('#start_time_new', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    minuteIncrement: 1,
                    locale: flatpickrLocale,
                });
                flatpickr('#end_time_new', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    minuteIncrement: 1,
                    locale: flatpickrLocale,
                });
            }
            // Inicializar Select2 en el modal de edición
            if (event.target.id === 'edit-session') {
                flatpickr('#date_range_new', {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    locale: flatpickrLocale,
                });
                flatpickr('#start_time_new', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    minuteIncrement: 1,
                    locale: flatpickrLocale,
                });
                flatpickr('#end_time_new', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    minuteIncrement: 1,
                    locale: flatpickrLocale,
                });
            }
        });

        if (window.Livewire) {
            Livewire.on('editSlot', slotId => {
                emitLivewireEvent('loadSlotForEdit', slotId);
            });
        }

        if (typeof Livewire !== 'undefined') {
            Livewire.on('toggleModel', (event) => {
                const modal = document.getElementById(event.id);
                if (modal) {
                    const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
                    if (event.action === 'show') {
                        bsModal.show();
                    } else if (event.action === 'hide') {
                        bsModal.hide();
                        setTimeout(() => {
                            document.body.classList.remove('modal-open');
                            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                            // Forzar visibilidad del calendario
                            document.querySelectorAll('.am-booking-wrapper, .am-booking-calander').forEach(el => {
                                el.style.display = 'block';
                            });
                        }, 300);
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            var editSessionModal = document.getElementById('edit-session');
            if (editSessionModal) {
                editSessionModal.addEventListener('hidden.bs.modal', function () {
                    window.location.reload();
                });
            }
            var newBookingModal = document.getElementById('new-booking-modal');
            if (newBookingModal) {
                newBookingModal.addEventListener('hidden.bs.modal', function () {
                    window.location.reload();
                });
            }
        });

        if (window.Livewire) {
            Livewire.on('forcePageReload', function() {
                window.location.reload();
            });
        }
    </script>
    <style>
        .custom-day-selector .day-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #f0f4f8;
            color: #5a6a85; 
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .custom-day-selector .day-circle:hover {
            background-color: #e1e8f0;
        }

        .custom-day-selector .day-checkbox:checked + .day-circle {
            background-color: #0d6efd;
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }
    </style>
@endpush