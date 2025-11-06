<section class="client-testimonials-section">
	<div class="section-header">
		<span class="section-tagline"></span>
		<h1 class="over-text"><span data-translate="alianzas"></span></h1>

		<h1 class="section-title"><span data-translate="alianzas_edu"></span></h1>
		<p class="section-description">
			<span data-translate="alianzas_Classgo_1"></span>
		</p>
	</div>

	<div class="client-carousel-wrapper">
		<div id="client-carousel-container" class="client-carousel-container">
			<div id="client-carousel-track" class="client-carousel-track">
				@foreach($alianzas as $alianza)
				  <img src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" alt="Imagen de {{ $alianza->titulo }}" onclick="window.location.href='{{ $alianza->enlace }}' "> 
        @endforeach
			</div>
		</div>
	</div>
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

