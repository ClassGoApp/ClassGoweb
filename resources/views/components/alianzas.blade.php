
<section class="client-testimonials-section">
    <div class="section-header">
        <span class="section-tagline"></span>
        <h1 class="over-text"><span data-translate="alianzas"></span></h1>

        <h1 class="section-title"><span data-translate="alianzas_edu"></span></h1>
        <p class="section-description">
            {{-- <span data-translate="alianzas_Classgo"></span> --}}
            <span data-translate="alianzas_Classgo_1"></span>
        </p>
    </div>

    <div class="client-carousel-wrapper">
        <div id="client-carousel-container" class="client-carousel-container">
            <div id="client-carousel-track" class="client-carousel-track">

                {{-- @foreach($alianzas as $alianza)
                    <div class="client-card-slide" onclick="window.location.href='{{ $alianza->enlace }}' ">
                        <div class="client-card">
                            <img src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" alt="Imagen de {{ $alianza->titulo }}" class="client-logo">

                            <h3 class="client-name">{{ $alianza->titulo }}</h3>
                             <p class="client-description">Plataforma de Investigación y Formación Especializada</p> ==esto estaba comentado==
                        </div>
                    </div>
                @endforeach --}}
                {{-- <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/empresalicen.png" alt="Colegio de Auditores o Contadores Publicos de Santa Cruz">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/incos.jpg" alt="Incos Santa Cruz">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/logo%20itjm.jpeg" alt="Instituto Tecnológico Jesús María Fe y Alegría">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/emi.jpeg" alt="EMI Unidad Académica Santa Cruz">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/WhatsApp%20Image%202025-05-24%20at%2011.03.44%20AM.jpeg" alt="Accion creativa">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/danis.jpeg" alt="danis restaurante">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/empresalicen.png" alt="Gabriel Alpiry Hurtado / Impuestos - Contabilidad - Auditoría">
                <img src="https://www.classgoapp.com/storage/optionbuilder/uploads/incos.jpg" alt="Tugo academy channel">
                <img src="Nuestras alianzas/club abierto.jpeg" alt="Club Abierto Tacuara Debate & Oratoria"> --}}
                 @foreach($alianzas as $alianza)
                    
                        
                            <img src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" alt="Imagen de {{ $alianza->titulo }}" onclick="window.location.href='{{ $alianza->enlace }}' ">

                @endforeach
            </div>
        </div>
    {{--<button id="client-prev-button" class="client-carousel-nav-btn prev">
            <svg xmlns="http://www.w3.org/2000/svg" class="client-carousel-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button> 
        <button id="client-next-button" class="client-carousel-nav-btn next">
            <svg xmlns="http://www.w3.org/2000/svg" class="client-carousel-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button> --}}
    </div>

{{--<div id="client-pagination-dots" class="client-pagination-dots-container">
        <button class="pagination-dot active"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
        <button class="pagination-dot"></button>
    </div> --}}
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const track = document.querySelector('#client-carousel-track');
  if (!track) return;

  const logos = Array.from(track.children);
  const logoCount = logos.length;
  if (logoCount === 0) return;

  // Clonamos los logos para crear efecto de desplazamiento infinito
  logos.forEach(logo => {
    const clone = logo.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    track.appendChild(clone);
  });

  const firstLogo = logos[0];

  function setupLogoAnimation() {
    const logoStyle = window.getComputedStyle(firstLogo);
    const logoWidth = firstLogo.offsetWidth;
    const logoMarginLeft = parseFloat(logoStyle.marginLeft) || 0;
    const logoMarginRight = parseFloat(logoStyle.marginRight) || 0;
    const logoTotalWidth = logoWidth + logoMarginLeft + logoMarginRight;

    const totalWidth = logoTotalWidth * logoCount * 2; // doble (original + clones)
    const scrollWidth = logoTotalWidth * logoCount;    // cuánto recorre antes de reiniciar
    const duration = logoCount * 2.5;                  // velocidad (ajustable)

    const animationName = 'scroll-client-logos';
    const keyframes = `
      @keyframes ${animationName} {
        0% { transform: translateX(0); }
        100% { transform: translateX(-${scrollWidth}px); }
      }
    `;

    // Inyectar animación dinámica
    const styleTag = document.createElement('style');
    styleTag.type = 'text/css';
    styleTag.textContent = keyframes;
    document.head.appendChild(styleTag);

    // Aplicar animación
    track.style.width = `${totalWidth}px`;
    track.style.display = 'flex';
    track.style.gap = '40px'; // separación entre logos
    track.style.animation = `${animationName} ${duration}s linear infinite`;
    track.style.willChange = 'transform';
  }

  if (firstLogo.complete) {
    setupLogoAnimation();
  } else {
    firstLogo.onload = setupLogoAnimation;
  }
});

</script>

