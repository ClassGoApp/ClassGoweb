<link rel="stylesheet" href="{{ asset('css/recruitment.css') }}">
<div id="recruitment-modal" class="am-recruitment-modal">
    <div class="am-modal-header-recruitment">
        <button type="button" 
            class="am-close-modal" 
            onclick="closeRecruitmentModal()" 
            title="Minimizar (puedes volver a abrirlo cuando quieras desde el botón flotante)"
            data-title-key="recruitment_minimize_title">
            ✕
        </button>
    </div>

    <!-- Custom confirmation overlay -->
    <div id="recruitment-confirm-overlay" class="am-confirm-overlay">
        <div class="am-confirm-card">
            <h3 data-translate="recruitment_confirm_title">¿Estás seguro?</h3>

            <p class="texto-advertencia" data-translate="recruitment_confirm_message">
                Si cierras desde aquí no podrás acceder al formulario después. Para minimizar y poder usar el botón flotante más tarde, presiona la <strong>✕</strong> de arriba.
            </p>
            <div class="am-confirm-buttons">
                <button type="button" class="am-confirm-btn am-confirm-btn-yes" onclick="confirmDismiss()" data-translate="recruitment_confirm_yes">
                    Sí, no volver a mostrar
                </button>

                <button type="button" class="am-confirm-btn am-confirm-btn-no" onclick="cancelDismiss()" data-translate="recruitment_confirm_no">
                    No, mantener activo
                </button>
            </div>
        </div>
    </div>

    <div class="am-recruitment-content">
        <div class="am-side-info">
            
            <h2>
                <span data-translate="recruitment_heading_prefix">Únete a nosotros, estamos buscando</span>
                <span data-translate="recruitment_heading_highlight">tu talento.</span>
            </h2>
            
            <ul class="am-phrase-list">

                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong data-translate="recruitment_area_title">Sin importar tu área:</strong>
                        <span data-translate="recruitment_area_desc">
                            Ya seas de TI, Marketing, Administración, Contabilidad o cualquier otra área, en ClassGo hay un lugar para ti.
                        </span>
                    </div>
                </li>
                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong data-translate="recruitment_commitment_title">Compromiso Real:</strong>
                        <span data-translate="recruitment_commitment_desc">
                            Envíanos tu información ahora mismo. Nuestro equipo de RRHH revisará tu perfil y
                        </span>
                        <strong data-translate="recruitment_commitment_contact">nos pondremos en contacto contigo enseguida.</strong>
                        </div>
                </li>
                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong data-translate="recruitment_growth_title">Crecimiento Exponencial:</strong>
                        <span data-translate="recruitment_growth_desc">
                            Buscamos socios estratégicos para transformar la empresa.
                        </span>
                    </div>
                </li>
            </ul>

            <div class="am-areas-badge">
                <strong data-translate="recruitment_current_priority">Prioridad actual:</strong>
                <span data-translate="recruitment_priority_areas">TI • Marketing • Finanzas • Administración • Ventas • ¡Y más!</span>
            </div>
        </div>

        <div class="am-form-side">
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="color: var(--primary-color); margin:0;"></h3>
                <p style="font-size: 1.1rem; color:var(--primary-color); font-weight: 600;" data-translate="recruitment_form_time">
                    Solo te tomará unos minutos.
                </p>
            </div>

            <livewire:frontend.recruitment-form />
        </div>
    </div>
