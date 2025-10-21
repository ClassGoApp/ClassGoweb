@extends('vistas.view.layouts.app')

@section('content')

<section class="buscar-section">
    <div class="buscar-header-content">
        <div class="container container--center">
            
            <h1 class="header-main__title">Descubre un Tutor en Línea para tus Estudios</h1>
            <p class="header-main__subtitle">
                Domina cualquier materia con la ayuda de nuestros tutores expertos y alcanza tus metas académicas.
            </p>
            <livewire:buscar-tutor>
            <p class="header-main__subtitle" id="texto">
                ¿Que deseas aprender?
            </p>
            <div class="loading-indicator">
                <span class="loader"></span>
            </div>
            
        </div>
    </div>

    <div class="main-border" id="mainContent">
        <div class="main-content container--center" id="mainContent">

            {{-- <div class="course-grid">
                @foreach ($topSubjects as $item)
                    <div class="card-filtro">
                        <div class="card-filtro__image-container">
                            <img src="{{ asset('images/filtros/contabilidadFiltro.png') }}" alt="Ilustración de Contabilidad" class="card-filtro__image">
                        </div>
                        <div class="card-filtro__content">
                            <h3 class="card-filtro__title">{{ $item->subject->name }}</h3>
                        </div>
                    </div>
                @endforeach
            
            </div> --}}
            
            <!-- Filtros de materias -->
            <div id="filterControls" class="filter-controls__list">
                <button class="filter-btn filter-btn--active" data-subject-id="all">Todos</button>
                @foreach ($topSubjects as $item)
                    <button class="filter-btn" data-subject-id="{{ $item->subject_id }}">{{ $item->subject->name }}</button>
                @endforeach
            </div>

            <div id="tutorGrid" class="tutor-grid-buscar">

                @foreach ($tutors as $tutor)
                    @php
                        // Esto crea una cadena de IDs como: "101,105,112"
                        $materiaIds = $tutor->subjects->pluck('id')->implode(',');
                    @endphp
                    <div x-data="{ expanded: false }" class="card-tutor card-tutor--interactive"
                        data-docente-id="{{ $tutor->id }}"
                        data-materias-ids="{{ $materiaIds }}" {{-- CLAVE PARA JS --}}>
                        <div x-show="!expanded"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            class="card-tutor__primary-content">
                            
                            <div class="card-tutor__content">
                                <div class="card-tutor__header">
                                    <img class="card-tutor__avatar" src="{{ $tutor->profile->image ? asset('storage/' . $tutor->profile->image) : asset('images/tutors/default.png') }}" alt="Avatar">
                                    <div>
                                        <h2 class="card-tutor__name">{{ explode(' ', $tutor->profile->first_name)[0] }}
                                            {{ explode(' ', $tutor->profile->last_name)[0] }}</h2>
                                            <!-- Aquí extreaeremos el precio de la base de datos -->
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
                                    <button @click="expanded = true" class="tags-more-btn">+Más</button>
                                </div>
                                
                                <p class="card-tutor__description">{{ $tutor->profile->tagline ?? ' Tutor verificado y aprobado por Classgo! '}}</p>
                            </div>
                            
                            <div class="card-tutor__footer">
                                <button class="card-tutor__button" onclick="window.location.href='{{ route('tutor', ['slug' => $tutor->profile['slug']]) }}'">Ver Perfil</button>
                            </div>
                        </div>

                        <div x-show="expanded"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="card-tutor__detail-panel">
                            
                            <div class="detail-panel__header">
                                <h3 class="detail-panel__title">{{ $tutor->profile->full_name }}</h3>
                                <button @click="expanded = false" class="detail-panel__close-btn">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <p class="detail-panel__subtitle">Todas mis materias:</p>
                            
                            <div class="detail-panel__tags-container">
                                @foreach ($tutor->userSubjects as $index => $userSubject)
                                    <span class="tag--detail">{{ $userSubject->subject->name }}</span>
                                @endforeach
                            </div>
                            
                            {{-- <div class="detail-panel__footer">
                                <div class="detail-panel__review-box">
                                    <div class="detail-panel__review-content">
                                        <svg class="w-5 h-5 star-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span>5.0 (15 reseñas)</span>
                                    </div>
                                </div>
                            </div> --}}
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
                            <a href="{{ route('register') }}" class="cta-card__button">
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
        // Cambiamos a data-subject-id para mayor claridad, pero mantenemos filter-btn
        const filterButtons = document.querySelectorAll('.filter-btn'); 
        const searchInput = document.getElementById('searchInput');
        const tutorCards = document.querySelectorAll('.card-tutor');
        const menuContainer = document.getElementById('mainContent');
        const loadingIndicator = document.querySelector('.loading-indicator');
        const filtrosContainer = document.querySelector('#filterControls');
        const ctaSection = document.querySelector('#cta-section');
        const subtitleElement = document.querySelector('#texto');

        /**
         * @description Filtra y busca los tutores basándose en el ID de materia activo y el término de búsqueda.
         */

        function filterAndSearchTutors() {
            // Obtenemos el ID de la materia seleccionada
            const activeFilterButton = document.querySelector('.filter-btn--active');
            if (!activeFilterButton) return;
            
            // Usamos el nuevo atributo que definimos en los botones
            const activeSubjectId = activeFilterButton.dataset.subjectId; 
            
            const searchTerm = searchInput.value.toLowerCase().trim();

            if(searchTerm){
                loadingIndicator.style.display = 'flex';
                menuContainer.style.display = 'none';
                filtrosContainer.style.display = 'none';
                subtitleElement.textContent = 'Buscando...'
                
                setTimeout(() => {
                    loadingIndicator.style.display = 'none';
                    subtitleElement.style.display= 'none';
                }, "1500");
                 
            }
            else{
                menuContainer.style.display = 'block';
                filtrosContainer.style.display = 'flex';
                subtitleElement.style.display= 'block';
                subtitleElement.textContent = '¿Qué deseas aprender?'
                tutorCards.forEach(card => {
                    // Obtenemos la cadena de IDs de materias del tutor (ej: "101,105,112")
                    const tutorSubjectIdsString = card.dataset.materiasIds || '';
                    // Obtenemos el texto de la tarjeta para la búsqueda por nombre
                    const cardText = card.textContent.toLowerCase();

                    // Lógica de Coincidencia de Materias
                    let subjectMatch = false;

                    if (activeSubjectId === 'all') {
                        subjectMatch = true; // Si es 'Todos', siempre coincide
                    } else {
                        // Convertimos la cadena de IDs del tutor a un array y comprobamos si incluye el ID seleccionado
                        const tutorSubjectIdsArray = tutorSubjectIdsString.split(',');
                        
                        // Comprobamos si el array de materias del tutor incluye el ID del filtro
                        subjectMatch = tutorSubjectIdsArray.includes(activeSubjectId); 
                    }
                    
                    // Lógica de Coincidencia de Búsqueda
                    const searchMatch = searchTerm === '' || cardText.includes(searchTerm);

                    // Mostrar u Ocultar
                    if (subjectMatch && searchMatch) {
                        card.classList.remove('is-hidden');
                    } else {
                        card.classList.add('is-hidden');
                    }
                });
            }
        }
        

        // 2. LISTENERS PARA LOS BOTONES DE FILTRO
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('filter-btn--active'));
                button.classList.add('filter-btn--active');
                filterAndSearchTutors();
            });
        });

        // 3. LISTENER PARA LA BARRA DE BÚSQUEDA
        searchInput.addEventListener('keyup', filterAndSearchTutors);
        
        // Ejecutar el filtrado inicial al cargar la página
        filterAndSearchTutors();
    });

    document.addEventListener('DOMContentLoaded', () => {
        // 1. CONFIGURACIÓN
        const inputElement = document.getElementById('searchInput'); // Asegúrate de que este ID sea correcto
        if (!inputElement) return; // Salir si no se encuentra el input

        const texts = [
            "Busca por nombre del tutor: Gariel Alpiry...",
            "Busca por materia: Matemáticas, Contabilidad...",
            "Buscar por temas: Álgebra, Cálculo..."
            ,
        ];

        const typingSpeed = 70;    // Velocidad de escritura (milisegundos por letra)
        const erasingSpeed = 40;    // Velocidad de borrado
        const newTextDelay = 500;  // Pausa antes de empezar a escribir el siguiente texto (en milisegundos)
        
        let textIndex = 0;
        let charIndex = 0;

        // 2. FUNCIÓN PRINCIPAL DE ESCRITURA
        function type() {
            // Si no se ha terminado de escribir el texto actual
            if (charIndex < texts[textIndex].length) {
                // Añadir la siguiente letra al placeholder
                inputElement.placeholder += texts[textIndex].charAt(charIndex);
                charIndex++;
                setTimeout(type, typingSpeed);
            } else {
                // Pausa antes de empezar a borrar
                setTimeout(erase, newTextDelay);
            }
        }

        // 3. FUNCIÓN DE BORRADO
        function erase() {
            // Si aún quedan letras
            if (charIndex > 0) {
                // Quitar la última letra del placeholder
                inputElement.placeholder = texts[textIndex].substring(0, charIndex - 1);
                charIndex--;
                setTimeout(erase, erasingSpeed);
            } else {
                // Pasar al siguiente texto
                textIndex++;
                if (textIndex >= texts.length) {
                    textIndex = 0; // Volver al inicio del array
                }
                // Empezar a escribir el nuevo texto
                setTimeout(type, typingSpeed);
            }
        }

        // 4. INICIO DEL EFECTO
        // Iniciar el ciclo llamando a la función 'type'
        setTimeout(type, newTextDelay); 
    });
        
    </script>
@endsection