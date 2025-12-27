<div id="seccion-encuesta-wrapper">
    <div class="encuesta-card-dark">
        <div class="encuesta-top-dark">
            <span class="bar-accent"></span>
            <span class="top-text-dark"><span data-translate="encuesta_txt1"></span></span>
            <span class="bar-accent"></span>
        </div>
        <h2 class="titulo-dark">
            <span data-translate="encuesta_txt2"></span>
            <br>
            <span class="subtitulo-dark"><span data-translate="encuesta_txt3"></span></span>
        </h2>
        <div class="mascot-wrap-dark">
            <img src="{{ asset(path: 'images/home/logoClassgo.webp') }}" 
                 alt="Tugo" class="mascot-img-dark"
                 onerror=this.src="{{ asset('images/Tugo-rostro.png') }}">
        </div>

        @guest
        <!-- si no esta logueado que siga el flujo normal -->
        <div class="btn-static-wrapper" id="trigger-encuesta-final">
            <button class="btn-naranja-original">
                <span data-translate="encuesta_btn1"></span>
            </button>
        </div>
        @endguest

        <!-- boton modificado para que cuando se presione valide si el usuario logueado 
            y no tiene numero en registrado en su perfil que lo reenvie para que coloque su numero de celular-->
        @auth
        <div class="btn-static-wrapper" id="trigger-encuesta-final"
            data-auth="1"
            data-has-phone="{{ (Auth::user()->profile && Auth::user()->profile->phone_number) ? '1' : '0' }}"
            data-profile-url="{{ route('student.profile.personal-details') }}">

            <button class="btn-naranja-original">
                <span data-translate="encuesta_btn1"></span>
            </button>
        </div>
        @endauth

    </div>
</div>

