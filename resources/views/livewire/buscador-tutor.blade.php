<div class="search-box">
    <i class="fa-solid fa-magnifying-glass icon-search"></i>

    <input type="text" class="form-control" placeholder="Buscar Tutor o Materias" wire:model.live="search">

   @if(!empty($search))
    <ul>
        @forelse($results as $tutor)
            <li>
                <a href=" {{ route('tutor', $tutor['slug']) }}"><strong>{{ $tutor['full_name'] }}</strong><br></a>
                <small>{{ implode(', ', $tutor['materias']) }}</small>
            </li>
        @empty
            {{-- EL MENSAJE DE NO RESULTADOS --}}
            <li class="no-results-message">
                No se encontraron tutores o Materias
            </li>
        @endforelse
    </ul>
@endif
</div>

            
