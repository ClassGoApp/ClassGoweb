@extends('vistas.view.layouts.app')

@section('content')
    <div>
        <livewire:horas />
    </div>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <style>
        :root {
            --primary-color: #023047;
            --secundary-color: #219EBC;
            --secundary-color2: #E2E8F0;
            --terciary-color: #8ECAE6;
            --terciary-color2: #E63946;
            --bg-color: #FFFFFF;
            --text-main: #334155;
            --text-muted: #64748B;
            --panel-bg: #F8FAFC;
            --transition: all 0.15s ease;
        }

        /* Pantalla de Bienvenida (Onboarding) Minimalista */
        .onboarding-card {
            max-width: 680px;
            margin: 4rem auto;
            /* padding: 2.5rem; */
            background-color: var(--panel-bg);
            border: 1px solid var(--secundary-color2);
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 10px 30px -10px rgba(2, 48, 71, 0.08);
            box-sizing: border-box;
        }

        .onboarding-hero .onboarding-icon {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 0.75rem;
        }

        .onboarding-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 0 1rem 0;
            letter-spacing: -0.5px;
        }

        .onboarding-desc {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-muted);
            /* margin: 0 0 2.5rem 0; */
        }

        .onboarding-action-zone {
            border-top: 1px solid var(--secundary-color2);
            padding-top: 10px;
        }

        .onboarding-action-zone label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.75rem;
        }

        /* Contenedor del Calendario Abierto Estilo Tablero */
        .datepicker-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
            width: 100%;
            margin: 0 auto;
        }

        /* Ajustes sutiles para el diseño integrado de Flatpickr */
        .flatpickr-calendar.inline {
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(2, 48, 71, 0.04) !important;
            border: 1px solid var(--secundary-color2) !important;
            border-radius: 8px !important;
            background: #fff;
        }

        .premium-date-input {
            flex-grow: 1;
            padding: 0.65rem 0.85rem !important;
            font-size: 0.95rem !important;
            font-weight: 500;
            border: 2px solid var(--secundary-color2) !important;
            border-radius: 6px !important;
            color: var(--text-main);
            outline: none;
            transition: var(--transition);
            background-color: #fff;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .premium-date-input:focus {
            border-color: var(--secundary-color) !important;
        }

        /* Botón grande y centrado debajo del calendario */
        .btn-onboarding {
            padding: 0.75rem 2rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            background-color: var(--primary-color);
            color: #fff;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            max-width: 300px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(2, 48, 71, 0.1);
        }

        .btn-onboarding:hover {
            background-color: #0b415c;
            transform: translateY(-1px);
        }

        /* --- REDISEÑO COMPLETO ESTILO WIDGET PREMIUM --- */

        .flatpickr-calendar.inline {
            background-color: var(--secundary-color) !important;
            border: none !important;
            border-radius: 16px !important;
            padding: 0.85rem !important;
            width: 290px !important;
            max-width: 290px !important;
            box-sizing: border-box;
            box-shadow: 0 10px 25px -5px rgba(2, 48, 71, 0.15) !important;
        }

        .flatpickr-months {
            background-color: var(--primary-color) !important;
            border-radius: 10px !important;
            padding: 0.5rem !important;
            margin-bottom: 0.75rem !important;
            display: flex;
            align-items: center;
            position: relative;
            box-sizing: border-box;
            height: 46px !important;
        }

        .flatpickr-prev-month, 
        .flatpickr-next-month {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            height: auto !important;
            padding: 0 !important;
            color: #ffffff !important;
            fill: #ffffff !important;
            z-index: 10 !important;
            right: auto !important;
        }
        .flatpickr-prev-month { left: 12px !important; }
        .flatpickr-next-month { left: 35px !important; }
        .flatpickr-prev-month:hover svg, .flatpickr-next-month:hover svg { fill: var(--terciary-color) !important; }

        .flatpickr-current-month {
            display: flex !important;
            align-items: center !important;
            gap: 0.4rem !important;
            position: absolute !important;
            left: 50px !important; /* Ajustado para dar paso limpio a las flechas izquierdas */
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: auto !important;
            padding: 0 !important;
            margin: 0 !important;
            color: #ffffff !important;
        }

        .flatpickr-monthDropdown-months {
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            outline: none !important;
            appearance: auto !important;
        }

        .flatpickr-monthDropdown-months option {
            color: var(--text-main) !important;
            background-color: #ffffff !important;
            font-weight: normal !important;
        }

        .flatpickr-current-month .numInputWrapper {
            display: inline-block !important;
            width: 60px !important;
            height: auto !important;
        }

        .flatpickr-current-month input.cur-year {
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            padding: 0.25rem 0.4rem !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            margin: 0 !important;
            height: 100% !important;
            box-sizing: border-box !important;
        }

        .flatpickr-current-month .numInputWrapper span { display: none !important; }

        .flatpickr-weekdays { background: transparent !important; height: 28px !important; margin-bottom: 0.25rem; }
        span.flatpickr-weekday { color: rgba(255, 255, 255, 0.9) !important; font-weight: 600 !important; font-size: 0.8rem !important; }
        .flatpickr-days { width: 100% !important; }
        .dayContainer { width: 100% !important; min-width: 100% !important; max-width: 100% !important; justify-content: space-between !important; }

        .flatpickr-day {
            color: #ffffff !important;
            font-weight: 500 !important;
            font-size: 0.85rem !important;
            background: transparent !important;
            border: 1px solid transparent !important;
            border-radius: 8px !important;
            margin: 2px 0 !important;
            height: 34px !important;
            line-height: 32px !important;
            max-width: 34px !important;
            flex-basis: 14% !important;
        }

        /* CORRECCIÓN: Filtrado estricto solo para elementos identificados como Lunes */
        .flatpickr-day.is-monday {
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            background-color: rgba(255, 255, 255, 0.05) !important;
            position: relative;
        }

        .flatpickr-day.is-monday::after {
            content: '';
            position: absolute;
            top: 4px;
            right: 4px;
            width: 4px;
            height: 4px;
            background-color: #38ef7d;
            border-radius: 50%;
        }

        /* Limpieza absoluta de contornos residuales en los demás días */
        .flatpickr-day:not(.is-monday):not(.selected) {
            border-color: transparent !important;
            background: transparent !important;
        }

        .flatpickr-day.selected {
            background-color: var(--primary-color) !important;
            border-color: #ffffff !important;
        }

        .flatpickr-day.disabled, .flatpickr-day.disabled:hover,
        .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
            color: rgba(255, 255, 255, 0.35) !important;
            background: transparent !important;
            border-color: transparent !important;
            cursor: not-allowed;
        }

        .flatpickr-day:hover:not(.disabled) {
            background-color: rgba(255, 255, 255, 0.2) !important;
            border-color: #ffffff !important;
        }

        .datepicker-hint {
            display: block;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.75rem;
        }

        /* Contenedor General */
        .control-horas-container {
            margin: 8rem auto;
            max-width: 100%;
            padding: 0 0.75rem;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-main);
            box-sizing: border-box;
        }

        .control-horas-container h2 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        /* Inputs optimizados para evitar recortes */
        input[type="date"] {
            padding: 0.25rem 0.4rem;
            border: 1px solid var(--secundary-color2);
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--text-main);
            outline: none;
            width: auto;
        }

        input[type="time"] {
            padding: 0.2rem 0.3rem;
            border: 1px solid var(--secundary-color2);
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--text-main);
            outline: none;
            width: 100%;
            min-width: 82px;
            max-width: 100%;
            box-sizing: border-box;
        }

        input[type="time"]:focus,
        input[type="date"]:focus {
            border-color: var(--secundary-color);
        }

        /* BOTONES MINI */
        .btn-mini {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: max-content;
            padding: 0.2rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
            background: none;
            transition: var(--transition);
        }

        .btn-mini-primary {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-mini-primary:hover {
            background-color: #0b415c;
        }

        .btn-mini-outline {
            border-color: var(--secundary-color);
            color: var(--secundary-color);
            width: 100%;
        }

        .btn-mini-outline:hover {
            background-color: #F0F9FF;
        }

        .btn-mini-danger {
            color: var(--terciary-color2);
            border-color: #fee2e2;
            background-color: #fff5f5;
        }

        .btn-mini-danger:hover {
            background-color: #fee2e2;
        }

        .btn-mini-text {
            color: var(--text-muted);
            padding: 0.15rem 0.3rem;
            border-radius: 3px;
        }

        .btn-mini-text:hover {
            color: var(--primary-color);
            background-color: #e2e8f0;
        }

        /* Sección de la Semana */
        .semana-section {
            border: 1px solid var(--secundary-color2);
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 1.25rem;
            background-color: #fff;
        }

        .semana-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding-bottom: 0.35rem;
            border-bottom: 1px solid var(--secundary-color2);
        }

        .semana-header h3 {
            margin: 0;
            font-size: 1rem;
            color: var(--primary-color);
        }

        .semana-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* GRID HORIZONTAL DE DÍAS */
        .dias-horizontal-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            overflow-x: auto;
            padding-bottom: 0.25rem;
        }

        @media (max-width: 1150px) {
            .dias-horizontal-grid {
                display: flex;
            }

            .dia-card {
                flex: 0 0 195px;
            }
        }

        /* Tarjeta de Día Individual */
        .dia-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--secundary-color2);
            border-top: 2px solid var(--secundary-color);
            border-radius: 4px;
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 185px;
            box-sizing: border-box;
        }

        .dia-title {
            font-size: 0.75rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Lista de Rangos dentro de la Card */
        .rangos-stack {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 0.5rem;
            flex-grow: 1;
        }

        /* Nuevo estilo para input de 24 horas en texto */
        input.input-24h {
            padding: 0.2rem 0.15rem;
            border: 1px solid var(--secundary-color2);
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--text-main);
            outline: none;
            text-align: center;
            width: 50px !important;
            min-width: 50px !important;
            max-width: 50px !important;
            box-sizing: border-box;
        }

        input.input-24h:focus {
            border-color: var(--secundary-color);
            background-color: #fff;
        }

        .rango-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.15rem;
            font-size: 0.7rem;
            background: #fff;
            padding: 0.2rem;
            border-radius: 3px;
            border: 1px dashed #cbd5e1;
            box-sizing: border-box;
            width: 100%;
        }

        .rango-row div {
            display: flex;
            align-items: center;
            flex-direction: row;
        }

        /* Barra de Redondeo Interna */
        .redondeo-mini-bar {
            display: flex;
            gap: 0.15rem;
            margin-top: 0.25rem;
            padding-top: 0.25rem;
            border-top: 1px solid var(--secundary-color2);
        }

        .dia-totales {
            font-size: 0.5rem;
            margin-top: 0.4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Footer de la semana */
        .semana-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.5rem;
            border-top: 1px solid var(--secundary-color2);
        }

        .semana-footer h4 {
            margin: 0;
            font-size: 0.85rem;
        }

        input.input-digito {
            padding: 0.15rem 0;
            border: 1px solid var(--secundary-color2);
            border-radius: 3px;
            font-size: 0.75rem;
            color: var(--text-main);
            outline: none;
            text-align: center;
            width: 26px !important;
            min-width: 26px !important;
            max-width: 26px !important;
            box-sizing: border-box;
        }

        input.input-digito:focus {
            border-color: var(--secundary-color);
            background-color: #fff;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        window.addEventListener('focus-nuevo-rango', event => {
            setTimeout(() => {
                const primerInput = document.getElementById(event.detail.id + '-1');
                if (primerInput) {
                    primerInput.focus();
                    primerInput.select();
                }
            }, 30);
        });
    </script>
@endsection