<div class="am-profile-setting">
    @slot('title')
        {{ __('profile.account_settings') }}
    @endslot
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="am-userperinfo">
        <div class="am-title_wrap">
            <div class="am-title" >
                <h2 style="color: black">{{ __('passwords.change_password') }}</h2>
                <p style="color: black">{{ __('passwords.change_password_detail') }}</p>
            </div>
        </div>
        <form  class="am-themeform am-accountsetting" >
            <fieldset>
                <div class="form-group" >
                    <x-input-label for="gender" style="color: black" class="am-important" :value="__('passwords.update_password')" />
                    <div class="form-group-two-wrap">
                        <div class="form-control_wrap @error('password') am-invalid @enderror">
                            <x-text-input   wire:model="password"  placeholder="{{ __('passwords.password') }}" type="password"  autofocus autocomplete="name" />
                            <x-input-error field_name="password" />
                        </div>
                        <div class="form-control_wrap  @error('confirm') am-invalid @enderror">
                            <x-text-input wire:model="confirm" class="{{ $errors->get($confirm) ? 'am-invalid' : '' }}" placeholder="{{ __('passwords.re_type_password') }}" type="password"  autofocus autocomplete="name" />
                            <x-input-error field_name="confirm" />
                        </div>
                    </div>
                </div>
                <div class="form-group am-form-btns">
                    <span  style="color: black">{{ __('passwords.latest_changes_live') }}</span>
                    <button wire:click="updatePassword" wire:target="updatePassword" type="button" wire:loading.class="am-btn_disable" class="am-btn">{{ __('passwords.update_password') }}</button>
                </div>
            </fieldset>
        </form>
        {{-- <div class="am-title_wrap">
            <div class="am-title">
                <h2  style="color: black">{{ __('settings.update_time_zone') }}</h2>
                <p  style="color: black"> {{ __('settings.time_zone_settings_easily') }}</p>
            </div>
        </div> --}}
        {{-- <form  class="am-themeform am-accountsetting">
            <fieldset>
                <div class="form-group @error('timezone') tu-invalid @enderror">
                    <label class="am-label am-important" style="color: black">{{ __('settings.timezone') }}</label>
                    <div class="am-select @error('timezone') am-invalid @enderror" wire:ignore>
                        <select data-componentid="@this" class="am-select2" value={{  $timezone}} data-searchable="true" id="timezone" data-wiremodel="timezone" id="timezone"
                            data-placeholder="{{ __('settings.timezone_placeholder') }}"
                            data-placeholderinput="{{ __('settings.timezone_placeholder') }}"
                            >
                            <option value="" selected label="{{ __('settings.timezone_placeholder') }}"></option>
                            @foreach (timezone_identifiers_list() as $tz)
                                <option value="{{ $tz }}" {{ $timezone == $tz ? 'selected' : '' }} >{{ $tz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <x-input-error field_name="timezone" />
                <div class="form-group am-form-btns">
                    <span  style="color: black">{{ __('passwords.latest_changes_live') }}</span>
                    <button wire:click="saveTimezone" wire:target="saveTimezone" type="button" wire:loading.class="am-btn_disable" class="am-btn">{{ __('settings.save_update') }}</button>
                </div>
            </fieldset>
        </form> --}}

     <div style="margin: 20px 0;"></div>
      
    

        
    </div>
</div>


 {{-- @if(!empty($getAccountSetting['google_access_token']))
            <div class="am-reminder">
                <div class="am-reminder_title">
                    <h3>{{ __('passwords.remind_me') }}</h3>
                    <p>{{ __('passwords.reminder_scheduled_lesson') }}</p>
                </div>
                <div class="am-reminder_option">
                    <div class="am-radio">
                        <input type="radio" wire:model="reminder" id="before1" value={{15}} name="reminder">
                        <label for="before1">{{ __('passwords.15_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input wire:model="reminder"  value={{30}} type="radio" id="nonoti" name="reminder">
                        <label for="nonoti">{{ __('passwords.30_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input wire:model="reminder" value={{60}} type="radio" id="before2" name="reminder">
                        <label for="before2">{{ __('passwords.60_min_before_lesson') }}</label>
                    </div>
                    <div class="am-radio">
                        <input type="radio" wire:model="reminder" value={{1440}} id="before3" name="reminder">
                        <label for="before3">{{ __('passwords.24_hours_before_lesson') }}</label>
                    </div>
                </div>
            </div>

            <div class="am-form-btns">
                <span>{{ __('passwords.update_changes_live') }}</span>
                <button  wire:click="saveReminder" wire:target="saveReminder" type="submit" wire:loading.class="am-btn_disable" type="button" class="am-btn">{{ __('passwords.Save_update') }}</button>
            </div>
            @endif --}}