@php
    $isLoggedIn = auth()->check();
@endphp

<link rel="stylesheet" href="{{ asset('css/recruitment.css') }}">
<div id="recruitment-modal" class="am-recruitment-modal">
    <button type="button" class="am-close-modal" onclick="closeRecruitmentModal()">✕</button>

    <div class="am-recruitment-content">
        <div class="am-side-info">
            
            <h2>Unete a nosotros estamos buscando <span>tu talento.</span></h2>
            
            <ul class="am-phrase-list">

                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong>Sin importar tu área:</strong> 
                        Ya seas de TI, Marketing, Administración, Contabilidad o cualquier otra área, en ClassGo hay un lugar para ti.
                    </div>
                </li>
                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong>Compromiso Real:</strong> 
                        Envíanos tu información ahora mismo. Nuestro equipo de RRHH revisará tu perfil y <strong>nos pondremos en contacto contigo enseguida.</strong>
                    </div>
                </li>
                <li>
                    <i class="am-icon-check-circle"></i>
                    <div>
                        <strong>Crecimiento Exponencial:</strong> 
                        Buscamos socios estratégicos para transformar la empresa.
                    </div>
                </li>
            </ul>

            <div class="am-areas-badge">
                <strong>Prioridad actual:</strong> TI • Marketing • Finanzas • Administración • Ventas • ¡Y más!
            </div>
        </div>

        <div class="am-form-side">
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="color: var(--primary-color); margin:0;"></h3>
                <p style="font-size: 1.1rem; color:var(--primary-color); font-weight: 600;">Solo te tomará unos minutos.</p>
            </div>

            <livewire:frontend.recruitment-form />
        </div>
    </div>
</div>
<script>
    function showRecruitmentModal() {
        document.getElementById('recruitment-modal').classList.add('show');
    }

    function closeRecruitmentModal() {
        document.getElementById('recruitment-modal').classList.remove('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const isLoggedIn = @json($isLoggedIn);
        const modalId = 'classgo_recruitment_shown';
        const now = new Date().getTime();
        const oneHour = 60 * 60 * 1000;

        let shouldShow = false;

        if (isLoggedIn) {
            const lastShown = localStorage.getItem(modalId);
            if (!lastShown || (now - lastShown) > oneHour) {
                shouldShow = true;
                localStorage.setItem(modalId, now);
            }
        } else {
            // Para invitados, lo mostramos siempre (quitar sessionStorage para pruebas)
            shouldShow = true;
            console.log("Recruitment: Guest user detected, showing popup.");
        }

        if (shouldShow) {
            console.log("Recruitment: Modal will show in 1 second.");
            setTimeout(showRecruitmentModal, 1000);
        } else {
            console.log("Recruitment: Modal skipped due to cache.");
        }
    });

    window.addEventListener('recruitment-sent', event => {
        setTimeout(closeRecruitmentModal, 3000); // Cierra automáticamente tras éxito
    });
</script>
