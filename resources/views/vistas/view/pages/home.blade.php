@extends('vistas.view.layouts.app')

@section('title', 'ClassGo - Aprende y Progresa')

@section('content')


<!-- 1 - HERO -->
<section class="hero">
    <div class="hero-container">

        <!-- 1.1 Hero Titular -->
        <div class="hero-text">
            <h1 class="hero-title-arriba">Aprende y Progresa con</h1>
            <h1 class="hero-title-abajo">Tutorías en Línea</h1>
            <p class="hero-subtext">
                Alcanza tus metas con tutorías personalizadas de los mejores expertos.<br>
                Conéctate con tutores dedicados para asegurar tu éxito.
            </p>
            <p class="hero-subtext mobile">
                Conéctate con tutores dedicados para asegurar tu éxito.
            </p>

            <!-- 1.2 Buscador -->
            {{-- <div class="search-box">
                <input type="text" placeholder="Buscar Tutor...">
                <button>
                    <i class="fa-solid fa-magnifying-glass icon-search"></i>
                </button>
            </div> --}}
            <div class="buscador-home">
                @livewire('buscador-tutor')
            </div>


            <!-- 1.3 Botones-->

            <div class="hero-buttons">
                @guest
                    <a href=" {{ route('buscar.tutor')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i>Tutores</button></a>
                    <a href=" {{ route(name: 'register')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-user"></i>Regístrate</button></a>
                    <a href=" {{ route(name: 'login')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-right-to-bracket"></i>Ingresa</button></a>
                @endguest

                @auth
                    <a href=" {{ route('buscar.tutor')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i>Buscar Tutores</button></a>
                    <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><button class="button-explorar-tutores"><i class="fa-solid fa-mobile"></i>Nuestra App</button></a>
                @endauth
            </div>
         
        </div>

        <!-- 1.4 Hero Mascota -->
       
        <img src="{{ asset(path: 'storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif') }}" alt="Mascota ClassGo">


       
    </div>
</section>


<!-- CONTADORES INFO -->
<section class="info-container" id="logros">
    <!-- CONTADORES -->
    <div class="counters">
        <div class="counter-box">
            <div class="counter-number" data-target="{{ $totalUsers }}">+0</div>
            <h1 class="{{ $color ?? 'text-dark' }}">Usuarios registrados</h1>
        </div>
        <div class="box-sky"></div>
        <div class="counter-box">
            <div class="counter-number" data-target="{{ $totalTutores }}">+0</div>
            <h1 class="{{ $color ?? 'text-dark' }}">Tutores disponibles</h1>
        </div>
        <div class="box-sky"></div>
        <div class="counter-box">
            <div class="counter-number" data-target="{{ $totalEstudiantes }}">0</div>
            <h1 class="{{ $color ?? 'text-dark' }}">Estudiantes registrados</h1>
        </div>
        <div class="box-sky"></div>
        <div class="counter-box">
            <div class="counter-numbe"><i class="fa fa-star"></i>4.5</div>
            <h1 class="{{ $color ?? 'text-dark' }}">En Play Store</h1>
        </div>
    </div> 

</section>

<!--TUTORES DESTACADOS-->

