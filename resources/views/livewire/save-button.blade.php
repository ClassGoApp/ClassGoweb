<button 
    wire:click="toggleFavorite" 
    class="btn-bookmark {{ $isFavorite ? 'is-favorited' : '' }}"
    style="transition: all 0.3s ease;"
>
    <svg width="20" height="20" viewBox="0 0 24 24" 
         fill="{{ $isFavorite ? '#FB8500' : 'none' }}" 
         stroke="{{ $isFavorite ? '#FB8500' : 'currentColor' }}" 
         stroke-width="2" 
         stroke-linecap="round" 
         stroke-linejoin="round"
         style="transition: all 0.3s ease;">
        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
    </svg>
</button>