<div class="tb-themeform__wrap" style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center; width: 100%;">
    <input type="text" wire:model.live.debounce.300ms="tutor" class="form-control form-control-sm"
        placeholder="Tutor..." title="Filtrar por tutor" style="width: 125px; height: 32px; font-size: 12px;">

    <input type="text" wire:model.live.debounce.300ms="student" class="form-control form-control-sm"
        placeholder="Estudiante..." title="Filtrar por estudiante" style="width: 125px; height: 32px; font-size: 12px;">

    <select wire:model.live="tipo" class="form-control form-control-sm" title="Tipo de tutoría"
        style="width: 110px; height: 32px; font-size: 12px;">
        <option value="">Tipo: Todas</option>
        <option value="instantanea">Instantánea</option>
        <option value="directa">Reserva</option>
    </select>

    <select wire:model.live="canal" class="form-control form-control-sm" title="Canal de origen"
        style="width: 105px; height: 32px; font-size: 12px;">
        <option value="">Canal: Todos</option>
        <option value="web">Web</option>
        <option value="app">App Móvil</option>
    </select>

    <select wire:model.live="status" class="form-control form-control-sm" title="Estado"
        style="width: 120px; height: 32px; font-size: 12px;">
        <option value="">Estado: Todos</option>
        <option value="1">Aceptado</option>
        <option value="2">Pendiente</option>
        <option value="3">No completado</option>
        <option value="4">Observado / Rechazado</option>
        <option value="5">Completado</option>
    </select>

    <input type="date" wire:model.live="fecha_inicio" class="form-control form-control-sm"
        title="Desde fecha" style="width: 125px; height: 32px; font-size: 12px;" />

    <input type="date" wire:model.live="fecha_fin" class="form-control form-control-sm"
        title="Hasta fecha" style="width: 125px; height: 32px; font-size: 12px;" />

    <div style="display: flex; gap: 4px; align-items: center; margin-left: auto;">
        <button type="button" wire:click="filtrarHoy" class="tb-btn" title="Tutorías de hoy"
            style="padding: 4px 8px; height: 32px; font-size: 12px; min-width: auto; line-height: 1;">
            Hoy
        </button>
        <button type="button" wire:click="filtrarAyer" class="tb-btn" title="Tutorías de ayer"
            style="padding: 4px 8px; height: 32px; font-size: 12px; min-width: auto; line-height: 1;">
            Ayer
        </button>
        <button type="button" wire:click="clearFilters" class="tb-btn admin-tip" data-tip="Limpiar filtros"
            aria-label="Limpiar filtros"
            style="padding: 4px 9px; height: 32px; font-size: 12px; min-width: auto; line-height: 1;">
            <i class="fas fa-broom"></i>
        </button>
        <a href="{{ route('google.authenticate') }}" class="tb-btn tb-btn-primary"
            title="Autenticar Google Calendar" aria-label="Autenticar Google"
            style="padding: 4px 10px; height: 32px; font-size: 12px; min-width: auto; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;">
            <i class="fab fa-google"></i>
            <span>Google</span>
        </a>
    </div>
</div>
