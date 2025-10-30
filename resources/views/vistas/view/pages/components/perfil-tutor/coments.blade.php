<div class="review-section-wrapper">   
    
    @livewire('tutor-reviews', [
        'tutor' => $tutor, 
        'reviews' => $reviews,
        'avgRating' => $avgRating ?? 0,
        'totalReviews' => $totalReviews ?? 0,
        'ratingDistribution' => $ratingDistribution ?? []
    ])

    {{-- @role('student')
        <div class="review-form-container">
            <h2 class="review-form__title">Deja tu reseña</h2>
            
            <form action="{{ route('tutor.review.store', $tutor->id) }}" method="POST" id="review-form">
                @csrf
                <input type="hidden" name="rating" id="rating-input" value="">

                <div id="star-rating" class="review-form__rating-wrapper">
                    @for($i = 1; $i <= 5; $i++)
                        <svg data-value="{{ $i }}" class="review-form__star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.0006 18.26L4.94715 22.2082L6.52248 14.2799L0.587891 8.7918L8.61493 7.84006L12.0006 0.5L15.3862 7.84006L23.4132 8.7918L17.4787 14.2799L19.054 22.2082L12.0006 18.26Z"></path>
                        </svg>
                    @endfor
                </div>

                <div class="review-form__textarea-wrapper">
                    <textarea name="comment" id="comment" rows="5" class="review-form__textarea" 
                        placeholder="Escribe tu reseña aquí (opcional)..."></textarea>
                </div>

                <div class="review-form__button-wrapper">
                    <button type="submit" class="review-form__button" id="submit-review">
                        Enviar reseña
                    </button>
                </div>
            </form>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
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
            <div class="tutor-empty-box">
                <div class="am-norecord">
                    @include('livewire.components.no-record')
                </div>
            </div>
        @endforelse
    </div> --}}

</div>