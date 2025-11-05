{{-- @php
    $readyTutorials = auth()->user()->enrolledTutorials()->where('status', 'ready')->count();
@endphp

<div class="fab-container">
    <button id="fab-option-ready-tutorials" class="fab-option fab-option--ready">
        <i class="fas fa-play-circle"></i>
        <span class="fab-option__label">Tutorías Listas ({{ $readyTutorials }})</span>
    </button>
    
    <button id="fab-option-my-tutorials" class="fab-option fab-option--enrolled">
        <i class="fas fa-book-open"></i>
        <span class="fab-option__label">Mis Tutorías</span>
    </button>
    
    @include('components.floating-button.partials.support-option')
    
    <button id="fab-main-button" class="fab-main">
        <img id="fab-main-icon" class="tutoria-disponible-boton" src="{{ asset('images/logoClassgo.png') }}" alt="">
        
        <span id="fab-tooltip-closed" class="fab-main__tooltip fab-main__tooltip--closed">
            Tutorías Disponibles: {{ $readyTutorials }}
        </span>
        <span id="fab-tooltip-open" class="fab-main__tooltip fab-main__tooltip--open hidden">
            Cerrar
        </span>
    </button>
</div> --}}
