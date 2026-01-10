<div>
    <main class="tb-main am-dispute-system">
        <div class="row">
            <div class="col-12">
                <div class="tb-dhb-mainheading" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    
                    {{-- Título --}}
                    <div class="tb-dhb-mainheading__title" style="margin-bottom: 0;">
                        <h4 style="margin: 0;">{{ __('general.all_surveys') }}</h4>
                    </div>

                    {{-- Contenedor de Filtros --}}
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        {{-- Buscador --}}
                        <div class="search-box-container">    
                            <input type="text" 
                                wire:model.live.debounce.500ms="search" 
                                class="search-input-clean" 
                                placeholder="{{ __('general.search_surveys') }}">
                            
                            <div class="search-icon-wrapper">
                                @if($search)
                                    <button type="button" wire:click="limpiarBusqueda" class="btn-clear-flex" title="Limpiar">
                                        <i class="icon-x"></i>
                                    </button>
                                @else
                                    <i class="icon-search text-muted"></i>
                                @endif
                            </div>
                        </div>

                        {{-- Select Orden --}}
                        <div wire:ignore style="width: 180px;">
                            <select class="filter-select2 form-control" id="sort_by" data-wiremodel="sortby">
                                <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }}>{{ __('general.most_recent') }}</option>
                                <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }}>{{ __('general.oldest_first') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="am-disputelist_wrap mt-4">
                    
                    {{-- Loader --}}
                    <div wire:loading wire:target="search,sortby" class="loader-overlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>

                    <div class="am-disputelist am-custom-scrollbar-y" wire:loading.class="tb-blur-loading">
                        
                        @if(!$encuestas->isEmpty())
                            <table class="tb-table table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th> 
                                        <th class="text-center">{{ __('general.user') }}</th>
                                        <th class="text-center">{{ __('general.found_subject_easily') }}</th>
                                        <th class="text-center" style="min-width: 140px;">{{ __('general.recommendation_rating') }}</th>
                                        <th class="text-left">{{ __('general.opinion') }}</th>
                                        <th class="text-center">{{ __('general.contact') }}</th>
                                        <th class="text-center" style="min-width: 140px;">{{ __('general.survey_date') }}</th>
                                        <th class="text-center" style="min-width: 100px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($encuestas as $encuesta)
                                        <tr wire:key="encuesta-{{ $encuesta->id }}">
                                            
                                            {{-- Contador Visual --}}
                                            <td class="text-center">
                                                <strong class="counter-badge">
                                                    @if($sortby == 'asc')
                                                        {{ $encuestas->firstItem() + $loop->index }}
                                                    @else
                                                        {{ $encuestas->total() - ($encuestas->firstItem() + $loop->index) + 1 }}
                                                    @endif
                                                </strong>
                                            </td>

                                            {{-- Usuario --}}
                                            <td class="text-center">
                                                @if($encuesta->IdUser && $encuesta->user)
                                                    <span class="badge badge-success">
                                                        {{ $encuesta->user->profile->first_name ?? $encuesta->user->email }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">{{ __('general.not_authenticated') }}</span>
                                                @endif
                                            </td>

                                            {{-- Pregunta 1 --}}
                                            <td class="text-center">
                                                @if($encuesta->Question_1 == 1)
                                                    <span class="badge badge-outline-success">
                                                        <i class="icon-check-circle"></i> {{ __('general.yes_easy') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-outline-warning">
                                                        <i class="icon-alert-circle"></i> {{ __('general.was_difficult') }}
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Estrellas --}}
                                            <td class="text-center">
                                                <div class="rating-display justify-content-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="icon-star {{ $i <= $encuesta->Question_2 ? 'text-warning' : 'text-muted-light' }}"></i>
                                                    @endfor
                                                    <span class="rating-number">{{ $encuesta->Question_2 }}/5</span>
                                                </div>
                                            </td>

                                            {{-- Comentario --}}
                                            <td class="text-left">
                                                @if($encuesta->Question_3)
                                                    <span class="comment-text" title="{{ $encuesta->Question_3 }}" wire:click="verDetalle({{ $encuesta->id }})">
                                                        {{ Str::limit($encuesta->Question_3, 40) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>

                                            {{-- Contacto --}}
                                            <td class="text-center">{{ $encuesta->Contact ?? '-' }}</td>

                                            {{-- Fecha --}}
                                            <td class="text-center">
                                                <div class="date-stacked align-items-center">
                                                    <span class="date-main"><i class="icon-calendar"></i> {{ $encuesta->created_at->format('d/m/Y') }}</span>
                                                    <span class="date-sub"><i class="icon-clock"></i> {{ $encuesta->created_at->format('H:i') }}</span>
                                                </div>
                                            </td>

                                            {{-- Acción (Botón Corregido) --}}
                                            <td class="text-center">
                                                <button 
                                                    type="button"
                                                    onclick="confirmarEliminacion({{ $encuesta->id }})"
                                                    class="btn-delete-action mx-auto"
                                                    title="Eliminar registro">
                                                    <i class="icon-trash-2"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="tb-pagination mt-3">
                                {{ $encuestas->links('pagination.custom') }}
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="icon-clipboard"></i>
                                <h5>{{ __('general.no_surveys_found') }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @push('styles')
    <style>
        .tb-dhb-mainheading { padding-bottom: 20px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
        .search-box-container { display: flex; align-items: center; justify-content: space-between; width: 300px; height: 45px; background-color: #fff; border: 1px solid #ced4da; border-radius: 1rem; padding: 0 10px; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
        .search-input-clean { border: none; background: transparent; outline: none; width: 100%; color: #495057; font-size: 0.95rem; padding: 0; margin: 0; height: 100%; }
        .search-icon-wrapper { display: flex; align-items: center; justify-content: center; padding-left: 8px; flex-shrink: 0; }
        .btn-clear-flex { background: #e9ecef; border: none; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #666; transition: all 0.2s; }
        .btn-clear-flex:hover { background: #dc3545; color: white; }
        .btn-clear-flex i { font-size: 14px; }
        .tb-table thead th { background-color: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #495057; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; padding: 15px 10px; vertical-align: middle !important; letter-spacing: 0.5px; }
        .tb-table tbody td { vertical-align: middle !important; padding: 12px 10px; border-bottom: 1px solid #f1f1f1; font-size: 0.9rem; }
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .justify-content-center { justify-content: center !important; }
        .align-items-center { align-items: center !important; }
        .mx-auto { margin-left: auto !important; margin-right: auto !important; }
        .counter-badge { background: #f1f3f5; color: #adb5bd; padding: 5px 10px; border-radius: 8px; font-size: 0.85rem; }
        .badge-outline-success { color: #28a745; border: 1px solid #28a745; background: #f0fff4; padding: 5px 10px; border-radius: 20px; font-weight: 500; }
        .badge-outline-warning { color: #d39e00; border: 1px solid #ffc107; background: #fffdf0; padding: 5px 10px; border-radius: 20px; font-weight: 500; }
        .rating-display { display: flex; align-items: center; gap: 2px; }
        .rating-display i { font-size: 14px; }
        .text-warning { color: #ffc107; }
        .text-muted-light { color: #e9ecef; }
        .rating-number { margin-left: 8px; font-weight: 700; color: #555; font-size: 0.85rem; }
        .comment-text { cursor: pointer; border-bottom: 1px dashed #ccc; transition: color 0.2s; }
        .comment-text:hover { color: #007bff; border-color: #007bff; }
        .date-stacked { display: flex; flex-direction: column; gap: 2px; width: 100%; }
        .date-main { font-weight: 600; color: #333; font-size: 0.9rem; }
        .date-sub { color: #888; font-size: 0.8rem; }
        .date-stacked i { margin-right: 4px; opacity: 0.7; }
        .btn-delete-action { background: transparent; border: 1px solid #ffcccc; color: #dc3545; padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 5px; }
        .btn-delete-action:hover { background: #dc3545; color: white; border-color: #dc3545; }
        .empty-state { text-align: center; padding: 50px 0; color: #999; }
        .empty-state i { font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.3; }
        .loader-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.6); z-index: 10; display: flex; justify-content: center; align-items: center; }
        .tb-blur-loading { filter: blur(2px); pointer-events: none; }
        
    </style>
    @endpush
    
    @push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initSelect2() {
                $('.filter-select2').select2({ minimumResultsForSearch: -1, width: '100%' }).on('change', function() {
                    @this.set($(this).data('wiremodel'), $(this).val());
                });
            }
            initSelect2();
            Livewire.hook('morph.updated', () => { initSelect2(); });
        });

        document.addEventListener('showSurveyDetail', function(event) {
            const data = event.detail[0];
            Swal.fire({
                title: 'Detalle de Encuesta',
                html: `
                    <div class="text-left" style="padding: 0 10px;">
                        <p><strong>ID (Sistema):</strong> #${data.id}</p>
                        <p><strong>Fecha:</strong> ${data.date}</p>
                        <hr>
                        <p><small class="text-muted">Pregunta 1:</small><br>${data.question1}</p>
                        <p><small class="text-muted">Calificación:</small><br>⭐ ${data.question2}/5</p>
                        <p><small class="text-muted">Comentario:</small><br><i>"${data.question3 || 'Sin comentario'}"</i></p>
                        <p><small class="text-muted">Contacto:</small><br>${data.contact || 'N/A'}</p>
                    </div>
                `,
                confirmButtonColor: '#333',
                confirmButtonText: 'Cerrar'
            });
        });

        // Definimos la función en el ámbito global para que el onclick la encuentre
        window.confirmarEliminacion = function(id) {
            Swal.fire({
                title: '¿Eliminar encuesta?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Llamada directa a Livewire
                    @this.delete(id);
                    
                    Swal.fire({
                        title: 'Procesando...',
                        timer: 1000,
                        showConfirmButton: false,
                        willOpen: () => { Swal.showLoading() }
                    });
                }
            });
        }
    </script>
    @endpush
</div>
