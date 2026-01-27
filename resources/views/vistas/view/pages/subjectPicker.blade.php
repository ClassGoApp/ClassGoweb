@extends('vistas.view.layouts.blank')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="max-w-5xl mx-auto p-6">

        <!-- PANTALLA A: Selección + Debug -->
        <div id="screenSelect">
            <h2 class="text-xl font-bold mb-4">Elegir materia</h2>

            <!-- BLOQUE A) Selección de materia -->
            <div class="card">
                <div class="card-title">1) Selecciona una materia</div>

                <div class="flex flex-col md:flex-row gap-3 items-start md:items-center">
                    <input id="search" type="text" placeholder="Buscar materia..."
                        class="w-full md:w-80 border rounded-lg px-3 py-2" />

                    <button id="reloadBtn" type="button" class="border rounded-lg px-4 py-2">
                        Recargar
                    </button>

                    <div class="text-sm opacity-70">
                        Endpoint: <code>/student/subject</code>
                    </div>
                </div>

                <div class="list-box">
                    <div class="list-title">Materias</div>
                    <div id="grid" class="subject-list"></div>
                </div>

                <div class="mt-6 border rounded-xl p-4">
                    <div class="flex flex-wrap gap-3 items-center">
                        <div class="font-semibold">Materia seleccionada:</div>
                        <div id="selectedName" class="opacity-70">Ninguna</div>
                    </div>

                    <div class="flex flex-wrap gap-3 items-center mt-2">
                        <div class="font-semibold">ID guardado:</div>
                        <div id="selectedId" class="opacity-70">null</div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-3 items-center">
                        <button id="nextBtn" type="button"
                            class="border rounded-lg px-4 py-2 opacity-50 cursor-not-allowed" disabled>
                            Solicitar (iniciar envío por lotes)
                        </button>

                        <div class="text-sm opacity-70">
                            Variable: <code>selectedSubjectId</code>
                        </div>
                    </div>

                    <div class="mt-3 text-sm">
                        <div class="opacity-70">Resultado start:</div>
                        <pre id="startOut" class="codebox">Aún no se inicia.</pre>
                    </div>
                </div>
            </div>

            <!-- BLOQUE B) Seguimiento debug -->
            <div class="card mt-6">
                <div class="card-title">2) Seguimiento de envíos (cada 1 minuto)</div>

                <div class="flex flex-wrap gap-3 items-center">
                    <div class="text-sm opacity-70">
                        Batch activo: <code id="batchIdLabel">null</code>
                    </div>

                    <div class="text-sm opacity-70">
                        Estado: <span id="batchStatusLabel">-</span>
                    </div>

                    <div class="text-sm opacity-70">
                        Enviados: <span id="sentCountLabel">0</span>
                    </div>
                    <div class="text-sm opacity-70">
                        Emails/min: <b id="ratePerMinLabel">-</b>
                    </div>
                    <div class="text-sm opacity-70">
                        Enviados este minuto: <b id="sentThisMinLabel">-</b>
                    </div>

                    <div class="text-sm opacity-70">
                        En cola: <span id="queuedCountLabel">0</span>
                    </div>

                    <div class="text-sm opacity-70">
                        Expira: <span id="expiresAtLabel">-</span>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-3 items-center">
                    <div class="pill">
                        Próximo refresco en: <b id="countdown">60</b>s
                    </div>

                    <button id="stopPollingBtn" type="button" class="border rounded-lg px-4 py-2" disabled>
                        Detener seguimiento
                    </button>
                </div>

                <div class="mt-4">
                    <div class="text-sm opacity-70 mb-2">Detalle de lotes (items del batch)</div>

                    <div class="table-wrap">
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th># Lote (position)</th>
                                    <th>user_id</th>
                                    <th>email</th>
                                    <th>status</th>
                                    <th>sent_at</th>
                                    <th>error</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTbody">
                                <tr>
                                    <td colspan="6" class="opacity-70">Aún no hay batch iniciado.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-3 text-sm">
                    <div class="opacity-70">Respuesta status (debug):</div>
                    <pre id="statusOut" class="codebox">-</pre>
                </div>
            </div>
        </div>

        <!-- PANTALLA B: Espera + tutores aceptados -->
        <div id="screenWait" class="hidden">
            <div class="card">
                <div class="card-title">Buscando tutores...</div>

                <div class="flex flex-wrap gap-3 items-center">
                    <div class="text-sm opacity-70">Batch: <b id="wBatchId">-</b></div>
                    <div class="text-sm opacity-70">Estado: <b id="wStatus">-</b></div>
                    <div class="text-sm opacity-70">Expira: <b id="wExpires">-</b></div>
                    <div class="text-sm opacity-70">
                        Emails/min: <b id="ratePerMinLabel">-</b>
                    </div>
                    <div class="text-sm opacity-70">
                        Enviados este minuto: <b id="sentThisMinLabel">-</b>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="text-sm opacity-70 mb-2">Tutores que aceptaron</div>

                    <div id="acceptedList" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="opacity-70">Aún nadie aceptó...</div>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-3 items-center">
                    {{-- <button id="btnCancel" type="button" class="border rounded-lg px-4 py-2">
                        Volver
                    </button> --}}

                    <button id="btnNewSearch" type="button" class="border rounded-lg px-4 py-2 hidden">
                        Nueva solicitud
                    </button>

                    <div id="waitMsg" class="text-sm opacity-70"></div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .hidden {
            display: none !important;
        }

        /* fallback por si no tienes Tailwind */

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            padding: 16px;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        }

        .card-title {
            font-weight: 800;
            font-size: 14px;
            margin-bottom: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 12px;
            display: inline-block;
        }

        .list-box {
            margin-top: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .list-title {
            padding: 12px 16px;
            font-weight: 700;
            font-size: 14px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .subject-list {
            max-height: 420px;
            overflow-y: auto;
        }

        .subject-row {
            width: 100%;
            text-align: left;
            padding: 12px 16px;
            border: 0;
            background: #fff;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .subject-row:hover {
            background: #f9fafb;
        }

        .subject-row.selected {
            background: #f3f4f6;
            outline: 2px solid #111;
            outline-offset: -2px;
        }

        .subject-name {
            font-weight: 700;
        }

        .subject-meta {
            font-size: 12px;
            opacity: .7;
            margin-top: 2px;
        }

        .codebox {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #0b1020;
            color: #dbeafe;
            padding: 12px;
            overflow: auto;
            max-height: 200px;
            font-size: 12px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .pill {
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 8px 12px;
            background: #f9fafb;
            font-size: 13px;
        }

        .table-wrap {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
        }

        .mini-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .mini-table thead th {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            padding: 10px 12px;
            font-weight: 800;
            font-size: 12px;
            white-space: nowrap;
        }

        .mini-table tbody td {
            border-bottom: 1px solid #eef2f7;
            padding: 10px 12px;
            vertical-align: top;
        }
    </style>



    <script>
        /* ==========================================================
                                               BLOQUE A) SELECCIÓN DE MATERIA
                                            ========================================================== */
        let selectedSubjectId = null;
        let subjectsCache = [];
        let selectedCardEl = null;

        const grid = document.getElementById('grid');
        const search = document.getElementById('search');
        const reloadBtn = document.getElementById('reloadBtn');
        const selectedNameEl = document.getElementById('selectedName');
        const selectedIdEl = document.getElementById('selectedId');
        const nextBtn = document.getElementById('nextBtn');
        const startOut = document.getElementById('startOut');

        const screenSelect = document.getElementById('screenSelect');
        const screenWait = document.getElementById('screenWait');

        function escapeHtml(str) {
            return String(str ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function showSelectScreen() {
            screenWait?.classList.add('hidden');
            screenSelect?.classList.remove('hidden');
        }

        function showWaitScreen() {
            screenSelect?.classList.add('hidden');
            screenWait?.classList.remove('hidden');
        }

        function setSelected(subject, cardEl) {
            selectedSubjectId = Number(subject.id);

            selectedNameEl.textContent = subject.name;
            selectedIdEl.textContent = String(selectedSubjectId);

            nextBtn.disabled = false;
            nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');

            if (selectedCardEl) selectedCardEl.classList.remove('selected');
            selectedCardEl = cardEl;
            selectedCardEl.classList.add('selected');
        }

        function render(list) {
            grid.innerHTML = '';

            if (!list.length) {
                grid.innerHTML = `<div style="padding:16px;opacity:.7">No hay materias para mostrar.</div>`;
                return;
            }

            const frag = document.createDocumentFragment();

            for (const s of list) {
                const row = document.createElement('button');
                row.type = 'button';

                const isSelected = selectedSubjectId === Number(s.id);
                row.className = 'subject-row' + (isSelected ? ' selected' : '');

                row.innerHTML = `
      <div>
        <div class="subject-name">${escapeHtml(s.name)}</div>
        <div class="subject-meta">ID: ${s.id}</div>
      </div>
      <div class="subject-meta">Seleccionar</div>
    `;

                row.addEventListener('click', () => setSelected(s, row));
                frag.appendChild(row);

                if (isSelected) selectedCardEl = row;
            }

            // ✅ BUG FIX: esto faltaba
            grid.appendChild(frag);
        }

        function normalizeApiSubjects(json) {
            if (Array.isArray(json?.data)) return json.data;
            if (Array.isArray(json?.data?.data)) return json.data.data;
            if (Array.isArray(json?.data?.items)) return json.data.items;
            return [];
        }

        async function loadSubjects() {
            grid.innerHTML = `<div class="opacity-70" style="padding:16px;">Cargando materias...</div>`;

            const res = await fetch('/student/subject', {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!res.ok) {
                grid.innerHTML =
                    `<div class="opacity-70" style="padding:16px;">Error cargando materias (HTTP ${res.status}).</div>`;
                return;
            }

            const json = await res.json();
            subjectsCache = normalizeApiSubjects(json);
            render(subjectsCache);
        }

        function filterSubjects() {
            const q = search.value.trim().toLowerCase();
            if (!q) return render(subjectsCache);

            const filtered = subjectsCache.filter(s => String(s.name).toLowerCase().includes(q));
            render(filtered);
        }

        reloadBtn.addEventListener('click', () => render(subjectsCache));

        let searchDebounce = null;
        search.addEventListener('input', () => {
            clearTimeout(searchDebounce);
            searchDebounce = setTimeout(filterSubjects, 120);
        });

        /* ==========================================================
           BLOQUE B) BATCH STATUS (polling cada 60s)
        ========================================================== */
        let currentBatchId = null;
        let pollTimer = null;
        let countdownTimer = null;
        let secondsLeft = 60;

        const ratePerMinLabel = document.getElementById('ratePerMinLabel');
        const wRate = document.getElementById('wRate');

        const batchIdLabel = document.getElementById('batchIdLabel');
        const batchStatusLabel = document.getElementById('batchStatusLabel');
        const sentCountLabel = document.getElementById('sentCountLabel');
        const queuedCountLabel = document.getElementById('queuedCountLabel');
        const expiresAtLabel = document.getElementById('expiresAtLabel');
        const countdownEl = document.getElementById('countdown');
        const stopPollingBtn = document.getElementById('stopPollingBtn');
        const itemsTbody = document.getElementById('itemsTbody');
        const statusOut = document.getElementById('statusOut');

        function resetCountdown() {
            secondsLeft = 60;
            if (countdownEl) countdownEl.textContent = secondsLeft;
        }

        function startCountdown() {
            if (countdownTimer) clearInterval(countdownTimer);
            resetCountdown();
            countdownTimer = setInterval(() => {
                secondsLeft--;
                if (secondsLeft <= 0) secondsLeft = 60;
                if (countdownEl) countdownEl.textContent = secondsLeft;
            }, 1000);
        }

        function stopPollingUI() {
            if (pollTimer) clearInterval(pollTimer);
            if (countdownTimer) clearInterval(countdownTimer);
            pollTimer = null;
            countdownTimer = null;

            if (stopPollingBtn) {
                stopPollingBtn.disabled = true;
                stopPollingBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        /* ==========================================================
           BLOQUE C) ACEPTADOS (polling cada 5s)
        ========================================================== */
        let acceptedTimer = null;
        let acceptedAfterId = 0;
        let acceptedMap = new Map();
        const sentThisMinLabel = document.getElementById('sentThisMinLabel');
        const wSentThisMin = document.getElementById('wSentThisMin');

        let lastSentCount = null;
        let lastSentAtMs = null;


        const wBatchId = document.getElementById('wBatchId');
        const wStatus = document.getElementById('wStatus');
        const wExpires = document.getElementById('wExpires');
        const acceptedList = document.getElementById('acceptedList');
        const waitMsg = document.getElementById('waitMsg');
        const btnCancel = document.getElementById('btnCancel');
        const btnNewSearch = document.getElementById('btnNewSearch');

        function stopAcceptedPolling() {
            if (acceptedTimer) clearInterval(acceptedTimer);
            acceptedTimer = null;
        }

        function renderAcceptedCards() {
            const items = Array.from(acceptedMap.values());

            if (!acceptedList) return;
            acceptedList.innerHTML = '';

            if (!items.length) {
                acceptedList.innerHTML = `<div class="opacity-70">Aún nadie aceptó...</div>`;
                return;
            }

            for (const t of items) {
                const card = document.createElement('div');
                card.className = 'card';
                card.style.padding = '14px';

                const name = t.name ? escapeHtml(t.name) : 'Tutor';
                const email = escapeHtml(t.email || '');
                const acceptedAt = escapeHtml(t.accepted_at || '');

                card.innerHTML = `
      <div style="font-weight:800;margin-bottom:6px;">${name}</div>
      <div class="text-sm opacity-70">${email}</div>
      <div class="text-sm opacity-70 mt-2">Aceptó: ${acceptedAt}</div>
      <div class="mt-3">
        <button type="button" class="border rounded-lg px-4 py-2">Elegir</button>
      </div>
    `;

                card.querySelector('button').addEventListener('click', () => chooseTutor(t.id));
                acceptedList.appendChild(card);
            }
        }

        // async function fetchAcceptedTutors(batchId) {
        //     const res = await fetch(
        //         `/student/batches/${batchId}/accepted?after_id=${acceptedAfterId}&limit=50`, {
        //             headers: {
        //                 'Accept': 'application/json'
        //             },
        //             credentials: 'same-origin'
        //         });

        //     const json = await res.json().catch(() => ({}));
        //     if (!res.ok) return;

        //     const data = Array.isArray(json.data) ? json.data : [];
        //     for (const row of data) {
        //         acceptedMap.set(row.id, row);
        //     }

        //     acceptedAfterId = Number(json.next_after_id || acceptedAfterId);
        //     renderAcceptedCards();
        // }


        
        function startAcceptedPolling(batchId) {
            stopAcceptedPolling();
            fetchAcceptedTutors(batchId);
            acceptedTimer = setInterval(() => fetchAcceptedTutors(batchId), 5000);
        }

        /* ==========================================================
           STATUS fetch
        ========================================================== */
        async function fetchBatchStatus(batchId) {
            const res = await fetch(`/student/batches/${batchId}/status`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            if (statusOut) statusOut.textContent = JSON.stringify(json, null, 2);

            if (!res.ok) return;

            // resumen (debug)
            if (batchStatusLabel) batchStatusLabel.textContent = json.batch?.status ?? '-';
            if (sentCountLabel) sentCountLabel.textContent = String(json.batch?.sent_count ?? 0);
            const sentCountNow = Number(json.batch?.sent_count ?? 0);
            const nowMs = Date.now();

            // delta vs último tick
            let sentThisMin = '-';
            if (lastSentCount !== null) {
                const diff = sentCountNow - lastSentCount;
                sentThisMin = String(Math.max(0, diff));
            }

            // pintar
            if (sentThisMinLabel) sentThisMinLabel.textContent = sentThisMin;
            if (wSentThisMin) wSentThisMin.textContent = sentThisMin;

            // actualizar memoria
            lastSentCount = sentCountNow;
            lastSentAtMs = nowMs;



            if (queuedCountLabel) queuedCountLabel.textContent = String(json.batch?.queued ?? 0);
            if (expiresAtLabel) expiresAtLabel.textContent = json.batch?.expires_at ?? '-';

            // emails por minuto (batch_size)
            const rate = json.batch?.batch_size ?? '-';
            if (ratePerMinLabel) ratePerMinLabel.textContent = String(rate);
            if (wRate) wRate.textContent = String(rate);

            // resumen (pantalla espera)
            if (wStatus) wStatus.textContent = json.batch?.status ?? '-';
            if (wExpires) wExpires.textContent = json.batch?.expires_at ?? '-';

            // tabla items (debug)
            const items = Array.isArray(json.items) ? json.items : [];
            if (itemsTbody) {
                itemsTbody.innerHTML = '';

                if (!items.length) {
                    itemsTbody.innerHTML = `<tr><td colspan="6" class="opacity-70">Sin items.</td></tr>`;
                } else {
                    for (const it of items) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
          <td>${it.position ?? ''}</td>
          <td>${it.user_id ?? ''}</td>
          <td>${escapeHtml(it.email ?? '')}</td>
          <td>${escapeHtml(it.status ?? '')}</td>
          <td>${escapeHtml(it.sent_at ?? '')}</td>
          <td>${escapeHtml(it.last_error ?? '')}</td>
        `;
                        itemsTbody.appendChild(tr);
                    }
                }
            }

            const st = (json.batch?.status ?? '').toLowerCase();
            if (st === 'done' || st === 'failed' || st === 'matched') {
                stopAcceptedPolling();
                stopPollingUI();

                if (btnNewSearch) btnNewSearch.classList.remove('hidden');
                if (waitMsg) waitMsg.textContent = 'La búsqueda terminó. Puedes iniciar una nueva solicitud.';
            }
        }


        /* ==========================================================
           Elegir tutor
        ========================================================== */
        async function chooseTutor(itemId) {
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

            stopAcceptedPolling();
            stopPollingUI();

            if (waitMsg) waitMsg.textContent = 'Tutor elegido. Redirigiendo a pagos...';

            if (json.redirect_to) {
                window.location.href = json.redirect_to;
            } else {
                alert('Elegido, pero faltó redirect_to. Define tu ruta de pagos.');
            }
        }

        /* ==========================================================
           Arrancar modo espera
        ========================================================== */
        function startPolling(batchId) {
            currentBatchId = batchId;
            lastSentCount = null;
            lastSentAtMs = null;
            if (sentThisMinLabel) sentThisMinLabel.textContent = '-';
            if (wSentThisMin) wSentThisMin.textContent = '-';

            // ✅ ocultar selección, mostrar espera
            showWaitScreen();

            if (wBatchId) wBatchId.textContent = String(batchId);
            if (btnNewSearch) btnNewSearch.classList.add('hidden');
            if (waitMsg) waitMsg.textContent = '';

            // reset accepted
            acceptedAfterId = 0;
            acceptedMap.clear();
            renderAcceptedCards();
            startAcceptedPolling(batchId);

            // debug / status
            if (batchIdLabel) batchIdLabel.textContent = String(batchId);
            if (stopPollingBtn) {
                stopPollingBtn.disabled = false;
                stopPollingBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            fetchBatchStatus(batchId);
            startCountdown();

            if (pollTimer) clearInterval(pollTimer);
            pollTimer = setInterval(() => {
                fetchBatchStatus(batchId);
                resetCountdown();
            }, 60000);
        }

        stopPollingBtn?.addEventListener('click', () => stopPollingUI());

        /* ==========================================================
           BOTÓN SOLICITAR
        ========================================================== */
        nextBtn.addEventListener('click', async () => {
            if (currentBatchId) {
                alert('Ya hay una búsqueda activa. Continúa la espera.');
                return;
            }
            if (!selectedSubjectId) {
                alert('Selecciona una materia primero.');
                return;
            }

            nextBtn.disabled = true;
            nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
            startOut.textContent = 'Creando batch...';

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
                        subject_id: selectedSubjectId
                    }),
                });

                const json = await res.json().catch(() => ({}));
                startOut.textContent = JSON.stringify(json, null, 2);

                if (!res.ok) {
                    alert('Error al iniciar batch: ' + (json.message ?? `HTTP ${res.status}`));
                    nextBtn.disabled = false;
                    nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    return;
                }

                if (json.batch_id) {
                    startPolling(json.batch_id);
                } else {
                    alert('Batch creado pero no llegó batch_id en respuesta.');
                }

            } catch (e) {
                console.error(e);
                alert('Error JS: ' + e.message);
                nextBtn.disabled = false;
                nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });

        /* ==========================================================
           BOTONES EN ESPERA
        ========================================================== */
        // btnCancel?.addEventListener('click', () => {
        //     // solo cambia UI (no mata batch en backend)
        //     showSelectScreen();
        // });

        btnNewSearch?.addEventListener('click', () => {
            // reset UI
            currentBatchId = null;
            stopAcceptedPolling();
            stopPollingUI();

            nextBtn.disabled = true;
            nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
            selectedSubjectId = null;
            selectedNameEl.textContent = 'Ninguna';
            selectedIdEl.textContent = 'null';

            showSelectScreen();
            loadSubjects();
        });

        /* ==========================================================
           Reanudar batch si existe
        ========================================================== */
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

                selectedSubjectId = Number(json.subject_id || 0);
                startOut.textContent = `Batch activo detectado (ID ${json.batch_id}). Reanudando...`;

                startPolling(json.batch_id);
                return true;

            } catch (e) {
                console.error('resumeActiveBatchIfAny error:', e);
                return false;
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const resumed = await resumeActiveBatchIfAny();
            if (!resumed) await loadSubjects();
        });
    </script>
@endsection
