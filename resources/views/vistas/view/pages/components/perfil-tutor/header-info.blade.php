<div class="tutor-banner" id="tutor-banner-area">
    <video id="tutor-bg-video"
        class="tutor-banner-video"
        preload="none"
        {{-- poster="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/profile.jpg') }}" --}}
        poster="{{ asset('images/classgo/banner.jpeg')}}"
        src="{{ $tutor->profile->intro_video ? asset('storage/' . $tutor->profile->intro_video) : '' }}"
        loop
        muted
        playsinline
        style="object-fit: cover; width: 100%; height: 100%; position: absolute; left: 0; top: 0; z-index: 1;">
    </video>
    <div class="tutor-banner-overlay" id="tutor-banner-overlay" style="position: relative; z-index: 2; transition: opacity 0.3s;">
        <button id="tutor-banner-play" class="tutor-banner-play">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-banner-play-icon">
                <polygon points="5 3 19 12 5 21 5 3"></polygon>
            </svg>
        </button>
        <input id="tutor-banner-volume" type="range" min="0" max="1" step="0.01" value="0.5" style="display:none; width:100px; margin-left:20px;">
    </div>
</div>
<div class="tutor-card-main-content">
    <!-----------------Verifica Imagen por defecto------------------->
    @if($tutor->profile->image)
        <img src="{{ asset('storage/' . $tutor->profile->image) }}" alt="Foto de {{ $tutor->profile->first_name ?? '' }}" class="tutor-profile-img" style="background-color: white">
    @else
        <img src="{{ asset('images/tutors/default.png') }}" alt="Foto de {{ $tutor->profile->first_name ?? '' }}" class="tutor-profile-img" style="background-color: white">
    @endif  
    <!-------------------------------------------------------------->
    <div class="tutor-profile-info">
        <h1 class="tutor-profile-name">{{ $tutor->profile->first_name ?? '' }} {{ $tutor->profile->last_name ?? '' }}</h1>
        <div class="tutor-profile-meta">
            <div class="tutor-profile-rating">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-star-icon">
                    <path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
                <span>{{ number_format($tutor->avg_rating ?? 0, 1) }}</span>
                <span class="rating-count">({{ $tutor->total_reviews }} 
                    {{ $tutor->total_reviews == 1 ? 'reseña' : 'reseñas' }})</span>
            </div>
            <div class="tutor-profile-students">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="tutor-student-icon">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <polyline points="3 7 12 13 21 7" />
                </svg>
                <span>{{$tutor->email}}</span>
            </div>
        </div>
        
    </div>
        {{-- <p class="tutor-profile-quote">{{ $tutor->profile->description ?? '" Tutor verificado y aprobado por ClassGo!"' }}</p> --}}
    <p class="tutor-profile-quote">"{{ $tutor->profile->tagline ?? ' Tutor verificado y aprobado por Classgo! '}}"</p> <!--Frase de BD-->
</div>