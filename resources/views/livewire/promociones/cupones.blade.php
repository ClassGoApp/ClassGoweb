<main class="tb-main am-dispute-system am-user-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_user_click" class="tb-btn add-new"
                                        data-bs-toggle="modal" data-bs-target="#tb-add-user">
                                        {{ __('general.add_new_cupon') }} <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="@this" class="am-select2 form-control"
                                            data-searchable="false" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                            <option value="">{{ __('general.All') }}</option>
                                            <option value="active">{{ __('general.Active') }}</option>
                                            <option value="inactive">{{ __('general.Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                                        autocomplete="off" placeholder="{{ __('general.search_cupon') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if (!$cupones->isEmpty())
                        <table
                            class="tb-table @if (setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('general.Name') }}</th>
                                    <th>{{ __('general.Code') }}</th>
                                    <th>{{ __('general.Expiration_date') }}</th>
                                    <th>{{ __('general.Status') }}</th>
                                    <th>{{ __('general.Discount') }}</th>
                                    <th>{{ __('general.Amount') }}</th>
                                    <th>{{ __('general.References') }}</th>
                                    <th>{{ __('general.Actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cupones as $cupon)
                                    <tr>
                                        <td>{{ $cupon->id }}</td>
                                        <td>
                                            <span>{{ $cupon->nombre }}</span>
                                        </td>
                                        <td>{{ $cupon->codigo }}</td>
                                        <td>
                                            {{ $cupon->fecha_caducidad ? $cupon->fecha_caducidad->format('d/m/Y') : 'sin fecha de vencimiento' }}
                                        </td>
                                        <td>
                                            {{ $cupon->estado }}
                                        </td>
                                        <td>
                                            {{ $cupon->descuento }}%
                                        </td>
                                        <td>
                                            {{ $cupon->cantidad }}
                                        </td>
                                        <td>
                                            {{ $this->referencia($cupon->referencia) }}
                                        </td>
                                        <td class="d-flex gap-2">
                                            {{-- Cambiar fecha de caducidad --}}
                                            <button type="button" class="tb-btn tb-btn-light btn-sm"
                                                wire:click="openFecha({{ $cupon->id }})"
                                                title="{{ __('general.change_expiration') }}">
                                                <i class="icon-calendar"></i>
                                            </button>

                                            {{-- Activar/Desactivar --}}
                                            <button type="button" class="tb-btn tb-btn-light btn-sm"
                                                wire:click="openConfirm({{ $cupon->id }}, 'toggle')"
                                                title="{{ $cupon->estado === 'activo' ? __('general.deactivate') : __('general.activate') }}">
                                                <i class="icon-power"></i>
                                            </button>

                                            {{-- Eliminar --}}
                                            <button type="button" class="tb-btn tb-btn-light btn-sm"
                                                wire:click="openConfirm({{ $cupon->id }}, 'delete')"
                                                title="{{ __('general.delete') }}">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')" />
                    @endif
                </div>
            </div>
            {{ $cupones->links('pagination.custom') }}
        </div>
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-user" aria-labelledby="tb_coupon_label"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_coupon_label">{{ __('general.add_new_cupon') }}</h5>
                        <a href="javascript:void(0);" class="close">
                            <i class="icon-x" data-bs-dismiss="modal"></i>
                        </a>
                    </div>

                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="saveCoupon" id="add_coupon_form">
                            <fieldset>
                                <div class="form-group-wrap">

                                    <!-- nombre -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.name') }}</label>
                                        <input type="text"
                                            class="form-control @error('form.nombre') tk-invalid @enderror"
                                            wire:model.defer="form.nombre"
                                            placeholder="{{ __('general.nombre_placeholder') }}">
                                        @error('form.nombre')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- codigo -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.codigo') }}</label>
                                        <input type="text"
                                            class="form-control @error('form.codigo') tk-invalid @enderror"
                                            wire:model.defer="form.codigo"
                                            placeholder="{{ __('general.codigo_placeholder') }}">
                                        @error('form.codigo')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- fecha_caducidad -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.fecha_caducidad') }}</label>
                                        <input type="date"
                                            class="form-control @error('form.fecha_caducidad') tk-invalid @enderror"
                                            wire:model.defer="form.fecha_caducidad">
                                        @error('form.fecha_caducidad')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- estado -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.estado') }}</label>
                                        <div class="@error('form.estado') tk-invalid @enderror">
                                            <div class="tb-select">
                                                <select class="form-control" wire:model.defer="form.estado">
                                                    <option value="">{{ __('general.select_option') }}</option>
                                                    <option value="activo">{{ __('general.activo') }}</option>
                                                    <option value="inactivo">{{ __('general.inactivo') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        @error('form.estado')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- descuento (decimal 8,2) -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.descuento') }}</label>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('form.descuento') tk-invalid @enderror"
                                            wire:model.defer="form.descuento"
                                            placeholder="{{ __('general.descuento_placeholder') }}">
                                        @error('form.descuento')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- cantidad (entero) -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.cantidad') }}</label>
                                        <input type="number" step="1" min="0"
                                            class="form-control @error('form.cantidad') tk-invalid @enderror"
                                            wire:model.defer="form.cantidad"
                                            placeholder="{{ __('general.cantidad_placeholder') }}">
                                        @error('form.cantidad')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- referencia -->
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.referencia') }}</label>
                                        <input class="form-control @error('form.referencia') tk-invalid @enderror"
                                            wire:model.defer="form.referencia"
                                            placeholder="{{ __('general.referencia_placeholder') }}" rows="3"></input>
                                        @error('form.referencia')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    <!-- Botones -->
                                    <div class="form-group tb-formbtn d-flex gap-2">
                                        <button class="tb-btn" type="submit" wire:target="saveCoupon"
                                            wire:loading.class="am-btn_disable">
                                            {{ __('general.save_cupon') }}
                                        </button>
                                        <button type="button" class="tb-btn tb-btn-light" data-bs-dismiss="modal">
                                            {{ __('general.cancel') }}
                                        </button>
                                    </div>

                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center p-5">
                        <div class="mb-3">
                            <i class="icon-trash-2 h2 d-block"></i>
                        </div>
                        <h5 class="mb-2">{{ __('general.confirm_title') }}</h5>

                        @php
                            $msg = match ($action) {
                                'delete' => __('general.confirm_delete_coupon'),
                                'toggle' => __('general.confirm_toggle_coupon'),
                                default => '',
                            };
                        @endphp

                        <p class="mb-4">{{ $msg }}</p>

                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="tb-btn tb-btn-light" data-bs-dismiss="modal">
                                {{ __('general.no') }}
                            </button>
                            <button type="button" class="tb-btn" wire:click="performConfirmedAction"
                                wire:loading.attr="disabled">
                                {{ __('general.yes') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="fechaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="tb-popuptitle d-flex justify-content-between align-items-center px-4 pt-3">
                        <h5 class="m-0">{{ __('general.change_expiration') }}</h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="saveFecha">
                            <div class="form-group">
                                <label class="tb-label">{{ __('general.fecha_caducidad') }}</label>
                                <input type="date" class="form-control" wire:model.defer="newFechaCaducidad">
                                <small class="text-muted">{{ __('general.leave_empty_no_expiration') }}</small>
                                @error('newFechaCaducidad')
                                    <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="tb-btn" wire:loading.attr="disabled">
                                    {{ __('general.save_changes') }}
                                </button>
                                <button type="button" class="tb-btn tb-btn-light" data-bs-dismiss="modal">
                                    {{ __('general.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@push('styles')
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tb-table td,
        .tb-table th {
            white-space: nowrap;
            padding: 12px 8px;
        }

        .tb-table .btn {
            padding: 4px 8px;
            font-size: 12px;
        }

        /* Asegurar que los botones no se compriman */
        .tb-table td:last-child {
            min-width: 180px !important;
        }

        /* Mejorar la visualización en dispositivos móviles */
        @media (max-width: 768px) {
            .tb-table {
                font-size: 14px;
            }

            .tb-table .btn {
                padding: 2px 6px;
                font-size: 11px;
            }
        }

        /* Ajustar la altura del contenedor de la tabla */
        .am-disputelist_wrap {
            height: auto !important;
            min-height: 400px;
        }

        .am-disputelist {
            height: auto !important;
            max-height: 70vh;
            /* Máximo 70% de la altura de la pantalla */
            overflow-y: auto;
            overflow-x: auto;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tb-table td,
        .tb-table th {
            white-space: nowrap;
            padding: 12px 8px;
        }

        .tb-table .btn {
            padding: 4px 8px;
            font-size: 12px;
        }

        /* Asegurar que los botones no se compriman */
        .tb-table td:last-child {
            min-width: 180px !important;
        }

        /* Remover restricciones de altura que puedan estar causando el overflow */
        .am-custom-scrollbar-y {
            height: auto !important;
            max-height: 430px !important;
        }

        /* Mejorar la visualización en dispositivos móviles */
        @media (max-width: 768px) {
            .tb-table {
                font-size: 14px;
            }

            .tb-table .btn {
                padding: 2px 6px;
                font-size: 11px;
            }

            .am-disputelist {
                max-height: 60vh;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {

            // Abrir/cerrar modales Bootstrap 5
            Livewire.on('open-bs-modal', ({
                id
            }) => {
                const el = document.getElementById(id);
                if (!el) return;
                const modal = bootstrap.Modal.getOrCreateInstance(el);
                modal.show();
            });

            Livewire.on('close-bs-modal', ({
                id
            }) => {
                const el = document.getElementById(id);
                if (!el) return;
                const modal = bootstrap.Modal.getOrCreateInstance(el);
                modal.hide();
            });

            // Toast simple (puedes reemplazar por tu sistema)
            Livewire.on('toast', ({
                type,
                message
            }) => {
                // Ejemplo simple:
                console.log(type?.toUpperCase() + ': ' + message);
                // Si usas algún plugin de notificaciones, llámalo aquí.
            });


            // Inicializar el select de filtro
            const filterSelect = document.getElementById('filter_user');
            if (filterSelect) {
                filterSelect.addEventListener('change', function() {
                    @this.set('filterUser', this.value);
                });
            }
            });
    </script>
@endpush