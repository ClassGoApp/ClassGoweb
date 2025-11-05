<div class="tutor-reviews-box">
    
    <div class="tutor-reviews-summary">
        <div class="tutor-reviews-score" style="font-size:2.5rem;">{{ $avgRating }}</div>
        <div class="tutor-reviews-stars" style="margin:1rem 0;">
            @for($i = 0; $i < 5; $i++)
                <svg class="tutor-star-icon" width="24" height="24" fill="{{ $i < floor($avgRating) ? '#FB8500' : '#ccc' }}" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            @endfor
        </div>
        <div class="tutor-reviews-count" style="color:#888;">Basado en {{ $totalReviews }} calificaciones</div>
    </div>

    <!-- Detalle de barras -->
    <div class="tutor-reviews-details" style="width:67%;">
        @foreach($ratingDistribution as $stars => $count)
        <div class="tutor-review-bar-row" style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.5rem;">
            <span style="color:#888;">{{ $stars }}</span>
            <svg class="tutor-star-icon" width="18" height="18" fill="#FB8500" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <div class="tutor-review-bar-bg" style="flex:1;background:#e0e0e0;border-radius:1rem;height:8px;">
                <div class="tutor-review-bar-fill" style="background:#FB8500;height:8px;border-radius:1rem;width:{{ $totalReviews > 0 ? ($count/$totalReviews*100) : 0 }}%;"></div>
            </div>
            <span style="color:#888;font-weight:600;">{{ $count }}</span>
        </div>
        @endforeach
    </div>
</div>