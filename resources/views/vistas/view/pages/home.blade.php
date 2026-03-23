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
        
        <h1 class="header-main__title fade-up" data-translate="selected_tutors"></h1>
        <p class="header-main__subtitle fade-up" data-translate="academic_variety"></p>
        @include('vistas.view.pages.components.home.card-tutor-destacado')

    </section>
    <section class="instant-info" id="tutorias-instantaneas-seccion">
    @include('vistas.view.pages.components.home.tutorias-al-instante')
    </section>

    <!--FILTRO DE MATERIAS-->
    <section class="filtro_materias fade-up">
        
        <h1 class="header-main__title "><span data-translate="filtro_materias_txt2"></span></h1>
        <p class="header-main__subtitle" data-translate="filtro_materias_txt3"></p>
        @include('vistas.view.pages.components.home.filtro-materias')
    </section>

    <!--DESBLOQUEA TU POTENCIAL CON SENCILLOS PASOS-->
    <section class="potencial-container fade-up">
        <h3 class="over-text-dark">
            <div class="linea"></div>
            <span data-translate="guide"></span>
            <div class="linea"></div>
        </h3>
        <h1 class="header-main__title_ligth fade-up" data-translate="unlock_potential"></h1>
        <p class="header-main__subtitle_ligth fade-up" data-translate="improve_skills"></p>
        @include('vistas.view.pages.components.home.guia-pasos')
    </section>

    <!-- INSTALA NUESTRA APP -->
    <section>
        @include('vistas.view.pages.components.home.nuestra-app')
    </section>

    <!-- BUSCAS TUTORIAS / ALIANZAS-->
    <section class="tutorias-container fade-up">
        <div class="tutorias">
            @include('vistas.view.pages.components.home.buscas-tutorias')
        </div>

        <!-- ALIANZAS-->
        <div class=" alianzas-container fade-up">
            
            <h1 class="header-main__title"><span data-translate="alianzas_edu"></span></h1>
            <p class="header-main__subtitle" data-translate="alianzas_Classgo_1"></p>
            @include('components.alianzas', ['alianzas' => $alianzas])
        </div>
    </section>

    <!-- Encuesta-->
    @php
        $mostrarEncuesta = false;

        // 1. INVITADO -> MOSTRAR
        if (Auth::guest()) {
            $mostrarEncuesta = true;
        }
        // 2. LOGUEADO
        else {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // VALIDACIÓN DE ROL:
            if ($user->hasRole('student')) {
                // VALIDACIÓN DE SI YA RESPONDIo
                $yaRespondio = \App\Models\Encuesta::where('IdUser', $user->id)->exists();

                if (!$yaRespondio) {
                    // Es estudiante y NO ha respondido
                    $mostrarEncuesta = true;
                }
            }
            // Si es tutor se queda oculto.
        }
    @endphp

    {{-- Renderizado --}}
    @if ($mostrarEncuesta)
        <section>
            @include('vistas.view.pages.components.home.encuesta')
        </section>
    @endif

    <script>
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
