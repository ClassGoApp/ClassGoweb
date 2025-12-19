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
                                        <th>{{ __('general.user') }}</th>
                                        <th>{{ __('general.found_subject_easily') }}</th>
                                        <th>{{ __('general.recommendation_rating') }}</th>
                                        <th>{{ __('general.opinion') }}</th>
                                        <th>{{ __('general.contact') }}</th>
                                        <th style="min-width: 180px;">{{ __('general.survey_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($encuestas as $encuesta)
                                        <tr wire:key="encuesta-{{ $encuesta->id }}">
                                            <td><strong>#{{ $encuesta->id }}</strong></td>
                                            <td>
                                                @if($encuesta->IdUser && $encuesta->user && $encuesta->user->profile)
                                                    <span class="badge badge-success">
                                                        {{ $encuesta->user->profile->first_name }} {{ $encuesta->user->profile->last_name }}
                                                    </span>
                                                @elseif($encuesta->IdUser && $encuesta->user)
                                                    <span class="badge badge-success">
                                                        {{ $encuesta->user->email }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">
                                                        {{ __('general.not_authenticated') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($encuesta->Question_1 == 1)
                                                    <span class="badge badge-success">
                                                        <i class="icon-check-circle"></i> {{ __('general.yes_easy') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="icon-alert-circle"></i> {{ __('general.was_difficult') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="rating-display">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $encuesta->Question_2)
                                                            <i class="icon-star text-warning" style="font-size: 16px;"></i>
                                                        @else
                                                            <i class="icon-star text-muted" style="font-size: 16px; opacity: 0.3;"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-2"><strong>{{ $encuesta->Question_2 }}/5</strong></span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($encuesta->Question_3)
                                                    <span title="{{ $encuesta->Question_3 }}">
                                                        {{ Str::limit($encuesta->Question_3, 50) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">{{ __('general.no_comment') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $encuesta->Contact }}</td>
                                            <td class="survey-date-cell">
                                                <div class="date-time-wrapper">
                                                    <div class="date-info">
                                                        <i class="icon-calendar" style="color: #17a2b8;"></i>
                                                        <strong>{{ $encuesta->created_at->format('d/m/Y') }}</strong>
                                                    </div>
                                                    <div class="time-info">
                                                        <i class="icon-clock" style="color: #6c757d;"></i>
                                                        <span>{{ $encuesta->created_at->format('H:i:s') }}</span>
                                                    </div>
                                                </div>
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

    .badge-success {
        background: #28a745;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .badge-secondary {
        background: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .badge-warning {
        background: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 2px;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .survey-date-cell {
        padding: 12px 8px;
    }

    .date-time-wrapper {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .date-info,
    .time-info {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .date-info {
        color: #2c3e50;
    }

    .date-info strong {
        font-weight: 600;
    }

    .time-info {
        color: #6c757d;
    }

    .time-info span {
        font-family: 'Courier New', monospace;
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
