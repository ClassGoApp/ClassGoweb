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


        <div class="nosotros-mision">
            <div class="nosotros-mision-text">
                <h2 class="nosotros-mision-title" data-translate="mision"></h2>
                <p class="nosotros-mision-text-general1" data-translate="plataforma_d_educacion">

                </p>
                <p class="nosotros-mision-text-general2" data-translate="proporcionamos_educacion">

                </p>
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
                <p class="team-member-quote" data-translate="jefi_presentacion"></p>
            </div>

            <div class="nosotros-vision" id="vision">
                <div class="vision-image">
                    <img src="{{ asset('images/home/vision.webp') }}"
                        alt="Visión ClassGo" class="tugo-image">
                </div>
                <p class="team-member-quote" data-translate="opjefi_presentacion"></p>
            </div>

            <div class="team-card">
                <img src="{{ asset('images/team/alvaro.webp')}}" alt="Foto de Ana Fuentes" class="team-member-img">
                <h3 class="team-member-name">Alvaro Rojas</h3>
                <p class="team-member-role" data-translate="jefi_movil_rol"></p>
                <div class="team-member-rating">
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <p class="team-member-quote" data-translate="jefi_movil_presentacion"></p>
            </div>

            <div class="team-card">
                <img src="{{ asset('images/team/alejandro.webp')}}" alt="" class="team-member-img">
                <h3 class="team-member-name">Alejandro Calzadilla Nogales</h3>
                <p class="team-member-role" data-translate="jefi_Bdeveloper_rol"></p>
                <div class="team-member-rating">
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <p class="team-member-quote" data-translate="jefi_Bdeveloper_presentacion"></p>
            </div>

            <div class="team-card">
                <img src="{{ asset('images/team/carlos.webp')}}" alt="" class="team-member-img">
                <h3 class="team-member-name" data-translate="jefi_Fdeveloper"></h3>
                <p class="team-member-role" data-translate="jefi_Fdeveloper_rol"></p>
                <div class="team-member-rating">
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <p class="team-member-quote" data-translate="jefi_Fdeveloper_presentacion"></p>
            </div>

            <div class="team-card">
                <img src="{{ asset('images/tutors/default.png')}}" alt="" class="team-member-img">
                <h3 class="team-member-name">Jhonny Durán</h3>
                <p class="team-member-role" data-translate="jefi_sofware_rol"></p>
                <div class="team-member-rating">
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="rating-star" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <p class="team-member-quote" data-translate="jefi_sofware_presentacion"></p>
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
                                <img src="{{ asset('images/team/gabriel.jpeg')}}" alt="Foto de Gabriel Alpiry Hurtado" class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/gabriel-alpiry-hurtado-1a6083a5/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Gabriel Alpiry Hurtado</h3>
                        <p class="member-title">CEO ClassGo</p>
                    </div>
                    <div></div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/daniel.webp')}}" alt="Foto de Edward Rojas" class="member-photo">
                            </div>
                            <a href="https://www.linkedin.com/in/jose-daniel-aguirre-antelo-193119187/" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Jose Aguirre Antelo</h3>
                        <p class="member-title">Coordinador General</p>
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
                        <p class="member-title">Desarrollador Mobile</p>
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
                        <p class="member-title">Frontend Developer</p>
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
                        <p class="member-title">Backend Developer</p>
                    </div>

                    <div class="team-member">
                        <div class="member-item">
                            <div class="member-photo-wrapper">
                                <img src="{{ asset('images/team/micaela.webp')}}" alt="Foto de Jhonny Durán" class="member-photo">
                            </div>
                            <a href="http://www.linkedin.com/in/micaela-leon-77b518380" class="member-link">
                                <img class="arrow-icon" src="{{ asset('images/team/linkedin.png') }}" alt="">
                            </a>
                        </div>
                        <h3 class="member-name">Mikaela Leon</h3>
                        <p class="member-title">Diseñadora Gráfica</p>
                    </div>

                </div>
            </div>

        </div>

        
    </section>
@endsection
