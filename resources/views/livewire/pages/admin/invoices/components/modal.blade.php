<div class="claim-modal-overlay" wire:click="closeClaimModal">
    <div class="claim-modal-container" wire:click.stop>
        <div class="claim-modal-header">
            <h3 class="claim-modal-title">
                <i class="fas fa-exclamation-triangle"></i>
                <span data-translate="invoices_claim_modal_title">
                    {{ __('invoices.claim_modal_title') }}
                </span>
            </h3>

            <button
                class="claim-modal-close"
                wire:click="closeClaimModal"
                aria-label="{{ __('invoices.claim_modal_close') }}"
                data-translate-aria-label="invoices_claim_modal_close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="claim-modal-body">
            <div class="claim-input-group">
                <label
                    for="claimDescription"
                    class="claim-label"
                    data-translate="invoices_claim_description_label">
                    {{ __('invoices.claim_description_label') }}
                </label>

                <textarea
                    id="claimDescription"
                    wire:model="claimDescription"
                    class="claim-textarea"
                    placeholder="{{ __('invoices.claim_placeholder') }}"
                    data-translate-placeholder="invoices_claim_placeholder"
                    rows="6"></textarea>

                <div class="claim-input-hint" data-translate="invoices_claim_minimum_hint">
                    {{ __('invoices.claim_minimum_hint') }}
                </div>
            </div>
        </div>

        <div class="claim-modal-footer">
            <button class="claim-btn claim-btn-secondary" wire:click="closeClaimModal">
                <i class="fas fa-times"></i>
                <span data-translate="invoices_claim_cancel">
                    {{ __('invoices.claim_cancel') }}
                </span>
            </button>

            <button class="claim-btn claim-btn-primary" wire:click="submitClaim">
                <i class="fas fa-paper-plane"></i>
                <span data-translate="invoices_claim_modal_submit">
                    {{ __('invoices.claim_modal_submit') }}
                </span>
            </button>
        </div>
    </div>
</div>