<!--Estilos en tutoria-instantanea.css-->
@extends('vistas.view.layouts.app')

@section('content')

<section class="tutoria-instantanea-section">
    <div class="tutoria-instantanea-header-content">
        <div class="container-text-header">
            
            <h1 class="header-main__title" style="color: white;">¡Tutor al Instante!</h1>
            <p class="header-main__subtitle" style="color: white">
                Elige una materia y conecta al momento con un tutor disponible.
            </p>
            <livewire:buscar-tutor>
            <p class="header-main__subtitle" style="padding-top: 1rem; color:white;" id="texto">
                ¿Que deseas aprender?
            </p>
            <div class="loading-indicator">
                <span class="loader"></span>
            </div>
            
        </div>
    </div>

    <div class="main-tutoria-instantanea" id="">
        
        <!--Cards de los tutores-->
    </div>
</section>
    
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const texts = [
            "Prueba con: Matemáticas, Contabilidad...",
            "Álgebra, Cálculo, Química..."
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
@endsection