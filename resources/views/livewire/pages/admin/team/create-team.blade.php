<main class="tb-main tb-forum-main tb-addblogcategory">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-4">
            <div class="tb-dhb-mainheading">
                <h4> {{ isset($teamMember) ? 'Editar Miembro' : 'Agregar Miembro' }}</h4>
            </div>
            <div class="tb-dbholder tb-packege-setting">
                <div class="tb-dbbox">
                    <div class="tk-themeform tk-themeform-blogs">
                        <fieldset>
                            <div class="tk-themeform__wrap">
                                <div class="tb-themeform-tags">
                                    
                                    {{-- FILA 1: Nombre y Apellido --}}
                                    <div class="form-group-wrap">
                                        <div class="form-group-half">
                                            <div class="form-group">
                                                <label class="tb-label tb-label-star">Nombre</label>
                                                <input type="text" class="form-control @error('name') tk-invalid @enderror" wire:model="name" placeholder="Ej: Juan">
                                                @error('name')
                                                    <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group-half">
                                            <div class="form-group">
                                                <label class="tb-label tb-label-star">Apellido</label>
                                                <input type="text" class="form-control @error('last_name') tk-invalid @enderror" wire:model="last_name" placeholder="Ej: Pérez">
                                                @error('last_name')
                                                    <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- FILA 2: Cargo --}}
                                    <div class="form-group">
                                        <label class="tb-label tb-label-star">Cargo / Rol</label>
                                        <input type="text" class="form-control @error('role') tk-invalid @enderror" wire:model="role" placeholder="Ej: CEO, Desarrollador Senior">
                                        @error('role')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>

                                    {{-- FILA 3: Selector de Plataforma (LOGOS) --}}
                                    <div class="form-group">
                                        <label class="tb-label">Plataforma (Red Social)</label>
                                        <div class="platform-selector-container">
                                            
                                            {{-- LinkedIn --}}
                                            <div class="platform-option" wire:click="$set('platform', 'linkedin')" title="LinkedIn">
                                                <img src="{{ asset('images/linkedin.png') }}" 
                                                     class="platform-img {{ $platform === 'linkedin' ? 'active' : '' }}" 
                                                     alt="linkedin">
                                            </div>

                                            {{-- GitHub --}}
                                            <div class="platform-option" wire:click="$set('platform', 'github')" title="GitHub">
                                                <img src="{{ asset('images/Github.png') }}" 
                                                     class="platform-img {{ $platform === 'github' ? 'active' : '' }}" 
                                                     alt="github">
                                            </div>

                                            {{-- Facebook --}}
                                            <div class="platform-option" wire:click="$set('platform', 'facebook')" title="Facebook">
                                                <img src="{{ asset('images/facebook.png') }}" 
                                                     class="platform-img {{ $platform === 'facebook' ? 'active' : '' }}" 
                                                     alt="facebook">
                                            </div>

                                        </div>
                                        
                                        {{-- Input oculto visualmente pero útil para depurar si hiciera falta, aquí solo mostramos error --}}
                                        @error('platform')
                                            <div class="tk-errormsg"><span>Debe seleccionar una plataforma</span></div>
                                        @enderror
                                        
                                        @if($platform)
                                            <small class="text-success mt-1 d-block">Seleccionado: <strong>{{ ucfirst($platform) }}</strong></small>
                                        @endif
                                    </div>

                                    {{-- FILA 4: Enlace del Perfil --}}
                                    <div class="form-group">
                                        <label class="tb-label">Enlace al Perfil</label>
                                        <input type="url" class="form-control @error('platform_link') tk-invalid @enderror" wire:model="platform_link" placeholder="https://linkedin.com/in/usuario">
                                        @error('platform_link')
                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SECCIÓN: Imagen (Lógica idéntica a Alianzas) --}}
                                <div class="form-group">
                                    <div class="form-group-wrap">
                                        <div class="form-group-half tb-group-wrap">
                                            <div class="form-group fw-form-group-image">
                                                <label class="tb-label tb-label-star">Foto de Perfil</label>
                                                <div class="form-group-half">
                                                    <div class="op-textcontent">
                                                        <ul class="op-upload-img">
                                                            <li class="op-upload-img-info">
                                                                <div class="op-uploads-img-data">
                                                                    <label> <em><i class="icon-plus"></i></em>
                                                                        <input type="file" id="photo" wire:model="photo" class="form-control">
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            
                                                            {{-- Imagen existente (Edición) --}}
                                                            @if (isset($teamMember) && $teamMember->photo && !$errors->has('photo') && !$photo)
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ url(Storage::url($teamMember->photo)) }}" alt="{{ $name }}" width="100">
                                                                        </figure>
                                                                    </div>
                                                                </li>
                                                            @endif

                                                            {{-- Imagen nueva (Previsualización) --}}
                                                            @if (!empty($photo) && !$errors->has('photo'))
                                                                <li class="op-upload-img-info op-img-thumbnail uploaded-img">
                                                                    <div class="op-upload-data">
                                                                        <figure>
                                                                            <img src="{{ $photo->temporaryUrl() }}" alt="{{ $name }}" width="100">
                                                                        </figure>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                        <span>{{ __('alianza.image_validation', ['extensions' => str_replace(',', ', ', $imageFileExt ?? 'jpg,png,webp'), 'size' => $imageFileSize ?? 5]) }}</span>
                                                        @error('photo')
                                                            <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- SECCIÓN: Estado y Orden --}}
                                <div class="form-group-wrap">
                                    
                                    {{-- Estado Switch --}}
                                    <div class="form-group-half">
                                        <div class="form-group fw-form-group-image">
                                            <label class="tb-label">{{ __('general.status') }}:</label>
                                            <div class="tb-email-status">
                                                <span>{{ $status ? 'Activo' : 'Inactivo' }}</span>
                                                <div class="tb-switchbtn">
                                                    <label for="status" class="tb-textdes">
                                                        <span id="tb-textdes">{{ $status ? 'Habilitado' : 'Deshabilitado' }}</span>
                                                    </label>
                                                    {{-- OJO: wire:model="status" directo --}}
                                                    <input wire:model.live="status" class="tb-checkaction" type="checkbox" id="status">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Orden --}}
                                    <div class="form-group-half">
                                        <div class="form-group">
                                            <label class="tb-label">{{ __('alianza.order') }}</label>
                                            <input 
                                                type="number" 
                                                class="form-control @error('order') tk-invalid @enderror" 
                                                wire:model="order" 
                                                min="1" 
                                                step="1" 
                                                placeholder="1" 
                                                required
                                            >
                                            @error('order')
                                                <div class="tk-errormsg"><span>{{ $message }}</span></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Botones de Acción --}}
                                <div class="form-group tb-dbtnarea">
                                    @if(isset($teamMember))
                                        <button wire:click.prevent="update" class="tb-btn">Actualizar Miembro</button>
                                    @else
                                        <button wire:click.prevent="store" class="tb-btn">Guardar Miembro</button>
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
    /* Estilos base del template */
    .tb-themeform .form-group { max-width: 100%; }
    .tb-themeform .form-control { width: 100%; }
    
    /* ESTILOS PARA EL SELECTOR DE PLATAFORMAS (LOGOS) */
    .platform-selector-container {
        display: flex;
        gap: 20px;
        align-items: center;
        padding: 10px 0;
    }

    .platform-option {
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 5px;
        border-radius: 8px;
        border: 2px solid transparent; /* Borde invisible por defecto */
    }

    /* Imagen base */
    .platform-img {
        width: 45px; /* Tamaño del logo */
        height: 45px;
        object-fit: contain;
        filter: grayscale(100%); /* En blanco y negro si no está seleccionado */
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    /* Hover: Un poco de color al pasar el mouse */
    .platform-option:hover .platform-img {
        filter: grayscale(0%);
        opacity: 0.8;
    }

    /* ESTADO ACTIVO (Seleccionado) */
    .platform-img.active {
        filter: grayscale(0%); /* Color completo */
        opacity: 1;
        transform: scale(1.1); /* Crece un poquito */
    }

    /* Borde opcional para el contenedor seleccionado */
    .platform-option:has(.active) {
        border-color: #22c55e; /* Color verde éxito o el color primario de tu tema */
        background-color: #f0fdf4;
    }

</style>
@endpush