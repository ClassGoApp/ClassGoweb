<main class="tb-main tb-forum-main tb-addblogcategory">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-4">
            <div class="tb-dhb-mainheading">
                <h4> {{ isset($alianza) ? __('alianza.edit_alianza') : __('alianza.create_alianza') }}</h4>
            </div>
            <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox">
                    <div class="tk-themeform tk-themeform-blogs">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="tb-themeform-tags">
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star">{{ __('general.title') }}</label>
                                        <input type="text" class="form-control @error('titulo') tk-invalid @enderror" wire:model="titulo" placeholder="{{ __('alianza.title_placeholder') }}">
                                        @error('titulo')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('alianza.link') }}</label>
                                        <input type="url" class="form-control @error('enlace') tk-invalid @enderror" wire:model="enlace" placeholder="{{ __('alianza.link_placeholder') }}">
                                        @error('enlace')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="tk-blog-content">
                                        <h6 class="tb-label">{{ __('general.description') }}</h6>
                                        <div class="form-group">
                                            <div id="desc-meta" 
                                                data-max="224" 
                                                data-max-label="{{ __('alianza.description_limit', ['count' => 224]) }}" 
                                                data-limit-reached="{{ __('alianza.limit_reached') }}">
                                                <small class="text-muted d-block mb-1" id="desc-message">{{ __('alianza.description_limit', ['count' => 224]) }}</small>
                                                <textarea id="descripcion" maxlength="224" wire:model="descripcion" class="form-control w-100" rows="5" placeholder="{{ __('alianza.description_placeholder') }}"></textarea>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <small class="text-muted" id="desc-counter">0/224</small>
                                                    <small class="text-danger d-none" id="desc-warning">{{ __('alianza.limit_reached') }}</small>
                                                </div>
                                            </div>
                                            @error('descripcion')
                                                <div class="tk-errormsg">
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group-wrap">
                                        <div class="form-group-half tb-group-wrap">
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label tb-label-star">{{ __('alianza.image') }}</label>
                                                <div class="form-group-half">
                                                    <div class="op-textcontent">
                                                        <ul class="op-upload-img">
                                                            <li class="op-upload-img-info">
                                                                <div class="op-uploads-img-data">
                                                                    <label> <em><i class="icon-plus"></i></em>
                                                                        <input type="file" id="imagen" wire:model="imagen" class="form-control">
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            @if (isset($alianza) && $alianza->imagen && !$errors->has('imagen') && !$imagen)
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ url(Storage::url($alianza->imagen)) }}" alt="{{ $titulo }}" width="100">
                                                                        </figure>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                            @if (!empty($imagen) && !$errors->has('imagen'))
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ $imagen->temporaryUrl() }}" alt="{{ $titulo }}" width="100">
                                                                        </figure>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                        <span>{{ __('alianza.image_validation', ['extensions' => str_replace(',', ', ', $imageFileExt ?? 'jpg,png'), 'size' => $imageFileSize ?? 5]) }}</span>
                                                        @error('imagen')
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
                                                    <span>{{ __('alianza.active') }}</span>
                                                    <div class="tb-switchbtn">
                                                        <label for="status" class="tb-textdes"><span id="tb-textdes">{{ $activo ? __('alianza.active') : __('alianza.inactive') }}</span></label>
                                                        <input wire:change="updateActivo($event.target.checked)" class="tb-checkaction" type="checkbox" id="status" {{ $activo ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                @error('activo')
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
                                        <label class="tb-label">{{ __('alianza.order') }}</label>
                                        <input type="number" class="form-control @error('orden') tk-invalid @enderror" wire:model="orden" min="0" step="1" placeholder="0">
                                        @error('orden')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group tb-dbtnarea">
                                    @if(isset($alianza))
                                        <button wire:click.prevent="update" class="tb-btn">{{ __('alianza.update_alianza') }}</button>
                                    @else
                                        <button wire:click="store" class="tb-btn">{{ __('alianza.add_alianza') }}</button>
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
<style>
    /* Ensure description block uses full available width */
    #desc-meta { display: block; width: 100%; }
    #desc-meta #descripcion {
        width: 100% !important;
        min-width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        resize: vertical; /* prevent horizontal shrinking */
    }
    /* Make the counter/warning row not constrain width */
    #desc-meta .d-flex { width: 100%; }
    /* In case any parent sets inline-block widths */
    .tk-blog-content .form-group { width: 100%; }
    .tk-blog-content { width: 100%; }
    .tb-themeform .form-group { max-width: 100%; }
    .tb-themeform .form-control { width: 100%; }
    .tb-themeform .form-group textarea.form-control { width: 100%; }
    .tb-themeform .form-group input.form-control { width: 100%; }
</style>
@endpush
@push('scripts')
<script type="text/javascript" data-navigate-once>
    document.addEventListener('livewire:navigated', function() {
        const meta = document.getElementById('desc-meta');
        if (!meta) return;

        const textarea = document.getElementById('descripcion');
        const counter = document.getElementById('desc-counter');
        const warning = document.getElementById('desc-warning');
        const message = document.getElementById('desc-message');

        const MAX = parseInt(meta.getAttribute('data-max') || '224', 10);
        const maxLabel = meta.getAttribute('data-max-label') || '';
        const limitReached = meta.getAttribute('data-limit-reached') || '';

        function update() {
            let val = textarea.value || '';
            if (val.length > MAX) {
                val = val.substring(0, MAX);
                textarea.value = val;
            }
            const used = val.length;
            counter.textContent = `${used}/${MAX}`;
            if (used >= MAX) {
                warning.classList.remove('d-none');
                message.textContent = limitReached;
            } else {
                warning.classList.add('d-none');
                message.textContent = maxLabel;
            }
        }

        ['input','change','keyup','paste'].forEach(evt => textarea.addEventListener(evt, update));
        // initialize on load in case of edit
        update();
    });
</script>
@endpush
