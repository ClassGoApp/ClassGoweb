<div id="js-booking-modal" class="booking-modal booking-modal--hidden">
    <div id="js-modal-content" class="booking-modal__content">
        <div class="booking-modal__body">
            <button id="js-close-modal-btn" class="booking-modal__close" aria-label="Cerrar">
                <svg class="booking-modal__close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <h2 class="booking-modal__title">Proceso de Reserva</h2>

            <div class="booking-stepper">
                <div class="booking-stepper__wrapper">
                    <div id="step-1" class="booking-stepper__item booking-stepper__item--active" data-step="1">
                        <div class="booking-stepper__icon">1</div>
                        <p class="booking-stepper__label">Materia</p>
                    </div>
                    <div class="booking-stepper__line"></div>
                    <div id="step-2" class="booking-stepper__item" data-step="2">
                        <div class="booking-stepper__icon">2</div>
                        <p class="booking-stepper__label">Horario</p>
                    </div>
                    <div class="booking-stepper__line"></div>
                    <div id="step-3" class="booking-stepper__item" data-step="3">
                        <div class="booking-stepper__icon">3</div>
                        <p class="booking-stepper__label">Pago</p>
                    </div>
                </div>
            </div>

            <div class="booking-steps">
                <!-- STEP 1: Materia -->
                <div id="content-step-1" class="booking-step" data-content="1">
                    <div class="booking-step__container">
                        <h3 class="booking-step__title">Selecciona una materia</h3>
                        <p class="booking-step__subtitle">¿Qué te gustaría aprender o reforzar hoy?</p>
                        <div class="booking-form__group">
                            <label for="js-subject-select" class="booking-form__label">Materia</label>
                            <select id="js-subject-select" name="subject" class="booking-form__select">
                                <option>Matemáticas Avanzadas</option>
                                <option>Física Cuántica</option>
                                <option>Química Orgánica</option>
                                <option>Programación en Python</option>
                                <option>Historia del Arte</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Horario -->
                <div id="content-step-2" class="booking-step booking-step--hidden" data-content="2">
                    <div class="booking-step__grid">
                        <div>
                            <h3 class="booking-step__title">Selecciona un día</h3>
                            <div id="js-calendar-container" class="booking-calendar">
                                <div class="booking-calendar__header">
                                    <button id="js-prev-month-btn" class="booking-calendar__nav-btn">&lt;</button>
                                    <h4 id="js-month-year" class="booking-calendar__month"></h4>
                                    <button id="js-next-month-btn" class="booking-calendar__nav-btn">&gt;</button>
                                </div>
                                <div id="js-calendar-days" class="booking-calendar__grid"></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="booking-step__title">Selecciona una hora</h3>
                            <div id="js-time-slots-container" class="booking-timeslots"></div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Pago -->
                <div id="content-step-3" class="booking-step booking-step--hidden" data-content="3">
                    <div class="booking-step__grid">
                        <div>
                            <h3 class="booking-summary__section-title">Resumen de la Reserva</h3>
                            <div class="booking-summary">
                                <div class="booking-summary__details">
                                    <div class="booking-summary__row">
                                        <span class="booking-summary__label">Materia:</span>
                                        <span id="js-summary-subject" class="booking-summary__value"></span>
                                    </div>
                                    <div class="booking-summary__row">
                                        <span class="booking-summary__label">Fecha:</span>
                                        <span id="js-summary-date" class="booking-summary__value"></span>
                                    </div>
                                    <div class="booking-summary__row">
                                        <span class="booking-summary__label">Hora:</span>
                                        <span id="js-summary-time" class="booking-summary__value"></span>
                                    </div>
                                </div>

                                <div class="booking-summary__divider"></div>

                                <div class="booking-form__group">
                                    <label for="js-coupon-input" class="booking-form__label">¿Tienes un cupón?</label>
                                    <div class="booking-summary__coupon-group">
                                        <input id="js-coupon-input" type="text" placeholder="Ej. PROMO25" class="booking-form__input">
                                        <button id="js-apply-coupon-btn" class="booking-btn booking-btn--secondary">Aplicar</button>
                                    </div>
                                    <p id="js-coupon-message" class="booking-summary__message"></p>
                                </div>

                                <div class="booking-form__group">
                                    <label class="booking-form__label">Comprobante de pago</label>
                                    <label for="js-file-upload" class="booking-form__file-upload">
                                        <span>Subir archivo</span>
                                    </label>
                                    <input id="js-file-upload" name="file-upload" type="file" class="booking-form__file-input">
                                </div>

                                <div class="booking-summary__divider"></div>

                                <div class="booking-summary__total">
                                    <span>Total a pagar:</span>
                                    <span id="js-summary-total">$50.00</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="booking-summary__section-title">Método de Pago</h3>
                            <div class="booking-payment">
                                <div class="booking-payment__tabs">
                                    <button class="booking-payment__tab booking-payment__tab--active" data-target="qr-payment">QR</button>
                                    <button class="booking-payment__tab" data-target="transfer-payment">Transferencia</button>
                                </div>
                                
                                <div id="qr-payment" class="booking-payment__content">
                                    <p>Escanea el código para pagar</p>
                                    <div class="booking-payment__qr-container">QR</div>
                                    <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.5rem;">Válido hasta: 14 de mayo de 2026</p>
                                </div>
                                
                                <div id="transfer-payment" class="booking-payment__content booking-payment__content--hidden">
                                    <p>Realiza la transferencia a la siguiente cuenta:</p>
                                    <div class="booking-payment__transfer-info">
                                        <div class="booking-payment__transfer-row">
                                            <strong>Banco:</strong> Banco Nacional de Bolivia
                                        </div>
                                        <div class="booking-payment__transfer-row">
                                            <strong>N° de Cuenta:</strong> 2502661143
                                        </div>
                                        <div class="booking-payment__transfer-row">
                                            <strong>Titular:</strong> Jane Doe
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LOADER STATE -->
                <div id="js-loader" class="booking-modal__state booking-modal__state--hidden">
                    <div class="booking-modal__spinner"></div>
                    <p class="booking-modal__state-text">Procesando tu reserva...</p>
                </div>

                <!-- CONFIRMATION STATE -->
                <div id="js-confirmation" class="booking-modal__state booking-modal__state--hidden">
                    <div class="booking-modal__state-icon">
                        <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #059669;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="booking-modal__state-title">¡Reservado correctamente!</h3>
                    <p class="booking-modal__state-text">Tu reserva está en proceso de revisión. Recibirás una confirmación por correo electrónico pronto.</p>
                    <button id="js-accept-btn" class="booking-btn booking-btn--primary" style="margin-top: 2rem;">Aceptar</button>
                </div>
            </div>

            <div id="js-navigation-buttons" class="booking-navigation">
                <button id="js-back-btn" class="booking-btn booking-btn--secondary" disabled>Atrás</button>
                <button id="js-next-btn" class="booking-btn booking-btn--primary">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // ===================================================================
    // SELECTORES DEL DOM
    // ===================================================================
    const bookingModal = document.getElementById('js-booking-modal');
    const modalContent = document.getElementById('js-modal-content');
    const closeModalBtn = document.getElementById('js-close-modal-btn');
    const backBtn = document.getElementById('js-back-btn');
    const nextBtn = document.getElementById('js-next-btn');
    const acceptBtn = document.getElementById('js-accept-btn');
    const steps = document.querySelectorAll('.booking-stepper__item');
    const stepContents = document.querySelectorAll('.booking-step');
    const stepLines = document.querySelectorAll('.booking-stepper__line');
    const navigationButtons = document.getElementById('js-navigation-buttons');
    const loader = document.getElementById('js-loader');
    const confirmation = document.getElementById('js-confirmation');

    // Elementos del Paso 3 (Pago)
    const couponInput = document.getElementById('js-coupon-input');
    const applyCouponBtn = document.getElementById('js-apply-coupon-btn');
    const couponMessage = document.getElementById('js-coupon-message');
    const summaryTotal = document.getElementById('js-summary-total');
    const paymentTabs = document.querySelectorAll('.booking-payment__tab');
    const paymentContents = document.querySelectorAll('.booking-payment__content');

    // Elementos del Paso 2 (Horario)
    const monthYearEl = document.getElementById('js-month-year');
    const calendarDaysEl = document.getElementById('js-calendar-days');
    const timeSlotsEl = document.getElementById('js-time-slots-container');
    const prevMonthBtn = document.getElementById('js-prev-month-btn');
    const nextMonthBtn = document.getElementById('js-next-month-btn');
    const calendarContainer = document.getElementById('js-calendar-container');

    // ===================================================================
    // ESTADO DEL MODAL Y DATOS
    // ===================================================================
    let currentStep = 1;
    const totalSteps = 3;
    let currentDate = new Date();
    
    const basePrice = 50.00;
    let currentPrice = basePrice;
    const validCoupons = {
        'PROMO25': 0.25,
        'AHORRA10': 0.1,
    };

    const bookingDetails = {
        subject: '',
        date: null,
        time: ''
    };

    // ===================================================================
    // CONTROL DE VISIBILIDAD DEL MODAL
    // ===================================================================
    let isModalOpen = false;

    function openModal() {
        if (!bookingModal || isModalOpen) return;
        isModalOpen = true;
        
        // Prevenir scroll del body
        document.body.style.overflow = 'hidden';
        
        // Mostrar modal sin animación primero
        bookingModal.classList.remove('booking-modal--hidden');
        
        // Forzar reflow para que la transición CSS funcione correctamente
        void bookingModal.offsetHeight;
        
        // Activar animación después de un frame
        requestAnimationFrame(() => {
            bookingModal.classList.add('booking-modal--active');
        });
    }

    function closeModal() {
        if (!bookingModal || !isModalOpen) return;
        
        // Iniciar animación de cierre
        bookingModal.classList.remove('booking-modal--active');
        
        // Restaurar scroll del body
        document.body.style.overflow = '';
        
        // Ocultar completamente y resetear después de la animación
        setTimeout(() => {
            bookingModal.classList.add('booking-modal--hidden');
            isModalOpen = false;
            resetModal();
        }, 300);
    }

    function resetModal() {
        currentStep = 1;
        updateStepUI();
        updateContent();
        updateNavButtons();
        loader.classList.add('booking-modal__state--hidden');
        confirmation.classList.add('booking-modal__state--hidden');
        navigationButtons.style.display = 'flex';
        
        bookingDetails.date = null;
        bookingDetails.time = '';
        
        const subjectSelect = document.getElementById('js-subject-select');
        if (subjectSelect) subjectSelect.selectedIndex = 0;
        
        document.querySelectorAll('.booking-calendar__day--selected').forEach(el => {
            el.classList.remove('booking-calendar__day--selected');
        });
        document.querySelectorAll('.booking-timeslot--selected').forEach(el => {
            el.classList.remove('booking-timeslot--selected');
        });

        if (couponInput) couponInput.value = '';
        if (couponMessage) {
            couponMessage.textContent = '';
            couponMessage.className = 'booking-summary__message';
        }
        currentPrice = basePrice;
        if (summaryTotal) summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
        
        paymentTabs.forEach(t => t.classList.remove('booking-payment__tab--active'));
        if (paymentTabs[0]) paymentTabs[0].classList.add('booking-payment__tab--active');
        paymentContents.forEach(c => c.classList.add('booking-payment__content--hidden'));
        if (paymentContents[0]) paymentContents[0].classList.remove('booking-payment__content--hidden');

        currentDate = new Date();
        renderCalendar();
        renderTimeSlots();
    }

    function showError(element) {
        if (!element) return;
        element.classList.add('booking-shake');
        const originalBorder = element.style.border;
        element.style.border = '2px solid #dc2626';
        setTimeout(() => {
            element.classList.remove('booking-shake');
            element.style.border = originalBorder;
        }, 600);
    }

    // ===================================================================
    // NAVEGACIÓN ENTRE PASOS (STEPPER)
    // ===================================================================
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentStep === 2) {
                if (!bookingDetails.date) {
                    showError(calendarContainer);
                    return;
                }
                if (!bookingDetails.time) {
                    showError(timeSlotsEl);
                    return;
                }
                updateSummary();
            }

            if (currentStep < totalSteps) {
                currentStep++;
                updateStepUI();
                updateContent();
                updateNavButtons();
            } else if (currentStep === totalSteps) {
                navigationButtons.style.display = 'none';
                loader.classList.remove('booking-modal__state--hidden');
                
                setTimeout(() => {
                    loader.classList.add('booking-modal__state--hidden');
                    confirmation.classList.remove('booking-modal__state--hidden');
                }, 2500);
            }
        });
    }

    if (backBtn) {
        backBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStepUI();
                updateContent();
                updateNavButtons();
            }
        });
    }

    function updateStepUI() {
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            if (stepNumber < currentStep) {
                step.classList.remove('booking-stepper__item--active');
                step.classList.add('booking-stepper__item--completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('booking-stepper__item--active');
                step.classList.remove('booking-stepper__item--completed');
            } else {
                step.classList.remove('booking-stepper__item--active', 'booking-stepper__item--completed');
            }
        });
        
        stepLines.forEach((line, index) => {
            if (index < currentStep - 1) {
                line.classList.add('booking-stepper__line--active');
            } else {
                line.classList.remove('booking-stepper__line--active');
            }
        });
    }

    function updateContent() {
        stepContents.forEach((content) => content.classList.add('booking-step--hidden'));
        const currentContent = document.querySelector(`.booking-step[data-content="${currentStep}"]`);
        if (currentContent) {
            currentContent.classList.remove('booking-step--hidden');
        }
    }

    function updateNavButtons() {
        if (backBtn) backBtn.disabled = currentStep === 1;
        if (nextBtn) {
            nextBtn.textContent = currentStep === totalSteps ? 'Finalizar Reserva' : 'Siguiente';
        }
    }
    
    function updateSummary() {
        const subjectSelect = document.getElementById('js-subject-select');
        bookingDetails.subject = subjectSelect ? subjectSelect.value : '';
        
        const summarySubject = document.getElementById('js-summary-subject');
        const summaryDate = document.getElementById('js-summary-date');
        const summaryTime = document.getElementById('js-summary-time');
        
        if (summarySubject) summarySubject.textContent = bookingDetails.subject;
        if (summaryDate && bookingDetails.date) {
            summaryDate.textContent = bookingDetails.date.toLocaleDateString('es-ES', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
        if (summaryTime) summaryTime.textContent = bookingDetails.time;
        if (summaryTotal) summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
    }

    // ===================================================================
    // LÓGICA DEL CUPÓN (PASO 3)
    // ===================================================================
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', () => {
            const code = couponInput.value.toUpperCase().trim();
            if (validCoupons[code]) {
                const discount = validCoupons[code];
                currentPrice = basePrice * (1 - discount);
                summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
                couponMessage.textContent = '¡Cupón aplicado correctamente! 🎉';
                couponMessage.className = 'booking-summary__message booking-summary__message--success';
            } else {
                currentPrice = basePrice;
                summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
                couponMessage.textContent = 'El cupón no es válido.';
                couponMessage.className = 'booking-summary__message booking-summary__message--error';
            }
        });
    }

    // ===================================================================
    // LÓGICA DEL CALENDARIO Y HORARIOS (PASO 2)
    // ===================================================================
    function renderCalendar() {
        if (!calendarDaysEl || !monthYearEl) return;
        
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const monthName = currentDate.toLocaleDateString('es-ES', { month: 'long' });
        monthYearEl.textContent = `${monthName.charAt(0).toUpperCase() + monthName.slice(1)} ${year}`;

        calendarDaysEl.innerHTML = '';
        const weekDays = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
        weekDays.forEach(day => {
            const dayEl = document.createElement('div');
            dayEl.className = 'booking-calendar__weekday';
            dayEl.textContent = day;
            calendarDaysEl.appendChild(dayEl);
        });

        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        const todayNoTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarDaysEl.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayDate = new Date(year, month, day);
            const dayEl = document.createElement('div');
            dayEl.className = 'booking-calendar__day';
            dayEl.textContent = day;
            dayEl.dataset.date = dayDate.toISOString().split('T')[0];
            
            const isPast = dayDate < todayNoTime;
            if (isPast) {
                dayEl.classList.add('booking-calendar__day--disabled');
            }
            
            if (bookingDetails.date && dayDate.getTime() === bookingDetails.date.getTime()) {
                dayEl.classList.add('booking-calendar__day--selected');
            }

            const hasAvailability = !isPast && Math.random() > 0.4;
            if (hasAvailability) {
                const dot = document.createElement('span');
                dot.className = 'booking-calendar__availability-dot';
                dayEl.appendChild(dot);
            }

            calendarDaysEl.appendChild(dayEl);
        }
    }

    if (calendarDaysEl) {
        calendarDaysEl.addEventListener('click', (e) => {
            const target = e.target.closest('.booking-calendar__day');
            if (target && !target.classList.contains('booking-calendar__day--disabled')) {
                document.querySelectorAll('.booking-calendar__day--selected').forEach(el => {
                    el.classList.remove('booking-calendar__day--selected');
                });
                target.classList.add('booking-calendar__day--selected');
                
                const dateParts = target.dataset.date.split('-').map(Number);
                bookingDetails.date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                
                bookingDetails.time = '';
                renderTimeSlots();
            }
        });
    }

    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', () => {
            const now = new Date();
            if (currentDate.getFullYear() > now.getFullYear() || 
                (currentDate.getFullYear() === now.getFullYear() && currentDate.getMonth() > now.getMonth())) {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            }
        });
    }

    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }

    function renderTimeSlots() {
        if (!timeSlotsEl) return;
        
        timeSlotsEl.innerHTML = '';
        if (!bookingDetails.date) {
            const placeholder = document.createElement('p');
            placeholder.textContent = 'Selecciona un día para ver los horarios disponibles.';
            placeholder.style.gridColumn = '1 / -1';
            placeholder.style.textAlign = 'center';
            placeholder.style.color = '#6b7280';
            timeSlotsEl.appendChild(placeholder);
            return;
        }

        for (let hour = 12; hour <= 20; hour++) {
            for (let minute = 0; minute < 60; minute += 20) {
                if (hour === 20 && minute > 40) break;
                
                const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                const timeSlot = document.createElement('div');
                timeSlot.className = 'booking-timeslot';
                timeSlot.textContent = time;
                
                if (bookingDetails.time === time) {
                    timeSlot.classList.add('booking-timeslot--selected');
                }
                
                timeSlotsEl.appendChild(timeSlot);
            }
        }
    }

    if (timeSlotsEl) {
        timeSlotsEl.addEventListener('click', (e) => {
            const target = e.target.closest('.booking-timeslot');
            if (target) {
                document.querySelectorAll('.booking-timeslot--selected').forEach(el => {
                    el.classList.remove('booking-timeslot--selected');
                });
                target.classList.add('booking-timeslot--selected');
                bookingDetails.time = target.textContent;
            }
        });
    }

    // ===================================================================
    // LÓGICA DE PESTAÑAS DE PAGO (PASO 3)
    // ===================================================================
    paymentTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            paymentTabs.forEach(t => t.classList.remove('booking-payment__tab--active'));
            tab.classList.add('booking-payment__tab--active');

            const targetId = tab.dataset.target;
            paymentContents.forEach(content => {
                content.classList.add('booking-payment__content--hidden');
            });
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.remove('booking-payment__content--hidden');
            }
        });
    });

    // ===================================================================
    // EVENT LISTENERS PARA CERRAR MODAL
    // ===================================================================
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (acceptBtn) {
        acceptBtn.addEventListener('click', closeModal);
    }

    if (bookingModal) {
        bookingModal.addEventListener('click', (e) => {
            if (e.target === bookingModal) {
                closeModal();
            }
        });
    }

    // ===================================================================
    // CONTROL DE INICIALIZACIÓN (evita doble ejecución)
    // ===================================================================
    let isInitialized = false;

    function initializeModal() {
        if (isInitialized) return;
        isInitialized = true;

        renderCalendar();
        renderTimeSlots();
        updateStepUI();
        updateNavButtons();

        // Conectar botón de apertura
        const openModalBtn = document.getElementById('open-modal-reservar');
        if (openModalBtn && !openModalBtn.dataset.bookingModalAttached) {
            openModalBtn.dataset.bookingModalAttached = 'true';
            openModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openModal();
            }, { once: false });
        }
    }

    // ===================================================================
    // API PÚBLICA
    // ===================================================================
    window.ClassGoBookingModal = {
        open: openModal,
        close: closeModal
    };

    // ===================================================================
    // INICIALIZACIÓN
    // ===================================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeModal);
    } else {
        initializeModal();
    }
})();
</script>
