<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal de Reserva de Clases</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Estilos para el scrollbar en webkit */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <!-- Botón para abrir el modal -->
    <button id="openModalBtn" class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 transition-all duration-300">
        Reservar una Clase
    </button>

    <!-- Contenedor del Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        
        <!-- Contenido del Modal -->
        <div id="modalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all duration-300 scale-95 opacity-0">
            <div class="p-6 sm:p-8 relative">
                <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Proceso de Reserva</h2>

                <!-- Stepper -->
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center w-full max-w-md">
                        <div id="step-1" class="step active flex-1 text-center">
                            <div class="step-icon mx-auto bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">1</div>
                            <p class="text-sm mt-2 text-gray-600">Materia</p>
                        </div>
                        <div class="flex-1 border-t-2 border-gray-200 transition-all duration-500 step-line"></div>
                        <div id="step-2" class="step flex-1 text-center">
                            <div class="step-icon mx-auto bg-gray-200 text-gray-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">2</div>
                            <p class="text-sm mt-2 text-gray-500">Horario</p>
                        </div>
                        <div class="flex-1 border-t-2 border-gray-200 transition-all duration-500 step-line"></div>
                        <div id="step-3" class="step flex-1 text-center">
                            <div class="step-icon mx-auto bg-gray-200 text-gray-500 w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">3</div>
                            <p class="text-sm mt-2 text-gray-500">Pago</p>
                        </div>
                    </div>
                </div>

                <!-- Contenido de los Pasos -->
                <div class="min-h-[400px]">
                    <!-- Paso 1: Selección de Materia -->
                    <div id="content-step-1" class="step-content">
                        <div class="max-w-md mx-auto">
                           <h3 class="text-xl font-semibold text-gray-700 mb-2 text-center">Selecciona una materia</h3>
                           <p class="text-gray-500 mb-6 text-center">¿Qué te gustaría aprender o reforzar hoy?</p>
                           <div class="space-y-4">
                               <label for="subject" class="block text-sm font-medium text-gray-700">Materia</label>
                               <select id="subject" name="subject" class="mt-1 block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                                   <option>Matemáticas Avanzadas</option>
                                   <option>Física Cuántica</option>
                                   <option>Química Orgánica</option>
                                   <option>Programación en Python</option>
                                   <option>Historia del Arte</option>
                               </select>
                           </div>
                        </div>
                    </div>

                    <!-- Paso 2: Selección de Fecha y Hora -->
                    <div id="content-step-2" class="step-content hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Calendario -->
                            <div class="w-full">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Selecciona un día</h3>
                                <div id="calendar-container" class="bg-white rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <button id="prev-month" class="p-2 rounded-full hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                        <h4 id="month-year" class="font-semibold text-gray-800"></h4>
                                        <button id="next-month" class="p-2 rounded-full hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                    </div>
                                    <div id="calendar-days" class="grid grid-cols-7 gap-2 text-center"></div>
                                </div>
                            </div>
                            <!-- Horarios -->
                            <div class="w-full">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Selecciona una hora</h3>
                                <div id="time-slots-container" class="max-h-80 overflow-y-auto custom-scrollbar pr-2 grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <!-- Horarios se generan dinámicamente -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Pago -->
                    <div id="content-step-3" class="step-content hidden">
                         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="lg:order-2">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Resumen de la Reserva</h3>
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                    <div class="space-y-3 text-gray-600">
                                        <div class="flex justify-between">
                                            <span class="font-medium">Materia:</span>
                                            <span id="summary-subject" class="font-semibold text-gray-800"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Fecha:</span>
                                            <span id="summary-date" class="font-semibold text-gray-800"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Hora:</span>
                                            <span id="summary-time" class="font-semibold text-gray-800"></span>
                                        </div>
                                    </div>
                                    <div class="border-t"></div>
                                    <div>
                                        <label for="coupon-input" class="block text-sm font-medium text-gray-700 mb-1">¿Tienes un cupón?</label>
                                        <div class="flex items-center gap-2">
                                            <input id="coupon-input" type="text" placeholder="Ej. PROMO25" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <button id="apply-coupon-btn" class="bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-md hover:bg-gray-300">Aplicar</button>
                                        </div>
                                        <p id="coupon-message" class="text-sm mt-2 h-5"></p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante de pago</label>
                                        <label for="file-upload" class="cursor-pointer mt-2 flex justify-center items-center w-full px-6 py-4 border-2 border-gray-300 border-dashed rounded-md">
                                            <div class="text-center">
                                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mt-1 text-sm text-gray-600">Subir archivo</p>
                                            </div>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                    </div>
                                    <div class="border-t"></div>
                                     <div class="flex justify-between items-center text-xl font-bold text-gray-800">
                                        <span>Total a pagar:</span>
                                        <span id="summary-total">$50.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:order-1">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Método de Pago</h3>
                                <div>
                                    <div class="flex border-b">
                                        <button class="payment-tab active-tab flex-1 py-2 text-center font-medium text-blue-600 border-b-2 border-blue-600" data-target="qr-payment">QR</button>
                                        <button class="payment-tab flex-1 py-2 text-center font-medium text-gray-500" data-target="transfer-payment">Transferencia</button>
                                    </div>
                                    <div id="qr-payment" class="payment-content mt-6 text-center">
                                        <p class="text-gray-600 mb-4">Escanea el código para pagar</p>
                                        <img src="https://placehold.co/200x200/ffffff/000000?text=QR+Code" alt="Código QR de pago" class="mx-auto rounded-lg shadow-md">
                                        <p class="text-xs text-gray-400 mt-2">Válido hasta: 14 de mayo de 2026</p>
                                    </div>
                                    <div id="transfer-payment" class="payment-content hidden mt-6">
                                        <p class="text-gray-600 mb-4">Realiza la transferencia a la siguiente cuenta:</p>
                                        <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                                            <p><span class="font-semibold">Banco:</span> Banco Nacional de Bolivia</p>
                                            <p><span class="font-semibold">N° de Cuenta:</span> 2502661143</p>
                                            <p><span class="font-semibold">Titular:</span> Jane Doe</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loader -->
                    <div id="loader" class="hidden absolute inset-0 bg-white bg-opacity-80 flex flex-col items-center justify-center space-y-4">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-gray-600 font-medium">Procesando tu reserva...</p>
                    </div>

                    <!-- Confirmación -->
                    <div id="confirmation" class="hidden absolute inset-0 bg-white flex flex-col items-center justify-center text-center p-8">
                         <div class="bg-green-100 rounded-full p-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                         </div>
                         <h3 class="text-2xl font-bold text-gray-800 mt-6">¡Reservado correctamente!</h3>
                         <p class="text-gray-600 mt-2 max-w-sm">Tu reserva está en proceso de revisión. Recibirás una confirmación por correo electrónico pronto.</p>
                         <button id="acceptBtn" class="mt-8 bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-700 transition-all">
                             Aceptar
                         </button>
                    </div>

                </div>

                <!-- Botones de Navegación -->
                <div id="navigation-buttons" class="flex justify-between pt-6 border-t mt-8">
                    <button id="backBtn" class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Atrás
                    </button>
                    <button id="nextBtn" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-all">
                        Siguiente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elementos del DOM
            const openModalBtn = document.getElementById('openModalBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const bookingModal = document.getElementById('bookingModal');
            const modalContent = document.getElementById('modalContent');
            const backBtn = document.getElementById('backBtn');
            const nextBtn = document.getElementById('nextBtn');
            const acceptBtn = document.getElementById('acceptBtn');
            const steps = document.querySelectorAll('.step');
            const stepContents = document.querySelectorAll('.step-content');
            const stepLines = document.querySelectorAll('.step-line');
            const navigationButtons = document.getElementById('navigation-buttons');
            const couponInput = document.getElementById('coupon-input');
            const applyCouponBtn = document.getElementById('apply-coupon-btn');
            const couponMessage = document.getElementById('coupon-message');
            const summaryTotal = document.getElementById('summary-total');

            // Estado del modal
            let currentStep = 1;
            const totalSteps = 3;
            
            // Lógica de precios y cupones
            const basePrice = 50.00;
            let currentPrice = basePrice;
            const validCoupons = {
                'PROMO25': 0.25, // 25% de descuento
                'AHORRA10': 0.1, // 10% de descuento
            };

            // Estado de la reserva
            const bookingDetails = {
                subject: '',
                date: null,
                time: ''
            };

            // --- Control del Modal ---
            const openModal = () => {
                bookingModal.classList.remove('hidden');
                bookingModal.classList.add('flex');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 50);
            };

            const closeModal = () => {
                modalContent.classList.add('scale-95', 'opacity-0');
                modalContent.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    bookingModal.classList.add('hidden');
                    bookingModal.classList.remove('flex');
                    resetModal();
                }, 300);
            };

            openModalBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            acceptBtn.addEventListener('click', closeModal);
            bookingModal.addEventListener('click', (e) => {
                if (e.target === bookingModal) {
                    closeModal();
                }
            });
            
            const resetModal = () => {
                currentStep = 1;
                updateStepUI();
                updateContent();
                updateNavButtons();
                document.getElementById('loader').classList.add('hidden');
                document.getElementById('confirmation').classList.add('hidden');
                navigationButtons.classList.remove('hidden');
                // Limpiar selecciones
                bookingDetails.date = null;
                bookingDetails.time = '';
                const selectedDateEl = document.querySelector('.calendar-day.selected');
                if(selectedDateEl) selectedDateEl.classList.remove('selected', 'bg-blue-600', 'text-white');
                const selectedTimeEl = document.querySelector('.time-slot.selected');
                if(selectedTimeEl) selectedTimeEl.classList.remove('selected', 'bg-blue-600', 'text-white');
                // Limpiar cupón
                couponInput.value = '';
                couponMessage.textContent = '';
                currentPrice = basePrice;
                summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
            }
            
            // Función para mostrar un error visual
            const showError = (element) => {
                element.classList.add('shake');
                element.style.border = '1px solid red';
                setTimeout(() => {
                    element.classList.remove('shake');
                    element.style.border = '';
                }, 600);
            };

            // --- Navegación entre pasos ---
            nextBtn.addEventListener('click', () => {
                if(currentStep === 2) {
                    if (!bookingDetails.date) {
                         showError(document.getElementById('calendar-container'));
                         return;
                    }
                    if (!bookingDetails.time) {
                        showError(document.getElementById('time-slots-container'));
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
                    // Lógica de finalización
                    navigationButtons.classList.add('hidden');
                    const loader = document.getElementById('loader');
                    loader.classList.remove('hidden');
                    
                    setTimeout(() => {
                        loader.classList.add('hidden');
                        document.getElementById('confirmation').classList.remove('hidden');
                    }, 2500); // Simula una llamada a la API
                }
            });

            backBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepUI();
                    updateContent();
                    updateNavButtons();
                }
            });

            const updateStepUI = () => {
                steps.forEach((step, index) => {
                    const stepIcon = step.querySelector('.step-icon');
                    const stepText = step.querySelector('p');
                    const stepNumber = index + 1;

                    if (stepNumber < currentStep) {
                        stepIcon.classList.add('bg-blue-600', 'text-white');
                        stepIcon.classList.remove('bg-gray-200', 'text-gray-500');
                        stepText.classList.remove('text-gray-500');
                        stepText.classList.add('text-gray-600');
                    } else if (stepNumber === currentStep) {
                        stepIcon.classList.add('bg-blue-600', 'text-white');
                        stepIcon.classList.remove('bg-gray-200', 'text-gray-500');
                        stepText.classList.remove('text-gray-500');
                        stepText.classList.add('text-gray-600');
                    } else {
                        stepIcon.classList.remove('bg-blue-600', 'text-white');
                        stepIcon.classList.add('bg-gray-200', 'text-gray-500');
                        stepText.classList.add('text-gray-500');
                        stepText.classList.remove('text-gray-600');
                    }
                });
                
                stepLines.forEach((line, index) => {
                    if (index < currentStep - 1) {
                        line.classList.add('border-blue-600');
                        line.classList.remove('border-gray-200');
                    } else {
                        line.classList.remove('border-blue-600');
                        line.classList.add('border-gray-200');
                    }
                });
            };

            const updateContent = () => {
                stepContents.forEach((content) => content.classList.add('hidden'));
                document.getElementById(`content-step-${currentStep}`).classList.remove('hidden');
            };

            const updateNavButtons = () => {
                backBtn.disabled = currentStep === 1;
                if (currentStep === totalSteps) {
                    nextBtn.textContent = 'Finalizar Reserva';
                } else {
                    nextBtn.textContent = 'Siguiente';
                }
            };
            
            const updateSummary = () => {
                 document.getElementById('summary-subject').textContent = document.getElementById('subject').value;
                 document.getElementById('summary-date').textContent = bookingDetails.date.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });
                 document.getElementById('summary-time').textContent = bookingDetails.time;
                 summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
            };

            // --- Lógica del Cupón (Paso 3) ---
            applyCouponBtn.addEventListener('click', () => {
                const code = couponInput.value.toUpperCase();
                if (validCoupons[code]) {
                    const discount = validCoupons[code];
                    currentPrice = basePrice * (1 - discount);
                    summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
                    couponMessage.textContent = '¡Cupón aplicado correctamente!';
                    couponMessage.className = 'text-sm mt-2 h-5 text-green-600';
                } else {
                    currentPrice = basePrice;
                    summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
                    couponMessage.textContent = 'El cupón no es válido.';
                    couponMessage.className = 'text-sm mt-2 h-5 text-red-600';
                }
            });


            // --- Lógica del Calendario y Horarios (Paso 2) ---
            const monthYearEl = document.getElementById('month-year');
            const calendarDaysEl = document.getElementById('calendar-days');
            const timeSlotsEl = document.getElementById('time-slots-container');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            
            let currentDate = new Date();

            const renderCalendar = () => {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                monthYearEl.textContent = `${currentDate.toLocaleDateString('es-ES', { month: 'long' })} ${year}`;

                calendarDaysEl.innerHTML = '';
                const weekDays = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
                weekDays.forEach(day => {
                    calendarDaysEl.innerHTML += `<div class="font-semibold text-gray-500 text-sm">${day}</div>`;
                });

                const firstDayOfMonth = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const today = new Date();

                for (let i = 0; i < firstDayOfMonth; i++) {
                    calendarDaysEl.innerHTML += `<div></div>`;
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDate = new Date(year, month, day);
                    let classes = 'calendar-day cursor-pointer p-2 rounded-full hover:bg-blue-100 transition-colors relative';
                    
                    const isPast = dayDate < new Date(today.getFullYear(), today.getMonth(), today.getDate());

                    if (isPast) {
                        classes += ' text-gray-300 cursor-not-allowed';
                    }
                    
                    if (bookingDetails.date && dayDate.getTime() === bookingDetails.date.getTime()) {
                        classes += ' selected bg-blue-600 text-white';
                    }

                    let dayHtml = `<div class="${classes}" data-date="${dayDate.toISOString()}">
                        ${day}
                        ${!isPast && Math.random() > 0.5 ? '<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-orange-400 rounded-full"></span>' : ''}
                    </div>`;
                    calendarDaysEl.innerHTML += dayHtml;
                }
            };

            calendarDaysEl.addEventListener('click', (e) => {
                const target = e.target.closest('.calendar-day');
                if (target && !target.classList.contains('cursor-not-allowed')) {
                    document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));
                    target.classList.add('selected', 'bg-blue-600', 'text-white');
                    bookingDetails.date = new Date(target.dataset.date);
                    renderTimeSlots();
                }
            });

            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            const renderTimeSlots = () => {
                timeSlotsEl.innerHTML = '';
                for (let hour = 12; hour <= 20; hour++) {
                    for (let minute = 0; minute < 60; minute += 20) {
                        const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                        let classes = 'time-slot cursor-pointer p-2 border rounded-md text-center hover:bg-blue-100 transition-colors';
                        if (bookingDetails.time === time) {
                           classes += ' selected bg-blue-600 text-white';
                        }
                        timeSlotsEl.innerHTML += `<div class="${classes}">${time}</div>`;
                    }
                }
            };

            timeSlotsEl.addEventListener('click', (e) => {
                const target = e.target.closest('.time-slot');
                if (target) {
                    document.querySelectorAll('.time-slot.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));
                    target.classList.add('selected', 'bg-blue-600', 'text-white');
                    bookingDetails.time = target.textContent;
                }
            });


            // --- Lógica de Pestañas de Pago (Paso 3) ---
            const paymentTabs = document.querySelectorAll('.payment-tab');
            const paymentContents = document.querySelectorAll('.payment-content');

            paymentTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    paymentTabs.forEach(t => {
                        t.classList.remove('active-tab', 'text-blue-600', 'border-blue-600');
                        t.classList.add('text-gray-500');
                    });
                    tab.classList.add('active-tab', 'text-blue-600', 'border-blue-600');
                    tab.classList.remove('text-gray-500');

                    const targetId = tab.dataset.target;
                    paymentContents.forEach(content => {
                        if (content.id === targetId) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });

            // Inicialización
            renderCalendar();
            renderTimeSlots();
            updateStepUI();
        });
    </script>
</body>
</html>

