@extends('vistas.view.layouts.app')

@section('title', 'ClassGo - Aprende y Progresa')

@section('content')

<section class="contadores-hero">
    <!-- 1 - HERO -->
    <div class="hero">
        <div class="hero-container">

            <!-- 1.1 Hero Titular -->
            <div class="hero-text fade-left">
                
                <h1 class="hero-title-arriba" data-translate="learn"></h1>
                <h1 class="hero-title-abajo" data-translate="tutoring"></h1>
                <p class="hero-subtext" data-translate="reach_goals">
                </p>

                <div class="buscador-home">
                    @livewire('buscador-tutor')
                </div>

                <!-- 1.3 Botones-->
                <div class="hero-buttons">
                    @guest
                    <a href=" {{ route('buscar')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i><span data-translate="tutores"></span></button></a>
                    <a href=" {{ route(name: 'register')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-user"></i><span data-translate="registrate"></span></button></a>
                    <a href=" {{ route(name: 'login')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-right-to-bracket"></i><span data-translate="ingresa"></span></button></a>
                    @endguest

                    @auth
                    <a href=" {{ route('buscar')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i> <span data-translate="buscar_tutor"></span> </button></a>
                    <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><button class="button-explorar-tutores"><i class="fa-solid fa-mobile"></i> <span data-translate="nuestra_app"></span> </button></a>
                    @endauth
                </div>
            </div>

            <!-- 1.4 Hero Mascota -->
            <img src="{{ asset(path: 'storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif') }}" alt="Mascota ClassGo">
        </div>
    </div>


    <!-- CONTADORES INFO -->
    <div class="info-container " id="logros">
        <!-- CONTADORES -->
        <div class="counters">
            <div class="counter-box">
                <div class="counter-number fade-up" data-target="{{ $totalUsers }}">+0</div>
                <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="us_check"></span></h1>
            </div>
            <div class="box-sky fade-up"></div>
            <div class="counter-box">
                <div class="counter-number fade-up" data-target="{{ $totalTutores }}">+0</div>
                <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="tutor_ok"></span></h1>
            </div>
            <div class="box-sky fade-up"></div>
            <div class="counter-box">
                <div class="counter-number fade-up" data-target="{{ $totalEstudiantes }}">0</div>
                <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="est_check"></span></h1>
            </div>
            <div class="box-sky fade-up"></div>
            <div class="counter-box">
                <div class="counter-numbe fade-up"><i class="fa fa-star"></i>4.5</div>
                <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="play_s"></span></h1>
            </div>
        </div>

    </div>
</section>


<!--TUTORES DESTACADOS-->

<section class="tutors-container fade-up">
    <h1 class="over-text">
        <div class="linea"></div><span data-translate="featured_tutors"></span><div class="linea"></div>
    </h1>
    <h1 class ="tutor ideal" data-translate="selected_tutors"></h1>
    <p data-translate="academic_variety"></p>

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
                        <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Tutor">
                        <h3>{{ $tutor->profile->first_name }} {{ $tutor->profile->last_name }}</h3> <!--NOMBRE DEL TUTOR-->
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
                    $materia = 'Materias Generales'; // Valor por defecto si no hay datos
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
                <h2 data-translate="seeks"></h2>
                <p data-translate="finds">
                </p>
                <a href="{{ route('buscar') }}" class="btn-primary">
                    <span data-translate="explore"></span>
                </a>
            </div>
        </div>
    </div>
    <button id="nextBtn" class="carousel-btn next-btn" aria-label="Siguiente">&gt;</button>
    </div>

</section>


<!--GUIA PASO A PASO-->
<section class="potencial-container fade-up">
    <h1 class="over-text ">
        <div class="linea"></div><span data-translate="guide"></span>
        <div class="linea"></div>
    </h1>
    <h1 class="unlock-potencial" data-translate="unlock_potential"></h1>
    <p data-translate="improve_skills"></p>
    <div class="steps">
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso" data-translate="step_1"></div>
            <img src="{{ asset('images/home/img1.webp') }}" alt="Pasos">
            <h1 data-translate="sign_up"></h1>
            <p data-translate="create_account"></p>
            <a href=" {{ route('login')}}"><button><span data-translate="begin"></span></button></a>
        </div> <!--FIN CARD-->
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso" data-translate="step_2"></div>
            <img src="{{ asset('images/home/img22.webp') }}" alt="Pasos">
            <h1 data-translate="find_tutor"></h1>
            <p data-translate="tutores_calificados"></p>
            <a href=" {{ route('buscar')}}"><button><span data-translate="buscar_ahora"></span></button></a>
        </div> <!--FIN CARD-->
        <!--CARD-->
        <div class="steps-card">
            <div class="numero-paso" data-translate="step_3"></div>
            <img src="{{ asset('images/home/img3.webp') }}" alt="Pasos">
            <h1 data-translate="reservar_ahora"></h1>
            <p data-translate="encuentra_mejor"></p>
            <a href=" {{ route('login')}}"><button><span data-translate="empecemos"></span></button></a>
        </div> <!--FIN CARD-->

        <!--COMIENZA TU JORNADA CARD-->
        <div class="go">
            <div class="numero-paso">
                <i class="fa-solid fa-person-running"></i>
            </div>
            <h1 data-translate="comenzar_jornada"></h1>
            <p data-translate="comenzar_viaje"></p>
            <a href="{{ route('buscar')}}"><button class="button-go"><span data-translate="empezar_ahora"></span></button></a>
        </div>
    </div>
