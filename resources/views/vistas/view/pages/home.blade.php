@extends('vistas.view.layouts.app')

@section('title', 'ClassGo - Aprende y Progresa')

@section('content')


<!-- 1 - HERO -->
<section class="hero">
    <div class="hero-container">

        <!-- 1.1 Hero Titular -->
        <div class="hero-text">
            <h1 class="hero-title-arriba" data-translate="learn"></h1>
            <h1 class="hero-title-abajo" data-translate="tutoring"></h1>
            <p class="hero-subtext" data-translate="reach_goals">
            </p>
            <p class="hero-subtext mobile">
                Conéctate con tutores dedicados para asegurar tu éxito.
            </p>

            <!-- 1.2 Buscador -->
            {{-- <div class="search-box">
                <input type="text" placeholder="Buscar tutor...">
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
                <a href=" {{ route('buscar.tutor')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i><span data-translate="tutores"></span></button></a>
                <a href=" {{ route(name: 'register')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-user"></i><span data-translate="registrate"></span></button></a>
                <a href=" {{ route(name: 'login')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-right-to-bracket"></i><span data-translate="ingresa"></span></button></a>
                @endguest

                @auth
                <a href=" {{ route('buscar.tutor')}}"><button class="button-explorar-tutores"><i class="fa-solid fa-compass"></i><span data-translate="search_tutors"></span></button></a>
                <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank"><button class="button-explorar-tutores"><i class="fa-solid fa-mobile"></i><span data-translate="get_app"></span></button></a>
                @endauth
            </div>

        </div>

        <!-- 1.4 Hero Mascota -->

        <img src="{{ asset('storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.gif') }}" alt="Mascota ClassGo">



    </div>
</section>


<!-- CONTADORES INFO -->
<section class="info-container">
    <!-- CONTADORES -->
    @include('components.counters', ['color' => 'text-dark'])

    <!--TUTORES DESTACADOS-->
    <div class="tutors-container">
        <h1 class="over-text">
            <div class="linea"></div><span data-translate="featured_tutors"></span>
            <div class="linea"></div>
        </h1>
        <h1 data-translate="selected_tutors"></h1>
        <p data-translate="academic_variety"></p>

        <!--Componente tutor destacado-->
        {{-- <div class="tutors-carousel-viewport">
            <div class="tutors" id="tutorsContainer">
                @include('components.tutors', [
                    'profiles' => $profiles,
                    'subjectsByUser' => $subjectsByUser,
                ])
            </div>
        </div>
        <div class="carousel-controls">
            <button class="carousel-nav prev" onclick="prevSlide()">‹</button>
            <button class="carousel-nav next" onclick="nextSlide()">›</button>
        </div>
        <div class="carousel-indicators" id="indicators"></div> --}}

        <!-- ======= NUEVO TUTORES DESTACADOS =======-->
        <div id="carousel-wrapper">
            <div class="carousel-container">
                <div class="carousel-track">
                    @include('components.tutors', [
                    'profiles' => $profiles,
                    'subjectsByUser' => $subjectsByUser,
                    ])
                </div>
            </div>

            <button id="prev-btn" class="nav-button prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="next-btn" class="nav-button next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </div>
</section>

<!--GUIA PASO A PASO-->
<section class="potencial-container">
    <h1 class="over-text">
        <div class="linea"></div><span data-translate="guide"></span>
        <div class="linea"></div>
    </h1>
    <h1 data-translate="unlock_potential"></h1>
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
            <a href=" {{ route('buscar.tutor')}}"><button><span data-translate="buscar_ahora"></span></button></a>
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
            <a href="{{ route('buscar.tutor')}}"><button class="button-go"><span data-translate="empezar_ahora"></span></button></a>
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
                <p data-translate="facil_simple_rapido"></p>
                <h1 data-translate="instala_app"></h1>
                <p data-translate="comienza_viaje_educativo"></p>

                <!-- Lista de características -->
                <ul class="list-app">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        <span data-translate="acceso"></span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        <span data-translate="tutores_expertos"></span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        <span data-translate="tarifas_asequibles"></span>
                    </li>
                </ul>

                <!-- Botón -->
                <div>
                    <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" class="btn-app"><span data-translate="descargar_ahora"></span></a>
                </div>
            </div>

            <!-- Columna Derecha: Imagen -->
            <div class="image-app">
                <img
                    src="{{ asset('images/home/iphone.webp')}}"
                    alt="ClassGo"
                    onerror="this.onerror=null;this.src='https://placehold.co/400x800/023047/FFFFFF?text=App';">
            </div>

        </div>
    </div>
</section>


<!--HERO TUTORIAS Y ALIANZAS-->
<section class="tutorias-container">
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
        <div class="tutores-img">
            <img src="{{ asset('images/home/img2.webp') }}" alt="Mascota">
        </div>
    </div>


    <!-- ALIANZAS-->
    @include('components.alianzas', ['alianzas' => $alianzas])
</section>

<script>
    let currentSlide = 0;
    const cardsPerView = 3;
    const tutorsContainer = document.getElementById('tutorsContainer');
    const cards = document.querySelectorAll('.tutor-card');
    const totalCards = cards.length;
    const totalSlides = Math.ceil(totalCards / cardsPerView);

    // Crear indicadores
    function createIndicators() {
        const indicatorsContainer = document.getElementById('indicators');
        indicatorsContainer.innerHTML = '';

        for (let i = 0; i < totalSlides; i++) {
            const indicator = document.createElement('div');
            indicator.className = 'indicator';
            if (i === 0) indicator.classList.add('active');
            indicator.onclick = () => goToSlide(i);
            indicatorsContainer.appendChild(indicator);
        }
    }

    // Ir a slide específico
    function goToSlide(slideIndex) {
        if (slideIndex < 0 || slideIndex >= totalSlides) return;

        currentSlide = slideIndex;
        const translateX = -currentSlide * 100;
        tutorsContainer.style.transform = `translateX(${translateX}%)`;

        updateIndicators();
        updateButtons();
    }

    // Siguiente slide
    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            goToSlide(currentSlide + 1);
        }
    }

    // Slide anterior
    function prevSlide() {
        if (currentSlide > 0) {
            goToSlide(currentSlide - 1);
        }
    }

    // Actualizar indicadores
    function updateIndicators() {
        const indicators = document.querySelectorAll('.indicator');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }

    // Actualizar botones
    function updateButtons() {
        const prevBtn = document.querySelector('.carousel-nav.prev');
        const nextBtn = document.querySelector('.carousel-nav.next');

        prevBtn.disabled = currentSlide === 0;
        nextBtn.disabled = currentSlide === totalSlides - 1;
    }

    // Inicializar carrusel
    function initCarousel() {
        createIndicators();
        updateButtons();

        // Ajustar ancho del contenedor
        tutorsContainer.style.width = `${totalSlides * 100}%`;
    }

    // Navegación con teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });

    // Inicializar al cargar la página
    document.addEventListener('DOMContentLoaded', initCarousel);

    // Responsive: ajustar cards por vista según el tamaño de pantalla
    function updateCardsPerView() {
        const width = window.innerWidth;
        let newCardsPerView;

        if (width <= 480) {
            newCardsPerView = 1;
        } else if (width <= 768) {
            newCardsPerView = 2;
        } else {
            newCardsPerView = 3;
        }

        if (newCardsPerView !== cardsPerView) {
            // Recalcular slides si es necesario
            //location.reload(); 
        }
    }

    window.addEventListener('resize', updateCardsPerView);



    document.addEventListener('DOMContentLoaded', function() {
        // Video lazy load: solo carga el src si el usuario da play
        document.querySelectorAll('.tutor-card video').forEach(video => {
            video.addEventListener('play', function() {
                if (!video.src) {
                    video.src = video.getAttribute('data-src');
                }
            }, {
                once: true
            });
        });
    });





    //================= Script para el nuevo carrusel =================
    document.addEventListener('DOMContentLoaded', function() {
        const carouselWrapper = document.getElementById('carousel-wrapper');
        if (!carouselWrapper) return;

        const track = carouselWrapper.querySelector('.carousel-track');
        const prevButton = carouselWrapper.querySelector('#prev-btn');
        const nextButton = carouselWrapper.querySelector('#next-btn');
        const cards = carouselWrapper.querySelectorAll('.carousel-card');
        const totalSlides = cards.length;

        if (totalSlides === 0) return;

        let currentIndex = 0;
        let slideInterval;
        let isCarouselActive = false; // Un indicador para saber si el carrusel está activo

        // --- FUNCIÓN DE CONTROL PRINCIPAL ---
        function setupCarousel() {
            const isMobile = window.innerWidth < 768; // Punto de quiebre (igual que en el CSS)

            if (isMobile) {
                // Si es móvil, nos aseguramos de que todo esté desactivado
                if (isCarouselActive) {
                    stopSlideShow();
                    track.style.transform = 'none'; // Resetea la posición del track
                    // Aquí podrías remover los event listeners si fuera necesario, pero con ocultar los botones es suficiente
                    isCarouselActive = false;
                }
                return; // No continuamos con la inicialización
            }

            // Si no es móvil, activamos el carrusel
            if (!isCarouselActive) {
                // Añadimos los eventos SOLO si el carrusel no estaba ya activo
                nextButton.addEventListener('click', handleNextClick);
                prevButton.addEventListener('click', handlePrevClick);
                carouselWrapper.addEventListener('mouseenter', stopSlideShow);
                carouselWrapper.addEventListener('mouseleave', startSlideShow);

                isCarouselActive = true;
                startSlideShow();
            }

            // Siempre actualizamos la vista del carrusel en escritorio
            updateCarouselView();
        }

        // --- Funciones del carrusel (modificadas para claridad) ---
        function getVisibleSlides() {
            if (window.innerWidth >= 1024) return 3;
            if (window.innerWidth >= 768) return 2;
            return 1; // Este valor solo se usará en escritorio
        }

        function updateCarouselView() {
            if (!isCarouselActive) return; // No hacer nada si el carrusel está inactivo

            const visibleSlides = getVisibleSlides();
            const maxIndex = Math.max(0, totalSlides - visibleSlides);

            if (currentIndex > maxIndex) currentIndex = maxIndex;
            if (currentIndex < 0) currentIndex = 0;

            const offset = -currentIndex * (100 / visibleSlides);
            track.style.transform = `translateX(${offset}%)`;

            prevButton.classList.toggle('disabled', currentIndex === 0);
            nextButton.classList.toggle('disabled', currentIndex >= maxIndex);
        }

        function moveToNextSlide() {
            const visibleSlides = getVisibleSlides();
            const maxIndex = totalSlides - visibleSlides;
            currentIndex = (currentIndex >= maxIndex) ? 0 : currentIndex + 1;
            updateCarouselView();
        }

        // --- Control del Slideshow ---
        function startSlideShow() {
            if (!isCarouselActive) return;
            stopSlideShow();
            slideInterval = setInterval(moveToNextSlide, 5000);
        }

        function stopSlideShow() {
            clearInterval(slideInterval);
        }

        // --- Manejadores de eventos ---
        function handleNextClick() {
            const visibleSlides = getVisibleSlides();
            const maxIndex = totalSlides - visibleSlides;
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateCarouselView();
            }
        }

        function handlePrevClick() {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarouselView();
            }
        }

        // --- INICIALIZACIÓN Y MANEJO DEL RESIZE ---
        window.addEventListener('resize', setupCarousel);
        setupCarousel(); // Llama a la función al cargar la página
    });
</script>
    <script src="{{ asset('js/translations.js') }}"></script>
@endsection