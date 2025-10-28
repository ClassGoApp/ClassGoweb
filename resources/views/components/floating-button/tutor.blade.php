@php
    $tutoriasCount = Cache::remember('tutor_floating_' . auth()->id(), 120, function () {
        try {
            $floatingService = app(App\Services\FloatingService::class);
            return $floatingService->getTutoriasAceptadasCount();
        } catch (\Exception $e) {
            Log::error('Floating button error: ' . $e->getMessage());
            return 0;
        }
    });
@endphp
<div class="fab-container">
    <button id="fab-option-tutorials" class="fab-option fab-option--tutorials">
        <i class="fas fa-chalkboard-teacher"></i>
        <span class="fab-option__label">Mis Tutorías 2</span>
    </button>
    
    <button id="fab-option-schedule" class="fab-option fab-option--schedule">
        <i class="fas fa-calendar-alt"></i>
        <span class="fab-option__label">Horarios</span>
    </button>
    
    @include('components.floating-button.partials.support-option')
    
    <button id="fab-main-button" class="fab-main">
        <img id="fab-main-icon" class="tutoria-disponible-boton" src="{{ asset('images/logoClassgo.png') }}" alt="">
        
        <span id="fab-tooltip-closed" class="fab-main__tooltip fab-main__tooltip--closed">
            Tutorías Pendientes: {{ $tutoriasCount }}
        </span>
        <span id="fab-tooltip-open" class="fab-main__tooltip fab-main__tooltip--open hidden">
            Cerrar
        </span>
    </button>
</div>
