@extends('vistas.view.layouts.app')

@section('content')
{{-- tutor-perfil.css --}}
<div class="tutor-bg">
    <!-- Contenido Principal -->
    <main class="tutor-main">
        <!-- Breadcrumbs -->
        <div class="tutor-breadcrumbs">
            <a href="#" class="tutor-breadcrumb-link" data-translate="tutor_profile_breadcrumb_tutors">
                Tutores
            </a> / 

            <a href="{{ route('buscar')}}" class="tutor-breadcrumb-link" data-translate="tutor_profile_breadcrumb_find_tutor">
                Encontrar tutor
            </a> / 
            <span class="tutor-breadcrumb-current">{{ $tutor->profile->first_name ?? '' }} {{ $tutor->profile->last_name ?? '' }}</span>
        </div>

        <div class="tutor-grid">
            
            <!-- Columna Izquierda (Información del Tutor) -->
            <div class="tutor-col tutor-col-main">
                @include('vistas.view.pages.components.perfil-tutor.info-tutor', [
                    'tutor' => $tutor,
                    'reviews' => $reviews,
                    'avgRating' => $avgRating,
                    'totalReviews' => $totalReviews,
                    'ratingDistribution' => $ratingDistribution,
                    'reservas' => $reservas
                ])
            </div>

            <!-- Columna Derecha (Acciones) -->
            <div class="tutor-col tutor-col-actions">
                @include('vistas.view.pages.components.perfil-tutor.actions', [
                    'tutor' => $tutor
                ])
            </div>
        </div>

    </main>

    <!-- Modal Compartir -->
    <div id="modal-share-profile" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:9999;align-items:center;justify-content:center;">
        @include('vistas.view.pages.modals.modal-compartir')
    </div>

    <!-- Modal Reserva (incluido, oculto hasta abrir) -->
    @include('vistas.view.pages.modals.modal-reserva.content')

    <script>
        function tutorProfileText(key, fallback = '') {
            const lang = localStorage.getItem('selectedLanguage') || 'es';

            if (typeof translations === 'undefined') {
                return fallback;
            }

            const t = translations[lang] || translations.es;

            return t[key] || fallback;
        }

        function applyTutorProfileDynamicTranslations() {
            const favoriteBtn = document.getElementById('favorite-btn-blue');
            const textFavorito = document.getElementById('text-favorito');

            if (favoriteBtn && textFavorito) {
                const isFavorited = favoriteBtn.classList.contains('is-favorited-blue');

                textFavorito.textContent = isFavorited
                    ? tutorProfileText('tutor_profile_in_favorites', 'En tus Favoritos')
                    : tutorProfileText('tutor_profile_add_favorites', 'Añadir a Favoritos');
            }
        }

        document.addEventListener('languageChanged', applyTutorProfileDynamicTranslations);
        //Para los botones de favoritos
        document.addEventListener('DOMContentLoaded', () => {
            const favoriteBtn = document.getElementById('favorite-btn-blue');
            const localStorageKey = 'isFavoriteBlue'; // Clave para el almacenamiento local
            const textFavorito = document.getElementById('text-favorito');
            const estiloFavorito = document.querySelector('.tutor-btn-reservar');

            if (favoriteBtn) {
                // Cargar el estado guardado al iniciar
                const isFavorited = localStorage.getItem(localStorageKey) === 'true';
                if (isFavorited) {
                    favoriteBtn.classList.add('is-favorited-blue');
                }

                applyTutorProfileDynamicTranslations();

                favoriteBtn.addEventListener('click', () => {
                    const newFavoriteState = favoriteBtn.classList.toggle('is-favorited-blue');

                    localStorage.setItem(localStorageKey, newFavoriteState);

                    console.log(estiloFavorito);

                    if (newFavoriteState) {
                        textFavorito.textContent = tutorProfileText(
                            'tutor_profile_in_favorites',
                            'En tus Favoritos'
                        );
                    } else {
                        console.log('Botón con corazón azul desactivado.');
                        textFavorito.textContent = tutorProfileText(
                            'tutor_profile_add_favorites',
                            'Añadir a Favoritos'
                        );
                    }
                });
            }
        });
        // --- SCRIPT PARA PESTAÑAS ---
        
        function changeTab(event, tabID) {
            let tabContents = document.querySelectorAll('.tutor-tab-content');
            tabContents.forEach(content => content.classList.add('hidden'));
            let tabButtons = document.querySelectorAll('.tutor-tab-btn');
            tabButtons.forEach(button => button.classList.remove('active'));
            document.getElementById(tabID).classList.remove('hidden');
            event.currentTarget.classList.add('active');
        }
        function changeSubTab(event, tabID) {
            let subTabContents = document.querySelectorAll('.tutor-subtab-content');
            subTabContents.forEach(content => content.classList.add('hidden'));
            let subTabButtons = document.querySelectorAll('.tutor-subtab-btn');
            subTabButtons.forEach(button => button.classList.remove('active'));
            document.getElementById(tabID).classList.remove('hidden');
            event.currentTarget.classList.add('active');
        }

        function goToTab(tabID) {
            // 1. Encontrar el botón de la pestaña con el tabID correspondiente.
            const targetButton = document.querySelector(`.tutor-tab-btn[onclick*="'${tabID}'"]`);

            // 2. Si el botón existe, simular un clic en él.
            if (targetButton) {
                targetButton.click();
            }
        }
        // --- SCRIPT PARA CALENDARIO Y HORA ---
        document.addEventListener('DOMContentLoaded', function() {
            const calendarGrid = document.getElementById('calendar-grid');
            const timeSelectorColumn = document.getElementById('time-selector-column');
            const timeSlotsContainer = document.getElementById('time-slots');
            if (!calendarGrid) return; // Salir si no estamos en la página correcta
            const month = 6; // Julio (0-indexed)
            const year = 2025;
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startingDay = (firstDay === 0) ? 6 : firstDay - 1; 
            for (let i = 0; i < startingDay; i++) {
                calendarGrid.appendChild(document.createElement('div'));
            }
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('button');
                dayCell.textContent = day;
                dayCell.classList.add('tutor-calendar-day');
                dayCell.dataset.day = day;
                dayCell.onclick = selectDate;
                calendarGrid.appendChild(dayCell);
            }
            const exampleTimes = ['16:00', '16:20', '16:40', '17:00', '17:20', '17:40', '18:00', '18:20', '19:00', '19:20', '19:40'];
            timeSlotsContainer.innerHTML = '';
            exampleTimes.forEach(time => {
                const timeButton = document.createElement('button');
                timeButton.textContent = time;
                timeButton.classList.add('tutor-time-slot');
                timeButton.onclick = selectTime;
                timeSlotsContainer.appendChild(timeButton);
            });
        });
        function selectDate(event) {
            const allDays = document.querySelectorAll('.tutor-calendar-day');
            allDays.forEach(d => d.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById('time-selector-column').classList.remove('hidden');
        }
        function selectTime(event) {
            const allTimes = document.querySelectorAll('.tutor-time-slot');
            allTimes.forEach(t => t.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('tutor-bg-video');
            const playBtn = document.getElementById('tutor-banner-play');
            const volumeSlider = document.getElementById('tutor-banner-volume');
            const overlay = document.getElementById('tutor-banner-overlay');
            const bannerArea = document.getElementById('tutor-banner-area');
            let isPlaying = false;
            let overlayTimeout = null;

            function showOverlay() {
                overlay.style.opacity = 1;
                overlay.style.pointerEvents = 'auto';
                if (overlayTimeout) clearTimeout(overlayTimeout);
            }
            function hideOverlay() {
                overlay.style.opacity = 0;
                overlay.style.pointerEvents = 'none';
            }

            // Mostrar controles al pasar el mouse o hacer click
            bannerArea.addEventListener('mouseenter', showOverlay);
            bannerArea.addEventListener('mousemove', showOverlay);
            bannerArea.addEventListener('mouseleave', function() {
                if (isPlaying) {
                    overlayTimeout = setTimeout(hideOverlay, 500); // espera breve para evitar parpadeo
                }
            });
            bannerArea.addEventListener('click', function() {
                showOverlay();
                if (isPlaying) {
                    overlayTimeout = setTimeout(hideOverlay, 2000); // oculta después de 2s si está reproduciendo
                }
            });

            playBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!video.src) return;
                if (video.paused) {
                    video.muted = false;
                    video.play();
                    isPlaying = true;
                    playBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-banner-play-icon">
                            <rect x="6" y="4" width="4" height="16"></rect>
                            <rect x="14" y="4" width="4" height="16"></rect>
                        </svg>
                    `;
                    volumeSlider.style.display = 'inline-block';
                    overlayTimeout = setTimeout(hideOverlay, 2000);
                } else {
                    video.pause();
                    isPlaying = false;
                    playBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-banner-play-icon">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                    `;
                    volumeSlider.style.display = 'none';
                    showOverlay();
                }
            });

            // Volumen
            volumeSlider.addEventListener('input', function(e) {
                video.volume = this.value;
                e.stopPropagation();
            });

            // Al pausar el video manualmente (por el usuario)
            video.addEventListener('pause', function() {
                isPlaying = false;
                playBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-banner-play-icon">
                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                    </svg>
                `;
                volumeSlider.style.display = 'none';
                showOverlay();
            });

            // Inicialmente mostrar controles
            showOverlay();
        });

        // ================ Modal para compartir perfil ======================
        document.addEventListener('DOMContentLoaded', function() {
            const btnShare = document.getElementById('btn-share-profile');
            const modalShare = document.getElementById('modal-share-profile');
            const closeModal = document.getElementById('close-modal-share');
            const btnWhatsapp = document.getElementById('btn-share-whatsapp');
            const btnFacebook = document.getElementById('btn-share-facebook');
            const slug = @json($tutor->profile->slug ?? '');
            const shareUrl = `https://classgoapp.com/tutores/${slug}`;
            function getTutorShareMessage() {
                return tutorProfileText(
                    'share_modal_description',
                    'Echa un vistazo a mi perfil en ClassGo!'
                );
            }

            btnShare.addEventListener('click', function() {
                modalShare.style.display = 'flex';
            });
            closeModal.addEventListener('click', function() {
                modalShare.style.display = 'none';
            });
            // WhatsApp
            btnWhatsapp.addEventListener('click', function() {
                const shareMsg = getTutorShareMessage();
                const url = `https://wa.me/?text=${encodeURIComponent(shareMsg + ' ' + shareUrl)}`;
                window.open(url, '_blank');
            });
            // Facebook
            btnFacebook.addEventListener('click', function() {
                const shareMsg = getTutorShareMessage();
                const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&quote=${encodeURIComponent(shareMsg)}`;
                window.open(url, '_blank');
            });
        });

    let lastScroll = 0;
    const actionBar = document.querySelector('.tutor-col-actions');

    window.addEventListener('scroll', () => {
        if (!actionBar) return;
        if (window.innerWidth > 768) {
            actionBar.classList.remove('hidden');
            return;
        }
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        if (currentScroll > lastScroll) {
            // Scroll hacia abajo → mostrar barra en móvil
            actionBar.classList.remove('hidden');
        } else {
            // Scroll hacia arriba → ocultar barra en móvil
            actionBar.classList.add('hidden');
        }
        lastScroll = currentScroll <= 0 ? 0 : currentScroll; // Evita valores negativos
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && actionBar) {
            actionBar.classList.remove('hidden');
        }
    });



    </script>

    <!-- Modal Tutoría al instante -->
    <div id="instant-tutor-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.6);z-index:10000;align-items:center;justify-content:center;padding:1rem;">
        <div style="background:white;border-radius:1.5rem;max-width:420px;width:100%;max-height:90vh;overflow-y:auto;position:relative;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <button onclick="closeInstantTutorModal()" style="position:absolute;top:1rem;right:1rem;background:#f1f5f9;border:none;border-radius:50%;width:32px;height:32px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <div style="padding:2rem;">
                <div style="text-align:center;margin-bottom:1.5rem;">
                    <div style="width:60px;height:60px;background:linear-gradient(135deg,#FB8500 0%,#FF6B00 100%);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </div>
                    <h2 style="font-size:1.5rem;font-weight:800;color:#023047;margin-bottom:0.5rem;" data-translate="instant_tutor_direct_title">Tutoría al instante</h2>
                    <p style="color:#64748b;font-size:0.9rem;" data-translate="instant_tutor_direct_desc">Elige la materia y solicita al instante a {{ $tutor->profile->first_name ?? '' }}</p>
                </div>
                
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;font-weight:600;color:#023047;margin-bottom:0.75rem;font-size:0.9rem;" data-translate="instant_tutor_select_subject">Selecciona una materia</label>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;max-height:250px;overflow-y:auto;">
                        @if($tutor->userSubjects && $tutor->userSubjects->count() > 0)
                            @foreach($tutor->userSubjects as $userSubject)
                                @if($userSubject->subject)
                                    <button type="button" onclick="selectInstantSubject({{ $userSubject->subject->id }}, '{{ addslashes($userSubject->subject->name) }}')" class="instant-subject-btn" style="padding:0.75rem 1rem;border:2px solid #e2e8f0;border-radius:0.75rem;background:white;text-align:left;cursor:pointer;transition:all 0.2s;font-weight:500;color:#023047;">
                                        {{ $userSubject->subject->name }}
                                    </button>
                                @endif
                            @endforeach
                        @else
                            <p style="color:#64748b;text-align:center;padding:1rem;" data-translate="instant_tutor_no_subjects">Este tutor no tiene materias asignadas</p>
                        @endif
                    </div>
                </div>
                
                <div id="instant-tutor-confirm" style="display:none;">
                    <div style="background:#f8fafc;padding:1rem;border-radius:0.75rem;margin-bottom:1rem;">
                        <p style="font-size:0.875rem;color:#64748b;margin-bottom:0.25rem;" data-translate="instant_tutor_selected_subject">Materia seleccionada:</p>
                        <p id="instant-selected-subject-name" style="font-weight:600;color:#023047;"></p>
                    </div>
                    <button onclick="startDirectInstantTutoring()" id="btn-start-instant" style="width:100%;padding:0.875rem;background:linear-gradient(135deg,#FB8500 0%,#FF6B00 100%);color:white;border:none;border-radius:0.75rem;font-weight:700;font-size:0.95rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        <span data-translate="instant_tutor_send_request">Enviar solicitud al instante</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let instantTutorData = {
            tutorId: {{ $tutor->id }},
            subjectId: null,
            subjectName: ''
        };

        function openInstantTutorModal() {
            document.getElementById('instant-tutor-modal').style.display = 'flex';
            document.getElementById('instant-tutor-confirm').style.display = 'none';
            instantTutorData.subjectId = null;
            instantTutorData.subjectName = '';
            document.querySelectorAll('.instant-subject-btn').forEach(btn => {
                btn.style.borderColor = '#e2e8f0';
                btn.style.background = 'white';
            });
        }

        function closeInstantTutorModal() {
            document.getElementById('instant-tutor-modal').style.display = 'none';
        }

        function selectInstantSubject(subjectId, subjectName) {
            instantTutorData.subjectId = subjectId;
            instantTutorData.subjectName = subjectName;
            document.querySelectorAll('.instant-subject-btn').forEach(btn => {
                btn.style.borderColor = '#e2e8f0';
                btn.style.background = 'white';
            });
            event.target.style.borderColor = '#FB8500';
            event.target.style.background = '#FFF7ED';
            document.getElementById('instant-selected-subject-name').textContent = subjectName;
            document.getElementById('instant-tutor-confirm').style.display = 'block';
        }

        async function startDirectInstantTutoring() {
            if (!instantTutorData.subjectId) {
                alert('Por favor selecciona una materia');
                return;
            }
            const btn = document.getElementById('btn-start-instant');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span style="opacity:0.7;">Enviando...</span>';
            
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/student/batches/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        subject_id: instantTutorData.subjectId,
                        tutor_id: instantTutorData.tutorId
                    })
                });
                const json = await res.json();
                if (json.success && json.batch_id) {
                    closeInstantTutorModal();
                    window.location.href = '/student/waiting-tutor/' + json.batch_id;
                } else {
                    alert(json.message || 'Error al enviar solicitud');
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                }
            } catch (e) {
                console.error(e);
                alert('Error al enviar solicitud');
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        }

        // Hide badge after 30 days
        document.addEventListener('DOMContentLoaded', function() {
            const badge = document.querySelector('[data-instant-badge]');
            if (badge) {
                const stored = localStorage.getItem('instant_badge_hide_until');
                const now = Date.now();
                if (stored && parseInt(stored) > now) {
                    badge.style.display = 'none';
                } else {
                    // Set to hide after 30 days
                    const hideUntil = now + (30 * 24 * 60 * 60 * 1000);
                    localStorage.setItem('instant_badge_hide_until', hideUntil.toString());
                    // Translate badge based on language
                    const lang = localStorage.getItem('selectedLanguage') || 'es';
                    if (lang === 'en') badge.textContent = 'NEW';
                    else if (lang === 'pt') badge.textContent = 'NOVO';
                    else badge.textContent = 'NUEVO';
                }
            }
        });

        document.getElementById('instant-tutor-modal')?.addEventListener('click', function(e) {
            if (e.target.id === 'instant-tutor-modal') {
                closeInstantTutorModal();
            }
        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('reload-page', (event) => {
                const section = event.section || 'top'; // Sección por defecto
                // Recargar y redirigir a la sección
                window.location.href = window.location.pathname + '#' + section;
                window.location.reload();
            });
        });
    </script>
</div>
@endsection