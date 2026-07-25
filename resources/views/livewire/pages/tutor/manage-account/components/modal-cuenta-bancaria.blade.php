<div wire:ignore.self class="modal fade" id="setupaccountpopup" tabindex="-1" aria-labelledby="setupaccountpopupLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-m">
        <div class="modal-content bank-modal">
            <!-- Header -->
            <div class="modal-header bank-modal-header">
                <h5 class="modal-title bank-modal-title" id="setupaccountpopupLabel">
                    <i class="fas fa-university me-2"></i>
                    <span data-translate="manage_account_bank_modal_title">
                        Configurar cuenta bancaria
                    </span>
                </h5>
                <button type="button" class="btn-close bank-close-btn" data-bs-dismiss="modal"
                    aria-label="Close" data-translate-aria-label="general_close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body bank-modal-body">
                <form wire:submit.prevent="updatePayout">

                    <!-- Título de la cuenta -->
                    <div class="form-group">
                        <label for="accounttitle" class="form-label" data-translate="manage_account_bank_account_type_label">
                            Tipo de cuenta bancaria
                        </label>

                        <select style="padding:0rem 1rem !important;"
                            wire:model.defer="bankTitle"
                            id="accounttitle"
                            name="accounttitle"
                            class="form-control bank-input @error('bankTitle') is-invalid @enderror"
                            required>

                            <option value="" data-translate="manage_account_select_account_type">
                                Seleccione tipo de cuenta
                            </option>

                            <option value="ahorro" data-translate="manage_account_savings_account">
                                Cuenta de ahorro
                            </option>

                            <option value="corriente" data-translate="manage_account_current_account">
                                Cuenta corriente
                            </option>
                        </select>

                        @error('bankTitle')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Número de cuenta -->
                    <div class="form-group">
                        <label for="account" class="form-label" data-translate="manage_account_bank_account_number_label">
                            Número de cuenta bancaria
                        </label>

                        <input wire:model.defer="bankAccountNumber" id="account" name="account"
                            placeholder="Ingrese el número de cuenta"
                            data-translate-placeholder="manage_account_bank_account_number_placeholder"
                            type="text"
                            class="form-control bank-input @error('bankAccountNumber') is-invalid @enderror" />

                        @error('bankAccountNumber')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Nombre del banco -->
                    <div class="form-group">
                        <label for="bankname" class="form-label" data-translate="manage_account_bank_name_label">
                            Nombre del banco
                        </label>

                        <input wire:model.defer="bankName" id="bankname" name="bankname"
                            placeholder="Introduzca el nombre del banco"
                            data-translate-placeholder="manage_account_bank_name_placeholder"
                            type="text"
                            class="form-control bank-input @error('bankName') is-invalid @enderror" />

                        @error('bankName')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer bank-modal-footer">
                <button type="button" class="btn btn-secondary bank-cancel-btn" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    <span data-translate="general_cancel">
                        Cancelar
                    </span>
                </button>

                <button type="button" wire:click="updatePayout" wire:loading.attr="disabled" wire:target="updatePayout"
                    class="btn btn-primary bank-save-btn">

                    <!-- Icono y texto normal -->
                    <span wire:loading.remove.delay wire:target="updatePayout">
                        <i class="fas fa-save me-2"></i>
                        <span data-translate="manage_account_save_account">
                            Guardar cuenta
                        </span>
                    </span>

                    <!-- Estado de carga -->
                    <span wire:loading.delay wire:target="updatePayout">
                        <i class="fas fa-spinner fa-spin me-2"></i>
                        <span data-translate="manage_account_saving">
                            Guardando...
                        </span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>