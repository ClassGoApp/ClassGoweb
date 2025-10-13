@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-centered-nav">

        <div class="pagination-buttons-container">
            
            {{-- VISTA MÓVIL (Anterior/Siguiente) --}}
            <div class="pagination-mobile-controls">
                @if ($paginator->onFirstPage())
                    <span class="pagination-btn pagination-btn--mobile-disabled">
                        Anterior
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn pagination-btn--mobile-active">
                        {{-- {!! __('pagination.previous') !!} --}}
                        Anterior
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn pagination-btn--mobile-active pagination-btn--mobile-next-margin">
                        {{-- {!! __('pagination.next') !!} --}}
                        Siguiente
                    </a>
                @else
                    <span class="pagination-btn pagination-btn--mobile-disabled pagination-btn--mobile-next-margin">
                        {{-- {!! __('pagination.next') !!} --}}
                        Siguiente
                    </span>
                @endif
            </div>

            {{-- VISTA ESCRITORIO (Números Centrados) --}}
            <div class="pagination-desktop-controls">
                <span class="pagination-group-wrapper">
                    {{-- Previous Page Link (Icono) --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="pagination-icon-btn pagination-icon-btn--left pagination-icon-btn--disabled" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                Anterior
                            </span>
                            
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-icon-btn pagination-icon-btn--left pagination-icon-btn--active" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            Anterior
                        </a>
                    @endif

                    {{-- Pagination Elements (Números y Separadores) --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true"><span class="pagination-number pagination-number--separator">{{ $element }}</span></span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"><span class="pagination-number pagination-number--current">{{ $page }}</span></span>
                                @else
                                    <a href="{{ $url }}" class="pagination-number pagination-number--active" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-icon-btn pagination-icon-btn--right pagination-icon-btn--active" aria-label="{{ __('pagination.next') }}">
                        {{-- ¡Añade el texto "Siguiente" aquí! --}}
                        Siguiente
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="pagination-icon-btn pagination-icon-btn--right pagination-icon-btn--disabled" aria-hidden="true">
                            {{-- ¡Añade el texto "Siguiente" aquí! (Deshabilitado) --}}Siguente
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </span>
                    </span>
                @endif
                </span>
            </div>
        </div>

        {{-- <div class="pagination-results-wrapper">
            <p class="pagination-results-text">
                {!! __('Mostrando') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('de') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('del total') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('tutores') !!}
            </p>
        </div> --}}
        
    </nav>

    <style>
        /* ======================================================= */
/* 1. NAVEGACIÓN PRINCIPAL (Diseño de Columna y Centrado) */
/* ======================================================= */
.pagination-centered-nav {
    display: flex;
    /* CLAVE: Coloca los elementos uno debajo del otro */
    flex-direction: column; 
    /* CLAVE: Centra horizontalmente todo el contenido */
    align-items: center; 
    justify-content: center;
}

/* Contenedor de Botones y Números (Arriba) */
.pagination-buttons-container {
    margin-bottom: 0.75rem; /* Espacio entre botones y texto de resultados */
}

/* Texto de Resultados (Abajo) */
.pagination-results-wrapper {
    /* Asegura que el texto también se centre en el contexto de un solo div */
    text-align: center; 
}


/* ======================================================= */
/* 2. CONTROLES MÓVILES VS ESCRITORIO */
/* ======================================================= */

/* VISTA MÓVIL (Por defecto: Solo botones Previous/Next) */
.pagination-mobile-controls {
    display: flex;
    justify-content: space-between;
    width: 100%; /* Ocupa todo el ancho disponible en móvil */
    max-width: 20rem; /* Limita el ancho del contenedor en pantallas pequeñas */
}
.pagination-desktop-controls {
    display: none; /* Oculto en móvil */
}

/* MEDIA QUERY: Escritorio (sm: 640px o más) */
@media (min-width: 640px) {
    /* Oculta los controles de móvil */
    .pagination-mobile-controls {
        display: none;
    }
    /* Muestra los controles de escritorio (números) */
    .pagination-desktop-controls {
        display: block; 
    }
}


/* ======================================================= */
/* 3. ESTILOS BASE DE BOTONES (Consolidado de estilos) */
/* ======================================================= */

/* Estilos compartidos para botones móviles y números de escritorio */
.pagination-btn,
.pagination-group-wrapper a,
.pagination-group-wrapper span span {
    position: relative;
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem; /* text-sm */
    font-weight: 500; /* font-medium */
    line-height: 1.25; /* leading-5 */
    border: 1px solid #D1D5DB; /* border-gray-300 */
    background-color: #FFFFFF; /* bg-white */
    color: #4B5563; /* text-gray-700 */
    transition: all 0.15s ease-in-out; 
    white-space: nowrap;
}
.dark .pagination-btn,
.dark .pagination-group-wrapper a,
.dark .pagination-group-wrapper span span {
    background-color: #1F2937; /* dark:bg-gray-800 */
    border-color: #4B5563; /* dark:border-gray-600 */
    color: #9CA3AF; /* dark:text-gray-400 */
}


/* -- BOTONES MÓVILES (Previous/Next) -- */
.pagination-btn {
    padding: 0.5rem 1rem; /* px-4 py-2 */
    border-radius: 0.375rem; /* rounded-md */
}
.pagination-btn--mobile-next-margin {
    margin-left: 0.75rem; /* ml-3 */
}
.pagination-btn--mobile-disabled {
    cursor: default;
    color: #6B7280; /* text-gray-500 */
}

/* -- GRUPO DE ESCRITORIO (Contenedor) -- */
.pagination-group-wrapper {
    z-index: 0;
    display: inline-flex;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
    border-radius: 0.375rem; /* rounded-md */
}

/* -- NÚMEROS Y SEPARADORES -- */
.pagination-number {
    padding: 0.5rem 1rem; /* px-4 py-2 */
    margin-left: -1px; /* -ml-px */
}
.pagination-number--separator,
.pagination-number--current {
    cursor: default;
}
/* Estilo del número actual */
.pagination-number--current {
    color: #6B7280; /* text-gray-500 */
}


/* -- ICONOS DE ESCRITORIO (Prev/Next) -- */
.pagination-icon-btn {
    padding: 0.5rem 0.5rem; /* px-2 py-2 */
    margin-left: -1px; /* -ml-px */
    color: #6B7280; /* text-gray-500 */
}
.pagination-icon-btn svg {
    width: 1.25rem; /* w-5 */
    height: 1.25rem; /* h-5 */
}

/* ----------------------------------------------- */
/* BORDES REDONDEADOS EN EL GRUPO */
/* ----------------------------------------------- */
.pagination-icon-btn--left {
    margin-left: 0; /* Anula el -ml-px para el primero */
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}
.pagination-icon-btn--right {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}


/* ----------------------------------------------- */
/* HOVER/FOCUS/ACTIVE STATES */
/* ----------------------------------------------- */
.pagination-btn--mobile-active:hover,
.pagination-number--active:hover,
.pagination-icon-btn--active:hover {
    color: #6B7280; /* hover:text-gray-500 (light) */
}
.dark .pagination-number--active:hover,
.dark .pagination-icon-btn--active:hover {
    color: #D1D5DB; /* dark:hover:text-gray-300 */
}

/* Focus/Ring */
.pagination-btn a:focus,
.pagination-number--active:focus,
.pagination-icon-btn--active:focus {
    z-index: 10; /* focus:z-10 */
    outline: none; 
    box-shadow: 0 0 0 3px rgba(199, 210, 254, 0.5); /* ring-gray-300 */
    border-color: #93C5FD; /* focus:border-blue-300 */
}
.dark .pagination-number--active:focus,
.dark .pagination-icon-btn--active:focus {
    border-color: #8a1e1e; /* dark:focus:border-blue-800 */
}

/* Active */
.pagination-btn a:active,
.pagination-number--active:active,
.pagination-icon-btn--active:active {
    background-color: #F3F4F6; /* active:bg-gray-100 */
    color: #4B5563; /* active:text-gray-700 */
}
.dark .pagination-number--active:active,
.dark .pagination-icon-btn--active:active {
    background-color: #374151; /* dark:active:bg-gray-700 */
}


/* ======================================================= */
/* 4. ESTILOS DEL TEXTO DE RESULTADOS */
/* ======================================================= */
.pagination-results-text {
    font-size: 0.875rem; /* text-sm */
    line-height: 1.25; /* leading-5 */
    color: #4B5563; /* text-gray-700 */
}
.dark .pagination-results-text {
    color: #9CA3AF; /* dark:text-gray-400 */
}
.pagination-results-text span {
    font-weight: 500; /* font-medium */
}
    </style>
@endif