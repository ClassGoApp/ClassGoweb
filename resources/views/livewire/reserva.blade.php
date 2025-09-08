<!--Los estilos de reserva.blade.php se encuentran en tutor-perfil.css-->
<div>
    <div class="section-reserva">
        {{-- Mensaje de éxito tras reservar --}}
        @if (session()->has('success_message'))
            <div class="alert-success" >{{ session('success_message') }}</div>
        @endif

        @if (session()->has('error'))
            <div style="color:red">{{ session('error') }}</div>
        @endif

        <div class="tutor-availability-grid">
            {{-- CALENDARIO --}}
            <div>
                <h4 class="tutor-section-title">Selecciona un día</h4>
            {{--  <div>
                    <p>ID del tutor: {{ $this->tutorId }}</p>
                </div> --}}
                <div class="tutor-calendar-box">
                    <div class="tutor-calendar-header">
                    <button wire:click="goToPreviousMonth" class="tutor-calendar-nav-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-calendar-nav-icon"><path d="m15 18-6-6 6-6"></path></svg></button>
                    <h5 class="tutor-calendar-month">{{ $currentDate->translatedFormat('F Y') }}</h5>
                    <button  wire:click="goToNextMonth" class="tutor-calendar-nav-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-calendar-nav-icon"><path d="m9 18 6-6-6-6"></path></svg></button>
                    </div>
                    <div class="tutor-calendar-grid">
                        <div class="tutor-calendar-day-label">D</div> 
                        <div class="tutor-calendar-day-label">L</div> 
                        <div class="tutor-calendar-day-label">M</div> 
                        <div class="tutor-calendar-day-label">M</div> 
                        <div class="tutor-calendar-day-label">J</div> 
                        <div class="tutor-calendar-day-label">V</div> 
                        <div class="tutor-calendar-day-label">S</div> 
                        @for ($i = 0; $i < $startDay; $i++) <div></div> @endfor
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $isAvailable = in_array($day, $daysWithAvailability);
                                $isSelected = $selectedDay == $day;
                                $isPast = $this->isPastDay($day);
                                $dayClasses = 'tutor-calendar-day';
                                if ($isAvailable) $dayClasses .= ' has-availability';
                                if ($isSelected) $dayClasses .= ' selected';
                                if ($isPast) $dayClasses .= ' past';
                            @endphp
                            <div wire:click="selectDay({{ $day }},{{ $currentDate->month }})" class="{{ $dayClasses }}">{{ $day }}</div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- SELECTOR DE HORA --}}
            @if ($selectedDay)
            <div class="tutor-time-selector-col">
                <h4 class="tutor-section-title">Selecciona una hora</h4>
                <div class="tutor-time-selector-box">
                    @if (!empty($availableTimeSlots))
                        <div class="tutor-time-slots">
                            @foreach ($availableTimeSlots as $slot)
                                @php
                                    $isOccupied = $slot['status'] === 'occupied';
                                    $isTimeSelected = $selectedTime === $slot['time'];
                                    $slotClasses = 'tutor-time-slot-btn';
                                    if ($isOccupied) $slotClasses .= ' occupied';
                                    if ($isTimeSelected) $slotClasses .= ' selected';
                                    
                                @endphp
                                <button wire:click="selectTime('{{ $slot['time'] }}')" class="{{ $slotClasses }}" @if($isOccupied) disabled @endif>
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
        <div class="tutor-pay-btn-box">
            <button wire:click="openReservationModal" class="tutor-pay-btn">Pagar y reservar</button>
        </div>

            @elserole('tutor')
            <div class="tutor-pay-btn-box">
                <p><i>Debes tener una cuenta "Estudiante" para poder reservar</i></p>
            </div>
        @endrole

    @endauth

    @guest
    <div class="tutor-pay-btn-box">
        <p><i>Debes tener una cuenta "Estudiante" para poder reservar</i></p>
    </div>
    @endguest
   
   <!-- =========================== MODAL RESERVA ====================================-->
    @if($showModal)
    <div class="modal-overlay is-visible">
        <div class="modal-content">
            <form wire:submit="makeReservation" class="modal-body">
                @if ($banner100)
                    @if($isAugustPromotion)
                    <div class="modal-promocion-column">
                            <img src="{{ asset('images/agosto.png') }}" alt="Promoción" class="banner_agosto">
                        </div>       
                    @else
                        <div class="modal-qr-column">
                            <img src="{{ asset('storage/qr/77b1a7da.jpg')}}" alt="Código QR" class="qr-image">
                        </div>
                    @endif
                @else
                    <div class="modal-qr-column">
                        <img src="{{ asset('storage/qr/77b1a7da.jpg')}}" alt="Código QR" class="qr-image">
                    </div>
                @endif
                    
              

                <div class="modal-form-column">
                    <h2 class="form-title">Confirmar Reserva</h2>
                    <!--Cupones-->
                    <div class="coupon-section">
                        <label for="coupon" class="input-label" style="padding-top: 0.5rem">¿Tienes un cupón de descuento?</label>
                        <div id="couponInputContainer" wire:key="{{ $key }}"> 
                            <!--La opcion por defecto es esta, muestra los cupones que tiene disponible-->
                            @if ($introCupon)
                                <div class="coupon-input-group">
                                    <input type="text" wire:model="cuponCode" wire:click="mostrarCupones" placeholder="Ej. classgo25" class="coupon-input">
                                    <button type="button" wire:click="aplicarCupon" id="btnAplicar" class="btn btn-secondary">Aplicar</button>
                                </div>   
                            @endif
                            

                            @if ($cuponSelecionado)
                            <div id="appliedCouponContainer" class="applied-coupon-container">
                                <p class="applied-coupon-text">Cupón aplicado: <br>
                                    <span id="appliedCouponCode" class="applied-coupon-code">{{ $cuponCode}}</span></p>
                                <button type="button" wire:click="quitarCupon" class="remove-coupon-btn">Quitar</button>
                            </div>   
                            @endif  

                            @if ($cuponMensage)
                                <p class="coupon-message">{{ $cuponMensage }}</p>
                            @endif

                            <!--Aquí iran los cupones, extraer de BD-->
                            
                            @if($cupones)
                            
                            <div id="couponDropdown" wire:click.away="ocultarCupones" class="coupon-dropdown-content">
                                    @foreach ($cuponesUsuario as $cupon)
                                      <div class="list-cupon" wire:click="selecionarCupon('{{ $cupon->codigo }}')">{{$cupon->nombre}}</div>   
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
                                        @if($paymentReceipt)
                                            <p id="fileUploadText" class="file-upload-text">{{ $paymentReceipt->getClientOriginalName() }}</p>
                                        @else
                                            <p id="fileUploadText" class="file-upload-text">Subir archivo</p>
                                        @endif
                                    </div>
                                    <input type="file" id="comprobante" wire:model="paymentReceipt" class="file-input-hidden">
                                </label>
                            </label>
                            @error('paymentReceipt') <span class="form-error">{{ $message }}</span> @enderror

                        </div>
                    @endif
                    

                    <!--Materias-->
                    <div>
                        <label for="materia" class="input-label">Materia</label>
                        <select id="materia" wire:model="selectedSubject" class="select-input">
                            <option value="">-- Elige una materia --</option>
                            @foreach($materiasTutor as $materia)
                                <option value="{{ $materia->subject->id }}">{{ $materia->subject->name }}</option>
                            @endforeach
                        </select>
                        @error('selectedSubject') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    
                    <!--Info Reservas-->
                    @if ($selectedDay && $selectedTime)
                        <div class="info-box">
                            <p><strong>Fecha:</strong> <span>{{ $currentDate->copy()->setDay($selectedDay)->translatedFormat('j \de F \de Y') }}</span></p>
                            <p><strong>Hora:</strong> <span>{{ \Carbon\Carbon::parse($selectedTime)->format('h:i a') }}</span></p>
                        </div>
                    @endif

                    

                    <!--Botones de Acciones-->
                    <div class="action-buttons">
                        <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Reservar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

<script>
    console.log('esta ejecuntadnos el script');
    
</script>


