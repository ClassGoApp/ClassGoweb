   <div wire:ignore.self class="modal fade am-educationpopup" id="education-popup" data-bs-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2 style="color:black !important;">
                            @if ($updateMode)
                                {{ __('education.update_new_education') }}
                            @else
                                {{ __('education.add_new_education') }}
                            @endif
                        </h2>
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form wire:submit="storeEducation" class="am-themeform">
                            <fieldset>
                                <div class="form-group @error('form.course_title') am-invalid @enderror">
                                    <x-input-label style="color:black !important;" for="name" class="am-important" :value="__('education.degree')"  />
                                    <x-text-input wire:model="form.course_title" id="course_title" name="course_title"
                                        placeholder="{{ __('education.degree_placeholder') }}" type="text" autofocus
                                        autocomplete="name" />
                                    <x-input-error field_name="form.course_title" />
                                </div>
                                <div class="form-group @error('form.institute_name') am-invalid @enderror">
                                    <x-input-label style="color:black !important;" for="name" class="am-important"
                                        :value="__('education.university')" />
                                    <x-text-input wire:model="form.institute_name" id="institute_name"
                                        name="institute_name" placeholder="{{ __('education.university_placeholder') }}"
                                        type="text" autofocus autocomplete="name" />
                                    <x-input-error field_name="form.institute_name" />
                                </div>
                                <div class="form-group form-group-two-wrap">
                                    <div @class(['am-invalid'=> $errors->has('form.country')])>
                                        <x-input-label style="color:black !important;" for="country" class="am-important"
                                            :value="__('education.country')" />
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="@this" wire:key="{{ time() }}"
                                                class="am-custom-select" data-parent="#education-popup"
                                                data-searchable="true" data-wiremodel="form.country">
                                            </select>
                                        </span>
                                        <x-input-error field_name="form.country" />
                                    </div>
                                    <div class="@error('form.city') am-invalid @enderror">
                                        <x-input-label style="color:black !important;" class="am-important" for="country"
                                            :value="__('education.city')" />
                                        <x-text-input wire:model="form.city" id="city" name="city"
                                            placeholder="{{ __('education.city_placeholder') }}" autofocus
                                            autocomplete="name" />
                                        <x-input-error field_name="form.city" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-input-label  style="color:black !important;" for="name" class="am-important" :value="__('education.date')" />
                                    <div class="form-group-two-wrap">
                                        <div class="@error('form.start_date') am-invalid @enderror">
                                            <x-text-input wire:model="form.start_date" class="flat-date date"
                                                id="startdate" name="startdate"
                                                placeholder="{{ __('education.start_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" autofocus
                                                autocomplete="name" />
                                            <x-input-error field_name="form.start_date" />
                                        </div>
                                        <div class="@error('form.end_date') am-invalid @enderror">
                                            <x-text-input  wire:model="form.end_date" class="flat-date date"
                                                id="end_date" name="end_date"
                                                placeholder="{{ __('education.end_date_placeholder') }}"
                                                data-format="Y-m-d" type="text" id="datepicker" autofocus
                                                autocomplete="name" />
                                            <x-input-error field_name="form.end_date" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="am-checkbox">
                                        <input wire:model="form.ongoing" type="checkbox" id="ongoing">
                                        <label style="color:black !important;" for="ongoing">{{__('education.checkbox_title')}}</label>
                                        <x-input-error field_name="form.ongoing" />
                                    </div>
                                </div>
                                <div class="form-group @error('form.description') am-invalid @enderror">
                                    <div class="am-label-wrap">
                                        <x-input-label style="color:black !important;" class="am-important" for="description"
                                            :value="__('education.description')" />
                                        @if(setting('_ai_writer_settings.enable_on_education_settings') == '1')
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal"  data-prompt-type="education" data-parent-model-id="education-popup" data-target-selector="#description" data-target-summernote="true">
                                                <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                {{ __('general.write_with_ai') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="description" class="form-control" placeholder="{{ __('education.description_placeholder') }}">{!! $form->description !!}</textarea>
                                        <span class="total-characters">
                                            <div class='tu-input-counter'>
                                                <span>{{ __('general.char_left') }}:</span>
                                                <b>
                                                    {!! $MAX_PROFILE_CHAR - Str::length($form->description) !!}
                                                </b> <em>/ {{ $MAX_PROFILE_CHAR }}</em>
                                            </div>
                                        </span>
                                    </div>
                                    <x-input-error field_name="form.description" />
                                </div>
                                <div class="form-group am-form-btns">
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"
                                        wire:target="storeEducation">{{__('general.save_update')}}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>