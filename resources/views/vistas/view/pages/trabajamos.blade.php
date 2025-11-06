@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | Cómo trabajamos')

@section('body-class', 'trabajamos')

@section('content')
<!--TRABAJAMOS-->
<section class="trabajamos">
    <div class="trabajamos-container">

        <div class="trabajamos-header fade-down">
            <div class="trabajamos-header-content">
                <div class="trabajamos-header-text align-left">
                    <nav class="breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-link" data-translate="inicio"></a> / <span class="breadcrumb-current" data-translate="como_trabajamos"></span>
                    </nav>
                    <h1 data-translate="unete_comunidad"></h1>
                    <p data-translate="unete_comunidad_desc">

                    </p>
                </div>
                <div class="trabajamos-tabs tabs-centered">
                    <div class="tab-buttons">
                        <button class="tab-button active" data-tab="estudiantes">
                            <i class="fa-solid fa-book"></i>
                            <span data-translate="para_estudiantes"></span>
                        </button>
                        <button class="tab-button" data-tab="tutores">
                            <i class="fa-solid fa-briefcase"></i>
                            <span data-translate="para_tutores"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Estudiantes Tab Content -->
        <div class="tab-content active" id="estudiantes-content">
            <!-- Sección 1: Complete sus datos -->
            <div class="trabajamos-section-white">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-text fade-left">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <h2 data-translate="completa_datos"></h2>
                        <p data-translate="completa_datos_desc">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugotecnológico.webp') }}" alt="Estudiante completando datos">
                    </div>
                </div>
            </div>

            <!-- Sección 2: Utilice filtros -->
            <div class="trabajamos-section-white">
                <div class="trabajamos-section-content reverse">
                    
                    <div class="trabajamos-text fade-up">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <h2 data-translate="utiliza_filtros"></h2>
                        <p data-translate="utiliza_filtros_desc">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugoconlaptop.webp') }}" alt="tugoconlaptop">
                    </div>
                </div>
            </div>

            <!-- Sección 3: Elija un horario -->
            <div class="trabajamos-section-primary">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-text fade-left">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 data-translate="asiste_leccion"></h3>
                        <h2 data-translate="elige_horario"></h2>
                        <h4 data-translate="pasos_reservar"></h4>
                        <ol>
                            <li data-translate="paso_select_time"></li>
                            <li data-translate="paso_click_slot"></li>
                            <li data-translate="paso_choose_type"></li>
                            <li data-translate="paso_confirm_booking"></li>
                            <li data-translate="paso_payment"></li>
                            <li data-translate="paso_receive_confirmation"></li>
                        </ol>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugoprofesor.webp') }}" alt="tugoprofesor">
                    </div>
                </div>
            </div>

            <!-- Sección 4: Inicie sesión -->
            <div class="trabajamos-section-primary">
                <div class="trabajamos-section-content reverse">

                    <div class="trabajamos-text fade-up">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 data-translate="asiste_leccion_login"></h3>
                        <h2 data-translate="asiste_login_desc"></h2>
                        <p data-translate="asiste_presen">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugo_With_Phone.webp') }}" alt="Estudiante en clase">
                    </div>
                </div>
            </div>

            <!-- Sección 5: Complete formulario -->
            <div class="trabajamos-section-white">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-text fade-left">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h3 data-translate="asiste_feedback"></h3>
                        <h2 data-translate="completa_form"></h2>
                        <p data-translate="feedback_desc">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/TuGoconMegafono.webp') }}" alt="Estudiante dando feedback">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutores Tab Content -->
        <div class="tab-content" id="tutores-content">
            <!-- Contenido para tutores (similar estructura) -->
            <div class="trabajamos-section-white">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-text fade-left">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <h2 data-translate="crea_perfil"></h2>
                        <p data-translate="crea_perfil_cont">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugoprofesor2.webp') }}" alt="Tutor completando perfil">
                    </div>
                </div>
            </div>
            <!-- Más secciones para tutores... -->

            <div class="trabajamos-section-white">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugo_With_Glasses2.webp') }}" alt="Tutor completando perfil">
                    </div>
                    <div class="trabajamos-text fade-up">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <h2 data-translate="gestiona_horario"></h2>
                        <p data-translate="gestiona_horario_desc">
                        </p>
                    </div>

                </div>
            </div>

            <!-- Sección 3 Revisar -->
            <div class="trabajamos-section-primary">
                <div class="trabajamos-section-content">
                    <div class="trabajamos-text fade-left">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 data-translate="asiste_leccion"></h3>
                        <h2 data-translate="revisar_solicitudes"></h2>
                        <p data-translate="revisar_solicitudes_desc">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugoprofesor.webp') }}" alt="Estudiante reservando">
                    </div>
                </div>
            </div>

            <!-- Sección 4: Inicie sesión -->
            <div class="trabajamos-section-primary">
                <div class="trabajamos-section-content reverse">

                    <div class="trabajamos-text fade-up">
                        <div class="trabajamos-icon">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <h3 data-translate="dirige_clase"></h3>
                        <h2 data-translate="dirige_clase"></h2>
                        <p data-translate="dirige_clase_desc">
                        </p>
                    </div>
                    <div class="trabajamos-image">
                        <img src="{{ asset('images/home/Tugo_With_Phone.webp') }}" alt="Estudiante en clase">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="trabajamos-footer">
            <div class="trabajamos-footer-content">
                <h3 data-translate="proceso_calidad"></h3>
                <h2 data-translate="unete_comunidad_repetido"></h2>
                <p data-translate="unete_comunidad_repetido_desc">
                </p>
            </div>
        </div>
    </div>
</section>

<script>
    // Funcionalidad de tabs
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remover clase active de todos los botones y contenidos
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Agregar clase active al botón clickeado y su contenido
                this.classList.add('active');
                document.getElementById(targetTab + '-content').classList.add('active');
            });
        });
    });
         
    // ===========================
    // 1. ANIMACIONES AL HACER SCROLL
    // ===========================
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.2 });

    // Observar elementos con clases de animación
    document.querySelectorAll('.fade-up, .fade-left, .fade-right, .fade-down').forEach(el => {
        scrollObserver.observe(el);
    });
</script>
@endsection