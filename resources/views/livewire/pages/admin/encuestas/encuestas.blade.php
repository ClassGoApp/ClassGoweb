<div>
    <main class="tb-main am-dispute-system am-user-system">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tb-dhb-mainheading">
                    <div class="tb-dhb-mainheading__title">
                        <h4>{{ __('general.all_surveys') }}</h4>
                    </div>

                    {{-- Barra de búsqueda y filtros --}}
                    <div class="tb-sortby" style="margin-top: 20px;">
                        <form class="tb-themeform tb-displistform">
                            <fieldset>
                                <div class="tb-themeform__wrap">
                                    
                                    {{-- Campo de búsqueda --}}
                                    <div class="form-group">
                                        <div class="tb-search">
                                            <div class="form-group">
                                                <i class="icon-search"></i>
                                                <input type="text" 
                                                    wire:model.live.debounce.500ms="search" 
                                                    class="form-control" 
                                                    placeholder="{{ __('general.search_surveys') }}">
                                                @if($search)
                                                    <button type="button" 
                                                            wire:click="limpiarBusqueda" 
                                                            class="btn btn-sm btn-link"
                                                            title="{{ __('general.clear_search') }}">
                                                        <i class="icon-x"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Select de orden --}}
                                    <div class="tb-actionselect" wire:ignore>
                                        <label class="tb-label">{{ __('general.sort_order') }}</label>
                                        <div class="tb-select">
                                            <select class="filter-select2 form-control" 
                                                    id="sort_by" 
                                                    data-wiremodel="sortby">
                                                <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }}>
                                                    {{ __('general.most_recent') }}
                                                </option>
                                                <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }}>
                                                    {{ __('general.oldest_first') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                {{-- Tabla de encuestas --}}
                <div class="am-disputelist_wrap">
                    
                    {{-- Loader --}}
                    <div wire:loading wire:target="search,sortby" 
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
                        <x-loader />
                    </div>

                    <div class="am-disputelist am-custom-scrollbar-y" 
                        wire:loading.class="tb-blur-loading" 
                        wire:target="search,sortby"
                        style="max-height: 600px;">
                        
                        @if(!$encuestas->isEmpty())
                            <table class="tb-table table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{ __('general.user_id') }}</th>
                                        <th>{{ __('general.question_1') }}</th>
                                        <th>{{ __('general.question_2') }}</th>
                                        <th>{{ __('general.question_3') }}</th>
                                        <th>{{ __('general.contact') }}</th>
                                        <th>{{ __('general.survey_date') }}</th>
                                        <th>{{ __('general.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($encuestas as $encuesta)
                                        <tr wire:key="encuesta-{{ $encuesta->id }}">
                                            <td><strong>#{{ $encuesta->id }}</strong></td>
                                            <td>{{ $encuesta->IdUser ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($encuesta->Question_1, 50) }}</td>
                                            <td>{{ Str::limit($encuesta->Question_2, 50) }}</td>
                                            <td>{{ Str::limit($encuesta->Question_3, 50) }}</td>
                                            <td>{{ $encuesta->Contact }}</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $encuesta->created_at->format('d/m/Y') }}
                                                </span>
                                                <br>
                                                <small class="text-muted">{{ $encuesta->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info" 
                                                        wire:click="verDetalle({{ $encuesta->id }})"
                                                        title="{{ __('general.view_details') }}">
                                                    <i class="icon-eye"></i> {{ __('general.view_details') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Paginación --}}
                            <div class="tb-pagination">
                                {{ $encuestas->links() }}
                            </div>
                        @else
                            <div class="tb-emptydata">
                                <div class="tb-emptydata-content">
                                    <i class="icon-clipboard" style="font-size: 48px; color: #ccc;"></i>
                                    <h5>{{ __('general.no_surveys_found') }}</h5>
                                    <p>{{ __('general.no_surveys_yet') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initFilterSelects() {
                $('.filter-select2').each(function() {
                    const $select = $(this);
                    
                    if ($select.data('select2')) {
                        $select.select2('destroy');
                    }
                    
                    $select.select2({
                        minimumResultsForSearch: -1,
                        width: '100%'
                    });
                    
                    $select.off('change').on('change', function() {
                        const wireModel = $(this).data('wiremodel');
                        const value = $(this).val();
                        @this.set(wireModel, value);
                    });
                });
            }
            
            initFilterSelects();
            
            Livewire.hook('morph.updated', () => {
                initFilterSelects();
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
    .tb-blur-loading {
        filter: blur(3px);
        pointer-events: none;
        transition: filter 0.3s ease;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .card h3 {
        color: #FF3D00;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 32px;
    }

    .tb-emptydata-content {
        text-align: center;
        padding: 60px 20px;
    }

    .tb-emptydata-content i {
        display: block;
        margin-bottom: 20px;
    }

    .tb-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .tb-table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.2s ease;
    }

    .badge-info {
        background: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    </style>
    @endpush

    {{-- Modal para ver detalles --}}
    @push('scripts')
    <script>
        document.addEventListener('showSurveyDetail', function(event) {
            const data = event.detail[0];
            
            Swal.fire({
                title: '<strong>{{ __("general.view_details") }}</strong>',
                html: `
                    <div style="text-align: left; padding: 20px;">
                        <div style="margin-bottom: 20px;">
                            <strong style="color: #FF3D00;">ID:</strong> #${data.id}<br>
                            <strong style="color: #FF3D00;">{{ __("general.user_id") }}:</strong> ${data.userId || 'N/A'}<br>
                            <strong style="color: #FF3D00;">{{ __("general.survey_date") }}:</strong> ${data.date}
                        </div>
                        <hr>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #FF3D00;">{{ __("general.question_1") }}</strong>
                            <p style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 5px;">${data.question1}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #FF3D00;">{{ __("general.question_2") }}</strong>
                            <p style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 5px;">${data.question2}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #FF3D00;">{{ __("general.question_3") }}</strong>
                            <p style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 5px;">${data.question3}</p>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <strong style="color: #FF3D00;">{{ __("general.contact") }}</strong>
                            <p style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 5px;">${data.contact}</p>
                        </div>
                    </div>
                `,
                width: 700,
                confirmButtonColor: '#FF3D00',
                confirmButtonText: '{{ __("general.close_btn") }}'
            });
        });
    </script>
    @endpush
</div>
