<div id="carousel-nativo" class="carousel-wrapper" data-carousel="new-tutor-carousel">
    
    {{-- Botón Anterior --}}
    <button class="carousel-btn prev" type="button" aria-label="Anterior" disabled>‹</button>

    <div class="carousel-viewport">
        <div class="carousel-track">
            
            {{-- LOOP DE TUTORES --}}
            @foreach($featuredTutors as $tutor)
                <div class="tutor-card">
                    {{-- FOTO --}}
                    <div class="tutor-image-wrapper">
                        <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" 
                             alt="Foto de {{ $tutor->profile->first_name }}" 
                             class="tutor-foto"
                             onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                    </div>

                    {{-- CONTENIDO --}}
                    <div class="tutor-card-content">
                        
                        {{-- Info Superior --}}
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
                                {{ Str::limit($tutor->profile->tagline ?? 'Tutor Profesional', 50) }}
                            </p>
                        </div>

                        {{-- Estadísticas --}}
                        <div class="tutor-stats">
                            <div class="stat-item">
                                <div class="stat-value">
                                    <span class="stat-icon-emoji">⭐</span>{{ number_format($tutor->avg_rating, 1) }}
                                </div>
                                <div class="stat-label">Rating</div>
                            </div>

                            <div class="stat-item">
                                <div class="stat-value">
                                    <span class="stat-icon-emoji">📖</span>{{ $tutor->subjects_count }}
                                </div>
                                <div class="stat-label">Materias</div>
                            </div>

                            <div class="stat-item">
                                <div class="stat-value">
                                    {{ 0 + ($tutor->profile->price ?? 15) }}Bs
                                </div>
                                <div class="stat-label">20 min.</div>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="tutor-actions">
                            <button class="btn-perfil" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                                Ver perfil
                            </button> 
                            <button class="btn-bookmark">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach

            {{-- CARD "VER MÁS" --}}
            <div class="tutor-card see-more-card" style="background: #0d1d2a;">
                <div class="tutor-image-wrapper">
                    <img src="{{ asset('images/home/models/img4.webp') }}"
                         alt="Ver más tutores"
                         class="tutor-foto"
                         onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                </div>

                <div class="tutor-card-content-vermas">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>

                    <h3>Ver más tutores</h3>
                    <p>Buscas tutores de acuerdo a lo que deseas aprender.</p>

                    <a href="{{ route('buscar') }}" class="btn-explorar-final">
                        <span>Explorar</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
    
    {{-- Botón Siguiente --}}
    <button class="carousel-btn next" type="button" aria-label="Siguiente" disabled>›</button>
</div>