<section class="tutors-container">
    <h1 class="over-text"><div class="linea"></div>Tutores Destacados<div class="linea"></div></h1>
    <h1>Encuentra tu Tutor Ideal</h1>
    <p>Descubre una variedad de temáticas académicas y prácticas para potenciar tu experiencia de aprendizaje</p> 

    

    <div class="carousel-container">
        <button id="prevBtn" class="carousel-btn prev-btn" aria-label="Anterior">&lt;</button>
        <div class="carousel-wrapper">
            <div class="carousel-track" id="carouselTrack">
                {{-- @foreach($featuredTutors as $tutor)
                    <div class="tutor-card" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}' ">
                        <button class="favorite-btn" onclick="event.stopPropagation(); this.classList.toggle('active')">⭐</button>
                        <div class="tutor-card-img">
                            <video controls preload="auto"
                                poster="https://via.placeholder.com/300x160"
                                src="{{ $tutor->profile->intro_video ? asset( 'storage/' . $tutor->profile->intro_video) : asset('images/tutors/default.png') }}"
                                onclick="event.stopPropagation()"></video>
                        </div>
                        <div class="tutor-card-content">
                            <div class="tutor-card-header">
                                <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Tutor">                                <h3>{{ $tutor->profile->first_name }} {{ $tutor->profile->last_name }}</h3> <!--NOMBRE DEL TUTOR-->
                            </div>
                            <p class="tutor-card-sub">Puedo enseñar: {{ $tutor->subjects->pluck('name')->implode(',')}}</p>
                            <!--
                            <div class="tutor-card-rating-row">
                                <div><span class="star">⭐</span>{{ $tutor->avg_rating }}<span>(90 reseñas)</span></div> 
                                <div><i class="fa-solid fa-book"></i><strong>{{ $tutor->completed_courses_count }}</strong> tutorías</div> 
                            </div>
                            -->
                        </div>
                    </div>
                @endforeach --}}

                @foreach($featuredTutors as $tutor)
                <div class="tutor-card" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                    <div class="tutor-card-content">
                        <div class="tutor-avatar-container">
                            <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Tutor" class="tutor-avatar">                               
                            <span class="tutor-status-badge">
                                <span class="tutor-status-star">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </span>
                        </div>
                        <h3 class="tutor-name">
                            {{ explode(' ', $tutor->profile->first_name)[0] }}
                            {{ explode(' ', $tutor->profile->last_name)[0] }}
                        </h3> <!--NOMBRE DEL TUTOR-->

                        @php
                            // Accede a la colección de materias del tutor.
                            $subjects = $tutor->subjects;

                            // Si la colección de materias no está vacía...
                            if ($subjects->isNotEmpty()) {
                                // ...accede a la primera materia de la colección.
                                $firstSubject = $subjects->first();
                                
                                // Si la primera materia tiene un grupo asociado...
                                if ($firstSubject->group) {
                                    // ...muestra el nombre del grupo.

                                    $materia = $firstSubject->group->name;
                                }
                            }
                        @endphp

                        {{-- <p class="tutor-job">Tutor de Ciencias Sociales </p> --}}
                        <p class="tutor-job">Tutor de {{$materia}} </p>
                        <div class="tutor-subjects">
                            @foreach ($tutor->subjects as $subject)
                                <span class="subject-tag">{{ $subject->name }}</span>
                            @endforeach
                        </div>
                        <button class="profile-btn">
                            Ver Perfil
                        </button>
                    </div>
                </div>


                @endforeach
                <!--Card buscar más tutores-->
                <div class="card-buscarmas">
                    <div class="icon-wrapper">
                        <svg class="w-10 h-10 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <h2>Buscar más tutores</h2>
                    <p>
                        Encuentra el tutor perfecto para tus necesidades y comienza a aprender hoy mismo.
                    </p>
                    <a href="{{ route('buscar.tutor') }}" class="btn-primary">
                        Explorar ahora
                    </a>
                </div>
            </div>
        </div>
        <button id="nextBtn" class="carousel-btn next-btn" aria-label="Siguiente">&gt;</button>
    </div>

</section>


<!--GUIA PASO A PASO-->
<section class="potencial-container">
    <h1 class="over-text"><div class="linea"></div>Una guía paso a paso<div class="linea"></div></h1>
    <h1>Desbloquea Tu Potencial Con Pasos Sencillos</h1>
    <p>Mejora tus habilidades con los mejores tutores, fácil y rápido.</p>
    <div class="steps">
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso">Paso 1</div>
            <img src="{{ asset('images/home/img1.webp') }}" alt="Pasos">
            <h1>Inscríbete</h1>
            <p>Crea tu cuenta rápidamente para comenzar a utilizar nuestra plataforma</p>
            <a href=" {{ route('login')}}"><button>Empezar</button></a>
        </div> <!--FIN CARD-->
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso">Paso 2</div>
            <img src="{{ asset('images/home/img22.webp') }}" alt="Pasos">
            <h1>Encuentra un tutor</h1>
            <p>Busca y selecciona entre tutores calificados según tus necesidades.</p>
            <a href=" {{ route('buscar.tutor')}}"><button>Buscar Ahora</button></a>
        </div> <!--FIN CARD-->
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso">Paso 3</div>
            <img src="{{ asset('images/home/img3.webp') }}" alt="Pasos">
            <h1>Reserva ahora</h1>
            <p>Encuentra el mejor momento y agenda tu sesión fácilmente en nuestra palaforma.</p>
            <a href=" {{ route('login')}}"><button>Empecemos</button></a>
        </div> <!--FIN CARD-->

        <!--COMIENZA TU JORNADA CARD-->
        <div class="go">
            <div class="numero-paso">
                <i class="fa-solid fa-person-running"></i>
            </div>
            <h1>Comienza tu jornada</h1>
            <p>Comienza tu viaje educativo con nosotros. ¡Reserva tu primera sesión hoy mismo!</p>
            <a href="{{ route('buscar.tutor')}}"><button class="button-go">Empieza ahora</button></a>
        </div>
    </div>
