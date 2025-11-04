<div class="carousel-container">
    <button id="prevBtn" class="carousel-btn prev-btn" aria-label="Anterior">&lt;</button>
    <div class="carousel-wrapper">
        <div class="carousel-track" id="carouselTrack">
            @foreach($featuredTutors as $tutor)
            <div class="tutor-card" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">
                <div class="tutor-card-content">
                    <div class="tutor-avatar-container">
                        <img src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Tutor" class="tutor-avatar">
                        <span class="tutor-status-badge">
                            <span class="tutor-status-star">
                                <svg xmlns="http://www.w3.org/2000/svg" class="star-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </span>
                        </span>
                    </div>
                    <h3 class="tutor-name">
                        {{ explode(' ', $tutor->profile->first_name)[0] }}
                        {{ explode(' ', $tutor->profile->last_name)[0] }}
                    </h3> <!--NOMBRE DEL TUTOR-->

                    @php
                    // Accede a la colección de materias del tutor.
                    $materia = 'Materias Generales'; // Valor por defecto si no hay datos
                    $subjects = $tutor->subjects;

                    // Si la colección de materias no está vacía...
                    if ($subjects->isNotEmpty()) {
                    // ...accede a la primera materia de la colección.
                    $firstSubject = $subjects->first();

                    // Si la primera materia tiene un grupo asociado...
                    if ($firstSubject->group) {
                    // ...muestra el nombre del grupo.

                    $materia = $firstSubject->group->name;
                    }
                    }
                    @endphp

                    
                    <p class="tutor-job">Tutor de {{$materia}} </p>
                    <div class="tutor-subjects">
                        @foreach ($tutor->subjects as $subject)
                        <span class="subject-tag">{{ $subject->name }}</span>
                        @endforeach
                    </div>
                    <button class="profile-btn">
                        Ver Perfil
                    </button>
                </div>
            </div>
        @endforeach
        <!--Card buscar más tutores-->
        <div class="card-buscarmas">
            <div class="icon-wrapper">
                <svg class="w-10 h-10 text-blue-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <h2 data-translate="seeks"></h2>
            <p data-translate="finds">
            </p>
            <a href="{{ route('buscar') }}" class="btn-primary">
                <span data-translate="explore"></span>
            </a>
        </div>
    </div>
</div>
<button id="nextBtn" class="carousel-btn next-btn" aria-label="Siguiente">&gt;</button>
