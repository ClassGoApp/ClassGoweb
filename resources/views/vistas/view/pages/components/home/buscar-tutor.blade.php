<h1 class="header-main__title">Descubre un Tutor en Línea para tus Estudios</h1>
<p class="header-main__subtitle">
    Domina cualquier materia con la ayuda de nuestros tutores expertos y alcanza tus metas académicas.
</p>
<div class="buscar-tutor-wrapper">
        @livewire('buscar-tutor')
</div>


<p class="header-main__subtitle" id="texto">
    ¿Que deseas aprender?
</p>
<script>
    const textoPlaceholder = document.querySelector('#texto');

    // MANTENER EL SCRIPT DEL PLACEHOLDER ANIMADO
    document.addEventListener('DOMContentLoaded', () => {
        const inputElement = document.getElementById('searchInput');
        if (!inputElement) return;

        const texts = [
            "Busca por nombre del tutor: Gariel Alpiry...",
            "Busca por materia: Matemáticas, Contabilidad...",
            "Buscar por temas: Álgebra, Cálculo..."
        ];

        const typingSpeed = 70;
        const erasingSpeed = 40;
        const newTextDelay = 500;

        let textIndex = 0;
        let charIndex = 0;

        function type() {
            if (charIndex < texts[textIndex].length) {
                inputElement.placeholder += texts[textIndex].charAt(charIndex);
                charIndex++;
                setTimeout(type, typingSpeed);
            } else {
                setTimeout(erase, newTextDelay);
            }
        }

        function erase() {
            if (charIndex > 0) {
                inputElement.placeholder = texts[textIndex].substring(0, charIndex - 1);
                charIndex--;
                setTimeout(erase, erasingSpeed);
            } else {
                textIndex++;
                if (textIndex >= texts.length) {
                    textIndex = 0;
                }
                setTimeout(type, typingSpeed);
            }
        }

        setTimeout(type, newTextDelay);
    });
</script>