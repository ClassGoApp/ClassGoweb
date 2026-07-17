<!--Los estilos de reserva.blade.php se encuentran en tutor-perfil.css y modal-pagar.css-->
<div>
    @if ($showModal)
        <style>
            .tutor-actions-card,
            .tutor-pay-btn-box,
            .favorite-button-container-blue,
            .tutor-btn-reservar {
                display: none !important;
            }
        </style>
    @endif
    <div class="section-reserva">
        {{-- Mensaje de éxito tras reservar --}}
        @if (session()->has('success_message'))
            <div class="reserva-success-message">
                {{ session('success_message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div style="color:red">{{ session('error') }}</div>
        @endif

        <div class="tutor-availability-grid">
            {{-- CALENDARIO --}}

            <div>
                <h4 class="tutor-section-title">
                    <span class="tutor-tooltip-wrapper">
                        <span data-translate="reservation_available_days">Mis días disponibles</span> <span style="font-size: 0.8em; color: #fbbf24; cursor: help;">ⓘ</span>

                        <div class="tutor-tooltip-content tooltip-left-align">
                            <strong data-translate="reservation_step_1">Paso 1:</strong>
                            <p data-translate="reservation_step_1_desc">
                                Busca en el calendario los días marcados (círculos) y haz clic en el que prefieras.
                            </p>
                            <div class="tutor-tooltip-arrow"></div>
                        </div>
                    </span>
                </h4>
                <!--<h4 class="tutor-section-title">Mis días disponibles</h4>-->

                {{--  <div>
                    <p>ID del tutor: {{ $this->tutorId }}</p>
                </div> --}}
                <div class="tutor-calendar-box">
                    <div class="tutor-calendar-header">
                        <button wire:click="goToPreviousMonth" class="tutor-calendar-nav-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="tutor-calendar-nav-icon">
                                <path d="m15 18-6-6 6-6"></path>
                            </svg></button>
                        <h5 class="tutor-calendar-month"
                            data-calendar-month
                            data-month="{{ $currentDate->month }}"
                            data-year="{{ $currentDate->year }}">
                            {{ $currentDate->translatedFormat('F Y') }}
                        </h5>
                        <button wire:click="goToNextMonth" class="tutor-calendar-nav-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="tutor-calendar-nav-icon">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg></button>
                    </div>
                    <div class="tutor-calendar-grid">
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_sun_short">D</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_mon_short">L</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_tue_short">M</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_wed_short">M</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_thu_short">J</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_fri_short">V</div>
                        <div class="tutor-calendar-day-label" data-translate="calendar_day_sat_short">S</div>
                        @for ($i = 0; $i < $startDay; $i++)
                            <div></div>
                        @endfor
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $isAvailable = in_array($day, $daysWithAvailability);
                                $isSelected = $selectedDay == $day;
                                $isPast = $this->isPastDay($day);
                                $dayClasses = 'tutor-calendar-day';
                                if ($isAvailable) {
                                    $dayClasses .= ' has-availability';
                                }
                                if ($isSelected) {
                                    $dayClasses .= ' selected';
                                }
                                if ($isPast) {
                                    $dayClasses .= ' past';
                                }
                            @endphp
                            <div wire:click="selectDay({{ $day }},{{ $currentDate->month }})"
                                class="{{ $dayClasses }}">{{ $day }}</div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- SELECTOR DE HORA --}}
            @if ($selectedDay)
                <div class="tutor-time-selector-col">
                    <h4 class="tutor-section-title">
                        <span class="tutor-tooltip-wrapper">
                            <span data-translate="reservation_select_time">Selecciona una hora</span> <span style="font-size: 0.8em; color: #fbbf24; cursor: help;">ⓘ</span>

                            <div class="tutor-tooltip-content tooltip-left-align">
                                <strong data-translate="reservation_step_2">Paso 2:</strong>
                                <p data-translate="reservation_step_2_desc">
                                    Elige un bloque de horario disponible para confirmar la tutoría.
                                </p>
                                <div class="tutor-tooltip-arrow"></div>
                            </div>
                        </span>
                    </h4>
                    <!--<div class="tutor-time-selector-col">
                    <h4 class="tutor-section-title">Selecciona una hora</h4>-->
                    <div class="tutor-time-selector-box">
                        @if (!empty($availableTimeSlots))
                            <div class="tutor-time-slots">
                                @foreach ($availableTimeSlots as $slot)
                                    {{-- @php
                                        $isOccupied = $slot['status'] === 'occupied';
                                        $isTimeSelected = $selectedTime === $slot['time'];
                                        $slotClasses = 'tutor-time-slot-btn';
                                        if ($isOccupied) {
                                            $slotClasses .= ' occupied';
                                        }
                                        if ($isTimeSelected) {
                                            $slotClasses .= ' selected';
                                        }

                                    @endphp --}}

                                    {{-- Busca este bloque dentro de tu foreach de horas --}}
                                    @php
                                        $isOccupied = $slot['status'] === 'occupied';

                                        // CAMBIO: Ahora verificamos si la hora existe en el array selectedTimes
                                        $isTimeSelected = in_array($slot['time'], $selectedTimes);

                                        $slotClasses = 'tutor-time-slot-btn';
                                        if ($isOccupied) {
                                            $slotClasses .= ' occupied';
                                        }
                                        if ($isTimeSelected) {
                                            $slotClasses .= ' selected';
                                        }
                                    @endphp
                                    <button wire:click="selectTime('{{ $slot['time'] }}')" class="{{ $slotClasses }}"
                                        @if ($isOccupied) disabled @endif>
                                        {{ $slot['time'] }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <p class="tutor-no-availability" data-translate="reservation_no_hours_available">
                                Horas no disponible
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    @auth
        @role('student')
            <!-- Hover Boton Pagar y Reservar
            <div class="tutor-pay-btn-box">
                <button wire:click="openReservationModal" class="tutor-pay-btn">Pagar y reservar</button>
            </div>-->
            <div class="tutor-pay-btn-box">

                <span class="tutor-tooltip-wrapper">

                    <button wire:click="openReservationModal" wire:loading.attr="disabled" class="tutor-pay-btn" data-translate="reservation_pay_and_book">
                        Pagar y reservar
                    </button>

                    <div class="tutor-tooltip-content">
                        <strong data-translate="reservation_step_3">Paso 3:</strong>
                        <p data-translate="reservation_step_3_desc">
                            Haz clic aquí para confirmar tu reserva y realizar el pago.
                        </p>
                        <div class="tutor-tooltip-arrow"></div>
                    </div>

                </span>

            </div>

            @elserole('tutor')
            <div class="alert-box alert-amber" role="alert">
                <div class="alert-content">
                    <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <div>
                        <p class="alert-title" data-translate="reservation_only_students_title">
                            Función solo para Estudiantes
                        </p>

                        <p class="alert-text" data-translate="reservation_only_students_desc">
                            Para poder reservar una sesión, necesitas utilizar una cuenta de tipo "Estudiante".
                        </p>

                        <p class="alert-text alert-subtext">
                            <span data-translate="reservation_only_students_logout_prefix">Si tienes una, por favor</span>
                            <a href="/logout" class="alert-link" data-translate="reservation_logout_link">cierra sesión</a>
                            <span data-translate="reservation_only_students_logout_suffix">y vuelve a ingresar con tu cuenta de estudiante.</span>
                        </p>
                    </div>
                </div>
            </div>
        @endrole

    @endauth

    @guest
        <div class="alert-box alert-teal" role="alert">
            <div class="alert-content">
                <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="alert-title" data-translate="reservation_guest_title">
                        ¡Casi listo para reservar!
                    </p>

                    <p class="alert-text">
                        <span data-translate="reservation_guest_desc_prefix">Para agendar una sesión, solo necesitas</span>
                        <a href="/login" class="alert-link" data-translate="reservation_login_link">iniciar sesión</a>
                        <span data-translate="reservation_or">o</span>
                        <a href="/register" class="alert-link" data-translate="reservation_register_link">crear tu cuenta</a>
                        <span data-translate="reservation_guest_desc_suffix">de estudiante.</span>
                    </p>
                </div>
            </div>
        </div>
    @endguest

    <!-- =========================== MODAL RESERVA ====================================-->
    @if ($showModal)
        <div class="modal-overlay is-visible">
            <div class="modal-content" style="position: relative; overflow: auto;">

                @if ($reservaExitosa)
                    {{-- PANTALLA DE ÉXITO DESPUÉS DE LA CARGA --}}
                    <div wire:key="modal-success-panel" x-init="setTimeout(() => $wire.closeModal(), 2500)"
                        style="padding: 40px; text-align: center; display: flex !important; flex-direction: column; align-items: center; justify-content: center; gap: 16px; height: 100%;">

                        <div
                            style="width: 70px; height: 70px; background-color: #d1fae5; border-radius: 50%; display: flex !important; align-items: center; justify-content: center; color: #10b981; font-size: 2rem; font-weight: bold;">
                            ✓
                        </div>

                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0;" data-translate="reservation_success_title">
                            ¡Reserva realizada exitosamente!
                        </h2>

                        <p style="display:block !important; font-size: 1rem; color: #64748b; margin: 0; max-width: 340px;" data-translate="reservation_success_desc">
                            También podrás ver tus reservas en el panel de tu perfil.
                        </p>
                    </div>
                @else
                    {{-- FORMULARIO DE RESERVA --}}
                    <form wire:key="modal-form-panel" class="modal-body" x-data="{
                        errorMateria: false,
                        errorComprobante: false,
                        comprobanteRequerido: {{ $comprobante ? 'true' : 'false' }},
                        validarFormulario() {
                            this.errorMateria = !$wire.selectedSubject;
                            this.errorComprobante = this.comprobanteRequerido && !$wire.paymentReceipt;
                    
                            if (!this.errorMateria && !this.errorComprobante) {
                                $wire.makeReservation();
                            }
                        }
                    }"
                        @submit.prevent="validarFormulario()">

                        {{-- COLUMNA QR / PROMOCIÓN --}}
                        @if ($banner100)
                            @if ($isAugustPromotion)
                                <div class="modal-promocion-column">
                                    <img src="{{ asset('images/agosto.png') }}" alt="Promoción"
                                        class="banner_agosto">
                                </div>
                            @else
                                <div class="modal-qr-column" x-data="{
                                    metodo: '{{ $paisDetectado === 'BO' ? 'bolivia' : 'takenos' }}',
                                    qrs: {
                                        bolivia: {
                                            src: '{{ asset('storage/qr/Qr-pagos.png') }}',
                                            alt: 'QR Pago Nacional Bolivia',
                                            titulo: 'Pago mediante QR nacional',
                                            desc: 'Escanea el código QR desde tu banco o billetera digital boliviana y realiza el pago en bolivianos.'
                                        },
                                        takenos: {
                                            src: '{{ asset('storage/qr/qr-takenos.png') }}',
                                            alt: 'QR Pago Takenos Internacional',
                                            titulo: 'Pago internacional con Takenos',
                                            desc: 'Escanea este código desde la opción «Pagar QR» de Takenos.'
                                        }
                                    }
                                }">

                                    <div class="qr-method-tabs">
                                        <button type="button" class="qr-method-tab"
                                            :class="{ 'qr-method-tab--active': metodo === 'bolivia' }"
                                            @click="metodo = 'bolivia'">
                                            🇧🇴 QR Bolivia
                                        </button>

                                        <button type="button" class="qr-method-tab"
                                            :class="{ 'qr-method-tab--active': metodo === 'takenos' }"
                                            @click="metodo = 'takenos'">
                                            Takenos Internacional
                                        </button>
                                    </div>

                                    <img :src="qrs[metodo].src" :alt="qrs[metodo].alt" class="qr-image">
                                    <a :href="qrs[metodo].src"
                                        :download="metodo === 'bolivia' ? 'QR-Pago-en-Bs.png' : 'QR-Pago-en-USD.png'"
                                        :aria-label="metodo === 'bolivia' ? 'Descargar QR Bolivia' : 'Descargar QR Takenos'"
                                        class="qr-download-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3">
                                            </line>
                                        </svg>

                                        <span
                                            x-text="metodo === 'bolivia' ? 'Descargar QR Bolivia' : 'Descargar QR Takenos'"></span>
                                    </a>

                                    <div class="qr-method-info">
                                        <p class="qr-method-titulo" x-text="qrs[metodo].titulo"></p>
                                        <p class="qr-method-desc" x-text="qrs[metodo].desc"></p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="modal-qr-column" x-data="{
                                metodo: '{{ $paisDetectado === 'BO' ? 'bolivia' : 'takenos' }}',
                                qrs: {
                                    bolivia: {
                                        src: '{{ asset('storage/qr/Qr-pagos.png') }}',
                                        alt: 'QR Pago Nacional Bolivia',
                                        titulo: 'Pago mediante QR nacional',
                                        desc: 'Escanea el código QR desde tu banco o billetera digital boliviana y realiza el pago en bolivianos.'
                                    },
                                    takenos: {
                                        src: '{{ asset('storage/qr/qr-takenos.png') }}',
                                        alt: 'QR Pago Takenos Internacional',
                                        titulo: 'Pago internacional con Takenos',
                                        desc: 'Escanea este código desde la opción «Pagar QR» de Takenos.'
                                    }
                                }
                            }">

                                <div class="qr-method-tabs">
                                    <button type="button" class="qr-method-tab"
                                        :class="{ 'qr-method-tab--active': metodo === 'bolivia' }"
                                        @click="metodo = 'bolivia'">
                                        🇧🇴 QR Bolivia
                                    </button>

                                    <button type="button" class="qr-method-tab"
                                        :class="{ 'qr-method-tab--active': metodo === 'takenos' }"
                                        @click="metodo = 'takenos'">
                                        Takenos Internacional
                                    </button>
                                </div>

                                <img :src="qrs[metodo].src" :alt="qrs[metodo].alt" class="qr-image">
                                <a :href="qrs[metodo].src"
                                    :download="metodo === 'bolivia' ? 'QR-Pago-Bolivia.png' : 'QR-Takenos-Internacional.png'"
                                    :aria-label="metodo === 'bolivia' ? 'Descargar QR Bolivia' : 'Descargar QR Takenos'"
                                    class="qr-download-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>

                                    <span
                                        x-text="metodo === 'bolivia' ? 'Descargar QR Bolivia' : 'Descargar QR Takenos'"></span>
                                </a>
                                <div class="qr-method-info">
                                    <p class="qr-method-titulo" x-text="qrs[metodo].titulo"></p>
                                    <p class="qr-method-desc" x-text="qrs[metodo].desc"></p>
                                </div>
                            </div>
                        @endif

                        {{-- COLUMNA FORMULARIO --}}
                        <div class="modal-form-column">
                            <h2 class="form-title" data-translate="reservation_confirm_title">
                                Confirmar Reserva
                            </h2>

                            {{-- CUPÓN --}}
                            <div class="coupon-section">
                                <label for="coupon" class="input-label" style="padding-top: 0.5rem" data-translate="reservation_coupon_question">
                                    ¿Tienes un cupón de descuento?
                                </label>

                                <div id="couponInputContainer" wire:key="{{ $key }}">
                                    @if ($introCupon)
                                        <div class="coupon-input-group">
                                            <input type="text" wire:model="cuponCode" wire:click="mostrarCupones"
                                                placeholder="Ej. classgo25"
                                                data-placeholder-key="reservation_coupon_placeholder"
                                                class="coupon-input">

                                            <button type="button" wire:click="aplicarCupon" id="btnAplicar"
                                                class="btn-coupon btn btn-secondary" data-translate="reservation_apply_coupon">
                                                Aplicar
                                            </button>
                                        </div>
                                    @endif

                                    @if ($cuponSelecionado)
                                        <div id="appliedCouponContainer" class="applied-coupon-container">
                                            <p class="applied-coupon-text">
                                                <span data-translate="reservation_coupon_applied">Cupón aplicado:</span> <br>
                                                <span id="appliedCouponCode" class="applied-coupon-code">
                                                    {{ $cuponCode }}
                                                </span>
                                            </p>

                                            <button type="button" wire:click="quitarCupon" class="remove-coupon-btn" data-translate="reservation_remove_coupon">
                                                Quitar
                                            </button>
                                        </div>
                                    @endif

                                    @if ($cuponMensage)
                                        <p class="coupon-message">{{ $cuponMensage }}</p>
                                    @endif

                                    @if ($cupones)
                                        <div id="couponDropdown" wire:click.away="ocultarCupones"
                                            class="coupon-dropdown-content">

                                            @foreach ($cuponesUsuario as $cupon)
                                                <div class="list-cupon"
                                                    wire:click="selecionarCupon('{{ $cupon->codigo }}')">
                                                    {{ $cupon->nombre }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- COMPROBANTE --}}
                            @if ($comprobante)
                                <div class="comprobante-section" x-data="{ isUploading: false, progress: 0, isDragging: false }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false; progress = 0; errorComprobante = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <label class="input-label" data-translate="reservation_payment_receipt">
                                        Comprobante de pago
                                    </label>

                                    <label for="comprobante"
                                        class="file-upload-cta-box {{ $errors->has('paymentReceipt') ? 'input-error-active' : '' }}"
                                        :class="{
                                            'input-error-active': errorComprobante,
                                            'is-uploading': isUploading,
                                            'has-file': {{ $paymentReceipt ? 'true' : 'false' }},
                                            'is-dragging': isDragging
                                        }"
                                        x-on:dragover.prevent="isDragging = true"
                                        x-on:dragleave.prevent="isDragging = false"
                                        x-on:drop.prevent="isDragging = false;
                const file = $event.dataTransfer.files[0];

                if (file) {
                    isUploading = true;

                    $wire.upload(
                        'paymentReceipt',
                        file,
                        () => {
                            isUploading = false;
                            progress = 0;
                            errorComprobante = false;
                        },
                        () => {
                            isUploading = false;
                        },
                        (event) => {
                            progress = event.detail.progress;
                        }
                    );
                }">

                                        <div class="file-upload-content">
                                            @if ($paymentReceipt)
                                                <div class="cta-text-group">
                                                    <p class="file-upload-text cta-title-success" data-translate="reservation_receipt_uploaded">
                                                        ¡Comprobante adjuntado con éxito!
                                                    </p>

                                                    <p class="file-name-text">
                                                        {{ $paymentReceipt->getClientOriginalName() }}
                                                    </p>
                                                </div>

                                                <span class="cta-action-link" data-translate="reservation_change_file">
                                                    Cambiar archivo
                                                </span>
                                            @else
                                                <div class="cta-text-group">
                                                    <p class="file-upload-text cta-main-title" data-translate="reservation_upload_receipt">
                                                        ¡Sube tu comprobante de pago!
                                                    </p>

                                                    <p class="file-upload-subtext" data-translate="reservation_upload_receipt_desc">
                                                        Haz clic para buscar tu captura o arrastra el archivo aquí mismo.
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <input type="file" id="comprobante" wire:model="paymentReceipt"
                                            class="file-input-hidden">
                                    </label>

                                    @error('paymentReceipt')
                                        <p class="field-error-message">{{ $message }}</p>
                                    @enderror

                                    <div x-show="isUploading" x-transition class="progress-container"
                                        style="display: none;">

                                        <div class="progress-bar-wrapper">
                                            <div class="progress-bar-fill" :style="'width: ' + progress + '%'">
                                            </div>
                                        </div>

                                        <div class="progress-meta">
                                            <span class="progress-text" data-translate="reservation_uploading_file">
                                                Subiendo archivo al servidor...
                                            </span>
                                            <span class="progress-percentage" x-text="progress + '%'">0%</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- materia --}}

                            <div class="custom-select-container" x-data="{
                                open: false,
                                selectedName: '{{ $selectedSubject ? $materiasTutor->where('subject.id', $selectedSubject)->first()?->subject->name ?? 'Elegir materia' : 'Elegir materia' }}',
                                subjectPlaceholder: reservationText('reservation_choose_subject', 'Elegir materia')
                            }"
                            x-init="if (!{{ $selectedSubject ? 'true' : 'false' }}) selectedName = subjectPlaceholder"
                            x-on:click.away="open = false">

                                <label class="input-label" data-translate="reservation_subject_label">
                                    Materia
                                </label>

                                <input type="hidden" id="materia" wire:model="selectedSubject">

                                <button type="button" wire:loading.remove wire:target="makeReservation"
                                    class="custom-select-trigger {{ $errors->has('selectedSubject') ? 'input-error-active' : '' }}"
                                    :class="{ 'input-error-active': errorMateria }" x-on:click="open = !open">

                                    <span x-text="selectedName"
                                        :class="{ 'select-placeholder': !$wire.selectedSubject }">
                                    </span>

                                    <svg class="select-arrow" :class="{ 'arrow-rotate': open }"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">

                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>

                                @error('selectedSubject')
                                    <p class="field-error-message">{{ $message }}</p>
                                @enderror

                                <div class="custom-select-options" x-show="open" x-transition
                                    style="display: none;">

                                    @foreach ($materiasTutor as $materia)
                                        <div class="custom-option"
                                            :class="{ 'is-selected': $wire.selectedSubject == '{{ $materia->subject->id }}' }"
                                            x-on:click="
                    $wire.set('selectedSubject', '{{ $materia->subject->id }}');
                    selectedName = '{{ addslashes($materia->subject->name) }}';
                    open = false;
                    errorMateria = false;
                ">

                                            <span class="option-text">
                                                {{ $materia->subject->name }}
                                            </span>

                                            <span class="option-check"
                                                x-show="$wire.selectedSubject == '{{ $materia->subject->id }}'">
                                                ✓
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- INFO RESERVA --}}
                            @if ($selectedDay && count($selectedTimes) > 0)
                                <div class="info-box" wire:loading.remove wire:target="makeReservation">

                                    <p class="info-box-p" style="display:block !important">
                                        <strong data-translate="reservation_date_label">Fecha:</strong>
                                        <span>
                                            {{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \de F \de Y') }}
                                        </span>
                                    </p>

                                    <p class="info-box-p" style="display:block !important">
                                        <strong data-translate="reservation_schedule_label">Horario:</strong>

                                        @php
                                            sort($selectedTimes);
                                            $horaInicio = \Carbon\Carbon::parse(reset($selectedTimes))->format('h:i a');
                                            $horaFin = \Carbon\Carbon::parse(end($selectedTimes))
                                                ->addMinutes(20)
                                                ->format('h:i a');
                                        @endphp

                                        <span>{{ $horaInicio }} - {{ $horaFin }}</span>
                                        <br>
                                        <small>
                                            ({{ count($selectedTimes) }}
                                            @if(count($selectedTimes) == 1)
                                                <span data-translate="reservation_session_singular">sesión de 20 min continua</span>
                                            @else
                                                <span data-translate="reservation_session_plural">sesiones de 20 min continuas</span>
                                            @endif
                                            )
                                        </small>
                                    </p>

                                    @if ($descuento > 0)
                                        <p class="info-box-p" style="display:block !important;">
                                            <strong>
                                                <span data-translate="reservation_discount_label">Descuento</span> ({{ $porcentaje }}%):
                                            </strong>
                                            -{{ number_format($descuento, 2) }} Bs.
                                        </p>
                                    @endif

                                    <p class="info-box-p" style="display:block !important;">
                                        <strong data-translate="reservation_total_to_pay">
                                            Total a Pagar:
                                        </strong>

                                        <span
                                            style="font-size: 1.25rem; font-weight: bold; color: var(--secundary-color);">
                                            {{ number_format($montoFinal, 2) }} Bs.
                                        </span>
                                    </p>
                                </div>
                            @endif


                            <div class="action-buttons" wire:loading.remove wire:target="makeReservation">

                                <button type="button" wire:click="closeModal" wire:loading.attr="disabled"
                                    wire:target="makeReservation" class="btn btn-primary" data-translate="reservation_cancel">
                                    Cancelar
                                </button>

                                <button wire:loading.attr="disabled" type="button" style="background-color: #FB8500; color: white;" 
                                    wire:click='$dispatch("openModalMaterialApoyo")'
                                    class="btn btn-primary">
                                    Siguiente
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
                {{-- PANTALLA DE CARGA --}}
                <div wire:loading wire:target="makeReservation" wire:key="column-loading-view"
                    class="modal-full-loading-overlay" style="display: absolute !important;">
                    <div class="loading-center-box">
                        <div class="main-loading-ring"></div>

                        <h3 class="loading-view-title" data-translate="reservation_processing_title">
                            Procesando tu reserva
                        </h3>

                        <p class="loading-view-desc" data-translate="reservation_processing_desc">
                            Estamos asegurando tus bloques de horario y validando los datos con el servidor.
                            Por favor, no cierres esta ventana.
                        </p>
                    </div>
                </div>

                <livewire:modal-material-apoyo />

            </div>

        </div>

    @endif

    <script>
    function reservationText(key, fallback = '') {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        if (typeof translations === 'undefined') {
            return fallback;
        }

        const t = translations[lang] || translations.es;

        return t[key] || fallback;
    }

    function applyReservationPlaceholders() {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        if (typeof translations === 'undefined') {
            return;
        }

        const t = translations[lang] || translations.es;

        document.querySelectorAll('[data-placeholder-key]').forEach((element) => {
            const key = element.getAttribute('data-placeholder-key');

            if (t[key]) {
                element.setAttribute('placeholder', t[key]);
            }
        });
    }

    function applyReservationCalendarMonth() {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        const localeMap = {
            es: 'es-BO',
            en: 'en-US',
            pt: 'pt-BR'
        };

        const locale = localeMap[lang] || 'es-BO';

        document.querySelectorAll('[data-calendar-month]').forEach((element) => {
            const month = parseInt(element.getAttribute('data-month'), 10);
            const year = parseInt(element.getAttribute('data-year'), 10);

            if (!month || !year) return;

            const date = new Date(year, month - 1, 1);

            let text = new Intl.DateTimeFormat(locale, {
                month: 'long',
                year: 'numeric'
            }).format(date);

            text = text.charAt(0).toUpperCase() + text.slice(1);

            element.textContent = text;
        });
    }

    function applyReservationTranslationsAfterLivewire() {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        applyReservationPlaceholders();
        applyReservationCalendarMonth();

        if (typeof selectLanguage === 'function') {
            selectLanguage(lang, false);
        }
    }

    document.addEventListener('DOMContentLoaded', applyReservationTranslationsAfterLivewire);
    document.addEventListener('livewire:navigated', applyReservationTranslationsAfterLivewire);

    document.addEventListener('languageChanged', function() {
        applyReservationPlaceholders();
        applyReservationCalendarMonth();
    });

    document.addEventListener('livewire:init', function() {
        Livewire.hook('morph.updated', function() {
            setTimeout(applyReservationTranslationsAfterLivewire, 50);
        });
    });
</script>

</div>
