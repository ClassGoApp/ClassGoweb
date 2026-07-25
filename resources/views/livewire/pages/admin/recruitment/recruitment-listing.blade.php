<div class="tb-db-dashboard_box_wrap">
    <style>
        .btn-download-cv {
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }
        .btn-download-cv:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }
        .btn-download-cv:disabled {
            opacity: 0.85;
            cursor: wait;
        }
        .cv-loading-spinner {
            display: inline-flex;
            align-items: center;
        }
        .badge-no-cv {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }
        /* Enter (Aparición: 0% a 100%) */
        .alert-grow-enter {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: top center;
            overflow: hidden;
        }
        .alert-grow-start {
            opacity: 0;
            max-height: 0px !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            border-width: 0px !important;
            transform: scaleY(0);
        }
        .alert-grow-end {
            opacity: 1;
            max-height: 100px;
            transform: scaleY(1);
        }

        /* Leave (Desaparición: 100% a 0%) */
        .alert-shrink-leave {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top center;
            overflow: hidden;
        }
        .alert-shrink-start {
            opacity: 1;
            max-height: 100px;
            transform: scaleY(1);
        }
        .alert-shrink-end {
            opacity: 0;
            max-height: 0px !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            margin-top: 0px !important;
            margin-bottom: 0px !important;
            border-width: 0px !important;
            transform: scaleY(0);
        }

        /* Barra de carga de descarga (100% ancho sin texto) */
        .download-progress-wrapper {
            width: 100%;
        }
        .download-bar-fill {
            height: 100%;
            border-radius: 6px;
            animation: fillDownloadBar 1s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes fillDownloadBar {
            0% { width: 0%; }
            40% { width: 55%; }
            80% { width: 85%; }
            100% { width: 100%; }
        }
    </style>

    <div class="tb-db-dashboard_box_wrap_inner">
        <div class="tb-menumanagement_wrap">
            <div class="tb-dbholder">
                <div class="tb-dbholder__title">
                    <h3>Gestión de Reclutamiento</h3>
                    <div class="tb-dbholder__right">
                        <div class="tb-inputicon">
                            <input type="text" wire:model.live="search" class="form-control"
                                placeholder="Buscar postulante...">
                        </div>
                    </div>
                </div>

                <!-- Barra de Carga de Descarga (100% de ancho, sin texto) -->
                <div wire:loading wire:target="downloadCV"
                     x-transition:enter="alert-grow-enter"
                     x-transition:enter-start="alert-grow-start"
                     x-transition:enter-end="alert-grow-end"
                     x-transition:leave="alert-shrink-leave"
                     x-transition:leave-start="alert-shrink-start"
                     x-transition:leave-end="alert-shrink-end"
                     class="w-100 my-3 px-3 download-progress-wrapper" style="width: 100%;">
                    <div class="progress" style="height: 8px; width: 100%; background-color: #e2e8f0; border-radius: 6px; overflow: hidden;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary download-bar-fill" role="progressbar"></div>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div wire:key="alert-success-{{ md5(session('success')) }}-{{ microtime(true) }}"
                         x-data="{ show: false }"
                         x-init="$nextTick(() => show = true); setTimeout(() => show = false, 3500)"
                         x-show="show"
                         x-transition:enter="alert-grow-enter"
                         x-transition:enter-start="alert-grow-start"
                         x-transition:enter-end="alert-grow-end"
                         x-transition:leave="alert-shrink-leave"
                         x-transition:leave-start="alert-shrink-start"
                         x-transition:leave-end="alert-shrink-end"
                         class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div wire:key="alert-error-{{ md5(session('error')) }}-{{ microtime(true) }}"
                         x-data="{ show: false }"
                         x-init="$nextTick(() => show = true); setTimeout(() => show = false, 3500)"
                         x-show="show"
                         x-transition:enter="alert-grow-enter"
                         x-transition:enter-start="alert-grow-start"
                         x-transition:enter-end="alert-grow-end"
                         x-transition:leave="alert-shrink-leave"
                         x-transition:leave-start="alert-shrink-start"
                         x-transition:leave-end="alert-shrink-end"
                         class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif

                <div class="tb-admin-table-area">
                    <table class="table tb-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Postulante</th>
                                <th>Contacto</th>
                                <th>Área / Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recruitments as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $item->full_name }}</strong><br>
                                        <small>{{ $item->email }}</small>
                                    </td>
                                    <td>
                                        @if ($item->phone)
                                            {{ $item->phone }}<br>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}"
                                                target="_blank" class="btn btn-sm btn-success mt-1">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">No proporcionado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $item->description }}">
                                            {{ $item->description ?? 'Sin descripción' }}
                                        </div>
                                    </td>
                                    <td>
                                        <select wire:change="updateStatus({{ $item->id }}, $event.target.value)"
                                            style="width: auto;" class="form-control form-control-sm">
                                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>
                                                Pendiente</option>
                                            <option value="reviewed"
                                                {{ $item->status == 'reviewed' ? 'selected' : '' }}>Revisado</option>
                                            <option value="contacted"
                                                {{ $item->status == 'contacted' ? 'selected' : '' }}>Contactado
                                            </option>
                                            <option value="rejected"
                                                {{ $item->status == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="tb-table-actions" style="display: flex; align-items: center; gap: 0.5rem;">
                                            @if (!empty($item->cv_path) && Illuminate\Support\Facades\Storage::disk('public')->exists($item->cv_path))
                                                <button wire:click="downloadCV({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="downloadCV({{ $item->id }})"
                                                    class="btn btn-sm btn-primary btn-download-cv"
                                                    title="Descargar CV">
                                                    <span wire:loading.remove wire:target="downloadCV({{ $item->id }})">
                                                        <i class="ti-download"></i>
                                                    </span>
                                                    <span wire:loading wire:target="downloadCV({{ $item->id }})" class="cv-loading-spinner">
                                                        <i class="fas fa-spinner fa-spin"></i>
                                                    </span>
                                                </button>
                                            @else
                                                <span class="badge-no-cv" title="El postulante no adjuntó archivo de CV o el archivo no existe">
                                                    <i class="ti-file"></i> Sin CV
                                                </span>
                                            @endif

                                            <button wire:click="delete({{ $item->id }})"
                                                class="btn btn-sm btn-danger"
                                                title="Eliminar"
                                                onclick="confirm('¿Estás seguro?') || event.stopImmediatePropagation()">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No se encontraron postulaciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $recruitments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

