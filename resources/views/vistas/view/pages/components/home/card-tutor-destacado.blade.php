<div class="tutor-carousel" data-carousel="featured-tutors">
    <button class="tutor-carousel__btn tutor-carousel__btn--prev" type="button" aria-label="Anterior" disabled>
        <span>&lt;</span>
    </button>

    <div class="tutor-carousel__viewport">
        <div class="tutor-carousel__track">
            @foreach($featuredTutors as $tutor)
                <div class="tutor-carousel__slide">
                    <div class="profile-card">
                        <div class="profile-card__image-container">
                            <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}"
                                 alt="Tutor"
                                 class="profile-card__image"
                                 onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                        </div>

                        <div class="profile-card__content">
                            <div class="profile-card__header">
                                <h2 class="profile-card__name">
                                    {{ explode(' ', $tutor->profile->first_name)[0] }}
                                    {{ explode(' ', $tutor->profile->last_name)[0] }}
                                </h2>
                                <svg class="profile-card__verified-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            <p class="profile-card__description">
                                {{ $tutor->profile->tagline ?? 'Tutor verificado y aprobado por ClassGo!' }}
                            </p>

                            <div class="profile-card__footer">
                                <div class="profile-card__stats-group">
                                    <span class="profile-card__stat">
                                        <svg class="profile-card__stat-icon" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        {{ number_format($tutor->avg_rating,1) }}
                                    </span>
                                    <span class="profile-card__stat">
                                        <svg class="profile-card__stat-icon" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                        {{ $tutor->subjects_count }} Materias
                                    </span>
                                </div>

                                <button class="profile-card__button"
                                        onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                                    Ver Perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Slide adicional para explorar -->
            <div class="tutor-carousel__slide">
                <div class="profile-card">
                    <div class="profile-card__image-container2">
                        <img src="{{ asset('images/home/models/img4.webp') }}"
                             alt="Ver más tutores"
                             class="profile-card__image"
                             onerror="this.src='{{ asset('images/tutors/default.png') }}'">
                        <div class="profile-card__explorar">
                            <h1>Ver más tutores</h1>
                            <p>Busca tutores de acuerdo a lo que necesites aprender</p>
                            <a href="{{ route('buscar') }}">
                                <button type="button">Explorar</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.tutor-carousel__track -->
    </div><!-- /.tutor-carousel__viewport -->

    <button class="tutor-carousel__btn tutor-carousel__btn--next" type="button" aria-label="Siguiente" disabled>
        <span>&gt;</span>
    </button>
</div>

<style>
    .tutor-carousel {
        position: relative;
        width: 100%;
        max-width: 1300px;
        margin: 2rem auto;
        padding: 0 3rem;
        box-sizing: border-box;
        }

        .tutor-carousel__viewport {
        overflow: hidden;
        width: 100%;
        padding-bottom: 2rem
        }

        .tutor-carousel__track {
        display: flex;
        gap: 1.5rem;
        will-change: transform;
        transition: transform 0.5s cubic-bezier(.4,0,.2,1);
        padding: 0.5rem 0;
        }

        .tutor-carousel__slide {
        flex: 0 0 clamp(240px, 24%, 280px);
        /* Permite que en pantallas grandes quepan varias sin ser gigantes */
        display: flex;
        justify-content: center;
        }

        .tutor-carousel__btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--primary-color);
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.25rem 0.5rem;
            box-shadow: none;
            transition: transform .2s ease, opacity .2s ease;
            z-index: 5;
        }

        .tutor-carousel__btn:hover:not([disabled]) {
            transform: translateY(-50%) scale(1.08);
        }

        .tutor-carousel__btn:active:not([disabled]) {
            transform: translateY(-50%) scale(.95);
        }

        .tutor-carousel__btn[disabled] {
            opacity: .35;
            cursor: not-allowed;
        }

        .tutor-carousel__btn--prev { left: 0.75rem; }
        .tutor-carousel__btn--next { right: 0.75rem; }

        @media (max-width: 1023px) {
        .tutor-carousel {
            padding: 0 2.2rem;
        }
        .tutor-carousel__slide {
            flex: 0 0 clamp(220px, 70%, 320px);
        }
        .tutor-carousel__btn {
            font-size: 1.5rem;
            padding: 0.2rem 0.4rem;
        }
        }

        @media (max-width: 640px) {
        .tutor-carousel {
            padding: 0 1.5rem;
        }
        .tutor-carousel__btn--prev { left: .25rem; }
        .tutor-carousel__btn--next { right: .25rem; }
        .tutor-carousel__track { gap: 1rem; }
        .tutor-carousel__slide { flex: 0 0 85%; }
        }

        @media (min-width: 1400px) {
        .tutor-carousel__slide { flex: 0 0 clamp(250px, 18%, 280px); }
        }

        @media (min-width: 1500px) {
            .tutor-carousel__viewport {
                overflow: hidden;
                width: 100%;
                padding-bottom: 2rem
            }

            .tutor-carousel {
                max-width: 1293px;
            }
        }
