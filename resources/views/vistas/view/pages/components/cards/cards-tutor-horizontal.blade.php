{{-- ARCHIVO DE RESPALDO: DISEÑO HORIZONTAL (PC) --}}
{{-- Usa este código cuando necesites el diseño ancho en otros proyectos --}}


<div class="carousel-wrapper" data-carousel="new-tutor-carousel">
    <button class="carousel-btn prev" type="button" aria-label="Anterior" disabled>‹</button>

    <div class="carousel-viewport">
        <div class="carousel-track">

            @foreach($featuredTutors as $tutor)
                <div class="tutor-card">
                    {{-- FOTO (Izquierda) --}}
                    <div class="tutor-image-container">
                        <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" 
                             alt="Foto de {{ $tutor->profile->first_name }}" 
                             class="tutor-foto"
                             onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                    </div>

                    {{-- CONTENIDO (Derecha) --}}
                    <div class="tutor-card-content">
                        <div class="tutor-info">
                            {{-- Nombre y Verificado --}}
                            <h3 class="tutor-nombre">
                                {{ explode(' ', $tutor->profile->first_name)[0] }} 
                                {{ explode(' ', $tutor->profile->last_name)[0] }}
                                <span class="icon-verificado">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" fill="#1DA1F2"/>
                                        <path d="M7.5 12L10.5 15L16.5 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </h3>
                            
                            {{-- Cargo --}}
                            <span class="tutor-cargo">
                                {{ Str::limit($tutor->profile->tagline ?? 'Tutor Verificado', 30) }}
                            </span>

                            {{-- Materias (Chips Grises) --}}
                            <div class="tutor-materias">
                                @foreach($tutor->subjects->take(5) as $subject)
                                    <span>{{ $subject->name }}</span>
                                @endforeach

                                @if($tutor->subjects->count() > 5)
                                    <span class="more-materias">+{{ $tutor->subjects->count() - 5 }} Más</span> 
                                @endif
                            </div>
                        </div>

                        {{-- Parte Inferior (Stats y Botones) --}}
                        <div class="tutor-bottom">
                            <div class="tutor-stats">
                                <div class="stat-item">
                                    <strong style="font-size: 1.2em; margin-right: 4px;">{{ $tutor->subjects_count }}</strong> 
                                    Materias
                                </div>
                                <div class="stat-item">
                                    <span class="stat-icon" style="color: #f39c12;">⭐</span> 
                                    <strong>{{ number_format($tutor->avg_rating, 1) }}</strong>
                                </div>
                                <div class="stat-item">
                                    <strong>{{ $tutor->hourly_rate ?? '15' }}Bs</strong>/20min
                                </div>
                            </div>

                            <div class="tutor-actions">
                                <button class="btn-perfil btn-blue" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                                    Ver Perfil
                                </button> 
                                <button class="btn-perfil btn-outline">Ver Materias</button>
                                <button class="btn-bookmark">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

             {{-- CARD FINAL "VER MÁS" --}}
             <div class="tutor-card see-more-card" style="justify-content: center; align-items: center; background: #f0f4f8;">
                <div class="tutor-card-content" style="text-align: center; background: transparent; justify-content: center; align-items: center;">
                    <h3 class="tutor-nombre" style="justify-content: center; font-size: 2em; margin-bottom: 10px;">¿Buscas más?</h3>
                    <p style="margin: 0 0 20px 0; color: #666; font-size: 1.1rem;">Explora todos nuestros tutores disponibles.</p>
                    <a href="{{ route('buscar') }}">
                        <button class="btn-perfil btn-blue" style="padding: 12px 30px; width: auto;">Explorar Todo</button>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <button class="carousel-btn next" type="button" aria-label="Siguiente" disabled>›</button>
</div>