</section>

<!-- Contenedor principal de la sección -->
<section class="section-app fade-up">
    <div class="container-app">
        <!-- Grid responsivo -->
        <div class="grid-app">

      <!-- Columna Izquierda: Contenido de texto -->
      <div class="text-app">
        <p data-translate="facil_simple_rapido"></p>
        <h1 data-translate="instala_app"></h1>
        <p data-translate="comienza_viaje_educativo"></p>

        <!-- Lista de características -->
        <ul class="list-app">
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span data-translate="acceso"></span>
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span data-translate="tutores_expertos"></span>
          </li>
          <li>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <span data-translate="tarifas_asequibles"></span>
          </li>
        </ul>

        
      </div>
      <!-- Columna Derecha: Imagen -->
                        
        <div class="image-app">
                    <img
                        src="{{ asset('images/home/tugo-cel.gif')}}"
                        alt="ClassGo"onerror="this.onerror=null;this.src='https://placehold.co/400x800/023047/FFFFFF?text=App';">
        </div>
        </div>
    </div>
    
</section>



<!--HERO TUTORIAS Y ALIANZAS-->
<section class="tutorias-container fade-up">
    <div class="tutorias">
        <!-- Texto -->
        <div class="tutores-text">
            <p class="tutores-text-encima" data-translate="buscas_tutorias"></p>
            <h1 data-translate="conectamos_tutores"></h1>
            <p data-translate="sesiones_cortas"></p>

            <a href="{{ route('login') }}">
                <button class="button-comienza" data-translate="comienza_ahora"></button>
            </a>


        </div>
        <!-- Imagen -->
        <div class="carousel-3D">
            <div class="img-container-3D">
                <div class="box-3D">
                    <img
                    src="images/home/img1.webp"
                    alt=""
                    />
                </div>
                <div class="box-3D">
                    <img
                    src="images/home/img3.webp"
                    alt=""
                    />
                </div>
                <div class="box-3D">
                    <img
                    src="images/home/img22.webp"
                    alt=""
                    />
                </div>
                <div class="box-3D">
                    <img
                    src="images/home/img1.webp"
                    alt=""
                    />
                </div>
                <div class="box-3D">
                    <img
                    src="images/home/img3.webp"
                    alt=""
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- ALIANZAS-->
    <div class="fade-up">
    @include('components.alianzas', ['alianzas' => $alianzas])
    </div>

