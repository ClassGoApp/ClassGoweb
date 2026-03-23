<div class="fab-container">
    @include('components.floating-button.partials.whatsapp-option')
    @include('components.floating-button.partials.ai-option')
    @include('components.floating-button.partials.support-option')

    <button class="instant-btn-floating " onclick="irAlInstanteDesdeFlotante()">
        <i>
            <svg class="bolt" viewBox="0 0 24 24">
                <path d="M13 2L3 14h7l-1 8 10-12h-7z" />
            </svg>
        </i>

        <span class="instant-tooltip">
            ¡Tutoría al Instante!
        </span>
    </button>

    <button id="fab-main-button" class="fab-main">
        <i id="fab-main-icon" class="fas fa-question"></i>
        {{-- <img id="fab-main-icon" class="tutoria-disponible-boton" src="{{ asset('images/logoClassgo.png') }}" alt=""> --}}

        <span id="fab-tooltip-closed" class="fab-main__tooltip fab-main__tooltip--closed">
            ¿Necesitas ayuda?
        </span>
        <span id="fab-tooltip-open" class="fab-main__tooltip fab-main__tooltip--open hidden">
            Cerrar
        </span>
    </button>

</div>
<style>
    .bolt {
        width: 30px;
        height: 30px;

        fill: transparent;
        /* 🔹 estado base: vacío */
        stroke: #ffffff;
        stroke-width: 2;

        transition:
            fill .25s ease,
            stroke .25s ease,
            transform .25s ease;
    }

    .instant-btn-floating {
        position: relative;
        /* ✅ CORRECTO */
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 60px;
        height: 60px;
        border-radius: 10rem;
        background: var(--terciary-color2);
        border: none;

        animation: ctaPulse 2s infinite ease-out;
    }

    @keyframes ctaPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(251, 133, 0, 0.6);
            ;
            opacity: 1;
        }

        70% {
            box-shadow: 0 0 0 22px rgba(251, 133, 0, 0.20);
            opacity: 1;
        }

        100% {
            box-shadow: 0 0 0 30px rgba(251, 133, 0, 0);
            opacity: 1;
        }
    }

    /* ===== URGENT CTA – BRAND SAFE ===== */
    .instant-tooltip {
        position: absolute;
        right: calc(100% + 12px);
        top: 50%;
        transform: translateY(-50%);

        background: rgba(14, 165, 183, 0.4);

        color: #ffffff;
        padding: 12px 20px;

        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
        opacity: 0;
        pointer-events: none;
        border-left: 4px solid var(--terciary-color2);
        animation: urgentAppear 10s ease forwards;
    }

    .instant-btn-floating:hover .instant-tooltip {
        opacity: 1;
        transform: translateY(-50%) scale(1);
        animation: none;
        /* 👈 cancela la animación */
    }

    .instant-tooltip::after {
        content: '';
        position: absolute;
        right: -10px;
        top: 50%;
        transform: translateY(-50%);

        width: 0;
        height: 0;

        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-left: 10px solid var(--terciary-color2);
    }

    @keyframes urgentAppear {
        0% {
            opacity: 0;
            transform: translateY(-50%) scale(0.9);
        }

        6% {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        30% {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        100% {
            opacity: 0;
            transform: translateY(-50%) scale(0.95);
        }
    }

    @media (max-width: 600px) {
        .instant-tooltip {
            font-size: 13px;
            padding: 20px 8px;
        }
    }
</style>
