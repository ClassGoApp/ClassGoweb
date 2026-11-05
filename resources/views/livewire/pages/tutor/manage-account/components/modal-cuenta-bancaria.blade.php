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

                    <!-- Nombre del banco (Selector con buscador + check + opción Otro) -->
                    <div class="form-group" style="position: relative;" id="bolivia-bank-selector-wrapper">
                        <label for="bankname" class="form-label" data-translate="manage_account_bank_name_label">
                            Nombre del banco
                        </label>

                        <div class="bank-combobox-container" style="position: relative;">
                            <input wire:model.defer="bankName" id="bankname" name="bankname"
                                placeholder="Seleccione o escriba su banco (ej. Ganadero, Unión...)"
                                data-translate-placeholder="manage_account_bank_name_placeholder"
                                type="text"
                                autocomplete="off"
                                onclick="openBoliviaBankDropdown()"
                                onfocus="openBoliviaBankDropdown()"
                                oninput="filterBoliviaBankDropdown(this.value)"
                                style="padding-right: 40px;"
                                class="form-control bank-input @error('bankName') is-invalid @enderror" />

                            <button type="button"
                                onclick="toggleBoliviaBankDropdown(event)"
                                tabindex="-1"
                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: #504f4f; cursor: pointer; padding: 4px 6px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-down" id="bankDropdownChevron" style="font-size: 13px; transition: transform 0.2s ease;"></i>
                            </button>

                            <!-- Lista desplegable simple estilo select -->
                            <div id="boliviaBankDropdownList"
                                wire:ignore
                                style="display: none; position: absolute; left: 0; right: 0; top: calc(100% + 2px); max-height: 220px; overflow-y: auto; background: #ffffff; border: 1px solid #504f4f; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.12); z-index: 1060; padding: 4px 0;">
                            </div>
                        </div>

                        <small id="customBankHint" style="display: none; color: #666; font-size: 12px; margin-top: 4px;">
                            Escriba el nombre de su banco en el campo superior.
                        </small>

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