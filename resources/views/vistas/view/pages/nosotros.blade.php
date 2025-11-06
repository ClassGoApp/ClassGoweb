@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')
<!--NOSOTROS-->
<section class="nosotros">
    <div class="nosotros-container">
        <div class="nosotros-header">
            <div class="nosotros-header-content">
                <div class="nosotros-header-text">
                    <nav class="breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-link"><span data-translate="ini_n"></span></a> / <span class="breadcrumb-current" data-translate="i_nos"></span>
                    </nav>
                    <h1 data-translate="who"></h1>
                    <p data-translate="plataforma_d_tutoria">
                    </p>
                </div>
                <div class="nosotros-header-image">
                    <img src="{{ asset('images/home/tugo2.webp') }}"
                        alt="Misión ClassGo" class="tugo-image">
                </div>
            </div>
        </div>

        <div class="nosotros-mision" id="mision">
            <div class="nosotros-mision-text">
                <h2 class="nosotros-mision-title" data-translate="mision"></h2>
                <p class="nosotros-mision-text-general1" data-translate="plataforma_d_educacion">
                </p>
                <p class="nosotros-mision-text-general2" data-translate="proporcionamos_educacion">
                </p>
            </div>
            <div class="nosotros-mision-image">
                <p class="nosotros-mision-porcentaje">
                    <span class="nosotros-mision-porcentaje-text">
                        +200 <!-- Porcentaje de Tutores Disponibles -->
                    </span>
                    <span class="nosotros-porcentaje-subtext" data-translate="tutorias_disponibles">
                    </span>
                </p>
                <img src="{{ asset('images/home/mision.webp') }}" alt="Misión ClassGo" class="tugo-image">
            </div>
        </div>

        <div class="nosotros-vision" id="vision">
            <div class="vision-image">
                <img src="{{ asset('images/home/vision.webp') }}"
                    alt="Visión ClassGo" class="tugo-image">
            </div>
            <div class="nosotros-vision-text">
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
                @foreach($alianzas as $alianza)
                    <div class="alianza-evento-card animate-in">
                        <img 
                            src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" 
                            alt="Imagen de {{ $alianza->titulo }}" 
                            class="client-logo alianza-evento-imagen">

                        <div class="alianza-evento-info">
                            <h3>{{ $alianza->titulo }}</h3>
                            <p class="alianza-descripcion">{{ $alianza->descripcion }}</p>
                            <button class="btn-blanco" onclick="window.open('{{ $alianza->enlace }}', '_blank')">
                                Visitar sitio
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SECCION TEAM-->
        <div class="team-section">
            <div class="team-header">
                <h1 class="team-title" data-translate="team"></h1>
                <p class="team-subtitle" data-translate="creadores_classgo"></p>
            </div>

            <div class="team-grid">
                <div class="team-member first-card">
                    <div class="member-item">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('images/team/gabriel.jpeg')}}" alt="Foto de Gabriel Alpiry Hurtado" class="member-photo">
                        </div>
                        <a href="https://www.linkedin.com/in/gabriel-alpiry-hurtado-1a6083a5/" class="member-link">
                            <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                        </a>
                    </div>
                    <h3 class="member-name">Gabriel Alpiry Hurtado</h3>
                    <p class="member-title">CEO & Founder</p>
                </div>

                <div class="team-member">
                    <div class="member-item">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('images/team/daniel.webp')}}" alt="Foto de Daniel" class="member-photo">
                        </div>
                        <a href="https://www.linkedin.com/in/jose-daniel-aguirre-antelo-193119187/" class="member-link">
                            <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                        </a>
                    </div>
                    <h3 class="member-name">Jose Aguirre Antelo</h3>
                    <p class="member-title" data-translate="jefi_rol"></p>
                </div>

                <div class="team-member">
                    <div class="member-item">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('images/team/alvaro.webp')}}" alt="Foto de Alvaro Rojas" class="member-photo">
                        </div>
                        <a href="https://www.linkedin.com/in/alvaro-rojas-machuca/" class="member-link">
                            <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                        </a>
                    </div>
                    <h3 class="member-name">Alvaro Rojas</h3>
                    <p class="member-title" data-translate="jefi_movil_rol"></p>
                </div>

                <div class="team-member">
                    <div class="member-item">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('images/team/carlos.webp')}}" alt="Foto de Carlos Mamani Torrez" class="member-photo">
                        </div>
                        <a href="www.linkedin.com/in/carlosenriquemamani" class="member-link">
                            <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                        </a>
                    </div>
                    <h3 class="member-name">Carlos Mamani Torrez</h3>
                    <p class="member-title" data-translate="jefi_Fdeveloper_rol"></p>
                </div>

                <div class="team-member">
                    <div class="member-item">
                        <div class="member-photo-wrapper">
                            <img src="{{ asset('images/team/jhonny.webp')}}" alt="Foto de Jhonny Durán" class="member-photo">
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
@endsection