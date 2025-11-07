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

            <img src="{{ asset(path: 'storage/optionbuilder/uploads/740102-17-2025_0859pmTugo-saludando.webp') }}" alt="Mascota ClassGo">



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

<section class="visual-section">
    
    {{-- <img class="visual-phone" src="{{ asset('images/celular-ClassGo.png') }}" alt=""> --}}
    <img class="visual-phone" src="{{ asset('images/home/img.png') }}" alt="">

    <div class="visual-wrapper" >
    </div>

    <div class="whats-new-card">
    
    <div class="whats-new-card__header">
        <svg class="whats-new-card__icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/>
        </svg>
        <h2 class="whats-new-card__title">¿Qué deseas aprender?</h2>
    </div>
    
    <ol class="whats-new-card__list">
        <li class="whats-new-card__list-item">Prepárate para ese exámen difícil</li>
        <li class="whats-new-card__list-item">Domina esa asignatura</li>
        <li class="whats-new-card__list-item">Refuerzo académico garantizado</li>
    </ol>
    
    <div class="whats-new-card__button-wrapper">
        <button class="whats-new-card__button">
            Buscar Tutores
        </button>
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

    @include('vistas.view.pages.components.home.card-tutor-destacado')
</section>
<!--CARRUSEL ANIMADO TUGO-->
<section class="tugo-carousel fade-up">
  <div class="tugo-container">
    <div class="text-zone">
      <p class="intro-text">Con ClassGo aprendes...</p>
      <div class="animated-word" id="animatedWord">Idiomas</div>
    </div>

    <div class="mascot-panel">
      <img id="mascot" class="mascot" src="/images/tugos-skin/Interpretación-y-Traducción-de-Idiomas.webp" alt="Tugo">
    </div>
  </div>
</section>

<!--CARRUSEL ANIMADO TUGO-->
{{-- <section class="tugo-carousel fade-up">
  <div class="tugo-container">
    <div class="text-zone">
      <p class="intro-text">Con ClassGo aprendes...</p>
      <div class="animated-word" id="animatedWord">Idiomas</div>
    </div>

    <div class="mascot-panel">
      <img id="mascot" class="mascot" src="/images/tugos-skin/Interpretación-y-Traducción-de-Idiomas.webp" alt="Tugo">
    </div>
  </div>
</section> --}}

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
      <div class="fade-left">
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
            <!-- Botón -->
            <div>
                <a href="https://play.google.com/store/apps/details?id=com.neurasoft.classgo" target="_blank" class="btn-app"> Descargar Ahora </a> 
            </div>
        
        </div>
        </div>
            <!-- Columna Derecha: Imagen -->
                        
            <div class="image-app">
                        <img
                            src="{{ asset('images/home/tugo-cel-optimizado.webp')}}"
                            alt="ClassGo"onerror="this.onerror=null;this.src='https://placehold.co/400x800/023047/FFFFFF?text=App';">
            </div>
        </div>

    </div>

    
</section>



<!--HERO TUTORIAS Y ALIANZAS-->
<section class="tutorias-container fade-up">
    <div class="tutorias">
        <!-- Texto -->
        <div class="fade-left">
        <div class="tutores-text">
            <p class="tutores-text-encima" data-translate="buscas_tutorias"></p>
            <h1 data-translate="conectamos_tutores"></h1>
            <p data-translate="sesiones_cortas"></p>

            <a href="{{ route('login') }}">
                <button class="button-comienza" data-translate="comienza_ahora"></button>
            </a>


        </div>
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
<!--------animacion skin----->
<script>
const words = [
  
  {text: "Química", img: "/images/tugos-skin/Química-General.webp"},
  {text: "Física", img: "/images/tugos-skin/Física-Aplicada.webp"},
  {text: "Matemáticas", img: "/images/tugos-skin/Cálculo.webp"},
  {text: "Programación", img: "/images/tugos-skin/Inteligencia-de-Software-26.webp"},
  {text: "Arte y edición", img: "/images/tugos-skin/Producción-Audiovisual-Para-Plataformas-Digitales.webp"},
  {text: "Electricidad y Electromecánica", img: "/images/tugos-skin/Robótica-y-Automatización.webp"},
  {text: "Idiomas", img: "/images/tugos-skin/Interpretación-y-Traducción-de-Idiomas.webp"},
  {text: "Creación de Contenidos", img: "/images/tugos-skin/Tugo-influencer.webp"},
  {text: "Mecánica Automotriz", img: "/images/tugos-skin/Mecánica-Automotriz-Básica.webp"},
  {text: "Contabilidad", img: "/images/tugos-skin/Modelación-Financiera.webp"},
];

const animatedWord = document.getElementById("animatedWord");
const mascot = document.getElementById("mascot");
let i = 0;

function changeWord() {
  animatedWord.classList.remove("fade-in");
  animatedWord.style.opacity = 0;
  mascot.classList.add("fade");

  setTimeout(() => {
    animatedWord.textContent = words[i].text;
    mascot.src = words[i].img;

    animatedWord.style.animation = "none";
    void animatedWord.offsetWidth; // reinicia la animación
    animatedWord.style.animation = "fadeSlide 1s forwards";

    mascot.classList.remove("fade");

    i = (i + 1) % words.length;
  }, 500);
}


setInterval(changeWord, 2500);

document.addEventListener('DOMContentLoaded', function() {

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
    // 7. INICIALIZACIÓN PRINCIPAL
    // ===========================
    try {
        // Ejecutar todas las inicializaciones
        initCarousel3D();
        initTextAnimation();
        initCounters();
        
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