</style>

<script>
        function initCarousel(root) {
            if (!root) return;
            const viewport = root.querySelector('.tutor-carousel__viewport');
            const track = root.querySelector('.tutor-carousel__track');
            const slides = [...track.querySelectorAll('.tutor-carousel__slide')];
            const btnPrev = root.querySelector('.tutor-carousel__btn--prev');
            const btnNext = root.querySelector('.tutor-carousel__btn--next');

            if (!viewport || !track || slides.length === 0) return;

            let currentIndex = 0;
            let slideWidth = 0;
            let gap = 0;

            function measure() {
            const slide = slides[0];
            const style = window.getComputedStyle(track);
            gap = parseFloat(style.columnGap || style.gap) || 0;
            slideWidth = slide.getBoundingClientRect().width;
            update();
            updateButtons();
            hideButtonsIfNoOverflow();
            }

            function maxIndex() {
            const viewportWidth = viewport.getBoundingClientRect().width;
            // cuántas slides caben visibles
            const visibleCount = Math.max(1, Math.floor((viewportWidth + gap) / (slideWidth + gap)));
            return Math.max(0, slides.length - visibleCount);
            }

            function clampIndex(i) {
            return Math.min(Math.max(i, 0), maxIndex());
            }

            function update() {
            const offset = -(slideWidth + gap) * currentIndex;
            track.style.transform = `translateX(${offset}px)`;
            updateButtons();
            }

            function updateButtons() {
            btnPrev.disabled = currentIndex <= 0;
            btnNext.disabled = currentIndex >= maxIndex();
            }

            function hideButtonsIfNoOverflow() {
            if (maxIndex() === 0) {
                btnPrev.style.display = 'none';
                btnNext.style.display = 'none';
            } else {
                btnPrev.style.display = '';
                btnNext.style.display = '';
            }
            }

            btnPrev.addEventListener('click', () => {
            currentIndex = clampIndex(currentIndex - 1);
            update();
            });

            btnNext.addEventListener('click', () => {
            currentIndex = clampIndex(currentIndex + 1);
            update();
            });

            // Drag / Touch
            let startX = 0;
            let lastX = 0;
            let isDragging = false;

            function onPointerDown(e) {
            isDragging = true;
            startX = e.clientX || e.touches?.[0].clientX;
            lastX = startX;
            track.style.transition = 'none';
            }

            function onPointerMove(e) {
            if (!isDragging) return;
            const x = e.clientX || e.touches?.[0].clientX;
            const delta = x - startX;
            track.style.transform = `translateX(${-(slideWidth + gap) * currentIndex + delta}px)`;
            lastX = x;
            }

            function onPointerUp() {
            if (!isDragging) return;
            isDragging = false;
            const deltaTotal = lastX - startX;
            track.style.transition = 'transform 0.5s cubic-bezier(.4,0,.2,1)';
            const threshold = slideWidth * 0.25;
            if (deltaTotal < -threshold) {
                currentIndex = clampIndex(currentIndex + 1);
            } else if (deltaTotal > threshold) {
                currentIndex = clampIndex(currentIndex - 1);
            }
            update();
            }

            track.addEventListener('mousedown', onPointerDown);
            track.addEventListener('touchstart', onPointerDown, { passive: true });
            window.addEventListener('mousemove', onPointerMove);
            window.addEventListener('touchmove', onPointerMove, { passive: true });
            window.addEventListener('mouseup', onPointerUp);
            window.addEventListener('touchend', onPointerUp);

            // Recalcular en resize
            window.addEventListener('resize', () => {
            measure();
            });

            // Integración con Livewire (si se re-renderiza el componente)
            if (window.Livewire) {
            window.Livewire.hook('message.processed', () => {
                measure();
            });
            }

            measure();
        }

        document.addEventListener('DOMContentLoaded', () => {
            document
            .querySelectorAll('.tutor-carousel[data-carousel]')
            .forEach(initCarousel);
        });
</script>