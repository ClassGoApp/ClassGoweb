<!--Los estilos de reserva.blade.php se encuentran en tutor-perfil.css-->
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
            <div class="alert-successs  ">{{ session('success_message') }}</div>
        @endif

        @if (session()->has('error'))
            <div style="color:red">{{ session('error') }}</div>
        @endif

        <div class="tutor-availability-grid">
            {{-- CALENDARIO --}}

            <div>
                <h4 class="tutor-section-title">
                    <span class="tutor-tooltip-wrapper">
                        Mis días disponibles <span style="font-size: 0.8em; color: #fbbf24; cursor: help;">ⓘ</span>

                        <div class="tutor-tooltip-content tooltip-left-align">
                            <strong>Paso 1:</strong>
                            <p>Busca en el calendario los días marcados (círculos) y haz clic en el que prefieras.</p>
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
                        <h5 class="tutor-calendar-month">{{ $currentDate->translatedFormat('F Y') }}</h5>
                        <button wire:click="goToNextMonth" class="tutor-calendar-nav-btn"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="tutor-calendar-nav-icon">
                                <path d="m9 18 6-6-6-6"></path>
                            </svg></button>
                    </div>
                    <div class="tutor-calendar-grid">
                        <div class="tutor-calendar-day-label">D</div>
                        <div class="tutor-calendar-day-label">L</div>
                        <div class="tutor-calendar-day-label">M</div>
                        <div class="tutor-calendar-day-label">M</div>
                        <div class="tutor-calendar-day-label">J</div>
                        <div class="tutor-calendar-day-label">V</div>
                        <div class="tutor-calendar-day-label">S</div>
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
                            Selecciona una hora <span style="font-size: 0.8em; color: #fbbf24; cursor: help;">ⓘ</span>

                            <div class="tutor-tooltip-content tooltip-left-align">
                                <strong>Paso 2:</strong>
                                <p>Elige un bloque de horario disponible para confirmar la tutoria.</p>
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
                            <p class="tutor-no-availability">Horas no disponible</p>
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

                    <button wire:click="openReservationModal" wire:loading.attr="disabled" class="tutor-pay-btn">Pagar y
                        reservar</button>

                    <div class="tutor-tooltip-content">
                        <strong>Paso 3:</strong>
                        <p>Haz clic aquí para confirmar tu reserva y realizar el pago.</p>
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
                        <p class="alert-title">Función solo para Estudiantes</p>
                        <p class="alert-text">
                            Para poder reservar una sesión, necesitas utilizar una cuenta de tipo "Estudiante".
                        </p>
                        <p class="alert-text alert-subtext">
                            Si tienes una, por favor <a href="/logout" class="alert-link">cierra sesión</a> y vuelve a ingresar
                            con tu cuenta de estudiante.
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
                    <p class="alert-title">¡Casi listo para reservar!</p>
                    <p class="alert-text">
                        Para agendar una sesión, solo necesitas <a href="/login" class="alert-link">iniciar sesión</a> o
                        <a href="/register" class="alert-link">crear tu cuenta</a> de estudiante.
                    </p>
                </div>
            </div>
        </div>
    @endguest

    <!-- =========================== MODAL RESERVA ====================================-->
    @if ($showModal)
        <div class="modal-overlay is-visible">
            <div class="modal-content">
                <form wire:submit="makeReservation" class="modal-body">
                    @if ($banner100)
                        @if ($isAugustPromotion)
                            {{-- Bloque de promoción de agosto: sin cambios --}}
                            <div class="modal-promocion-column">
                                <img src="{{ asset('images/agosto.png') }}" alt="Promoción" class="banner_agosto">
                            </div>
                        @else
                            {{-- Selector inteligente de método de pago por país --}}
                            {{-- La pestaña inicial se elige desde PHP según CF-IPCountry --}}
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
                                        desc: 'Escanea este código desde la opción «Pagar QR» de Takenos. Disponible para usuarios con cuenta Takenos y saldo disponible.'
                                    }
                                }
                            }">

                                {{-- Pestañas de selección de método --}}
                                <div class="qr-method-tabs">
                                    <button type="button" class="qr-method-tab"
                                        :class="{ 'qr-method-tab--active': metodo === 'bolivia' }"
                                        @click="metodo = 'bolivia'">
                                        🇧🇴 QR Bolivia
                                    </button>
                                    <button type="button" class="qr-method-tab"
                                        :class="{ 'qr-method-tab--active': metodo === 'takenos' }"
                                        @click="metodo = 'takenos'">
                                        🌍 Takenos Internacional
                                    </button>
                                </div>

                                {{-- Imagen QR dinámica --}}
                                <img :src="qrs[metodo].src" :alt="qrs[metodo].alt" class="qr-image"
                                    style="transition: opacity 0.25s ease;">

                                {{-- Descripción dinámica del método seleccionado --}}
                                <div class="qr-method-info">
                                    <p class="qr-method-titulo" x-text="qrs[metodo].titulo"></p>
                                    <p class="qr-method-desc" x-text="qrs[metodo].desc"></p>
                                </div>
                            </div>
                        @endif
                    @else
                        {{-- Selector inteligente (cuando banner100 = false, ej. cupón parcial activo) --}}
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
                                    desc: 'Escanea este código desde la opción «Pagar QR» de Takenos. Disponible para usuarios con cuenta Takenos y saldo disponible.'
                                }
                            }
                        }">

                            {{-- Pestañas de selección de método --}}
                            <div class="qr-method-tabs">
                                <button type="button" class="qr-method-tab"
                                    :class="{ 'qr-method-tab--active': metodo === 'bolivia' }"
                                    @click="metodo = 'bolivia'">
                                    🇧🇴 QR Bolivia
                                </button>
                                <button type="button" class="qr-method-tab"
                                    :class="{ 'qr-method-tab--active': metodo === 'takenos' }"
                                    @click="metodo = 'takenos'">
                                    🌍 Takenos Internacional
                                </button>
                            </div>

                            {{-- Imagen QR dinámica --}}
                            <img :src="qrs[metodo].src" :alt="qrs[metodo].alt" class="qr-image"
                                style="transition: opacity 0.25s ease;">

                            {{-- Descripción dinámica del método seleccionado --}}
                            <div class="qr-method-info">
                                <p class="qr-method-titulo" x-text="qrs[metodo].titulo"></p>
                                <p class="qr-method-desc" x-text="qrs[metodo].desc"></p>
                            </div>
                        </div>
                    @endif



                    <div class="modal-form-column">
                        <h2 class="form-title">Confirmar Reserva</h2>
                        <!--Cupones-->
                        <div class="coupon-section">
                            <label for="coupon" class="input-label" style="padding-top: 0.5rem">¿Tienes un cupón de
                                descuento?</label>
                            <div id="couponInputContainer" wire:key="{{ $key }}">
                                <!--La opcion por defecto es esta, muestra los cupones que tiene disponible-->
                                @if ($introCupon)
                                    <div class="coupon-input-group">
                                        <input type="text" wire:model="cuponCode" wire:click="mostrarCupones"
                                            placeholder="Ej. classgo25" class="coupon-input">
                                        <button type="button" wire:click="aplicarCupon" id="btnAplicar"
                                            class="btn-coupon btn btn-secondary">Aplicar</button>
                                    </div>
                                @endif


                                @if ($cuponSelecionado)
                                    <div id="appliedCouponContainer" class="applied-coupon-container">
                                        <p class="applied-coupon-text">Cupón aplicado: <br>
                                            <span id="appliedCouponCode"
                                                class="applied-coupon-code">{{ $cuponCode }}</span>
                                        </p>
                                        <button type="button" wire:click="quitarCupon"
                                            class="remove-coupon-btn">Quitar</button>
                                    </div>
                                @endif

                                @if ($cuponMensage)
                                    <p class="coupon-message">{{ $cuponMensage }}</p>
                                @endif

                                <!--Aquí iran los cupones, extraer de BD-->

                                @if ($cupones)

                                    <div id="couponDropdown" wire:click.away="ocultarCupones"
                                        class="coupon-dropdown-content">
                                        @foreach ($cuponesUsuario as $cupon)
                                            <div class="list-cupon"
                                                wire:click="selecionarCupon('{{ $cupon->codigo }}')">
                                                {{ $cupon->nombre }}</div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                            {{-- <p id="couponMessage" class="coupon-message"></p> --}}
                        </div>

                        <!--COMPROBANTE-->

                        @if ($comprobante)
                            <div class="comprobante-section {{ $errors->has('paymentReceipt') ? 'input-error-active' : '' }}"
                                x-data="{
                                    isUploading: false,
                                    progress: 0,
                                    isDragging: false
                                }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 0"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <label class="input-label">Comprobante de pago</label>

                                <label for="comprobante" class="file-upload-cta-box"
                                    :class="{
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
                                  $wire.upload('paymentReceipt', file, 
                                      () => { isUploading = false; progress = 0; }, 
                                      () => { isUploading = false; }, 
                                      (event) => { progress = event.detail.progress; }
                                  );
                              }">

                                    <div class="file-upload-content">
                                        @if ($paymentReceipt)
                                            <div class="cta-text-group">
                                                <p class="file-upload-text cta-title-success">¡Comprobante adjuntado
                                                    con éxito!</p>
                                                <p class="file-name-text">
                                                    {{ $paymentReceipt->getClientOriginalName() }}</p>
                                            </div>
                                            <span class="cta-action-link">Cambiar archivo</span>
                                        @else
                                            <div class="cta-text-group">
                                                <p class="file-upload-text cta-main-title"
                                                    style="font-size: 1rem; font-weight: 700; color: #1e3a8a; margin-bottom: 4px;">
                                                    ¡Sube tu comprobante de pago!</p>
                                                <p class="file-upload-subtext">Haz clic para buscar tu captura o
                                                    arrastra el archivo aquí mismo.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <input type="file" id="comprobante" wire:model="paymentReceipt"
                                        class="file-input-hidden">
                                </label>

                                <div x-show="isUploading" x-transition class="progress-container"
                                    style="display: none;">
                                    <div class="progress-bar-wrapper">
                                        <div class="progress-bar-fill" :style="'width: ' + progress + '%'"></div>
                                    </div>
                                    <div class="progress-meta">
                                        <span class="progress-text">Subiendo archivo al servidor...</span>
                                        <span class="progress-percentage" x-text="progress + '%'">0%</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="custom-select-container {{ $errors->has('selectedSubject') ? 'input-error-active' : '' }}"
                            x-data="{
                                open: false,
                                selectedName: '{{ $selectedSubject ? $materiasTutor->where('subject.id', $selectedSubject)->first()?->subject->name ?? 'Elegir materia' : 'Elegir materia' }}'
                            }" x-on:click.away="open = false">

                            <label class="input-label">Materia</label>

                            <input type="hidden" id="materia" wire:model="selectedSubject">

                            <button type="button" class="custom-select-trigger" x-on:click="open = !open">
                                <span x-text="selectedName"
                                    :class="{ 'select-placeholder': !$wire.selectedSubject }"></span>
                                <svg class="select-arrow" :class="{ 'arrow-rotate': open }"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <div class="custom-select-options" x-show="open" x-transition style="display: none;">
                                @foreach ($materiasTutor as $materia)
                                    <div class="custom-option"
                                        :class="{ 'is-selected': $wire.selectedSubject == '{{ $materia->subject->id }}' }"
                                        x-on:click="$wire.set('selectedSubject', '{{ $materia->subject->id }}'); selectedName = '{{ addslashes($materia->subject->name) }}'; open = false">

                                        <span class="option-text">{{ $materia->subject->name }}</span>
                                        <span class="option-check"
                                            x-show="$wire.selectedSubject == '{{ $materia->subject->id }}'">✓</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!--Info Reservas-->

                        @if ($selectedDay && count($selectedTimes) > 0)
                            <div class="info-box">
                                <p class="info-box-p" style="display:block !important"><strong>Fecha:</strong>
                                    <span>{{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \de F \de Y') }}</span>
                                </p>

                                <p class="info-box-p" style="display:block !important"><strong>Horario:</strong>
                                    @php
                                        // Aseguramos el orden para mostrar el rango correcto
                                        sort($selectedTimes);
                                        $horaInicio = \Carbon\Carbon::parse(reset($selectedTimes))->format('h:i a');
                                        $horaFin = \Carbon\Carbon::parse(end($selectedTimes))
                                            ->addMinutes(20)
                                            ->format('h:i a');
                                    @endphp
                                    <span>{{ $horaInicio }} - {{ $horaFin }}</span>
                                    <br><small>({{ count($selectedTimes) }} sesiones de 20 min continuas)</small>
                                </p>

                                @if ($descuento > 0)
                                    <p class="info-box-p" style="display:block !important;"><strong>Descuento
                                            ({{ $porcentaje }}%):</strong>
                                        -{{ number_format($descuento, 2) }} Bs.</p>
                                @endif

                                <p class="info-box-p" style="display:block !important;"><strong>Total a
                                        Pagar:</strong>
                                    <span
                                        style="font-size: 1.25rem; font-weight: bold; color: var(--secundary-color);">
                                        {{ number_format($montoFinal, 2) }} Bs.
                                    </span>
                                </p>
                            </div>
                        @endif



                        <!--Botones de Acciones-->
                        <div class="action-buttons">
                            <button type="button" wire:click="closeModal" wire:loading.attr="disabled"
                                class="btn btn-primary">Cancelar</button>

                            <button type="submit" wire:loading.attr="disabled"
                                class="btn btn-primary">Reservar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