<div id="modal-encuesta-overlay" class="encuesta-overlay-fixed">
    <div class="encuesta-modal-card">

        <button class="btn-corner btn-back" id="btn-encuesta-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>

        <button class="btn-corner btn-close close-modal-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6L6 18M6 6l12 12" />
            </svg>
        </button>

        <div class="progress-header">
            <div class="progress-track">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            <span class="step-text" id="step-text">1/3</span>
        </div>

        <div class="modal-watermark">
            <img src="{{ asset(path: 'images/home/logoClassgo.webp') }}" alt="Watermark">
        </div>

        <div class="modal-body">

            <div class="step-content active" data-step="1">
                <div class="icon-header">🔍</div>
                <h3 class="question-text"><span data-translate="encuesta_txt4"></span></h3>
                <div class="options-grid-binary">
                    <label class="option-card">
                        <input type="radio" name="p1" value="si">
                        <div class="card-inner"><span class="emoji">👍</span> <span data-translate="encuesta_op1"></span></div>
                    </label>
                    <label class="option-card">
                        <input type="radio" name="p1" value="no">
                        <div class="card-inner"><span class="emoji">👎</span> <span data-translate="encuesta_op2"></span></div>
                    </label>
                </div>
                <div class="action-footer">
                    <button class="btn-next" onclick="EncuestaManager.next(2)"><span data-translate="encuesta_btn2"></span> ➜</button>
                </div>
            </div>

            <div class="step-content" data-step="2">
                <div class="icon-header">⭐</div>
                <h3 class="question-text"><span data-translate="encuesta_txt5"></span></h3>

                <div class="rating-feedback-wrapper">
                    <span id="rating-feedback-text"><span data-translate="encuesta_txt6"></span></span>
                </div>

                <div class="stars-container" id="rating-container-js">
                    <button class="star-btn" data-val="1">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                    <button class="star-btn" data-val="2">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                    <button class="star-btn" data-val="3">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                    <button class="star-btn" data-val="4">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                    <button class="star-btn" data-val="5">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    </button>
                </div>

                <div class="action-footer">
                    <button class="btn-next" onclick="EncuestaManager.next(3)"><span data-translate="encuesta_btn2"> ➜</button>
                </div>
            </div>
            <!-- si el usuario no esta logueado -->
            @guest
            <div class="step-content" data-step="3">
                <div class="icon-header">💬</div>
                <h3 class="question-text"><span data-translate="encuesta_txt7"></span></h3>

                <div class="quick-tags-container">
                    <button class="tag-bubble" data-text="Excelente servicio">🔥 <span data-translate="encuesta_op3"></span></button>
                    <button class="tag-bubble" data-text="Muy rápido">🚀 <span data-translate="encuesta_op4"></span></button>
                    <button class="tag-bubble" data-text="Precios justos">💲 <span data-translate="encuesta_op5"></span></button>
                    <button class="tag-bubble" data-text="Falta variedad">📉 <span data-translate="encuesta_op6"></span></button>
                    <button class="tag-bubble" data-text="Regular">😐 <span data-translate="encuesta_op7"></span></button>
                </div>

                <div class="textarea-wrapper">
                    <textarea id="comment-box" placeholder="O escribe aquí..." class="premium-input"></textarea>
                </div>

                <div class="action-footer">
                    <button class="btn-next btn-finish" onclick="EncuestaManager.next('final')"><span data-translate="encuesta_btn2"></button>
                </div>
            </div>

            <div class="step-content" id="step-final">
                <div class="success-animation">
                    <div class="tugo-circle">
                        <img src="{{ asset('images/tugo-encuesta/tugo-pulgar-arriba.png') }}" alt="Success">
                    </div>
                    <h2 class="final-title"><span data-translate="encuesta_txt8"></span></h2>
                    <p class="final-desc"><span data-translate="encuesta_txt9"></span></p>
                </div>
                <div class="contact-form-premium" id="coupon-form">
                    <p style="margin-bottom: 10px; font-weight:600; color: #185875;">
                        <span data-translate="encuesta_txt10"></span>
                    </p>
                    <input type="tel" placeholder="Ej: 70012345" class="premium-input contact-input" style="text-align: center;" maxlength="15">
                    <button class="btn-redeem" onclick="EncuestaManager.submitGuest()"><span data-translate="encuesta_btn3"></button>
                </div>
            </div>
            @endguest

            <!-- si el usuario esta logueado -->
            @auth
            <div class="step-content" data-step="3">
                <div class="icon-header">💬</div>
                <h3 class="question-text">Queremos saber tu opinión: <br>cuéntanos tu experiencia o deja tu comentario.</h3>

                <div class="quick-tags-container">
                    <button class="tag-bubble" data-text="Excelente servicio">🔥 Excelente servicio</button>
                    <button class="tag-bubble" data-text="Muy rápido">🚀 Muy rápido</button>
                    <button class="tag-bubble" data-text="Precios justos">💲 Precios justos</button>
                    <button class="tag-bubble" data-text="Falta variedad">📉 Falta variedad</button>
                    <button class="tag-bubble" data-text="Regular">😐 Regular</button>
                </div>

                <div class="textarea-wrapper">
                    <textarea id="comment-box" placeholder="O escribe aquí..." class="premium-input"></textarea>
                </div>

                <div class="action-footer">
                    <button class="btn-next btn-finish" onclick="EncuestaManager.submitAuth(this)">Finalizar Encuesta</button>
                </div>
            </div>

            <div class="step-content" id="step-final-auth">
                <div class="success-animation">
                    <div class="tugo-circle">
                        <img src="{{ asset('images/tugo-encuesta/tugo-pulgar-arriba.png') }}" alt="Success">
                    </div>
                    <h2 class="final-title">¡Encuesta Completada!</h2>

                    <p class="final-desc">
                        Tu opinión es muy valiosa para nosotros. Como agradecimiento, te enviaremos un cupón del 50% descuento al número que está asociado a tu cuenta.
                    </p>

                    <button class="btn-naranja-original" onclick="window.location.reload()" style="margin-top:20px; padding: 10px 30px; font-size:1rem;">Cerrar</button>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
<!-- notificacion del cupon-->
<div id="toast-wrapper-fixed"></div>

