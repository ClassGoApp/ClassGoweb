<div class="profile-flex-columns">
    <div class="profile-col profile-col-1">
        @include('livewire.pages.common.profile-settings.components.imagenes', [
            'image' => $image,
            'imageName' => $imageName,
            'maxImageSize' => $maxImageSize,
            'allowImgFileExt' => $allowImgFileExt
        ])
    </div>

    <div class="profile-col profile-col-2">
        <div class="profile-details-card">
            <div class="profile-details-header">
                <h2 class="profile-details-title" data-translate="profile_personal_details">
                    {{ __('profile.personal_details') }}
                </h2>

                <p class="profile-details-sub" data-translate="profile_basic_info">
                    {{ __('profile.basic_info') }}
                </p>
            </div>

            <form wire:submit.prevent="updateInfo" class="profile-details-form">
                <div class="profile-details-grid">
                    <div class="profile-details-group">
                        <label for="first_name" class="profile-details-label" data-translate="profile_first_name">
                            {{ __('profile.first_name') }}
                        </label>

                        <input type="text" id="first_name" class="profile-details-inputs" wire:model="first_name">

                        @error('first_name')
                            <span class="profile-details-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-details-group">
                        <label for="last_name" class="profile-details-label" data-translate="profile_last_name">
                            {{ __('profile.last_name') }}
                        </label>

                        <input type="text" id="last_name" class="profile-details-inputs" wire:model="last_name">

                        @error('last_name')
                            <span class="profile-details-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="profile-details-group">
                        <label for="email" class="profile-details-label" data-translate="profile_email">
                            {{ __('profile.email') }}
                        </label>

                        <input type="email" id="email" class="profile-details-inputs" wire:model="email" disabled>
                    </div>

                    <div class="profile-details-group">
                        <label for="phone_number" class="profile-details-label" data-translate="profile_phone_number">
                            {{ __('profile.phone_number') }}
                        </label>

                        <input type="tel" id="phone_number" class="profile-details-inputs" wire:model="phone_number">

                        @error('phone_number')
                            <span class="profile-details-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="profile-details-gender-row">
                    @include('livewire.pages.common.profile-settings.components.genero')
                </div>

                <div class="profile-details-actions">
                    <x-primary-button type="submit" wire:loading.class="am-btn_disable" wire:target="updateInfo">
                        <span data-translate="general_save_changes">
                            {{ __('general.save_changes') }}
                        </span>
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/livewire/pages/common/profile-settings/components/student.css') }}">
@endpush