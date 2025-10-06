<div class="container-buscartuto">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    
    <!-- Componente de búsqueda y listado de tutores -->
    <section class="buscartutor-search-section">
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
    </section>
    
    <section class="buscartutor-tutorlist-section">
        <div class="buscartutor-tutorlist-space">
            @forelse ($profiles as $profile)
                <div class="buscartutor-tutor-card" wire:key="tutor-{{ $profile['user_id'] }}">
                    <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}">
                        <img 
                        src="{{ $profile['image'] ? asset('storage/' . $profile['image']) : asset('images/tutors/default.png') }}" 
                        alt="Foto de {{ $profile['full_name'] }}" 
                        class="buscartutor-tutor-img">
                    </a>
                    <div class="buscartutor-tutor-info">
                        <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}"><h3 class="buscartutor-tutor-name">{{ $profile['full_name'] }}</h3></a>
                        <div class="buscartutor-tutor-meta">
                            <span>⭐ {{ $profile['avg_rating'] }}/5.0 ({{ $profile['total_reviews'] }} reseñas)</span>
                                <div class="tutor-subjects-display">
                                    
                                    @if (!empty($profile['matched_subjects']))
                                        
                                        <span class="subjects-matched">
                                            <span>•</span> <strong>{{ implode(', ', $profile['matched_subjects']) }}</strong>
                                        </span>

                                    @else
                                        @php
                                            $subjects = collect($profile['all_subjects']);
                                            $firstTwo = $subjects->take(2)->implode(', ');
                                            $moreCount = $subjects->count() > 2 ? $subjects->count() - 2 : 0;
                                        @endphp
                                        
                                        <span class="subjects-summary">
                                            <span>• </span>{{ $firstTwo }}
                                            @if ($moreCount > 0)
                                                <span class="more-subjects">+{{ $moreCount }} más</span>
                                            @endif
                                        </span>

                                    @endif

                                </div>
                            {{-- <span>Idioma: {{ $profile['native_language'] ?? 'N/A' }}</span> --}}
                        </div>
                        <p class="buscartutor-tutor-desc">
                            {{ $profile['description'] }}
                        </p>
                    </div>
                    <div class="buscartutor-tutor-actions">
                        <a href="{{ route('tutor', ['slug' => $profile['slug']]) }}" class="buscartutor-tutor-btn buscartutor-tutor-btn-blue">
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

                    <h2 class="no-results-title">
                        ¡Vaya! No encontramos resultados.
                    </h2>
                    <p class="no-results-message">
                        Pero no te preocupes, ¡estamos aquí para ayudarte! Es posible que el tutor o la materia que buscas no esté disponible, o que haya un error de escritura.
                    </p>

                    <div class="no-results-suggestions-box">
                        <h3 class="no-results-suggestions-title">¿Qué puedes hacer?</h3>
                        <ul class="no-results-suggestions-list">
                            <li class="no-results-suggestion-item">
                                <span class="no-results-check-icon">✓</span>
                                <strong>Revisa si escribiste bien&nbsp;</strong> el nombre.
                            </li>
                            <li class="no-results-suggestion-item">
                                <span class="no-results-check-icon">✓</span>
                                    Prueba con una materia similar o &nbsp;<strong>más general</strong>.
                            </li>
                            <li class="no-results-suggestion-item">
                                <span class="no-results-check-icon">✓</span>
                                <strong>¡Ponte en contacto con nosotros!&nbsp;</strong> Dinos, necesitas alguna materia en específica?
                            </li>
                        </ul>
                    </div>

                    <a href="https://wa.link/8f8z6i" class="no-results-contact-btn" target="_blank">
                        Contáctanos
                    </a>
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
    </section>
</div>