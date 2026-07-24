<div>
    @if ($successMessage)
        <div class="am-success-msg" style="text-align: center; padding: 40px 20px;">
            <div class="success-icon-container">
                <i class="am-icon-check-circle" style="font-size: 60px; color: #219EBC;"></i>
            </div>

            <h4 style="margin-top: 20px; color: #023047; font-weight: 700;">
                {{ $successMessage }}
            </h4>

            <p style="color: #6c757d;" data-translate="recruitment_success_profile_sent">
                {{ __('recruitment.success_profile_sent') }}
            </p>

            <button
                type="button"
                class="am-btn"
                onclick="closeRecruitmentModal()"
                style="margin-top: 15px; width: 200px;"
                data-translate="recruitment_understood">
                {{ __('recruitment.understood') }}
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="am-recruitment-form" style="padding: 1rem;">

            <div class="row">
                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">
                        <span data-translate="recruitment_full_name">
                            {{ __('recruitment.full_name') }}
                        </span>
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model.blur="full_name"
                        class="form-control input-form @error('full_name') is-invalid @enderror"
                        placeholder="{{ __('recruitment.full_name_placeholder') }}"
                        data-translate-placeholder="recruitment_full_name_placeholder">

                    @error('full_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">
                        <span data-translate="recruitment_email">
                            {{ __('recruitment.email') }}
                        </span>
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="email"
                        wire:model.blur="email"
                        class="form-control input-form @error('email') is-invalid @enderror"
                        placeholder="{{ __('recruitment.email_placeholder') }}"
                        data-translate-placeholder="recruitment_email_placeholder">

                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6 mb-3 input-form">
                    <label style="color: #023047; font-weight: 600;">
                        <span data-translate="recruitment_whatsapp">
                            {{ __('recruitment.whatsapp') }}
                        </span>
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model.blur="phone"
                        class="form-control input-form @error('phone') is-invalid @enderror"
                        placeholder="{{ __('recruitment.phone_placeholder') }}"
                        data-translate-placeholder="recruitment_phone_placeholder">

                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <div class="form-group mb-4">
                <label>
                    <span data-translate="recruitment_cv_label">
                        {{ __('recruitment.cv_label') }}
                    </span>
                    <span class="text-danger">*</span>
                </label>

                <div class="custom-file-upload">
                    <input type="file" wire:model="cv" id="cv-upload" class="d-none" accept=".pdf">

                    <label for="cv-upload" class="am-upload-box" style="position: relative;">
                        <div wire:loading.remove wire:target="cv">
                            <i class="am-icon-upload-01" style="font-size: 1.5rem; color: #219EBC;"></i>

                            @if($cv)
                                <span class="d-block mt-1" style="font-size: 0.8rem; color: #6c757d;">
                                    {{ $cv->getClientOriginalName() }}
                                </span>
                            @else
                                <span
                                    class="d-block mt-1"
                                    style="font-size: 0.8rem; color: #6c757d;"
                                    data-translate="recruitment_upload_cv">
                                    {{ __('recruitment.upload_cv') }}
                                </span>
                            @endif
                        </div>
                        
                        <div wire:loading wire:target="cv">
                            <i class="fas fa-spinner fa-spin" style="font-size: 1.5rem; color: #219EBC;"></i>

                            <span
                                class="d-block mt-1"
                                style="font-size: 0.8rem; color: #219EBC; font-weight: 600;"
                                data-translate="recruitment_uploading_file">
                                {{ __('recruitment.uploading_file') }}
                            </span>
                        </div>
                    </label>
                </div>

                @error('cv')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="am-form-btn">
                <button
                    type="submit"
                    class="am-btn w-100 am-btn-submit"
                    wire:loading.attr="disabled"
                    wire:target="submit, cv">
                    <span wire:loading.remove wire:target="submit" data-translate="recruitment_apply_now">
                        {{ __('recruitment.apply_now') }}
                    </span>

                    <span wire:loading wire:target="submit">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span data-translate="recruitment_processing">
                            {{ __('recruitment.processing') }}
                        </span>
                    </span>
                </button>
            </div>

            @auth
                <button id="hidden-dismiss-btn" type="button" wire:click.prevent="dismiss" style="display: none;"></button>

                <div class="mt-3 text-center">
                    <a href="#"
                       onclick="triggerDismissConfirm(true); return false;"
                       style="color: #6c757d; font-size: 0.85rem; text-decoration: underline; cursor: pointer;"
                       data-translate="recruitment_close_never_show">
                        {{ __('recruitment.close_never_show') }}
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
