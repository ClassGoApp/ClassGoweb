@extends('vistas.view.layouts.app')

@section('content')
{{-- tutor-perfil.css --}}
<div class="tutor-bg">
    <!-- Contenido Principal -->
    <main class="tutor-main">
        <!-- Breadcrumbs -->
        <div class="tutor-breadcrumbs">
            <a href="#" class="tutor-breadcrumb-link">Tutores</a> / 
            <a href="{{ route('buscar')}}" class="tutor-breadcrumb-link">Encontrar tutor</a> / 
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
                    'ratingDistribution' => $ratingDistribution

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

    


    <script>
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


                favoriteBtn.addEventListener('click', () => {
                    // Alternar la clase en el botón
                    const newFavoriteState = !favoriteBtn.classList.toggle('is-favorited-blue');

                    // Guardar el nuevo estado en el almacenamiento local
                    localStorage.setItem(localStorageKey, newFavoriteState);

                    // Puedes añadir aquí la lógica para interactuar con el servidor
                    console.log(estiloFavorito);

                    if (newFavoriteState) {
                        textFavorito.textContent = 'Añadir a Favoritos';
                        
                    } else {
                        console.log('Botón con corazón azul desactivado.');
                        textFavorito.textContent = 'En tus Favoritos';
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
            const shareUrl = `https://classgoapp.com/tutors/${slug}`;
            const shareMsg = 'Hecha un vistazo a mi perfil en ClassGo!';

            btnShare.addEventListener('click', function() {
                modalShare.style.display = 'flex';
            });
            closeModal.addEventListener('click', function() {
                modalShare.style.display = 'none';
            });
            // WhatsApp
            btnWhatsapp.addEventListener('click', function() {
                const url = `https://wa.me/?text=${encodeURIComponent(shareMsg + ' ' + shareUrl)}`;
                window.open(url, '_blank');
            });
            // Facebook
            btnFacebook.addEventListener('click', function() {
                const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}&quote=${encodeURIComponent(shareMsg)}`;
                window.open(url, '_blank');
            });
        });

        //============== Calificaciones y reseñas =========================
        document.addEventListener('DOMContentLoaded', function() {
            const starRating = document.getElementById('star-rating');
            const stars = starRating.getElementsByClassName('review-form__star');
            const ratingInput = document.getElementById('rating-input');
            const form = document.getElementById('review-form');
            let currentRating = 0;

            function updateStars(rating) {
                Array.from(stars).forEach((star, index) => {
                    star.style.color = index < rating ? '#FB8500' : '#E5E7EB';
                });
            }

            Array.from(stars).forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                    updateStars(index + 1);
                });

                star.addEventListener('click', () => {
                    currentRating = index + 1;
                    ratingInput.value = currentRating;
                    updateStars(currentRating);
                });
            });

            starRating.addEventListener('mouseleave', () => {
                updateStars(currentRating);
            });

            form.addEventListener('submit', function(e) {
                if (!currentRating) {
                    e.preventDefault();
                    alert('Por favor, selecciona una calificación');
                }
            });
        });

        //===================== Modal para reserva ===================
        // document.addEventListener('DOMContentLoaded', () => {
        //     // --- Selección de Elementos del DOM ---
        //     const openModalBtn = document.getElementById('openModalBtn');
        //     const reservationModal = document.getElementById('reservationModal');
        //     const modalContent = document.getElementById('modalContent');
        //     const cancelBtn = document.getElementById('cancelBtn');
        //     const body = document.body; // Seleccionamos el body para manipularlo

        //     // Elementos del formulario
        //     const fileInput = document.getElementById('comprobante');
        //     const fileNameDisplay = document.getElementById('fileName');
        //     const dateSpan = document.getElementById('currentDate');
        //     const timeSpan = document.getElementById('currentTime');

        //     // --- Funciones ---

        //     /**
        //      * Actualiza la fecha y la hora en el modal.
        //      */
        //     const updateDateTime = () => {
        //         const now = new Date();
        //         const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
        //         // He ajustado las opciones de hora para usar la de Santa Cruz, Bolivia (GMT-4)
        //         const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'America/La_Paz' };
                
        //         // Usamos 'es-BO' para el formato de Bolivia
        //         dateSpan.textContent = now.toLocaleDateString('es-BO', dateOptions);
        //         timeSpan.textContent = now.toLocaleTimeString('es-BO', timeOptions);
        //     };

        //     /**
        //      * Abre el modal y bloquea el scroll del fondo.
        //      */
        //     const openModal = () => {
        //         updateDateTime(); // Actualiza la fecha y hora

        //         // 1. Calcula el ancho de la barra de scroll
        //         const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

        //         // 2. Aplica el padding-right al body para compensar el espacio de la barra
        //         body.style.paddingRight = `${scrollbarWidth}px`;

        //         // 3. Añade la clase que oculta el overflow (bloquea el scroll)
        //         body.classList.add('modal-open');
                
        //         // 4. Muestra el modal
        //         reservationModal.classList.add('is-visible');
        //     };

        //     /**
        //      * Cierra el modal y restaura el scroll del fondo.
        //      */
        //     const closeModal = () => {
        //         // 1. Oculta el modal
        //         reservationModal.classList.remove('is-visible');

        //         // 2. Elimina la clase que bloquea el scroll
        //         body.classList.remove('modal-open');
                
        //         // 3. Restaura el padding-right del body a su estado original
        //         body.style.paddingRight = '';
        //     };

        //     /**
        //      * Actualiza el nombre del archivo seleccionado.
        //      */
        //     const handleFileChange = (event) => {
        //         const file = event.target.files[0];
        //         if (file) {
        //             fileNameDisplay.textContent = file.name;
        //         } else {
        //             fileNameDisplay.textContent = 'Ningún archivo seleccionado';
        //         }
        //     };

        //     // --- Asignación de Eventos (sin cambios aquí) ---

        //     if (openModalBtn) {
        //         openModalBtn.addEventListener('click', openModal);
        //     }
            
        //     if (cancelBtn) {
        //         cancelBtn.addEventListener('click', closeModal);
        //     }

        //     if (reservationModal) {
        //         reservationModal.addEventListener('click', (event) => {
        //             if (event.target === reservationModal) {
        //                 closeModal();
        //             }
        //         });
        //     }

        //     document.addEventListener('keydown', (event) => {
        //         if (event.key === 'Escape' && reservationModal.classList.contains('is-visible')) {
        //             closeModal();
        //         }
        //     });

        //     if (fileInput) {
        //         fileInput.addEventListener('change', handleFileChange);
        //     }
        // });


    document.addEventListener('livewire:initialized', () => {
        // --- Selección de Elementos del DOM ---
        const reservationModal = document.getElementById('reservationModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const body = document.body;

        // Verificar que los elementos existen
        if (!reservationModal) {
            console.error('Modal element not found');
            return;
        }

        // --- Funciones ---
        const openModal = () => {
            try {
                // Calcular ancho de scrollbar para evitar saltos
                const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
                body.style.paddingRight = `${scrollbarWidth}px`;
                body.classList.add('modal-open');
                reservationModal.classList.add('is-visible');
                
                console.log('Modal opened successfully');
                
            } catch (error) {
                console.error('Error opening modal:', error);
            }
        };

        const closeModal = () => {
            try {
                reservationModal.classList.remove('is-visible');
                body.classList.remove('modal-open');
                body.style.paddingRight = '';
                
                console.log('Modal closed successfully');
            } catch (error) {
                console.error('Error closing modal:', error);
            }
        };

        // --- Asignación de Eventos Livewire ---
        
        // 1. Escucha el evento 'open-modal' que viene desde Livewire
        if (window.Livewire) {
            Livewire.on('open-modal', (event) => {
            console.log('Received open-modal event:', event);
            setTimeout(() => {
                openModal();
            }, 1); // Un retraso mínimo es suficiente
        });

            // 2. Escucha un evento de error (opcional pero recomendado)
            Livewire.on('show-error', (event) => {
                console.log('Received error event:', event);
                alert(event.message || 'Ha ocurrido un error');
            });
        } else {
            console.error('Livewire not found. Make sure Livewire is properly loaded.');
        }

        // --- Eventos de Cierre del Modal ---
        
        // Cierra el modal con el botón de cancelar
        if (cancelBtn) {
            cancelBtn.addEventListener('click', (e) => {
                e.preventDefault();
                closeModal();
            });
        }

        // Cierra el modal al hacer clic en el fondo
        reservationModal.addEventListener('click', (event) => {
            if (event.target === reservationModal) {
                closeModal();
            }
        });

        // Cierra el modal con la tecla Escape
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && reservationModal.classList.contains('is-visible')) {
                closeModal();
            }
        });

        // --- Manejo del Input de Archivo ---
        const fileInput = document.getElementById('comprobante');
        const fileNameDisplay = document.getElementById('fileName');
        
        if (fileInput && fileNameDisplay) {
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                fileNameDisplay.textContent = file ? file.name : 'Ningún archivo seleccionado';
            });
        }

        // --- Debug: Función para probar el modal manualmente ---
        window.testModal = () => {
            console.log('Testing modal...');
            openModal();
        };
        
        console.log('Modal JavaScript initialized successfully');
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
</div>
@endsection