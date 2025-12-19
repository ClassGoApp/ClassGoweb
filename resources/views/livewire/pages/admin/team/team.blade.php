<main class="tb-main am-dispute-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4>Gestión de Equipo</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ count($selectedTeams) > 0 ? '' : 'd-none' }}" 
                                       @click="$wire.dispatch('showConfirm', { action : 'delete-team' })">
                                        {{ __('general.delete_selected') }}
                                    </a>
                                </div>
                                <a href="{{ route('admin.create-team') }}" class="tb-btn tb-menubtn">
                                    Agregar Miembro <i class="icon-plus"></i>
                                </a>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_sort" class="form-control tk-select2">
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }}>{{ __('general.asc') }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }}>{{ __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_per_page" class="form-control tk-select2">
                                            @foreach([10,20,50,100] as $opt)
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="Buscar miembro...">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!empty($teams) && $teams->count() > 0)
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.live="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('general.select') }}</label>
                                        </div>
                                    </th>
                                    <th style="width: 100px;">Foto</th>
                                    <th style="width: 200px;">Nombre Completo</th>
                                    <th style="width: 150px;">Cargo / Rol</th>
                                    <th style="width: 150px;">Red Social</th>
                                    <th style="width: 90px;">Estado</th>
                                    <th style="width: 80px;">Orden</th>
                                    <th style="width: 120px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $single)
                                    <tr>
                                        <td data-label="{{ __('general.select') }}">
                                            <div class="tb-checkbox">
                                                <input id="team_id{{ $single->id }}" wire:model.live="selectedTeams" value="{{ $single->id }}" type="checkbox">
                                                <label for="team_id{{ $single->id }}"></label>
                                            </div>
                                        </td>
                                        <td data-label="Foto">
                                            @if($single->photo)
                                                @php
                                                    // Usamos la misma lógica robusta de Alianza
                                                    $imagePath = storage_path('app/public/' . $single->photo);
                                                    $imageExists = file_exists($imagePath);
                                                @endphp

                                                @if($imageExists)
                                                    @php
                                                        $imageData = base64_encode(file_get_contents($imagePath));
                                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                        $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                                    @endphp
                                                    <div class="tb-blog-image">
                                                        <img src="{{ $imageSrc }}" alt="{{ $single->name }}" width="60" height="60" style="object-fit: cover; border-radius: 50%;">
                                                    </div>
                                                @else
                                                    <div class="tb-blog-image">
                                                        {{-- Intento secundario con asset normal si falla el path --}}
                                                        <img src="{{ asset('storage/' . $single->photo) }}" alt="{{ $single->name }}" width="60" height="60" style="object-fit: cover; border-radius: 50%;" onerror="this.src='{{ asset('images/Tugo-rostro.png') }}'">
                                                    </div>
                                                @endif
                                            @else
                                                <div class="tb-no-image">
                                                    <i class="icon-user" style="font-size: 24px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="Nombre">
                                            <div class="tb-blog-title">
                                                <h6 class="tb-title">{{ $single->name }} {{ $single->last_name }}</h6>
                                            </div>
                                        </td>
                                        <td data-label="Cargo">
                                            <span class="fw-form-description">
                                                {{ $single->role }}
                                            </span>
                                        </td>
                                        <td data-label="Red Social">
                                            @if($single->platform_link)
                                                {{-- Simplificado a texto/icono para evitar errores de imagen rota de logos externos --}}
                                                <a href="{{ $single->platform_link }}" target="_blank" class="text-primary">
                                                    <i class="icon-external-link"></i> {{ ucfirst($single->platform ?? 'Link') }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="Estado">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status ? 'active' : 'disabled' }}" style="padding-left: 20px">
                                                    {{ $single->status ? 'Activo' : 'Inactivo' }}
                                                </em>
                                            </div>
                                        </td>
                                        <td data-label="Orden">
                                            <span>{{ $single->order }}</span>
                                        </td>
                                        <td data-label="Acciones">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <a href="{{ route('admin.update-team', $single->id) }}" title="Editar">
                                                        <i class="icon-edit-3"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" wire:click="toggleStatus({{ $single->id }})" title="Cambiar Estado">
                                                        <i class="icon-power"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" 
                                                       @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-team' })" 
                                                       class="tb-delete" title="Eliminar">
                                                        <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $teams->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

@push('styles')
<style>
    /* Usamos EXACTAMENTE los mismos estilos de Alianza para corregir la tabla */
    .tb-table { table-layout: fixed; width: 100%; }
    .tb-table th, .tb-table td { padding: 8px 6px; vertical-align: middle; word-wrap: break-word; overflow: hidden; }
    .tb-blog-image img { border-radius: 50%; object-fit: cover; display: block; margin: 0 auto; } /* Ajustado radius 50% para perfiles */
    .tb-no-image { display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; background-color: #f8f9fa; border-radius: 50%; margin: 0 auto; }
    .tb-no-image i { font-size: 18px; color: #ccc; }
    .tb-blog-title .tb-title { margin: 0 0 2px 0; font-size: 13px; font-weight: 600; color: #333; line-height: 1.2; }
    .fw-form-description { font-size: 11px; line-height: 1.3; color: #666; }
    .tb-action-icon { margin: 0; padding: 0; gap:5px}
    .tb-action-icon li { display: inline-block; margin: 0 2px;}
    .tb-action-icon li a { padding: 4px; font-size: 14px; }
    .am-disputelist { overflow-x: auto; }
    .tb-table thead th { font-size: 12px; font-weight: 600; background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; }
    .tb-table tbody tr:hover { background-color: #f8f9fa; }
</style>
@endpush

@push('scripts')
<script type="text/javascript" data-navigate-once>
    document.addEventListener('livewire:navigated', function() {
        component = @this;
    });

    document.addEventListener('livewire:initialized', function() {
        jQuery('#filter_sort').on('change', function (e) {
            var selectedSort = $(this).val();
            component.set('sortby', selectedSort);
        });

        jQuery('#filter_per_page').on('change', function (e) {
            var selectedPer = $(this).val();
            component.set('perPage', selectedPer);
        });
    });
</script>
@endpush