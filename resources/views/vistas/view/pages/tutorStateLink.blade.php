@extends('vistas.view.layouts.blank')
@section('content')
    <style>
        :root {
            --primary-color: #023047;
            --secundary-color: #219EBC;
            --secundary-color2: #CDD6DA;
            --terciary-color: #8ECAE6;
            --terciary-color2: #FB8500;
            --white: #ffffff;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-900: #0f172a;
            --emerald-400: #34d399;
            --error-color: #ef4444;
            --bg-gradient2: linear-gradient(135deg, #023047 0%, #219EBC 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--slate-100);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            min-height: 100vh;
        }

        .dashboard-card {
            width: 100%;
            max-width: 400px;
            background-color: var(--white);
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .15);
            overflow: hidden;
            border: 1px solid var(--slate-200);
        }

        .header {
            background: var(--bg-gradient2);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--white);
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .header-title {
            text-transform: uppercase;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .05em;
        }

        .content {
            padding: 2.5rem;
            text-align: center;
        }

        .state-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        .icon-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ping-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            animation: ping 2s cubic-bezier(0, 0, .2, 1) infinite;
            opacity: .2;
            pointer-events: none;
        }

        .glow-success {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            animation: breathe 3s ease-in-out infinite;
            opacity: .05;
            pointer-events: none;
            background-color: var(--terciary-color2);
        }

        .icon-bg {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        @keyframes breathe {

            0%,
            100% {
                transform: scale(1);
                opacity: .05;
            }

            50% {
                transform: scale(1.1);
                opacity: .1;
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes scan {

            0%,
            100% {
                transform: translate(-2px, -2px);
            }

            50% {
                transform: translate(4px, 4px);
            }
        }

        .animate-scan {
            animation: scan 3s ease-in-out infinite;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--primary-color);
            line-height: 1.2;
            margin-bottom: .5rem;
        }

        .description {
            color: var(--slate-500);
            font-size: .875rem;
            line-height: 1.5;
        }

        .status-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            font-size: .75rem;
            font-weight: 700;
            padding: .5rem 1.25rem;
            border-radius: 9999px;
            margin: 0 auto;
            width: fit-content;
        }

        .action-card {
            background: var(--bg-gradient2);
            color: var(--white);
            padding: 1.25rem;
            border-radius: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, .1);
            width: 100%;
        }

        @media (min-width: 380px) {
            .action-card {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .action-info {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-align: left;
        }

        .action-icon-box {
            padding: .5rem;
            background-color: rgba(255, 255, 255, .1);
            border-radius: .5rem;
            display: flex;
        }

        .action-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: .7;
        }

        .action-status {
            font-weight: 700;
            font-size: .875rem;
            color: var(--emerald-400);
        }

        .btn-action {
            background-color: var(--white);
            color: var(--primary-color);
            border: none;
            padding: .6rem 1.25rem;
            border-radius: .75rem;
            font-size: .875rem;
            font-weight: 900;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            transition: all .3s;
        }

        .btn-action:hover {
            background-color: var(--slate-50);
            transform: translateX(7px);
        }

        .hidden-state {
            display: none !important;
        }

        .fade-in {
            animation: fadeIn .6s ease-out forwards;
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

        .mock-container {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-mock {
            color: var(--slate-400);
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 700;
            background: none;
            border: none;
            text-decoration: underline;
            cursor: pointer;
        }

        .btn-mock:hover {
            color: var(--primary-color);
        }
    </style>

    <div class="dashboard-card">
        <header class="header">
            <div class="header-info">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="color: var(--terciary-color)">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                <span class="header-title">Tutoría Al Instante</span>
            </div>
        </header>

        <div class="content">

            <!-- ESTADO 1: choosing -->
            <div id="state-choosing" class="state-container fade-in">
                <div class="icon-wrapper">
                    <div class="ping-animation" style="background-color: var(--secundary-color)"></div>
                    <div class="icon-bg" style="background-color: #219EBC15">
                        <svg class="animate-scan" width="56" height="56" viewBox="0 0 24 24" fill="none"
                            stroke="var(--secundary-color)" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>

                <div class="text-block">
                    <h2 class="title">Buscando confirmación</h2>
                    <p class="description">El estudiante está revisando tu perfil. Por favor, mantente en línea para recibir
                        el pago.</p>
                </div>

                <div class="status-badge"
                    style="color: var(--secundary-color); background-color: #219EBC10; border: 1px solid #219EBC20">
                    <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                    </svg>
                    <span id="syncLabel">SINCRONIZANDO...</span>
                </div>

                <!-- 🔥 contador dentro del estado choosing -->
                <div style="margin-top:6px;opacity:.8;font-size:14px;">
                    Expira en: <span id="expiresAtText">{{ $expires_at ?? '-' }}</span><br>
                    Tiempo restante: <b id="tutorCountdown">--:--</b>
                    <span id="tutorWarn" style="display:none;margin-left:8px;font-weight:700;color:#f59e0b;">⚠️ Expira
                        pronto</span>
                </div>
            </div>

            <!-- ESTADO NUEVO: paying (elegido, esperando pago) -->
            <div id="state-paying" class="state-container hidden-state fade-in">
                <div class="icon-wrapper">
                    <div class="ping-animation" style="background-color: var(--terciary-color2)"></div>
                    <div class="icon-bg" style="background-color: #FB850015; border: 2px solid #FB850030">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                            stroke="var(--terciary-color2)" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 7l-8-4-8 4v10l8 4 8-4V7z"></path>
                            <path d="M12 22V12"></path>
                            <path d="M20 7l-8 5-8-5"></path>
                        </svg>
                    </div>
                </div>

                <div class="text-block">
                    <h2 class="title">¡Fuiste elegido!</h2>
                    <p class="description">El estudiante está realizando el pago. Mantente en línea, en breve podrás iniciar
                        la tutoría.</p>
                </div>

                <div class="status-badge"
                    style="color: var(--terciary-color2); background-color: #FB850010; border: 1px solid #FB850020">
                    <svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                    </svg>
                    <span>ESPERANDO COMPROBANTE...</span>
                </div>
            </div>

            <!-- ESTADO 2: paid (solo entrar al aula) -->
            <div id="state-paid" class="state-container hidden-state fade-in">
                <div class="icon-wrapper">
                    <div class="glow-success"></div>
                    <div class="icon-bg" style="background-color: #16a34a10; border: 2px solid #16a34a30">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                </div>

                <div class="text-block">
                    <h2 class="title">Tutoría lista</h2>
                    <p class="description">El estudiante ya completó el proceso. Puedes iniciar la clase ahora mismo.</p>
                </div>

                <div class="action-card">
                    <div class="action-info">
                        <div class="action-icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="5" rx="2" />
                                <line x1="2" x2="22" y1="10" y2="10" />
                            </svg>
                        </div>
                        <div>
                            <p class="action-label">CLASE</p>
                            <p class="action-status">Lista para iniciar</p>
                        </div>
                    </div>

                    <button id="btnGoMeet" class="btn-action" type="button">
                        Entrar al Aula
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>


            <!-- ESTADO 3: rejected -->
            <div id="state-rejected" class="state-container hidden-state fade-in">
                <div class="icon-wrapper">
                    <div class="icon-bg" style="background-color: #fee2e2; border: 2px solid #fecaca">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                            stroke="var(--error-color)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                </div>

                <div class="text-block">
                    <h2 class="title" style="color: var(--error-color)">Sesión no asignada</h2>
                    <p class="description">El estudiante ha optado por otro tutor para esta sesión. ¡Sigue atento a nuevas
                        solicitudes!</p>
                </div>

                <button class="btn-action" onclick="location.reload()"
                    style="background-color: var(--slate-100); color: var(--slate-900); width: 100%">
                    Volver al Inicio
                </button>
            </div>

            <!-- ESTADO 4: expired -->
            <div id="state-expired" class="state-container hidden-state fade-in">
                <div class="icon-wrapper">
                    <div class="icon-bg" style="background-color: #fee2e2; border: 2px solid #fecaca">
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                            stroke="var(--error-color)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                </div>

                <div class="text-block">
                    <h2 class="title" style="color: var(--error-color)">La solicitud ya expiró</h2>
                    <p class="description">El estudiante dejó de buscar tutor. Si vuelve a solicitar, te llegará otra
                        invitación.</p>
                </div>

                <button class="btn-action" onclick="location.reload()"
                    style="background-color: var(--slate-100); color: var(--slate-900); width: 100%">
                    Volver al Inicio
                </button>
            </div>



        </div>
    </div>


    <script>
        // ================== VARIABLES DESDE BACKEND (Blade) ==================
        const initialStatus = @json($status ?? 'choosing'); // choosing | payment_phase | accepted | rejected | expired

        const expiresAtMsRaw = @json($expires_at_ms ?? null);
        const secondsLeftRaw = @json($seconds_left ?? null);
        const meetLink = @json($meeting_link ?? null); // cuando accepted

        // ================== UI STATE ==================
        const STATES = ['choosing', 'paying', 'paid', 'rejected', 'expired'];

        function hideAllStates() {
            document.getElementById('state-choosing').classList.add('hidden-state');
            document.getElementById('state-paying').classList.add('hidden-state');
            document.getElementById('state-paid').classList.add('hidden-state');
            document.getElementById('state-rejected').classList.add('hidden-state');
            document.getElementById('state-expired').classList.add('hidden-state');
        }



        function setState(s) {
            // normaliza
            if (!STATES.includes(s)) s = 'choosing';

            hideAllStates();

            // mostrar el correcto
            document.getElementById(`state-${s}`).classList.remove('hidden-state');

            if (s === 'expired') {
                sessionStorage.removeItem('waitlist_reloaded');
            }
        }


        const btnGoMeet = document.getElementById('btnGoMeet');

        let currentBookingId = null;

        function goMeet(link) {
            if (link) window.location.href = link;
            else alert('Aún no hay link de Meet.');
        }

        // click inicial (por si meetLink ya viene desde Blade)
        /* if (btnGoMeet) {
            btnGoMeet.addEventListener('click', () => goMeet(meetLink));
        } */
        let accepting = false;



        // ================== COUNTDOWN ROBUSTO ==================
        let expiresAtMs = (expiresAtMsRaw !== null) ? Number(expiresAtMsRaw) : null;
        if (!expiresAtMs && secondsLeftRaw !== null) {
            expiresAtMs = Date.now() + (Number(secondsLeftRaw) * 1000);
        }

        const el = document.getElementById('tutorCountdown');
        const warn = document.getElementById('tutorWarn');
        const syncLabel = document.getElementById('syncLabel');

        function fmtMMSS(s) {
            s = Math.max(0, Math.floor(s));
            const m = String(Math.floor(s / 60)).padStart(2, '0');
            const r = String(s % 60).padStart(2, '0');
            return `${m}:${r}`;
        }

        function markExpiredUI() {
            // Cambia al estado expired en front
            setState('expired');

            // Etiqueta opcional
            if (syncLabel) syncLabel.textContent = 'FINALIZADO';

            // ✅ recargar solo 1 vez para que el backend confirme expired
            if (!sessionStorage.getItem('waitlist_reloaded')) {
                sessionStorage.setItem('waitlist_reloaded', '1');
                setTimeout(() => location.reload(), 1200);
            }
        }

        function renderCountdown() {
            // Solo renderiza si estamos en choosing
            const choosingVisible = !document.getElementById('state-choosing').classList.contains('hidden-state');
            if (!choosingVisible) return;

            if (!el) return;

            if (!expiresAtMs) {
                el.textContent = '--:--';
                if (warn) {
                    warn.style.display = 'inline';
                    warn.style.color = '#ef4444';
                    warn.textContent = 'No se pudo calcular expiración';
                }
                return;
            }

            const diffSec = Math.ceil((expiresAtMs - Date.now()) / 1000);

            if (diffSec <= 0) {
                markExpiredUI();
                return;
            }

            el.textContent = fmtMMSS(diffSec);

            if (warn) {
                if (diffSec <= 30) {
                    warn.style.display = 'inline';
                    warn.style.color = '#f59e0b';
                    warn.textContent = '⚠️ Expira pronto';
                } else {
                    warn.style.display = 'none';
                }
            }
        }

        // ====== TOKEN (igual que vista de prueba) ======
        window.WAITLIST_TOKEN = @json($token ?? request()->query('t', ''));
        const token = String(window.WAITLIST_TOKEN || '').trim();

        async function fetchStatusNice() {
            if (!token) return;

            const res = await fetch(`/tutor/waitlist/status?t=${encodeURIComponent(token)}`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.ok) return;

            if (json.chosen?.booking_id) {
                currentBookingId = Number(json.chosen.booking_id);
            }

            const ui = String(json.ui_state || 'waiting');
            // ✅ Opción B: si ya mostraste EXPIRED, no permitas que el polling lo cambie a REJECTED
            const expiredVisible = !document
                .getElementById('state-expired')
                .classList.contains('hidden-state');

            if (expiredVisible && (ui === 'batch_expired_waiting' || ui === 'rejected')) {
                return;
            }


            // 🔄 Re-sincronizar temporizador desde backend si llega info nueva
            if (json.expires_at_ms != null) {
                expiresAtMs = Number(json.expires_at_ms);
            } else if (json.seconds_left != null) {
                expiresAtMs = Date.now() + (Number(json.seconds_left) * 1000);
            }
            renderCountdown();


            // expiración
            const expiresAtStr = json.batch?.expires_at || '-';
            const expiresAtEl = document.getElementById('expiresAtText');
            if (expiresAtEl) expiresAtEl.textContent = expiresAtStr;

            // ====== MAPEO DE ESTADOS ======
            if (ui === 'waiting') {
                setState('choosing');
                return;
            }

            if (ui === 'batch_expired_waiting') {
                const st = String(json.batch?.status || '');
                const msg = String(json.message || '');

                const closedByChoice = (st === 'matched' || st === 'done' || st === 'failed') && !/expir/i.test(msg);

                setState(closedByChoice ? 'rejected' : 'expired');
                return;
            }
            if (ui === 'payment_phase' || ui === 'accepted') {
                const hasReceipt = !!(json.payment && json.payment.has_receipt);
                setState(hasReceipt ? 'paid' : 'paying');
                return;
            }

            if (ui === 'rejected') {
                setState('rejected');
                return;
            }
        }
        const btnAccept = document.getElementById('btnAccept');
        const btnReject = document.getElementById('btnReject');
        const rejectReasonEl = document.getElementById('rejectReason');
        const actionMsg = document.getElementById('actionMsg');
        const paymentLabel = document.getElementById('paymentLabel');

        function setActionMsg(text) {
            if (actionMsg) actionMsg.textContent = text || '';
        }

        function setButtonsEnabled(enabled) {
            if (btnAccept) btnAccept.disabled = !enabled;
            if (btnReject) btnReject.disabled = !enabled;
        }

        async function postJSON(url, bodyObj) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify(bodyObj || {})
            });

            const json = await res.json().catch(() => ({}));
            return {
                res,
                json
            };
        }

        if (btnAccept) {
            btnAccept.addEventListener('click', async () => {
                if (!token) return;

                setButtonsEnabled(false);
                setActionMsg('Aceptando...');

                const {
                    res,
                    json
                } = await postJSON(`/tutor/waitlist/accept?t=${encodeURIComponent(token)}`, {});

                setButtonsEnabled(true);

                if (!res.ok || !json.ok) {
                    setActionMsg('');
                    alert(json.message || `No se pudo aceptar (HTTP ${res.status})`);
                    return;
                }

                // si backend devuelve meeting_link, redirige de una
                const link = json.meeting_link || json.booking?.meeting_link || null;
                if (link) {
                    window.location.href = link;
                    return;
                }

                setActionMsg('✅ Aceptado. Actualizando...');
                fetchStatusNice();
            });
        }

        if (btnReject) {
            btnReject.addEventListener('click', async () => {
                if (!token) return;

                const reason = String(rejectReasonEl?.value || '').trim();

                setButtonsEnabled(false);
                setActionMsg('Rechazando...');

                const {
                    res,
                    json
                } = await postJSON(`/tutor/waitlist/reject?t=${encodeURIComponent(token)}`, {
                    reason: reason || 'Comprobante sospechoso'
                });

                setButtonsEnabled(true);

                if (!res.ok || !json.ok) {
                    setActionMsg('');
                    alert(json.message || `No se pudo rechazar (HTTP ${res.status})`);
                    return;
                }

                setActionMsg('❌ Rechazado. Actualizando...');
                fetchStatusNice();
            });
        }
        let joining = false;

        async function acceptThenGoMeet() {
            if (!token || joining) return;

            if (!currentBookingId) {
                alert('Aún no se encontró la reserva de esta tutoría.');
                return;
            }

            joining = true;

            if (btnGoMeet) {
                btnGoMeet.disabled = true;
                btnGoMeet.style.opacity = '.75';
                btnGoMeet.style.cursor = 'not-allowed';
            }

            const {
                res,
                json
            } = await postJSON(`/tutor/waitlist/accept?t=${encodeURIComponent(token)}`, {});

            if (!res.ok || !json.ok) {
                joining = false;
                if (btnGoMeet) {
                    btnGoMeet.disabled = false;
                    btnGoMeet.style.opacity = '1';
                    btnGoMeet.style.cursor = 'pointer';
                }
                alert(json.message || `No se pudo aceptar (HTTP ${res.status})`);
                return;
            }

            const directLink = json.meeting_link || json.booking?.meeting_link || null;
            if (directLink) {
                window.location.href = directLink;
                return;
            }

            const meetRes = await fetch(`/bookings/${currentBookingId}/check-meet`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const meetJson = await meetRes.json().catch(() => ({}));

            if (!meetRes.ok || !meetJson.ok || !meetJson.meeting_link) {
                joining = false;
                if (btnGoMeet) {
                    btnGoMeet.disabled = false;
                    btnGoMeet.style.opacity = '1';
                    btnGoMeet.style.cursor = 'pointer';
                }
                alert(meetJson.message || 'Aún no hay link de Meet.');
                return;
            }

            window.location.href = meetJson.meeting_link;
        }

        if (btnGoMeet) {
            btnGoMeet.onclick = acceptThenGoMeet;
        }




        // ====== START POLLING ======
        let pollTimer = null;
        let t = null;

        function startPollingNice() {
            if (pollTimer) clearInterval(pollTimer);
            fetchStatusNice();
            pollTimer = setInterval(fetchStatusNice, 2500);
        }
        document.addEventListener('DOMContentLoaded', startPollingNice);
        window.addEventListener('beforeunload', () => {
            if (pollTimer) clearInterval(pollTimer);
            clearInterval(t);
        });


        // ================== INIT ==================
        // Si el backend manda expired, muestra expired. Si no, muestra lo que venga.
        let init = initialStatus;
        if (init === 'accepted' || init === 'payment_phase') {
            // en carga inicial, si aún no sabemos has_receipt, mostramos paying por defecto
            init = 'paying';
        }
        setState(init === 'expired' ? 'expired' : init);

        // render inmediato
        renderCountdown();
        // ✅ tick del temporizador (cada 1s)
        t = setInterval(renderCountdown, 1000);
    </script>
@endsection
