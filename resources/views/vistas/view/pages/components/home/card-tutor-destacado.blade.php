
<div class="cards-container-tutores">
    @foreach($featuredTutors as $tutor)
        <div class="profile-card">
            <div class="profile-card__image-container">
                <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" 
                    alt="Tutor" 
                    class="profile-card__image"
                    onerror="this.src= {{ asset('images/tutors/default.png') }}"
                >
            </div>

            <div class="profile-card__content">
                
                <div class="profile-card__header">
                    <h2 class="profile-card__name">
                        {{ explode(' ', $tutor->profile->first_name)[0] }}
                        {{ explode(' ', $tutor->profile->last_name)[0] }}
                    </h2>
                    <svg class="profile-card__verified-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>

                <p class="profile-card__description">
                    {{ $tutor->profile->tagline ?? ' Tutor verificado y aprobado por Classgo! '}} 
                </p>

                <div class="profile-card__footer">
                    
                    <div class="profile-card__stats-group">
                        
                        <span class="profile-card__stat">
                            <svg class="profile-card__stat-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            {{  number_format($tutor->avg_rating,1) }}
                        </span>
                        
                        <span class="profile-card__stat">
                            <svg class="profile-card__stat-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            {{ $tutor->subjects_count }} Materias
                        </span>
                    </div>

                    <button class="profile-card__button" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                        Ver Perfil
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <div class="profile-card">
        <div class="profile-card__image-container2">
            <img src="{{ asset('images/home/models/img4.webp') }}" 
                alt="Tutor" 
                class="profile-card__image"
                onerror="this.src= {{ asset('images/tutors/default.png') }}"
            >
            <div class="profile-card__explorar">
                <h1>Ver más tutores</h1>
                <p>Busca tutores deacuerdo a lo que necesites aprender</p>
                <a href="{{ route('buscar') }}"><button>Explorar</button></a>
            </div>
            
        </div>

    </div>
</div>
