<div class="filtro">

    <span class="filtro-blog-icon">
        <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd" />
        </svg>
    </span>

    <input wire:model.live.debounce.300ms="search" wire:keydown.enter="searchBlogs" class="filtro-blog-input"
        type="text" placeholder="Buscar por palabra clave">

    <button type="submit" class="button-buscar" wire:click.prevent="searchBlogs">Buscar</button>


    <div class="content-sugerencias">
        @if (!empty($suggestions))
            <ul class="sugerencias-lista">
                @forelse ($suggestions as $s)
                    <li wire:click="selectSuggestion('{{ $s->slug }}')">
                        {{ Str::limit($s->title, 40) }}
                    </li>
                @empty
                    <div class="sin-coincidencias">Sin coincidencias</div>
                @endforelse
            </ul>
        @endif
    </div>
</div>

</div>
<script>
 
    document.addEventListener('DOMContentLoaded', function() {
        const filtro = document.querySelector('.filtro');
        const sugerencias = document.querySelector('.content-sugerencias');
        const input = document.querySelector('.filtro-blog-input');
        document.addEventListener('click', function(event) {
            if (sugerencias && filtro && !filtro.contains(event.target)) {
                sugerencias.classList.add('oculto');
            }
        });

        input.addEventListener('focus', function() {
            if (sugerencias) {
                if (sugerencias.querySelector('ul')?.children.length > 0) {
                    sugerencias.classList.remove('oculto');
                }
            }
        });
    });
</script>


