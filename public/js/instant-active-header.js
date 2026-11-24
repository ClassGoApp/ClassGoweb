// Botón y Card global para retomar tutoría al instante activa (Búsqueda, Pago QR o Sala Meet)
(function() {
    'use strict';

    let counterInterval = null;
    let currentTargetExpMs = null;

    async function checkActiveInstant() {
        try {
            const res = await fetch('/student/batches/active', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const json = await res.json().catch(() => ({}));
            if (json.active && (json.batch_id || json.booking_id)) {
                applyActiveState(json);
            } else {
                removeFloatingCard();
            }
        } catch (e) {
            console.error('instant-active-header error:', e);
        }
    }

    function getTargetExpiresMs(data) {
        if (data.expires_at_ms && data.server_now_ms) {
            const skew = Date.now() - Number(data.server_now_ms);
            return Number(data.expires_at_ms) + skew;
        }
        if (data.seconds_left !== undefined && data.seconds_left !== null) {
            return Date.now() + (Number(data.seconds_left) * 1000);
        }
        if (data.expires_at) {
            return new Date(data.expires_at).getTime();
        }
        return null;
    }

    function applyActiveState(data) {
        const redirectUrl = data.redirect_url || (data.batch_id ? ('/tutorias-instantaneas?batch=' + data.batch_id) : '/student/bookings');
        const isExternalMeet = data.phase === 'meet_ready' && /^https?:\/\//i.test(redirectUrl);
        currentTargetExpMs = getTargetExpiresMs(data);

        // 1) Actualizar botones de rayo / flotantes existentes
        const targets = [];
        document.querySelectorAll('.instant-btn-floating, #fab-instant-tutoring, .instant-btn, [data-instant-tutoring], .tutor-btn-instant').forEach(el => {
            targets.push(el);
        });

        targets.forEach(btn => {
            btn.dataset.instantActiveApplied = '1';
            btn.classList.add('instant-has-active');

            const bolt = btn.querySelector('.bolt, svg path[d*="13 2"], svg polygon');
            if (bolt) {
                bolt.classList.add('instant-bolt-pulse');
            }

            if (!btn.querySelector('.instant-active-dot')) {
                const dot = document.createElement('span');
                dot.className = 'instant-active-dot';
                dot.style.cssText = 'position:absolute;top:2px;right:2px;width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 rgba(34,197,94,0.7);animation:instant-dot-pulse 1.8s infinite;z-index:15;';
                btn.style.position = btn.style.position || 'relative';
                btn.appendChild(dot);
            }

            const goToActive = function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (isExternalMeet) {
                    window.open(redirectUrl, '_blank');
                    return;
                }
                showInstantRedirectSnackbar(data.phase);
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 650);
            };
            btn.onclick = goToActive;
            if (btn.tagName === 'A') {
                btn.href = 'javascript:void(0)';
            }

            if (currentTargetExpMs) {
                let counter = btn.querySelector('.instant-active-counter');
                if (!counter) {
                    counter = document.createElement('span');
                    counter.className = 'instant-active-counter';
                    counter.style.cssText = 'position:absolute;bottom:-14px;left:50%;transform:translateX(-50%);font-size:0.7rem;font-weight:700;background:rgba(2,48,71,0.9);color:white;padding:2px 8px;border-radius:999px;white-space:nowrap;z-index:20;box-shadow:0 4px 12px rgba(2,48,71,0.3);';
                    btn.style.position = btn.style.position || 'relative';
                    btn.style.overflow = 'visible';
                    btn.appendChild(counter);
                }
            }
        });

        // 2) Renderizar Card Flotante si el usuario retrocedió o está fuera de la pantalla activa
        const path = window.location.pathname || '';
        const isAlreadyOnWaiting = path.includes('/student/waiting-tutor');
        const isAlreadyOnRadar = path.includes('/tutorias-instantaneas') || path.includes('/materias/elegir');

        if ((data.phase === 'waiting_tutor' && isAlreadyOnWaiting) ||
            ((data.phase === 'searching' || data.phase === 'payment_pending') && isAlreadyOnRadar)) {
            removeFloatingCard();
        } else {
            renderFloatingCard(data, redirectUrl, isExternalMeet);
        }

        if (counterInterval) clearInterval(counterInterval);
        tickAllCounters();
        counterInterval = setInterval(tickAllCounters, 1000);
    }

    function renderFloatingCard(data, redirectUrl, isExternalMeet) {
        let card = document.getElementById('instant-active-floating-card');
        if (!card) {
            card = document.createElement('div');
            card.id = 'instant-active-floating-card';
            document.body.appendChild(card);
        }

        let badgeText = 'EN CURSO';
        let badgeBg = '#FEF3C7';
        let badgeColor = '#92400E';
        let titleText = 'Tutoría al instante activa';
        let btnText = 'Continuar';
        let btnBg = 'linear-gradient(135deg, #FB8500 0%, #FF6B00 100%)';

        if (data.phase === 'waiting_tutor') {
            badgeText = 'ESPERANDO TUTOR';
            titleText = data.subject_name ? ('Solicitud: ' + data.subject_name) : 'Esperando respuesta del tutor';
            btnText = 'Ver solicitud';
        } else if (data.phase === 'searching') {
            badgeText = 'BUSCANDO TUTOR';
            titleText = data.subject_name ? ('Materia: ' + data.subject_name) : 'Buscando tutor disponible';
            btnText = 'Ver tutores';
        } else if (data.phase === 'payment_pending') {
            badgeText = 'PAGO PENDIENTE';
            badgeBg = '#FFEDD5';
            badgeColor = '#C2410C';
            titleText = data.tutor_name
                ? ('Pago QR: ' + data.tutor_name)
                : (data.subject_name ? ('Pago QR: ' + data.subject_name) : 'Completa tu pago con QR');
            btnText = 'Retomar pago QR';
        } else if (data.phase === 'meet_ready') {
            badgeText = 'CLASE LISTA';
            badgeBg = '#D1FAE5';
            badgeColor = '#065F46';
            titleText = data.subject_name
                ? (data.subject_name + (data.tutor_name ? ' • ' + data.tutor_name : ''))
                : 'Tu tutoría está en curso';
            btnText = 'Entrar al Aula (Meet)';
            btnBg = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        }

        card.innerHTML = `
            <div style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;margin-bottom:0.45rem;">
                <span style="display:inline-flex;align-items:center;gap:0.35rem;background:${badgeBg};color:${badgeColor};font-size:0.68rem;font-weight:800;padding:0.2rem 0.55rem;border-radius:999px;letter-spacing:0.03em;">
                    <span style="width:7px;height:7px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                    ${badgeText}
                </span>
                <span class="instant-active-counter" style="font-family:monospace;font-size:0.82rem;font-weight:800;color:#023047;background:#f1f5f9;padding:0.15rem 0.5rem;border-radius:0.4rem;">--:--</span>
            </div>
            <p style="font-size:0.86rem;font-weight:700;color:#023047;margin:0 0 0.6rem 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                ${titleText}
            </p>
            <button type="button" id="instant-floating-card-action" style="width:100%;border:none;border-radius:0.65rem;padding:0.55rem 0.85rem;background:${btnBg};color:#fff;font-weight:700;font-size:0.82rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.4rem;box-shadow:0 4px 12px rgba(2,48,71,0.15);">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>${btnText}</span>
            </button>
        `;

        const actionBtn = card.querySelector('#instant-floating-card-action');
        if (actionBtn) {
            actionBtn.onclick = function() {
                if (isExternalMeet) {
                    window.open(redirectUrl, '_blank');
                } else {
                    window.location.href = redirectUrl;
                }
            };
        }
    }

    function removeFloatingCard() {
        const card = document.getElementById('instant-active-floating-card');
        if (card) card.remove();
    }

    function tickAllCounters() {
        if (!currentTargetExpMs) return;
        const diff = currentTargetExpMs - Date.now();
        const text = diff <= 0
            ? '00:00'
            : String(Math.floor(diff / 60000)).padStart(2, '0') + ':' + String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');

        document.querySelectorAll('.instant-active-counter').forEach(el => {
            el.textContent = text;
        });

        if (diff <= 0) {
            if (counterInterval) clearInterval(counterInterval);
            setTimeout(checkActiveInstant, 1500);
        }
    }

    function showInstantRedirectSnackbar(phase) {
        if (document.getElementById('instant-redirect-snackbar')) return;
        const msg = phase === 'payment_pending'
            ? 'Retomando tu pago pendiente de tutoría...'
            : 'Redirigiendo a tu tutoría al instante...';
        const snackbar = document.createElement('div');
        snackbar.id = 'instant-redirect-snackbar';
        snackbar.innerHTML = `
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FB8500" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span style="font-weight:600;font-size:0.9rem;">${msg}</span>
            </div>
        `;
        snackbar.style.cssText = 'position:fixed;bottom:2rem;left:50%;transform:translateX(-50%) translateY(120%);background:white;padding:0.9rem 1.5rem;border-radius:999px;box-shadow:0 20px 60px rgba(2,48,71,0.25);z-index:10000;transition:all 0.4s ease;border:2px solid #FB8500;font-family:Inter,system-ui,sans-serif;';
        document.body.appendChild(snackbar);
        setTimeout(() => {
            snackbar.style.transform = 'translateX(-50%) translateY(0)';
        }, 50);
    }

    function injectStyles() {
        if (document.getElementById('instant-active-header-styles')) return;
        const style = document.createElement('style');
        style.id = 'instant-active-header-styles';
        style.textContent = `
            .instant-has-active {
                box-shadow: 0 0 0 0 rgba(251, 133, 0, 0.6);
                animation: instant-cta-pulse 2s infinite ease-out;
            }
            @keyframes instant-cta-pulse {
                0% { box-shadow: 0 0 0 0 rgba(251, 133, 0, 0.6); }
                70% { box-shadow: 0 0 0 12px rgba(251, 133, 0, 0.15); }
                100% { box-shadow: 0 0 0 18px rgba(251, 133, 0, 0); }
            }
            .instant-bolt-pulse {
                animation: instant-bolt-pulse 1.6s ease-in-out infinite;
                filter: drop-shadow(0 0 6px rgba(251, 133, 0, 0.8));
            }
            @keyframes instant-bolt-pulse {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.12); opacity: 0.9; }
            }
            @keyframes instant-dot-pulse {
                0% { box-shadow: 0 0 0 0 rgba(34,197,94,0.7); }
                70% { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
                100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
            }
            .instant-btn-floating.instant-has-active {
                position: relative;
                overflow: visible !important;
            }
            #instant-active-floating-card {
                position: fixed;
                bottom: 1.25rem;
                left: 1.25rem;
                width: 265px;
                max-width: calc(100vw - 2.5rem);
                background: #ffffff;
                border: 2px solid #FB8500;
                border-radius: 1rem;
                padding: 0.85rem 1rem;
                box-shadow: 0 20px 45px rgba(2, 48, 71, 0.22);
                z-index: 9990;
                font-family: Inter, system-ui, -apple-system, sans-serif;
                animation: instant-card-slide-in 0.35s ease-out;
            }
            @keyframes instant-card-slide-in {
                from { opacity: 0; transform: translateY(15px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @media (max-width: 768px) {
                #instant-active-floating-card {
                    bottom: 5.2rem;
                    left: 0.75rem;
                    width: 245px;
                }
            }
        `;
        document.head.appendChild(style);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            injectStyles();
            checkActiveInstant();
        });
    } else {
        injectStyles();
        checkActiveInstant();
    }

    setInterval(checkActiveInstant, 30000);
})();
