<!-- Modal QR -->
<div wire:ignore.self class="modal fade" id="modalQR" tabindex="-1" aria-labelledby="modalQRLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-m">
        <div class="modal-content qr-modal">
            <!-- Header -->
            <div class="modal-header qr-modal-header">
                <h5 class="modal-title qr-modal-title" id="modalQRLabel">
                    <i class="fas fa-qrcode me-2"></i>
                    Configurar Código QR de Pago
                </h5>
                <button type="button" class="btn-close qr-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body qr-modal-body">
                <form wire:submit.prevent="updatePayout" enctype="multipart/form-data">
                    <!-- QR Actual (si existe) -->
                    @if($currentQRPath)
                        <div class="current-qr-section">
                            <h6 class="section-title">Código QR Actual</h6>
                            <div class="current-qr-container">
                                <div class="qr-image-wrapper">
                                    <img src="{{ asset('storage/' . $currentQRPath) }}" alt="QR Actual"
                                        class="current-qr-image">
                                    <div class="qr-image-overlay">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    @endif

                    <!-- Zona de Upload -->
                    <div class="upload-section">
                        <h6 class="section-title">
                            @if($currentQRPath)
                                Cambiar Código QR
                            @else
                                Subir Código QR
                            @endif
                        </h6>

                        <div class="upload-zone" onclick="document.getElementById('qrImageInput').click()"
                            ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">

                            @if($qrImage)
                                <!-- Preview de nueva imagen -->
                                <div class="new-image-preview">
                                    <img src="{{ $qrImage->temporaryUrl() }}" alt="Nueva imagen QR" class="preview-image">
                                    <div class="preview-overlay">
                                        <div class="preview-info">
                                            <i class="fas fa-image"></i>
                                            <span class="preview-filename">{{ $qrImage->getClientOriginalName() }}</span>
                                            <span class="preview-size">{{ number_format($qrImage->getSize() / 1024, 2) }}
                                                KB</span>
                                        </div>
                                        <button type="button" class="remove-preview-btn" wire:click="$set('qrImage', null)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <!-- Zona de upload vacía -->
                                <div class="upload-placeholder">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="upload-text">
                                        <h6>Arrastra tu imagen aquí</h6>
                                        <p>o <span class="upload-link">haz clic para seleccionar</span></p>
                                    </div>
                                    <div class="upload-requirements">
                                        <small>PNG, JPG, GIF • Máximo 5MB</small>
                                    </div>
                                </div>
                            @endif

                            <!-- Input oculto -->
                            <input wire:model="qrImage" id="qrImageInput" type="file" accept="image/*" class="d-none">
                        </div>

                        <!-- Error de validación -->
                        @if($qrImageTypeError)
                            <div class="alert alert-danger mt-3">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ $qrImageTypeError }}
                            </div>
                        @endif
                    </div>
                    <!-- Información adicional -->
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer qr-modal-footer">
                <button type="button" class="btn btn-secondary qr-cancel-btn" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancelar
                </button>

                <button type="button" wire:click="updatePayout" wire:loading.attr="disabled" wire:target="updatePayout"
                    class="btn btn-primary qr-save-btn" {{ !$qrImage && !$currentQRPath ? 'disabled' : '' }}>

                    <!-- Icono y texto normal -->
                    <span wire:loading.remove wire:target="updatePayout">
                        @if($currentQRPath && $qrImage)
                            <i class="fas fa-sync-alt me-2"></i>
                            Cambiar imagen
                        @elseif($currentQRPath)
                            <i class="fas fa-check me-2"></i>
                            Guardar QR
                        @else
                            <i class="fas fa-save me-2"></i>
                            Guardar QR
                        @endif
                    </span>

                    <!-- Estado de carga -->
                    <span wire:loading wire:target="updatePayout">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        Procesando...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    // Función para limpiar completamente el modal y backdrop
    function cleanupModal() {
        // Remover cualquier backdrop que pueda quedar
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());

        // Limpiar clases del body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    // Drag and Drop handlers
    function dragOverHandler(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.add('drag-over');
    }

    function dropHandler(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.remove('drag-over');

        if (ev.dataTransfer.items) {
            for (var i = 0; i < ev.dataTransfer.items.length; i++) {
                if (ev.dataTransfer.items[i].kind === 'file') {
                    var file = ev.dataTransfer.items[i].getAsFile();
                    if (file.type.startsWith('image/')) {
                        // Simular que el archivo fue seleccionado
                        const input = document.getElementById('qrImageInput');
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;

                        // Disparar evento de change para Livewire
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    break;
                }
            }
        }
    }

    // Limpiar clase drag-over cuando se sale del área
    document.addEventListener('dragleave', function (e) {
        if (!e.relatedTarget || !e.currentTarget.contains(e.relatedTarget)) {
            document.querySelectorAll('.upload-zone').forEach(zone => {
                zone.classList.remove('drag-over');
            });
        }
    });

    // Event listeners para el modal
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modalQR');
        if (modalElement) {
            // Cuando el modal se cierra completamente
            modalElement.addEventListener('hidden.bs.modal', function () {
                cleanupModal();

                // Reset del formulario Livewire
                if (window.Livewire) {
                    Livewire.dispatch('modalClosed');
                }
            });

            // Cuando el modal se muestra
            modalElement.addEventListener('shown.bs.modal', function () {
                // Asegurar que el modal está correctamente inicializado
                console.log('Modal QR abierto correctamente');
            });

            // Manejo de errores
            modalElement.addEventListener('hide.bs.modal', function (e) {
                // Permitir que el modal se cierre normalmente
                console.log('Cerrando modal QR...');
            });
        }
    });

    // Listener específico para Livewire navigation
    document.addEventListener('livewire:navigated', function () {
        cleanupModal();
    });
</script>