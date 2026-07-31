<div class="container">
    @php use Illuminate\Support\Str; @endphp

    @if($currentCourse)
        <div class="am-card">
            <div class="am-card-header">
                <h4>{{ $currentCourse->name }}</h4>

                <small>
                    <span data-translate="company_course_instructor">Instructor:</span>
                    {{ $currentCourse->instructor_name }}
                </small>
            </div>

            <div class="am-card-body">
                @if($currentCourse->video_url)
                    @php
                        $videoUrl = $currentCourse->video_url;

                        if (Str::contains($videoUrl, 'youtube.com/watch?v=')) {
                            $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                        }
                    @endphp

                    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />

                    <div class="am-video-container" wire:ignore>
                        <div class="plyr__video-embed" id="player">
                            <iframe
                                src="{{ $videoUrl }}"
                                allowfullscreen
                                allowtransparency
                                allow="autoplay">
                            </iframe>
                        </div>
                    </div>

                    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>

                @else
                    <p class="nodisponible"
                        data-translate="company_course_video_unavailable">
                        No hay video disponible para este curso.
                    </p>
                @endif

                @if($exam)
                    <button class="am-btnn am-btn-primary am-open-exam-modal"
                        data-translate="company_course_go_to_exam">
                        Ir al examen
                    </button>
                @endif
            </div>
        </div>

        <!-- Modal Examen -->
        @include('livewire.pages.tutor.company-courses.components.courses-modal', [
            'exam' => $exam
        ])
    @else
        <div class="am-alert am-alert-info"
            data-translate="company_course_no_pending_courses">
            No tienes cursos pendientes o en progreso.
        </div>
    @endif

    <script>
        // Función para inicializar Plyr
        function initPlyr() {
            const playerElement = document.getElementById('player');

            if (playerElement && !playerElement.plyr) {
                new Plyr(playerElement);
            }
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', initPlyr);

        // Ejecutar después de cada actualización de Livewire
        document.addEventListener('livewire:updated', initPlyr);

        // Modal JS puro para abrir/cerrar
        document.addEventListener('DOMContentLoaded', function() {
            const modalBtn = document.querySelector('.am-open-exam-modal');
            const modal = document.getElementById('examModal');

            if (!modal) return;

            const closeBtn = modal.querySelector('.am-close');

            if (modalBtn && closeBtn) {
                modalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modal.classList.add('am-show');
                });

                closeBtn.addEventListener('click', function() {
                    modal.classList.remove('am-show');
                });
            }
        });

        // Cerrar modal desde Livewire
        window.addEventListener('close-exam-modal', function() {
            const modal = document.getElementById('examModal');

            if (modal) {
                modal.classList.remove('am-show');
            }
        });
    </script>
</div>

@push('styles')
    <link rel="stylesheet"
        href="{{ asset('css/livewire/pages/tutor/company-courses/courses.css') }}">

    <link rel="stylesheet"
        href="{{ asset('css/livewire/pages/tutor/company-courses/components/courses-modal.css') }}">
@endpush