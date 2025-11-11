<div>
    <div class="tutor-reviews-box">
        <div class="tutor-reviews-summary">
            <!-- ✨ Estas variables se actualizarán automáticamente -->
            <div class="tutor-reviews-score" style="font-size:3rem;">{{ number_format($averageRating, 1) }}</div>
            <div class="tutor-reviews-stars" style="margin:1rem 0;">
                @for($i = 0; $i < 5; $i++)
                    <svg class="tutor-star-icon" width="24" height="24" fill="{{ $i < floor($averageRating) ? '#FB8500' : '#ccc' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                @endfor
            </div>
            <div class="tutor-reviews-count" style="color:#888;">
                Basado en {{ $totalReviews }} {{ $totalReviews == 1 ? 'calificación' : 'calificaciones' }}
            </div>
        </div>

        <!-- ✨ Las barras también se actualizarán automáticamente -->
        <div class="tutor-reviews-details" style="width:67%;">
            @foreach($ratingDistribution as $stars => $count)
            <div class="tutor-review-bar-row" style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
                <span style="color:#888;">{{ $stars }}</span>
                <svg class="tutor-star-icon" width="18" height="18" fill="#FB8500" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <div class="tutor-review-bar-bg" style="flex:1;background:#e0e0e0;border-radius:1rem;height:8px;">
                    <div 
                        class="tutor-review-bar-fill" 
                        style="background:#FB8500;height:8px;border-radius:1rem;width:{{ $totalReviews > 0 ? ($count/$totalReviews*100) : 0 }}%;transition:width 0.3s ease;"
                    ></div>
                </div>
                <span style="color:#888;font-weight:600;">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    @if($reviews->isEmpty())
        @include('vistas.view.pages.components.alerts.no-coments')
    @endif

    
    <div class="review-section-wrapper">                       
        @role('student')
            @if($canReview)
                <div class="review-form-container">
                    <h2 class="review-form__title">Deja tu reseña</h2>
                    
                    <form wire:submit="submitReview" id="review-form">
                        <div id="star-rating" class="review-form__rating-wrapper">
                            @for($i = 1; $i <= 5; $i++)
                                <svg 
                                    wire:click="selectRating({{ $i }})" 
                                    class="review-form__star {{ $rating >= $i ? 'active' : '' }}" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    viewBox="0 0 24 24" 
                                    fill="currentColor"
                                    data-rating="{{ $i }}"
                                >
                                    <path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path>
                                </svg>
                            @endfor
                        </div>
                        @error('rating') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror

                        <div class="review-form__textarea-wrapper">
                            <textarea 
                                wire:model="comment" 
                                rows="5" 
                                class="review-form__textarea" 
                                placeholder="Escribe tu reseña aquí (opcional)..."
                            ></textarea>
                        </div>
                        @error('comment') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror

                        <div class="review-form__button-wrapper">
                            <button 
                                type="submit" 
                                class="review-form__button"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                            >
                                <span wire:loading.remove>Enviar reseña</span>
                                <span wire:loading>Enviando...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="alert alert-info">
                    @include('vistas.view.pages.components.alerts.alert-coments')
                </div>
            @endif
        @endrole

        <!-- Lista de reseñas -->
        <div class="review-list">
            @forelse($reviews as $review)
                <article class="review-card">
                    <div class="review-card__header">
                        <div class="review-card__user-info">
                            @if($review['reviewer']['image'])
                                <img src="{{ asset('storage/' . $review['reviewer']['image']) }}" alt="Avatar de {{ $review['reviewer']['name'] }}" class="review-card__avatar">
                            @else
                                <img src="{{ asset('images/tutors/default.png') }}" class="review-card__avatar">
                            @endif

                            <div class="review-card__meta">
                                <p class="review-card__name">{{ $review['reviewer']['name'] }}</p>
                                <p class="review-card__date">{{ $review['created_at']->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="review-card__rating">
                            <span class="review-card__score">{{ number_format($review['rating'], 1) }}</span>
                            <svg class="review-card__star-icon--filled" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="review-card__text">"{{ $review['comment'] }}"</p>
                </article>
            @empty
            @endforelse
        </div>
    </div>

    @push('styles')
    <style>
    /* Estilos base para las estrellas */
    .review-form__star {
        color: #d1d5db;
        fill: #d1d5db;
        transition: color 0.2s ease, fill 0.2s ease;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .review-form__star.active,
    .review-form__star:hover {
        color: #fbbf24 !important;
        fill: #fbbf24 !important;
    }

    /* Estilos específicos para móvil */
    @media (max-width: 768px) {
        .review-form__star {
            width: 2.5rem !important;
            height: 2.5rem !important;
            touch-action: manipulation;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        .review-form__star.active {
            color: #fbbf24 !important;
            fill: #fbbf24 !important;
        }
        
        /* Desactivar hover en dispositivos táctiles */
        @media (hover: none) and (pointer: coarse) {
            .review-form__star:hover {
                color: inherit;
                fill: inherit;
            }
            
            .review-form__star.active:hover {
                color: #fbbf24 !important;
                fill: #fbbf24 !important;
            }
        }
    }

    /* Mejorar el espaciado en móvil */
    @media (max-width: 600px) {
        .review-form__rating-wrapper {
            padding: 1rem 0;
            gap: 0.5rem;
            justify-content: center;
        }
    }

    .alert-success-container {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tutor-review-bar-fill {
        transition: width 0.3s ease;
    }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            // Escuchar el evento para ocultar la alerta
            Livewire.on('hide-alert-after', (event) => {
                setTimeout(() => {
                    @this.call('hideAlert');
                }, event.delay || 5000);
            });

            // Funcionalidad adicional para las estrellas en móvil
            const stars = document.querySelectorAll('.review-form__star');
            stars.forEach((star, index) => {
                star.addEventListener('touchstart', function(e) {
                    e.preventDefault();
                    // Remover clase active de todas las estrellas
                    stars.forEach(s => s.classList.remove('active'));
                    // Agregar clase active hasta la estrella tocada
                    for(let i = 0; i <= index; i++) {
                        stars[i].classList.add('active');
                    }
                });
            });
        });
    </script>
    @endpush
</div>