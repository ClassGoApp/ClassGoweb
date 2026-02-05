@extends('vistas.view.layouts.blank')

@section('content')
    <div class="tw-wrap">
        <div class="tw-card">
            <div class="tw-head">
                <div>
                    <div class="tw-title">Panel Tutor · Solicitud</div>
                    <div class="tw-sub">Esta pantalla se actualiza sola según el estado de la solicitud.</div>
                </div>
                <div class="tw-badges">
                    <span class="tw-badge">Token: <code id="tokenLabel">-</code></span>
                    <span class="tw-badge">Estado: <b id="uiStateLabel">-</b></span>
                </div>
            </div>

            {{-- INFO / TIMER --}}
            <div class="tw-info">
                <div class="tw-kv">
                    <div class="tw-k">Expira:</div>
                    <div class="tw-v" id="expiresAtText">{{ $expires_at ?? '-' }}</div>
                </div>
                <div class="tw-kv">
                    <div class="tw-k">Tiempo restante:</div>
                    <div class="tw-v">
                        <div class="tw-v">
                            <b id="tutorCountdown">--:--</b>
                            <span id="tutorWarn" class="tw-hide" style="margin-left:8px;font-weight:700;"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATE BOX --}}
            <div id="stateBox" class="tw-state">
                <div id="stateTitle" class="tw-state-title">Cargando...</div>
                <div id="stateDesc" class="tw-state-desc">Por favor espera.</div>
            </div>

            {{-- PAYMENT / ACTIONS --}}
            <div id="payBox" class="tw-pay tw-hide">
                <div class="tw-pay-top">
                    <div>
                        <div class="tw-pay-title">Ya fuiste elegido 🎯</div>
                        <div class="tw-pay-sub">Revisa el comprobante y decide si aceptas o rechazas.</div>
                    </div>
                    <div class="tw-pay-meta">
                        <div><span class="tw-muted">Booking:</span> <b id="bookingId">-</b></div>
                        <div><span class="tw-muted">Monto:</span> <b id="amount">-</b></div>
                        <div><span class="tw-muted">Horario:</span> <b id="timeRange">-</b></div>
                        <div><span class="tw-muted">Estudiante:</span> <b id="studentName">-</b></div>
                        <div><span class="tw-muted">Teléfono:</span> <b id="studentPhone">-</b></div>
                    </div>
                </div>

                <div class="tw-pay-body">
                    <div class="tw-col">
                        <div class="tw-sec-title">Comprobante</div>
                        <div id="receiptBox" class="tw-receipt tw-mutedbox">
                            <div class="tw-muted">Aún no se subió comprobante.</div>
                        </div>
                    </div>

                    <div class="tw-col">
                        <div class="tw-sec-title">Acciones</div>

                        <button id="btnAccept" type="button" class="tw-btn tw-btn-ok tw-hide">
                            Aceptar tutoría
                        </button>

                        <button id="btnReject" type="button" class="tw-btn tw-btn-bad tw-hide">
                            Rechazar
                        </button>

                        <div class="tw-mt">
                            <label class="tw-muted" for="rejectReason">Motivo (opcional)</label>
                            <input id="rejectReason" class="tw-in" type="text" maxlength="255"
                                placeholder="Ej: comprobante no coincide..." />
                        </div>

                        <div class="tw-mt">
                            <button id="btnMeet" type="button" class="tw-btn tw-btn-primary tw-hide">
                                Ir a Meet
                            </button>
                        </div>

                        <div id="actionMsg" class="tw-note tw-mt"></div>
                    </div>
                </div>
            </div>

            {{-- DEBUG --}}
            <div class="tw-debug">
                <div class="tw-debug-lbl">Respuesta status (debug):</div>
                <pre id="debugOut" class="tw-code">-</pre>
            </div>
        </div>
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
            --pri: #111827;
        }

        .tw-wrap {
            max-width: 860px;
            margin: 40px auto;
            padding: 20px;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--txt);
        }

        .tw-card {
            border: 1px solid var(--b);
            border-radius: 18px;
            background: var(--bg);
            padding: 18px;
        }

        .tw-head {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .tw-title {
            font-weight: 900;
            font-size: 18px;
            letter-spacing: -.2px;
        }

        .tw-sub {
            color: var(--muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .tw-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .tw-badge {
            border: 1px solid var(--b);
            background: var(--soft);
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 12px;
            color: var(--muted);
        }

        .tw-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            border: 1px solid var(--b);
            border-radius: 16px;
            background: #fff;
            padding: 12px;
            margin-top: 10px;
        }

        @media(max-width:720px) {
            .tw-info {
                grid-template-columns: 1fr;
            }
        }

        .tw-kv {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .tw-k {
            font-weight: 900;
        }

        .tw-v {
            color: var(--muted);
        }

        .tw-warn {
            margin-left: 8px;
            font-weight: 900;
            color: var(--warn);
        }

        .tw-hide {
            display: none !important;
        }

        .tw-state {
            margin-top: 12px;
            border: 1px solid var(--b);
            border-radius: 16px;
            padding: 14px;
            background: var(--soft);
        }

        .tw-state-title {
            font-weight: 900;
        }

        .tw-state-desc {
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
            line-height: 1.35;
        }

        .tw-pay {
            margin-top: 14px;
            border: 1px dashed var(--b);
            border-radius: 16px;
            padding: 14px;
            background: #fff;
        }

        .tw-pay-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .tw-pay-title {
            font-weight: 900;
        }

        .tw-pay-sub {
            color: var(--muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .tw-pay-meta {
            font-size: 12px;
            color: var(--muted);
            display: grid;
            gap: 4px;
        }

        .tw-pay-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: 12px;
        }

        @media(max-width:820px) {
            .tw-pay-body {
                grid-template-columns: 1fr;
            }
        }

        .tw-sec-title {
            font-weight: 900;
            margin-bottom: 8px;
        }

        .tw-muted {
            color: var(--muted);
        }

        .tw-mutedbox {
            border: 1px solid var(--b);
            border-radius: 14px;
            background: var(--soft);
            padding: 12px;
        }

        .tw-receipt img {
            max-width: 100%;
            border-radius: 12px;
            border: 1px solid var(--b);
            background: #fff;
        }

        .tw-receipt iframe {
            width: 100%;
            height: 420px;
            border: 1px solid var(--b);
            border-radius: 12px;
            background: #fff;
        }

        .tw-btn {
            width: 100%;
            border: 1px solid var(--b);
            background: #fff;
            border-radius: 14px;
            padding: 11px 12px;
            font-weight: 900;
            font-size: 13px;
            cursor: pointer;
        }

        .tw-btn:hover {
            background: var(--soft);
        }

        .tw-btn-ok {
            border-color: var(--ok);
            background: var(--ok);
            color: #fff;
        }

        .tw-btn-ok:hover {
            filter: brightness(.95);
        }

        .tw-btn-bad {
            border-color: var(--bad);
            background: var(--bad);
            color: #fff;
            margin-top: 10px;
        }

        .tw-btn-bad:hover {
            filter: brightness(.95);
        }

        .tw-btn-primary {
            border-color: var(--pri);
            background: var(--pri);
            color: #fff;
        }

        .tw-btn-primary:hover {
            background: #0b1020;
        }

        .tw-in {
            width: 100%;
            border: 1px solid var(--b);
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 14px;
            margin-top: 6px;
        }

        .tw-note {
            font-size: 13px;
            color: var(--muted);
            min-height: 18px;
        }

        .tw-mt {
            margin-top: 12px;
        }

        .tw-debug {
            margin-top: 14px;
        }

        .tw-debug-lbl {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .tw-code {
            border: 1px solid var(--b);
            border-radius: 14px;
            background: var(--codebg);
            color: var(--code);
            padding: 12px;
            max-height: 280px;
            overflow: auto;
            font-size: 12px;
            white-space: pre-wrap;
            word-break: break-word;
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
         * Vista Tutor (sin login)
         * Endpoints usados:
         *  - GET  /tutor/waitlist/status?t=TOKEN
         *  - POST /tutor/waitlist/accept?t=TOKEN
         *  - POST /tutor/waitlist/reject?t=TOKEN {reason?}
         *
         * 5 UI states requeridos:
         *  - waiting
         *  - batch_expired_waiting
         *  - payment_phase
         *  - accepted
         *  - rejected
         */

        window.WAITLIST_TOKEN = @json($token ?? request()->query('t', ''));
        const token = String(window.WAITLIST_TOKEN || '').trim();

        const tokenLabel = document.getElementById('tokenLabel');
        const uiStateLabel = document.getElementById('uiStateLabel');

        const expiresAtText = document.getElementById('expiresAtText');
        const countdownEl = document.getElementById('tutorCountdown');
        const warnEl = document.getElementById('tutorWarn');

        const stateTitle = document.getElementById('stateTitle');
        const stateDesc = document.getElementById('stateDesc');

        const payBox = document.getElementById('payBox');
        const bookingIdEl = document.getElementById('bookingId');
        const amountEl = document.getElementById('amount');
        const timeRangeEl = document.getElementById('timeRange');
        const studentNameEl = document.getElementById('studentName');
        const studentPhoneEl = document.getElementById('studentPhone');

        const receiptBox = document.getElementById('receiptBox');

        const btnAccept = document.getElementById('btnAccept');
        const btnReject = document.getElementById('btnReject');
        const btnMeet = document.getElementById('btnMeet');
        const rejectReasonEl = document.getElementById('rejectReason');
        const actionMsg = document.getElementById('actionMsg');

        const debugOut = document.getElementById('debugOut');

        let pollTimer = null;

        /* --- helpers --- */
        function fmtMMSS(s) {
            s = Math.max(0, Math.floor(s));
            const m = String(Math.floor(s / 60)).padStart(2, '0');
            const r = String(s % 60).padStart(2, '0');
            return `${m}:${r}`;
        }

        function setState(title, desc) {
            stateTitle.textContent = title;
            stateDesc.textContent = desc;
        }

        function setUiStateLabel(s) {
            uiStateLabel.textContent = s;
        }

        function showPayBox(show) {
            payBox.classList.toggle('tw-hide', !show);
        }

        function show(el, yes) {
            el.classList.toggle('tw-hide', !yes);
        }

        function clearActions() {
            actionMsg.textContent = '';
        }

        function setCountdownFromBatch(batch) {
            // batch.expires_at puede ser string, pero el backend ya envía "expired" bool
            // usamos seconds_left si llega, si no, dejamos el contador como '--:--'
            // NOTA: tu endpoint /tutor/waitlist/status no manda seconds_left, así que hacemos fallback:
            // - si batch.expired true => 00:00
            // - si no, dejamos el contador como "--:--"
            if (!batch) return;

            if (batch.expired) {
                countdownEl.textContent = '00:00';
                warnEl.style.display = 'inline';
                warnEl.style.color = '#ef4444';
                warnEl.textContent = '❌ Expirado';
                return;
            }

            // Si quieres un contador real aquí, lo correcto es que /tutor/waitlist/status te mande:
            //  - expires_at_ms y/o seconds_left
            // Por ahora, mostramos solo "expira en ..." con el string que ya viene.
            warnEl.style.display = 'none';
            warnEl.textContent = '⚠️ Expira pronto';
        }

        /* --- receipt renderer --- */
        function renderReceipt(url) {
            if (!url) {
                receiptBox.innerHTML = `<div class="tw-muted">Aún no se subió comprobante.</div>`;
                return;
            }
            const u = String(url);
            const isPdf = u.toLowerCase().endsWith('.pdf');
            if (isPdf) {
                receiptBox.innerHTML = `<iframe src="${u}" title="Comprobante PDF"></iframe>`;
            } else {
                receiptBox.innerHTML = `<img src="${u}" alt="Comprobante" />`;
            }
        }

        /* --- main status poll --- */
        async function fetchStatus() {
            if (!token) {
                setState('Token inválido', 'Falta el parámetro t en el enlace.');
                setUiStateLabel('invalid');
                showPayBox(false);
                return;
            }

            tokenLabel.textContent = token;

            const res = await fetch(`/tutor/waitlist/status?t=${encodeURIComponent(token)}`, {
                headers: {
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            debugOut.textContent = JSON.stringify(json, null, 2);

            if (!res.ok || !json.ok) {
                setState('Error', json.message || `No se pudo consultar (HTTP ${res.status})`);
                setUiStateLabel('error');
                showPayBox(false);
                return;
            }

            const ui = String(json.ui_state || 'waiting');
            setUiStateLabel(ui);

            // info top
            if (expiresAtText) expiresAtText.textContent = json.batch?.expires_at || '-';
            setCountdownFromBatch(json.batch);

            // reset ui blocks
            clearActions();
            showPayBox(false);
            show(btnMeet, false);
            show(btnAccept, false);
            show(btnReject, false);


            // states:
            // waiting
            // batch_expired_waiting
            // payment_phase
            // accepted
            // rejected
            if (ui === 'waiting') {
                setState(
                    'En espera',
                    'Aún no fuiste elegido. Si el estudiante te selecciona, aquí aparecerá la fase de pago.'
                );
                return;
            }

            if (ui === 'batch_expired_waiting') {
                const st = String(json.batch?.status || '');
                const msg = String(json.message || '');

                // Si fue cerrado porque eligieron a otro (matched/done/failed) -> texto distinto
                const closedByChoice = (st === 'matched' || st === 'done' || st === 'failed') && !/expir/i.test(msg);

                if (closedByChoice) {
                    setState(
                        'Solicitud cerrada',
                        msg || 'El estudiante ya eligió a otro tutor. Gracias.'
                    );
                    warnEl.style.display = 'inline';
                    warnEl.style.color = '#6b7280';
                    warnEl.textContent = 'ℹ️ Cerrado';
                } else {
                    setState(
                        'Expirado',
                        msg ||
                        'El batch expiró y no fuiste elegido. Si el estudiante vuelve a solicitar, te llegará otra invitación.'
                    );
                    warnEl.style.display = 'inline';
                    warnEl.style.color = '#ef4444';
                    warnEl.textContent = '❌ Expirado';
                }

                showPayBox(false);
                show(btnMeet, false);
                show(btnAccept, false);
                show(btnReject, false);
                sessionStorage.removeItem('waitlist_reloaded');
                return;
            }


            // Desde aquí en adelante: ya fuiste elegido
            const booking = json.booking || {};
            const payment = json.payment || {};
            const student = json.student || {};
            const actions = json.actions || {};

            showPayBox(true);

            bookingIdEl.textContent = booking.id != null ? String(booking.id) : '-';
            amountEl.textContent = booking.session_fee != null ? String(booking.session_fee) + ' Bs' : '-';
            timeRangeEl.textContent = (booking.start_time && booking.end_time) ?
                `${booking.start_time} → ${booking.end_time}` : '-';

            studentNameEl.textContent = student.name || '-';
            studentPhoneEl.textContent = student.phone || '-';

            renderReceipt(payment.receipt_url || null);

            // payment_phase: elegido, esperando comprobante o esperando aprobación
            if (ui === 'payment_phase') {
                if (payment.has_receipt) {
                    setState(
                        'En proceso de pago',
                        'El estudiante ya subió comprobante. Revísalo y decide aceptar o rechazar.'
                    );
                } else {
                    setState(
                        'En proceso de pago',
                        'Fuiste elegido. Aún no hay comprobante. Espera a que el estudiante lo suba.'
                    );
                }

                // Acciones según backend:
                // can_accept => reserved(4) y hay comprobante
                // can_reject => reserved(4)
                show(btnReject, !!actions.can_reject);
                show(btnAccept, !!actions.can_accept);
                return;
            }

            // accepted: booking active(1)
            if (ui === 'accepted') {
                setState(
                    'Aceptado',
                    'Tutoría confirmada. Ya puedes entrar a la sala de Meet.'
                );
                show(btnReject, false);
                show(btnAccept, false);
                show(btnMeet, !!actions.can_join_meet);

                // Link viene en booking.meeting_link
                btnMeet.onclick = () => {
                    const link = booking.meeting_link;
                    if (link) window.location.href = link;
                    else alert('Aún no hay meeting_link.');
                };
                return;
            }

            // rejected: booking canceled(0)
            if (ui === 'rejected') {
                setState(
                    'Rechazado',
                    'Rechazaste la tutoría (o fue cancelada). El estudiante podrá elegir otro tutor.'
                );
                show(btnReject, false);
                show(btnAccept, false);
                show(btnMeet, false);
                return;
            }

            // fallback
            setState('Estado desconocido', 'UI state no reconocido.');
        }

        /* --- actions --- */
        // btnAccept.addEventListener('click', async () => {
        //     if (!token) return;

        //     btnAccept.disabled = true;
        //     btnAccept.style.opacity = '.6';
        //     actionMsg.textContent = 'Aceptando...';

        //     const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        //     const res = await fetch(`/tutor/waitlist/accept?t=${encodeURIComponent(token)}`, {
        //         method: 'POST',
        //         headers: {
        //             'Accept': 'application/json',
        //             ...(csrf ? {
        //                 'X-CSRF-TOKEN': csrf
        //             } : {}),
        //         },
        //         credentials: 'same-origin'
        //     });
        //     console.log('POST URL:', `/tutor/waitlist/accept?t=${encodeURIComponent(token)}`);


        //     const json = await res.json().catch(() => ({}));
        //     debugOut.textContent = JSON.stringify(json, null, 2);

        //     btnAccept.disabled = false;
        //     btnAccept.style.opacity = '1';

        //     if (!res.ok || !json.ok) {
        //         actionMsg.textContent = '';
        //         alert(json.message || `No se pudo aceptar (HTTP ${res.status})`);
        //         return;
        //     }

        //     actionMsg.textContent = '✅ Aceptado. Actualizando...';
        //     await fetchStatus();
        // });

        btnAccept.addEventListener('click', async () => {
            if (!token) return;

            btnAccept.disabled = true;
            btnAccept.style.opacity = '.6';
            actionMsg.textContent = 'Aceptando...';

            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

            const res = await fetch(`/tutor/waitlist/accept?t=${encodeURIComponent(token)}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin'
            });

            const json = await res.json().catch(() => ({}));
            debugOut.textContent = JSON.stringify(json, null, 2);

            btnAccept.disabled = false;
            btnAccept.style.opacity = '1';

            if (!res.ok || !json.ok) {
                actionMsg.textContent = '';
                alert(json.message || `No se pudo aceptar (HTTP ${res.status})`);
                return;
            }

            // ✅ REDIRECT DIRECTO AL MEET
            const link = json.meeting_link || json.booking?.meeting_link;
            if (link) {
                if (pollTimer) clearInterval(pollTimer);
                window.location.href = link;
                return;
            }

            // fallback: refresca UI
            actionMsg.textContent = '✅ Aceptado. Actualizando...';
            await fetchStatus();
        });


        btnReject.addEventListener('click', async () => {
            if (!token) return;

            const reason = String(rejectReasonEl.value || '').trim();
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

            btnReject.disabled = true;
            btnReject.style.opacity = '.6';
            actionMsg.textContent = 'Rechazando...';

            const res = await fetch(`/tutor/waitlist/reject?t=${encodeURIComponent(token)}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    ...(csrf ? {
                        'X-CSRF-TOKEN': csrf
                    } : {}),
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    reason: reason || 'Comprobante sospechoso'
                })
            });

            const json = await res.json().catch(() => ({}));
            debugOut.textContent = JSON.stringify(json, null, 2);

            btnReject.disabled = false;
            btnReject.style.opacity = '1';

            if (!res.ok || !json.ok) {
                actionMsg.textContent = '';
                alert(json.message || `No se pudo rechazar (HTTP ${res.status})`);
                return;
            }

            actionMsg.textContent = '❌ Rechazado. Actualizando...';
            await fetchStatus();
        });


        /* --- start polling --- */
        function startPolling() {
            if (pollTimer) clearInterval(pollTimer);
            fetchStatus();
            pollTimer = setInterval(fetchStatus, 2500);
        }

        window.addEventListener('beforeunload', () => {
            if (pollTimer) clearInterval(pollTimer);
        });

        document.addEventListener('DOMContentLoaded', startPolling);
    </script>
@endsection
