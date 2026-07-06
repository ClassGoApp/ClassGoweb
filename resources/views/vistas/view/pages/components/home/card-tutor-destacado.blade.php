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
                                {{ Str::limit($tutor->profile->tagline ?? 'Tutor Verificado por ClassGo', 50) }}
                            </p>
                        </div>

                        {{-- Estadísticas --}}
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

                            @auth
                                @if(auth()->user()->hasRole('student'))
                                    <livewire:save-button :tutorId="$tutor->id" />
                                @endif
                            @endauth
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