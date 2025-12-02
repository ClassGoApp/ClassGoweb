@extends('vistas.view.layouts.app')

@section('title', 'ClassGo - Aprende y Progresa')

@section('content')

    <section class="contadores-hero">
        <!-- HERO -->
        <div class="hero">
            @include('vistas.view.pages.components.home.hero')
        </div>

        <!-- CONTADORES -->
        <div class="info-container " id="logros">
            @include('vistas.view.pages.components.home.counters', [
                'totalUsers' => $totalUsers,
                'totalTutores' => $totalTutores,
                'totalEstudiantes' => $totalEstudiantes,
            ])
        </div>

    </section>

    <!-- ELEMENTO VISUAL TELEFONO-->
    <section class="visual-section">
        @include('vistas.view.pages.components.home.visual-phone')
    </section>

    <!--Buscar Tutor-->
    <section class="buscar-tutor-section">
        @include('vistas.view.pages.components.home.buscar-tutor')
    </section>

    <!--TUTORES DESTACADOS-->
    <section class="tutors-container fade-up">
    
        <h1 class="over-text">
        <div class="linea"></div><span data-translate="featured_tutors"></span>
        <div class="linea"></div>
        </h1>
        <h1 class ="tutor ideal" data-translate="selected_tutors"></h1>
        <p data-translate="academic_variety"></p>


        @include('vistas.view.pages.components.home.card-tutor-destacado')

    </section>

    <!--CARRUSEL ANIMADO TUGO-->
    {{-- <section class="tugo-carousel fade-up">
        <h1 class="over-text">
            <div class="linea"></div><span data-translate="featured_tutors"></span>
            <div class="linea"></div>
        </h1>
        <h1 class ="tutor ideal" data-translate="selected_tutors"></h1>
        <p data-translate="academic_variety"></p>
        <div class="tugo-container">
            <div class="text-zone">
                <p class="intro-text">En ClassGo encuentras tutorías de...</p>
                <div class="animated-word" id="animatedWord">Idiomas</div>
            </div>

            <div class="mascot-panel">
                <img id="mascot" class="mascot" src="/images/tugos-skin/Interpretación-y-Traducción-de-Idiomas.webp"
                    alt="Tugo">
            </div>
        </div>
    </section> --}}

    <!--FILTRO DE MATERIAS-->
    <section class="filtro_materias fade-up">
        <h1 class="over-text">
            <div class="linea"></div>
            <span>Materias que te pueden ayudar</span>
            <div class="linea"></div>
        </h1>
        <h1 class="title">Explora Nuestras Materias</h1>
        <p>Tutores listos en distintas áreas para ayudarte</p>
        @include('vistas.view.pages.components.home.filtro-materias')
    </section>

    <!--GUIA PASO A PASO-->
    <section class="potencial-container fade-up">
        @include('vistas.view.pages.components.home.guia-pasos')
    </section>

    <!-- INSTALA NUESTRA APP -->
    <section class="section-app fade-up">
        @include('vistas.view.pages.components.home.nuestra-app')
    </section>

    <!-- BUSCAS TUTORIAS / ALIANZAS-->
    <section class="tutorias-container fade-up">
        <div class="tutorias">
            @include('vistas.view.pages.components.home.buscas-tutorias')
        </div>

        <!-- ALIANZAS-->
        <div class="fade-up">
            @include('components.alianzas', ['alianzas' => $alianzas])
        </div>
    </section>

    <script>
        // const words = [

        //     {
        //         text: "Química",
        //         img: "/images/tugos-skin/Química-General.webp"
        //     },
        //     {
        //         text: "Física",
        //         img: "/images/tugos-skin/Física-Aplicada.webp"
        //     },
        //     {
        //         text: "Matemáticas",
        //         img: "/images/tugos-skin/Cálculo.webp"
        //     },
        //     {
        //         text: "Programación",
        //         img: "/images/tugos-skin/Inteligencia-de-Software-26.webp"
        //     },
        //     {
        //         text: "Arte y edición",
        //         img: "/images/tugos-skin/Producción-Audiovisual-Para-Plataformas-Digitales.webp"
        //     },
        //     {
        //         text: "Electricidad y Electromecánica",
        //         img: "/images/tugos-skin/Robótica-y-Automatización.webp"
        //     },
        //     {
        //         text: "Idiomas",
        //         img: "/images/tugos-skin/Interpretación-y-Traducción-de-Idiomas.webp"
        //     },
        //     {
        //         text: "Creación de Contenidos",
        //         img: "/images/tugos-skin/Tugo-influencer.webp"
        //     },
        //     {
        //         text: "Mecánica Automotriz",
        //         img: "/images/tugos-skin/Mecánica-Automotriz-Básica.webp"
        //     },
        //     {
        //         text: "Contabilidad",
        //         img: "/images/tugos-skin/Modelación-Financiera.webp"
        //     },
        // ];

        // const animatedWord = document.getElementById("animatedWord");
        // const mascot = document.getElementById("mascot");
        // let i = 0;

        // function changeWord() {
        //     animatedWord.classList.remove("fade-in");
        //     animatedWord.style.opacity = 0;
        //     mascot.classList.add("fade");

        //     setTimeout(() => {
        //         animatedWord.textContent = words[i].text;
        //         mascot.src = words[i].img;

        //         animatedWord.style.animation = "none";
        //         void animatedWord.offsetWidth; // reinicia la animación
        //         animatedWord.style.animation = "fadeSlide 1s forwards";

        //         mascot.classList.remove("fade");

        //         i = (i + 1) % words.length;
        //     }, 500);
        // }

        // setInterval(changeWord, 2500);

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
            }, {
                threshold: 0.2
            });

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