</section>

<!-- Contenedor principal de la sección -->
<section class="section-app">
  <div class="container-app">
    <!-- Grid responsivo -->
    <div class="grid-app">

      <!-- Columna Izquierda: Contenido de texto -->
      <div class="text-app">
        <p>Fácil, simple y rápido</p>
        <h1>Instala nuestra App</h1>
        <p>Comienza tu viaje educativo con nosotros. ¡Instalate hoy mismo nuestra app!</p>

        <!-- Lista de características -->
        <ul class="list-app">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span>Acceso 24/7</span>
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span>Tutores Expertos</span>
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span>Tarifas Asequibles</span>
          </li>
        </ul>

        <!-- Botón -->
        <div>
          <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" class="btn-app">Descargar Ahora</a>
        </div>
      </div>

      <!-- Columna Derecha: Imagen -->
      <div class="image-app">
        <img 
          src="{{ asset('images/home/iphone.webp')}}" 
          alt="ClassGo"
          onerror="this.onerror=null;this.src='https://placehold.co/400x800/023047/FFFFFF?text=App';"
        >
      </div>

    </div>
  </div>
</section>


<!--HERO TUTORIAS Y ALIANZAS-->
<section class="tutorias-container">
    <div class="tutorias">
        <!-- Texto -->
        <div class="tutores-text">
            <p class="tutores-text-encima">¿Buscas tutorías personalizadas?</p>
            <h1>En Classgo, te conectamos con los mejores tutores</h1>
            <p>Accede a sesiones cortas y prácticas, diseñadas por tutores expertos para ser pequeños salvavidas en el aprendizaje</p>

            <a href=" {{ route('login')}}"><button class="button-comienza">Comienza Ahora</button></a>
            
        </div>
        <!-- Imagen -->
        <div class="tutores-img">
            <img src="{{ asset('images/home/img2.webp') }}" alt="Mascota">
        </div>
    </div>


    <!-- ALIANZAS-->
    @include('components.alianzas', ['alianzas' => $alianzas])
</section>


<script>

    document.addEventListener('DOMContentLoaded', () => {
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        // Calcula la cantidad de tarjetas visibles en desktop
        const getCardsPerView = () => window.innerWidth > 768 ? 3 : 1;
        let cardsPerView = getCardsPerView();
        let cardIndex = 0;

        const updateButtons = () => {
            prevBtn.disabled = cardIndex <= 0;
            nextBtn.disabled = cardIndex >= (track.children.length - cardsPerView);
        };

        const moveToSlide = (index) => {
            const cardWidth = track.children[0].offsetWidth;
            const offset = -index * (cardWidth + 20); // 20px para el margen
            track.style.transform = `translateX(${offset}px)`;
            updateButtons();
        };

        nextBtn.addEventListener('click', () => {
            cardIndex += cardsPerView;
            if (cardIndex > track.children.length - cardsPerView) {
                cardIndex = track.children.length - cardsPerView;
            }
            moveToSlide(cardIndex);
        });

        prevBtn.addEventListener('click', () => {
            cardIndex -= cardsPerView;
            if (cardIndex < 0) {
                cardIndex = 0;
            }
            moveToSlide(cardIndex);
        });

        // Maneja el redimensionamiento de la ventana
        window.addEventListener('resize', () => {
            cardsPerView = getCardsPerView();
            cardIndex = 0; // Resetea el carrusel
            moveToSlide(cardIndex);
        });

        // Inicializa el carrusel
        moveToSlide(cardIndex);
    });


    //Contadores de usuarios
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.counter-number');

        const animateCounter = (el) => {
            const target = +el.getAttribute('data-target');
            const isDecimal = el.getAttribute('data-decimal') === 'true';
            let count = 0;
            const step = isDecimal ? 0.1 : Math.ceil(target / 100);

            const updateCounter = () => {
                count += step;
                if (count < target) {
                    el.innerHTML = isDecimal ? `<i class="fa fa-star"></i> ${count.toFixed(1)}` : `+${Math.floor(count)}`;
                    requestAnimationFrame(updateCounter);
                } else {
                    el.innerHTML = isDecimal ? `<i class="fa fa-star"></i> ${target.toFixed(1)}` : `+${target}`;
                }
            };

            updateCounter();
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.6 });

        counters.forEach(counter => observer.observe(counter));
    });
</script>

@endsection

