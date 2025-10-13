<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal de Reserva de Clases</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> </head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <style> 
        /* styles.css */

/* Fuentes */
body {
    font-family: 'Inter', sans-serif;
}

/* --- Modal y Responsividad --- */

/* Clase base para ocultar elementos de contenido */
.is-hidden {
    display: none !important;
}

/* Estilo inicial del Modal Overlay */
.c-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Fondo desactivado */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
    padding: 1rem; /* Padding para evitar desborde en móviles */
}

/* Contenido del Modal (max-width y centrado con overflow) */
.c-modal__content {
    background-color: #fff;
    border-radius: 1rem; /* rounded-2xl */
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
    width: 100%;
    max-width: 48rem; /* max-w-3xl, 768px */
    max-height: 95vh; /* Evita desborde vertical en pantallas pequeñas */
    overflow-y: auto; /* Scroll dentro del contenido si es necesario */
    transform: scale(0.95);
    opacity: 0;
    transition: all 300ms ease-in-out;
}

/* Modificadores para la transición de apertura */
.c-modal.is-active .c-modal__content {
    transform: scale(1);
    opacity: 1;
}

/* Estados del Modal (Loader y Confirmación) */
.c-modal__state {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    z-index: 10;
    padding: 2rem;
    border-radius: 1rem;
}

/* Botón de cierre */
.c-modal__close-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #9ca3af; /* text-gray-400 */
    transition: color 150ms;
}
.c-modal__close-btn:hover {
    color: #4b5563; /* hover:text-gray-600 */
}

/* --- Stepper (Navegación por Pasos) --- */

.c-stepper__wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 480px; /* max-w-md */
    margin: 0 auto;
}

.c-stepper__step {
    flex: 1 1 0%;
    text-align: center;
}

.c-stepper__icon {
    margin: 0 auto;
    width: 2.5rem; /* w-10 */
    height: 2.5rem; /* h-10 */
    border-radius: 9999px; /* rounded-full */
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700; /* font-bold */
    font-size: 1.125rem; /* text-lg */
    background-color: #e5e7eb; /* bg-gray-200 */
    color: #6b7280; /* text-gray-500 */
    transition: all 300ms ease-in-out;
}

.c-stepper__step.is-active .c-stepper__icon {
    background-color: #2563eb; /* bg-blue-600 */
    color: #fff;
}
.c-stepper__step.is-completed .c-stepper__icon {
    background-color: #2563eb; /* bg-blue-600 */
    color: #fff;
}

.c-stepper__text {
    margin-top: 0.5rem;
    font-size: 0.875rem; /* text-sm */
    color: #6b7280; /* text-gray-500 */
}
.c-stepper__step.is-active .c-stepper__text,
.c-stepper__step.is-completed .c-stepper__text {
    color: #4b5563; /* text-gray-600 */
}


.c-stepper__line {
    flex: 1 1 0%;
    border-top: 2px solid #e5e7eb; /* border-gray-200 */
    transition: border-color 500ms ease-in-out;
}
.c-stepper__line.is-active {
    border-color: #2563eb; /* border-blue-600 */
}

.c-step-container {
    min-height: 400px;
    position: relative;
}
.c-step-content {
    transition: opacity 300ms ease-in-out;
}

/* --- Formularios y Botones --- */

.c-button {
    font-weight: 600;
    padding: 0.5rem 1.5rem; /* py-2 px-6 */
    border-radius: 0.5rem;
    transition: all 300ms;
}

.c-button--primary {
    background-color: #2563eb; /* bg-blue-600 */
    color: #fff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
}
.c-button--primary:hover {
    background-color: #1d4ed8; /* hover:bg-blue-700 */
}

.c-button--secondary {
    background-color: #e5e7eb; /* bg-gray-200 */
    color: #4b5563; /* text-gray-700 */
}
.c-button--secondary:hover {
    background-color: #d1d5db; /* hover:bg-gray-300 */
}

.c-button--tertiary {
    background-color: #e5e7eb; /* bg-gray-200 */
    color: #4b5563; /* text-gray-700 */
}
.c-button--tertiary:hover {
    background-color: #d1d5db; /* hover:bg-gray-300 */
}
.c-button--tertiary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.c-form-select, .c-form-input {
    width: 100%;
    padding: 0.75rem 0.75rem; /* py-3 pl-3 */
    font-size: 1rem;
    border: 1px solid #d1d5db; /* border-gray-300 */
    border-radius: 0.375rem; /* rounded-md */
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
    outline: none;
    transition: border-color 150ms, box-shadow 150ms;
}
.c-form-select:focus, .c-form-input:focus {
    border-color: #3b82f6; /* focus:border-blue-500 */
    box-shadow: 0 0 0 1px #3b82f6; /* focus:ring-blue-500 */
}

