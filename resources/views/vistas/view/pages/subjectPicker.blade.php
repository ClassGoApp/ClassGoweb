@extends('vistas.view.layouts.blank')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="sp-wrap">
        <!-- HEADER -->
        <div class="sp-top">
            <div>
                <div class="sp-title">Elegir materia</div>
                <div class="sp-sub">Selecciona una materia, inicia el batch y elige un tutor cuando acepte.</div>
            </div>
            <div class="sp-badges">
                <span class="sp-badge">Endpoint materias: <code>/student/subject</code></span>
                <span class="sp-badge">Batches: <code>/student/batches/*</code></span>
            </div>
        </div>

        <!-- SCREEN A: SELECT SUBJECT -->
        <section id="screenSelect" class="sp-card">
            <div class="sp-card-h">
                <div class="sp-card-title">1) Selecciona una materia</div>
                <div class="sp-row sp-row-gap">
                    <input id="search" class="sp-in" type="text" placeholder="Buscar materia..." />
                    <button id="reloadBtn" class="sp-btn" type="button">Recargar</button>
                </div>
            </div>

            <div class="sp-list">
                <div class="sp-list-h">Materias</div>
                <div id="grid" class="sp-list-body"></div>
            </div>

            <div class="sp-select-box">
                <div class="sp-kv">
                    <div class="sp-k">Materia seleccionada:</div>
                    <div id="selectedName" class="sp-v">Ninguna</div>
                </div>
                <div class="sp-kv">
                    <div class="sp-k">ID guardado:</div>
                    <div id="selectedId" class="sp-v">null</div>
                </div>

                <div class="sp-row sp-row-gap sp-mt">
                    <button id="nextBtn" class="sp-btn sp-btn-primary sp-disabled" type="button" disabled>
                        Solicitar (iniciar búsqueda)
                    </button>
                    <span class="sp-hint">Variable: <code>selectedSubjectId</code></span>
                </div>

                <div class="sp-debug">
                    <div class="sp-debug-lbl">Respuesta start:</div>
                    <pre id="startOut" class="sp-code">Aún no se inicia.</pre>
                </div>
            </div>
        </section>

        <!-- SCREEN B: WAIT + ACCEPTED -->
        <section id="screenWait" class="sp-card sp-hide">
            <div class="sp-card-h">
                <div class="sp-card-title">Buscando tutores...</div>

                <div class="sp-row sp-row-wrap sp-row-gap">
                    <span class="sp-badge">Batch: <b id="wBatchId">-</b></span>
                    <span class="sp-badge">Estado: <b id="wStatus">-</b></span>
                    <span class="sp-badge">Expira: <b id="wExpires">-</b></span>
                    <span class="sp-badge">Emails/min: <b id="wRate">-</b></span>
                    <span class="sp-badge">Enviados este minuto: <b id="wSentThisMin">0</b></span>
                    <span class="sp-badge">Expira en: <b id="batchExpireCountdown"
                            class="sp-expire sp-expire-ok">--:--</b></span>
                </div>
            </div>

            <div class="sp-split">
                <!-- LEFT: accepted tutors -->
                <div class="sp-col">
                    <div class="sp-sec-title">Tutores que aceptaron</div>
                    <div id="acceptedList" class="sp-grid-2">
                        <div class="sp-muted">Aún nadie aceptó...</div>
                    </div>

                    <div class="sp-row sp-row-gap sp-mt">
                        <button id="btnNewSearch" type="button" class="sp-btn sp-hide">Nueva solicitud</button>
                        <div id="waitMsg" class="sp-muted"></div>
                    </div>
                </div>

                <!-- RIGHT: payment panel -->
                <div class="sp-col">
                    <div class="sp-sec-title">Pago / Reserva</div>

                    <!-- STEP 1: booking created -->
                    <div id="payBox" class="sp-pay sp-mutedbox sp-hide">
                        <div class="sp-pay-top">
                            <div>
                                <div class="sp-pay-title">Reserva creada ✅</div>
                                <div class="sp-muted">Sube el comprobante y espera aprobación del tutor.</div>
                            </div>
                            <div class="sp-pay-meta">
                                <div><span class="sp-muted">Booking:</span> <b id="payBookingId">-</b></div>
                                <div><span class="sp-muted">Monto:</span> <b id="payAmount">-</b></div>
                                <div><span class="sp-muted">Horario:</span> <b id="payTime">-</b></div>
                            </div>
                        </div>

                        <div class="sp-pay-body">
                            <div class="sp-pay-left">
                                <div class="sp-muted">Comprobante (jpg/png/pdf, máx 5MB)</div>
                                <input id="receiptFile" class="sp-file" type="file" accept=".jpg,.jpeg,.png,.pdf" />
                                <div class="sp-row sp-row-gap sp-mt">
                                    <button id="btnUploadReceipt" class="sp-btn sp-btn-primary" type="button">Subir
                                        comprobante</button>
                                    <button id="btnCancelBookingUI" class="sp-btn" type="button">Volver a lista</button>
                                </div>
                                <div id="payNote" class="sp-note sp-mt"></div>
                            </div>

                            <div class="sp-pay-right">
                                <div class="sp-muted">Estado</div>
                                <div class="sp-state">
                                    <div class="sp-state-k">UI:</div>
                                    <div class="sp-state-v" id="stuUiState">payment_phase</div>
                                </div>
                                <div class="sp-state">
                                    <div class="sp-state-k">Comprobante:</div>
                                    <div class="sp-state-v" id="stuHasReceipt">No</div>
                                </div>

                                <div class="sp-mt">
                                    <button id="btnMeet" class="sp-btn sp-btn-success sp-hide" type="button">
                                        Ir a Meet
                                    </button>
                                    <div id="stuStatusMsg" class="sp-muted sp-mt"></div>
                                </div>
                            </div>
                        </div>

                        <div class="sp-debug sp-mt">
                            <div class="sp-debug-lbl">Respuesta booking/status (debug):</div>
                            <pre id="payOut" class="sp-code">-</pre>
                        </div>
                    </div>

                    <!-- Debug batch status -->
                    <div class="sp-debug">
                        <div class="sp-debug-lbl">Respuesta status (debug):</div>
                        <pre id="statusOut" class="sp-code">-</pre>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        :root {
            --b: #e5e7eb;
            --bg: #ffffff;
            --soft: #f9fafb;
            --txt: #111827;
            --muted: #6b7280;
            --codebg: #0b1020;
            --code: #dbeafe;
            --ok: #16a34a;
            --warn: #f59e0b;
            --bad: #ef4444;
        }

        .sp-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 18px;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--txt);
        }

        .sp-top {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .sp-title {
            font-weight: 900;
            font-size: 20px;
            letter-spacing: -.3px;
        }

        .sp-sub {
            color: var(--muted);
            margin-top: 4px;
            font-size: 13px;
        }

        .sp-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .sp-badge {
            border: 1px solid var(--b);
            background: var(--soft);
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 12px;
            color: var(--muted);
        }

        .sp-card {
            border: 1px solid var(--b);
            border-radius: 16px;
            background: var(--bg);
            padding: 16px;
        }

        .sp-card+.sp-card {
            margin-top: 14px;
        }

        .sp-card-h {
            margin-bottom: 12px;
        }

        .sp-card-title {
            display: inline-block;
            font-weight: 900;
            font-size: 13px;
            border: 1px solid var(--b);
            background: var(--soft);
            padding: 9px 12px;
            border-radius: 12px;
        }

        .sp-row {
            display: flex;
            align-items: center;
        }

        .sp-row-wrap {
            flex-wrap: wrap;
        }

        .sp-row-gap {
            gap: 10px;
        }

        .sp-in {
            width: 100%;
            max-width: 360px;
            border: 1px solid var(--b);
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .sp-btn {
            border: 1px solid var(--b);
            background: #fff;
            border-radius: 12px;
            padding: 10px 12px;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
        }

        .sp-btn:hover {
            background: var(--soft);
        }

        .sp-btn-primary {
            border-color: #111827;
            background: #111827;
            color: #fff;
        }

        .sp-btn-primary:hover {
            background: #0b1020;
        }

        .sp-btn-success {
            border-color: var(--ok);
            background: var(--ok);
            color: #fff;
        }

        .sp-btn-success:hover {
            filter: brightness(.95);
        }

        .sp-disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .sp-list {
            border: 1px solid var(--b);
            border-radius: 16px;
            overflow: hidden;
            margin-top: 12px;
            background: #fff;
        }

        .sp-list-h {
            padding: 12px 14px;
            font-weight: 900;
            font-size: 13px;
            background: var(--soft);
            border-bottom: 1px solid var(--b);
        }

        .sp-list-body {
            max-height: 420px;
            overflow: auto;
        }

        .sp-item {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
            padding: 12px 14px;
            border: 0;
            border-bottom: 1px solid var(--b);
            background: #fff;
            text-align: left;
            cursor: pointer;
        }

        .sp-item:hover {
            background: var(--soft);
        }

        .sp-item.sel {
            outline: 2px solid #111827;
            outline-offset: -2px;
            background: #f3f4f6;
        }

        .sp-item-name {
            font-weight: 900;
        }

        .sp-item-meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .sp-select-box {
            margin-top: 12px;
            border: 1px solid var(--b);
            border-radius: 16px;
            padding: 14px;
            background: #fff;
        }

        .sp-kv {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 6px;
        }

        .sp-k {
            font-weight: 900;
        }

        .sp-v {
            color: var(--muted);
        }

        .sp-hint {
            font-size: 12px;
            color: var(--muted);
        }

        .sp-debug {
            margin-top: 12px;
        }

        .sp-debug-lbl {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .sp-code {
            border: 1px solid var(--b);
            border-radius: 14px;
            background: var(--codebg);
            color: var(--code);
            padding: 12px;
            max-height: 260px;
            overflow: auto;
            font-size: 12px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .sp-hide {
            display: none !important;
        }

        .sp-muted {
            color: var(--muted);
            font-size: 13px;
        }

        .sp-mt {
            margin-top: 12px;
        }

        .sp-split {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 14px;
            margin-top: 10px;
        }

        @media(max-width:900px) {
            .sp-split {
                grid-template-columns: 1fr;
            }
        }

        .sp-sec-title {
            font-weight: 900;
            margin: 8px 0 10px 0;
        }

        .sp-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media(max-width:800px) {
            .sp-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .sp-tcard {
            border: 1px solid var(--b);
            border-radius: 16px;
            background: #fff;
            padding: 14px;
        }

        .sp-trow {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .sp-avatar {
            width: 56px;
            height: 56px;
            border-radius: 999px;
            overflow: hidden;
            border: 1px solid var(--b);
            background: var(--soft);
            flex: 0 0 auto;
        }

        .sp-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .sp-tname {
            font-weight: 900;
        }

        .sp-tmeta {
            color: var(--muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .sp-expire {
            font-variant-numeric: tabular-nums;
        }

        .sp-expire-ok {
            color: inherit;
        }

        .sp-expire-warn {
            color: var(--warn);
            font-weight: 900;
        }

        .sp-expire-bad {
            color: var(--bad);
            font-weight: 900;
        }

        .sp-pay {
            border: 1px dashed var(--b);
            border-radius: 16px;
            padding: 14px;
            background: #fff;
        }

        .sp-mutedbox {
            background: linear-gradient(0deg, #fff, #fff), linear-gradient(90deg, transparent, transparent);
        }

        .sp-pay-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .sp-pay-title {
            font-weight: 900;
        }

        .sp-pay-meta {
            font-size: 12px;
            color: var(--muted);
            display: grid;
            gap: 4px;
        }

        .sp-pay-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 10px;
        }

        @media(max-width:900px) {
            .sp-pay-body {
                grid-template-columns: 1fr;
            }
        }

        .sp-file {
            width: 100%;
            border: 1px solid var(--b);
            border-radius: 12px;
            padding: 10px;
            background: #fff;
        }

        .sp-note {
            font-size: 12px;
            color: var(--muted);
            min-height: 18px;
        }

        .sp-state {
            display: flex;
            gap: 8px;
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }

        .sp-state-k {
            font-weight: 900;
            color: var(--txt);
        }

        code {
            background: #11182710;
            border: 1px solid #11182720;
            border-radius: 8px;
            padding: 2px 6px;
            font-size: 12px;
        }
    </style>

    <script>
        /**
         * ESTA VISTA USA SOLO TUS ENDPOINTS (ROL ESTUDIANTE):
         *  - GET  /student/subject
         *  - POST /student/batches/start
         *  - GET  /student/batches/active
         *  - GET  /student/batches/{batch}/status
         *  - GET  /student/batches/{batch}/accepted-tutors
         *  - POST /student/batches/{batch}/request-booking   (crea slot_booking RESERVED=4)
         *  - POST /student/bookings/{booking}/receipt
         *  - GET  /student/bookings/{booking}/status
         *  - GET  /student/bookings/{booking}/meet
         *
         * IMPORTANTE PARA QUE "DESAPAREZCAN" CARDS:
         *  - backend debe filtrar tutores ya reservados/activos (status 4/1) con overlap
         *  - frontend NO acumula, reemplaza lista completa cada 5s
         */

        const API = '/student';

        const $ = (id) => document.getElementById(id);
        const csrf = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const screenSelect = $('screenSelect');
        const screenWait = $('screenWait');

        const grid = $('grid');
        const search = $('search');
        const reloadBtn = $('reloadBtn');

        const selectedNameEl = $('selectedName');
        const selectedIdEl = $('selectedId');
        const nextBtn = $('nextBtn');
        const startOut = $('startOut');

        const wBatchId = $('wBatchId');
        const wStatus = $('wStatus');
        const wExpires = $('wExpires');
        const wRate = $('wRate');
        const wSentThisMin = $('wSentThisMin');
        const waitMsg = $('waitMsg');
        const btnNewSearch = $('btnNewSearch');

        const statusOut = $('statusOut');

        const batchExpireCountdownEl = $('batchExpireCountdown');

        const acceptedList = $('acceptedList');

        const payBox = $('payBox');
        const payBookingId = $('payBookingId');
        const payAmount = $('payAmount');
        const payTime = $('payTime');
        const receiptFile = $('receiptFile');
        const btnUploadReceipt = $('btnUploadReceipt');
        const btnCancelBookingUI = $('btnCancelBookingUI');

        const stuUiState = $('stuUiState');
        const stuHasReceipt = $('stuHasReceipt');
        const btnMeet = $('btnMeet');
        const stuStatusMsg = $('stuStatusMsg');
        const payOut = $('payOut');

        let subjectsCache = [];
        let selectedSubjectId = null;
        let selectedCardEl = null;

        let currentBatchId = null;
        let pollBatchTimer = null;
        let pollAcceptedTimer = null;
        let pollBookingTimer = null;

        let lastSentCount = null;

        let batchExpiresAtMs = null;
        let batchExpireTimer = null;

        let currentBookingId = null;

        function escapeHtml(str) {
            return String(str ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function showSelectScreen() {
            screenWait.classList.add('sp-hide');
            screenSelect.classList.remove('sp-hide');
        }

        function showWaitScreen() {
            screenSelect.classList.add('sp-hide');
            screenWait.classList.remove('sp-hide');
        }

        /** /storage/profile_images/... */
        function profileImageUrl(image) {
            if (!image) return '';
            let p = String(image).replaceAll('\\', '/');
            p = p.replace(/^\/+/, '');
            return `/storage/${p}`;
        }

        /* -------------------- SUBJECTS -------------------- */
        function setSelectedSubject(subject, btnEl) {
            selectedSubjectId = Number(subject.id);
            selectedNameEl.textContent = subject.name;
            selectedIdEl.textContent = String(selectedSubjectId);

            nextBtn.disabled = false;
            nextBtn.classList.remove('sp-disabled');

            if (selectedCardEl) selectedCardEl.classList.remove('sel');
            selectedCardEl = btnEl;
            selectedCardEl.classList.add('sel');
        }

        function renderSubjects(list) {
            grid.innerHTML = '';
            if (!list.length) {
                grid.innerHTML = `<div style="padding:14px;color:#6b7280;">No hay materias para mostrar.</div>`;
                return;
            }

            const frag = document.createDocumentFragment();
            for (const s of list) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'sp-item' + (selectedSubjectId === Number(s.id) ? ' sel' : '');
                btn.innerHTML = `
      <div>
        <div class="sp-item-name">${escapeHtml(s.name)}</div>
        <div class="sp-item-meta">ID: ${escapeHtml(s.id)}</div>
      </div>
      <div class="sp-item-meta">Seleccionar</div>
    `;
                btn.addEventListener('click', () => setSelectedSubject(s, btn));
                frag.appendChild(btn);
            }
            grid.appendChild(frag);
        }

        function normalizeApiSubjects(json) {
            const arr =
                Array.isArray(json) ? json :
                Array.isArray(json?.data) ? json.data :
                Array.isArray(json?.subjects) ? json.subjects :
                Array.isArray(json?.items) ? json.items :
                Array.isArray(json?.data?.data) ? json.data.data :
                Array.isArray(json?.data?.items) ? json.data.items : [];

            return arr
                .map(s => ({
                    id: s?.id ?? s?.subject_id ?? s?.value ?? null,
                    name: s?.name ?? s?.materia ?? s?.label ?? s?.title ?? '',
                }))
                .filter(s => s.id != null && String(s.name).trim() !== '');
        }

        async function loadSubjects() {
            grid.innerHTML = `<div style="padding:14px;color:#6b7280;">Cargando materias...</div>`;
            const res = await fetch(`${API}/subject`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });
            if (!res.ok) {
                grid.innerHTML =
                    `<div style="padding:14px;color:#6b7280;">Error cargando materias (HTTP ${res.status}).</div>`;
                return;
            }
            const json = await res.json().catch(() => ({}));
            subjectsCache = normalizeApiSubjects(json);
            renderSubjects(subjectsCache);
        }

        function filterSubjects() {
            const q = search.value.trim().toLowerCase();
            if (!q) return renderSubjects(subjectsCache);
            const filtered = subjectsCache.filter(s => String(s.name).toLowerCase().includes(q));
            renderSubjects(filtered);
        }

        reloadBtn.addEventListener('click', () => renderSubjects(subjectsCache));
        let searchDebounce = null;
        search.addEventListener('input', () => {
            clearTimeout(searchDebounce);
            searchDebounce = setTimeout(filterSubjects, 120);
        });

        /* -------------------- BATCH EXPIRE COUNTDOWN -------------------- */
        // function fmtMMSS(totalSeconds) {
        //     const s = Math.max(0, Math.floor(totalSeconds));
        //     const m = String(Math.floor(s / 60)).padStart(2, '0');
        //     const r = String(s % 60).padStart(2, '0');
        //     return `${m}:${r}`;
        // }

        // // function startBatchExpireCountdown() {
        // //     if (batchExpireTimer) clearInterval(batchExpireTimer);

        // //     batchExpireTimer = setInterval(() => {
        // //         if (!batchExpireCountdownEl) return;

        // //         if (!batchExpiresAtMs) {
        // //             batchExpireCountdownEl.textContent = '--:--';
        // //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        // //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        // //             return;
        // //         }

        // //         const diffSec = Math.ceil((batchExpiresAtMs - Date.now()) / 1000);

        // //         if (diffSec <= 0) {
        // //             batchExpireCountdownEl.textContent = '00:00';
        // //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-warn');
        // //             batchExpireCountdownEl.classList.add('sp-expire-bad');
        // //             if (waitMsg) waitMsg.textContent = 'El batch expiró. Inicia una nueva búsqueda.';
        // //             btnNewSearch.classList.remove('sp-hide');
        // //             return;
        // //         }

        // //         batchExpireCountdownEl.textContent = fmtMMSS(diffSec);

        // //         if (diffSec <= 30) {
        // //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-bad');
        // //             batchExpireCountdownEl.classList.add('sp-expire-warn');
        // //             if (waitMsg && !waitMsg.textContent) waitMsg.textContent = '⚠️ Expira pronto...';
        // //         } else {
        // //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        // //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        // //             if (waitMsg && waitMsg.textContent === '⚠️ Expira pronto...') waitMsg.textContent = '';
        // //         }
        // //     }, 1000);
        // // }

        // function startBatchExpireCountdown() {
        //     if (batchExpireTimer) clearInterval(batchExpireTimer);

        //     batchExpireTimer = setInterval(() => {
        //         if (!batchExpireCountdownEl) return;

        //         if (!batchExpiresAtMs) {
        //             batchExpireCountdownEl.textContent = '--:--';
        //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        //             return;
        //         }

        //         const nowMs = Date.now() + (serverOffsetMs || 0);
        //         const diffSec = Math.ceil((batchExpiresAtMs - nowMs) / 1000);

        //         if (diffSec <= 0) {
        //             batchExpireCountdownEl.textContent = '00:00';
        //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-warn');
        //             batchExpireCountdownEl.classList.add('sp-expire-bad');
        //             if (waitMsg) waitMsg.textContent = 'El batch expiró. Inicia una nueva búsqueda.';
        //             btnNewSearch.classList.remove('sp-hide');
        //             return;
        //         }

        //         batchExpireCountdownEl.textContent = fmtMMSS(diffSec);

        //         if (diffSec <= 30) {
        //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-warn');
        //             if (waitMsg && !waitMsg.textContent) waitMsg.textContent = '⚠️ Expira pronto...';
        //         } else {
        //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        //             if (waitMsg && waitMsg.textContent === '⚠️ Expira pronto...') waitMsg.textContent = '';
        //         }
        //     }, 1000);
        // }


        // function stopBatchExpireCountdown() {
        //     if (batchExpireTimer) clearInterval(batchExpireTimer);
        //     batchExpireTimer = null;
        //     batchExpiresAtMs = null;
        //     batchExpireCountdownEl.textContent = '--:--';
        //     batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //     batchExpireCountdownEl.classList.add('sp-expire-ok');
        // }

        // function startBatchExpireCountdown() {
        //     if (batchExpireTimer) clearInterval(batchExpireTimer);

        //     batchExpireTimer = setInterval(() => {
        //         if (!batchExpireCountdownEl) return;

        //         if (!batchExpiresAtMs) {
        //             batchExpireCountdownEl.textContent = '--:--';
        //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        //             return;
        //         }

        //         const diffSec = Math.ceil((batchExpiresAtMs - Date.now()) / 1000);

        //         if (diffSec <= 0) {
        //             batchExpireCountdownEl.textContent = '00:00';
        //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-warn');
        //             batchExpireCountdownEl.classList.add('sp-expire-bad');
        //             if (waitMsg) waitMsg.textContent = 'El batch expiró. Inicia una nueva búsqueda.';
        //             btnNewSearch.classList.remove('sp-hide');
        //             return;
        //         }

        //         batchExpireCountdownEl.textContent = fmtMMSS(diffSec);

        //         if (diffSec <= 30) {
        //             batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-warn');
        //             if (waitMsg && !waitMsg.textContent) waitMsg.textContent = '⚠️ Expira pronto...';
        //         } else {
        //             batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //             batchExpireCountdownEl.classList.add('sp-expire-ok');
        //             if (waitMsg && waitMsg.textContent === '⚠️ Expira pronto...') waitMsg.textContent = '';
        //         }
        //     }, 1000);
        // }

        // function stopBatchExpireCountdown() {
        //     if (batchExpireTimer) clearInterval(batchExpireTimer);
        //     batchExpireTimer = null;
        //     batchExpiresAtMs = null;
        //     batchExpireCountdownEl.textContent = '--:--';
        //     batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
        //     batchExpireCountdownEl.classList.add('sp-expire-ok');
        // }

        /* -------------------- BATCH EXPIRE COUNTDOWN -------------------- */
        function fmtMMSS(totalSeconds) {
            const s = Math.max(0, Math.floor(totalSeconds));
            const m = String(Math.floor(s / 60)).padStart(2, '0');
            const r = String(s % 60).padStart(2, '0');
            return `${m}:${r}`;
        }

        // ✅ offsets para que funcione igual en cualquier dispositivo
        let serverOffsetMs = 0; // server_now_ms - Date.now()
      
 

        // ✅ se llama cada vez que recibes JSON del backend con expires_at_ms y server_now_ms
        function applyBatchTimingFromJson(json) {
            // puede venir en root (/active) o dentro de batch (/status)
            const expiresMs = Number(
                json?.expires_at_ms ??
                json?.batch?.expires_at_ms ??
                null
            );

            const serverNow = Number(
                json?.server_now_ms ??
                json?.batch?.server_now_ms ??
                null
            );

            if (Number.isFinite(serverNow) && serverNow > 0) {
                serverOffsetMs = serverNow - Date.now();
            }

            if (Number.isFinite(expiresMs) && expiresMs > 0) {
                batchExpiresAtMs = expiresMs;
                return;
            }

            // fallback si solo llega seconds_left
            const secLeft = Number(json?.seconds_left ?? json?.batch?.seconds_left ?? NaN);
            if (Number.isFinite(secLeft)) {
                const nowMs = Date.now() + (serverOffsetMs || 0);
                batchExpiresAtMs = nowMs + (secLeft * 1000);
            } else {
                batchExpiresAtMs = null;
            }
        }

        function startBatchExpireCountdown() {
            if (batchExpireTimer) clearInterval(batchExpireTimer);

            batchExpireTimer = setInterval(() => {
                if (!batchExpireCountdownEl) return;

                if (!batchExpiresAtMs) {
                    batchExpireCountdownEl.textContent = '--:--';
                    batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
                    batchExpireCountdownEl.classList.add('sp-expire-ok');
                    return;
                }

                const nowMs = Date.now() + (serverOffsetMs || 0);
                const diffSec = Math.ceil((batchExpiresAtMs - nowMs) / 1000);

                if (diffSec <= 0) {
                    batchExpireCountdownEl.textContent = '00:00';
                    batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-warn');
                    batchExpireCountdownEl.classList.add('sp-expire-bad');
                    if (waitMsg) waitMsg.textContent = 'El batch expiró. Inicia una nueva búsqueda.';
                    btnNewSearch.classList.remove('sp-hide');
                    return;
                }

                batchExpireCountdownEl.textContent = fmtMMSS(diffSec);

                if (diffSec <= 30) {
                    batchExpireCountdownEl.classList.remove('sp-expire-ok', 'sp-expire-bad');
                    batchExpireCountdownEl.classList.add('sp-expire-warn');
                    if (waitMsg && !waitMsg.textContent) waitMsg.textContent = '⚠️ Expira pronto...';
                } else {
                    batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
                    batchExpireCountdownEl.classList.add('sp-expire-ok');
                    if (waitMsg && waitMsg.textContent === '⚠️ Expira pronto...') waitMsg.textContent = '';
                }
            }, 1000);
        }

        function stopBatchExpireCountdown() {
            if (batchExpireTimer) clearInterval(batchExpireTimer);
            batchExpireTimer = null;
            batchExpiresAtMs = null;
            serverOffsetMs = 0;

            if (batchExpireCountdownEl) {
                batchExpireCountdownEl.textContent = '--:--';
                batchExpireCountdownEl.classList.remove('sp-expire-warn', 'sp-expire-bad');
                batchExpireCountdownEl.classList.add('sp-expire-ok');
            }
        }


        /* -------------------- ACCEPTED TUTORS -------------------- */
        /**
         * CLAVE: NO acumulamos. Reemplazamos lista completa cada 5s.
         * Así cuando el backend deje de devolver un tutor (porque ya fue reservado por otro estudiante),
         * la card desaparece.
         */
        function renderAcceptedCards(items) {
            if (!acceptedList) return;
            acceptedList.innerHTML = '';

            if (!items.length) {
                acceptedList.innerHTML = `<div class="sp-muted">Aún nadie aceptó...</div>`;
                return;
            }

            for (const t of items) {
                const card = document.createElement('div');
                card.className = 'sp-tcard';

                const name = escapeHtml(t.name || `${t.first_name || ''} ${t.last_name || ''}`.trim() || 'Tutor');
                const email = escapeHtml(t.email || '');
                const acceptedAt = escapeHtml(t.accepted_at || '');

                const verified = (Number(t.is_verified) === 1 || !!t.verified_at) ? '✅ Verificado' : '⚠️ No verificado';
                const price = (t.price !== null && t.price !== undefined && String(t.price) !== '') ?
                    `${escapeHtml(String(t.price))} Bs` : 'Sin precio';
                const rating = (t.rating !== null && t.rating !== undefined) ? `${escapeHtml(String(t.rating))} ⭐` :
                    '0.0 ⭐';

                const imgSrc = profileImageUrl(t.image);

                card.innerHTML = `
      <div class="sp-trow">
        <div class="sp-avatar">
          ${imgSrc ? `<img src="${escapeHtml(imgSrc)}" alt="perfil">` : ``}
        </div>
        <div style="min-width:0;">
          <div class="sp-tname">${name}</div>
          <div class="sp-tmeta">${email}</div>
          <div class="sp-tmeta">${escapeHtml(verified)} · ${price} · ${rating}</div>
          <div class="sp-tmeta">Aceptó: ${acceptedAt}</div>
        </div>
      </div>

      <div class="sp-mt">
        <button type="button" class="sp-btn sp-btn-primary" data-item="${escapeHtml(t.id)}">
          Elegir
        </button>
      </div>
    `;

                card.querySelector('button').addEventListener('click', () => requestBooking(t.id));
                acceptedList.appendChild(card);
            }
        }

        async function fetchAcceptedTutors(batchId) {
            const res = await fetch(`${API}/batches/${batchId}/accepted-tutors?limit=50`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (!res.ok) return;

            const data = Array.isArray(json.data) ? json.data : [];
            renderAcceptedCards(data);
        }

        function startAcceptedPolling(batchId) {
            stopAcceptedPolling();
            fetchAcceptedTutors(batchId);
            pollAcceptedTimer = setInterval(() => fetchAcceptedTutors(batchId), 5000);
        }

        function stopAcceptedPolling() {
            if (pollAcceptedTimer) clearInterval(pollAcceptedTimer);
            pollAcceptedTimer = null;
        }

        /* -------------------- BATCH STATUS -------------------- */
        async function fetchBatchStatus(batchId) {
            const res = await fetch(`${API}/batches/${batchId}/status`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (statusOut) statusOut.textContent = JSON.stringify(json, null, 2);
            if (!res.ok) return;

            const batch = json.batch || {};

            // labels
            wBatchId.textContent = String(batch.id ?? batchId);
            wStatus.textContent = batch.status ?? '-';
            wExpires.textContent = batch.expires_at ?? '-';
            wRate.textContent = (batch.batch_size ?? '-') + '';

            // expire ms
            // batchExpiresAtMs = Number(batch.expires_at_ms ?? null);
            // if (!batchExpiresAtMs && batch.seconds_left != null) {
            //     batchExpiresAtMs = Date.now() + (Number(batch.seconds_left) * 1000);
            // }

            applyBatchTimingFromJson(json);

            // sent this minute (delta)
            const sentCountNow = Number(batch.sent_count ?? 0);
            let sentThisMin = '0';
            if (lastSentCount !== null) sentThisMin = String(Math.max(0, sentCountNow - lastSentCount));
            wSentThisMin.textContent = sentThisMin;
            lastSentCount = sentCountNow;

            // finished?
            const st = String(batch.status ?? '').toLowerCase();
            const secLeft = Number(batch.seconds_left ?? NaN);

            if (st === 'failed' || st === 'matched') {
                btnNewSearch.classList.remove('sp-hide');
                if (waitMsg) waitMsg.textContent = 'La búsqueda terminó. Puedes iniciar una nueva solicitud.';
            }
            if (Number.isFinite(secLeft) && secLeft <= 0) {
                btnNewSearch.classList.remove('sp-hide');
                if (waitMsg) waitMsg.textContent = 'El tiempo terminó. Puedes iniciar una nueva solicitud.';
            }
        }

        function startBatchPolling(batchId) {
            stopBatchPolling();
            currentBatchId = batchId;

            lastSentCount = null;
            btnNewSearch.classList.add('sp-hide');
            if (waitMsg) waitMsg.textContent = '';

            // showWaitScreen();
            // startBatchExpireCountdown();

            // fetchBatchStatus(batchId);

            showWaitScreen();
fetchBatchStatus(batchId);
startBatchExpireCountdown();

            pollBatchTimer = setInterval(() => fetchBatchStatus(batchId), 60000);
        }

        function stopBatchPolling() {
            if (pollBatchTimer) clearInterval(pollBatchTimer);
            pollBatchTimer = null;
        }

        /* -------------------- CREATE BOOKING (RESERVE) -------------------- */
        async function requestBooking(itemId) {
            if (!currentBatchId) return;

            // bloquea doble click
            if (waitMsg) waitMsg.textContent = 'Creando reserva...';

            const res = await fetch(`${API}/batches/${currentBatchId}/request-booking`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrf() ? {
                        'X-CSRF-TOKEN': csrf()
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    item_id: itemId
                })
            });

            const json = await res.json().catch(() => ({}));
            if (payOut) payOut.textContent = JSON.stringify(json, null, 2);

            if (!res.ok || !json.ok) {
                if (waitMsg) waitMsg.textContent = '';
                alert(json.message || `No se pudo reservar (HTTP ${res.status})`);
                return;
            }

            // booking creado
            const b = json.booking || {};
            currentBookingId = Number(b.id || 0);
            if (!currentBookingId) {
                alert('Reserva creada, pero no llegó booking.id');
                return;
            }

            // mostrar panel pago
            openPaymentPanel(b);

            // refrescar aceptados ya (para que también se esconda en tu propia lista si backend filtra)
            fetchAcceptedTutors(currentBatchId);
        }

        function openPaymentPanel(booking) {
            payBox.classList.remove('sp-hide');

            payBookingId.textContent = String(booking.id ?? '-');
            payAmount.textContent = booking.session_fee != null ? String(booking.session_fee) + ' Bs' : '-';
            payTime.textContent = (booking.start_time && booking.end_time) ? `${booking.start_time} → ${booking.end_time}` :
                '-';

            stuUiState.textContent = 'payment_phase';
            stuHasReceipt.textContent = 'No';
            stuStatusMsg.textContent = 'Sube tu comprobante. Luego espera la aprobación del tutor.';
            btnMeet.classList.add('sp-hide');

            // empezar polling de booking status
            startBookingPolling(currentBookingId);
        }

        btnCancelBookingUI.addEventListener('click', () => {
            // solo UI: volver a la lista (NO cancela booking en backend)
            payBox.classList.add('sp-hide');
            stuStatusMsg.textContent = '';
        });

        btnUploadReceipt.addEventListener('click', async () => {
            if (!currentBookingId) return alert('No hay booking activo.');
            const f = receiptFile.files?.[0];
            if (!f) return alert('Selecciona un archivo primero.');

            btnUploadReceipt.disabled = true;
            btnUploadReceipt.classList.add('sp-disabled');
            $('payNote').textContent = 'Subiendo...';
            console.log('FILE:', f, f?.name, f?.type, f?.size);
            const fd = new FormData();
            fd.append('comprobante', f);
            console.log([...fd.entries()]);
            const res = await fetch(`${API}/bookings/${currentBookingId}/receipt`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    ...(csrf() ? {
                        'X-CSRF-TOKEN': csrf()
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

            console.log('STATUS:', res.status);
            console.log('RAW:', raw);
            console.log('UPLOAD JSON:', json);

            if (payOut) payOut.textContent = JSON.stringify(json, null, 2);

            btnUploadReceipt.disabled = false;
            btnUploadReceipt.classList.remove('sp-disabled');
            $('payNote').textContent = '';

            if (!res.ok || !json.ok) {
                const err =
                    json?.errors?.comprobante?.[0] ||
                    json?.message ||
                    `No se pudo subir (HTTP ${res.status})`;
                alert(err);
                return;
            }

            $('payNote').textContent = '✅ Comprobante subido. Espera revisión del tutor.';
        });

        /* -------------------- BOOKING STATUS (STUDENT) -------------------- */
        async function fetchBookingStatus(bookingId) {
            const res = await fetch(`${API}/bookings/${bookingId}/status`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (payOut) payOut.textContent = JSON.stringify(json, null, 2);
            if (!res.ok || !json.ok) return;

            const ui = String(json.ui_state || 'payment_phase');
            stuUiState.textContent = ui;

            const hasReceipt = !!json.payment?.has_receipt;
            stuHasReceipt.textContent = hasReceipt ? 'Sí' : 'No';

            // accepted => habilitar meet
            if (ui === 'accepted') {
                stuStatusMsg.textContent = '✅ Aprobado por el tutor. Ya puedes entrar al Meet.';
                btnMeet.classList.remove('sp-hide');
            } else if (ui === 'rejected') {
                stuStatusMsg.textContent = '❌ El tutor rechazó. Puedes elegir otro tutor si el batch sigue activo.';
                btnMeet.classList.add('sp-hide');

                // volver a la lista de aceptados automáticamente
                payBox.classList.add('sp-hide');
                currentBookingId = null;

                // refrescar lista aceptados (como el booking quedó cancelado, el tutor puede reaparecer si sigue accepted y el batch sigue vivo)
                if (currentBatchId) fetchAcceptedTutors(currentBatchId);
            } else {
                // payment_phase
                btnMeet.classList.add('sp-hide');
                stuStatusMsg.textContent = hasReceipt ?
                    'Comprobante enviado. Esperando aprobación del tutor...' :
                    'Sube el comprobante para que el tutor pueda aprobar.';
            }
        }

        function startBookingPolling(bookingId) {
            stopBookingPolling();
            fetchBookingStatus(bookingId);
            pollBookingTimer = setInterval(() => fetchBookingStatus(bookingId), 2500);
        }

        function stopBookingPolling() {
            if (pollBookingTimer) clearInterval(pollBookingTimer);
            pollBookingTimer = null;
        }

        /* meet */
        btnMeet.addEventListener('click', () => {
            if (!currentBookingId) return;
            // tu endpoint existente
            window.location.href = `${API}/bookings/${currentBookingId}/meet`;
        });

        /* -------------------- START BATCH -------------------- */
        nextBtn.addEventListener('click', async () => {
            if (currentBatchId) {
                alert('Ya hay una búsqueda activa.');
                return;
            }
            if (!selectedSubjectId) {
                alert('Selecciona una materia primero.');
                return;
            }

            nextBtn.disabled = true;
            nextBtn.classList.add('sp-disabled');
            startOut.textContent = 'Creando batch...';

            const res = await fetch(`${API}/batches/start`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrf() ? {
                        'X-CSRF-TOKEN': csrf()
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    subject_id: selectedSubjectId
                }),
            });

            const json = await res.json().catch(() => ({}));
            startOut.textContent = JSON.stringify(json, null, 2);

            if (!res.ok || !json.success || !json.batch_id) {
                alert(json.message || `Error al iniciar (HTTP ${res.status})`);
                nextBtn.disabled = false;
                nextBtn.classList.remove('sp-disabled');
                return;
            }

            // arrancar wait
            startFlowWithBatch(json.batch_id);
        });

        /* -------------------- RESUME ACTIVE BATCH -------------------- */
        async function resumeActiveBatchIfAny() {
            const res = await fetch(`${API}/batches/active`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.active || !json.batch_id) return false;
applyBatchTimingFromJson(json);
            selectedSubjectId = Number(json.subject_id || 0);
            startOut.textContent = `Batch activo detectado (ID ${json.batch_id}). Reanudando...`;

            startFlowWithBatch(json.batch_id);
            return true;
        }

        /* -------------------- FLOW START -------------------- */
        function startFlowWithBatch(batchId) {
            currentBatchId = Number(batchId);
            wBatchId.textContent = String(currentBatchId);

            // UI
            showWaitScreen();
            btnNewSearch.classList.add('sp-hide');
            if (waitMsg) waitMsg.textContent = '';

            // polling
            startBatchPolling(currentBatchId);
            startAcceptedPolling(currentBatchId);

            // habilitar panel pago si ya tenías booking en otro intento? (si lo necesitas, se puede “rehidratar” desde tu backend)
        }

        /* reset */
        btnNewSearch.addEventListener('click', () => {
            // reset state
            stopBatchPolling();
            stopAcceptedPolling();
            stopBatchExpireCountdown();
            stopBookingPolling();

            currentBatchId = null;
            currentBookingId = null;

            // UI reset
            payBox.classList.add('sp-hide');
            nextBtn.disabled = true;
            nextBtn.classList.add('sp-disabled');

            selectedSubjectId = null;
            selectedNameEl.textContent = 'Ninguna';
            selectedIdEl.textContent = 'null';
            if (selectedCardEl) selectedCardEl.classList.remove('sel');
            selectedCardEl = null;

            showSelectScreen();
            loadSubjects();
        });

        document.addEventListener('DOMContentLoaded', async () => {
            const resumed = await resumeActiveBatchIfAny();
            if (!resumed) await loadSubjects();
        });
    </script>
@endsection
