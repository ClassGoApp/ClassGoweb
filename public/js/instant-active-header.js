// Botón global para retomar tutoría al instante activa
(function() {
    'use strict';
    
    async function checkActiveInstant() {
        try {
            const res = await fetch('/student/batches/active', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const json = await res.json().catch(() => ({}));
            if (json.active && json.batch_id) {
                applyActiveState(json.batch_id, json.expires_at);
            }
        } catch (e) {
            console.error('instant-active-header error:', e);
        }
    }
    
    function applyActiveState(batchId, expiresAt) {
        // Buscar botones con rayo/flotante de instantáneo
        const targets = [];
        document.querySelectorAll('.instant-btn-floating, #fab-instant-tutoring, .instant-btn, [data-instant-tutoring], .tutor-btn-instant').forEach(el => {
            targets.push(el);
        });
        
        targets.forEach(btn => {
            if (btn.dataset.instantActiveApplied) return;
            btn.dataset.instantActiveApplied = '1';
            btn.classList.add('instant-has-active');
            
            // Agregar pulso al rayo si existe
            const bolt = btn.querySelector('.bolt, svg path[d*="13 2"], svg polygon');
            if (bolt) {
                bolt.classList.add('instant-bolt-pulse');
            }
            
            // Añadir puntito verde
            if (!btn.querySelector('.instant-active-dot')) {
                const dot = document.createElement('span');
                dot.className = 'instant-active-dot';
                dot.style.cssText = 'position:absolute;top:2px;right:2px;width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 rgba(34,197,94,0.7);animation:instant-dot-pulse 1.8s infinite;z-index:15;';
                btn.style.position = btn.style.position || 'relative';
                btn.appendChild(dot);
            }
            
            // Cambiar onclick/href para redirigir al batch con snackbar
            const goToBatch = function(e) {
                e.preventDefault();
                e.stopPropagation();
                showInstantRedirectSnackbar();
                setTimeout(function() {
                    window.location.href = '/tutorias-instantaneas?batch=' + batchId;
                }, 900);
            };
            btn.onclick = goToBatch;
            if (btn.tagName === 'A') {
                btn.href = 'javascript:void(0)';
                btn.addEventListener('click', goToBatch);
            }
            
            // Añadir contador si hay expires_at
            if (expiresAt) {
                let counter = btn.querySelector('.instant-active-counter');
                if (!counter) {
                    counter = document.createElement('span');
                    counter.className = 'instant-active-counter';
                    counter.style.cssText = 'position:absolute;bottom:-14px;left:50%;transform:translateX(-50%);font-size:0.7rem;font-weight:700;background:rgba(2,48,71,0.9);color:white;padding:2px 8px;border-radius:999px;white-space:nowrap;z-index:20;box-shadow:0 4px 12px rgba(2,48,71,0.3);';
                    btn.style.position = btn.style.position || 'relative';
                    btn.style.overflow = 'visible';
                    btn.appendChild(counter);
                }
                updateCounter(counter, expiresAt);
                setInterval(() => updateCounter(counter, expiresAt), 1000);
            }
        });
    }
    
    function updateCounter(el, expiresAt) {
        const now = new Date().getTime();
        const exp = new Date(expiresAt).getTime();
        const diff = exp - now;
        if (diff <= 0) {
            el.textContent = '00:00';
            return;
        }
        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        el.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
    }
    
    function showInstantRedirectSnackbar() {
        if (document.getElementById('instant-redirect-snackbar')) return;
        const snackbar = document.createElement('div');
        snackbar.id = 'instant-redirect-snackbar';
        snackbar.innerHTML = `
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FB8500" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span style="font-weight:600;font-size:0.9rem;">Redirigiendo a tu tutoría al instante...</span>
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
    
    // Re-check cada 60 segundos por si cambia
    setInterval(checkActiveInstant, 60000);
})();