.c-file-upload {
    cursor: pointer;
    margin-top: 0.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 1rem 1.5rem; /* py-4 px-6 */
    border: 2px dashed #d1d5db; /* border-gray-300 */
    border-radius: 0.375rem; /* rounded-md */
    transition: border-color 150ms;
}
.c-file-upload:hover {
    border-color: #9ca3af; /* Más oscuro al pasar el ratón */
}

/* --- Calendario y Horarios --- */

.c-calendar__days-grid {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 0.5rem;
    text-align: center;
}

.calendar-day {
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 9999px;
    transition: background-color 150ms, color 150ms;
    position: relative;
    user-select: none;
}
.calendar-day:not(.cursor-not-allowed):hover {
    background-color: #ebf8ff; /* hover:bg-blue-100 */
}
.calendar-day.selected {
    background-color: #2563eb;
    color: #fff;
}

.c-time-slots-grid {
    max-height: 20rem; /* max-h-80 */
    overflow-y: auto;
    padding-right: 0.5rem; /* pr-2 */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr)); /* Adaptativo */
    gap: 0.75rem; /* gap-3 */
}

@media (min-width: 640px) { /* sm: */
    .c-time-slots-grid {
         grid-template-columns: repeat(3, minmax(0, 1fr)); /* sm:grid-cols-3 */
    }
}

.time-slot {
    cursor: pointer;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    text-align: center;
    transition: background-color 150ms, color 150ms, border-color 150ms;
    user-select: none;
}
.time-slot:hover {
    background-color: #ebf8ff; /* hover:bg-blue-100 */
    border-color: #93c5fd; /* light blue border */
}
.time-slot.selected {
    background-color: #2563eb;
    color: #fff;
    border-color: #2563eb;
}

/* --- Pestañas de Pago --- */

.c-payment__tabs {
    display: flex;
    border-bottom: 1px solid #e5e7eb;
}

.c-payment__tab {
    flex: 1 1 0%;
    padding: 0.5rem 0; /* py-2 */
    text-align: center;
    font-weight: 500;
    color: #6b7280; /* text-gray-500 */
    border-bottom: 2px solid transparent;
    transition: color 150ms, border-bottom-color 150ms;
}
.c-payment__tab:hover {
    color: #2563eb;
}
.c-payment__tab.is-active {
    color: #2563eb; /* text-blue-600 */
    border-bottom-color: #2563eb; /* border-blue-600 */
}
.c-payment__content.is-hidden {
    display: none !important;
}

/* --- Scrollbar Personalizado (Webkit) --- */

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