<style>
    /* =========================================
       1. ESTILOS SECCIÓN ORIGINAL
       ========================================= */
    #seccion-encuesta-wrapper {
        background-image: linear-gradient(to right, #02011b, #054f72);
        padding: 60px 20px;
        width: 100%;
        text-align: center;
        font-family: 'Montserrat', sans-serif;
        box-sizing: border-box;
        position: relative;
        border-radius: 2rem 2rem 0 0;
    }

    #seccion-encuesta-wrapper * {
        box-sizing: border-box;
    }

    .encuesta-card-dark {
        max-width: 800px;
        margin: 0 auto;
    }

    .encuesta-top-dark {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .bar-accent {
        width: 50px;
        height: 4px;
        background: #46c7e0;
        border-radius: 4px;
    }

    .top-text-dark {
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    .titulo-dark {
        color: #fff;
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 30px;
    }

    .subtitulo-dark {
        font-size: 0.6em;
        font-weight: 400;
        opacity: 0.9;
        display: block;
        margin-top: 5px;
    }

    .mascot-img-dark {
        width: 180px;
        max-width: 100%;
        height: auto;
        transform: scale(1.5);
        pointer-events: none;
        position: relative;
        z-index: 1;
        padding: 2rem 0 2rem 0;
    }

    /* 1. el envoltorio div recibe los clics y es estatico para evitar bugs */
    .btn-static-wrapper {
        display: inline-block;
        padding-bottom: 4px;
        cursor: pointer;
    }

    /* 2. boton */
    .btn-naranja-original {
        background-color: #FB8500;
        color: white;
        border: none;
        padding: 16px 50px;
        border-radius: 50px;
        font-size: 1.3rem;
        font-weight: 800;
        box-shadow: 0 6px 0 #7e480bff;
        transition: transform 0.1s, box-shadow 0.1s;
        pointer-events: none;
    }

    /* 3. acción cuando el cursor toca el area del div hace el efecto de estar precionado */
    .btn-static-wrapper:hover .btn-naranja-original {
        transform: translateY(4px);
        box-shadow: 0 2px 0 #ff8800ff;
    }

    .btn-static-wrapper:active .btn-naranja-original {
        transform: translateY(6px);
        box-shadow: none;
    }

    /* =========================================
       2. MODAL & ESTRUCTURA
       ========================================= */
    .encuesta-overlay-fixed {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 30, 45, 0.7);
        backdrop-filter: blur(5px);
        z-index: 2147483647;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        padding: 20px;
    }

    .encuesta-overlay-fixed.active {
        opacity: 1;
        visibility: visible;
    }

    .encuesta-modal-card {
        background: #fff;
        width: 100%;
        max-width: 600px;
        height: auto;
        max-height: 90vh;
        border-radius: 24px;
        padding: 30px;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        font-family: 'Inter', sans-serif;
        transform: scale(0.95);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow-y: auto;
    }

    .encuesta-overlay-fixed.active .encuesta-modal-card {
        transform: scale(1);
    }

    .btn-corner {
        position: absolute;
        top: 25px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: #f1f3f5;
        color: #555;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s;
        z-index: 20;
    }

    .btn-corner:hover {
        background: #e9ecef;
        color: #000;
    }

    .btn-back {
        left: 25px;
    }

    .btn-close {
        right: 25px;
    }

    .progress-header {
        position: absolute;
        top: 25px;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        z-index: 15;
    }

    .progress-track {
        flex: 1;
        height: 6px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #46c7e0;
        width: 33%;
        transition: width 0.3s ease;
    }

    .step-text {
        font-size: 0.9rem;
        font-weight: 800;
        color: #185875;
        white-space: nowrap;
    }

    .modal-body {
        flex: 1;
        position: relative;
        display: flex;
        flex-direction: column;
        z-index: 5;
        margin-top: 50px;
    }

    .step-content {
        display: none;
        flex-direction: column;
        height: 100%;
        align-items: center;
        text-align: center;
        animation: fadeIn 0.4s ease;
        width: 100%;
        justify-content: space-between;
        padding-bottom: 10px;
    }

    .step-content.active {
        display: flex;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .icon-header {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .question-text {
        font-size: 1.5rem;
        color: #185875;
        margin-bottom: 25px;
        font-weight: 700;
        line-height: 1.3;
    }

    .modal-watermark {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 250px;
        opacity: 0.06;
        pointer-events: none;
        z-index: 0;
    }

    .modal-watermark img {
        width: 100%;
    }

    .options-grid-binary {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        width: 100%;
        margin-bottom: auto;
    }

    .option-card input {
        display: none;
    }

    .card-inner {
        border: 2px solid #eee;
        border-radius: 16px;
        padding: 30px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: 0.2s;
        color: #555;
        font-weight: 600;
        background: white;
    }

    .option-card input:checked+.card-inner {
        border-color: #46c7e0;
        background: #f0fbff;
        color: #185875;
        box-shadow: 0 4px 12px rgba(70, 199, 224, 0.2);
    }

    .emoji {
        font-size: 2.2rem;
    }

    .rating-feedback-wrapper {
        height: 30px;
        margin-bottom: 15px;
        font-weight: 700;
        font-size: 1.2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #888;
    }

    .stars-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .star-btn {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        width: 50px;
        height: 50px;
        color: #e0e0e0;
        transition: transform 0.2s, color 0.2s;
    }

    .star-btn svg {
        width: 100%;
        height: 100%;
        fill: currentColor;
    }

    .star-btn.filled {
        color: #ffc107;
    }

    .star-btn.active-scale {
        transform: scale(1.2);
    }

    .quick-tags-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
        width: 100%;
    }

    .tag-bubble {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 50px;
        padding: 8px 16px;
        font-size: 0.9rem;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
    }

    .tag-bubble:hover {
        background: #e2e6ea;
    }

    .tag-bubble.selected {
        background: #185875;
        color: white;
        border-color: #185875;
    }

    .textarea-wrapper {
        width: 100%;
        margin-bottom: auto;
    }

    .premium-input {
        width: 100%;
        padding: 15px;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 1rem;
        outline: none;
        background: #fcfcfc;
        resize: none;
        font-family: inherit;
    }

    .premium-input:focus {
        border-color: #46c7e0;
        background: #fff;
    }

    .action-footer {
        width: 100%;
        margin-top: auto;
        display: flex;
        justify-content: center;
        padding-top: 10px;
    }

    .btn-next {
        background: #185875;
        color: white;
        border: none;
        padding: 14px 0;
        width: 200px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(24, 88, 117, 0.2);
        transition: 0.2s;
    }

    .btn-next:hover {
        background: #114258;
        transform: translateY(-2px);
    }

    .btn-finish {
        background: #FB8500;
        box-shadow: 0 5px 15px rgba(255, 106, 43, 0.3);
    }

    .btn-finish:hover {
        background: #FB8500;
    }

    /* =========================================
       ESTILOS PANTALLA FINAL (CORREGIDOS)
       ========================================= */
    #step-final {
        justify-content: center;
    }

    .success-animation {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        margin-bottom: 20px;
    }

    .tugo-circle {
        width: 110px;
        height: 110px;
        background: #e0f7fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }

    .tugo-circle img {
        width: 70px;
    }

    .final-title {
        color: #2ecc71;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    /* CLASE NUEVA PARA FORZAR VISIBILIDAD DEL TEXTO */
    .final-desc {
        color: #555 !important;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        margin: 10px 0 !important;
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    .contact-form-premium {
        width: 100%;
        margin-top: 10px;
        opacity: 0;
        transform: translateY(20px);
        transition: 0.5s;
    }

    .contact-form-premium.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .btn-redeem {
        background: #2ecc71;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 15px;
        font-size: 1.1rem;
    }

    /*css del mensaje de notificación del cupon */
    #toast-wrapper-fixed {
        position: fixed;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2147483647;
        pointer-events: none;
        width: 90%;
        max-width: 400px;
    }

    .toast-premium {
        background: white;
        padding: 15px 25px;
        border-radius: 50px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 15px;
        animation: dropIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #eee;
    }

    @keyframes dropIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }


    @media (max-width: 600px) {
        .encuesta-modal-card {
            width: 90%;
            min-height: auto;
            max-height: 85vh;
            border-radius: 20px;
            padding: 20px;
            margin: auto;
        }

        .progress-header {
            width: 60%;
            top: 20px;
        }

        .btn-next {
            width: 100%;
        }

        .modal-body {
            margin-top: 50px;
        }

        .tugo-circle {
            width: 90px;
            height: 90px;
        }

        .tugo-circle img {
            width: 50px;
        }

        .final-title {
            font-size: 1.6rem;
        }

        .final-desc {
            font-size: 0.95rem !important;
        }
    }

    /* 1. Bajamos la encuesta de "Infinito" a un número alto pero razonable */
    .encuesta-overlay-fixed {
        z-index: 10000 !important;
        /* Antes era 2147483647 */
    }

    /* 2. Subimos la Alerta y el Toast por encima de la encuesta */
    .swal2-container {
        z-index: 20000 !important;
        /* Mayor que 10000 para que gane */
    }

    /* También aseguramos que tu notificación toast se vea */
    #toast-wrapper-fixed {
        z-index: 20000 !important;
    }
</style>

<script>
    const EncuestaManager = (function() {

        let currentRating = 0;

        // --- Inicialización (DOM Ready) ---
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modal-encuesta-overlay');
            const toast = document.getElementById('toast-wrapper-fixed');
            if (modal) document.body.appendChild(modal);
            if (toast) document.body.appendChild(toast);

            // LISTENERS
            const trigger = document.getElementById('trigger-encuesta-final');
            if (trigger) trigger.addEventListener('click', checkAndOpen);

            const closer = document.querySelector('.close-modal-btn');
            if (closer) closer.addEventListener('click', close);

            const backer = document.getElementById('btn-encuesta-back');
            if (backer) {
                backer.addEventListener('click', () => {
                    const activeStep = document.querySelector('.step-content.active');
                    const stepNum = activeStep ? parseInt(activeStep.dataset.step) : 1;
                    if (stepNum > 1) next(stepNum - 1);
                });
            }

            // TAGS
            const tags = document.querySelectorAll('.tag-bubble');
            const textarea = document.getElementById('comment-box');
            tags.forEach(tag => {
                tag.addEventListener('click', () => {
                    tags.forEach(t => t.classList.remove('selected'));
                    tag.classList.add('selected');
                    textarea.value = tag.getAttribute('data-text');
                });
            });

            // ESTRELLAS
            const starBtns = document.querySelectorAll('.star-btn');
            starBtns.forEach(btn => {
                const val = parseInt(btn.dataset.val);
                btn.addEventListener('mouseenter', () => updateStars(val));
                btn.addEventListener('click', () => {
                    currentRating = val;
                    updateStars(val, true);
                });
            });

            const starContainer = document.getElementById('rating-container-js');
            if (starContainer) {
                starContainer.addEventListener('mouseleave', () => {
                    const feedbackText = document.getElementById('rating-feedback-text');
                    if (currentRating > 0) updateStars(currentRating, true);
                    else {
                        feedbackText.textContent = "Selecciona las estrellas";
                        feedbackText.style.color = "#ccc";
                        starBtns.forEach(b => b.classList.remove('filled', 'active-scale'));
                    }
                });
            }

            // VALIDACIÓN INPUT EN VIVO
            const phoneInput = document.querySelector('.contact-input');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/\D/g, '');
                });
            }
        });

        // --- VALIDACIÓN POR PASOS ---
        function validateStep(stepToCheck) {
            if (stepToCheck === 1) {
                const p1 = document.querySelector('input[name="p1"]:checked');
                if (!p1) {
                    showToast('ℹ', 'Selecciona una opción', '#3498db');
                    return false;
                }
            } else if (stepToCheck === 2) {
                if (currentRating === 0) {
                    showToast('ℹ', 'Selecciona una calificación', '#3498db');
                    return false;
                }
            } else if (stepToCheck === 3) {
                const comment = document.getElementById('comment-box').value.trim();
                if (comment === '') {
                    showToast('ℹ', 'Escribe un comentario', '#3498db');
                    document.getElementById('comment-box').style.borderColor = 'red';
                    return false;
                } else {
                    document.getElementById('comment-box').style.borderColor = '#eee';
                }
            }
            return true;
        }

        // --- LIMPIEZA ---
        function resetForm() {
            currentRating = 0;
            const radios = document.querySelectorAll('input[name="p1"]');
            radios.forEach(r => r.checked = false);
            const starBtns = document.querySelectorAll('.star-btn');
            starBtns.forEach(b => b.classList.remove('filled', 'active-scale'));
            const feedbackText = document.getElementById('rating-feedback-text');
            if (feedbackText) {
                feedbackText.textContent = "Selecciona las estrellas";
                feedbackText.style.color = "#ccc";
            }
            const tags = document.querySelectorAll('.tag-bubble');
            tags.forEach(t => t.classList.remove('selected'));
            const textarea = document.getElementById('comment-box');
            if (textarea) {
                textarea.value = '';
                textarea.style.borderColor = '#eee';
            }
            const phoneInput = document.querySelector('.contact-input');
            if (phoneInput) {
                phoneInput.value = '';
                phoneInput.style.borderColor = '#eee';
            }
            setTimeout(() => next(1), 300);
        }

        function close() {
            document.getElementById('modal-encuesta-overlay').classList.remove('active');
            resetForm();
        }

        // --- NAVEGACIÓN ---
        function next(targetStep) {
            let currentStepNum = null;
            const currentStepEl = document.querySelector('.step-content.active');
            if (currentStepEl) currentStepNum = parseInt(currentStepEl.dataset.step);

            if (targetStep !== 'final-auth' && (targetStep === 'final' || targetStep > currentStepNum)) {
                if (!validateStep(currentStepNum)) return;
            }

            const modalContext = document.getElementById('modal-encuesta-overlay');
            const localSteps = modalContext.querySelectorAll('.step-content');
            const closeBtn = modalContext.querySelector('.close-modal-btn');

            localSteps.forEach(s => s.classList.remove('active'));

            if (targetStep === 'final') {
                if (!validateStep(3)) {
                    document.querySelector('.step-content[data-step="3"]').classList.add('active');
                    return;
                }
                modalContext.querySelector('#step-final').classList.add('active');
                modalContext.querySelector('.progress-header').style.display = 'none';
                modalContext.querySelector('#btn-encuesta-back').style.display = 'none';
                const form = modalContext.querySelector('#coupon-form');
                if (form) setTimeout(() => form.classList.add('visible'), 300);
            } else if (targetStep === 'final-auth') {
                modalContext.querySelector('#step-final-auth').classList.add('active');
                modalContext.querySelector('.progress-header').style.display = 'none';
                modalContext.querySelector('#btn-encuesta-back').style.display = 'none';
                if (closeBtn) closeBtn.style.display = 'none';
            } else {
                if (closeBtn) closeBtn.style.display = 'flex';
                modalContext.querySelector('.progress-header').style.display = 'flex';
                modalContext.querySelector('#btn-encuesta-back').style.display = 'block';

                const stepEl = modalContext.querySelector(`.step-content[data-step="${targetStep}"]`);
                if (stepEl) stepEl.classList.add('active');

                const pct = (targetStep / 3) * 100;
                const fill = modalContext.querySelector('#progress-fill');
                const txt = modalContext.querySelector('#step-text');
                if (fill) fill.style.width = `${pct}%`;
                if (txt) txt.textContent = `${targetStep}/3`;
            }
        }

        // --- ENVÍO DE DATOS AJAX ---
        async function sendData(contact, btnToDisable = null) {
            const p1Element = document.querySelector('input[name="p1"]:checked');
            const question1 = p1Element ? (p1Element.value === 'si' ? 1 : 0) : 0;
            const question3 = document.getElementById('comment-box').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (btnToDisable) {
                btnToDisable.disabled = true;
                btnToDisable.innerText = "Enviando...";
            }

            try {
                const response = await fetch('/encuesta/guardar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        Question_1: question1,
                        Question_2: currentRating,
                        Question_3: question3,
                        Contact: contact
                    })
                });
                const data = await response.json();
                if (response.ok && data.success) {
                    return {
                        success: true,
                        message: data.message
                    };
                } else {
                    return {
                        success: false,
                        message: data.message || 'Error desconocido'
                    };
                }
            } catch (error) {
                console.error(error);
                return {
                    success: false,
                    message: 'Error de conexión'
                };
            } finally {
                if (btnToDisable) {
                    btnToDisable.disabled = false;
                    btnToDisable.innerText = "Finalizar";
                }
            }
        }

        // ==========================================
        // 1. ENVÍO GUEST (SIN BOTÓN WHATSAPP)
        // ==========================================
        async function submitGuest() {
            const input = document.querySelector('.contact-input');
            const btn = document.querySelector('.btn-redeem');

            if (!input.value) {
                input.style.borderColor = 'red';
                return;
            }
            if (input.value.length < 8) {
                showToast('⚠', 'Mínimo 8 dígitos', '#e74c3c');
                return;
            }

            const result = await sendData(input.value, btn);

            if (result.success) {
                close();
                showToast('✔', result.message, '#2ecc71');
                input.value = '';
            } else {
                // ERROR GUEST: Solo mostramos Toast rojo pidiendo corregir
                // NO mostramos SweetAlert ni WhatsApp aquí
                showToast('✖', "El número ya fue usado. Ingresa otro.", '#e74c3c');
                input.style.borderColor = 'red';
            }
        }

        // ==========================================
        // 2. ENVÍO AUTH (CON BOTÓN WHATSAPP)
        // ==========================================
        async function submitAuth(btnElement) {
            if (!validateStep(3)) return;

            const result = await sendData(null, btnElement);

            if (result.success) {
                next('final-auth');
                showToast('✔', 'Datos guardados correctamente', '#2ecc71');
            } else {
                // ERROR AUTH: Detectamos duplicado y mostramos Alerta WhatsApp
                const errorMsg = result.message.toLowerCase();
                const esDuplicado = errorMsg.includes('duplicate') || errorMsg.includes('1062') || errorMsg.includes('ya tiene un cupón');

                if (esDuplicado) {
                    Swal.fire({
                        title: '¡Atención!',
                        html: "El número asociado a esta cuenta ya fue usado. Actualiza tu número; si no fuiste tú, contáctanos.",
                        icon: 'warning',
                        iconColor: '#FB8500',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa-brands fa-whatsapp"></i> 77573997',
                        cancelButtonText: 'Cerrar',
                        confirmButtonColor: '#25D366',
                        cancelButtonColor: '#185875',
                        reverseButtons: true,
                        background: '#fff',
                        customClass: {
                            popup: 'encuesta-swal-popup'
                        }
                    }).then((res) => {
                        if (res.isConfirmed) window.location.href = "https://wa.link/yiegi5";
                    });
                } else {
                    showToast('✖', "Ocurrió un error al guardar.", '#e74c3c');
                }
            }
        }

        // --- AUXILIARES ---
        function checkAndOpen(e) {
            e.preventDefault();
            const btn = e.currentTarget;
            const isAuth = btn.getAttribute('data-auth') === '1';
            const hasPhone = btn.getAttribute('data-has-phone') === '1';
            const profileUrl = btn.getAttribute('data-profile-url');

            if (isAuth && !hasPhone) {
                Swal.fire({
                    title: '¡Falta un pequeño paso!',
                    text: "Necesitamos tu número de teléfono en tu perfil para poder enviarte el cupón de descuento.",
                    icon: 'warning',
                    iconColor: '#FB8500',
                    showCancelButton: true,
                    confirmButtonColor: '#FB8500',
                    cancelButtonColor: '#185875',
                    confirmButtonText: 'Ir a mi perfil',
                    cancelButtonText: 'Cancelar',
                    background: '#fff',
                    customClass: {
                        popup: 'encuesta-swal-popup',
                        title: 'encuesta-swal-title'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = profileUrl;
                    }
                });
                return;
            }
            open();
        }

        function open() {
            document.getElementById('modal-encuesta-overlay').classList.add('active');
            next(1);
        }

        function updateStars(val, select = false) {
            const feedbackText = document.getElementById('rating-feedback-text');
            const starBtns = document.querySelectorAll('.star-btn');
            const getStarInfo = (v) => {
                if (v <= 2) return {
                    t: "Nada probable 😞",
                    c: "#e74c3c"
                };
                if (v === 3) return {
                    t: "Tal vez 🤔",
                    c: "#f1c40f"
                };
                return {
                    t: "¡Sin duda! 🤩",
                    c: "#2ecc71"
                };
            };
            const info = getStarInfo(val);
            if (feedbackText) {
                feedbackText.textContent = info.t;
                feedbackText.style.color = info.c;
            }
            starBtns.forEach(b => {
                const bVal = parseInt(b.dataset.val);
                if (bVal <= val) {
                    b.classList.add('filled');
                    if (bVal === val) b.classList.add('active-scale');
                    else b.classList.remove('active-scale');
                } else {
                    b.classList.remove('filled', 'active-scale');
                }
            });
        }

        function showToast(icon, text, color) {
            const toast = document.createElement('div');
            toast.className = 'toast-premium';
            toast.innerHTML = `<span style="color:${color}; font-size:1.2rem;">${icon}</span> <span>${text}</span>`;
            document.getElementById('toast-wrapper-fixed').appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        return {
            next,
            submitGuest,
            submitAuth,
            checkAndOpen,
            close
        };
    })();
</script>