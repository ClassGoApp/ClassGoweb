<div>
    @if ($successMessage)
        <div class="am-success-msg" style="text-align: center; padding: 40px 20px;">
            <div class="success-icon-container">
                <i class="am-icon-check-circle" style="font-size: 60px; color: #219EBC;"></i>
            </div>
            <h4 style="margin-top: 20px; color: #023047; font-weight: 700;">{{ $successMessage }}</h4>
            <p style="color: #6c757d;">Tu perfil ha sido enviado a nuestro equipo de ClassGo.</p>
            <button type="button" class="am-btn" onclick="closeRecruitmentModal()"
                style="margin-top: 15px; width: 200px;">Entendido</button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="am-recruitment-form" style="padding: 1rem;">

            <div class="row">
                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">Nombre Completo <span
                            class="text-danger">*</span></label>
                    <input type="text" wire:model.blur="full_name"
                        class="form-control input-form @error('full_name') is-invalid @enderror"
                        placeholder="Ej. Juan Pérez">
                    @error('full_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">Email Corporativo/Personal <span
                            class="text-danger">*</span></label>
                    <input type="email" wire:model.blur="email"
                        class="form-control input-form @error('email') is-invalid @enderror"
                        placeholder="ejemplo@correo.com">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" wire:model.blur="phone"
                        class="form-control input-form @error('phone') is-invalid @enderror" placeholder="+591 ...">
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- <div class="form-group mb-3">
                <label style="color: var(--primary-color); font-weight: 600;">¿En qué área te destacas? <span class="text-danger">*</span></label>
                <textarea wire:model.defer="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Ej: Desarrollador Backend, Especialista en Ventas, Tutor de Matemáticas..."></textarea>
                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div> --}}

            <div class="form-group mb-4">
                <label>Tu Curriculum Vitae (PDF) <span class="text-danger">*</span></label>
                <div class="custom-file-upload">
                    <input type="file" wire:model="cv" id="cv-upload" class="d-none" accept=".pdf">

                    <label for="cv-upload" class="am-upload-box" style="position: relative;">
                        <!-- Estado normal -->
                        <div wire:loading.remove wire:target="cv">
                            <i class="am-icon-upload-01" style="font-size: 1.5rem; color: #219EBC;"></i>
                            <span class="d-block mt-1" style="font-size: 0.8rem; color: #6c757d;">
                                {{ $cv ? $cv->getClientOriginalName() : 'Haz clic aquí para subir tu CV' }}
                            </span>
                        </div>
                        
                        <!-- Animación mientras carga -->
                        <div wire:loading wire:target="cv">
                            <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; color: #219EBC;"></i>
                            <span class="d-block mt-1" style="font-size: 0.8rem; color: #219EBC; font-weight: 600;">
                                Subiendo archivo...
                            </span>
                        </div>
                    </label>
                </div>
                @error('cv')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="am-form-btn">
                <button type="submit" class="am-btn w-100 am-btn-submit" wire:loading.attr="disabled" wire:target="submit, cv">
                    <span wire:loading.remove wire:target="submit">POSTULARME AHORA</span>
                    <span wire:loading wire:target="submit">
                        <i class="fas fa-spinner fa-spin"></i> PROCESANDO...
                    </span>
                </button>
            </div>

            @auth
            <div class="mt-3 text-center">
                <a href="#" wire:click.prevent="dismiss" style="color: #6c757d; font-size: 0.85rem; text-decoration: underline; cursor: pointer;">
                    Cerrar y no volver a mostrar
                </a>
            </div>
            @endauth
        </form>
    @endif
    
    <script>
        window.addEventListener('hide-recruitment-button', event => {
            if (typeof closeRecruitmentModal === 'function') {
                closeRecruitmentModal();
            }
            document.querySelectorAll('.am-recruitment-fab').forEach(el => {
                el.style.display = 'none';
            });
        });

        window.addEventListener('recruitment-sent', event => {
            // Oculta el botón flotante en el fondo sin recargar cuando se envía el CV
            document.querySelectorAll('.am-recruitment-fab').forEach(el => {
                el.style.display = 'none';
            });
        });
    </script>
    <style>
        /* Estilo para bloquear y apagar el botón visualmente mientras procesa */
        button.am-btn-submit:disabled {
            background: #6c757d !important;
            border-color: #6c757d !important;
            cursor: not-allowed !important;
            opacity: 0.8;
            transform: none !important;
            box-shadow: none !important;
        }
        button.am-btn-submit:disabled::after {
            display: none !important; /* Oculta la animación de brillo */
        }
    </style>
</div>
