@extends('vistas.view.layouts.app')

@section('content')
<div class="container-buscartutor">
    <!-- Hero Section -->
    <section class="buscartutor-hero-section">
        <div class="buscartutor-container">
            <div class="buscartutor-hero-grid">
                <div>
                    <p class="buscartutor-hero-label" data-translate="tutores_encontrar">Tutores / Encontrar tutor</p>
                    <h1 class="buscartutor-hero-title" data-translate="descubra_tutor">Descubra un tutor en línea capacitado para sus estudios</h1>
                    <p class="buscartutor-hero-desc" data-translate="domina_tus_estudios">
                        Domina tus estudios con tutorías personalizadas en línea impartidas por educadores expertos. Nuestros tutores capacitados están aquí para ayudarlo a construir bases sólidas y alcanzar sus objetivos académicos.
                    </p>
                </div>
                <div class="buscartutor-hero-img-col">
                    <img src="{{ asset('storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif') }}"
                        alt="Mascota de ClassGo"
                        class="buscartutor-hero-img"
                        onerror="this.onerror=null; this.src='https://placehold.co/300x300/ffffff/023047?text=ClassGo';">
                </div>
            </div>
        </div>
    </section>

    <livewire:buscar-tutor />
</div>

<!-- Scripts -->

<script>
    // Hacer la función selectLanguage global si no lo está
    window.applyLanguage = function() {
        const savedLang = localStorage.getItem("selectedLanguage") || "es";
        selectLanguage(savedLang, false); // no cerrar dropdown
    }

    // Traducir al cargar la página
    document.addEventListener("DOMContentLoaded", applyLanguage);

    // Traducir cuando Livewire renderiza o actualiza contenido
    document.addEventListener("livewire:load", applyLanguage);
    document.addEventListener("livewire:update", applyLanguage);
</script>
<script src="{{ asset('js/translations.js') }}"></script>
@endsection