</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

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
    document.querySelectorAll('.fade-up, .fade-left, .fade-right').forEach(el => {
        scrollObserver.observe(el);
    });

    // ===========================
    // 2. CARRUSEL 3D
    // ===========================
    const initCarousel3D = () => {
        const imgContainer = document.querySelector(".img-container-3D");
        
        if (imgContainer && imgContainer.children.length > 0) {
            setInterval(() => {
                const first = imgContainer.firstElementChild;
                if (first) {
                    imgContainer.appendChild(first);
                }
            }, 1500);
        }
    };

    // ===========================
    // 3. ANIMACIÓN TEXTO-ANIMADO
    // ===========================
    const initTextAnimation = () => {
        const textos = document.querySelectorAll('.texto-animado');

        if (textos.length > 0) {
            const textObserver = new IntersectionObserver((entradas) => {
                entradas.forEach((entrada) => {
                    if (entrada.isIntersecting) {
                        entrada.target.classList.add('visible');
                        textObserver.unobserve(entrada.target);
                    }
                });
            });

            textos.forEach((texto) => textObserver.observe(texto));
        }
    };

    // ===========================
    // 4. CARRUSEL DE TUTORES
    // ===========================
    const initTutorCarousel = () => {
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Verificar que los elementos existen
        if (!track || !prevBtn || !nextBtn || track.children.length === 0) {
            console.warn('Elementos del carrusel de tutores no encontrados');
            return;
        }

        // Variables del carrusel
        const getCardsPerView = () => window.innerWidth > 768 ? 3 : 1;
        let cardsPerView = getCardsPerView();
        let cardIndex = 0;

        const updateButtons = () => {
            prevBtn.disabled = cardIndex <= 0;
            nextBtn.disabled = cardIndex >= (track.children.length - cardsPerView);
        };

        const moveToSlide = (index) => {
            if (track.children.length === 0) return;
            
            const cardWidth = track.children[0].offsetWidth;
            const offset = -index * (cardWidth + 20);
            track.style.transform = `translateX(${offset}px)`;
            updateButtons();
        };

        // Event listeners
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

        // Redimensionamiento de ventana
        window.addEventListener('resize', () => {
            cardsPerView = getCardsPerView();
            cardIndex = 0;
            moveToSlide(cardIndex);
        });

        // Inicializar
        moveToSlide(cardIndex);
    };

    // ===========================
    // 5. CONTADORES DE USUARIOS
    // ===========================
    const initCounters = () => {
        const counters = document.querySelectorAll('.counter-number');

        if (counters.length === 0) return;

        const animateCounter = (el) => {
            const target = +el.getAttribute('data-target');
            const isDecimal = el.getAttribute('data-decimal') === 'true';
            let count = 0;
            const step = isDecimal ? 0.1 : Math.ceil(target / 100);

            const updateCounter = () => {
                count += step;
                if (count < target) {
                    el.innerHTML = isDecimal ? 
                        `<i class="fa fa-star"></i> ${count.toFixed(1)}` : 
                        `+${Math.floor(count)}`;
                    requestAnimationFrame(updateCounter);
                } else {
                    el.innerHTML = isDecimal ? 
                        `<i class="fa fa-star"></i> ${target.toFixed(1)}` : 
                        `+${target}`;
                }
            };

            updateCounter();
        };

        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.6
        });

        counters.forEach(counter => counterObserver.observe(counter));
    };

    // ===========================
    // 6. CARRUSEL DE ALIANZAS (OPCIONAL)
    // ===========================
    const initAllianceCarousel = () => {
        const track = document.getElementById('client-carousel-track');
        const dotsContainer = document.getElementById('client-pagination-dots');
        const nextButton = document.getElementById('client-next-button');
        const prevButton = document.getElementById('client-prev-button');

        // Solo ejecutar si los elementos existen (para páginas que lo tienen)
        if (!track || !nextButton || !prevButton) {
            return; // Salir silenciosamente si no existe
        }

        const slides = Array.from(track.children);
        const dots = dotsContainer ? Array.from(dotsContainer.children) : [];

        if (slides.length === 0) return;

        const getSlidesPerView = () => {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 768) return 2;
            return 1;
        };

        let currentIndex = 0;
        let slideInterval;

        const goToSlide = (index) => {
            const slidesPerView = getSlidesPerView();
            const maxIndex = slides.length - slidesPerView;

            if (index < 0) {
                currentIndex = maxIndex;
            } else if (index > maxIndex) {
                currentIndex = 0;
            } else {
                currentIndex = index;
            }

            updateCarousel();
        };

        const updateCarousel = () => {
            const slidesPerView = getSlidesPerView();
            const slideWidth = slides[0].offsetWidth;
            track.style.transform = 'translateX(' + (-slideWidth * currentIndex) + 'px)';

            // Actualizar puntos si existen
            if (dots.length > 0) {
                dots.forEach((dot, index) => {
                    dot.classList.remove('active');
                    if (index === currentIndex) {
                        dot.classList.add('active');
                    }
                });
            }
        };

        const startInterval = () => {
            slideInterval = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 3000);
        };

        const resetInterval = () => {
            clearInterval(slideInterval);
            startInterval();
        };

        // Event listeners
        nextButton.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
            resetInterval();
        });

        prevButton.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
            resetInterval();
        });

        // Puntos de paginación
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                goToSlide(index);
                resetInterval();
            });
        });

        // Redimensionamiento
        window.addEventListener('resize', () => {
            const newSlidesPerView = getSlidesPerView();
            const maxIndex = slides.length - newSlidesPerView;
            if (currentIndex > maxIndex) {
                currentIndex = maxIndex;
            }
            updateCarousel();
        });

        // Inicializar
        updateCarousel();
        startInterval();
    };

    // ===========================
    // 7. INICIALIZACIÓN PRINCIPAL
    // ===========================
    try {
        // Ejecutar todas las inicializaciones
        initCarousel3D();
        initTextAnimation();
        initTutorCarousel();
        initCounters();
        initAllianceCarousel();
        
        console.log('✅ Scripts de Home inicializados correctamente');
    } catch (error) {
        console.error('❌ Error al inicializar scripts:', error);
    }

    // ===========================
    // 8. COMPATIBILIDAD CON LIVEWIRE
    // ===========================
    // Si estás usando Livewire, reinicializar cuando se actualice
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('message.processed', () => {
            // Reinicializar solo lo necesario después de updates de Livewire
            initTutorCarousel();
            initCounters();
        });
    }
});
</script>




@endsection