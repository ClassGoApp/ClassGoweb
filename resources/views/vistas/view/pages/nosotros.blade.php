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
                            <a href="{{ route('home') }}" class="breadcrumb-link">Inicio</a> / <span class="breadcrumb-current">Nosotros</span>
                        </nav>
                        <h1>¿Quiénes Somos?</h1>
                        <p>
                            Somos una plataforma de tutorías en línea que conecta a estudiantes de todas las edades con
                            tutores expertos.
                            Te proporcionamos una experiencia accesible y de calidad, independientemente de tu ubicación u
                            horario.
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
                    <h2 class="nosotros-mision-title">Misión</h2>
                    <p class="nosotros-mision-text-general1">
                        Plataforma educativa de tutorías virtuales para compartir conocimientos.
                    </p>
                    <p class="nosotros-mision-text-general2">
                        Proporcionamos una plataforma educativa de tutorías virtuales accesibles las 24 horas, dirigida a
                        toda
                        persona que quiera compartir su conocimiento, con contenido que abarca desde nivel universitario
                        hasta
                        habilidades técnicas.
                    </p>
                </div>
                <div class="nosotros-mision-image">
                    <p class="nosotros-mision-porcentaje">
                        <span class="nosotros-mision-porcentaje-text">
                            +200 <!-- Porcentaje de Tutores Disponibles -->
                        </span>
                        <span class="nosotros-porcentaje-subtext">
                            Tutorías disponibles
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
                    <h2 class="nosotros-vision-title">Visión</h2>
                    <p class="nosotros-vision-subtext">
                       Impulsar el crecimiento del aprendizaje.
                    </p>
                    <p class="nosotros-vision-subtext2">
                        Ser la plataforma líder en tutorías virtuales, fomentando el aprendizaje continuo y la accesibilidad
                        educativa en todas las áreas del conocimiento.
                    </p>
                </div>
            </div>

            <div class="team-section">
                <div class="team-header">
                    <h1 class="team-title">Nuestro Equipo</h1>
                    <p class="team-subtitle">Los creadores de la página y app de ClassGo, dedicados a revolucionar la educación.</p>
                </div>

                <div class="team-grid">
                    <div></div>
                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/gabriel.webp')}}" alt="Foto de Gabriel Alpiry Hurtado" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <img src="{{ asset('') }}" alt="">
                                <svg class="arrow-icon" xmlns="http viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Gabriel Alpiry Hurtado</h3>
                        <p class="member-title">CEO ClassGo</p>
                    </div>
                    <div></div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/edwar.webp')}}" alt="Foto de Edward Rojas" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Edward Rojas</h3>
                        <p class="member-title">Coordinador General</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/antonio.webp')}}" alt="Foto de Antonio Sandoval Flores" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Antonio Sandoval Flores</h3>
                        <p class="member-title">Encargado de Operaciones</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/alvaro.webp')}}" alt="Foto de Alvaro Rojas" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Alvaro Rojas</h3>
                        <p class="member-title">Desarrollador Mobile</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/alejandro.webp')}}" alt="Foto de Alejandro Calzadilla Nogales" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Alejandro Calzadilla</h3>
                        <p class="member-title">Backend Developer</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/carlos.webp')}}" alt="Foto de Carlos Mamani Torrez" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Carlos Mamani Torrez</h3>
                        <p class="member-title">Frontend Developer</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/jhonny.webp')}}" alt="Foto de Jhonny Durán" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Jhonny Durán</h3>
                        <p class="member-title">Software Architecture</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/micaela.webp')}}" alt="Foto de Jhonny Durán" class="member-photo">
                            </div>
                            <a href="#" class="member-link">
                                <svg class="arrow-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                        <h3 class="member-name">Mikaela Leon</h3>
                        <p class="member-title">Diseñadors</p>
                    </div>

                </div>
            </div>

        </div>

        
    </section>
@endsection
