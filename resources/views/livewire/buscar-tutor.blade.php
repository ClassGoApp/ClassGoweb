    <div class="container-buscartutor">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> 
    <!-- Componente de búsqueda y listado de tutores -->
    {{-- <section class="buscartutor-search-section">
        <div class="buscartutor-search-box">
            <div class="buscartutor-search-grid">
                <div class="buscartutor-search-keyword">
                    <div class="buscartutor-search-input-wrap">
                        <!-- BUSCADOR-->
                        <!--desktop--> 
                        <div class="buscador-desktop">
                            <input type="text"
                            id="keyword-search"
                            placeholder="¿Qué necesitas aprender? Busca por nombre del tutor o materia."
                            class="buscartutor-search-input"
                            wire:model.live.debounce.500ms="search">
                            <span class="buscartutor-search-icon">
                                <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                            </span>
                        </div>
                        <!---movile-->
                        <div class="buscador-mobile">
                            <input type="text"
                            id="keyword-search"
                            placeholder="¿Qué necesitas aprender?"
                            class="buscartutor-search-input"
                            wire:model.live.debounce.500ms="search">
                            <span class="buscartutor-search-icon">
                                <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                            </span>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <div class="search-module">
        <div class="search-field__wrapper">
            <div class="search-field__icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input id="searchInput" 
            type="text" 
            placeholder="¿Qué necesitas aprender? Busca por nombre del tutor o materia."
            data-placeholder-key="tutor_live_search_placeholder"
            wire:model.live.debounce.500ms="search"
            class="search-field__input">
        </div>
    </div>

    @if (strlen($search) > 0) <!--Verifica si no hay resutados--->
    
    <section class="buscartutor-tutorlist-section">
        <div class="buscartutor-tutorlist-space">
            @forelse ($profiles as $profile)
                <div class="buscartutor-tutor-card" wire:key="tutor-{{ $profile['user_id'] }}">
                    <a href="{{ route(  'tutor', ['slug' => $profile['slug']]) }}">
                        <img 
                        src="{{ $profile['image'] ? asset('storage/' . $profile['image']) : asset('images/tutors/default.png') }}" 
                        alt="Foto de {{ $profile['full_name'] }}" 
                        class="buscartutor-tutor-img">
                    </a>
                    <div class="buscartutor-tutor-info">
                        <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}">
                            <h3 class="buscartutor-tutor-name">{{ $profile['full_name'] }}</h3>
                            <div class="desk infor-tutor card-tutor__price-duration">
                                <p class="card-tutor__price">
                                    💸 {{ $profile['price'] ?? '15.00'}} Bs.
                                    <span class="card-tutor__price-duration" data-translate="tutor_search_per_tutoring">/ tutoría</span>
                                </p>

                                <span>
                                    ⭐ {{ $profile['avg_rating'] }}/5
                                    ({{ $profile['total_reviews'] }}
                                    @if ($profile['total_reviews'] == 1)
                                        <span data-translate="review_singular">reseña</span>
                                    @else
                                        <span data-translate="review_plural">reseñas</span>
                                    @endif
                                    )
                                </span>

                                <span>
                                    🌐 <span data-translate="tutor_search_language">Idioma:</span>
                                    {{ $profile['native_language'] ?? 'N/A' }}
                                </span>
                            </div>
                            
                            <!--Solo mobile-->
                            <div class="mobile infor-tutor card-tutor__price-duration">
                                <p class="card-tutor__price">
                                    💸 {{ $profile['price'] ?? '15.00'}} Bs.
                                    <span class="card-tutor__price-duration" data-translate="tutor_search_per_tutoring">/ tutoría</span>
                                </p>

                                <span>
                                    ⭐ {{ $profile['avg_rating'] }}/5
                                    ({{ $profile['total_reviews'] }}
                                    @if ($profile['total_reviews'] == 1)
                                        <span data-translate="review_singular">reseña</span>
                                    @else
                                        <span data-translate="review_plural">reseñas</span>
                                    @endif
                                    )
                                </span>
                            </div>
                                        
                        </a>
                        <div class="buscartutor-tutor-meta">
                                <div class="tutor-subjects-display">

                                    @if (!empty($profile['matched_subjects']))
                                        
                                        <span class="subjects-matched">
                                            {{-- Muestra solo los sujetos que coincidieron con la búsqueda --}}
                                            <span data-translate="tutor_search_i_can_teach">Puedo enseñar:</span>
                                            <strong>
                                                @foreach ($profile['matched_subjects_with_id'] as $subject)
                                                    <span
                                                        class="subject-translatable"
                                                        data-subject-id="{{ $subject['id'] }}"
                                                        data-subject-fallback="{{ $subject['name'] }}"
                                                    >{{ $subject['name'] }}</span>@if (!$loop->last)<span>, </span>@endif
                                                @endforeach
                                            </strong>
                                        </span>

                                    @else
                                        {{-- Muestra TODOS los sujetos del tutor, separados por comas --}}
                                        
                                        @php
                                            // Aseguramos que 'all_subjects_with_id' sea un array
                                            $allSubjectsWithId = $profile['all_subjects_with_id'];
                                            // Separar materias según si son de Primaria/Secundaria o no
                                            $materiasPrioritarias = [];
                                            $materiasAlFinal = [];

                                            foreach ($allSubjectsWithId as $subject) {
                                                // Verificar si la materia contiene "Primaria" o "Secundaria" (case insensitive)
                                                if (stripos($subject['name'], 'Primaria') !== false || stripos($subject['name'], 'Secundaria') !== false || stripos($subject['name'], 'Básico') !== false ) {
                                                    $materiasAlFinal[] = $subject;
                                                } else {
                                                    $materiasPrioritarias[] = $subject;
                                                }
                                            }
                                            
                                            // Combinar: primero las prioritarias, luego las de Primaria/Secundaria
                                            $subjectsOrdenados = array_merge($materiasPrioritarias, $materiasAlFinal);

                                            
                                        @endphp
                                        
                                        <span class="subjects-summary">
                                            <span>
                                                <strong data-translate="tutor_search_i_can_teach">Puedo enseñar:</strong>
                                                @foreach ($subjectsOrdenados as $subject)
                                                    <span
                                                        class="subject-translatable"
                                                        data-subject-id="{{ $subject['id'] }}"
                                                        data-subject-fallback="{{ $subject['name'] }}"
                                                    >{{ $subject['name'] }}</span>@if (!$loop->last)<span>, </span>@endif
                                                @endforeach
                                            </span>
                                        </span>

                                    @endif

                                </div>
                            {{-- <span>Idioma: {{ $profile['native_language'] ?? 'N/A' }}</span> --}}
                        </div>
                        {{-- <p class="buscartutor-tutor-desc">
                            {{ $profile['description'] }}
                        </p> --}}
                    </div>
                    <div class="buscartutor-tutor-actions">
                        <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}"
                        class="buscartutor-tutor-btn buscartutor-tutor-btn-blue"
                        data-translate="view_profile">
                            Ver Perfil
                        </a>
                    </div>
                </div>
            @empty
                <div id="no-results" class="no-results-card">
                    <div class="no-results-icon-wrapper">
                        {{-- <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg> --}}
                        <img src="{{ asset('images/Tugo-rostro.png') }}" alt="">
                    </div>

                    <h2 class="no-results-title" data-translate="tutor_search_no_results_title">
                        ¡Vaya! No encontramos resultados.
                    </h2>

                    <p class="no-results-message" data-translate="tutor_search_no_results_message">
                        Pero no te preocupes, ¡estamos aquí para ayudarte! Es posible que el tutor o la materia que buscas no esté disponible, o que haya un error de escritura.
                    </p>

                    <div class="contactanos-btn">
                        <a href="https://wa.link/8f8z6i" class="no-results-contact-btn" target="_blank" data-translate="tutor_search_contact_us">
                        Contáctanos
                    </a>
                    </div>
                </div>
            @endforelse
        </div>
        

        <div class="buscartutor-pagination">
            <style>
                .buscartutor-pagination nav {
                    display: flex;
                    justify-content: center;
                    margin-top: 2rem;
                }
                
            </style>
            
            {{ $profiles->links() }}
        </div>
    </section>

    @endif

    <script>
        function tutorLiveSearchText(key, fallback = '') {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (typeof translations === 'undefined') {
                return fallback;
            }

            const t = translations[lang] || translations.es;

            return t[key] || fallback;
        }

        function applyTutorLiveSearchTranslations() {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            const input = document.querySelector('#searchInput');

            if (input) {
                input.placeholder = tutorLiveSearchText(
                    'tutor_live_search_placeholder',
                    '¿Qué necesitas aprender? Busca por nombre del tutor o materia.'
                );
            }

            if (typeof selectLanguage === 'function') {
                selectLanguage(lang, false);
            }

            if (typeof window.applySubjectTranslations === 'function') {
                window.applySubjectTranslations();
            }
        }

        document.addEventListener('DOMContentLoaded', applyTutorLiveSearchTranslations);
        document.addEventListener('livewire:navigated', applyTutorLiveSearchTranslations);

        document.addEventListener('languageChanged', () => {
            const input = document.querySelector('#searchInput');

            if (input) {
                input.placeholder = tutorLiveSearchText(
                    'tutor_live_search_placeholder',
                    '¿Qué necesitas aprender? Busca por nombre del tutor o materia.'
                );
            }
        });

        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                setTimeout(applyTutorLiveSearchTranslations, 50);
            });
        });
    </script>

</div>