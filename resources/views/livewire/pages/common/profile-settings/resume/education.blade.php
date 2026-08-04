<div class="am-resumebox_content" wire:init="loadData">
    @slot('title')
        {{ __('education.title') }}
    @endslot
    <div class="am-resumewrap">
        @if($isLoading)
        @include('skeletons.education')
    @else 
        @if(!$educations->isEmpty())
        <!-- @include('skeletons.education') -->
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2 data-translate="education_details">{{ __('education.education_details') }}</h2>
                    <p data-translate="education_message">{{ __('education.education_message') }}</p>
                </div>
                <button class="am-btn am-btnsmall" wire:click="addEducation" wire:loading.class="am-btn_disable">
                    <span data-translate="general_add_new">{{ __('general.add_new') }}</span>
                    <i class="am-icon-plus-02"></i>
                </button>
            </div>
            <div class="am-resume">
                @foreach($educations as $education)
                <div class="am-resume_item">
                    <div class="am-resume_item_title">
                        <h3>{{ $education->course_title }}</h3>
                       <div class="am-itemactions">
    <button type="button" class="am-btn am-btn-icon" wire:click="editEducation({{ $education }})" title="{{ __('general.edit') }}" data-translate-title="general_edit">
        <i class="am-icon-pencil-02"></i>
    </button>
    <button type="button" class="am-btn am-btn-icon"
        @click="$wire.dispatch('showConfirm', { id : {{ $education->id }}, action : 'delete-education' })"
        title="{{ __('general.delete') }}" data-translate-title="general_delete">
        <i class="am-icon-trash-02"></i>
    </button>
</div>
                        <div id="education-model-{{ $education->id }}" class="modal am-educationpopup" tabindex="-1"
                            role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="am-modal-header">
                                        <span data-translate="education_description">
                                            {{ __('education.education_description') }}
                                        </span>
                                        <span data-bs-dismiss="modal" class="am-closepopup">
                                            <i class="am-icon-multiply-01"></i>
                                        </span>
                                    </div>
                                    <div class="am-modal-body">
                                        <p>{{ $education->description }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="am-btn"
                                            x-on:click="$('#education-model-{{ $education->id }}').modal('hide')">
                                            <span data-translate="general_close_btn">
                                                {{ __('general.close_btn') }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="am-resume_item_info">
                        <li>
                            <span>
                                <i class="am-icon-book-1"></i>
                                {{ $education->institute_name }}
                            </span>
                        </li>
                        <li>
                            <span>
                                <i class="am-icon-location"></i>
                                {{ ucfirst($education->city) }}, {{ ucfirst($education->country->name) }}
                            </span>
                        </li>
                        <li>
                            <span>
                                <i class="am-icon-calender"></i>
                                {{ \Carbon\Carbon::parse($education->start_date)->translatedFormat('F Y') }} -
                                @if($education->ongoing)
                                    <span data-translate="general_current">{{ __('general.current') }}</span>
                                @else
                                    {{ \Carbon\Carbon::parse($education->end_date)->translatedFormat('F Y') }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
                @endforeach
    
            </div>
        @else
            <x-no-record :image="asset('images/education.png')" :title="__('general.no_record_title')"
                :description="__('general.no_record_desc')" :btn_text="__('education.add_new_education')"
                wire:click="addEducation" />
        @endif
    @endif       
       

         @include('livewire.pages.common.profile-settings.resume.components.modal_education')




    </div>
</div>
@push('styles')
@vite([
'public/css/flatpicker.css',
'public/summernote/summernote-lite.min.css',
'public/css/flatpicker-month-year-plugin.css'
])
@endpush

@push('scripts')
<script defer src="{{ asset('js/flatpicker.js') }}"></script>
<script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
<script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>

<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
        component = @this;
    });
    document.addEventListener('livewire:initialized', function() {      
        $(document).on('show.bs.modal','#education-popup', function () {
            initializeDatePicker()
            var initialContent = component.get('form.description');
            $('#description').summernote('destroy');
            $('#description').summernote(summernoteConfigs('#description', '.total-characters'));
            $('#description').summernote('code', initialContent);

            $(document).on('summernote.change', '#description', function(we, contents, $editable) {             
                component.set("form.description",contents, false);
                updateCharacterCounter();
            });
            updateCharacterCounter();
        });

        function updateCharacterCounter() {

            let contentLength = $('#description').summernote('code').replace(/(<([^>]+)>)/gi, "").length;
            let maxChars = {!! $MAX_PROFILE_CHAR !!};
            let charsLeft = maxChars - contentLength;
        
            $('.total-characters b').text(charsLeft);
        }

        document.addEventListener('initSelectTwo', (evt) => {
            let element = jQuery(evt.detail.target);
            if(element.data('select2')){
                element.val(evt.detail.id ?? '').trigger('change');
            } else {
                jQuery(evt.detail.target).select2({
                    data: evt.detail.data,
                    dropdownParent: jQuery('#education-popup')
                });
            }
        });

        jQuery(document).on('change', '.am-custom-select', function(e){
            component.set('form.country', jQuery('.am-custom-select').select2("val"), false);
        })

        document.addEventListener('loadPageJs', (event) => {
            component.dispatch('initSelect2', {target:'.am-select2'});
            setTimeout(() => {
                $('#description').summernote('destroy');
                $('#description').summernote(summernoteConfigs('#description','.total-characters'));
                initializeDatePicker()
            }, 500);
        })
    })
</script>
@endpush
