{{-- <section class="buscartutor-search-section">
    <div class="buscartutor-search-box">
        <div class="buscartutor-search-grid">
            <div class="buscartutor-search-keyword">
                <label for="keyword-search" class="sr-only" data-translate="tutor_search_keyword_label">
                    Buscar por palabra clave
                </label>

                <div class="buscartutor-search-input-wrap">
                    <input type="text" id="keyword-search"
                        placeholder="Buscar por palabra clave"
                        data-placeholder-key="tutor_search_keyword_placeholder"
                        class="buscartutor-search-input">
                    <span class="buscartutor-search-icon">
                        <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                    </span>
                </div>
            </div>
            <div class="buscartutor-search-group">
                <label for="group-select" class="sr-only" data-translate="tutor_search_subject_group_label">
                    Grupo de materias
                </label>

                <select id="group-select" class="buscartutor-search-select">
                    <option data-translate="tutor_search_choose_subject_group">Elige grupo de materias</option>
                    <option data-translate="tutor_search_exact_sciences">Ciencias Exactas</option>
                    <option data-translate="tutor_search_humanities">Humanidades</option>
                    <option data-translate="tutor_search_languages">Idiomas</option>
                </select>
            </div>
            <button class="buscartutor-search-btn" data-translate="bus">
                Buscar
            </button>
        </div>
    </div>
</section>
<section class="buscartutor-tutorlist-section">
    <div class="buscartutor-tutorlist-space">
        @foreach ($profiles as $profile)
            <div class="buscartutor-tutor-card">
                <img 
                    src="{{ $profile['image'] ? asset('storage/' . $profile['image']) : asset('images/tutors/profile.jpg') }}" 
                    alt="Foto de {{ $profile['full_name'] }}" 
                    class="buscartutor-tutor-img">
                <div class="buscartutor-tutor-info">
                    <h3 class="buscartutor-tutor-name">{{ $profile['full_name'] }}</h3>
                    <div class="buscartutor-tutor-meta">
                        <span>
                            ⭐ {{ $profile['avg_rating'] }}
                            ({{ $profile['total_reviews'] }}
                            @if ($profile['total_reviews'] == 1)
                                <span data-translate="review_singular">reseña</span>
                            @else
                                <span data-translate="review_plural">reseñas</span>
                            @endif
                            )
                        </span>
                        <span>•</span>
                        <span>
                            1 <span data-translate="tutor_search_session">Sesión</span>
                        </span>
                        <span>•</span>
                        <span>
                            <span data-translate="tutor_search_language">Idioma:</span>
                            {{ $profile['native_language'] }}
                        </span>
                    </div>
                    <p class="buscartutor-tutor-desc">
                        {{ $profile['description'] }}
                    </p>
                </div>
                <div class="buscartutor-tutor-actions">
                    <button class="buscartutor-tutor-btn buscartutor-tutor-btn-orange" data-translate="tutor_search_book_session">
                        Reservar una sesión
                    </button>

                    <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}"
                    class="buscartutor-tutor-btn buscartutor-tutor-btn-blue"
                    data-translate="view_profile">
                        Ver Perfil
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="buscartutor-pagination">
        <script>
            function tutorSearchText(key, fallback = '') {
                const lang = localStorage.getItem('selectedLanguage') || 'es';

                if (typeof translations === 'undefined') {
                    return fallback;
                }

                const t = translations[lang] || translations.es;

                return t[key] || fallback;
            }

            function applyTutorSearchTranslations() {
                const input = document.querySelector('#keyword-search');

                if (input) {
                    input.placeholder = tutorSearchText(
                        'tutor_search_keyword_placeholder',
                        'Buscar por palabra clave'
                    );
                }
            }

            document.addEventListener('DOMContentLoaded', applyTutorSearchTranslations);
            document.addEventListener('languageChanged', applyTutorSearchTranslations);
            document.addEventListener('livewire:update', applyTutorSearchTranslations);
        </script>
        <style>
            .buscartutor-pagination nav {
                display: flex;
                justify-content: center;
                margin-top: 2rem;
            }
            .buscartutor-pagination .pagination {
                display: flex;
                gap: 0.5rem;
                list-style: none;
                padding: 0;
            }
            .buscartutor-pagination .pagination li {
                display: inline-block;
            }
            .buscartutor-pagination .pagination li a,
            .buscartutor-pagination .pagination li span {
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                border: 1px solid #023047;
                color: #023047;
                background: #fff;
                font-weight: 600;
                text-decoration: none;
                transition: background 0.2s, color 0.2s;
            }
            .buscartutor-pagination .pagination li.active span,
            .buscartutor-pagination .pagination li span[aria-current="page"] {
                background: #023047;
                color: #fff;
                border-color: #023047;
            }
            .buscartutor-pagination .pagination li a:hover {
                background: #FB8500;
                color: #fff;
                border-color: #FB8500;
            }
            .buscartutor-pagination .pagination li.disabled span {
                color: #aaa;
                background: #f5f5f5;
                border-color: #eee;
            }
        </style>
        {{ $profiles->links() }}
    </div>
</section>  --}}