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
                    <div class="tutor-time-selector-box" style="padding: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
                        @php
                            $minTime = '07:00';
                            if ($selectedDay) {
                                $selectedDateObj = $currentDate->copy()->setDay($selectedDay);
                                if ($selectedDateObj->isToday()) {
                                    $minTime = now()->format('H:i');
                                    if ($minTime < '07:00') {
                                        $minTime = '07:00';
                                    }
                                }
                            }
                        @endphp
                        
                        {{-- Mensaje de Disponibilidad Real si no es Virtual --}}
                        @if(!$isVirtual)
                            <div style="margin-bottom: 16px;">
                                <span style="font-weight: 600; font-size: 0.9rem; color: #475569; display: block; margin-bottom: 8px;">Horarios disponibles del tutor para este día:</span>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    @foreach($tutorConfiguredRanges as $range)
                                        <span style="background: rgba(59, 130, 246, 0.1); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.2); padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 500;">
                                            {{ $range['start'] }} - {{ $range['end'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div style="margin-bottom: 16px;">
                                <span style="background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; display: inline-block;">
                                    Tutoría virtual libre (cualquier rango en pasos de 20 min)
                                </span>
                            </div>
                        @endif

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            {{-- HORA DE INICIO --}}
                            <div>
                                <label for="start-time-input" style="display: block; font-weight: 600; font-size: 0.85rem; color: #475569; margin-bottom: 6px;">Hora de Inicio</label>
                                <div style="position: relative;">
                                    <input type="time" id="start-time-input" wire:model.blur="startTime"
                                        min="{{ $minTime }}" max="23:20"
                                        style="width: 100%; padding: 11px 16px; background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; color: #1e293b; font-size: 0.95rem; outline: none; box-sizing: border-box; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05); transition: all 0.2s ease-in-out;"
                                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 4px rgba(59, 130, 246, 0.15)'"
                                        onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none'">
                                </div>
                            </div>

                            {{-- DURACIÓN --}}
                            <div>
                                <label for="duration-select" style="display: block; font-weight: 600; font-size: 0.85rem; color: #475569; margin-bottom: 6px;">Duración</label>
                                <select id="duration-select" wire:model.live="duration" class="select-input"
                                    style="box-sizing: border-box;">
                                    <option value="20">20 minutos</option>
                                    <option value="40">40 minutos</option>
                                    <option value="60">60 minutos (1 hr)</option>
                                    <option value="80">80 minutos</option>
                                    <option value="100">100 minutos</option>
                                    <option value="120">120 minutos (2 hrs)</option>
                                </select>
                            </div>
                        </div>

                        {{-- RESULTADOS Y ERRORES --}}
                        @if($timeRangeError)
                            <div style="padding: 10px 12px; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #b91c1c; font-size: 0.85rem; font-weight: 500;">
                                ⚠️ {{ $timeRangeError }}
                            </div>
                        @elseif($startTime && $endTime)
                            <div style="padding: 12px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; font-size: 0.9rem; color: #1e293b; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em;">Hora de Finalización</span>
                                    <span style="font-size: 1.1rem; font-weight: 700; color: #1d4ed8;">{{ $endTime }}</span>
                                </div>
                                <div style="text-align: right;">
                                    <span style="display: block; font-size: 0.75rem; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em;">Costo Total</span>
                                    <span style="font-size: 1.1rem; font-weight: 700; color: #047857;">
                                        @if($this->isAugustPromotion)
                                            Gratis (Promo)
                                        @else
                                            {{ number_format($montoFinal, 2) }} Bs.
                                        @endif
                                    </span>
                                </div>
                            </div>
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

                    <button wire:click="openReservationModal"
                        wire:loading.attr="disabled"
                        {{ $timeRangeError ? 'disabled' : '' }}
                        class="tutor-pay-btn"
                        style="{{ $timeRangeError ? 'opacity: 0.45; cursor: not-allowed; pointer-events: none;' : '' }}">
                        @if($isVirtual)
                            Solicitar disponibilidad
                        @else
                            Pagar y reservar
                        @endif
                    </button>

                    <div class="tutor-tooltip-content">
                        <strong>Paso 3:</strong>
                        @if($isVirtual)
                            <p>Envía una solicitud al tutor para este horario. Podrás realizar el pago una vez que el tutor la acepte.</p>
                        @else
                            <p>Haz clic aquí para confirmar tu reserva y realizar el pago inmediato.</p>
                        @endif
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

    <!-- ==================== MODAL SOLICITAR DISPONIBILIDAD (VIRTUAL) ==================== -->
    @if ($showVirtualModal)
        <div class="modal-overlay is-visible">
            <div class="modal-content" style="position: relative; overflow: auto; max-width: 540px;">

                @if ($reservaExitosa)
                    {{-- PANTALLA DE ÉXITO --}}
                    <div x-init="setTimeout(() => $wire.closeVirtualModal(), 2500)"
                        style="padding: 40px; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px;">
                        <div style="width: 70px; height: 70px; background-color: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 2rem; font-weight: bold;">
                            ✓
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0;">
                            ¡Solicitud enviada!
                        </h2>
                        <p style="font-size: 1rem; color: #64748b; margin: 0; max-width: 360px; text-align: center;">
                            Tu solicitud ha sido enviada al tutor. Recibirás una notificación en tu correo cuando sea aceptada o rechazada.
                        </p>
                    </div>
                @else
                    {{-- FORMULARIO SIMPLIFICADO --}}
                    <form wire:submit.prevent="makeVirtualRequest"
                        x-data="{ errorMateria: false, validarForm() { this.errorMateria = !$wire.selectedSubject; if (!this.errorMateria) { $wire.makeVirtualRequest(); } } }"
                        @submit.prevent="validarForm()">

                        {{-- ENCABEZADO --}}
                        <div style="padding: 24px 28px 16px 28px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <h2 style="margin: 0; font-size: 1.3rem; font-weight: 700; color: #0f172a;">Solicitar disponibilidad</h2>
                                <p style="margin: 4px 0 0 0; font-size: 0.85rem; color: #64748b;">El tutor tendrá 4 horas para confirmar o rechazar tu solicitud.</p>
                            </div>
                            <button type="button" wire:click="closeVirtualModal"
                                style="background: none; border: none; cursor: pointer; color: #94a3b8; padding: 4px; border-radius: 6px; line-height: 1;">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                    <path d="M6 6L18 18M18 6L6 18"/>
                                </svg>
                            </button>
                        </div>

                        <div style="padding: 24px 28px;">

                            {{-- BANNER INFORMATIVO --}}
                            <div style="display: flex; gap: 12px; align-items: flex-start; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px;">
                                <div style="flex-shrink: 0; margin-top: 2px;">
                                    <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/>
                                    </svg>
                                </div>
                                <p style="margin: 0; font-size: 0.88rem; color: #1d4ed8; line-height: 1.5;">
                                    Estás solicitando un horario fuera de los bloques configurados. <strong>No se realizará ningún cobro ahora.</strong> El pago se solicita únicamente si el tutor acepta.
                                </p>
                            </div>

                            {{-- RESUMEN DE HORARIO --}}
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 18px; margin-bottom: 20px;">
                                <p style="margin: 0 0 10px 0; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Resumen del Horario</p>
                                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.92rem; color: #1e293b;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748b; font-weight: 600;">Fecha:</span>
                                        <span style="font-weight: 600;">{{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \d\e F \d\e Y') }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748b; font-weight: 600;">Horario:</span>
                                        <span style="font-weight: 600;">{{ \Carbon\Carbon::parse($startTime)->format('h:i a') }} - {{ \Carbon\Carbon::parse($endTime)->format('h:i a') }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748b; font-weight: 600;">Duración:</span>
                                        <span style="font-weight: 600;">{{ $duration }} minutos</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between; border-top: 1px solid #e2e8f0; padding-top: 8px; margin-top: 4px;">
                                        <span style="color: #64748b; font-weight: 600;">Precio estimado:</span>
                                        <span style="font-weight: 700; color: #047857; font-size: 1.05rem;">{{ number_format($montoFinal, 2) }} Bs.</span>
                                    </div>
                                </div>
                            </div>

                            {{-- SELECTOR DE MATERIA --}}
                            <div class="custom-select-container" x-data="{
                                open: false,
                                selectedName: '{{ $selectedSubject ? $materiasTutor->where('subject.id', $selectedSubject)->first()?->subject->name ?? 'Elegir materia' : 'Elegir materia' }}'
                            }" x-on:click.away="open = false">

                                <label class="input-label">Materia</label>

                                <input type="hidden" id="materia-virtual" wire:model="selectedSubject">

                                <button type="button" class="custom-select-trigger" :class="{ 'input-error-active': errorMateria }" x-on:click="open = !open">
                                    <span x-text="selectedName" :class="{ 'select-placeholder': !$wire.selectedSubject }"></span>
                                    <svg class="select-arrow" :class="{ 'arrow-rotate': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>

                                <template x-if="errorMateria">
                                    <p class="field-error-message">Debes seleccionar una materia.</p>
                                </template>

                                <div class="custom-select-options" x-show="open" x-transition style="display: none;">
                                    @foreach ($materiasTutor as $materia)
                                        <div class="custom-option"
                                            :class="{ 'is-selected': $wire.selectedSubject == '{{ $materia->subject->id }}' }"
                                            x-on:click="$wire.set('selectedSubject', '{{ $materia->subject->id }}'); selectedName = '{{ addslashes($materia->subject->name) }}'; open = false; errorMateria = false;">
                                            <span class="option-text">{{ $materia->subject->name }}</span>
                                            <span class="option-check" x-show="$wire.selectedSubject == '{{ $materia->subject->id }}'">✓</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ACCIONES --}}
                            <div class="action-buttons" style="margin-top: 24px;" wire:loading.remove wire:target="makeVirtualRequest">
                                <button type="button" wire:click="closeVirtualModal" class="btn btn-primary">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary" style="background-color: #0284c7; color: #fff; border-color: #0284c7;">
                                    Enviar solicitud
                                </button>
                            </div>

                            {{-- LOADING --}}
                            <div wire:loading wire:target="makeVirtualRequest" style="text-align: center; padding: 16px 0; color: #64748b; font-size: 0.9rem;">
                                <div class="main-loading-ring" style="margin: 0 auto 10px;"></div>
                                Enviando tu solicitud...
                            </div>

                        </div>
                    </form>
                @endif

            </div>
        </div>
    @endif

    <!-- =========================== MODAL RESERVA (PAGO) ==================================-->
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

                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0;">
                            ¡Reserva realizada exitosamente!
                        </h2>

                        <p
                            style="display:block !important; font-size: 1rem; color: #64748b; margin: 0; max-width: 340px;">
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
                            <h2 class="form-title">Confirmar Reserva</h2>

                            {{-- CUPÓN --}}
                            <div class="coupon-section">
                                <label for="coupon" class="input-label" style="padding-top: 0.5rem">
                                    ¿Tienes un cupón de descuento?
                                </label>

                                <div id="couponInputContainer" wire:key="{{ $key }}">
                                    @if ($introCupon)
                                        <div class="coupon-input-group">
                                            <input type="text" wire:model="cuponCode" wire:click="mostrarCupones"
                                                placeholder="Ej. classgo25" class="coupon-input">

                                            <button type="button" wire:click="aplicarCupon" id="btnAplicar"
                                                class="btn-coupon btn btn-secondary">
                                                Aplicar
                                            </button>
                                        </div>
                                    @endif

                                    @if ($cuponSelecionado)
                                        <div id="appliedCouponContainer" class="applied-coupon-container">
                                            <p class="applied-coupon-text">
                                                Cupón aplicado: <br>
                                                <span id="appliedCouponCode" class="applied-coupon-code">
                                                    {{ $cuponCode }}
                                                </span>
                                            </p>

                                            <button type="button" wire:click="quitarCupon"
                                                class="remove-coupon-btn">
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

                                    <label class="input-label">Comprobante de pago</label>

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
                                                    <p class="file-upload-text cta-title-success">
                                                        ¡Comprobante adjuntado con éxito!
                                                    </p>

                                                    <p class="file-name-text">
                                                        {{ $paymentReceipt->getClientOriginalName() }}
                                                    </p>
                                                </div>

                                                <span class="cta-action-link">Cambiar archivo</span>
                                            @else
                                                <div class="cta-text-group">
                                                    <p class="file-upload-text cta-main-title">
                                                        ¡Sube tu comprobante de pago!
                                                    </p>

                                                    <p class="file-upload-subtext">
                                                        Haz clic para buscar tu captura o arrastra el archivo aquí
                                                        mismo.
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
                                            <span class="progress-text">Subiendo archivo al servidor...</span>
                                            <span class="progress-percentage" x-text="progress + '%'">0%</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- materia --}}

                            <div class="custom-select-container" x-data="{
                                open: false,
                                selectedName: '{{ $selectedSubject ? $materiasTutor->where('subject.id', $selectedSubject)->first()?->subject->name ?? 'Elegir materia' : 'Elegir materia' }}'
                            }"
                                x-on:click.away="open = false">

                                <label class="input-label">Materia</label>

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
                                        <strong>Fecha:</strong>
                                        <span>
                                            {{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \de F \de Y') }}
                                        </span>
                                    </p>

                                    <p class="info-box-p" style="display:block !important">
                                        <strong>Horario:</strong>

                                        @php
                                            sort($selectedTimes);
                                            $horaInicio = \Carbon\Carbon::parse(reset($selectedTimes))->format('h:i a');
                                            $horaFin = \Carbon\Carbon::parse(end($selectedTimes))
                                                ->addMinutes(20)
                                                ->format('h:i a');
                                        @endphp

                                        <span>{{ $horaInicio }} - {{ $horaFin }}</span>
                                        <br>
                                        <small>({{ count($selectedTimes) }} sesiones de 20 min continuas)</small>
                                    </p>

                                    @if ($descuento > 0)
                                        <p class="info-box-p" style="display:block !important;">
                                            <strong>Descuento ({{ $porcentaje }}%):</strong>
                                            -{{ number_format($descuento, 2) }} Bs.
                                        </p>
                                    @endif

                                    <p class="info-box-p" style="display:block !important;">
                                        <strong>Total a Pagar:</strong>

                                        <span
                                            style="font-size: 1.25rem; font-weight: bold; color: var(--secundary-color);">
                                            {{ number_format($montoFinal, 2) }} Bs.
                                        </span>
                                    </p>
                                </div>
                            @endif


                            <div class="action-buttons" wire:loading.remove wire:target="makeReservation">

                                <button type="button" wire:click="closeModal" wire:loading.attr="disabled"
                                    wire:target="makeReservation" class="btn btn-primary">
                                    Cancelar
                                </button>

                                <button type="submit" wire:loading.attr="disabled" wire:target="makeReservation"
                                    class="btn btn-primary">
                                    Reservar
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

                        <h3 class="loading-view-title">
                            Procesando tu reserva
                        </h3>

                        <p class="loading-view-desc">
                            Estamos asegurando tus bloques de horario y validando los datos con el servidor.
                            Por favor, no cierres esta ventana.
                        </p>
                    </div>
                </div>


            </div>

        </div>

    @endif


</div>
