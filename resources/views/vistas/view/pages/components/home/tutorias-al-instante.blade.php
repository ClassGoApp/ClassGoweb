<div class="instant-info-container">

    <!-- LADO IZQUIERDO -->
    <div class="instant-info-text">

        <div class="instant-badge">
            <span class="check-icon">✓</span>
            9 tutores ya son parte de tutorías al instante
        </div>

        <h2>
            Tutorías al instante
            <span>ayuda real, en minutos</span>
        </h2>

        <p>
            ¿Tienes una duda ahora? Conéctate de inmediato con un tutor verificado
            y resuelve tus preguntas sin esperas ni citas largas.
        </p>




        @php
            $user = Auth::user();
            $isLogged = $user !== null;
            $isTutor = $user?->hasRole('tutor') ?? false;
        @endphp

        <div id="cta-container">
            @if (!$isLogged)
                <a class="instant-btn" style="cursor: pointer" href="{{ route('login') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M13 2L3 14H11L9 22L21 10H13Z" fill="currentColor" />
                    </svg>
                    Iniciar sesión
                </a>
            @elseif (!$isTutor)
                <a class="instant-btn" style="cursor: pointer" href="{{ route('student.subjects.pick') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M13 2L3 14H11L9 22L21 10H13Z" fill="currentColor" />
                    </svg>
                    Pedir tutor ahora
                </a>
            @endif
        </div>

        

    </div>

    <div class="instant-info-visual">

        <!-- Estudiante -->
        <div class="student-avatar">
            <img src="{{ asset(path: 'images/home/logoClassgo.webp') }}" alt="Estudiante">
        </div>

        <!-- Órbita -->
        <div class="orbit">
            <svg class="connection-layer" width="100%" height="100%">
                <line id="connectionLine" x1="0" y1="0" x2="0" y2="0" />
            </svg>

            <div class="tutor-card-mini">

                <div class="mini-body">
                    <div class="mini-icon avatar-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor"
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8Z" />
                        </svg>
                    </div>

                    <span class="mini-badge">MATEMÁTICAS</span>
                    <div class="mini-price">
                        Bs. 30
                    </div>
                </div>
            </div>

            <div class="tutor-card-mini">

                <div class="mini-body">
                    <div class="mini-icon avatar-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor"
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8Z" />
                        </svg>
                    </div>
                    <span class="mini-badge">PROGRAMACIÓN</span>
                    <div class="mini-price">
                        Bs. 35
                    </div>
                </div>
            </div>

            <div class="tutor-card-mini">

                <div class="mini-body">
                    <div class="mini-icon avatar-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor"
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8Z" />
                        </svg>
                    </div>
                    <span class="mini-badge">CÁLCULO</span>
                    <div class="mini-price">
                        Bs. 30
                    </div>
                </div>
            </div>

            <div class="tutor-card-mini">

                <div class="mini-body">
                    <div class="mini-icon avatar-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor"
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8Z" />
                        </svg>
                    </div>
                    <span class="mini-badge">LITERATURA</span>
                    <div class="mini-price">
                        Bs. 40
                    </div>
                </div>
            </div>

            <div class="tutor-card-mini">

                <div class="mini-body">
                    <div class="mini-icon avatar-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path fill="currentColor"
                                d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12Zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8Z" />
                        </svg>
                    </div>
                    <span class="mini-badge">MARKETING</span>
                    <div class="mini-price">
                        Bs. 25
                    </div>
                </div>
            </div>

        </div>

    </div>


</div>

