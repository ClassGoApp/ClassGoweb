<!--Los estilos de reserva.blade.php se encuentran en tutor-perfil.css-->
<div>
    <div class="section-reserva">
        {{-- Mensaje de éxito tras reservar --}}
        @if (session()->has('success_message'))
            <div class="alert-success">{{ session('success_message') }}</div>
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
                                    @php
                                        $isOccupied = $slot['status'] === 'occupied';
                                        $isTimeSelected = $selectedTime === $slot['time'];
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
                    
                    <button wire:click="openReservationModal" class="tutor-pay-btn">Pagar y reservar</button>

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
                        Para agendar una sesión, solo necesitas <a href="/login" class="alert-link">iniciar sesión</a> o <a
                            href="/register" class="alert-link">crear tu cuenta</a> de estudiante.
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
                            <div class="modal-promocion-column">
                                <img src="{{ asset('images/agosto.png') }}" alt="Promoción" class="banner_agosto">
                            </div>
                        @else
                            <div class="modal-qr-column">
                                <img src="{{ asset('storage/qr/Qr-pagos.png') }}" alt="Código QR" class="qr-image">
                            </div>
                        @endif
                    @else
                        <div class="modal-qr-column">
                            <img src="{{ asset('storage/qr/Qr-pagos.png') }}" alt="Código QR" class="qr-image">
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
                                            class="btn btn-secondary">Aplicar</button>
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
                            <div>
                                <label class="input-label">Comprobante de pago</label>
                                <label for="comprobante" class="input-label">
                                    <label for="comprobante" class="file-upload-label">
                                        <div class="file-upload-content">
                                            <span class="file-upload-icon">📄</span>
                                            @if ($paymentReceipt)
                                                <p id="fileUploadText" class="file-upload-text">
                                                    {{ $paymentReceipt->getClientOriginalName() }}</p>
                                            @else
                                                <p id="fileUploadText" class="file-upload-text">Subir archivo</p>
                                            @endif
                                        </div>
                                        <input type="file" id="comprobante" wire:model="paymentReceipt"
                                            class="file-input-hidden">
                                    </label>
                                </label>
                                @error('paymentReceipt')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror

                            </div>
                        @endif


                        <!--Materias-->
                        <div>
                            <label for="materia" class="input-label">Materia</label>
                            <select id="materia" wire:model="selectedSubject" class="select-input">
                                <option value="">-- Elige una materia --</option>
                                @foreach ($materiasTutor as $materia)
                                    <option value="{{ $materia->subject->id }}">{{ $materia->subject->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedSubject')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!--Info Reservas-->
                        @if ($selectedDay && $selectedTime)
                            <div class="info-box">
                                <p><strong>Fecha:</strong>
                                    <span>{{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \de F \de Y') }}</span>
                                </p>
                                <p><strong>Hora:</strong>
                                    <span>{{ \Carbon\Carbon::parse($selectedTime)->format('h:i a') }}</span></p>
                            </div>
                        @endif



                        <!--Botones de Acciones-->
                        <div class="action-buttons">
                            <button type="button" wire:click="closeModal" class="btn btn-primary">Cancelar</button>

                            <button type="submit" class="btn btn-primary">Reservar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