/* --- Animación de Error --- */

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}
.shake {
    animation: shake 0.5s ease-in-out;
}
    </style>

    <button id="js-open-modal-btn" class="c-button c-button--primary">
        Reservar una Clase
    </button>

    <div id="js-booking-modal" class="c-modal is-hidden">
        
        <div id="js-modal-content" class="c-modal__content">
            <div class="p-6 sm:p-8 relative">
                <button id="js-close-modal-btn" class="c-modal__close-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Proceso de Reserva</h2>

                <div class="c-stepper mb-8">
                    <div class="c-stepper__wrapper">
                        <div id="step-1" class="c-stepper__step is-active" data-step="1">
                            <div class="c-stepper__icon">1</div>
                            <p class="c-stepper__text">Materia</p>
                        </div>
                        <div class="c-stepper__line"></div>
                        <div id="step-2" class="c-stepper__step" data-step="2">
                            <div class="c-stepper__icon">2</div>
                            <p class="c-stepper__text">Horario</p>
                        </div>
                        <div class="c-stepper__line"></div>
                        <div id="step-3" class="c-stepper__step" data-step="3">
                            <div class="c-stepper__icon">3</div>
                            <p class="c-stepper__text">Pago</p>
                        </div>
                    </div>
                </div>

                <div class="c-step-container">
                    <div id="content-step-1" class="c-step-content" data-content="1">
                        <div class="max-w-md mx-auto">
                           <h3 class="text-xl font-semibold text-gray-700 mb-2 text-center">Selecciona una materia</h3>
                           <p class="text-gray-500 mb-6 text-center">¿Qué te gustaría aprender o reforzar hoy?</p>
                           <div class="space-y-4">
                               <label for="subject" class="block text-sm font-medium text-gray-700">Materia</label>
                               <select id="js-subject-select" name="subject" class="c-form-select">
                                   <option>Matemáticas Avanzadas</option>
                                   <option>Física Cuántica</option>
                                   <option>Química Orgánica</option>
                                   <option>Programación en Python</option>
                                   <option>Historia del Arte</option>
                               </select>
                           </div>
                        </div>
                    </div>

                    <div id="content-step-2" class="c-step-content is-hidden" data-content="2">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="w-full">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Selecciona un día</h3>
                                <div id="js-calendar-container" class="bg-white rounded-lg p-4 c-calendar">
                                    <div class="flex justify-between items-center mb-4">
                                        <button id="js-prev-month-btn" class="p-2 rounded-full hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                        <h4 id="js-month-year" class="font-semibold text-gray-800"></h4>
                                        <button id="js-next-month-btn" class="p-2 rounded-full hover:bg-gray-100"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                                    </div>
                                    <div id="js-calendar-days" class="c-calendar__days-grid"></div>
                                </div>
                            </div>
                            <div class="w-full">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Selecciona una hora</h3>
                                <div id="js-time-slots-container" class="c-time-slots-grid custom-scrollbar">
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div id="content-step-3" class="c-step-content is-hidden" data-content="3">
                         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="lg:order-2">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Resumen de la Reserva</h3>
                                <div class="bg-gray-50 rounded-lg p-6 space-y-4 c-summary">
                                    <div class="space-y-3 text-gray-600">
                                        <div class="flex justify-between">
                                            <span class="font-medium">Materia:</span>
                                            <span id="js-summary-subject" class="font-semibold text-gray-800"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Fecha:</span>
                                            <span id="js-summary-date" class="font-semibold text-gray-800"></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium">Hora:</span>
                                            <span id="js-summary-time" class="font-semibold text-gray-800"></span>
                                        </div>
                                    </div>
                                    <div class="border-t"></div>
                                    <div>
                                        <label for="coupon-input" class="block text-sm font-medium text-gray-700 mb-1">¿Tienes un cupón?</label>
                                        <div class="flex items-center gap-2">
                                            <input id="js-coupon-input" type="text" placeholder="Ej. PROMO25" class="c-form-input">
                                            <button id="js-apply-coupon-btn" class="c-button c-button--secondary">Aplicar</button>
                                        </div>
                                        <p id="js-coupon-message" class="text-sm mt-2 h-5"></p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante de pago</label>
                                        <label for="js-file-upload" class="c-file-upload">
                                            <div class="text-center">
                                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mt-1 text-sm text-gray-600">Subir archivo</p>
                                            </div>
                                            <input id="js-file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                    </div>
                                    <div class="border-t"></div>
                                     <div class="flex justify-between items-center text-xl font-bold text-gray-800">
                                        <span>Total a pagar:</span>
                                        <span id="js-summary-total">$50.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:order-1">
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">Método de Pago</h3>
                                <div class="c-payment">
                                    <div class="c-payment__tabs">
                                        <button class="c-payment__tab is-active" data-target="qr-payment">QR</button>
                                        <button class="c-payment__tab" data-target="transfer-payment">Transferencia</button>
                                    </div>
                                    <div id="qr-payment" class="c-payment__content mt-6 text-center">
                                        <p class="text-gray-600 mb-4">Escanea el código para pagar</p>
                                        <img src="https://placehold.co/200x200/ffffff/000000?text=QR+Code" alt="Código QR de pago" class="mx-auto rounded-lg shadow-md">
                                        <p class="text-xs text-gray-400 mt-2">Válido hasta: 14 de mayo de 2026</p>
                                    </div>
                                    <div id="transfer-payment" class="c-payment__content is-hidden mt-6">
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

                    <div id="js-loader" class="c-modal__state c-modal__state--loader is-hidden">
                        <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-gray-600 font-medium">Procesando tu reserva...</p>
                    </div>

                    <div id="js-confirmation" class="c-modal__state c-modal__state--confirmation is-hidden">
                         <div class="bg-green-100 rounded-full p-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                         </div>
                         <h3 class="text-2xl font-bold text-gray-800 mt-6">¡Reservado correctamente!</h3>
                         <p class="text-gray-600 mt-2 max-w-sm">Tu reserva está en proceso de revisión. Recibirás una confirmación por correo electrónico pronto.</p>
                         <button id="js-accept-btn" class="c-button c-button--primary mt-8">
                             Aceptar
                         </button>
                    </div>

                </div>

                <div id="js-navigation-buttons" class="flex justify-between pt-6 border-t mt-8">
                    <button id="js-back-btn" class="c-button c-button--tertiary" disabled>
                        Atrás
                    </button>
                    <button id="js-next-btn" class="c-button c-button--primary">
                        Siguiente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // script.js

