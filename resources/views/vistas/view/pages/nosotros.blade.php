@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')
    <!--NOSOTROS-->
    <section class="nosotros">
        <div class="nosotros-container">
            <div class="nosotros-header fade-down">
                <div class="nosotros-header-content ">
                    <div class="nosotros-header-text fade-left">
                        <nav class="breadcrumb">
                            <a href="{{ route('home') }}" class="breadcrumb-link"><span data-translate="ini_n"></span></a> /
                            <span class="breadcrumb-current" data-translate="i_nos"></span>
                        </nav>
                        <h1 data-translate="who"></h1>
                        <p data-translate="plataforma_d_tutoria">
                        </p>
                    </div>
                    <div class="nosotros-header-image">
                        <img src="{{ asset('images/home/tugo2.webp') }}" alt="Misión ClassGo" class="tugo-image">
                    </div>
                </div>
            </div>

            <div class="nosotros-mision" id="mision">
                <div class="nosotros-mision-text fade-left">
                    <h2 class="nosotros-mision-title" data-translate="mision"></h2>
                    <p class="nosotros-mision-text-general1" data-translate="plataforma_d_educacion">
                    </p>
                    <p class="nosotros-mision-text-general2" data-translate="proporcionamos_educacion">
                    </p>
                </div>
                <div class="nosotros-mision-image">
                    {{-- <p class="nosotros-mision-porcentaje">
                    <span class="nosotros-mision-porcentaje-text">
                        +200 <!-- Porcentaje de Tutores Disponibles -->
                    </span>
                    <span class="nosotros-porcentaje-subtext" data-translate="tutorias_disponibles">
                    </span>
                </p> --}}
                    <img src="{{ asset('images/home/models/img1.webp') }}" alt="Misión ClassGo" class="tugo-image">
                </div>
            </div>

            <div class="nosotros-vision" id="vision">
                <div class="vision-image">
                    <img src="{{ asset('images/home/models/img2.webp') }}" alt="Visión ClassGo" class="tugo-image">
                </div>
                <div class="nosotros-vision-text fade-right">
                    <h2 class="nosotros-vision-title" data-translate="vision"></h2>
                    <p class="nosotros-vision-subtext" data-translate="ser_plataforma_lider">
                    </p>
                    <p class="nosotros-vision-subtext2" data-translate="fomentar_aprendizaje">
                    </p>
                </div>
            </div>

            <!-- SECCIÓN ALIANZAS -->
            <div class="alianzas-eventos-section">
                <div class="section-header">
                    <span data-translate="alianzas" class="section-tagline-nosotros"></span>
                    <h1 class="over-text-nosotros"><span data-translate="alianzas_edu"></span></h1>
                    <p class="section-description-nosotros">
                        <span data-translate="alianzas_Classgo"></span>
                    </p>
                </div>

                <div class="alianzas-eventos-grid">
                    @foreach ($alianzas as $alianza)
                        <div class="fade-up">
                            <div class="alianza-evento-card animate-in">
                                @if ($alianza->imagen)
                                    @php
                                        $imagePath = storage_path('app/public/' . $alianza->imagen);
                                        $imageExists = file_exists($imagePath);
                                    @endphp

                                    @if ($imageExists)
                                        @php
                                            $imageData = base64_encode(file_get_contents($imagePath));
                                            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                            $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="{{ $alianza->titulo }}"
                                            class="client-logo alianza-evento-imagen">
                                    @else
                                        <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                            class="client-logo alianza-evento-imagen">
                                    @endif
                                    {{-- <img 
                            src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" 
                            alt="Imagen de {{ $alianza->titulo }}" 
                            class="client-logo alianza-evento-imagen"> --}}
                                @else
                                    <img src="{{ asset('storage/' . $alianza->imagen) }}" alt="{{ $alianza->titulo }}"
                                        class="client-logo alianza-evento-imagen">
                                @endif

                                <div class="alianza-evento-info">
                                    <h3>{{ $alianza->titulo }}</h3>
                                    <p class="alianza-descripcion">{{ $alianza->descripcion }}</p>
                                    <button class="btn-blanco" onclick="window.open('{{ $alianza->enlace }}', '_blank')">
                                        Visitar sitio
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SECCION TEAM-->
            <div class="team-section" id="team">
                <div class="team-header">
                    <h1 class="team-title" data-translate="team"></h1>
                    <p class="team-subtitle" data-translate="creadores_classgo"></p>
                </div>

                <div class="team-grid">
                    <div class="team-member first-card fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/gabriel.jpeg') }}" alt="Foto de Gabriel Alpiry Hurtado"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/gabriel-alpiry-hurtado-1a6083a5/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Gabriel Alpiry Hurtado</h3>
                        <p class="member-title">CEO & Founder</p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/daniel.webp') }}" alt="Foto de Daniel"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/jose-daniel-aguirre-antelo-193119187/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Jose Aguirre Antelo</h3>
                        <p class="member-title" data-translate="jefi_rol"></p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/carlos.webp') }}" alt="Foto de Carlos Mamani Torrez"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/carlosenriquemamani/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Carlos Mamani Torrez</h3>
                        <p class="member-title">Coordinador TI</p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/ronald.webp') }}" alt="Foto de Carlos Mamani Torrez"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/carlosenriquemamani/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Ronald Flores</h3>
                        <p class="member-title" data-translate="jefi_Fdeveloper_rol"></p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/oscar.webp') }}" alt="Foto de Carlos Mamani Torrez"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/carlosenriquemamani/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Oscar Cruz</h3>
                        <p class="member-title" data-translate="jefi_Bdeveloper_rol"></p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/jose.webp') }}" alt="Foto de Carlos Mamani Torrez"
                                    class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/carlosenriquemamani/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Jose Felix Bruno</h3>
                        <p class="member-title">Coordinador Contabilidad</p>
                    </div>

                    <div class="team-member fade-up">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/jhonny.webp') }}" alt="Foto de Jhonny Durán"
                                    class="member-photo">
                            </div>
                            <a href="http://www.linkedin.com/in/jhonny-alfredo-duran-marin-804618376" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Jhonny Durán</h3>
                        <p class="member-title" data-translate="jefi_Bdeveloper_rol"></p>
                    </div>
                </div>

            </div>

        </div>


    </section>

    <script>
        // ===========================
        // 1. ANIMACIONES AL HACER SCROLL
        // ===========================
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.2
        });

        // Observar elementos con clases de animación
        document.querySelectorAll('.fade-up, .fade-left, .fade-right, .fade-down').forEach(el => {
            scrollObserver.observe(el);
        });
    </script>
@endsection
