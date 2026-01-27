@extends('vistas.view.layouts.blank')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* ================= VARIABLES DE PRODUCCIÓN ================= */
        :root {
            --orange: #FB8500;
            --bg-body: #f1f3f4;
            --white: #ffffff;
            --text-main: #023047;
            --text-muted: #64748b;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-hero: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            --bg-gradient: linear-gradient(180deg, #073b4c 64%, #184d5e 77%, #219ebc 100%);

            --primary-color: #023047;
            --secundary-color: #219EBC;
            --secundary-color2: #CDD6DA;
            --terciary-color: #8ECAE6;
            --terciary-color2: #FB8500;
            --bg-color: #fff;
            --transition: all 0.3s ease;
            --secondary-text-color: #cbd5e1;
            --main-text-color: #f3f4f6;
            --bg-gradient: linear-gradient(180deg,
                    rgba(7, 59, 76, 1) 64%,
                    rgba(24, 77, 94, 1) 77%,
                    rgba(33, 158, 188, 1) 100%);
            /*  */
        }

        /* ================= RESET & BASICS ================= */
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
            display: none;
        }

        /* ================= HEADER & SEARCH (TU BASE) ================= */
        header {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        @media (min-width: 768px) {
            header {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .header-info h1 {
            font-size: 1.8rem;
            font-weight: 900;
            letter-spacing: -0.05em;
            text-transform: uppercase;
        }

        .header-info p {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
            max-width: 360px;
        }

        .search-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 1.2rem;
            background: var(--white);
            font-size: 0.8rem;
            font-weight: 800;
            outline: none;
            transition: var(--transition);
            box-shadow: 0 8px 20px rgba(2, 48, 71, 0.06);
        }

        .search-input:focus {
            border-color: rgba(33, 158, 188, 0.7);
            box-shadow: 0 12px 30px rgba(33, 158, 188, 0.12);
        }

        .search-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.2rem;
            height: 1.2rem;
            color: #94a3b8;
        }

        /* ================= NUEVO: CATEGORÍAS (PILLS) ================= */
        .category-bar {
            display: flex;
            align-items: center;
            gap: 0.6rem;
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
            padding: 0.55rem 1rem;
            border-radius: 999px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.62rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            white-space: nowrap;
            box-shadow: 0 8px 16px rgba(2, 48, 71, 0.04);
        }

        .pill:hover {
            transform: translateY(-1px);
            border-color: rgba(33, 158, 188, 0.55);
        }

        .pill.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        /* ================= NUEVO: GROUP HEADERS ================= */
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
            font-size: 0.62rem;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.32em;
            white-space: nowrap;
        }

        .section-divider {
            height: 1px;
            flex: 1;
            background: #eaeef3;
        }

        /* ================= NUEVO: SUBJECT GRID + CARDS COMPACTAS ================= */
        .subject-grid {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;

            /* 3 filas visibles */
            height: calc(5 * 78px);
            gap: 0.7rem;

            overflow-x: auto;
            overflow-y: hidden;

            align-content: flex-start;
            scrollbar-width: none;
        }

        /* @media (max-width: 640px) {
                                                .subject-grid {
                                                    grid-template-columns: repeat(2, 1fr);
                                                }
                                                .subject-card-btn {
                                                    width: 100%;
                                                    flex-direction: column;
                                                    justify-content: center;
                                                }
                                                .subject-meta {
                                                    text-align: center;
                                                }
                                                
                                            } */

        /* @media (min-width: 1024px) {
                        .subject-grid {
                            grid-template-columns: repeat(5, 1fr);
                        }
                    } */

        .subject-card-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            padding: 1rem;
            border-radius: 1.4rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 10px 22px rgba(2, 48, 71, 0.06);
            cursor: pointer;
            text-align: left;
            transition: var(--transition);
        }

        .subject-card-btn:hover {
            border-color: rgba(33, 158, 188, 0.55);
            transform: translateY(-3px);
            box-shadow: 0 16px 34px rgba(33, 158, 188, 0.10);
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
            background: rgba(33, 158, 188, 0.98);
            color: #fff;
        }

        .subject-meta {
            min-width: 0;
            overflow: hidden;
        }

        .subject-title {
            font-size: 0.9rem;
            font-weight: 900;
            color: var(--primary-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .subject-category {
            font-size: 0.62rem;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 0.15rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .subject-card-btn:hover .subject-icon {
            border-color: var(--terciary-color2);
            background: var(--white);
            color: var(--terciary-color2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        /* ================= RADAR SUPER PRO (FULL VIEW) ================= */
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
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        /* Cuando ya hay resultados, el radar deja de ser pantalla completa */
        .radar-section.results-found {
            height: auto;
            min-height: 220px;
            /* puedes bajar a 160px si quieres */
            padding: 2rem 1rem 1.5rem;
            background: transparent;
            /* opcional: quita el fondo radial */
        }


        .radar-section.fade-out {
            opacity: 0;
            pointer-events: none;
            transform: translateY(-50px);
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
            animation: ripple-animation 3s infinite cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .ripple-2 {
            animation-delay: 1.5s;
        }

        @keyframes ripple-animation {
            0% {
                transform: scale(0.3);
                opacity: 0.8;
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
            background: conic-gradient(from 180deg at 0% 100%, rgba(33, 158, 188, 0.3) 0deg, transparent 90deg);
            transform-origin: bottom left;
            animation: radar-sweep 2s linear infinite;
            border-left: 2px solid var(--secundary-color);
        }

        @keyframes radar-sweep {
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
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
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
            letter-spacing: -0.02em;
            color: var(--primary-color);
        }

        .subject-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 1.2rem;
            background: var(--white);
            border-radius: 999px;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .ping {
            width: 0.6rem;
            height: 0.6rem;
            background: var(--orange);
            border-radius: 50%;
            animation: pulse-ping 1.4s infinite;
        }

        @keyframes pulse-ping {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.6);
                opacity: 0.4;
            }
        }

        .is-hidden {
            display: none !important;
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
            padding: 1.8rem 1.8rem 1px;
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
            font-size: 1.8rem;
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
            margin-top: .8rem;
            border-radius: .9rem;
            padding: .8rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: left;
            font-size: .75rem;
            color: var(--text-muted);
        }

        /* ================= FAB SELECCIÓN TUTORÍA ================= */
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
            animation:
                tutoriaFadeUp .5s ease-out,
                tutoriaPulse 1.8s infinite;
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

        /* ================= SELECCIÓN DE MATERIA ================= */
        .subject-card-btn.is-selected {
            border-color: var(--terciary-color2);
            box-shadow: 0 18px 38px rgba(251, 133, 0, .25);
        }

        .subject-card-btn.is-selected .subject-initial {
            background: var(--terciary-color2);
            color: #fff;
        }
    </style>
    <section>

        <button class="tutoria-fab" id="tutoriaFab" onclick="confirmarMateria()">
            Go!
        </button>
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
                <!-- NUEVO: Pills de categoría -->
                <div class="category-bar" id="category-bar"></div>

                <!-- NUEVO: Secciones agrupadas -->
                <div class="subject-sections" id="subject-sections"></div>

                <!-- NUEVO: Empty state -->
                <div class="empty-state hidden" id="empty-state">
                    <div class="icon">🔍</div>
                    <h3>No hay coincidencias</h3>
                    <p>Prueba con otro término o cambia el área.</p>
                </div>
            </div>

            <!-- VISTA 2: RADAR INMERSIVO -->
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
                    </div>
                </div>

                <!-- RESULTADOS -->
                <div class="container">
                    <div id="tutor-results" class="tutor-grid"></div>
                </div>
            </div>
        </div>
    </section>
    <script>
        let categories = ['Todas'];
        let subjects = [];

        /* ================== DATA (materias) ================== */
        async function loadCategoriasMaterias() {
            const url = '/student/subject-groups/categorias-materias';

            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            // Log básico
            console.log('GET', url, 'status:', res.status, 'redirected:', res.redirected, 'finalURL:', res.url);

            const ct = (res.headers.get('content-type') || '').toLowerCase();

            // Si no es JSON, lee como texto y muéstralo (aquí normalmente verás el login HTML)
            if (!ct.includes('application/json')) {
                const text = await res.text();
                console.error('Respuesta NO JSON. Content-Type:', ct);
                console.error('Respuesta (primeros 300 chars):', text.slice(0, 300));
                return;
            }

            const json = await res.json();
            const data = Array.isArray(json.data) ? json.data : [];

            console.log('categoriasMaterias data.length:', data.length);

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

            console.log('subjects.length:', subjects.length);
        }



        const allTutors = [{
                id: 99,
                name: 'Ronald Laravé',
                subject: 'PROGRAMACIÓN',
                degree: 'Full Stack Developer',
                price: 45,
                rating: 5.0,
                img: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300'
            },
            {
                id: 100,
                name: 'Andrés Vera',
                subject: 'FÍSICA',
                degree: 'Ingeniero Físico',
                price: 28,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300'
            },
            {
                id: 101,
                name: 'Sofía Martínez',
                subject: 'MATEMÁTICAS',
                degree: 'PhD en Matemáticas',
                price: 25,
                rating: 4.8,
                img: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300'
            },
            {
                id: 102,
                name: 'Elena Peña',
                subject: 'FÍSICA',
                degree: 'Física Pura',
                price: 30,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300'
            },
            {
                id: 103,
                name: 'Ronald Laravé',
                subject: 'PROGRAMACIÓN',
                degree: 'Laravel Architect',
                price: 45,
                rating: 5.0,
                img: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300'
            },
            {
                id: 104,
                name: 'Andrés Vera',
                subject: 'DISEÑO UX/UI',
                degree: 'Lead UX Designer',
                price: 28,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300'
            },
            {
                id: 105,
                name: 'Andrés Vera',
                subject: 'MATEMÁTICAS',
                degree: 'Matemáticas Discretas',
                price: 28,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300'
            },
            {
                id: 106,
                name: 'Sofía Martínez',
                subject: 'FÍSICA',
                degree: 'Física Cuántica',
                price: 25,
                rating: 4.8,
                img: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300'
            },
            {
                id: 107,
                name: 'Elena Peña',
                subject: 'PROGRAMACIÓN',
                degree: 'Desarrolladora Full Stack',
                price: 30,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300'
            },
            {
                id: 108,
                name: 'Ronald Laravé',
                subject: 'DISEÑO UX/UI',
                degree: 'UI Specialist',
                price: 45,
                rating: 5.0,
                img: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300'
            },
            {
                id: 109,
                name: 'Andrés Vera',
                subject: 'PROGRAMACIÓN',
                degree: 'Cyber Seguridad',
                price: 28,
                rating: 4.9,
                img: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300'
            },
            {
                id: 110,
                name: 'Sofía Martínez',
                subject: 'PROGRAMACIÓN',
                degree: 'PhD en Matemáticas',
                price: 25,
                rating: 4.8,
                img: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300'
            }
        ];

        let state = {
            activeHeroId: null,
            selectedCategory: 'Todas',
            searchQuery: ''
        };

        const fab = document.getElementById('tutoriaFab');
        async function init() {
            wireSearch();
            await loadCategoriasMaterias();
            renderCategoryPills();
            renderSubjectSections();
        }

        function wireSearch() {
            const input = document.getElementById('search-input');
            input.addEventListener('input', (e) => {
                state.searchQuery = (e.target.value || '').trim();
                renderSubjectSections();
            });
        }

        /* ================== UI: CATEGORY PILLS ================== */
        function renderCategoryPills() {
            const bar = document.getElementById('category-bar');
            bar.innerHTML = categories.map(cat => `
      <button class="pill ${state.selectedCategory === cat ? 'active' : ''}"
              onclick="setCategory('${cat}')">
        ${cat}
      </button>
    `).join('');
        }

        function setCategory(cat) {
            state.selectedCategory = cat;
            renderCategoryPills();
            renderSubjectSections();
        }

        /* ================== FILTER + GROUP ================== */
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

        /* ================== UI: SUBJECT SECTIONS (AGRUPADAS) ================== */
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
                                                              <button class="subject-card-btn" onclick="seleccionarMateria(this, ${sub.id}, '${sub.name}')">
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

        /* ================== TU FLOW: SELECT SUBJECT ================== */
        async function postJson(url, payload) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload),
            });

            const json = await res.json().catch(() => ({}));

            if (!res.ok) {
                const msg = json?.message || `HTTP ${res.status}`;
                throw new Error(msg);
            }

            return json;
        }

        /**
         * ✅ Ahora SOLO inicia el batch (notifica tutores por correo)
         * y deja el radar como pantalla de "espera".
         */
        async function selectSubject(subjectName, subjectId) {
            ocultarFabTutoria();

            // 1) UI: cambiar a vista radar
            document.getElementById('selected-subject-name').innerText = subjectName;
            document.getElementById('view-selection').classList.add('hidden');
            document.getElementById('view-browse').classList.remove('hidden');

            document.body.classList.add('lock-scroll');

            // 2) UI: reset radar / mensajes
            const radar = document.getElementById('radar-ui');
            const status = document.getElementById('status-message');
            const radarVisual = document.getElementById('radar-visual');
            const grid = document.getElementById('tutor-results');

            // No mostrar cards por ahora
            if (grid) grid.innerHTML = '';

            if (radar) radar.classList.remove('results-found');
            if (radarVisual) radarVisual.classList.remove('is-hidden');
            if (status) status.innerText = 'Notificando a los expertos...';

            try {
                // 3) ✅ Llamar al backend para iniciar notificación / batch
                // OJO: usa tu ruta real: /batches/start (según tu routes)
                const json = await postJson('/batches/start', {
                    subject_id: subjectId
                });

                // 4) UI: mostrar mensaje de éxito (sin cards)
                // Si el backend te devuelve batch_id, guárdalo por si luego consultas status.
                // Ej: json.data.batch_id (depende de tu backend)
                const batchId = json?.data?.batch_id || json?.batch_id || null;

                if (status) {
                    status.innerText = batchId ?
                        `Solicitud enviada. Notificando tutores (Batch #${batchId})...` :
                        `Solicitud enviada. Notificando tutores...`;
                }

                // Opcional: bajar radar a tamaño "pequeño" (como modo resultados)
                // aunque todavía no haya cards, solo para que no sea full screen.
                if (radar) radar.classList.add('results-found');
                if (radarVisual) radarVisual.classList.add('is-hidden');

                // Desbloquear scroll ya que ya no necesitas bloquear
                document.body.classList.remove('lock-scroll');

                // Si quieres, muestra un texto placeholder donde irían tutores
                if (grid) {
                    grid.innerHTML = `
        <div style="padding:2rem; text-align:center; color: var(--text-muted); font-weight:800;">
          Estamos contactando tutores disponibles para
          <span style="color:var(--primary-color)">${subjectName}</span>.
          <div style="margin-top:.7rem; font-size:.85rem; opacity:.85; font-weight:700;">
            En breve verás opciones aquí.
          </div>
        </div>
      `;
                    grid.classList.add('active');
                }

            } catch (err) {
                console.error(err);

                if (status) status.innerText = 'No se pudo iniciar la solicitud.';
                if (grid) {
                    grid.innerHTML = `
        <div style="padding:2rem; text-align:center; color: var(--text-muted); font-weight:800;">
          Ocurrió un error al notificar tutores.
          <div style="margin-top:.6rem; font-size:.85rem; opacity:.85;">
            ${String(err.message)}
          </div>
        </div>
      `;
                    grid.classList.add('active');
                }

                document.body.classList.remove('lock-scroll');
            }
        }


        function renderTutors(subjectName) {
            const grid = document.getElementById('tutor-results');

            const list = allTutors.filter(t => t.subject === subjectName);

            grid.innerHTML = list.length ?
                list.map(t => `
        <div class="tutor-card-wrapper">
          <div class="tutor-card" id="hero-${t.id}">
            <div class="card-face card-face-front">
              <div class="card-header">
                <span class="badge">${t.subject}</span>
                <span class="rating">★ ${t.rating}</span>
              </div>
              <div class="avatar-wrapper">
                <div class="avatar-halo"></div>
                <div class="avatar-container">
                  <img class="avatar" src="${t.img}" alt="${t.name}">
                  <span class="verified">
                    <svg viewBox="0 0 24 24" class="verified-icon">
                      <path d="M12 2l4 2 4 .6 1.4 4L22 12l-1.6 3.4L20 19l-4 .6-4 2-4-2-4-.6L3.6 15.4 2 12l1.4-3.4L4 4.6l4-.6 4-2z"/>
                      <path d="M9.5 12.5l1.7 1.7 3.8-3.8"/>
                    </svg>
                  </span>
                </div>
              </div>
              <div class="card-body">
                <h3>${t.name}</h3>
                <p style="font-size:0.8rem; color:var(--text-muted);">${t.degree}</p>
                <div class="card-footer">
                  <div style="text-align:left;">
                    <small>PRECIO/H</small>
                    <div class="price">$${t.price}</div>
                  </div>
                  <button class="btn" onclick="openHero('${t.id}')">
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
                  <img src="${t.img}">
                  <div>
                    <h4 style="font-size:0.8rem;">${t.name}</h4>
                    <span style="font-size:0.6rem; color:var(--secundary-color);">
                      Conexión Segura
                    </span>
                  </div>
                </div>

                <div class="qr-wrapper">
                  <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=Pay-${t.id}">
                </div>

                <div class="upload-field">
                    <label>Comprobante de pago</label>

                    <input
                        type="file"
                        class="real-file-input"
                        accept="image/*,application/pdf"
                        onchange="handleReceiptUpload(event, '${t.id}')"
                        hidden
                    >

                    <div class="custom-file-input" onclick="triggerReceiptPicker(this)">
                        <span class="file-label">Adjuntar captura o PDF...</span>
                    </div>

                    <div class="receipt-preview hidden"></div>
                </div>


                <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                  <span style="font-size:0.65rem; font-weight:800; color:var(--text-muted);">TOTAL</span>
                  <div style="font-size:1.6rem; font-weight:900;">$${t.price}.00</div>
                </div>

                <button class="btn-pay" onclick="finishPayment(this)">PAGAR AHORA</button>
              </div>

              <button class="btn-cancel" onclick="closeHero()">REGRESAR</button>

              <div class="payment-success hidden" id="payment-success">
                <div style="font-size:3rem;">✅</div>
                <h2 style="margin-top:1rem;">Pago exitoso</h2>
                <p style="font-size:0.75rem; color:var(--text-muted);">
                  Redirigiendo a la tutoría...
                </p>
              </div>
            </div>

          </div>
        </div>
      `).join('') :
                `<div style="padding:2rem; text-align:center; color: var(--text-muted); font-weight:800;">
          No hay tutores disponibles para <span style="color:var(--primary-color)">${subjectName}</span> por ahora.
        </div>`;
        }

        // ✅ CENTRADO + FLIP (sin blur)
        function openHero(id) {
            if (state.activeHeroId && state.activeHeroId !== id) closeHero(true);

            state.activeHeroId = id;

            const grid = document.getElementById('tutor-results');
            const card = document.getElementById(`hero-${id}`);

            grid.classList.add('hide-others');
            card.classList.add('is-active');
            document.body.classList.add('lock-scroll');

            requestAnimationFrame(() => {
                setTimeout(() => {
                    card.classList.add('is-flipped');
                }, 520);
            });
        }

        function closeHero(skipAnimation = false) {
            if (!state.activeHeroId) return;

            const grid = document.getElementById('tutor-results');
            const card = document.getElementById(`hero-${state.activeHeroId}`);

            card.classList.remove('is-flipped');

            const finish = () => {
                card.classList.remove('is-active');
                grid.classList.remove('hide-others');
                document.body.classList.remove('lock-scroll');
                state.activeHeroId = null;
            };

            if (skipAnimation) return finish();
            setTimeout(finish, 420);
        }

        function finishPayment(btn) {

            // 1️⃣ Obtener la card correcta (sin usar state)
            const card = btn.closest('.tutor-card');
            if (!card) {
                console.error('No se encontró la tarjeta del tutor');
                return;
            }

            // 2️⃣ Obtener el ID real del tutor
            const heroId = card.id.replace('hero-', '');

            // 3️⃣ Buscar elementos dentro de ESA card
            const wrapper = card.querySelector('.upload-field');
            const label = wrapper.querySelector('.file-label');

            // 4️⃣ Validar comprobante
            if (!state.receipts || !state.receipts[heroId]) {
                label.textContent = 'Debes ingresar comprobante';
                label.style.color = 'red';
                return;
            }

            // Restaurar color si ya estaba correcto
            label.style.color = '';

            // 5️⃣ Ocultar todo el back excepto success
            const backFace = card.querySelector('.card-face-back');

            backFace.querySelectorAll(':scope > *').forEach(el => {
                el.classList.add('is-hidden');
            });

            // 6️⃣ Mostrar mensaje de éxito
            const success = card.querySelector('.payment-success');
            success.classList.remove('is-hidden');

            // 7️⃣ Redirección (aquí sí llega)
            setTimeout(() => {
                window.location.href = 'https://meet.google.com/egm-qjwq-kjh';
            }, 2500);
        }



        // ================== UPLOAD HANDLER ==================
        function triggerReceiptPicker(customEl) {
            // Busca el input file real dentro del mismo upload-field
            const wrapper = customEl.closest('.upload-field');
            const input = wrapper.querySelector('.real-file-input');
            if (input) input.click();
        }

        function handleReceiptUpload(event, tutorId) {
            const file = event.target.files?.[0];
            if (!file) return;

            const wrapper = event.target.closest('.upload-field');
            const label = wrapper.querySelector('.file-label');
            const preview = wrapper.querySelector('.receipt-preview');

            // Validación básica
            const isImage = file.type.startsWith('image/');
            const isPDF = file.type === 'application/pdf';

            if (!isImage && !isPDF) {
                label.textContent = 'Formato inválido. Sube imagen o PDF.';
                preview.classList.add('hidden');
                event.target.value = '';
                return;
            }
            // Restaurar color normal al subir archivo válido
            label.style.color = '';

            // Mostrar nombre del archivo
            label.textContent = file.name;

            // Guardar en memoria (por si luego lo mandas a backend)
            if (!state.receipts) state.receipts = {};
            state.receipts[tutorId] = file;
            //  Bloquear botón regresar
            const card = event.target.closest('.tutor-card');
            const backFace = card.querySelector('.card-face-back');
            const btnCancel = backFace.querySelector('.btn-cancel');
            btnCancel.style.opacity = '0.5';
            btnCancel.style.pointerEvents = 'none'; // desactiva clic
        }
        /* ================= SELECCIÓN ÚNICA DE MATERIA ================= */
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

        init();
    </script>
@endsection
