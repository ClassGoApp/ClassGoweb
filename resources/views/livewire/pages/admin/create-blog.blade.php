<main class="tb-main tb-forum-main tb-addblogcategory" wire:init="loadData">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-4">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('blogs.add_blog') }}</h4>
                </div>
                <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox">
                    
                    <div class="tk-themeform tk-themeform-blogs">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="tb-themeform-tags">
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star">{{ __('general.title') }}</label>
                                        <input type="text" class="form-control @error('title') tk-invalid @enderror" wire:model="title" placeholder="{{ __('blogs.add_title') }}">
                                        @error('title')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    @if(!empty($blog))
                                        <div class="form-group">
                                            <label class="tb-label tb-label-star">{{ __('blogs.slug') }}</label>
                                            <input type="text" class="form-control @error('slug') tk-invalid @enderror" wire:model="slug" placeholder="{{ __('blogs.add_slug') }}">
                                            @error('slug')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span>
                                            </div>
                                            @enderror
                                        </div>
                                    @endif
                                    
                                </div>
                                <div class="tb-themeform-tags">
                                    <div class="form-group @error('category_ids') tk-invalid @enderror">
                                        <div class="form-group fw-forms-group">
                                            <label class="tb-label tb-label-star">{{ __('blogs.categories') }}</label>
                                            <select 
                                                class="categories form-control" 
                                                id="category_ids" 
                                                multiple
                                                wire:ignore
                                            >
                                            <option value="" disabled>{{ __('blogs.select_category') }}</option>
                                                @foreach ( $categories as $id => $category)
                                                    <option value="{{ $id }}" @if( in_array( $id, $selectedCategories) ) selected @endif>{{ $category }}</option>
                                                @endforeach
                                            </select>
                                            <div class="categoryList">
                                                {{-- Display selected categories --}}
                                            @if (!empty($selectedCategories))
                                                <div class="tb-form-tag mt-2">
                                                    @foreach ($selectedCategories as $categoryId)
                                                        @if(isset($categories[$categoryId]))
                                                            <span class="tb-tag">
                                                                <span>{{ $categories[$categoryId] }}</span>
                                                                <i class="icon-x removeSelectedCategory" data-id="{{ $categoryId }}"></i>
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        @error('category_ids')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div x-data="tagInput()" class="form-group">
                                        <label class="tb-label">{{ __('blogs.tags') }}</label>
                                        <input type="text" class="form-control" x-model="newTag" @keydown.enter.prevent="addTag" placeholder="{{ __('blogs.add_tags') }}">
                                        <div class="tb-form-tag">
                                            <template x-for="(tag, index) in tags" :key="index">
                                                <span class="tb-tag" data-has-alpine-state="true">
                                                    <span x-text="tag"></span>
                                                    <i class="icon-x" @click="removeTag(index)"></i>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="tk-blog-content">
                                        <h6 class="tb-label tb-label-star">{{__('blogs.blog_content')}}</h6>
                                        <div @error('description') class="tk-invalid tk-blog-form" @enderror>
                                            <div class="form-group am-custom-editor" wire:ignore>
                                                <textarea id="blog_desc" class="form-control summernote" >{{ $description }}</textarea>
                                            </div>
                                            @error('description')
                                                <div class="tk-errormsg">
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group-wrap">
                                        <div class="form-group-half tb-group-wrap ">
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label tb-label-star">{{ __('blogs.blog_image') }}</label>
                                                <div class="form-group-half">
                                                    <div class="op-textcontent">
                                                        <ul class="op-upload-img">
                                                            <li class="op-upload-img-info">
                                                                <div class="op-uploads-img-data">
                                                                    <label> <em><i class="icon-plus"></i></em>
                                                                        <input type="file" id="image" wire:model="image" class="form-control">
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li id="image-loader" class="op-upload-img-info img-loader d-none">
                                                            </li>
                                                            @if (!empty($image) && !$errors->has('image'))
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ $image->temporaryUrl() }}" alt="{{ $title }}" width="100"> 
                                                                        </figure>
                                                                        <div wire:click="removeImage" class="op-overlay-icon op-remove-file">
                                                                            <i class="icon-trash-2"></i>
                                                                        </div>
                                                                        <input type="hidden">
                                                                    </div>
                                                                </li>    
                                                            @elseif(!empty($blog->image))
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ url(Storage::url($blog->image)) }}" alt="{{ $title }}" width="100"> 
                                                                        </figure>
                                                                        <div wire:click="removeImage" class="op-overlay-icon op-remove-file">
                                                                            <i class="icon-trash-2"></i>
                                                                        </div>
                                                                        <input type="hidden">
                                                                    </div>
                                                                </li>   
                                                            @endif
                                                            
                                                        </ul>
                                                        <span>{{ __('blogs.blog_image_validation', ['extensions' => str_replace(',', ', ', $imageFileExt), 'size' => $imageFileSize]) }}. {{ __('blogs.blog_image_recommended') }}</span>            
                                                        @error('image')
                                                        <div class="tk-errormsg">
                                                            <span>{{ $message }}</span>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label">{{ __('general.status') }}:</label>
                                                <div class="tb-email-status">
                                                    <span>{{__('blogs.blog_status')}}</span>
                                                    <div class="tb-switchbtn">
                                                        <label for="tb-emailstatus" class="tb-textdes"><span id="tb-textdes">{{ $status == 'published' ? __('blogs.published') : __('blogs.published') }}</span></label>
                                                        <input wire:change="updateStatus($event.target.checked)" class="tb-checkaction" type="checkbox" id="status" {{ $status == 'published' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                @error('status')
                                                <div class="tk-errormsg">
                                                    <span>{{$message}}</span>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-wraps">
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star">{{ __('blogs.meta_title') }}</label>
                                        <input type="text" class="form-control @error('meta_title') tk-invalid @enderror" wire:model="meta_title" placeholder="{{ __('blogs.add_meta_title') }}">
                                        @error('meta_title')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                <div class="form-group">
                                <div class="tk-blog-content">
                                    <h6 class="tb-label tb-label-star">{{__('blogs.meta_description')}}</h6>
                                        <div class="form-group @error('meta_description') class="tk-invalid tk-blog-form" @enderror" wire:ignore>
                                            <textarea wire:model="meta_description" class="form-control" placeholder="{{ __('blogs.add_meta_description') }}">{{ $meta_description }}</textarea>
                                        </div>
                                        @error('meta_description')
                                            <div class="tk-errormsg">
                                                <span>{{ $message }}</span>
                                            </div>
                                        @enderror
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group tb-dbtnarea">
                                    @if(!empty($blog))  
                                        <button wire:click.prevent="update" class="tb-btn">
                                            {{__('blogs.update_blog') }}
                                        </button>
                                    @else
                                        <button wire:click="store" class="tb-btn">
                                            {{__('blogs.add_blog') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
    </div>
    </div>
</main>
@push('styles')
@vite([
'public/summernote/summernote-lite.min.css',
])
@endpush

@push('scripts')
<script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>

<script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = @this;

            // Initialize Select2 when categories are loaded
            window.addEventListener('initSelect2Categories', function(event) {
                setTimeout(function() {
                    initializeCategoriesSelect();
                }, 100);
            });

            document.addEventListener('loadPageJs', (event) => {
                jQuery('#blog_desc').summernote(summernoteConfigs('#blog_desc','.characters-count'));
            
                // Initialize categories select after a short delay
                setTimeout(function() {
                    initializeCategoriesSelect();
                }, 500);
            });

            function initializeCategoriesSelect() {
                if (jQuery('#category_ids').length) {
                    // Destroy existing Select2 if it exists
                    if (jQuery('#category_ids').hasClass('select2-hidden-accessible')) {
                        jQuery('#category_ids').select2('destroy');
                    }

                    // Initialize Select2
                    jQuery('#category_ids').select2({
                        placeholder: '{{ __("blogs.select_category") }}',
                        allowClear: true,
                        multiple: true,
                        width: '100%'
                    });

                    // Set initial values
                    var selectedCategories = @json($selectedCategories ?? []);
                    if (selectedCategories.length > 0) {
                        jQuery('#category_ids').val(selectedCategories).trigger('change.select2');
                    }
                }
            }

            jQuery('#blog_desc').on('summernote.paste', function(we, e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            });

            jQuery('#blog_desc').on('summernote.change', function(we, contents, $editable) {
                component.set("description", contents, false);
            });

            // Handle category selection changes
            jQuery(document).on("change", "#category_ids", function(e){
                var selectedCategories = $(this).val() || [];
                component.set('category_ids', selectedCategories);
                component.set('selectedCategories', selectedCategories);
            });

            // Handle category removal from visual display
            jQuery(document).delegate(".removeSelectedCategory", "click", function() {
                let id = jQuery(this).attr('data-id');
                let currentValues = jQuery('#category_ids').val() || [];
                let newValues = currentValues.filter(value => value !== id);
                
                jQuery('#category_ids').val(newValues).trigger('change');
            });

            document.addEventListener('livewire:initialized', function() {
                jQuery('#status').on('change', function(e) {
                    var status = $(this).val();
                });
            });

            function populateCategoryList(){
                let categories = jQuery('#category_ids').select2('data');
                var category_html = '<div class="tb-form-tag">';
                jQuery.each(categories, function(index, elem){
                    if (elem.id && elem.text) {
                        category_html += `<span class="tb-tag">
                                            <span>${elem.text}</span>
                                            <i class="icon-x removeSelectedCategory" data-id="${elem.id}"></i>
                                        </span>`;
                    }
                });
                category_html += '</div>';
                jQuery('.categoryList').html(category_html);
            }

            // Handle category removal
            jQuery(document).delegate(".removeSelectedCategory", "click", function() {
                let id = jQuery(this).attr('data-id');
                let currentValues = jQuery('#category_ids').val() || [];
                let newValues = currentValues.filter(value => value !== id);
                
                jQuery('#category_ids').val(newValues).trigger('change');
                component.set('category_ids', newValues);
                populateCategoryList();
            });


            document.addEventListener('livewire:initialized', function() {
            
                jQuery('#status').on('change', function(e) {
                    var status = $(this).val();
                });
            });
    });

    $(document).ready(function() {
        const imageInput = $('#image');
        const loader = $('#image-loader');

        imageInput.on('change', function() {
            if (this.files.length > 0) {
                loader.removeClass('d-none');
                jQuery('.uploaded-img').addClass('d-none');
            }
        });
    })
    
    function tagInput() {
        return {
            newTag: '',
            tags: @json($tags ?? []),
            errorMessage: '', // Add a property to store error messages
            addTag() {
                if (this.newTag.trim() !== '') {
                    if (!this.tags.includes(this.newTag)) {
                        this.tags.push(this.newTag.trim());
                        component.set('tags', this.tags);
                        this.newTag = '';
                        this.errorMessage = '';
                    } else {
                        component.dispatch('showAlertMessage', { type: 'error', message: @json(__('blogs.tag_already_added')) });
                    }
                }
            },
            removeTag(index) {
                this.tags.splice(index, 1);
                component.set('tags', this.tags);
            },
            checkDuplicateTags() {
                let uniqueTags = [...new Set(this.tags)];
                if (uniqueTags.length !== this.tags.length) {
                    this.tags = uniqueTags;
                    component.set('tags', this.tags);
                }
            }
        }
    }

        
</script>
@endpush