</div>
<script>
    let autoCloseTimeout = null;
    let tooltipTimeout = null;
    let isDismissAuth = false;

    function triggerDismissConfirm(isAuth) {
        isDismissAuth = isAuth;
        const overlay = document.getElementById('recruitment-confirm-overlay');
        const modal = document.getElementById('recruitment-modal');
        if (overlay && modal) {
            overlay.style.top = modal.scrollTop + 'px';
            overlay.style.height = modal.clientHeight + 'px';
            overlay.classList.add('active');
            modal.classList.add('confirm-active');
        }
    }

    function cancelDismiss() {
        const overlay = document.getElementById('recruitment-confirm-overlay');
        const modal = document.getElementById('recruitment-modal');
        if (overlay) {
            overlay.classList.remove('active');
        }
        if (modal) {
            modal.classList.remove('confirm-active');
        }
    }

    function confirmDismiss() {
        const overlay = document.getElementById('recruitment-confirm-overlay');
        const modal = document.getElementById('recruitment-modal');
        if (overlay) {
            overlay.classList.remove('active');
        }
        if (modal) {
            modal.classList.remove('confirm-active');
        }

        if (isDismissAuth) {
            const hiddenBtn = document.getElementById('hidden-dismiss-btn');
            if (hiddenBtn) {
                hiddenBtn.click();
            }
        } else {
            localStorage.setItem('classgo_recruitment_auto_shown', 'true');
            localStorage.setItem('classgo_recruitment_dismissed_permanently', 'true');
            
            document.querySelectorAll('.am-recruitment-fab').forEach(el => {
                el.style.display = 'none';
            });
            
            if (typeof closeRecruitmentModal === 'function') {
                closeRecruitmentModal();
            }
            if (typeof hideRecruitmentTooltip === 'function') {
                hideRecruitmentTooltip();
            }
        }
    }

    function showRecruitmentTooltip() {
        // Cancel any existing tooltip timer
        if (tooltipTimeout) {
            clearTimeout(tooltipTimeout);
        }

        const tooltips = document.querySelectorAll('.am-recruitment-tooltip');
        tooltips.forEach(tooltip => {
            tooltip.classList.add('show');
        });
        console.log("Recruitment: Tooltip shown. Will hide in 3 seconds.");

        // Automatically hide the tooltip after 3 seconds
        tooltipTimeout = setTimeout(hideRecruitmentTooltip, 3000);
    }

    function hideRecruitmentTooltip() {
        if (tooltipTimeout) {
            clearTimeout(tooltipTimeout);
            tooltipTimeout = null;
        }
        const tooltips = document.querySelectorAll('.am-recruitment-tooltip');
        tooltips.forEach(tooltip => {
            tooltip.classList.remove('show');
        });
        console.log("Recruitment: Tooltip hidden.");
    }

    function showRecruitmentModal(isAuto = false) {
        const modal = document.getElementById('recruitment-modal');
        if (!modal) return;

        modal.classList.add('show');

        // Hide the tooltip when modal is open
        hideRecruitmentTooltip();

        // Cancel any existing timer to prevent duplicates
        if (autoCloseTimeout) {
            clearTimeout(autoCloseTimeout);
            autoCloseTimeout = null;
        }

        if (isAuto) {
            console.log("Recruitment: Modal shown automatically. Starting 5-second auto-close timer.");

            // Start 5 seconds countdown to close it
            autoCloseTimeout = setTimeout(closeRecruitmentModal, 5000);

            // Cancel countdown if there's any interaction inside the modal
            const cancelAutoClose = function() {
                if (autoCloseTimeout) {
                    clearTimeout(autoCloseTimeout);
                    autoCloseTimeout = null;
                    console.log("Recruitment: Auto-close timer canceled due to user interaction.");
                }
            };

            modal.addEventListener('click', cancelAutoClose, { once: true });
            modal.addEventListener('input', cancelAutoClose, { once: true });
            modal.addEventListener('focusin', cancelAutoClose, { once: true });
        } else {
            console.log("Recruitment: Modal shown manually via button. Auto-close timer disabled.");
        }
    }

    function closeRecruitmentModal() {
        const modal = document.getElementById('recruitment-modal');
        if (modal) {
            modal.classList.remove('show');
            modal.classList.remove('confirm-active');
        }
        if (autoCloseTimeout) {
            clearTimeout(autoCloseTimeout);
            autoCloseTimeout = null;
        }
        // Show tooltip after the modal closes
        showRecruitmentTooltip();
    }

     function applyRecruitmentAttributeTranslations() {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        if (typeof translations === 'undefined') {
            return;
        }

        const t = translations[lang] || translations.es;

        document.querySelectorAll('[data-title-key]').forEach((element) => {
            const key = element.getAttribute('data-title-key');

            if (t[key]) {
                element.setAttribute('title', t[key]);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', applyRecruitmentAttributeTranslations);
    document.addEventListener('languageChanged', applyRecruitmentAttributeTranslations);

    document.addEventListener('DOMContentLoaded', function() {
        const modalId = 'classgo_recruitment_auto_shown';
        
        @auth
            @if(!session()->has('classgo_recruitment_logged_shown'))
                @php
                    session(['classgo_recruitment_logged_shown' => true]);
                @endphp
                console.log("Recruitment: Authenticated user newly logged in. Showing modal automatically.");
                setTimeout(() => showRecruitmentModal(true), 1000);
                return;
            @endif
        @endauth

        // If they permanently dismissed it (as a guest), hide the buttons immediately
        const permanentlyDismissed = localStorage.getItem('classgo_recruitment_dismissed_permanently');
        if (permanentlyDismissed) {
            document.querySelectorAll('.am-recruitment-fab').forEach(el => {
                el.style.display = 'none';
            });
            console.log("Recruitment: FAB hidden because recruitment was permanently dismissed.");
            return;
        }

        const alreadyShown = localStorage.getItem(modalId);

        if (!alreadyShown) {
            console.log("Recruitment: Modal will show automatically in 1 second.");
            localStorage.setItem(modalId, 'true');
            setTimeout(() => showRecruitmentModal(true), 1000);
        } else {
            console.log("Recruitment: Modal skipped because it was already shown once automatically.");
        }
    });

    window.addEventListener('recruitment-sent', event => {
        setTimeout(() => {
            closeRecruitmentModal();
            hideRecruitmentTooltip();
            // Hide the button entirely upon successful submission
            const fabs = document.querySelectorAll('.am-recruitment-fab');
            fabs.forEach(fab => fab.style.display = 'none');
        }, 3000); // Cierra automáticamente tras éxito
    });
</script>