document.addEventListener('DOMContentLoaded', function () {
    // 1. Elementos del DOM con prefijo 'js-' para identificarlos
    const openModalBtn = document.getElementById('js-open-modal-btn');
    const closeModalBtn = document.getElementById('js-close-modal-btn');
    const bookingModal = document.getElementById('js-booking-modal');
    const modalContent = document.getElementById('js-modal-content');
    const backBtn = document.getElementById('js-back-btn');
    const nextBtn = document.getElementById('js-next-btn');
    const acceptBtn = document.getElementById('js-accept-btn');
    const steps = document.querySelectorAll('.c-stepper__step');
    const stepContents = document.querySelectorAll('.c-step-content');
    const stepLines = document.querySelectorAll('.c-stepper__line');
    const navigationButtons = document.getElementById('js-navigation-buttons');
    const loader = document.getElementById('js-loader');
    const confirmation = document.getElementById('js-confirmation');

    // Elementos del Paso 3 (Pago)
    const couponInput = document.getElementById('js-coupon-input');
    const applyCouponBtn = document.getElementById('js-apply-coupon-btn');
    const couponMessage = document.getElementById('js-coupon-message');
    const summaryTotal = document.getElementById('js-summary-total');
    const paymentTabs = document.querySelectorAll('.c-payment__tab');
    const paymentContents = document.querySelectorAll('.c-payment__content');

    // Elementos del Paso 2 (Horario)
    const monthYearEl = document.getElementById('js-month-year');
    const calendarDaysEl = document.getElementById('js-calendar-days');
    const timeSlotsEl = document.getElementById('js-time-slots-container');
    const prevMonthBtn = document.getElementById('js-prev-month-btn');
    const nextMonthBtn = document.getElementById('js-next-month-btn');
    const calendarContainer = document.getElementById('js-calendar-container');

    // 2. Estado del modal y datos
    let currentStep = 1;
    const totalSteps = 3;
    let currentDate = new Date(); // Para el calendario
    
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

    // --- Control de Visibilidad del Modal ---
    const openModal = () => {
        // Desactiva el scroll del body y añade la clase 'is-active' para la transición
        document.body.style.overflow = 'hidden';
        bookingModal.classList.remove('is-hidden');
        // Usamos un pequeño timeout para asegurar que la clase 'is-active' active la transición CSS
        setTimeout(() => {
            bookingModal.classList.add('is-active');
        }, 50);
    };

    const closeModal = () => {
        bookingModal.classList.remove('is-active');
        // Restaura el scroll del body
        document.body.style.overflow = '';
        setTimeout(() => {
            bookingModal.classList.add('is-hidden');
            resetModal();
        }, 300); // 300ms es la duración de la transición CSS
    };

    openModalBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);
    acceptBtn.addEventListener('click', closeModal);
    // Cierre al hacer clic en el fondo (overlay)
    bookingModal.addEventListener('click', (e) => {
        // Solo cierra si el clic fue directamente en el contenedor del modal (el fondo)
        if (e.target === bookingModal) {
            closeModal();
        }
    });

    const resetModal = () => {
        currentStep = 1;
        updateStepUI();
        updateContent();
        updateNavButtons();
        loader.classList.add('is-hidden');
        confirmation.classList.add('is-hidden');
        navigationButtons.classList.remove('is-hidden');
        
        // Limpiar selecciones de reserva y UI
        bookingDetails.date = null;
        bookingDetails.time = '';
        document.getElementById('js-subject-select').value = document.getElementById('js-subject-select').options[0].value;
        document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));
        document.querySelectorAll('.time-slot.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));

        // Limpiar cupón
        couponInput.value = '';
        couponMessage.textContent = '';
        couponMessage.className = 'text-sm mt-2 h-5';
        currentPrice = basePrice;
        summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
        
        // Reiniciar pestañas de pago
        paymentTabs.forEach(t => t.classList.remove('is-active', 'text-blue-600', 'border-blue-600'));
        paymentTabs[0].classList.add('is-active', 'text-blue-600', 'border-blue-600');
        paymentContents.forEach(c => c.classList.add('is-hidden'));
        paymentContents[0].classList.remove('is-hidden');

        // Reiniciar calendario al mes actual
        currentDate = new Date();
        renderCalendar();
    }
    
    // Función para mostrar un error visual
    const showError = (element) => {
        element.classList.add('shake');
        element.style.border = '1px solid red'; // Estilo de borde temporal
        setTimeout(() => {
            element.classList.remove('shake');
            element.style.border = '';
        }, 600);
    };

    // --- Navegación entre pasos (Stepper) ---
    nextBtn.addEventListener('click', () => {
        // Validaciones antes de avanzar
        if(currentStep === 2) {
            if (!bookingDetails.date) {
                 showError(calendarContainer);
                 return;
            }
            if (!bookingDetails.time) {
                showError(timeSlotsEl);
                return;
            }
            // Si la validación pasa, actualiza el resumen para el paso 3
            updateSummary();
        }

        if (currentStep < totalSteps) {
            currentStep++;
            updateStepUI();
            updateContent();
            updateNavButtons();
        } else if (currentStep === totalSteps) {
            // Lógica de finalización (Simulación de API)
            navigationButtons.classList.add('is-hidden');
            loader.classList.remove('is-hidden');
            
            setTimeout(() => {
                loader.classList.add('is-hidden');
                confirmation.classList.remove('is-hidden');
            }, 2500);
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
            const stepNumber = index + 1;
            // Usa clases CSS para el estado
            if (stepNumber < currentStep) {
                step.classList.remove('is-active');
                step.classList.add('is-completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('is-active');
                step.classList.remove('is-completed');
            } else {
                step.classList.remove('is-active', 'is-completed');
            }
        });
        
        stepLines.forEach((line, index) => {
            if (index < currentStep - 1) {
                line.classList.add('is-active'); // is-active corresponde a border-blue-600 en CSS
            } else {
                line.classList.remove('is-active');
            }
        });
    };

    const updateContent = () => {
        stepContents.forEach((content) => content.classList.add('is-hidden'));
        // Muestra el contenido del paso actual
        const currentContent = document.querySelector(`.c-step-content[data-content="${currentStep}"]`);
        if (currentContent) {
            currentContent.classList.remove('is-hidden');
        }
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
         bookingDetails.subject = document.getElementById('js-subject-select').value;
         document.getElementById('js-summary-subject').textContent = bookingDetails.subject;
         document.getElementById('js-summary-date').textContent = bookingDetails.date.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' });
         document.getElementById('js-summary-time').textContent = bookingDetails.time;
         summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
    };

    // --- Lógica del Cupón (Paso 3) ---
    applyCouponBtn.addEventListener('click', () => {
        const code = couponInput.value.toUpperCase().trim();
        if (validCoupons[code]) {
            const discount = validCoupons[code];
            currentPrice = basePrice * (1 - discount);
            summaryTotal.textContent = `$${currentPrice.toFixed(2)}`;
            couponMessage.textContent = '¡Cupón aplicado correctamente! 🎉';
            couponMessage.className = 'text-sm mt-2 h-5 text-green-600';
        } else {
            currentPrice = basePrice; // Restablecer el precio base si el cupón no es válido
            summaryTotal.textContent = `$${basePrice.toFixed(2)}`;
            couponMessage.textContent = 'El cupón no es válido.';
            couponMessage.className = 'text-sm mt-2 h-5 text-red-600';
        }
    });

    // --- Lógica del Calendario y Horarios (Paso 2) ---
    const renderCalendar = () => {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        // Capitalizar el mes
        const monthName = currentDate.toLocaleDateString('es-ES', { month: 'long' });
        monthYearEl.textContent = `${monthName.charAt(0).toUpperCase() + monthName.slice(1)} ${year}`;

        calendarDaysEl.innerHTML = '';
        const weekDays = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
        weekDays.forEach(day => {
            calendarDaysEl.innerHTML += `<div class="font-semibold text-gray-500 text-sm">${day}</div>`;
        });

        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        const todayNoTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        // Rellenar espacios en blanco
        for (let i = 0; i < firstDayOfMonth; i++) {
            calendarDaysEl.innerHTML += `<div></div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayDate = new Date(year, month, day);
            let classes = 'calendar-day';
            
            // Comprobar si es un día pasado (no se puede seleccionar)
            const isPast = dayDate < todayNoTime;

            if (isPast) {
                classes += ' text-gray-300 cursor-not-allowed';
            }
            
            // Comprobar si es el día seleccionado actualmente
            if (bookingDetails.date && dayDate.getTime() === bookingDetails.date.getTime()) {
                classes += ' selected bg-blue-600 text-white';
            }

            // Simulación de disponibilidad (punto naranja)
            const hasAvailability = !isPast && Math.random() > 0.4;

            let dayHtml = `<div class="${classes}" data-date="${dayDate.toISOString().split('T')[0]}">
                ${day}
                ${hasAvailability ? '<span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-orange-400 rounded-full"></span>' : ''}
            </div>`;
            calendarDaysEl.innerHTML += dayHtml;
        }
    };

    // Manejar la selección de día
    calendarDaysEl.addEventListener('click', (e) => {
        const target = e.target.closest('.calendar-day');
        if (target && !target.classList.contains('cursor-not-allowed')) {
            // Limpiar selección anterior
            document.querySelectorAll('.calendar-day.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));
            // Aplicar nueva selección
            target.classList.add('selected', 'bg-blue-600', 'text-white');
            
            // Guardar la fecha seleccionada (solo el día, sin la hora)
            const dateParts = target.dataset.date.split('-').map(Number);
            bookingDetails.date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            
            // Restablecer la hora al seleccionar un nuevo día
            bookingDetails.time = '';
            renderTimeSlots();
        }
    });

    prevMonthBtn.addEventListener('click', () => {
        // Evita ir a meses anteriores al actual
        if (currentDate.getFullYear() > new Date().getFullYear() || currentDate.getMonth() > new Date().getMonth()) {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    const renderTimeSlots = () => {
        timeSlotsEl.innerHTML = '';
        if (!bookingDetails.date) {
            timeSlotsEl.innerHTML = '<p class="col-span-full text-center text-gray-500">Selecciona un día para ver los horarios disponibles.</p>';
            return;
        }

        // Generar horarios de 12:00 a 20:40 en intervalos de 20 minutos
        for (let hour = 12; hour <= 20; hour++) {
            for (let minute = 0; minute < 60; minute += 20) {
                // No mostrar horarios después de las 20:40
                if (hour === 20 && minute > 40) break;
                
                const time = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
                let classes = 'time-slot';
                
                if (bookingDetails.time === time) {
                   classes += ' selected bg-blue-600 text-white';
                }
                timeSlotsEl.innerHTML += `<div class="${classes}">${time}</div>`;
            }
        }
    };

    // Manejar la selección de hora
    timeSlotsEl.addEventListener('click', (e) => {
        const target = e.target.closest('.time-slot');
        if (target) {
            // Limpiar selección anterior
            document.querySelectorAll('.time-slot.selected').forEach(el => el.classList.remove('selected', 'bg-blue-600', 'text-white'));
            // Aplicar nueva selección
            target.classList.add('selected', 'bg-blue-600', 'text-white');
            bookingDetails.time = target.textContent;
        }
    });


    // --- Lógica de Pestañas de Pago (Paso 3) ---
    paymentTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remover estilos de activo de todas las pestañas
            paymentTabs.forEach(t => t.classList.remove('is-active', 'text-blue-600', 'border-blue-600', 'text-gray-500'));
            // Aplicar estilos de activo a la pestaña actual
            tab.classList.add('is-active', 'text-blue-600', 'border-blue-600');
            tab.classList.remove('text-gray-500');

            const targetId = tab.dataset.target;
            // Ocultar todos los contenidos
            paymentContents.forEach(content => content.classList.add('is-hidden'));
            // Mostrar el contenido objetivo
            document.getElementById(targetId).classList.remove('is-hidden');
        });
    });

    // --- Inicialización ---
    renderCalendar();
    renderTimeSlots();
    updateStepUI();
    updateNavButtons();
});
        
    </script>
    </body>
</html>