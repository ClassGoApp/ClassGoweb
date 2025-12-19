<div class="favorite-button-container-blue">
    <button wire:click="toggleFavorite" class="favorite-btn-blue tutor-btn tutor-btn-reservar {{ $isFavorite ? 'is-favorited-blue' : '' }}" aria-label="Agregar a favoritos">
        <svg class="heart-icon-blue" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
        </svg>
        <span>{{ $isFavorite ? 'En tus Favoritos' : 'Favoritos' }}</span>
    </button>
</div>
