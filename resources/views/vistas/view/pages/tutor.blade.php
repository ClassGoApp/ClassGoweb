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
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        if (currentScroll > lastScroll) {
            // Scroll hacia abajo → ocultar
            actionBar.classList.remove('hidden');
        } else {
            // Scroll hacia arriba → mostrar
            actionBar.classList.add('hidden');
        }
        lastScroll = currentScroll <= 0 ? 0 : currentScroll; // Evita valores negativos
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