<style>
    /* =========================================
       1. ESTRUCTURA GENERAL DEL CARRUSEL
       ========================================= */
    .carousel-wrapper {
        position: relative;
        width: 100%;
        margin: 20px auto;
        display: flex;
        justify-content: center;
    }

    .carousel-viewport {
        /* Define el ancho visible. 750px card + 20px gap = 770px aprox */
        width: 100%;
        max-width: 800px; 
        overflow: hidden;
        padding: 20px 0; 
    }

    .carousel-track {
        display: flex;
        gap: 20px;
        width: max-content;
        transition: transform 0.4s ease-in-out;
        padding-left: 10px; /* Pequeño margen visual */
    }

    /* =========================================
       2. ESTILOS DE LA TARJETA (VERSIÓN ESCRITORIO)
       Aquí es donde ocurre la magia para que se vea HORIZONTAL
       ========================================= */
    .tutor-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        
        /* FUERZA LA FILA (FOTO IZQ - TEXTO DER) */
        display: flex;
        flex-direction: row; 
        
        /* TAMAÑO FIJO GRANDE */
        width: 750px;
        flex: 0 0 750px;
        height: 380px; /* Altura fija para consistencia */
        
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .tutor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    /* -- IZQUIERDA: FOTO -- */
    .tutor-image-container {
        width: 300px; /* Ancho fijo de la columna de foto */
        flex: 0 0 300px;
        height: 100%;
        overflow: hidden;
    }

    .tutor-foto {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
    }

    /* -- DERECHA: CONTENIDO -- */
    .tutor-card-content {
        flex: 1; /* Ocupa el resto del espacio */
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Esparce contenido arriba y abajo */
    }

    /* Título */
    .tutor-nombre {
        font-family: 'Montserrat', sans-serif;
        font-size: 2rem;
        font-weight: 800;
        color: #222;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        line-height: 1.1;
    }

    .tutor-cargo {
        font-size: 1rem;
        color: #999;
        font-weight: 600;
        display: block;
        margin-bottom: 15px;
    }

    /* Materias (Chips) */
    .tutor-materias {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 10px;
    }

    .tutor-materias span {
        background-color: #eee;
        color: #555;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    /* Footer (Stats y Botones) */
    .tutor-bottom {
        margin-top: auto;
    }

    .tutor-stats {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        font-size: 1rem;
        color: #444;
    }

    .stat-item {
        display: flex;
        align-items: center;
        padding: 0 15px;
        position: relative;
    }
    .stat-item:first-child { padding-left: 0; }

    /* Línea separadora azul */
    .stat-item:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 20%;
        height: 60%;
        width: 2px;
        background-color: #3498db;
    }

    /* Botones */
    .tutor-actions {
        display: flex;
        gap: 10px;
    }

    .btn-perfil {
        flex: 1;
        padding: 12px 0;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-blue {
        background-color: #1890ff;
        color: white;
        border: none;
    }
    .btn-blue:hover { background-color: #1070c9; }

    .btn-outline {
        background-color: white;
        color: #333;
        border: 2px solid #ddd;
    }
    .btn-outline:hover { border-color: #1890ff; color: #1890ff; }

    .btn-bookmark {
        width: 50px;
        background: #f39c12;
        border: none;
        border-radius: 10px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .btn-bookmark:hover { background: #e67e22; }

    /* Flechas */
    .carousel-btn {
        position: absolute;
        top: 50%; transform: translateY(-50%);
        background: #fff;
        border: 1px solid #ddd;
        width: 50px; height: 50px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        z-index: 10;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .carousel-btn.prev { left: -60px; }
    .carousel-btn.next { right: -60px; }
    .carousel-btn:disabled { opacity: 0.5; cursor: default; }


    /* =========================================
       3. RESPONSIVIDAD (MÓVIL)
       Aquí transformamos la tarjeta a VERTICAL si la pantalla es pequeña
       ========================================= */
    @media (max-width: 900px) {
        .carousel-wrapper {
            display: block;
            padding: 0 10px;
        }
        .carousel-viewport {
            max-width: 100%;
            overflow: visible;
        }
        
        .tutor-card {
            /* CAMBIO A VERTICAL */
            flex-direction: column;
            width: 300px;       /* Ancho móvil */
            height: 500px;      /* Alto móvil */
            margin: 0 auto;
        }

        .tutor-image-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0; left: 0;
            z-index: 0;
        }
        
        .tutor-card-content {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            z-index: 1;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 60%, transparent 100%);
            color: #fff;
            justify-content: flex-end;
            border-radius: 0 0 20px 20px;
        }

        /* Ajustes visuales para móvil (texto blanco sobre foto) */
        .tutor-nombre { color: #fff; font-size: 1.8rem; }
        .tutor-cargo { color: #ddd; }
        .tutor-materias { display: none; } /* Ocultar materias */
        .btn-outline { display: none; } /* Ocultar botón secundario */
        
        .tutor-stats { 
            color: #fff; 
            justify-content: space-around;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 10px;
        }
        .stat-item::after { display: none; } /* Quitar líneas separadoras */
        
        .carousel-btn { display: none; } /* Ocultar flechas */
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        function setupTutorCarousel() {
            const wrapper = document.querySelector('.carousel-wrapper[data-carousel="new-tutor-carousel"]');
            if (!wrapper) return;

            const track = wrapper.querySelector('.carousel-track');
            const btnPrev = wrapper.querySelector('.carousel-btn.prev');
            const btnNext = wrapper.querySelector('.carousel-btn.next');
            const viewport = wrapper.querySelector('.carousel-viewport');

            if (!track || !btnPrev || !btnNext || !viewport) return;

            const cards = Array.from(track.children);
            const cardCount = cards.length;
            if (cardCount === 0) return;

            let currentIndex = 0;
            let isMoving = false;
            const transitionTime = 400;

            const getCardStep = () => {
                const card = cards[0];
                const style = window.getComputedStyle(track);
                const gap = parseFloat(style.gap) || 20;
                const width = card.getBoundingClientRect().width;
                return width + gap;
            };

            const maxIndex = () => {
                // En escritorio, mostramos 1 tarjeta grande a la vez, 
                // por lo tanto el max index es cardCount - 1
                return Math.max(0, cardCount - 1);
            };

            const moveCarousel = (animate = true) => {
                const step = getCardStep();
                currentIndex = Math.min(Math.max(currentIndex, 0), maxIndex());

                if (animate) {
                    track.style.transition = `transform ${transitionTime / 1000}s ease-in-out`;
                } else {
                    track.style.transition = 'none';
                }

                track.style.transform = `translateX(-${currentIndex * step}px)`;

                if (animate) {
                    setTimeout(() => { isMoving = false; }, transitionTime);
                } else {
                    isMoving = false;
                }
                updateButtons();
            };

            const updateButtons = () => {
                btnPrev.disabled = currentIndex <= 0;
                btnNext.disabled = currentIndex >= maxIndex();
                
                btnPrev.style.opacity = btnPrev.disabled ? '0.5' : '1';
                btnNext.style.opacity = btnNext.disabled ? '0.5' : '1';
                btnPrev.style.cursor = btnPrev.disabled ? 'default' : 'pointer';
                btnNext.style.cursor = btnNext.disabled ? 'default' : 'pointer';
            };

            btnNext.addEventListener('click', () => {
                if (isMoving || btnNext.disabled) return;
                isMoving = true;
                currentIndex++;
                moveCarousel();
            });

            btnPrev.addEventListener('click', () => {
                if (isMoving || btnPrev.disabled) return;
                isMoving = true;
                currentIndex--;
                moveCarousel();
            });

            // Soporte Touch
            let startX = 0;
            let isDragging = false;
            
            track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                track.style.transition = 'none';
            }, { passive: true });

            track.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                const currentX = e.touches[0].clientX;
                const diff = currentX - startX;
                const step = getCardStep();
                track.style.transform = `translateX(${-(currentIndex * step) + diff}px)`;
            }, { passive: true });

            track.addEventListener('touchend', (e) => {
                isDragging = false;
                const endX = e.changedTouches[0].clientX;
                const diff = endX - startX;
                if (diff < -50) {
                    if (currentIndex < maxIndex()) currentIndex++;
                } else if (diff > 50) {
                    if (currentIndex > 0) currentIndex--;
                }
                moveCarousel(true);
            });

            // Resize observer
            window.addEventListener('resize', () => {
                moveCarousel(false);
            });

            // Init
            setTimeout(() => {
                moveCarousel(false);
                updateButtons();
            }, 100);
        }

        setupTutorCarousel();
    });
</script>
{{-- Recuerda agregar el JS correspondiente si usas este archivo --}}