<style>
    /* =========================================
       RESET Y ESTRUCTURA GENERAL
       ========================================= */
    #carousel-nativo {
        position: relative; 
        width: 100%; 
        max-width: 1250px; 
        margin: 40px auto; 
        padding: 0 70px; /* Espacio para botones */
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
        line-height: 1.2 !important; text-align: left !important; 
    }
    #carousel-nativo * { box-sizing: border-box; margin: 0; padding: 0; border: none; outline: none; }

    #carousel-nativo .carousel-wrapper { position: relative; width: 100%; }
    
    #carousel-nativo .carousel-viewport { 
        width: 100%; overflow: hidden; 
        padding: 40px 10px; 
    }
    
    #carousel-nativo .carousel-track {
        display: flex; gap: 24px; 
        overflow-x: auto; scroll-snap-type: x mandatory; 
        scroll-behavior: smooth; 
        scrollbar-width: none; padding-bottom: 10px;
    }
    #carousel-nativo .carousel-track::-webkit-scrollbar { display: none; }

    /* =========================================
       TARJETAS (BASE)
       ========================================= */
    #carousel-nativo .tutor-card {
        width: 300px; flex: 0 0 300px; height: 440px;
        border-radius: 28px; background-color: #0d1d2a; 
        position: relative; scroll-snap-align: center; overflow: hidden;
        
        box-shadow: 0 10px 30px -10px rgba(0, 224, 224, 0.3);
        border: 1px solid rgba(0, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);

        /* 🔥 FIX CLAVE: MÁSCARA PARA QUE NO SE SALGA EL EFECTO CUADRADO */
        -webkit-mask-image: -webkit-radial-gradient(white, black);
        mask-image: radial-gradient(white, black);
    }

    #carousel-nativo .tutor-card:hover { 
        transform: translateY(-12px);
        box-shadow: 0 20px 50px -10px rgba(0, 255, 255, 0.4);
        border-color: rgba(0, 255, 255, 0.4); z-index: 5;
    }
    #carousel-nativo .tutor-image-wrapper { width: 100%; height: 100%; position: absolute; top: 0; left: 0; }
    #carousel-nativo .tutor-foto { width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease; }
    #carousel-nativo .tutor-card:hover .tutor-foto { transform: scale(1.1); }

    /* =========================================
       CONTENIDO TARJETAS NORMALES
       ========================================= */
    #carousel-nativo .tutor-card-content {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
        background: linear-gradient(to top, rgba(3, 20, 30, 0.98) 15%, rgba(3, 20, 30, 0.8) 60%, rgba(3, 20, 30, 0) 100%);
        padding: 24px 20px 20px 20px;
        display: flex; flex-direction: column; justify-content: flex-end; 
        align-items: flex-start !important; text-align: left !important;
        pointer-events: none;
    }

    #carousel-nativo .tutor-info { width: 100%; margin-bottom: 12px; }
    #carousel-nativo .tutor-nombre { 
        font-size: 1.35rem; font-weight: 800; color: #ffffff;
        margin: 0 0 6px 0; display: flex; align-items: center; gap: 6px; 
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }
    #carousel-nativo .tutor-cargo { 
        font-size: 0.9rem; color: #aedee6; font-weight: 500; 
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;  
        display: block; width: 100%; text-align: left !important;
    }

    #carousel-nativo .tutor-stats { 
        display: flex; align-items: center; width: 100%; margin-bottom: 16px; 
        background: rgba(255,255,255,0.05); padding: 8px; border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.05);
    }
    #carousel-nativo .stat-item { flex: 1; display: flex; flex-direction: column; align-items: center; border-right: 1px solid rgba(255,255,255,0.15); }
    #carousel-nativo .stat-item:last-child { border-right: none; }
    #carousel-nativo .stat-value { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 2px; }
    #carousel-nativo .stat-label { font-size: 0.7rem; color: #82a7ad; }

    #carousel-nativo .tutor-actions, #carousel-nativo .btn-perfil, #carousel-nativo .btn-bookmark { pointer-events: auto; }
    #carousel-nativo .tutor-actions { display: flex; gap: 10px; width: 100%; }

    #carousel-nativo .btn-perfil {
        flex: 1; height: 42px; border-radius: 14px;
        background: linear-gradient(135deg, #FB8500 0%, #FB8500 100%);
        color: white; font-size: 0.95rem; font-weight: 700; cursor: pointer;
        box-shadow: 0 4px 12px rgba(224, 202, 0, 0.3); transition: transform 0.2s;
    }
    #carousel-nativo .btn-perfil:hover { transform: translateY(-2px); background: #ff9e01ff; }
    #carousel-nativo .btn-bookmark {
        width: 42px; height: 42px; border-radius: 14px;
        background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); 
        color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s;
    }
    #carousel-nativo .btn-bookmark:hover { transform: scale(1.05); color: #00ffff; }

    /* =========================================
       CARD "VER MÁS" (SOLUCIÓN BORDE CUADRADO)
       ========================================= */
    #carousel-nativo .tutor-card-content-vermas {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10;
        background: rgba(3, 20, 30, 0.85); backdrop-filter: blur(8px);
        opacity: 0; 
        
        display: flex; flex-direction: column; 
        align-items: center !important; justify-content: center !important; text-align: center !important;
        
        padding: 30px; transition: all 0.4s ease; pointer-events: none;
        
        /* 🔥 FIX: Aseguramos que el hijo también sea redondo */
        border-radius: 28px;
    }
    #carousel-nativo .tutor-card:hover .tutor-card-content-vermas { opacity: 1; pointer-events: auto; }

    #carousel-nativo .tutor-card-content-vermas .icon-wrapper { margin-bottom: 15px; background: rgba(0,255,255,0.1); padding: 15px; border-radius: 50%; }
    #carousel-nativo .tutor-card-content-vermas .icon-wrapper svg { width: 30px; height: 30px; color: #fff; }
    #carousel-nativo .tutor-card-content-vermas h3 { color: white; font-size: 1.5rem; margin-bottom: 10px; font-weight: 800; }
    #carousel-nativo .tutor-card-content-vermas p { color: #aedee6; margin-bottom: 25px; font-size: 0.95rem; }
    
    #carousel-nativo .btn-explorar-final {
        text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 12px 30px; border-radius: 50px; background: transparent; 
        border: 2px solid #00e0e0; color: #00e0e0; font-weight: 700; cursor: pointer; transition: all 0.3s;
        width: auto !important;
    }
    #carousel-nativo .btn-explorar-final:hover { background: #00e0e0; color: #001a20; box-shadow: 0 0 20px rgba(0,224,224,0.5); }
    #carousel-nativo .btn-explorar-final svg { width: 20px; height: 20px; }

    /* =========================================
       BOTONES DE NAVEGACIÓN
       ========================================= */
    #carousel-nativo .carousel-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        background: rgba(0, 36, 48, 0.9); border: 1px solid #00e0e0; color: #eaffff;
        border-radius: 50%; width: 48px; height: 48px; cursor: pointer; z-index: 1000; 
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3); transition: all 0.3s;
    }
    #carousel-nativo .carousel-btn:hover { 
        background: #00e0e0; color: #001a20; 
        box-shadow: 0 0 15px #00e0e0; transform: translateY(-50%) scale(1.1);
    }
    #carousel-nativo .carousel-btn.prev { left: 10px !important; right: auto !important; }
    #carousel-nativo .carousel-btn.next { right: 10px !important; left: auto !important; }

    /* =========================================
       MÓVIL
       ========================================= */
    @media (max-width: 768px) {
        #carousel-nativo { padding: 0 !important; margin: 20px 0 !important; }
        #carousel-nativo .carousel-btn { display: none !important; } 
        #carousel-nativo .carousel-track { padding: 0 20px !important; gap: 15px !important; }
        #carousel-nativo .tutor-card { width: 85vw !important; flex: 0 0 85vw !important; height: 480px !important; }

        #carousel-nativo .tutor-card-content {
            background: linear-gradient(to top, rgba(3, 20, 30, 1) 15%, rgba(3, 20, 30, 0.9) 60%, rgba(3, 20, 30, 0) 100%) !important;
            padding-bottom: 35px !important;
            align-items: flex-start !important;
        }
        
        #carousel-nativo .tutor-cargo { 
            display: block !important; opacity: 1 !important; margin-bottom: 10px !important; white-space: nowrap !important;
        }

        #carousel-nativo .tutor-card-content-vermas {
            opacity: 1 !important; pointer-events: auto !important;
            background: rgba(3, 20, 30, 0.8) !important;
            align-items: center !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.querySelector('.carousel-wrapper[data-carousel="new-tutor-carousel"]');
        if (!wrapper) return;
        const track = wrapper.querySelector('.carousel-track');
        const btnPrev = wrapper.querySelector('.carousel-btn.prev');
        const btnNext = wrapper.querySelector('.carousel-btn.next');
        
        if (!track) return;

        // --- 1. LÓGICA DE ESCALADO (SOLO MÓVIL) ---
        const animateCards = () => {
            const cards = Array.from(track.querySelectorAll('.tutor-card'));

            // Si la pantalla es grande (Escritorio > 768px), NO hacemos el efecto.
            if (window.innerWidth > 768) {
                cards.forEach(card => card.style.transform = 'scale(1)');
                return; 
            }

            // --- A PARTIR DE AQUÍ SOLO SE EJECUTA EN CELULAR ---
            const trackCenter = track.scrollLeft + (track.clientWidth / 2);

            cards.forEach((card) => {
                const cardCenter = card.offsetLeft + (card.offsetWidth / 2);
                const distance = Math.abs(trackCenter - cardCenter);
                
                const range = 250; 
                let scale = 1;
                
                if (distance < range) {
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
            animateCards(); 
            updateButtons();
        });
        
        animateCards();
        updateButtons();
        
        window.addEventListener('load', () => {
            animateCards();
            updateButtons();
        });
    });
</script>