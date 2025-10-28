<div class="fab-container">
    @include('components.floating-button.partials.whatsapp-option')
    @include('components.floating-button.partials.ai-option')
    @include('components.floating-button.partials.support-option')
    
    <button id="fab-main-button" class="fab-main">
        <i id="fab-main-icon" class="fas fa-question"></i>
        {{-- <img id="fab-main-icon" class="tutoria-disponible-boton" src="{{ asset('images/logoClassgo.png') }}" alt=""> --}}
        
        <span id="fab-tooltip-closed" class="fab-main__tooltip fab-main__tooltip--closed">
            ¿Necesitas ayuda?
        </span>
        <span id="fab-tooltip-open" class="fab-main__tooltip fab-main__tooltip--open hidden">
            Cerrar
        </span>
    </button>
</div>
