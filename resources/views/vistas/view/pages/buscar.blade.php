<!--Estilo en buscar.css-->
@extends('vistas.view.layouts.app')

@section('content')

<section class="buscar-section">
    <div class="buscar-header-content">
        <div class="container container--center">
            
            <h1 class="header-main__title" data-translate="buscar_tutor_txt1" style="color: white;">Descubre un Tutor en Línea para tus Estudios</h1>
            <p class="header-main__subtitle" data-translate="buscar_tutor_txt2" style="color: white">
                Domina cualquier materia con la ayuda de nuestros tutores expertos y alcanza tus metas académicas.
            </p>
            <livewire:buscar-tutor>
            <p class="header-main__subtitle" data-translate="buscar_tutor_txt3" style="padding-top: 1rem; color:white;" id="texto">
                ¿Que deseas aprender?
            </p>
            <div class="loading-indicator">
                <span class="loader"></span>
            </div>
            
        </div>
    </div>

    <div class="main-border" id="mainContent">
        <div class="main-content container--center" id="mainContent">
            
            <!-- Filtros de materias -->
            <div id="filterControls" class="filter-controls__list">
                <button class="filter-btn filter-btn--active" data-subject-id="all">Todos</button>
                @foreach ($topSubjects as $item)
                    <button class="filter-btn" data-subject-id="{{ $item->subject_id }}">{{ $item->subject->name }}</button>
                @endforeach
            </div>

            <!-- Wrapper con Alpine.js para manejar el estado global -->
            <div x-data="{ expandedCard: null }" id="tutorGrid" class="tutor-grid-buscar">

                @foreach ($tutors as $tutor)
                    @php
                        $materiaIds = $tutor->subjects->pluck('id')->implode(',');
                        $tutorId = $tutor->id;
                    @endphp
                    <div class="card-tutor card-tutor--interactive"
                        data-docente-id="{{ $tutor->id }}"
                        data-materias-ids="{{ $materiaIds }}">
                        
                        <!-- Vista primaria (mostrar cuando NO está expandida) -->
                        <div x-show="expandedCard !== {{ $tutorId }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="card-tutor__primary-content">
                            
                            <div class="card-tutor__content">
                                <div class="card-tutor__header">
                                    <img class="card-tutor__avatar" src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Avatar">
                                    <div>
                                        <h2 class="card-tutor__name">{{ explode(' ', $tutor->profile->first_name)[0] }}
                                            {{ explode(' ', $tutor->profile->last_name)[0] }}</h2>
                                        <p class="card-tutor__price">💸 {{  $tutor->profile->price ?? '15.00' }} Bs. <span class="card-tutor__price-duration">/ 20 min</span></p>
                                    </div>
                                </div>
                                <div class="card-tutor__tags-wrapper">
                                    <p class="card-tutor__tags">
                                        @foreach ($tutor->userSubjects as $index => $userSubject)
                                            @php
                                                $colorClass = ($index % 2 == 0) ? 'tag--blue' : 'tag--green';
                                            @endphp
                                            
                                            <span class="{{ $colorClass }}">
                                                {{ $userSubject->subject->name }}
                                            </span>
                                        @endforeach
                                    </p>
                                </div>
                                
                                <p class="card-tutor__description">{{ $tutor->profile->tagline ?? ' Tutor verificado y aprobado por ClassGo! '}}</p>
                            </div>
                            
                            <div class="card-tutor__footer">
                                <button @click="expandedCard = {{ $tutorId }}" class="card-tutor__button-materias">Ver Materias</button>
                                <button class="card-tutor__button" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">Ver Perfil</button>
                            </div>
                        </div>

                        <!-- Vista expandida (mostrar cuando SÍ está expandida) -->
                        <div x-show="expandedCard === {{ $tutorId }}"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="card-tutor__detail-panel">
                            
                            <div class="detail-panel__header">
                                <h3 class="detail-panel__title">{{ $tutor->profile->full_name }}</h3>
                                <button @click="expandedCard = null" class="detail-panel__close-btn">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <p class="detail-panel__subtitle">Todas mis materias:</p>
                            
                            <div class="detail-panel__tags-container">
                                @foreach ($tutor->userSubjects as $index => $userSubject)
                                    <span class="tag--detail">{{ $userSubject->subject->name }}</span>
                                @endforeach
                            </div>

                            <div class="rating-info-wrapper">
                                <div class="rating-info">
                                    <div class="rating-info__content">
                                        <svg class="rating-info__star" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        <span class="rating-info__text">{{ number_format($tutor->avg_rating ?? 0, 1) }} 
                                            ({{ $tutor->total_reviews }} {{ $tutor->total_reviews == 1 ? 'reseña' : 'reseñas' }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="paginacion">
                {{ $tutors->links()}}
            </div>

            <div class="cta-section-wrapper" id="cta-section">
                <div class="cta-card">
                    <div class="cta-card__content">
                        
                        <h2 class="cta-card__title">
                            Comparte tu conocimiento. Transforma el futuro.
                        </h2>
                        
                        <p class="cta-card__subtitle">
                            Ayuda a estudiantes a alcanzar sus metas, genera un ingreso extra y sé parte de esta comunidad de aprendizaje. Tu pasión por enseñar puede marcar la diferencia.
                        </p>
                        
                        <div class="cta-card__action">
                            <a href="{{ route('login', ['mode' => 'register'])}}" class="cta-card__button">
                                ¿Deseas dar tutorías?
                            </a>
                        </div>

                        <p class="cta-card__note">
                            Regístrate como tutor y comienza a enseñar
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. SELECTORES DE ELEMENTOS
        const filterButtons = document.querySelectorAll('.filter-btn'); 
        const searchInput = document.getElementById('searchInput');
        const tutorCards = document.querySelectorAll('.card-tutor');
        const menuContainer = document.getElementById('mainContent');
        const loadingIndicator = document.querySelector('.loading-indicator');
        const filtrosContainer = document.querySelector('#filterControls');
        const ctaSection = document.querySelector('#cta-section');
        const subtitleElement = document.querySelector('#texto');

        /**
         * @description Filtra los tutores basándose SOLO en el ID de materia activo (SIN búsqueda por texto).
         */
        function filterTutorsBySubject() {
            // Obtenemos el ID de la materia seleccionada
            const activeFilterButton = document.querySelector('.filter-btn--active');
            if (!activeFilterButton) return;
            
            const activeSubjectId = activeFilterButton.dataset.subjectId; 

            tutorCards.forEach(card => {
                // Obtenemos la cadena de IDs de materias del tutor (ej: "101,105,112")
                const tutorSubjectIdsString = card.dataset.materiasIds || '';

                // Lógica de Coincidencia de Materias SOLAMENTE
                let subjectMatch = false;

                if (activeSubjectId === 'all') {
                    subjectMatch = true; // Si es 'Todos', siempre coincide
                } else {
                    // Convertimos la cadena de IDs del tutor a un array y comprobamos si incluye el ID seleccionado
                    const tutorSubjectIdsArray = tutorSubjectIdsString.split(',');
                    
                    // Comprobamos si el array de materias del tutor incluye el ID del filtro
                    subjectMatch = tutorSubjectIdsArray.includes(activeSubjectId); 
                }
                
                // Mostrar u Ocultar SOLO basado en la materia
                if (subjectMatch) {
                    card.classList.remove('is-hidden');
                } else {
                    card.classList.add('is-hidden');
                }
            });
        }

        // 2. LISTENERS PARA LOS BOTONES DE FILTRO
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('filter-btn--active'));
                button.classList.add('filter-btn--active');
                filterTutorsBySubject(); // Solo filtrar por materia
            });
        });
        
        // Ejecutar el filtrado inicial al cargar la página (solo por materias)
        filterTutorsBySubject();
    });

    // MANTENER EL SCRIPT DEL PLACEHOLDER ANIMADO
    document.addEventListener('DOMContentLoaded', () => {
    const inputElement = document.getElementById('searchInput');
    if (!inputElement) return;

    const typingSpeed = 70;
    const erasingSpeed = 40;
    const newTextDelay = 500;

    let texts = getPlaceholderTexts();
    let textIndex = 0;
    let charIndex = 0;
    let animationTimeout;

    function getPlaceholderTexts(lang = localStorage.getItem("selectedLanguage") || "es") {
        const currentLang = translations[lang] ? lang : "es";

        return [
            translations[currentLang].buscar_tutor_placeholder_1,
            translations[currentLang].buscar_tutor_placeholder_2,
            translations[currentLang].buscar_tutor_placeholder_3,
        ];
    }

    function type() {
        if (charIndex < texts[textIndex].length) {
            inputElement.placeholder += texts[textIndex].charAt(charIndex);
            charIndex++;

            animationTimeout = setTimeout(type, typingSpeed);
        } else {
            animationTimeout = setTimeout(erase, newTextDelay);
        }
    }

    function erase() {
        if (charIndex > 0) {
            inputElement.placeholder = texts[textIndex].substring(0, charIndex - 1);
            charIndex--;

            animationTimeout = setTimeout(erase, erasingSpeed);
        } else {
            textIndex++;

            if (textIndex >= texts.length) {
                textIndex = 0;
            }

            animationTimeout = setTimeout(type, typingSpeed);
        }
    }

    document.addEventListener("languageChanged", (event) => {
        console.log("Placeholder recibió idioma:", event.detail.lang);
        clearTimeout(animationTimeout);

        texts = getPlaceholderTexts(event.detail.lang);
        textIndex = 0;
        charIndex = 0;
        inputElement.placeholder = "";

        animationTimeout = setTimeout(type, newTextDelay);
    });

    animationTimeout = setTimeout(type, newTextDelay);
});
</script>
@endsection