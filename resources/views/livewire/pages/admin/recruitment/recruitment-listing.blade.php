<div class="tb-db-dashboard_box_wrap">
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
                                        <div class="tb-table-actions" style="display: flex; gap: 0.5rem;">
                                            <button wire:click="downloadCV({{ $item->id }})"
                                                class="btn btn-sm btn-primary" title="Descargar CV">
                                                <i class="ti-download"></i>
                                            </button>
                                            <button wire:click="delete({{ $item->id }})"
                                                class="btn btn-sm btn-danger"
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