<style>
    @keyframes ctaPulse1 {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 243, 251, 0.8);
            ;
            opacity: 1;
        }

        70% {
            box-shadow: 0 0 0 25px rgba(0, 243, 251, 0.20);
            opacity: 1;
        }

        100% {
            box-shadow: 0 0 0 80px rgba(0, 243, 251, 0);
            opacity: 1;
        }
    }

    .instant-info {
        padding: 100px 20px;
        background: linear-gradient(135deg,
                #071c2f,
                #0b3a5a,
                #1395b6);
        color: #ffffff;
        text-align: left;
        position: relative;
        overflow: hidden;
    }

    .instant-info-container {
        max-width: 1200px;
        margin: auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    /* ---------- TEXTO ---------- */

    .instant-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(6px);
        font-size: 14px;
        margin-bottom: 24px;
    }

    .check-icon {
        width: 18px;
        height: 18px;
        background: #2ecc71;
        color: white;
        border-radius: 50%;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .instant-info h2 {
        font-size: 48px;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .instant-info h2 span {
        display: block;
        color: #9be7ff;
        text-shadow: 0 0 12px rgba(155, 231, 255, 0.6);
    }

    .instant-info p {
        font-size: 18px;
        opacity: 0.9;
        margin-bottom: 40px;
    }

    /* ---------- BOTÓN ---------- */

    .instant-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 16px 34px;
        border-radius: 999px;
        background: linear-gradient(135deg, #4fd1ff, #2bb0ff);
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        text-decoration: none;
        box-shadow: 0 0 30px rgba(79, 209, 255, 0.65);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .instant-btn svg {
        width: 18px;
        height: 18px;
    }

    .instant-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 0 45px rgba(79, 209, 255, 0.9);
    }

    /* ---------- VISUAL ---------- */

    .instant-info-visual {
        position: relative;
        width: 420px;
        height: 420px;
        margin: auto;
        background-color: color-mix(in srgb, var(--primary-color) 50%, transparent);
        border-radius: 8rem;
    }

    /* Centro (estudiante) */
    .student-avatar {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 120px;
        height: 120px;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        background: radial-gradient(circle,
                rgba(79, 209, 255, 0.35),
                rgba(255, 255, 255, 0.08));
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        border: 2px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 0 40px rgba(79, 209, 255, 0.5);
        animation: ctaPulse1 1.5s infinite;
    }

    .student-avatar::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        border: 2px solid rgba(79, 209, 255, 0.35);
        box-shadow: 0 0 30px rgba(79, 209, 255, 0.4);
        z-index: -1;
    }

    .student-avatar img {
        width: 104%;
        opacity: 1;
    }

    /* Órbita */
    .orbit {
        position: absolute;
        inset: 0;
    }

    /* ---------- TARJETAS ---------- */
    .connection-layer {
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
    }

    #connectionLine {
        stroke: rgba(79, 209, 255, 0.9);
        stroke-width: 2;
        stroke-dasharray: 6 6;
        opacity: 0;
        filter: drop-shadow(0 0 6px rgba(79, 209, 255, 0.8));
        transition: opacity 0.3s ease;
    }


    /* ================= MINI CARD ================= */
    .tutor-card-mini {
        position: absolute;
        top: 50%;
        left: 50%;

        width: 120px;
        padding: 14px;
        border-radius: 18px;

        background: linear-gradient(145deg,
                rgba(255, 255, 255, .45),
                rgba(235, 245, 255, .55));

        backdrop-filter: blur(8px);

        box-shadow:
            0 12px 28px rgba(0, 0, 0, .18),
            inset 0 1px 0 rgba(255, 255, 255, .6);

        display: flex;
        align-items: center;
        justify-content: center;

        font-weight: 800;
        font-size: .75rem;
        color: #023047;

        transform-origin: center center;
        transition: box-shadow .3s ease, transform .3s ease;
        z-index: 4;
    }

    .tutor-card-mini.active {
        box-shadow:
            0 0 0 3px rgba(79, 209, 255, .9),
            0 30px 60px rgba(79, 209, 255, .7);
    }

    .tutor-card-mini:hover {
        transform: translateY(-6px) scale(1.05);
        box-shadow:
            0 0 0 3px rgba(79, 209, 255, .9),
            0 30px 60px rgba(79, 209, 255, .65);
    }

    /* ================= HEADER ================= */
    .mini-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .65rem;
        font-weight: 800;
    }

    .mini-badge {
        padding: .3rem .6rem;
        border-radius: 999px;
        background: rgba(2, 48, 71, .08);
        color: #023047;
    }

    /* ================= BODY ================= */
    .mini-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .mini-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4fd1ff, #2bb0ff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: 0 8px 18px rgba(79, 209, 255, .6);
    }

    .avatar-icon {
        background: #b9b9b9;
        color: #64748b;
        box-shadow: none;
    }

    .avatar-icon svg {
        width: 22px;
        height: 22px;
        color: white;
    }

    .mini-price {
        font-size: 1.05rem;
        font-weight: 900;
        color: #0f172a;
    }

    .mini-price small {
        display: block;
        font-size: .65rem;
        font-weight: 600;
        color: #64748b;
    }

    /* ================= BUTTON ================= */
    .mini-btn {
        border: none;
        border-radius: 999px;
        padding: .6rem;
        font-size: .7rem;
        font-weight: 800;
        cursor: pointer;

        background: linear-gradient(135deg, #023047, #219EBC);
        color: white;

        transition: all .3s ease;
    }

    .mini-btn:hover {
        background: #FB8500;
        color: #023047;
    }

    /* toast */
    

    

    /* ---------- RESPONSIVE ---------- */

    @media (max-width: 768px) {
        .instant-info-container {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .instant-info-visual {
            width: 280px;
            height: 280px;
            margin-top: 60px;
        }

        .student-avatar {
            width: 110px;
            height: 110px;
        }

        .tutor-card-instant {
            width: 100px;
            font-size: 13px;
        }
    }
</style>
<script>
    /* ========= SETUP ========= */
    const $ = s => document.querySelector(s);
    const cards = [...document.querySelectorAll('.tutor-card-mini')];

    const visual = $('.instant-info-visual');
    const avatar = $('.student-avatar');
    const line = $('#connectionLine');

    const isMobile = innerWidth <= 400;

    const CFG = {
        radius: isMobile ? 100 : 170,
        speed: 0.18,
        approach: 80,
        lineOffset: 30,
        cycle: 5200,
        inspect: 1500,
        return: 600
    };

    let angle = 0;
    let active = 0;
    let target = 1;
    let state = 'rotating';

    cards.forEach((c, i) => c.dataset.base = i * 360 / cards.length);

    /* ========= HELPERS ========= */
    const center = r => ({
        x: r.left + r.width / 2,
        y: r.top + r.height / 2
    });

    function updateLine() {
        const v = visual.getBoundingClientRect();
        const a = center(avatar.getBoundingClientRect());
        const c = center(cards[target].getBoundingClientRect());

        const dx = c.x - a.x;
        const dy = c.y - a.y;
        const d = Math.hypot(dx, dy) || 1;

        line.setAttribute('x1', a.x - v.left);
        line.setAttribute('y1', a.y - v.top);
        line.setAttribute('x2', c.x - v.left - dx / d * CFG.lineOffset);
        line.setAttribute('y2', c.y - v.top - dy / d * CFG.lineOffset);
        line.style.opacity = 1;
    }

    /* ========= LOOP ========= */
    function animate() {
        if (!isMobile && state === 'rotating') angle += CFG.speed;

        cards.forEach((card, i) => {
            const total = angle + Number(card.dataset.base);
            const r = state === 'selecting' && i === active ?
                CFG.radius - CFG.approach :
                CFG.radius;

            card.style.transform =
                `translate(-50%,-50%) rotate(${total}deg) translate(${r}px) rotate(${-total}deg)`;
        });

        updateLine();
        requestAnimationFrame(animate);
    }

    /* ========= TIMELINE ========= */
    setInterval(() => {
        active = target;
        cards.forEach(c => c.classList.remove('active'));
        cards[active].classList.add('active');
        state = 'selecting';

        setTimeout(() => {
            cards[active].classList.remove('active');
            state = 'returning';

            setTimeout(() => {
                target = (active + 1) % cards.length;
                state = 'rotating';
            }, CFG.return);

        }, CFG.inspect);

    }, CFG.cycle);

    animate();

    function irAlInstanteDesdeFlotante() {
        const ctaTerms = document.getElementById('cta-terms');
        const seccionTutorias = document.getElementById('tutorias-instantaneas-seccion');

        // Si no ha aceptado términos y estamos en home
        if (ctaTerms && window.getComputedStyle(ctaTerms).display !== 'none') {
            if (seccionTutorias) {
                // Hacer scroll suave hacia la sección
                seccionTutorias.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Mostrar alerta después del scroll
                setTimeout(() => {
                    showTermsAlert('Debes aceptar los términos y condiciones.', 'error');
                }, 300);
            }
            return;
        }

        // Si ya aceptó términos, redirigir
        window.location.href = "{{ route('student.subjects.pick') }}";
    }

    

   
</script>
