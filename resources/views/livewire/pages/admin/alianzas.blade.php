<main class="tb-main am-dispute-system am-alianzas-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('alianza.alianzas') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedAlianzas ? '' : 'd-none' }}" @click="$wire.dispatch('showConfirm', { action : 'delete-alianza' })">{{ __('general.delete_selected') }}</a>
                                </div>
                                <a href="{{route('admin.create-alianza')}}" class="tb-btn tb-menubtn">
                                    {{ __('alianza.create_alianza') }} <i class="icon-plus"></i>
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
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="{{ __('taxonomy.search_here') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!empty($alianzas) && $alianzas->count() > 0)
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('general.select') }}</label>
                                        </div>
                                    </th>
                                    <th style="width: 100px;">{{ __('alianza.image') }}</th>
                                    <th style="width: 220px;">{{ __('general.title') }}</th>
                                    <th style="width: 240px;">{{ __('general.description') }}</th>
                                    <th style="width: 180px;">{{ __('alianza.link') }}</th>
                                    <th style="width: 90px;">{{ __('general.status') }}</th>
                                    <th style="width: 80px;">{{ __('alianza.order') }}</th>
                                    <th style="width: 120px;">{{ __('general.created_date') }}</th>
                                    <th style="width: 120px;">{{ __('general.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alianzas as $single)
                                    <tr>
                                        <td data-label="{{ __('general.select') }}">
                                            <div class="tb-checkbox">
                                                <input id="alianza_id{{ $single->id }}" wire:model.lazy="selectedAlianzas" value="{{ $single->id }}" type="checkbox">
                                                <label for="alianza_id{{ $single->id }}"></label>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('alianza.image') }}">
                                            @if($single->imagen)
                                                @php
                                                    $imagePath = storage_path('app/public/' . $single->imagen);
                                                    $imageExists = file_exists($imagePath);
                                                @endphp

                                                @if($imageExists)
                                                    @php
                                                        $imageData = base64_encode(file_get_contents($imagePath));
                                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                        $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                                    @endphp
                                                    <div class="tb-blog-image">
                                                        <img src="{{ $imageSrc }}" alt="{{ $single->titulo }}" width="80" height="60" style="object-fit: cover; border-radius: 4px;">
                                                    </div>
                                                @else
                                                    {{-- <div class="tb-no-image">
                                                        <i class="icon-image" style="font-size: 24px; color: #ccc;"></i>
                                                        <small>{{ __('alianza.file_not_found') }}</small>
                                                    </div> --}}
                                                    <div class="tb-blog-image">
                                                        <img src="{{ asset('storage/' . $single->imagen) }}" alt="{{ $single->titulo }}" class="client-logo alianza-evento-imagen">
                                                    </div>
                                                @endif
                                            @else
                                                <div class="tb-no-image">
                                                    <i class="icon-image" style="font-size: 24px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('general.title') }}">
                                            <div class="tb-blog-title">
                                                <h6 class="tb-title">{{ $single->titulo }}</h6>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.description') }}">
                                            <span class="fw-form-description">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($single->descripcion), 100) }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('alianza.link') }}">
                                            @if($single->enlace)
                                                <a href="{{ $single->enlace }}" target="_blank" class="text-primary">{{ \Illuminate\Support\Str::limit($single->enlace, 30) }}</a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('general.status') }}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->activo ? 'active' : 'disabled' }}" style="padding-left: 20px">
                                                    {{ $single->activo ? __('alianza.active') : __('alianza.inactive') }}
                                                </em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('alianza.order') }}">
                                            <span>{{ $single->orden }}</span>
                                        </td>
                                        <td data-label="{{ __('general.created_date') }}">
                                            <div class="tb-date-info">
                                                <span class="tb-date">{{ $single->created_at?->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <a href="{{ route('admin.update-alianza', $single->id) }}" title="{{ __('general.edit') }}">
                                                        <i class="icon-edit-3"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" @click="$wire.toggleStatus({{ $single->id }})" title="{{ __('alianza.toggle_status') }}">
                                                        <i class="icon-power"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-alianza' })" class="tb-delete" title="{{ __('general.delete') }}">
                                                        <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $alianzas->links('pagination.custom') }}
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
    .tb-table { table-layout: fixed; width: 100%; }
    .tb-table th, .tb-table td { padding: 8px 6px; vertical-align: middle; word-wrap: break-word; overflow: hidden; }
    .tb-blog-image img { border-radius: 4px; object-fit: cover; display: block; margin: 0 auto; }
    .tb-no-image { display: flex; align-items: center; justify-content: center; width: 60px; height: 45px; background-color: #f8f9fa; border-radius: 4px; margin: 0 auto; }
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
