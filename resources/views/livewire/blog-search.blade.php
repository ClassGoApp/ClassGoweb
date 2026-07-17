<div class="filtro">

    <span class="filtro-blog-icon">
        <svg class="buscartutor-search-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd" />
        </svg>
    </span>

    <input wire:model.live.debounce.300ms="search" wire:keydown.enter="searchBlogs" class="filtro-blog-input"
    type="text" placeholder="Buscar por palabra clave" data-placeholder-key="blog_search_placeholder">

    <button type="submit" class="button-buscar" wire:click.prevent="searchBlogs" data-translate="bus">
        Buscar
    </button>


    <div class="content-sugerencias">
        @if (!empty($suggestions))
            <ul class="sugerencias-lista">
                @forelse ($suggestions as $s)
                    <li wire:click="selectSuggestion('{{ $s->slug }}')">
                        {{ Str::limit($s->title, 40) }}
                    </li>
                @empty
                    <div class="sin-coincidencias" data-translate="blog_no_matches">Sin coincidencias</div>
                @endforelse
            </ul>
        @endif
    </div>
</div>

</div>
<script>
    function blogText(key, fallback = '') {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        if (typeof translations === 'undefined') {
            return fallback;
        }

        const t = translations[lang] || translations.es;

        return t[key] || fallback;
    }

    function applyBlogPlaceholder() {
        const input = document.querySelector('.filtro-blog-input');

        if (input) {
            input.placeholder = blogText('blog_search_placeholder', 'Buscar por palabra clave');
        }
    }

    function applyBlogFilterTranslations() {
        const lang = localStorage.getItem('selectedLanguage') || 'es';

        applyBlogPlaceholder();

        if (typeof selectLanguage === 'function') {
            selectLanguage(lang, false);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filtro = document.querySelector('.filtro');
        const sugerencias = document.querySelector('.content-sugerencias');
        const input = document.querySelector('.filtro-blog-input');

        applyBlogFilterTranslations();

        document.addEventListener('click', function(event) {
            if (sugerencias && filtro && !filtro.contains(event.target)) {
                sugerencias.classList.add('oculto');
            }
        });

        if (input) {
            input.addEventListener('focus', function() {
                if (sugerencias) {
                    if (sugerencias.querySelector('ul')?.children.length > 0) {
                        sugerencias.classList.remove('oculto');
                    }
                }
            });
        }
    });

    document.addEventListener('languageChanged', function() {
        applyBlogPlaceholder();
    });

    document.addEventListener('livewire:navigated', applyBlogFilterTranslations);

    document.addEventListener('livewire:init', function() {
        Livewire.hook('morph.updated', function() {
            setTimeout(applyBlogFilterTranslations, 50);
        });
    });
</script>


