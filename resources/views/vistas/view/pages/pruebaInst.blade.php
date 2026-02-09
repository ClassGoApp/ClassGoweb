@extends('vistas.view.layouts.blank')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ================= VARIABLES (limpias, sin duplicados) ================= */
        :root {
            --orange: #FB8500;
            --bg-body: #f1f3f4;
            --white: #ffffff;
            --text-main: #023047;
            --text-muted: #64748b;
            --transition: all .35s cubic-bezier(.4, 0, .2, 1);
            --transition-hero: all .6s cubic-bezier(.34, 1.56, .64, 1);

            --primary-color: #023047;
            --secundary-color: #219EBC;
            --terciary-color: #8ECAE6;
            --terciary-color2: #FB8500;

            --bg-gradient: linear-gradient(180deg, rgba(7, 59, 76, 1) 64%, rgba(24, 77, 94, 1) 77%, rgba(33, 158, 188, 1) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.5;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .lock-scroll {
            overflow: hidden;
            height: 100vh;
        }

        .hidden {
            display: none !important;
        }

        /* ================= HEADER & SEARCH ================= */
        header {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }



        .header-info h1 {
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: -.05em;
            text-transform: uppercase;
        }

        .header-info p {
            font-size: .7rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .2em;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
            max-width: 360px;
        }

        .search-input {
            width: 100%;
            padding: .9rem 1rem .9rem 2.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 1.2rem;
            background: var(--white);
            font-size: .8rem;
            font-weight: 800;
            outline: none;
            transition: var(--transition);
            box-shadow: 0 8px 20px rgba(2, 48, 71, .06);
        }

        .search-input:focus {
            border-color: rgba(33, 158, 188, .7);
            box-shadow: 0 12px 30px rgba(33, 158, 188, .12);
        }

        .search-icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.2rem;
            height: 1.2rem;
            color: #94a3b8;
        }

        /* ================= CATEGORÍAS (PILLS) ================= */
        .category-bar {
            display: flex;
            align-items: center;
            gap: .6rem;
            overflow-x: auto;
            padding: 1rem 0 1rem;
            margin-bottom: 1rem;
            scrollbar-width: none;
        }

        .category-bar::-webkit-scrollbar {
            display: none;
        }

        .pill {
            appearance: none;
            border: 1px solid #e2e8f0;
            background: var(--white);
            color: #64748b;
            padding: .55rem 1rem;
            border-radius: 999px;
            cursor: pointer;
            transition: var(--transition);
            font-size: .62rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .18em;
            white-space: nowrap;
            box-shadow: 0 8px 16px rgba(2, 48, 71, .04);
        }

        .pill:hover {
            transform: translateY(-1px);
            border-color: rgba(33, 158, 188, .55);
        }

        .pill.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        /* ================= GROUP HEADERS ================= */
        .subject-sections {
            padding-bottom: 2rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.8rem 0 1rem;
        }

        .section-header h3 {
            font-size: .62rem;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .32em;
            white-space: nowrap;
        }

        .section-divider {
            height: 1px;
            flex: 1;
            background: #eaeef3;
        }

        /* ================= SUBJECT GRID ================= */
        .subject-grid {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            height: calc(5 * 78px);
            gap: .7rem;
            overflow-x: auto;
            overflow-y: hidden;
            align-content: flex-start;
            scrollbar-width: none;
        }

        .subject-grid::-webkit-scrollbar {
            display: none;
        }

        .subject-card-btn {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: var(--white);
            padding: 1rem;
            border-radius: 1.4rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 22px rgba(2, 48, 71, .06);
            cursor: pointer;
            text-align: left;
            transition: var(--transition);
        }

        .subject-card-btn:hover {
            border-color: rgba(33, 158, 188, .55);
            box-shadow: 0 16px 34px rgba(33, 158, 188, .10);
        }

        .subject-initial {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 1000;
            color: var(--primary-color);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .subject-card-btn:hover .subject-initial {
            background: rgba(33, 158, 188, .98);
            color: #fff;
        }

        .subject-meta {
            min-width: 0;
            overflow: hidden;
        }

        .subject-title {
            font-size: .9rem;
            font-weight: 900;
            color: var(--primary-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .subject-card-btn.is-selected {
            border-color: var(--terciary-color2);
            box-shadow: 0 18px 38px rgba(251, 133, 0, .25);
        }

        .subject-card-btn.is-selected .subject-initial {
            background: var(--terciary-color2);
            color: #fff;
        }

        /* ================= RADAR ================= */
        #view-browse {
            position: relative;
            width: 100%;
        }

        .radar-section {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle, #f1f3f4 0%, #e2e8f0 100%);
            transition: opacity .8s ease, transform .8s ease;
        }

        .radar-section.results-found {
            height: auto;
            min-height: 220px;
            padding: 2rem 1rem 1.5rem;
            background: transparent;
        }

        .radar-visual-container {
            position: relative;
            width: 320px;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radar-ripple {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid var(--secundary-color);
            border-radius: 50%;
            opacity: 0;
            animation: ripple 3s infinite cubic-bezier(.25, .46, .45, .94);
        }

        .ripple-2 {
            animation-delay: 1.5s;
        }

        @keyframes ripple {
            0% {
                transform: scale(.3);
                opacity: .8;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        .radar-sweep {
            position: absolute;
            width: 50%;
            height: 50%;
            top: 0;
            left: 50%;
            background: conic-gradient(from 180deg at 0% 100%, rgba(33, 158, 188, .3) 0deg, transparent 90deg);
            transform-origin: bottom left;
            animation: sweep 2s linear infinite;
            border-left: 2px solid var(--secundary-color);
        }

        @keyframes sweep {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .radar-center {
            position: relative;
            z-index: 10;
            width: 6rem;
            height: 6rem;
            background: var(--white);
            border-radius: 50%;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            border: 4px solid var(--bg-body);
        }

        .status-header {
            text-align: center;
            margin-top: 2rem;
        }

        .status-header h2 {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -.02em;
            color: var(--primary-color);
        }

        .subject-badge {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .5rem 1.2rem;
            background: var(--white);
            border-radius: 999px;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
        }

        .ping {
            width: .6rem;
            height: .6rem;
            background: var(--orange);
            border-radius: 50%;
            animation: pulse 1.4s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.6);
                opacity: .4;
            }
        }

        /* ================= TUTOR RESULTS (aceptados) ================= */
        .tutor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1rem;
            width: 100%;
            padding: 2rem 0;
        }

        .accept-card {
            border: 1px solid #e5e7eb;
            border-radius: 1.4rem;
            background: #fff;
            padding: 1rem;
            box-shadow: 0 10px 22px rgba(2, 48, 71, .06);
        }

        .accept-row {
            display: flex;
            gap: .8rem;
            align-items: center;
        }

        .accept-avatar {
            width: 56px;
            height: 56px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            flex: 0 0 auto;
        }

        .accept-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .accept-name {
            font-weight: 900;
            color: var(--primary-color);
        }

        .accept-meta {
            font-size: .8rem;
            color: var(--text-muted);
            margin-top: .2rem;
            line-height: 1.3;
        }

        .accept-btn {
            margin-top: .8rem;
            width: 100%;
            padding: .9rem 1rem;
            border: none;
            border-radius: 1rem;
            background: var(--primary-color);
            color: #fff;
            font-weight: 900;
            cursor: pointer;
            transition: var(--transition);
        }

        .accept-btn:hover {
            background: var(--terciary-color2);
        }

        .small-pill {
            display: inline-flex;
            gap: .5rem;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: .35rem .8rem;
            background: #fff;
            font-size: .7rem;
            font-weight: 900;
            color: #64748b;
            margin-top: .8rem;
        }

        .expire-normal {}

        .expire-soon {
            color: #f59e0b;
        }

        .expire-dead {
            color: #ef4444;
        }

        @keyframes pulseWarn {

            0%,
            100% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.06)
            }
        }

        .expire-pulse {
            animation: pulseWarn .8s infinite;
        }

        /* ================= TUTOR GRID & HERO CARDS ================= */
        .tutor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            width: 100%;
            padding: 2rem 0;
            justify-items: center;
            opacity: 0;
            transform: translateY(30px);
            transition: var(--transition);
        }

        .tutor-grid.active {
            opacity: 1;
            transform: translateY(0);
        }

        .tutor-grid.hide-others .tutor-card-wrapper {
            opacity: 0;
            pointer-events: none;
            transform: scale(0.95);
            transition: 0.4s ease;
            display: none;
        }

        .tutor-grid.hide-others .tutor-card-wrapper:has(.is-active) {
            display: grid;
            opacity: 1;
            pointer-events: auto;
            transform: scale(1);
        }

        .tutor-card-wrapper {
            width: 280px;
            height: 480px;
            position: relative;
            perspective: 2000px;
        }

        .tutor-card {
            width: 100%;
            height: 100%;
            position: absolute;
            background: var(--white);
            border-radius: 1.7rem;
            transition: var(--transition-hero);
            transform-style: preserve-3d;
            z-index: 10;
        }

        /* CENTRADO ABSOLUTO SUPREMO */
        .tutor-card.is-active {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 280px;
            height: 490px;
            transform: translate(-50%, -50%);
            z-index: 90;
            margin: 0;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.4);
        }

        .tutor-card.is-flipped {
            transform: translate(-50%, -50%) rotateY(180deg);
        }

        .card-face {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            border-radius: 1.7rem;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            background: var(--white);
        }

        /* FRONT */
        .card-face-front {
            z-index: 2;
            transform: rotateY(0deg);
        }

        .card-header {
            height: 130px;
            background: var(--bg-gradient);
            position: relative;
        }

        .card-header::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(#fff 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.12;
        }

        .badge {
            position: absolute;
            top: 1rem;
            left: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            color: #f3f4f6;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .rating {
            position: absolute;
            top: 1rem;
            right: 1.2rem;
            background: rgba(0, 0, 0, 0.45);
            padding: 0.35rem 0.6rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 800;
            color: #f3f4f6;
        }

        .avatar-container {
            position: relative;
            width: 140px;
            height: 140px;
            z-index: 2;
        }

        .avatar-wrapper {
            position: relative;
            margin-top: -65px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 130px;
        }

        .avatar-halo {
            position: absolute;
            width: 180px;
            height: 180px;
            top: 50%;
            transform: translateY(-50%);
            background: radial-gradient(ellipse at center,
                    rgba(251, 133, 0, .95) 0%,
                    rgba(251, 133, 0, .95) 35%,
                    transparent 67%);
            z-index: 0;
        }

        .avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid var(--primary-color);
            object-fit: cover;
            transition: var(--transition);
        }

        .tutor-card:hover .avatar {
            transform: scale(1.05);
        }

        .verified {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 42px;
            height: 42px;
            background: var(--secundary-color);
            border-radius: 50%;
            border: 4px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .25);
        }

        .verified-icon {
            width: 22px;
            height: 22px;
        }

        .verified-icon path {
            fill: none;
            stroke: #fff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ================= BODY ================= */
        .card-body {
            padding: 1.8rem 1rem 1px;
            text-align: center;
        }

        .card-body h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .tutor-card:hover h3 {
            color: var(--terciary-color2);
        }

        .card-body p {
            color: #64748b;
            font-size: .9rem;
            margin-top: .4rem;
        }

        /* ================= FOOTER ================= */
        .card-footer {
            margin-top: 5rem;
            padding-top: 1.2rem;
            border-top: 1px solid #e5e7eb;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .price {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0f172a;
        }

        /* ================= BUTTON ================= */
        .btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: var(--primary-color);
            color: #fff;
            padding: 1rem 1.4rem;
            border: none;
            border-radius: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .bolt {
            width: 14px;
            height: 14px;
            fill: transparent;
            stroke: #fff;
            stroke-width: 2;
        }

        .tutor-card:hover .bolt {
            fill: #fff;
        }

        .btn:hover {
            background: var(--terciary-color2);
        }

        .btn:hover .bolt {
            fill: var(--primary-color);
            stroke: var(--primary-color);
        }

        /* BACK */
        .card-face-back {
            transform: rotateY(180deg);
            z-index: 1;
            padding: 1rem;
            justify-content: space-between;
            text-align: center;
            background: #ffffff;
        }

        .summary-box {
            background: #f8fafc;
            border-radius: 1rem;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-align: left;
            margin-bottom: 0.5rem;
        }

        .summary-box img {
            width: 3.2rem;
            height: 3.2rem;
            border-radius: 0.8rem;
            object-fit: cover;
        }

        .qr-wrapper img {
            width: 110px;
            height: 110px;
            margin: 0.8rem 0;
        }

        .upload-field {
            text-align: left;
            margin-bottom: 1.2rem;
        }

        .upload-field label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .custom-file-input {
            border-bottom: 1px solid #e2e8f0;
            padding: 0.4rem 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: var(--transition);
        }

        .custom-file-input:hover {
            border-color: var(--secondary);
        }

        .custom-file-input span {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        .btn-pay {
            width: 100%;
            padding: 1rem;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 0.8rem;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        .btn-cancel {
            background: none;
            border: none;
            font-size: 0.65rem;
            font-weight: 800;
            color: var(--text-muted);
            cursor: pointer;
            margin-top: 0.8rem;
            text-transform: uppercase;
        }

        .tutor-grid.prueba {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

        }

        .payment-success {
            display: flex;
            margin-top: 1rem;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            animation: fadeInScale .4s ease forwards;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .receipt-preview {
            border-radius: .9rem;
            padding: .1rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: left;
            font-size: .75rem;
            color: var(--text-muted);
            width: 20%;
        }

        @media(min-width:768px) {
            header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        @media(max-width:600px) {

            /* SECCIÓN RADAR */
            .radar-section {
                height: 100svh;
                /* mejor que 100vh en móviles */
                padding: 1.5rem 1rem;
                overflow: hidden;
            }

        }
    </style>

    <section>
        <button class="tutoria-fab" id="tutoriaFab" onclick="confirmarMateria()">Go!</button>

        <div id="app">
            <!-- VISTA 1: SELECCIÓN -->
            <div id="view-selection" class="container">
                <header>
                    <div class="header-info">
                        <h1>¿Qué necesitas aprender hoy?</h1>
                        <p>Más de 600 materias con la que un tutor puede ayudarte ahora</p>
                    </div>
                    <div class="search-wrapper">
                        <svg class="search-icon" width="20" height="20" fill="none" stroke="currentColor"
                            stroke-width="2.5" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        <input type="text" id="search-input" class="search-input" placeholder="BUSCAR MATERIA...">
                    </div>
                </header>

                <div class="category-bar" id="category-bar"></div>
                <div class="subject-sections" id="subject-sections"></div>

                <div class="empty-state hidden" id="empty-state"
                    style="text-align:center;color:var(--text-muted);font-weight:900;padding:2rem;">
                    <div style="font-size:2rem;">🔍</div>
                    <h3 style="margin-top:.5rem;">No hay coincidencias</h3>
                    <p style="font-weight:800;">Prueba con otro término o cambia el área.</p>
                </div>
            </div>

            <!-- VISTA 2: RADAR + RESULTADOS -->
            <div id="view-browse" class="hidden">
                <div class="radar-section" id="radar-ui">
                    <div class="radar-visual-container" id="radar-visual">
                        <div class="radar-ripple"></div>
                        <div class="radar-ripple ripple-2"></div>
                        <div class="radar-sweep"></div>
                        <div class="radar-center">🎓</div>
                    </div>

                    <div class="status-header">
                        <h2 id="status-message">Notificando a los expertos...</h2>

                        <div class="subject-badge">
                            <div class="ping"></div>
                            <span id="selected-subject-name"></span>
                        </div>

                        <div class="small-pill">
                            Batch: <b id="wBatchId">-</b> · Estado: <b id="wStatus">-</b> · Expira: <b
                                id="wExpires">-</b>
                        </div>

                        <div class="small-pill">
                            Emails/min: <b id="ratePerMinLabel">-</b> · Enviados este minuto: <b id="sentThisMinLabel">0</b>
                            · Expira en: <b id="batchExpireCountdown" class="expire-normal">--:--</b>
                        </div>

                        <div id="waitMsg"
                            style="margin-top:.6rem;font-size:.85rem;color:var(--text-muted);font-weight:800;"></div>
                    </div>
                </div>

                <div class="container">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;">
                        <h3
                            style="font-size:.8rem;font-weight:1000;letter-spacing:.22em;color:#94a3b8;text-transform:uppercase;">
                            Tutores que aceptaron
                        </h3>
                        <button id="btnNewSearch" type="button" class="pill hidden"
                            style="letter-spacing:.14em;font-size:.6rem;">
                            Nueva solicitud
                        </button>
                    </div>

                    <div id="tutor-results" class="tutor-grid"></div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* FAB (del archivo 1) */
        .tutoria-fab {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 100px;
            height: 50px;
            border-radius: 4rem;
            border: none;
            background: var(--terciary-color2);
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transform: translateY(20px);
        }

        .tutoria-fab.visible {
            opacity: 1;
            pointer-events: auto;
            animation: tutoriaFadeUp .5s ease-out, tutoriaPulse 1.8s infinite;
        }

        @keyframes tutoriaFadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes tutoriaPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(251, 133, 0, .6);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 16px rgba(251, 133, 0, 0);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>

    <script>
        /* ========================================================================
      CLASSGO | Student - Instant Tutors Script
      ------------------------------------------------------------------------
      FLUJO:
      1) Cargar Categorías/Materias
      2) Seleccionar Materia (solo una) + mostrar FAB
      3) Crear Batch + mostrar Radar + polling:
          - status (cada 60s)
          - tutores aceptados (cada 5s)
          - countdown expiración (cada 1s)
      4) Mostrar cards de tutores + reservar + abrir checkout (flip)
      5) Subir comprobante + pagar + polling booking (cada 2.5s)
      6) Nueva solicitud / reset

      ENDPOINTS:
      - GET  /student/subject-groups/categorias-materias
      - POST /student/batches/start
      - GET  /student/batches/active
      - GET  /student/batches/{batchId}/status
      - GET  /student/batches/{batchId}/accepted-tutors?limit=50
      - POST /student/batches/{batchId}/reserve
      - POST /student/bookings/{bookingId}/receipt
      - GET  /student/bookings/{bookingId}/status
      - GET  /student/bookings/{bookingId}/meet

      NOTAS:
      - fetchAcceptedTutors() se pausa si state.activeHeroId existe (checkout abierto)
      - closeHero(true) debe existir en otro lado o aquí (si no, revienta)
    ======================================================================== */


        /* ========================================================================
          0) STATE GLOBAL + MEMORIA
        ======================================================================== */
        let categories = ['Todas'];
        let subjects = []; // {id, name, category, category_id}

        let state = {
            selectedCategory: 'Todas',
            searchQuery: '',
            receipts: {}, // heroId -> File
            activeHeroId: null, // heroId activo (checkout abierto)
        };

        // booking por item (heroId = item_id)
        let bookingByHeroId = new Map();

        // polling por booking (heroId -> interval)
        let bookingPollTimers = new Map();

        const fab = document.getElementById('tutoriaFab');


        /* ========================================================================
          1) API: CATEGORÍAS + MATERIAS
        ======================================================================== */
        async function loadCategoriasMaterias() {
            const url = '/student/subject-groups/categorias-materias';

            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const ct = (res.headers.get('content-type') || '').toLowerCase();
            if (!ct.includes('application/json')) {
                const text = await res.text();
                console.error('Respuesta NO JSON', ct, text.slice(0, 300));
                categories = ['Todas'];
                subjects = [];
                return;
            }

            const json = await res.json().catch(() => ({}));
            const data = Array.isArray(json.data) ? json.data : [];

            categories = ['Todas', ...data.map(x => x.categoria)];

            subjects = [];
            for (const cat of data) {
                const mats = Array.isArray(cat.materias) ? cat.materias : [];
                for (const m of mats) {
                    subjects.push({
                        id: Number(m.id_materia),
                        name: m.materia,
                        category: cat.categoria,
                        category_id: Number(cat.id_categoria),
                    });
                }
            }
        }


        /* ========================================================================
          2) UI: BUSCADOR + PILLS + SECCIONES
        ======================================================================== */
        function wireSearch() {
            const input = document.getElementById('search-input');
            input.addEventListener('input', (e) => {
                state.searchQuery = (e.target.value || '').trim();
                renderSubjectSections();
            });
        }

        function renderCategoryPills() {
            const bar = document.getElementById('category-bar');
            bar.innerHTML = categories.map(cat => `
    <button class="pill ${state.selectedCategory === cat ? 'active':''}"
            onclick="setCategory('${cat.replaceAll("'", "\\'")}')">
      ${cat}
    </button>
  `).join('');
        }

        function setCategory(cat) {
            state.selectedCategory = cat;
            renderCategoryPills();
            renderSubjectSections();
        }

        function getFilteredSubjects() {
            let filtered = [...subjects];

            if (state.selectedCategory !== 'Todas') {
                filtered = filtered.filter(s => s.category === state.selectedCategory);
            }

            if (state.searchQuery !== '') {
                const q = state.searchQuery.toLowerCase();
                filtered = filtered.filter(s => s.name.toLowerCase().includes(q));
            }

            return filtered;
        }

        function groupByCategory(items) {
            const groups = {};
            items.forEach(s => {
                if (!groups[s.category]) groups[s.category] = [];
                groups[s.category].push(s);
            });
            return groups;
        }

        function renderSubjectSections() {
            const sections = document.getElementById('subject-sections');
            const empty = document.getElementById('empty-state');
            const results = getFilteredSubjects();

            if (results.length === 0) {
                sections.innerHTML = '';
                empty.classList.remove('hidden');
                return;
            }

            empty.classList.add('hidden');

            const grouped = groupByCategory(results);

            const orderedCats = Object.keys(grouped).sort((a, b) => {
                const ia = categories.indexOf(a);
                const ib = categories.indexOf(b);
                if (ia === -1 && ib === -1) return a.localeCompare(b);
                if (ia === -1) return 1;
                if (ib === -1) return -1;
                return ia - ib;
            });

            sections.innerHTML = orderedCats.map(cat => {
                const items = grouped[cat];
                return `
      <section>
        <div class="section-header">
          <h3>${cat}</h3>
          <div class="section-divider"></div>
        </div>

        <div class="subject-grid">
          ${items.map(sub => `
                <button class="subject-card-btn"
                  onclick="seleccionarMateria(this, ${sub.id}, '${sub.name.replaceAll("'", "\\'")}')">
                  <div class="subject-initial">${sub.name.charAt(0)}</div>
                  <div class="subject-meta">
                    <div class="subject-title">${sub.name}</div>
                  </div>
                </button>
              `).join('')}
        </div>
      </section>
    `;
            }).join('');
        }


        /* ========================================================================
          3) SELECCIÓN ÚNICA + FAB
        ======================================================================== */
        let materiaSeleccionada = null;
        let materiaSeleccionadaId = null;
        let materiaSeleccionadaNombre = null;

        function seleccionarMateria(btn, id, nombre) {
            if (materiaSeleccionada) materiaSeleccionada.classList.remove('is-selected');

            btn.classList.add('is-selected');
            materiaSeleccionada = btn;

            materiaSeleccionadaId = id;
            materiaSeleccionadaNombre = nombre;

            fab.classList.add('visible');
        }

        function ocultarFabTutoria() {
            fab.classList.remove('visible');
        }

        function confirmarMateria() {
            if (!materiaSeleccionadaId) return;
            selectSubject(materiaSeleccionadaNombre, materiaSeleccionadaId);
        }


        /* ========================================================================
          4) BATCH FLOW: POLLING + COUNTDOWN + RESUME
        ======================================================================== */
        let currentBatchId = null;

        // timers
        let pollTimer = null; // batch status cada 60s
        let acceptedTimer = null; // accepted tutors cada 5s
        let batchExpireTimer = null; // countdown cada 1s

        // accepted list
        let acceptedAfterId = 0; // (no usado ahora, pero lo dejas)
        let acceptedAfterAcceptedAt = ''; // (no usado ahora, pero lo dejas)
        let acceptedMap = new Map(); // tutorId -> tutorData

        // expiración
        let batchExpiresAtMs = null;

        // delta enviados
        let lastSentCount = null;

        // DOM refs (status panel)
        const statusMsg = document.getElementById('status-message');
        const wBatchId = document.getElementById('wBatchId');
        const wStatus = document.getElementById('wStatus');
        const wExpires = document.getElementById('wExpires');
        const ratePerMinLabel = document.getElementById('ratePerMinLabel');
        const sentThisMinLabel = document.getElementById('sentThisMinLabel');
        const batchExpireCountdownEl = document.getElementById('batchExpireCountdown');
        const waitMsg = document.getElementById('waitMsg');
        const btnNewSearch = document.getElementById('btnNewSearch');


        /* ========================================================================
          4.1) UTILS: escape + countdown format
        ======================================================================== */
        function escapeHtml(str) {
            return String(str ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        function fmtMMSS(totalSeconds) {
            const s = Math.max(0, Math.floor(totalSeconds));
            const m = String(Math.floor(s / 60)).padStart(2, '0');
            const r = String(s % 60).padStart(2, '0');
            return `${m}:${r}`;
        }


        /* ========================================================================
          4.2) UI: show/hide views
        ======================================================================== */
        function showRadar() {
            document.getElementById('view-selection').classList.add('hidden');
            document.getElementById('view-browse').classList.remove('hidden');
        }

        function showSelection() {
            document.getElementById('view-browse').classList.add('hidden');
            document.getElementById('view-selection').classList.remove('hidden');
            document.body.classList.remove('lock-scroll');
        }


        /* ========================================================================
          4.3) Countdown batch expiración
        ======================================================================== */
        function startBatchExpireCountdown() {
            if (batchExpireTimer) clearInterval(batchExpireTimer);

            batchExpireTimer = setInterval(() => {
                if (!batchExpireCountdownEl) return;

                if (!batchExpiresAtMs) {
                    batchExpireCountdownEl.textContent = '--:--';
                    batchExpireCountdownEl.classList.remove('expire-soon', 'expire-dead', 'expire-pulse');
                    batchExpireCountdownEl.classList.add('expire-normal');
                    return;
                }

                const diffSec = Math.ceil((batchExpiresAtMs - Date.now()) / 1000);

                if (diffSec <= 0) {
                    batchExpireCountdownEl.textContent = '00:00';
                    batchExpireCountdownEl.classList.remove('expire-normal', 'expire-soon');
                    batchExpireCountdownEl.classList.add('expire-dead', 'expire-pulse');
                    if (waitMsg) waitMsg.textContent = 'El batch expiró. Inicia una nueva solicitud.';
                    return;
                }

                batchExpireCountdownEl.textContent = fmtMMSS(diffSec);

                if (diffSec <= 30) {
                    batchExpireCountdownEl.classList.remove('expire-normal', 'expire-dead');
                    batchExpireCountdownEl.classList.add('expire-soon', 'expire-pulse');
                    if (waitMsg && !waitMsg.textContent) waitMsg.textContent = '⚠️ Expira pronto...';
                } else {
                    batchExpireCountdownEl.classList.remove('expire-soon', 'expire-dead', 'expire-pulse');
                    batchExpireCountdownEl.classList.add('expire-normal');
                    if (waitMsg && waitMsg.textContent === '⚠️ Expira pronto...') waitMsg.textContent = '';
                }
            }, 1000);
        }

        function stopBatchExpireCountdown() {
            if (batchExpireTimer) clearInterval(batchExpireTimer);
            batchExpireTimer = null;
            batchExpiresAtMs = null;
            if (batchExpireCountdownEl) batchExpireCountdownEl.textContent = '--:--';
        }


        /* ========================================================================
          4.4) Stop polling (limpieza global)
        ======================================================================== */
        function stopPollingAll() {
            if (pollTimer) clearInterval(pollTimer);
            pollTimer = null;

            if (acceptedTimer) clearInterval(acceptedTimer);
            acceptedTimer = null;

            stopBatchExpireCountdown();
        }


        /* ========================================================================
          4.5) Polling: Accepted Tutors (cada 5s)
        ======================================================================== */
        async function fetchAcceptedTutors(batchId) {
            if (state.activeHeroId) return; // pausar si hay un hero activo (checkout abierto)

            const res = await fetch(`/student/batches/${batchId}/accepted-tutors?limit=50`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (!res.ok) return;

            const data = Array.isArray(json.data) ? json.data : [];

            // ✅ REEMPLAZAR COMPLETO (no acumular)
            acceptedMap = new Map(data.map(row => [row.id, row]));

            renderAcceptedCards();
        }

        function startAcceptedPolling(batchId) {
            if (acceptedTimer) clearInterval(acceptedTimer);
            fetchAcceptedTutors(batchId);
            acceptedTimer = setInterval(() => fetchAcceptedTutors(batchId), 5000);
        }


        /* ========================================================================
          4.6) Polling: Batch Status (cada 60s)
        ======================================================================== */
        async function fetchBatchStatus(batchId) {
            const res = await fetch(`/student/batches/${batchId}/status`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (!res.ok) return;

            const batch = json.batch || {};
            const rate = (batch.batch_size !== undefined && batch.batch_size !== null) ? String(batch.batch_size) : '0';

            if (ratePerMinLabel) ratePerMinLabel.textContent = rate;
            if (wStatus) wStatus.textContent = batch.status ?? '-';
            if (wExpires) wExpires.textContent = batch.expires_at ?? '-';

            batchExpiresAtMs = Number(batch.expires_at_ms ?? null);
            if (!batchExpiresAtMs && batch.seconds_left != null) {
                batchExpiresAtMs = Date.now() + (Number(batch.seconds_left) * 1000);
            }

            // enviados este minuto (delta)
            const sentNow = Number(batch.sent_count ?? 0);
            let sentThisMin = '0';
            if (lastSentCount !== null) {
                sentThisMin = String(Math.max(0, sentNow - lastSentCount));
            }
            lastSentCount = sentNow;
            if (sentThisMinLabel) sentThisMinLabel.textContent = sentThisMin;

            const st = String(batch.status ?? '').toLowerCase();
            const secondsLeft = Number(batch.seconds_left ?? NaN);

            if (st === 'failed' || st === 'matched' || (Number.isFinite(secondsLeft) && secondsLeft <= 0)) {
                stopPollingAll();
                currentBatchId = null;
                if (btnNewSearch) btnNewSearch.classList.remove('hidden');
                if (waitMsg) waitMsg.textContent = 'La búsqueda terminó. Puedes iniciar una nueva solicitud.';
            }
        }


        /* ========================================================================
          4.7) Start polling (batch bootstrap)
        ======================================================================== */
        function startPolling(batchId) {
            currentBatchId = batchId;

            // reset deltas y accepted
            lastSentCount = null;
            acceptedAfterId = 0;
            acceptedAfterAcceptedAt = '';
            acceptedMap.clear();
            renderAcceptedCards();

            if (wBatchId) wBatchId.textContent = String(batchId);
            if (btnNewSearch) btnNewSearch.classList.add('hidden');
            if (waitMsg) waitMsg.textContent = '';

            startBatchExpireCountdown();
            startAcceptedPolling(batchId);

            // primer fetch inmediato
            fetchBatchStatus(batchId);

            // status cada 60s
            if (pollTimer) clearInterval(pollTimer);
            pollTimer = setInterval(() => fetchBatchStatus(batchId), 60000);
        }


        /* ========================================================================
          5) selectSubject: crea batch + startPolling
        ======================================================================== */
        async function selectSubject(subjectName, subjectId) {
            if (currentBatchId) {
                alert('Ya hay una búsqueda activa. Continúa la espera.');
                return;
            }
            if (!subjectId) {
                alert('Selecciona una materia primero.');
                return;
            }

            ocultarFabTutoria();
            fab.disabled = true;
            fab.style.opacity = '0.6';

            document.getElementById('selected-subject-name').innerText = subjectName;

            showRadar();
            if (statusMsg) statusMsg.innerText = 'Creando batch...';

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const res = await fetch('/student/batches/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...(csrf ? {
                            'X-CSRF-TOKEN': csrf
                        } : {}),
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        subject_id: subjectId
                    }),
                });

                const json = await res.json().catch(() => ({}));

                if (!res.ok) {
                    if (statusMsg) statusMsg.innerText = 'No se pudo iniciar la solicitud.';
                    alert('Error al iniciar batch: ' + (json.message ?? `HTTP ${res.status}`));
                    showSelection();
                    return;
                }

                const batchId = json.batch_id ?? json?.data?.batch_id ?? null;

                if (!batchId) {
                    if (statusMsg) statusMsg.innerText = 'Batch creado, pero no llegó batch_id.';
                    alert('Batch creado pero no llegó batch_id en respuesta.');
                    showSelection();
                    return;
                }

                if (statusMsg) statusMsg.innerText = `Solicitud enviada. Notificando tutores (Batch #${batchId})...`;
                startPolling(batchId);

            } catch (e) {
                console.error(e);
                if (statusMsg) statusMsg.innerText = 'Error JS al iniciar la solicitud.';
                alert('Error JS: ' + e.message);
                showSelection();
            } finally {
                fab.disabled = false;
                fab.style.opacity = '';
                document.body.classList.remove('lock-scroll');
            }
        }


        /* ========================================================================
          6) Reanudar batch si existe
        ======================================================================== */
        async function resumeActiveBatchIfAny() {
            try {
                const res = await fetch('/student/batches/active', {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                const json = await res.json().catch(() => ({}));
                if (!res.ok || !json.active || !json.batch_id) return false;

                showRadar();
                if (statusMsg) statusMsg.innerText = `Reanudando búsqueda activa (Batch #${json.batch_id})...`;
                if (wBatchId) wBatchId.textContent = String(json.batch_id);

                startPolling(json.batch_id);
                return true;
            } catch (e) {
                console.error('resumeActiveBatchIfAny error:', e);
                return false;
            }
        }


        /* ========================================================================
          7) UI + CARDS: Accepted Tutors + Hero Flip + Reservas
        ======================================================================== */
        function setReceiptError(heroId, on) {
            const card = document.getElementById(`hero-${heroId}`);
            if (!card) return;

            const label = card.querySelector('.file-label');
            const picker = card.querySelector('.custom-file-input');

            if (on) {
                if (label) {
                    label.style.color = '#ef4444';
                    label.style.fontWeight = '900';
                    label.textContent = '⚠️ Debes adjuntar el comprobante';
                }
                if (picker) {
                    picker.style.border = '2px solid #ef4444';
                }
            } else {
                if (label) {
                    label.style.color = '';
                    label.style.fontWeight = '';
                    if (!label.textContent || label.textContent.includes('⚠️')) {
                        label.textContent = 'Adjuntar captura o PDF...';
                    }
                }
                if (picker) {
                    picker.style.border = '';
                    picker.style.background = '';
                }
            }
        }

        function renderAcceptedCards() {
            const grid = document.getElementById('tutor-results');
            const items = Array.from(acceptedMap.values());

            if (!grid) return;
            grid.innerHTML = '';

            if (!items.length) {
                grid.innerHTML =
                    `<div style="padding:1.5rem;text-align:center;color:var(--text-muted);font-weight:900;">Aún nadie aceptó...</div>`;
                grid.classList.remove('active');
                return;
            }

            grid.classList.add('active');

            for (const t of items) {
                const name = escapeHtml(
                    t.name ||
                    `${t.first_name || ''} ${t.last_name || ''}`.trim() ||
                    'Tutor'
                );

                const rating = (t.rating !== null && t.rating !== undefined) ? escapeHtml(String(t.rating)) : '0.0';
                const verified = (Number(t.is_verified) === 1 || !!t.verified_at);

                const priceNum = t.price !== null && t.price !== undefined && String(t.price) !== '' ?
                    Number(t.price).toString() :
                    '0';

                const price = escapeHtml(priceNum);

                const degree = escapeHtml(t.degree || t.education || t.title || '');

                // imagen (URL absoluta si viene relativa)
                let img = '';
                if (t.image) {
                    const raw = String(t.image).replace(/^\/+/, '');
                    if (raw.startsWith('http')) img = raw;
                    else if (raw.startsWith('storage/')) img = '/' + raw;
                    else img = '/storage/' + raw; // profile_images/...
                }

                const id = escapeHtml(String(t.id));

                const wrapper = document.createElement('div');
                wrapper.className = 'tutor-card-wrapper';

                wrapper.innerHTML = `
      <div class="tutor-card" id="hero-${id}">
        <div class="card-face card-face-front">
          <div class="card-header">
            <span class="badge">${materiaSeleccionadaNombre}</span>
            <span class="rating">★ ${rating}</span>
          </div>

          <div class="avatar-wrapper">
            <div class="avatar-halo"></div>
            <div class="avatar-container">
              ${img ? `<img class="avatar" src="${escapeHtml(img)}" alt="${name}">` : ``}

              ${verified ? `
                    <span class="verified">
                      <svg viewBox="0 0 24 24" class="verified-icon">
                        <path d="M12 2l4 2 4 .6 1.4 4L22 12l-1.6 3.4L20 19l-4 .6-4 2-4-2-4-.6L3.6 15.4 2 12l1.4-3.4L4 4.6l4-.6 4-2z"/>
                        <path d="M9.5 12.5l1.7 1.7 3.8-3.8"/>
                      </svg>
                    </span>
                  ` : ``}
            </div>
          </div>

          <div class="card-body">
            <h3>${name}</h3>
            <p style="font-size:0.8rem; color:var(--text-muted);">${degree}</p>

            <div class="card-footer">
              <div style="text-align:left;">
                <small>PRECIO</small>
                <div class="price">${price} Bs</div>
              </div>

              <button class="btn" type="button" data-hero-open="${id}">
                SOLICITAR
                <svg class="bolt" viewBox="0 0 24 24">
                  <path d="M13 2L3 14h7l-1 8 10-12h-7z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="card-face card-face-back">
          <div class="checkout-content">
            <h2 style="font-size: 1rem; text-transform: uppercase; color:var(--primary-color);">
              Checkout Seguro
            </h2>

            <div class="summary-box">
              ${img ? `<img src="${escapeHtml(img)}">` : ``}
              <div>
                <h4 style="font-size:0.8rem;">${name}</h4>
                <span style="font-size:0.6rem; color:var(--secundary-color);">
                  Conexión Segura
                </span>
              </div>
            </div>

            <div class="qr-wrapper">
              <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=Pay-${id}">
            </div>

            <div class="upload-field">
              <label>Comprobante de pago</label>

              <input type="file" class="real-file-input"
                accept="image/*,application/pdf" hidden>

              <div class="custom-file-input">
                <div class="receipt-preview hidden"></div>
                <span class="file-label">Adjuntar captura o PDF...</span>
              </div>
            </div>

            <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
              <span style="font-size:0.65rem; font-weight:800; color:var(--text-muted);">TOTAL</span>
              <div style="font-size:1.6rem; font-weight:900;">${price} Bs</div>
            </div>

            <button class="btn-pay" type="button" data-pay="${id}">PAGAR AHORA</button>
          </div>

          <div class="payment-success hidden" id="payment-success-${id}">
            <div style="font-size:3rem;">✅</div>
            <h2 style="margin-top:1rem;">Pago exitoso</h2>
            <p style="font-size:0.75rem; color:var(--text-muted);">
              Redirigiendo a la tutoría...
            </p>
          </div>
        </div>
      </div>
    `;

                const openBtn = wrapper.querySelector('[data-hero-open]');
                const payBtn = wrapper.querySelector('[data-pay]');
                const fileInput = wrapper.querySelector('.real-file-input');
                const fakePicker = wrapper.querySelector('.custom-file-input');

                openBtn?.addEventListener('click', () => reserveTutorAndOpen(id));

                fakePicker?.addEventListener('click', () => {
                    setReceiptError(id, false);
                    fileInput?.click();
                });

                fileInput?.addEventListener('change', (ev) => {
                    handleReceiptUpload(ev, id);
                });

                payBtn?.addEventListener('click', () => finishPayment(payBtn, id));

                grid.appendChild(wrapper);
            }

            document.getElementById('radar-ui')?.classList.add('results-found');
        }

        function openHero(id) {
            if (state.activeHeroId && state.activeHeroId !== id) {
                closeHero(true); // ⚠️ Debe existir
            }

            state.activeHeroId = id;

            const grid = document.getElementById('tutor-results');
            const card = document.getElementById(`hero-${id}`);

            if (!grid || !card) {
                console.warn('No se encontró grid/card para hero', {
                    id,
                    grid,
                    card
                });
                return;
            }

            grid.classList.add('hide-others');
            document.body.classList.add('lock-scroll');

            card.classList.add('is-active');

            requestAnimationFrame(() => {
                setTimeout(() => {
                    card.classList.add('is-flipped');
                }, 60);
            });
        }

        async function reserveTutorAndOpen(heroId) {
            state.activeHeroId = String(heroId);

            if (!currentBatchId) {
                alert('No hay batch activo.');
                return;
            }

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const res = await fetch(`/student/batches/${currentBatchId}/reserve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    item_id: Number(heroId)
                })
            });

            const json = await res.json().catch(() => ({}));

            if (!res.ok || !json.success) {
                alert(json.message || `No se pudo reservar (HTTP ${res.status})`);
                return;
            }

            const bookingId = Number(json.booking_id || json.booking?.id || 0);
            if (!bookingId) {
                alert('Reservó pero no llegó booking_id.');
                return;
            }

            bookingByHeroId.set(String(heroId), bookingId);

            openHero(heroId);
        }


        /* ========================================================================
          8) (OPCIONAL) chooseTutor (no usado en este flujo)
        ======================================================================== */
        async function chooseTutor(itemId) {
            if (!currentBatchId) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const res = await fetch(`/student/batches/${currentBatchId}/choose`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    item_id: itemId
                })
            });

            const json = await res.json().catch(() => ({}));

            if (!res.ok) {
                alert(json.message || `No se pudo elegir (HTTP ${res.status})`);
                return;
            }

            stopPollingAll();
            if (waitMsg) waitMsg.textContent = 'Tutor elegido. Redirigiendo...';

            if (json.redirect_to) {
                window.location.href = json.redirect_to;
            } else {
                alert('Elegido, pero faltó redirect_to. Define tu ruta de pagos.');
            }
        }


        /* ========================================================================
          9) PAGOS: upload receipt + submit + polling booking
        ======================================================================== */
        function handleReceiptUpload(ev, heroId) {
            const file = ev?.target?.files?.[0];
            if (!file) return;

            state.receipts[String(heroId)] = file;

            const card = document.getElementById(`hero-${heroId}`);
            if (!card) return;

            const preview = card.querySelector('.receipt-preview');
            const label = card.querySelector('.file-label');

            if (label) label.textContent = file.name;
            if (!preview) return;

            preview.classList.remove('hidden');
            preview.innerHTML = '';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.style.width = '100%';
                img.style.borderRadius = '12px';
                img.style.border = '1px solid rgba(0,0,0,.08)';
                img.src = URL.createObjectURL(file);
                preview.appendChild(img);
            } else {
                preview.innerHTML =
                    `<div style="font-size:.75rem;color:var(--text-muted);font-weight:20px;">📄 ${escapeHtml(file.name)}</div>`;
            }

            setReceiptError(heroId, false);
        }

        async function finishPayment(btn, heroId) {
            const bookingId = bookingByHeroId.get(String(heroId));
            if (!bookingId) {
                alert('Primero debes SOLICITAR para generar la reserva.');
                return;
            }

            const file = state.receipts[String(heroId)];
            if (!file) {
                setReceiptError(heroId, true);
                document.getElementById(`hero-${heroId}`)
                    ?.querySelector('.upload-field')
                    ?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                return;
            }

            btn.disabled = true;
            btn.classList.add('sp-disabled');

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const fd = new FormData();
                fd.append('comprobante', file);

                const res = await fetch(`/student/bookings/${bookingId}/receipt`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        ...(csrf ? {
                            'X-CSRF-TOKEN': csrf
                        } : {}),
                    },
                    credentials: 'same-origin',
                    body: fd
                });

                const raw = await res.text();
                let json = {};
                try {
                    json = JSON.parse(raw);
                } catch {}

                if (!res.ok || !json.ok) {
                    const err =
                        json?.errors?.comprobante?.[0] ||
                        json?.message ||
                        `No se pudo subir (HTTP ${res.status})`;
                    alert(err);
                    return;
                }

                const okBox = document.getElementById(`payment-success-${heroId}`);
                if (okBox) okBox.classList.remove('hidden');

                const card = document.getElementById(`hero-${heroId}`);
                card?.querySelector('.checkout-content')?.classList.add('hidden');

                startStudentBookingPolling(bookingId, heroId);

            } finally {
                btn.disabled = false;
                btn.classList.remove('sp-disabled');
            }
        }

        function startStudentBookingPolling(bookingId, heroId) {
            const key = String(heroId);

            if (bookingPollTimers.has(key)) {
                clearInterval(bookingPollTimers.get(key));
                bookingPollTimers.delete(key);
            }

            const run = async () => {
                const res = await fetch(`/student/bookings/${bookingId}/status`, {
                    headers: {
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                const json = await res.json().catch(() => ({}));
                if (!res.ok || !json.ok) return;

                const ui = String(json.ui_state || 'payment_phase');

                if (ui === 'accepted') {
                    window.location.href = `/student/bookings/${bookingId}/meet`;
                    return;
                }

                if (ui === 'rejected') {
                    alert('El tutor rechazó el pago. Puedes elegir otro tutor si el batch sigue activo.');

                    closeHero(true); // ⚠️ Debe existir

                    bookingByHeroId.delete(String(heroId));
                    delete state.receipts[String(heroId)];

                    if (currentBatchId) fetchAcceptedTutors(currentBatchId);

                    if (bookingPollTimers.has(key)) {
                        clearInterval(bookingPollTimers.get(key));
                        bookingPollTimers.delete(key);
                    }
                }
            };

            run();
            const t = setInterval(run, 2500);
            bookingPollTimers.set(key, t);
        }


        /* ========================================================================
          10) BOTÓN: Nueva solicitud (reset total)
        ======================================================================== */
        btnNewSearch?.addEventListener('click', async () => {
            currentBatchId = null;
            stopPollingAll();

            document.getElementById('radar-ui')?.classList.remove('results-found');
            document.getElementById('tutor-results').innerHTML = '';

            materiaSeleccionada = null;
            materiaSeleccionadaId = null;
            materiaSeleccionadaNombre = null;
            ocultarFabTutoria();

            showSelection();
            await loadCategoriasMaterias();
            renderCategoryPills();
            renderSubjectSections();
        });


        /* ========================================================================
          11) INIT
        ======================================================================== */
        async function init() {
            wireSearch();
            const resumed = await resumeActiveBatchIfAny();

            if (!resumed) {
                await loadCategoriasMaterias();
                renderCategoryPills();
                renderSubjectSections();
            }
        }

        init();
    </script>
@endsection
