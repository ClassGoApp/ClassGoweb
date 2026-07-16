<div class="carousel-wrapper" data-carousel="new-tutor-carousel">
    <button class="carousel-btn prev" 
        type="button" 
        aria-label="Anterior"
        data-aria-label-key="tutor_carousel_prev"
        disabled>
        ‹
    </button>

    <div class="carousel-viewport">
        <div class="carousel-track">
            @foreach($featuredTutors as $tutor)
                <div class="tutor-card">
                    {{-- FOTO (Fondo con efecto Zoom) --}}
                    <div class="tutor-image-wrapper">
                        <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" 
                            alt="Foto de {{ $tutor->profile->first_name }}"
                            data-alt-prefix-key="tutor_carousel_photo_of"
                            data-tutor-name="{{ $tutor->profile->first_name }}" 
                            class="tutor-foto"
                            onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                    </div>

                    {{-- CONTENIDO (Compacto y Elegante) --}}
                    <div class="tutor-card-content">
                        
                        {{-- INFO SUPERIOR --}}
                        <div class="tutor-info">
                            <h3 class="tutor-nombre">
                                {{ $tutor->profile->first_name }} {{ explode(' ', $tutor->profile->last_name)[0] }}
                                <span class="icon-verificado">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" fill="#1DA1F2"/>
                                        <path d="M7.5 12L10.5 15L16.5 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </h3>
                            <p class="tutor-cargo">
                                @if(!empty($tutor->profile->tagline))
                                    {{ Str::limit($tutor->profile->tagline, 50) }}
                                @else
                                    <span data-translate="tutor_carousel_professional_tutor">
                                        Tutor Profesional
                                    </span>
                                @endif
                            </p>
                        </div>

                        {{-- ESTADÍSTICAS --}}
                        <div class="tutor-stats">
                            <div class="stat-item">
                                <div class="stat-value">
                                    <span class="stat-icon-emoji">⭐</span>{{ number_format($tutor->avg_rating, 1) }}
                                </div>
                                <div class="stat-label" data-translate="rating">Calificación</div>
                            </div>

                            <div class="stat-item">
                                <div class="stat-value">
                                    <span class="stat-icon-emoji">📖</span>{{ $tutor->subjects_count }}
                                </div>
                                <div class="stat-label" data-translate="subjects">Materias</div>
                            </div>

                            <div class="stat-item">
                                <div class="stat-value">
                                    {{ $tutor->hourly_rate ?? '15' }}Bs
                                </div>
                                <div class="stat-label">20 min.</div>
                            </div>
                        </div>

                        {{-- BOTONES --}}
                        <div class="tutor-actions">
                            <button class="btn-perfil" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                                <span data-translate="view_profile">Ver perfil</span>
                            </button> 
                            <button class="btn-bookmark">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- CARD "VER MÁS" --}}
            <div class="tutor-card see-more-card" style="background: #0f172a;">
                
                <div class="tutor-image-wrapper">
                    <img src="{{ asset('images/home/models/img4.webp') }}"
                        alt="Ver más tutores"
                        data-alt-key="see_more_tutors"
                        class="tutor-foto"
                        onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                </div>

                {{-- Usamos la clase con el CSS centrado que hicimos antes --}}
                <div class="tutor-card-content-vermas">
                    
                    <div class="icon-wrapper" style="margin-bottom: 15px; background: rgba(255,255,255,0.1); padding: 15px; border-radius: 50%; transition: transform 0.3s ease;">
                        <svg style="width: 30px; height: 30px; color: #fff;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <h3 style="color: white; font-size: 1.3rem; margin: 0 0 5px 0; font-weight: 700;"
                        data-translate="see_more_tutors">
                        Ver más tutores
                    </h3>
                    <p style="color: #ccc; font-size: 0.85rem; margin: 0 0 15px 0;"
                        data-translate="find_tutors_description">
                         Busca tutores de acuerdo a lo que deseas aprender.
                        </p>

                    <a href="{{ route('buscar') }}">
                        <button class="btn-perfil" style="width: auto; padding: 0 25px; gap: 8px;">
                            
                            <span data-translate="explore_tutors">Explorar</span>
                            
                            {{-- ICONO SVG ELEGANTE (Lupa) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 18px; height: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>

                        </button>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <button class="carousel-btn next" 
        type="button" 
        aria-label="Siguiente"
        data-aria-label-key="tutor_carousel_next"
        disabled>
        ›
    </button>
</div>

<style>
    /* =========================================
       1. ESTRUCTURA Y SCROLL
       ========================================= */
    .carousel-wrapper {
        position: relative; width: 100%; max-width: 1050px;
        margin: 20px auto; padding: 0 50px; box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }
    .carousel-viewport { width: 100%; overflow: hidden; padding: 30px 0; }
    
    .carousel-track {
        display: flex; gap: 20px;
        overflow-x: auto; scroll-snap-type: x mandatory; 
        scroll-behavior: smooth; 
        scrollbar-width: none; -ms-overflow-style: none; padding-bottom: 10px;
    }
    .carousel-track::-webkit-scrollbar { display: none; }

    /* =========================================
       2. TARJETAS (ESTRUCTURA PRINCIPAL)
       ========================================= */
    .tutor-card {
        width: 280px; flex: 0 0 280px; height: 400px;
        border-radius: 24px;
        background-color: #1a1a1a;
        position: relative; 
        scroll-snap-align: center;
        
        /* MAGIA 1: Recortamos la imagen que crece */
        overflow: hidden; 
        
        /* MAGIA 2: Sombra base suave */
        box-shadow: 0 8px 20px rgba(0,0,0,0.15); 

        /* MAGIA 3: Transición solo de posición y sombra (NO SCALE) */
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        
        /* Fix para evitar parpadeos en bordes */
        -webkit-mask-image: -webkit-radial-gradient(white, black);
        transform: translateZ(0); 
    }

    /* EFECTO HOVER CARD: Solo flota, no se estira */
    .tutor-card:hover { 
        transform: translateY(-8px); /* Sube 8px suavemente */
        box-shadow: 0 20px 40px rgba(0,0,0,0.4); /* Sombra difusa hacia abajo */
        z-index: 5;
    }

    /* =========================================
       3. IMAGEN (ZOOM)
       ========================================= */
    .tutor-image-wrapper {
        width: 100%; height: 100%; position: absolute; top: 0; left: 0;
    }

    .tutor-foto { 
        width: 100%; height: 100%; object-fit: cover; 
        /* Transición lenta para el zoom */
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        will-change: transform;
    }

    /* AL HACER HOVER EN LA TARJETA, LA FOTO HACE ZOOM */
    .tutor-card:hover .tutor-foto {
        transform: scale(1.12); /* Zoom al 112% */
    }

    /* =========================================
       4. CONTENIDO (ESTÁTICO Y COMPACTO)
       ========================================= */
    .tutor-card-content {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
        
        /* Altura compacta */
        height: auto; min-height: 30%;
        
        /* Degradado negro elegante */
        background: linear-gradient(to top, rgba(0,0,0,1) 0%, rgba(0,0,0,0.8) 70%, rgba(0,0,0,0) 100%);
        
        padding: 15px; padding-top: 50px;
        display: flex; flex-direction: column; justify-content: flex-end; align-items: flex-start;
        box-sizing: border-box; pointer-events: none;
        
        /* SIN TRANSICIÓN DE MOVIMIENTO AQUÍ -> El texto se queda quieto */
    }
    
    /* Clase específica para la tarjeta "Ver más" (Centrada) */
    .tutor-card-content-vermas {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
        height: 35%;
        background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.8) 70%, rgba(0,0,0,0) 100%);
        padding: 20px;
        display: flex; flex-direction: column; 
        justify-content: flex-end; align-items: center; text-align: center;
        box-sizing: border-box; pointer-events: auto;
    }

    /* Elementos interactivos */
    .tutor-actions, .tutor-info, .btn-perfil, .btn-bookmark { pointer-events: auto; }

    /* --- TIPOGRAFÍA --- */
    .tutor-info { width: 100%; margin-bottom: 8px; text-align: left; }
    .tutor-nombre { font-size: 1.1rem; font-weight: 700; color: #fff; margin: 0 0 2px 0; display: flex; align-items: center; gap: 4px; text-shadow: 0 2px 5px rgba(0,0,0,0.5); }
    .tutor-cargo { font-size: 0.75rem; color: #ccc; margin: 0; font-weight: 400; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%; display: block; }

    /* --- ESTADÍSTICAS --- */
    .tutor-stats { display: flex; align-items: center; width: 100%; margin-bottom: 12px; gap: 0; }
    .stat-item {
        display: flex;
        flex-direction: column;
        flex: 1;
        
        /* Agrega esto para centrar horizontalmente */
        align-items: center; 
        
        /* Opcional: para centrar verticalmente si sobra espacio */
        justify-content: center; 

        /* NOTA: Tu padding actual empuja el contenido un poco a la izquierda.
        Para un centrado perfecto, iguala el padding o úsalo solo para el borde. */
        padding-right: 5px; 
        padding-left: 5px; /* Agregado para equilibrar */
        
        margin-right: 5px;
        border-right: 1px solid rgba(255,255,255,0.15);
    }

    .stat-item:last-child {
        border-right: none;
        padding-right: 0;
        margin-right: 0;
        padding-left: 0;
    }

    .stat-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 4px;
        line-height: 1;
        margin-bottom: 2px;
        
        /* Asegura que el texto interno también se centre si hay saltos de línea */
        text-align: center; 
    }    
    .stat-icon-emoji { font-size: 0.8rem; }
    .stat-label { font-size: 0.65rem; color: #999; font-weight: 500; }

    /* --- BOTONES --- */
    .tutor-actions { display: flex; align-items: center; gap: 8px; width: 100%; }
    .btn-perfil {
        flex: 1; height: 36px; border-radius: 18px; border: none;
        background-color: #ffffff; color: #000000;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s, background-color 0.2s; 
    }
    .btn-perfil:hover { background-color: #f0f0f0; transform: scale(1.05); } 
    
    .btn-bookmark {
        width: 36px; height: 36px; border-radius: 12px;
        background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(5px);
        border: 1px solid rgba(255,255,255,0.1); color: white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        
        /* CAMBIO 1: Agregamos transform a la transición para que sea suave */
        transition: background 0.2s, transform 0.2s; 
    }

    .btn-bookmark:hover { 
        background: rgba(255,255,255,0.3); 
        
        /* CAMBIO 2: Agregamos el efecto de zoom del perfil */
        transform: scale(1.15); 
    }

    /* Estilo para los botones de navegación */
    .carousel-btn {
        position: absolute; 
        top: 50%; 
        transform: translateY(-50%);
        background: #fff; 
        border: 1px solid #ddd; 
        border-radius: 50%;
        width: 40px; 
        height: 40px; 
        cursor: pointer; 
        z-index: 1000;
        font-size: 1.5rem; 
        color: #333;
        display: flex; 
        align-items: center; 
        justify-content: center;
        /* Reduje un poco la opacidad de la sombra para que sea más sutil */
        box-shadow: 0 2px 8px rgba(0,0,0,0.2); 
        transition: all 0.3s;
    }

    .carousel-btn:hover { 
        transform: translateY(-50%) scale(1.1); 
        box-shadow: 0 4px 10px rgba(0,0,0,0.3); 
    }

    .carousel-btn:disabled { 
        opacity: 0; 
        pointer-events: none; 
    }

    /* --- AQUÍ ESTÁ LA SOLUCIÓN RÁPIDA --- */
    /* En lugar de 0, les damos 10px de espacio para que la sombra no se corte */
    .carousel-btn.prev { 
        left: 10px; 
    }

    .carousel-btn.next { 
        right: 10px; 
    }
    /* =========================================
       5. CELULAR
       ========================================= */
    @media (max-width: 768px) {
        .carousel-btn { display: none !important; }
        .carousel-wrapper { padding: 0; }
        .carousel-viewport { padding: 20px 0; }
        
        /* Padding calculado para centrar tarjeta de 85vw */
        .carousel-track { padding: 0 7.5vw; gap: 15px; }
        
        .tutor-card {
            width: 85vw; flex: 0 0 85vw; height: 420px; margin: 0;
            /* En móvil simple: sin transiciones complejas */
            transition: transform 0.1s ease-out; 
        }
        
        /* En móvil quitamos efectos hover para evitar sticky states */
        .tutor-card:hover { transform: none; box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .tutor-card:hover .tutor-foto { transform: none; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.querySelector('.carousel-wrapper[data-carousel="new-tutor-carousel"]');
        if (!wrapper) return;
        const track = wrapper.querySelector('.carousel-track');
        const btnPrev = wrapper.querySelector('.carousel-btn.prev');
        const btnNext = wrapper.querySelector('.carousel-btn.next');

        function tutorCarouselText(key, fallback = '') {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (typeof translations === 'undefined') {
                return fallback;
            }

            const t = translations[lang] || translations.es;

            return t[key] || fallback;
        }

        function applyTutorCarouselAttributeTranslations() {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (typeof translations === 'undefined') {
                return;
            }

            const t = translations[lang] || translations.es;

            document.querySelectorAll('[data-aria-label-key]').forEach((element) => {
                const key = element.getAttribute('data-aria-label-key');

                if (t[key]) {
                    element.setAttribute('aria-label', t[key]);
                }
            });

            document.querySelectorAll('[data-alt-prefix-key]').forEach((element) => {
                const key = element.getAttribute('data-alt-prefix-key');
                const tutorName = element.getAttribute('data-tutor-name') || '';

                if (t[key]) {
                    element.setAttribute('alt', `${t[key]} ${tutorName}`);
                }
            });

            document.querySelectorAll('[data-alt-key]').forEach((element) => {
                const key = element.getAttribute('data-alt-key');

                if (t[key]) {
                    element.setAttribute('alt', t[key]);
                }
            });
        }
        
        if (!track) return;

        // --- 1. LÓGICA DE ESCALADO (SOLO MÓVIL) ---
        const animateCards = () => {
            const cards = Array.from(track.querySelectorAll('.tutor-card'));

            // CONDICIÓN IMPORTANTE:
            // Si la pantalla es grande (Escritorio > 768px), NO hacemos el efecto.
            // Forzamos que todas las tarjetas estén al 100% y salimos de la función.
            if (window.innerWidth > 768) {
                cards.forEach(card => card.style.transform = 'scale(1)');
                return; 
            }

            // --- A PARTIR DE AQUÍ SOLO SE EJECUTA EN CELULAR ---
            const trackCenter = track.scrollLeft + (track.clientWidth / 2);

            cards.forEach((card) => {
                const cardCenter = card.offsetLeft + (card.offsetWidth / 2);
                const distance = Math.abs(trackCenter - cardCenter);
                
                // Radio de efecto ajustado para móvil
                const range = 250; 
                let scale = 1;
                
                if (distance < range) {
                    // Se achica un 10% (0.9) si se aleja del centro
                    scale = 1 - (distance / range) * 0.1; 
                } else {
                    scale = 0.9;
                }

                card.style.transform = `scale(${scale})`;
            });
        };

        // --- 2. EVENTOS ---
        track.addEventListener('scroll', () => {
            animateCards();
            if(btnPrev && btnNext) updateButtons();
        });

        const getScrollAmount = () => {
            const card = track.querySelector('.tutor-card');
            return card ? card.offsetWidth + 25 : 300; 
        };

        if(btnNext) btnNext.addEventListener('click', () => { 
            track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' }); 
        });
        
        if(btnPrev) btnPrev.addEventListener('click', () => { 
            track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' }); 
        });

        const updateButtons = () => {
            if(!btnPrev || !btnNext) return;
            const maxScrollLeft = track.scrollWidth - track.clientWidth - 10;
            
            if (track.scrollLeft <= 10) {
                btnPrev.disabled = true; btnPrev.style.opacity = '0'; btnPrev.style.pointerEvents = 'none';
            } else {
                btnPrev.disabled = false; btnPrev.style.opacity = '1'; btnPrev.style.pointerEvents = 'auto';
            }
            if (maxScrollLeft <= 0 || track.scrollLeft >= maxScrollLeft) {
                btnNext.disabled = true; btnNext.style.opacity = '0'; btnNext.style.pointerEvents = 'none';
            } else {
                btnNext.disabled = false; btnNext.style.opacity = '1'; btnNext.style.pointerEvents = 'auto';
            }
        };

        // --- 3. INICIALIZACIÓN ---
        window.addEventListener('resize', () => {
            animateCards(); // Esto recalcula si pasas de PC a Móvil y viceversa
            updateButtons();
        });
        
        animateCards();
        updateButtons();
        applyTutorCarouselAttributeTranslations();

        window.addEventListener('load', () => {
            animateCards();
            updateButtons();
            applyTutorCarouselAttributeTranslations();
        });

        document.addEventListener('languageChanged', function() {
            applyTutorCarouselAttributeTranslations();
        });
    });
</script>