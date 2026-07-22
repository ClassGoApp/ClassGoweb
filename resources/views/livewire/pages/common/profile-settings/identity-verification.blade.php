{{--
    Vista Blade para la verificación de identidad del usuario.
    Permite a usuarios (tutores y estudiantes) cargar información personal, dirección, documentos y fotos para su verificación.
    Integra select2, carga dinámica de estados según país, subida de archivos y validaciones Livewire.
    - Si $enableGooglePlaces == '1', usa Google Places para autocompletar dirección.
    - Si el usuario ya está verificado, muestra mensaje de éxito.
    - Si la verificación está pendiente, muestra mensaje de espera.
    - Si no hay verificación, muestra el formulario completo.
    - Incluye scripts para select2, flatpickr y Google Places.
--}}
<div class="am-profile-setting" wire:init="loadData">
    {{-- Título de la página --}}
    @slot('title')
        {{ __('identity.title') }}
    @endslot


    {{-- Tabs de navegación del perfil --}}
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="">
        {{-- Si el usuario no tiene verificación de identidad, muestra el formulario --}}
        @if (empty($identity))
            <div class="am-userid">
                <div class="am-title_wrap">
                    <div class="am-title">
                        <h2 style="color: black">{{ __('profile.identity_verification') }}</h2> {{-- Título principal --}}
                        <p style="color: black">{{ __('profile.identity_detail_desc') }}</p> {{-- Descripción --}}
                    </div>
                </div>
                <form wire:submit.prevent="updateInfo" class="am-themeform am-themeform_personalinfo">
                    @if ($isLoading)
                        {{-- Skeleton de carga mientras se obtienen los datos --}}
                        @include('skeletons.identity-verification')
                    @else
                        <fieldset x-data="{ flashErrors: false }"
                            @validation-failed.window="flashErrors = true; setTimeout(() => flashErrors = false, 2000);">



                            {{-- Campo: Fecha de nacimiento --}}

                            <div class="container-date-photo">

                                {{-- TARJETA FECHA DE NACIMIENTO: Libre de wire:ignore para poder parpadear y cambiar de color --}}
                                <div class="form-group mb-2 group-date-photo"
                                    style="background-color: {{ empty($form->dateOfBirth) || $errors->has('form.dateOfBirth') ? 'var(--secundary-color)' : 'var(--primary-color)' }} !important; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;"
                                    :class="{
                                        'prereq-card-flash': flashErrors &&
                                            {{ $errors->has('form.dateOfBirth') ? 'true' : 'false' }}
                                    }">

                                    {{-- Label con contraste garantizado --}}
                                    <x-input-label class="am-important fw-bold mb-2" style="color: #fff !important;"
                                        :value="__('profile.date_of_birth')" />

                                    {{-- El contenedor del calendario y el wire:ignore se mudan AQUÍ adentro para proteger solo al input --}}
                                    <div class="form-group-two-wrap" x-data="{
                                        fp: null,
                                        init() {
                                            if (window.flatpickr) {
                                                this.initFlatpickr();
                                            } else {
                                                this.loadAssets().then(() => this.initFlatpickr());
                                            }
                                        },
                                        async loadAssets() {
                                            if (!document.getElementById('fp-css')) {
                                                let link = document.createElement('link');
                                                link.id = 'fp-css';
                                                link.rel = 'stylesheet';
                                                link.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css';
                                                document.head.appendChild(link);
                                    
                                                let theme = document.createElement('link');
                                                theme.rel = 'stylesheet';
                                                theme.href = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css';
                                                document.head.appendChild(theme);
                                            }
                                            if (!window.flatpickr) {
                                                await new Promise((resolve) => {
                                                    let script = document.createElement('script');
                                                    script.src = 'https://cdn.jsdelivr.net/npm/flatpickr';
                                                    script.onload = resolve;
                                                    document.head.appendChild(script);
                                                });
                                                await new Promise((resolve) => {
                                                    let script = document.createElement('script');
                                                    script.src = 'https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js';
                                                    script.onload = resolve;
                                                    document.head.appendChild(script);
                                                });
                                            }
                                        },
                                        initFlatpickr() {
                                            this.fp = flatpickr(this.$refs.dobInput, {
                                                dateFormat: 'd/m/Y',
                                                allowInput: true,
                                                locale: 'es',
                                                disableMobile: true,
                                                onChange: (selectedDates, dateStr) => {
                                                    @this.set('form.dateOfBirth', dateStr);
                                                }
                                            });
                                        }
                                    }" wire:ignore>

                                        <div @class([
                                            'form-control_wrap',
                                            'am-invalid border-danger' => $errors->has('form.dateOfBirth'),
                                        ]) style="position: relative;">

                                            <x-text-input id="dob_mask" x-ref="dobInput" x-mask="99/99/9999"
                                                wire:model.blur="form.dateOfBirth" placeholder="DD/MM/AAAA"
                                                type="text" class="form-control" autocomplete="bday"
                                                style="padding-right: 42px; font-weight: 600; color: var(--primary-color) !important;" />

                                            <button type="button" @click="fp ? fp.open() : null"
                                                style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; display: flex; align-items: center; color: #1e293b;"
                                                onmouseover="this.style.color='#000'"
                                                onmouseout="this.style.color='#1e293b'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6">
                                                    </line>
                                                    <line x1="8" y1="2" x2="8" y2="6">
                                                    </line>
                                                    <line x1="3" y1="10" x2="21" y2="10">
                                                    </line>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- El mensaje de error queda fuera de wire:ignore para renderizarse en tiempo real --}}
                                    {{-- @error('form.dateOfBirth')
        <span style="color: #fff !important; background-color: rgba(239, 68, 68, 0.5); padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; margin-top: 10px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            {{ $message }}
        </span>
    @enderror --}}
                                </div>

                                {{-- Campo: Foto personal (Estructura original protegida con Fondo Inteligente y Animación) --}}
                                <div class="form-group mb-2 group-date-photo"
                                    wire:key="uploading-profile-photo-container"
                                    style="background-color: {{ empty($form->image) || $errors->has('form.image') ? 'var(--secundary-color)' : 'var(--primary-color)' }} !important; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;"
                                    :class="{
                                        'prereq-card-flash': flashErrors &&
                                            {{ $errors->has('form.image') ? 'true' : 'false' }}
                                    }">

                                    <x-input-label class="am-important fw-bold mb-2" style="color: #fff !important;"
                                        for="profile_photo" :value="__('profile.personal_photo')" />

                                    <div x-data="{
                                        isUploading: false,
                                        isDragging: false,
                                        showCamera: false,
                                        hasPhoto: {{ !empty($form->image) ? 'true' : 'false' }},
                                        isCameraSupported: 'mediaDevices' in navigator,
                                        stream: null,
                                        isCameraLoading: false,
                                        showLightbox: false,
                                        lightboxUrl: '',
                                    
                                        // --- CÁMARA, LINTERNA Y OBTURADOR ---
                                        facingMode: 'user', // Frontal por defecto (Selfie)
                                        flashMode: 'off',
                                        isFlashSupported: false,
                                        isProcessingPhoto: false,
                                        showShutter: false,
                                    
                                        uploadFile(file) {
                                            if (!file) return;
                                            this.isUploading = true;
                                    
                                            $wire.upload('form.image', file,
                                                () => {
                                                    this.isUploading = false;
                                                    this.hasPhoto = true;
                                                    this.stopCamera();
                                                    if (this.$refs.file_upload_image) this.$refs.file_upload_image.value = '';
                                                },
                                                (error) => {
                                                    this.isUploading = false;
                                                    this.isProcessingPhoto = false;
                                                    if (this.$refs.video) this.$refs.video.play();
                                                    alert('Error al subir la imagen. Intenta nuevamente.');
                                                }
                                            );
                                        },
                                        async startCamera() {
                                            this.isCameraLoading = true;
                                            this.isProcessingPhoto = false;
                                            this.showShutter = false;
                                            try {
                                                if (this.stream) this.stopCamera();
                                    
                                                // Mostrar contenedor de cámara de inmediato para transición fluida
                                                this.showCamera = true;
                                    
                                                this.stream = await navigator.mediaDevices.getUserMedia({
                                                    video: { facingMode: this.facingMode },
                                                    audio: false
                                                });
                                    
                                                this.$nextTick(() => {
                                                    if (this.$refs.video) this.$refs.video.srcObject = this.stream;
                                                });
                                    
                                                this.$nextTick(async () => {
                                                    try {
                                                        const track = this.stream.getVideoTracks()[0];
                                                        await new Promise(r => setTimeout(r, 120));
                                                        const capabilities = track.getCapabilities();
                                                        if (capabilities.torch) {
                                                            this.isFlashSupported = true;
                                                            this.applyFlashConstraint(track, this.flashMode);
                                                        } else {
                                                            this.isFlashSupported = false;
                                                        }
                                                    } catch (e) {
                                                        this.isFlashSupported = false;
                                                    }
                                                });
                                    
                                            } catch (err) {
                                                console.error(err);
                                                this.showCamera = false;
                                                alert('No se pudo acceder a la cámara.');
                                            } finally {
                                                this.isCameraLoading = false;
                                            }
                                        },
                                        toggleCamera() {
                                            this.facingMode = this.facingMode === 'user' ? 'environment' : 'user';
                                            this.startCamera();
                                        },
                                        stopCamera() {
                                            if (this.stream) {
                                                this.stream.getTracks().forEach(track => track.stop());
                                                this.stream = null;
                                            }
                                            this.showCamera = false;
                                            this.isFlashSupported = false;
                                            this.flashMode = 'off';
                                            this.isProcessingPhoto = false;
                                        },
                                        takePhoto() {
                                            const video = this.$refs.video;
                                            const canvas = this.$refs.canvas;
                                    
                                            if (!video || video.paused || video.ended || this.isProcessingPhoto) return;
                                            this.isProcessingPhoto = true;
                                    
                                            this.showShutter = true;
                                            setTimeout(() => { this.showShutter = false; }, 150);
                                    
                                            video.pause();
                                    
                                            canvas.width = video.videoWidth;
                                            canvas.height = video.videoHeight;
                                            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                                    
                                            canvas.toBlob((blob) => {
                                                if (!blob) {
                                                    this.isProcessingPhoto = false;
                                                    if (video) video.play();
                                                    return;
                                                }
                                                const file = new File([blob], 'captura_personal.jpg', { type: 'image/jpeg' });
                                                this.uploadFile(file);
                                            }, 'image/jpeg', 0.95);
                                        },
                                        toggleFlash() {
                                            this.flashMode = this.flashMode === 'off' ? 'on' : 'off';
                                            if (this.stream) {
                                                const track = this.stream.getVideoTracks()[0];
                                                this.applyFlashConstraint(track, this.flashMode);
                                            }
                                        },
                                        async applyFlashConstraint(track, mode) {
                                            try {
                                                await track.applyConstraints({
                                                    advanced: [{ torch: mode === 'on' }]
                                                });
                                            } catch (e) {}
                                        }
                                    }" wire:ignore.self class="position-relative"
                                        :style="isUploading ? 'min-height: 180px;' : ''">

                                        {{-- CONTENEDOR PROTEGIDO --}}
                                        <div wire:ignore>
                                            {{-- 1. Zona Principal: Arrastrar/Soltar + Opción de Cámara --}}
                                            <div class="w-100" x-show="!hasPhoto && !showCamera">
                                                <div
                                                    class="am-uploadoption overflow-hidden position-relative rounded w-100">
                                                    <div class="tk-draganddrop border rounded d-flex flex-column align-items-center justify-content-center"
                                                        x-bind:class="{ 'am-dragfile bg-light border-primary': isDragging, 'am-uploading': isUploading }"
                                                        x-on:dragover.prevent="isDragging = true"
                                                        x-on:dragleave.prevent="isDragging = false"
                                                        x-on:drop.prevent="isDragging = false; uploadFile($event.dataTransfer.files[0])"
                                                        style="border-style: dashed !important; border-color: rgba(255,255,255,0.3) !important; background: rgba(255, 255, 255, 1); transition: all 0.2s ease; padding:0.3rem;">

                                                        <x-text-input name="file" type="file" id="at_upload_photo"
                                                            x-ref="file_upload_image"
                                                            class="position-absolute opacity-0"
                                                            style="width: 1px; height: 1px;"
                                                            accept="{{ !empty($allowImgFileExt)? join(',',array_map(function ($ex) {return '.' . $ex;}, $allowImgFileExt)): 'image/*' }}"
                                                            x-on:change="uploadFile($refs.file_upload_image.files[0])" />

                                                        <label for="at_upload_photo"
                                                            class="am-upload-file-photo mb-0 cursor-pointer text-center w-100">
                                                            <span
                                                                class="am-dropfileshadow d-flex flex-column align-items-center mb-2">
                                                                <i class="am-icon-plus-02 mb-2"
                                                                    style="font-size: 1.5rem; opacity: 0.9;"></i>
                                                                <span
                                                                    class="fw-medium">{{ __('general.drop_file_here') }}</span>
                                                            </span>
                                                            <span class="d-block text-opacity-75 small">
                                                                {{ __('general.drop_file_here_or') }} <span
                                                                    class="fw-bold text-decoration-underline">{{ __('general.click_here_file') }}</span>
                                                            </span>
                                                        </label>

                                                        <template x-if="isCameraSupported">
                                                            {{-- Botón para Iniciar Cámara con Animación de Carga --}}
                                                            <button type="button" @click="startCamera()"
                                                                :class="isCameraLoading ? 'camera-btn-loading' : ''"
                                                                class="mt-3 px-3 py-1.5 rounded-pill border bg-white text-dark d-inline-flex align-items-center gap-2"
                                                                style="font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: background 0.2s; border: solid 1px #000000 !important">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="14" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                                                    </path>
                                                                    <circle cx="12" cy="13" r="4">
                                                                    </circle>
                                                                </svg>
                                                                Usar cámara web
                                                            </button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 2. Interfaz de la Cámara --}}
                                            <div x-show="showCamera" x-transition
                                                class="border rounded bg-dark text-center overflow-hidden mx-auto"
                                                :class="{ 'd-flex flex-column': showCamera }"
                                                style="display: none; max-width: 450px; border-color: rgba(255, 255, 255, 0.15) !important;">

                                                {{-- Pantalla de Video (Proporción 4:3) --}}
                                                <div class="position-relative w-100 bg-black"
                                                    style="aspect-ratio: 4/3; overflow: hidden;">
                                                    <video x-ref="video" autoplay playsinline
                                                        class="position-absolute top-0 start-0 w-100 h-100"
                                                        style="object-fit: cover;"></video>

                                                    {{-- ⚡ EFECTO OBTURADOR BLANCO --}}
                                                    <div x-show="showShutter" x-transition.opacity.duration.150ms
                                                        class="position-absolute top-0 start-0 w-100 h-100 bg-white"
                                                        style="display: none; z-index: 10; opacity: 0.85;">
                                                    </div>
                                                </div>

                                                <canvas x-ref="canvas" style="display:none;"></canvas>

                                                {{-- Franja de Controles Inferior --}}
                                                <div class="d-flex justify-content-center align-items-center p-3 w-100 position-relative"
                                                    style="background: #1e293b; border-top: 1px solid rgba(255, 255, 255, 0.1); min-height: 80px;">

                                                    <div
                                                        class="w-100 d-flex justify-content-center align-items-center position-relative">

                                                        {{-- 🔄 Botón Voltear Cámara --}}
                                                        <button type="button" @click="toggleCamera()"
                                                            class="position-absolute"
                                                            style="left: 15px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); width: 38px; height: 38px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                            onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                                                            onmouseout="this.style.background='rgba(255,255,255,0.1)'"
                                                            title="Voltear cámara">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path
                                                                    d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                                                            </svg>
                                                        </button>

                                                        {{-- 📸 Botón Capturar --}}
                                                        <button class="take-photo" type="button"
                                                            @click="takePhoto()"
                                                            style="transform: scale(1); transition: transform 0.1s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.4);"
                                                            onmousedown="this.style.transform='scale(0.92)'"
                                                            onmouseup="this.style.transform='scale(1)'">
                                                            <div
                                                                style="width: 42px; height: 42px; border-radius: 50%; border: 3px solid #000; background: #fff;">
                                                            </div>
                                                        </button>

                                                        {{-- 🔦 Botón Linterna --}}
                                                        <template x-if="isFlashSupported">
                                                            <button type="button" @click="toggleFlash()"
                                                                class="position-absolute"
                                                                style="right: 60px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); width: 38px; height: 38px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                                onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                                                                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                                                                <svg x-show="flashMode === 'off'"
                                                                    xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#9ca3af" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M18 10L16 3H8L6 10l3 3h6l3-3z" />
                                                                    <path
                                                                        d="M9 13v7a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-7" />
                                                                    <line x1="12" y1="7"
                                                                        x2="12.01" y2="7" />
                                                                    <line x1="3" y1="3"
                                                                        x2="21" y2="21"
                                                                        stroke="#ef4444" stroke-width="2" />
                                                                </svg>
                                                                <svg x-show="flashMode === 'on'"
                                                                    xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#facc15" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M18 10L16 3H8L6 10l3 3h6l3-3z"
                                                                        fill="#facc15" fill-opacity="0.3" />
                                                                    <path
                                                                        d="M9 13v7a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-7" />
                                                                    <circle cx="12" cy="6.5" r="1"
                                                                        fill="#facc15" />
                                                                    <line x1="12" y1="1"
                                                                        x2="12" y2="2"
                                                                        stroke="#facc15" stroke-width="2" />
                                                                    <line x1="6" y1="1"
                                                                        x2="7" y2="2"
                                                                        stroke="#facc15" stroke-width="2" />
                                                                    <line x1="18" y1="1"
                                                                        x2="17" y2="2"
                                                                        stroke="#facc15" stroke-width="2" />
                                                                </svg>
                                                            </button>
                                                        </template>

                                                        {{-- ❌ Botón Cerrar Cámara (Extremo Derecho) --}}
                                                        <button class="stop-camera position-absolute" type="button"
                                                            @click="stopCamera()"
                                                            style="right: 15px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); width: 38px; height: 38px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                            onmouseover="this.style.background='rgba(239, 68, 68, 0.85)'; this.style.borderColor='#ef4444';"
                                                            onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='rgba(255, 255, 255, 0.25)';">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2.5"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
                                                            </svg>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 3. Cortina de Carga (Para archivos subidos desde galería) --}}
                                            <div class="position-absolute top-0 start-0 w-100 h-100 rounded flex-column align-items-center justify-content-center bg-white d-none"
                                                :class="isUploading ? 'd-flex' : 'd-none'"
                                                style="z-index: 99; background-color: rgba(255, 255, 255, 0.95) !important; border-radius: 10px;">
                                                <div class="spinner-border text-primary mb-2" role="status"
                                                    style="width: 2.2rem; height: 2.2rem; border-width: 0.22em;"></div>
                                                <span class="text-primary fw-bold small"
                                                    style="letter-spacing: 0.5px;">Subiendo...</span>
                                            </div>
                                        </div>

                                        {{-- 4. Vista previa de la imagen subida --}}
                                        <div wire:key="photo-preview-container-block"
                                            class="container-photo-preview w-100">

                                            @if (!empty($form->image))
                                                <div class="am-uploaded-file rounded align-items-center shadow-sm w-100 flex-column"
                                                    x-show="hasPhoto" style="max-width: 320px; background: none;">

                                                    {{-- Caja de foto con proporción 4:3 unificada --}}
                                                    <div class="photo-preview-wrapper border shadow-sm w-100"
                                                        @click="showLightbox = true; lightboxUrl = '{{ method_exists($form?->image, 'temporaryUrl') ? $form?->image->temporaryUrl() : (setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form?->image))) }}'">

                                                        @if (method_exists($form?->image, 'temporaryUrl'))
                                                            <img src="{{ $form?->image->temporaryUrl() }}"
                                                                class="w-100 h-100 object-fit-cover rounded">
                                                        @else
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form?->image)) }}"
                                                                class="w-100 h-100 object-fit-cover rounded" />
                                                        @endif

                                                        <div class="photo-hover-overlay">Click para ver</div>
                                                    </div>

                                                    {{-- 🔄 NUEVO BOTÓN: Elimina servidor + Oculta vista + Abre cámara directo --}}
                                                    <a href="#"
                                                        @click.prevent="$wire.removeMedia('personal_photo'); hasPhoto = false; startCamera();"
                                                        class="am-delitem text-danger border border-danger rounded-circle d-flex align-items-center justify-content-center mt-2"
                                                        style="width: 38px; height: 38px; background: #fff; transition: all 0.2s ease;"
                                                        onmouseover="this.style.background='#fff5f5'; this.style.transform='scale(1.08)';"
                                                        onmouseout="this.style.background='#fff'; this.style.transform='scale(1)';"
                                                        title="Reemplazar foto">
                                                        <i class="am-icon-trash-02" style="font-size: 1.15rem;"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- 5. VISUALIZADOR MODAL LIGHTBOX --}}
                                        <div x-show="showLightbox" x-transition
                                            class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
                                            :class="{ 'd-flex': showLightbox, 'd-none': !showLightbox }"
                                            style="z-index: 10000; background: rgba(0,0,0,0.85); padding: 20px; display: none;"
                                            @click="showLightbox = false"
                                            @keydown.escape.window="showLightbox = false">

                                            <button type="button" @click="showLightbox = false"
                                                class="position-absolute top-0 end-0 m-4"
                                                style="background: none; border: none; color: #fff; cursor: pointer; z-index: 10001;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6"
                                                        y2="18"></line>
                                                    <line x1="6" y1="6" x2="18"
                                                        y2="18"></line>
                                                </svg>
                                            </button>

                                            @if (!empty($form->image))
                                                <img src="{{ method_exists($form?->image, 'temporaryUrl') ? $form?->image->temporaryUrl() : (setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : url(Storage::url($form?->image))) }}"
                                                    class="rounded shadow-lg"
                                                    style="max-width: 90%; max-height: 85vh; object-fit: contain;"
                                                    @click.stop>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <style>
                                    .container-date-photo {
                                        display: flex;
                                        gap: 20px;
                                    }

                                    .container-photo-preview {
                                        display: flex;
                                        flex-direction: column;
                                        justify-content: center;
                                        align-items: center;
                                    }

                                    /* PROPORCIÓN UNIFICADA 4:3 (Misma medida que la cámara) */
                                    .photo-preview-wrapper {
                                        position: relative;
                                        width: 100%;
                                        max-width: 280px;
                                        aspect-ratio: 4 / 3;
                                        cursor: pointer;
                                        overflow: hidden;
                                        border-radius: 12px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        background-color: #f9fafb;
                                    }

                                    .photo-hover-overlay {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 100%;
                                        height: 100%;
                                        background: rgba(0, 0, 0, 0.65);
                                        backdrop-filter: blur(2px);
                                        color: #fff;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        text-align: center;
                                        font-size: 0.75rem;
                                        font-weight: 700;
                                        letter-spacing: 0.3px;
                                        opacity: 0;
                                        transition: opacity 0.2s ease-in-out;
                                        border-radius: 12px;
                                    }

                                    .photo-preview-wrapper:hover .photo-hover-overlay {
                                        opacity: 1;
                                    }

                                    .am-uploaded-file {
                                        display: flex;
                                        background: none;
                                        align-items: center;
                                    }

                                    .am-upload-file-photo {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }

                                    /* 🔄 ANIMACIÓN DE CARGA PARA EL BOTÓN DE ABRIR CÁMARA */
                                    @keyframes camera-btn-spinner {
                                        0% {
                                            transform: rotate(0deg);
                                        }

                                        100% {
                                            transform: rotate(360deg);
                                        }
                                    }

                                    .camera-btn-loading {
                                        pointer-events: none;
                                        background-color: #f3f4f6 !important;
                                        color: #000 !important;
                                    }

                                    .camera-btn-loading svg {
                                        display: none !important;
                                    }

                                    .camera-btn-loading::before {
                                        content: "";
                                        width: 14px;
                                        height: 14px;
                                        border: 2px solid #d1d5db;
                                        border-left-color: #3b82f6;
                                        border-radius: 50%;
                                        display: inline-flex;
                                        animation: camera-btn-spinner 0.6s linear infinite;
                                    }

                                    /* ⚠️ ANIMACIÓN DE VIBRACIÓN DE ERRORES */
                                    @keyframes prereq-pulse-error {
                                        0% {
                                            border-color: rgba(255, 255, 255, 0.1);
                                            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                        }

                                        25% {
                                            border-color: #ff0000;
                                            box-shadow: 0 0 0 8px rgba(255, 0, 0, 0.65);
                                        }

                                        50% {
                                            border-color: rgba(255, 255, 255, 0.1);
                                            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                        }

                                        75% {
                                            border-color: #ff0000;
                                            box-shadow: 0 0 0 8px rgba(255, 0, 0, 0.65);
                                        }

                                        100% {
                                            border-color: rgba(255, 255, 255, 0.1);
                                            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                        }
                                    }

                                    .prereq-card-flash {
                                        animation: prereq-pulse-error 1.3s ease-in-out infinite !important;
                                    }

                                    /* 📱 RESPONSIVO MÓVIL */
                                    @media (max-width: 767px) {
                                        .container-date-photo {
                                            flex-direction: column;
                                            gap: 0;
                                        }

                                        .photo-preview-wrapper {
                                            max-width: 280px !important;
                                            aspect-ratio: 4 / 3 !important;
                                        }
                                    }
                                </style>

                            </div>




                            {{-- Documentos adicionales según rol (tutor/estudiante) --}}
                            @if ($user->hasRole('tutor'))
                                {{-- Campo: Cédula de Identidad (Estructura Premium con Fondos Inteligentes y Funciones JavaScript Corregidas) --}}
                                <div class="form-group mb-2 group-date-photo"
                                    wire:key="uploading-profile-photo-container"
                                    style="background-color: {{ empty($form->identificationCardFront) || empty($form->identificationCardBack) || $errors->has('form.identificationCardFront') || $errors->has('form.identificationCardBack') ? 'var(--secundary-color)' : 'var(--primary-color)' }} !important; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;"
                                    :class="{
                                        'prereq-card-flash': flashErrors &&
                                            {{ $errors->has('form.identificationCardFront') || $errors->has('form.identificationCardBack') ? 'true' : 'false' }}
                                    }">

                                    {{-- Label original en color blanco --}}
                                    <x-input-label class="am-important fw-bold mb-2" style="color: #fff !important;"
                                        :value="__('profile.identification_card')" />

                                    <div x-data="{
                                        step: 'init',
                                        openCameraModal: false,
                                        openUploadModal: false,
                                        cameraStep: 'front_capture',
                                        showCamera: false,
                                        currentSide: 'front',
                                        isCameraLoading: false,
                                        isCameraSupported: 'mediaDevices' in navigator,
                                        stream: null,
                                        lightboxUrl: '',
                                        facingMode: 'environment', // Por defecto cámara trasera para documentos
                                    
                                        // --- CONTROL DE FLASH, OBTURADOR Y GALERÍA ---
                                        flashMode: 'off',
                                        isFlashSupported: false,
                                        isProcessingPhoto: false,
                                        showShutter: false,
                                        isUploadingFront: false,
                                        isUploadingBack: false,
                                        frontPreview: '{{ $form->identificationCardFront ? (method_exists($form->identificationCardFront, 'temporaryUrl') ? $form->identificationCardFront->temporaryUrl() : url(Storage::url($form->identificationCardFront))) : '' }}',
                                        backPreview: '{{ $form->identificationCardBack ? (method_exists($form->identificationCardBack, 'temporaryUrl') ? $form->identificationCardBack->temporaryUrl() : url(Storage::url($form->identificationCardBack))) : '' }}',
                                    
                                        uploadMethod: '{{ !empty($form->identificationCardFront) ? 'gallery' : '' }}',
                                    
                                        hasFront: {{ !empty($form->identificationCardFront) ? 'true' : 'false' }},
                                        hasBack: {{ !empty($form->identificationCardBack) ? 'true' : 'false' }},
                                    
                                        init() {
                                            this.evaluateGlobalStep();
                                        },
                                        evaluateGlobalStep() {
                                            if (this.hasFront && this.hasBack) {
                                                this.step = 'completed';
                                            } else {
                                                this.step = 'init';
                                            }
                                        },
                                        async startCamera(side) {
                                            this.currentSide = side;
                                            this.isCameraLoading = true;
                                            this.isProcessingPhoto = false;
                                            this.showShutter = false;
                                            try {
                                                if (this.stream) this.stopCamera();
                                    
                                                this.stream = await navigator.mediaDevices.getUserMedia({
                                                    video: { facingMode: this.facingMode },
                                                    audio: false
                                                });
                                    
                                                this.showCamera = true;
                                                this.$nextTick(() => { this.$refs.idVideo.srcObject = this.stream; });
                                    
                                                this.$nextTick(async () => {
                                                    try {
                                                        const track = this.stream.getVideoTracks()[0];
                                                        await new Promise(r => setTimeout(r, 120));
                                                        const capabilities = track.getCapabilities();
                                    
                                                        if (capabilities.torch) {
                                                            this.isFlashSupported = true;
                                                            this.applyFlashConstraint(track, this.flashMode);
                                                        } else {
                                                            this.isFlashSupported = false;
                                                        }
                                                    } catch (e) {
                                                        this.isFlashSupported = false;
                                                    }
                                                });
                                    
                                            } catch (err) {
                                                console.error(err);
                                                alert('No se pudo acceder a la cámara seleccionada.');
                                                this.openCameraModal = false;
                                            } finally {
                                                this.isCameraLoading = false;
                                            }
                                        },
                                        toggleCamera() {
                                            this.facingMode = this.facingMode === 'user' ? 'environment' : 'user';
                                            this.startCamera(this.currentSide);
                                        },
                                        stopCamera() {
                                            if (this.stream) {
                                                this.stream.getTracks().forEach(track => track.stop());
                                                this.stream = null;
                                            }
                                            this.showCamera = false;
                                            this.isFlashSupported = false;
                                            this.isProcessingPhoto = false;
                                        },
                                        takePhoto() {
                                            const video = this.$refs.idVideo;
                                            const canvas = this.$refs.idCanvas;
                                    
                                            if (!video || video.paused || video.ended || this.isProcessingPhoto) return;
                                    
                                            this.isProcessingPhoto = true;
                                    
                                            // 📸 EFECTO VISUAL DE OBTURADOR (Flash blanco rápido)
                                            this.showShutter = true;
                                            setTimeout(() => { this.showShutter = false; }, 150);
                                    
                                            video.pause();
                                    
                                            canvas.width = video.videoWidth;
                                            canvas.height = video.videoHeight;
                                            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                                    
                                            canvas.toBlob((blob) => {
                                                if (!blob) {
                                                    this.isProcessingPhoto = false;
                                                    if (video) video.play();
                                                    return;
                                                }
                                                const file = new File([blob], `id_${this.currentSide}.jpg`, { type: 'image/jpeg' });
                                                this.uploadPhoto(file, this.currentSide);
                                            }, 'image/jpeg', 0.95);
                                        },
                                        toggleFlash() {
                                            this.flashMode = this.flashMode === 'off' ? 'on' : 'off';
                                            if (this.stream) {
                                                const track = this.stream.getVideoTracks()[0];
                                                this.applyFlashConstraint(track, this.flashMode);
                                            }
                                        },
                                        async applyFlashConstraint(track, mode) {
                                            try {
                                                await track.applyConstraints({
                                                    advanced: [{ torch: mode === 'on' }]
                                                });
                                            } catch (e) {
                                                console.error('Error al cambiar linterna:', e);
                                            }
                                        },
                                        uploadPhoto(file, side) {
                                            if (!file) return;
                                            let targetProperty = side === 'front' ? 'form.identificationCardFront' : 'form.identificationCardBack';
                                    
                                            if (side === 'front') {
                                                this.isUploadingFront = true;
                                                this.frontPreview = URL.createObjectURL(file);
                                            } else {
                                                this.isUploadingBack = true;
                                                this.backPreview = URL.createObjectURL(file);
                                            }
                                    
                                            $wire.upload(targetProperty, file,
                                                () => {
                                                    this.stopCamera();
                                                    if (side === 'front') {
                                                        this.hasFront = true;
                                                        this.isUploadingFront = false;
                                                        if (this.openCameraModal) this.cameraStep = 'front_confirm';
                                                    } else {
                                                        this.hasBack = true;
                                                        this.isUploadingBack = false;
                                                        if (this.openCameraModal) this.cameraStep = 'back_confirm';
                                                    }
                                                    this.evaluateGlobalStep();
                                                },
                                                () => {
                                                    if (side === 'front') {
                                                        this.isUploadingFront = false;
                                                        this.frontPreview = '';
                                                    } else {
                                                        this.isUploadingBack = false;
                                                        this.backPreview = '';
                                                    }
                                                    this.isProcessingPhoto = false;
                                                    if (this.$refs.idVideo) this.$refs.idVideo.play();
                                                    alert('Error al subir la imagen.');
                                                }
                                            );
                                        },
                                        resetSide(side) {
                                            if (side === 'front') {
                                                $wire.set('form.identificationCardFront', null);
                                                this.hasFront = false;
                                                this.frontPreview = '';
                                            } else {
                                                $wire.set('form.identificationCardBack', null);
                                                this.hasBack = false;
                                                this.backPreview = '';
                                            }
                                            this.evaluateGlobalStep();
                                        },
                                        triggerChangePhotos() {
                                            if (this.uploadMethod === 'camera') {
                                                this.openCameraModal = true;
                                                this.cameraStep = 'front_capture';
                                                this.startCamera('front');
                                            } else {
                                                this.openUploadModal = true;
                                            }
                                        },
                                        resetAll() {
                                            this.resetSide('front');
                                            this.resetSide('back');
                                            this.uploadMethod = '';
                                            this.step = 'init';
                                        }
                                    }" x-init="init()" wire:ignore.self
                                        class="w-100">

                                        {{-- 1. PANTALLA PRINCIPAL: ESTADO INICIAL --}}
                                        <div :class="{ 'd-block': step === 'init', 'd-none': step !== 'init' }"
                                            style="display: none;" x-transition>
                                            <p class="small mb-3" style="color: rgba(255, 255, 255, 0.9) !important;">
                                                Para completar tu verificación es necesario capturar o subir ambas caras
                                                de tu documento.</p>
                                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                <button type="button"
                                                    @click="uploadMethod = 'gallery'; openUploadModal = true;"
                                                    class="btn btn-outline-light btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                                    Subir desde Galería
                                                </button>
                                                <template x-if="isCameraSupported">
                                                    <button type="button"
                                                        @click="uploadMethod = 'camera'; openCameraModal = true; cameraStep = 'front_capture'; startCamera('front');"
                                                        class="btn btn-light btn-sm rounded-pill px-4 d-flex align-items-center gap-2 shadow-sm fw-bold text-dark"
                                                        :class="isCameraLoading ? 'camera-btn-loading' : ''"
                                                        style="border: none !important;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5">
                                                            <path
                                                                d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                                            </path>
                                                            <circle cx="12" cy="13" r="4"></circle>
                                                        </svg>
                                                        Usar Cámara Web
                                                    </button>
                                                </template>

                                            </div>
                                        </div>

                                        {{-- 2. PANTALLA PRINCIPAL: AMBAS FOTOS CARGADAS CON ÉXITO --}}
                                        <div :class="{ 'd-flex flex-column align-items-center': step === 'completed', 'd-none': step !== 'completed' }"
                                            style="display: none;" x-transition>
                                            <h6 class="fw-bold mb-3 d-flex align-items-center justify-content-center gap-2"
                                                style="color: #fff !important;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="#2ecc71"
                                                    stroke-width="3">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                Documento de Identidad Cargado
                                            </h6>

                                            <div class="d-flex justify-content-center flex-wrap gap-4 w-100">
                                                {{-- Miniatura Frente --}}
                                                <div class="d-flex flex-column align-items-center w-100-mobile flex-fill"
                                                    style="max-width: 280px;">
                                                    <span class="small fw-bold mb-1"
                                                        style="color: rgba(255,255,255,0.85) !important;">Cara
                                                        Frontal</span>
                                                    <div class="id-preview-box-centered border border-white border-opacity-25 shadow-sm w-100"
                                                        @click="lightboxUrl = $refs.finalImgFront.src">
                                                        <img x-ref="finalImgFront"
                                                            src="{{ $form->identificationCardFront ? (method_exists($form->identificationCardFront, 'temporaryUrl') ? $form->identificationCardFront->temporaryUrl() : url(Storage::url($form->identificationCardFront))) : '' }}"
                                                            class="w-100 h-100 object-fit-cover rounded">
                                                        <div class="id-hover-overlay">Click para ver</div>
                                                    </div>
                                                </div>

                                                {{-- Miniatura Reverso --}}
                                                <div class="d-flex flex-column align-items-center w-100-mobile flex-fill"
                                                    style="max-width: 280px;">
                                                    <span class="small fw-bold mb-1"
                                                        style="color: rgba(255,255,255,0.85) !important;">Cara
                                                        Reverso</span>
                                                    <div class="id-preview-box-centered border border-white border-opacity-25 shadow-sm w-100"
                                                        @click="lightboxUrl = $refs.finalImgBack.src">
                                                        <img x-ref="finalImgBack"
                                                            src="{{ $form->identificationCardBack ? (method_exists($form->identificationCardBack, 'temporaryUrl') ? $form->identificationCardBack->temporaryUrl() : url(Storage::url($form->identificationCardBack))) : '' }}"
                                                            class="w-100 h-100 object-fit-cover rounded">
                                                        <div class="id-hover-overlay">Click para ver</div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- BOTONES UX CENTRALIZADOS --}}
                                            <div class="d-flex justify-content-center gap-3 mt-4 w-100">
                                                <button type="button" @click="resetAll()"
                                                    class="btn-new btn-sm btn-outline-danger px-4 rounded-pill shadow-sm fw-bold">
                                                    Empezar de nuevo
                                                </button>
                                                <button type="button" @click="triggerChangePhotos()"
                                                    class="btn btn-sm btn-light  px-4 rounded-pill fw-bold shadow-sm"
                                                    style="border: none !important;">
                                                    Cambiar fotos
                                                </button>
                                            </div>
                                        </div>

                                        {{-- MODAL INTERACTIVO 1: CÁMARA --}}
                                        <div x-show="openCameraModal" class="custom-modal-backdrop"
                                            :style="openCameraModal ? 'display: flex !important;' : 'display: none !important;'"
                                            style="display: none;">
                                            <div class="custom-modal-card text-center text-dark position-relative"
                                                @click.stop>

                                                <button type="button"
                                                    @click="stopCamera(); openCameraModal = false; evaluateGlobalStep();"
                                                    class="position-absolute top-0 end-0 m-3 border-0 bg-transparent text-muted">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                </button>

                                                <div x-show="cameraStep === 'front_capture'">
                                                    <span class="badge bg-primary mb-2">Paso 1: Frente</span>
                                                    <h5 class="fw-bold mb-3 text-dark">Encuadra el FRENTE de tu Cédula
                                                    </h5>
                                                </div>

                                                <div x-show="cameraStep === 'front_confirm'">
                                                    <h5 class="fw-bold text-success mb-1">Foto del frente guardada</h5>
                                                    <p class="text-muted small mb-3">¿Los datos se leen de forma clara?
                                                    </p>
                                                    <div class="id-preview-box-centered mx-auto mb-3">
                                                        <img src="{{ $form->identificationCardFront ? (method_exists($form->identificationCardFront, 'temporaryUrl') ? $form->identificationCardFront->temporaryUrl() : url(Storage::url($form->identificationCardFront))) : '' }}"
                                                            class="w-100 h-100 object-fit-cover rounded">
                                                    </div>
                                                    <div class="d-flex p-1 justify-content-center gap-2">
                                                        <button type="button"
                                                            @click="cameraStep = 'back_capture'; startCamera('back');"
                                                            class="btn-photo text-black btn-sm rounded-pill px-3 fw-bold">Siguiente,
                                                            reverso</button>
                                                        <button type="button"
                                                            @click="resetSide('front'); cameraStep = 'front_capture'; startCamera('front');"
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-3">Tomar
                                                            otra vez</button>
                                                    </div>
                                                </div>

                                                <div x-show="cameraStep === 'back_capture'">
                                                    <span class="badge bg-primary mb-2">Paso 2: Reverso</span>
                                                    <h5 class="fw-bold mb-3 text-dark">Encuadra el REVERSO de tu Cédula
                                                    </h5>
                                                </div>

                                                <div x-show="cameraStep === 'back_confirm'">
                                                    <h5 class="fw-bold text-success mb-1">Foto del reverso guardada
                                                    </h5>
                                                    <p class="text-muted small mb-3">¿El reverso se ve nítido?</p>
                                                    <div class="id-preview-box-centered mx-auto mb-3">
                                                        <img src="{{ $form->identificationCardBack ? (method_exists($form->identificationCardBack, 'temporaryUrl') ? $form->identificationCardBack->temporaryUrl() : url(Storage::url($form->identificationCardBack))) : '' }}"
                                                            class="w-100 h-100 object-fit-cover rounded">
                                                    </div>
                                                    <div class="d-flex pb-1 justify-content-center gap-2">
                                                        <button type="button"
                                                            @click="openCameraModal = false; step = 'completed';"
                                                            class="btn btn-sm btn-success rounded-pill px-4 fw-bold">Finalizar
                                                            y Guardar</button>
                                                        <button type="button"
                                                            @click="resetSide('back'); cameraStep = 'back_capture'; startCamera('back');"
                                                            class="btn btn-sm btn-outline-danger rounded-pill px-3">Tomar
                                                            otra vez</button>
                                                    </div>
                                                </div>

                                                {{-- 2. Interfaz de la Cámara para Cédula --}}
                                                <div x-show="showCamera" x-transition
                                                    class="border rounded bg-dark overflow-hidden mx-auto mt-3 shadow-sm w-100"
                                                    :class="{ 'd-flex flex-column': showCamera }"
                                                    style="display: none; max-width: 450px; border-color: rgba(255, 255, 255, 0.15) !important;">

                                                    {{-- Contenedor del Video --}}
                                                    <div class="position-relative w-100 bg-black"
                                                        style="aspect-ratio: 4/3; overflow: hidden;">
                                                        <video x-ref="idVideo" autoplay playsinline
                                                            class="position-absolute top-0 start-0 w-100 h-100"
                                                            style="object-fit: cover;"></video>

                                                        {{-- ⚡ EFECTO OBTURADOR: Se activa con showShutter por 150ms --}}
                                                        <div x-show="showShutter" x-transition.opacity.duration.150ms
                                                            class="position-absolute top-0 start-0 w-100 h-100 bg-white"
                                                            style="display: none; z-index: 10; opacity: 0.85;">
                                                        </div>

                                                        {{-- Guía Visual --}}
                                                        <div class="position-absolute top-50 start-50 translate-middle w-100 h-75"
                                                            style="border: 2px dashed rgba(255, 255, 255, 0.4); border-radius: 12px; pointer-events: none; box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.2); z-index: 11;">
                                                        </div>
                                                    </div>

                                                    <canvas x-ref="idCanvas" style="display:none;"></canvas>

                                                    {{-- Franja de Controles Inferior --}}
                                                    <div class="d-flex justify-content-center align-items-center p-3 w-100 position-relative"
                                                        style="background: #1e293b; border-top: 1px solid rgba(255, 255, 255, 0.1); min-height: 80px;">

                                                        <div
                                                            class="w-100 d-flex justify-content-center align-items-center position-relative">

                                                            {{-- 🔄 BOTÓN VOLTEAR CÁMARA (Extremo Izquierdo) --}}
                                                            <button type="button" @click="toggleCamera()"
                                                                class="position-absolute"
                                                                style="left: 20px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); width: 38px; height: 38px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                                onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                                                                onmouseout="this.style.background='rgba(255,255,255,0.1)'"
                                                                title="Cambiar de cámara">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                    height="18" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2.5"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path
                                                                        d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                                                                </svg>
                                                            </button>

                                                            {{-- 📸 Botón Capturar (Centro Perfecto) --}}
                                                            <button class="take-photo" type="button"
                                                                @click="takePhoto()"
                                                                style="transform: scale(1); transition: transform 0.1s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.4);"
                                                                onmousedown="this.style.transform='scale(0.92)'"
                                                                onmouseup="this.style.transform='scale(1)'">
                                                                <div
                                                                    style="width: 42px; height: 42px; border-radius: 50%; border: 3px solid #000; background: #fff;">
                                                                </div>
                                                            </button>

                                                            {{-- 🔦 BOTÓN LINTERNA (Extremo Derecho) --}}
                                                            <template x-if="isFlashSupported">
                                                                <button type="button" @click="toggleFlash()"
                                                                    class="position-absolute"
                                                                    style="right: 20px; top: 50%; transform: translateY(-50%); background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); width: 38px; height: 38px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                                    onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                                                                    onmouseout="this.style.background='rgba(255,255,255,0.1)'"
                                                                    :title="flashMode === 'on' ? 'Apagar linterna' :
                                                                        'Encender linterna'">

                                                                    {{-- Icono Linterna APAGADA --}}
                                                                    <svg x-show="flashMode === 'off'"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="18" height="18"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="#9ca3af" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path d="M18 10L16 3H8L6 10l3 3h6l3-3z" />
                                                                        <path
                                                                            d="M9 13v7a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-7" />
                                                                        <line x1="12" y1="7"
                                                                            x2="12.01" y2="7" />
                                                                        <line x1="3" y1="3"
                                                                            x2="21" y2="21"
                                                                            stroke="#ef4444" stroke-width="2" />
                                                                    </svg>

                                                                    {{-- Icono Linterna ENCENDIDA --}}
                                                                    <svg x-show="flashMode === 'on'"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        width="18" height="18"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="#facc15" stroke-width="2"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path d="M18 10L16 3H8L6 10l3 3h6l3-3z"
                                                                            fill="#facc15" fill-opacity="0.3" />
                                                                        <path
                                                                            d="M9 13v7a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-7" />
                                                                        <circle cx="12" cy="6.5" r="1"
                                                                            fill="#facc15" />
                                                                        <line x1="12" y1="1"
                                                                            x2="12" y2="2"
                                                                            stroke="#facc15" stroke-width="2" />
                                                                        <line x1="6" y1="1"
                                                                            x2="7" y2="2"
                                                                            stroke="#facc15" stroke-width="2" />
                                                                        <line x1="18" y1="1"
                                                                            x2="17" y2="2"
                                                                            stroke="#facc15" stroke-width="2" />
                                                                    </svg>
                                                                </button>
                                                            </template>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- MODAL INTERACTIVO 2: ARCHIVOS / GALERÍA --}}
                                        <div x-show="openUploadModal" class="custom-modal-backdrop"
                                            :style="openUploadModal ? 'display: flex !important;' : 'display: none !important;'"
                                            style="display: none;">
                                            <div class="custom-modal-card p-4 text-center text-dark"
                                                style="max-width: 460px;" @click.stop>
                                                <h5 class="fw-bold subir-ci">Subir Cédula desde Archivos</h5>

                                                {{-- Contenedor de Cajas (Responsivo: 1 columna en móvil, flex centrado en desktop) --}}
                                                <div
                                                    class="id-upload-container d-flex justify-content-center gap-4 flex-wrap mb-4 w-100">

                                                    {{-- File Box Frente --}}
                                                    <div class="id-upload-card d-flex flex-column align-items-center w-100-mobile">
                                                        <span class="small fw-bold mb-1 text-muted">Cara Frontal</span>
                                                        <div
                                                            class="id-preview-box-centered bg-light border d-flex flex-column justify-content-center position-relative">

                                                            {{-- Spinner de carga superpuesto sin conflictos CSS --}}
                                                            <div x-show="isUploadingFront"
                                                                :class="{ 'd-flex': isUploadingFront }"
                                                                class="position-absolute top-0 start-0 w-100 h-100 flex-column align-items-center justify-content-center bg-white rounded"
                                                                style="z-index: 10; display: none;">
                                                                <div class="spinner-border spinner-border-sm text-primary mb-1"
                                                                    role="status"></div>
                                                                <span
                                                                    class="x-small text-muted fw-semibold">Cargando...</span>
                                                            </div>

                                                            {{-- Vista previa de la foto --}}
                                                            <div x-show="hasFront && !isUploadingFront"
                                                                class="w-100 h-100 position-relative">
                                                                <img :src="frontPreview"
                                                                    class="w-100 h-100 object-fit-cover rounded"
                                                                    @click="lightboxUrl = frontPreview">
                                                                <div class="id-hover-overlay"
                                                                    @click="lightboxUrl = frontPreview">Click para ver
                                                                </div>
                                                            </div>

                                                            {{-- Botón de selección de archivo --}}
                                                            <div x-show="!hasFront && !isUploadingFront"
                                                                class="w-100 h-100">
                                                                <label
                                                                    class="w-100 h-100 d-flex flex-column align-items-center justify-content-center cursor-pointer p-2 mb-0">
                                                                    <input type="file" class="d-none"
                                                                        accept="image/*"
                                                                        @change="uploadPhoto($event.target.files[0], 'front')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="22" height="22"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        class="text-primary mb-1">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                        <polyline points="17 8 12 3 7 8" />
                                                                        <line x1="12" y1="3"
                                                                            x2="12" y2="15" />
                                                                    </svg>
                                                                    <span class="text-primary small fw-bold">Subir
                                                                        Frente</span>
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <template x-if="hasFront && !isUploadingFront">
                                                            <button type="button" @click="resetSide('front')"
                                                                class="btn btn-link text-danger text-decoration-none x-small p-0 mt-1">Borrar</button>
                                                        </template>
                                                    </div>

                                                    {{-- File Box Reverso --}}
                                                    <div class=" id-upload-card d-flex flex-column align-items-center w-100-mobile">
                                                        <span class="small fw-bold mb-1 text-muted">Cara Reverso</span>
                                                        <div
                                                            class="id-preview-box-centered bg-light border d-flex flex-column justify-content-center position-relative">

                                                            {{-- Spinner de carga superpuesto sin conflictos CSS --}}
                                                            <div x-show="isUploadingBack"
                                                                :class="{ 'd-flex': isUploadingBack }"
                                                                class="position-absolute top-0 start-0 w-100 h-100 flex-column align-items-center justify-content-center bg-white rounded"
                                                                style="z-index: 10; display: none;">
                                                                <div class="spinner-border spinner-border-sm text-primary mb-1"
                                                                    role="status"></div>
                                                                <span
                                                                    class="x-small text-muted fw-semibold">Cargando...</span>
                                                            </div>

                                                            {{-- Vista previa de la foto --}}
                                                            <div x-show="hasBack && !isUploadingBack"
                                                                class="w-100 h-100 position-relative">
                                                                <img :src="backPreview"
                                                                    class="w-100 h-100 object-fit-cover rounded"
                                                                    @click="lightboxUrl = backPreview">
                                                                <div class="id-hover-overlay"
                                                                    @click="lightboxUrl = backPreview">Click para ver
                                                                </div>
                                                            </div>

                                                            {{-- Botón de selección de archivo --}}
                                                            <div x-show="!hasBack && !isUploadingBack"
                                                                class="w-100 h-100">
                                                                <label
                                                                    class="w-100 h-100 d-flex flex-column align-items-center justify-content-center cursor-pointer p-2 mb-0">
                                                                    <input type="file" class="d-none"
                                                                        accept="image/*"
                                                                        @change="uploadPhoto($event.target.files[0], 'back')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="22" height="22"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        class="text-primary mb-1">
                                                                        <path
                                                                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                        <polyline points="17 8 12 3 7 8" />
                                                                        <line x1="12" y1="3"
                                                                            x2="12" y2="15" />
                                                                    </svg>
                                                                    <span class="text-primary small fw-bold">Subir
                                                                        Reverso</span>
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <template x-if="hasBack && !isUploadingBack">
                                                            <button type="button" @click="resetSide('back')"
                                                                class="btn btn-link text-danger text-decoration-none x-small p-0 mt-1">Borrar</button>
                                                        </template>
                                                    </div>

                                                </div>

                                                {{-- Botones de Acción --}}
                                                <div
                                                    class="action-buttons-wrapper d-flex justify-content-center gap-3">
                                                    <button type="button"
                                                        @click="openUploadModal = false; evaluateGlobalStep();"
                                                        :disabled="!hasFront || !hasBack || isUploadingFront || isUploadingBack"
                                                        class="btn btn-success rounded-pill px-4 btn-sm fw-bold">Finalizar</button>
                                                    <button type="button"
                                                        @click="openUploadModal = false; evaluateGlobalStep();"
                                                        class="btn btn-outline-secondary rounded-pill px-3 btn-sm">Cancelar</button>
                                                </div>
                                            </div>


                                        </div>

                                        {{-- UNIFICADO: VISUALIZADOR LIGHTBOX PANTALLA COMPLETA --}}
                                        <div x-show="lightboxUrl !== ''" x-transition.opacity
                                            class="position-fixed top-0 start-0 w-100 h-100 align-items-center justify-content-center"
                                            :class="lightboxUrl !== '' ? 'd-flex' : 'd-none'"
                                            style="z-index: 30000; background: rgba(0,0,0,0.9); padding: 20px; display: none;"
                                            @click="lightboxUrl = ''" @keydown.escape.window="lightboxUrl = ''">

                                            <button type="button" @click="lightboxUrl = ''"
                                                class="position-absolute top-0 end-0 m-4"
                                                style="background: none; border: none; color: #fff; cursor: pointer; z-index: 30001;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6"
                                                        y2="18"></line>
                                                    <line x1="6" y1="6" x2="18"
                                                        y2="18"></line>
                                                </svg>
                                            </button>

                                            <img :src="lightboxUrl" class="rounded shadow-lg"
                                                style="max-width: 95%; max-height: 85vh; object-fit: contain;"
                                                @click.stop>
                                        </div>

                                    </div>
                                </div>
                                <style>
    /* ======================================================
       🖥️ ESTILOS BASE Y DESKTOP (PC): LADO A LADO PERFECTO
       ====================================================== */
    
    /* Modal con ancho suficiente para 2 fotos en horizontal */
    .custom-modal-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 560px !important; /* 👈 Garantiza espacio para las 2 fotos en PC */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: modal-fade-in 0.25s ease-out;
    }

    /* Columnas simétricas iguales */
    .id-upload-card {
        flex: 1 1 0px !important; /* 👈 Fuerza a ambas columnas a medir exactamente lo mismo */
        width: 100%;
        max-width: 230px !important; /* 👈 Medida idéntica para ambas cajas en PC */
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Caja de Vista Previa y Carga en 4:3 */
    .id-preview-box-centered {
        position: relative;
        width: 100%;
        aspect-ratio: 4 / 3 !important; /* 👈 Garantiza proporción 4:3 unificada */
        cursor: pointer;
        overflow: hidden;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9fafb;
    }

    .id-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(2px);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
        border-radius: 12px;
    }

    .id-preview-box-centered:hover .id-hover-overlay {
        opacity: 1;
    }

    /* Modal Backdrop */
    .custom-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 6px;
    }

    @keyframes modal-fade-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .x-small { font-size: 0.75rem !important; }

    .btn-new { background: #ff0000; color: black; }
    .btn-new:hover { color: #ff0000; background-color: #ffffff; }

    .subir-ci { color: rgba(191, 25, 25, 0.7); }

    /* ======================================================
       📱 MEDIA QUERIES RESPONSIVAS PARA MÓVILES (< 576px)
       ====================================================== */
    @media (max-width: 576px) {
        .custom-modal-card {
            max-width: 100% !important;
            max-height: 88vh !important;
            overflow-y: auto !important;
            padding: 1.25rem 1rem !important;
            margin: 0 10px !important;
        }

        .id-upload-container {
            flex-direction: column !important; /* 👈 En móvil se apilan verticalmente */
            align-items: center !important;
            gap: 1.25rem !important;
        }

        .id-upload-card {
            max-width: 280px !important; /* En móvil crecen hasta 280px centrado */
        }

        .w-100-mobile {
            width: 100% !important;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .action-buttons-wrapper {
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 0.6rem !important;
        }

        .action-buttons-wrapper button {
            width: 100% !important;
            padding: 0.6rem !important;
        }
    }
</style>
                            @endif
                            @if ($user->hasRole('student'))

                                {{-- Documento: Identificación estudiante --}}
                                <div class="form-group">
                                    <x-input-label class="am-important" for="coverphoto1" :value="__('profile.identification_card')" />
                                    <div class="am-uploadoption" x-data="{ isUploading: false }"
                                        wire:key="uploading-transcript-{{ time() }}">
                                        <div class="tk-draganddrop"
                                            x-bind:class="{ 'am-dragfile': isDragging, 'am-uploading': isUploading }"
                                            x-on:drop.prevent="isUploading = true; isDragging = false"
                                            wire:drop.prevent="$upload('form.transcript', $event.dataTransfer.files[0])">
                                            <x-text-input name="file" type="file" id="at_upload_transcript"
                                                x-ref="file_upload"
                                                accept="{{ !empty($allowImgFileExt)? join(',',array_map(function ($ex) {return '.' . $ex;}, $allowImgFileExt)): '*' }}"
                                                x-on:change=" isUploading = true; $wire.upload('form.transcript', $refs.file_upload.files[0])" />
                                            <label style="color: black" for="at_upload_transcript"
                                                class="am-uploadfile">
                                                <span class="am-dropfileshadow">
                                                    <svg class="am-border-svg ">
                                                        <rect width="100%" height="100%" rx="12"></rect>
                                                    </svg>
                                                    <i class="am-icon-plus-02"></i>
                                                    <span class="am-uploadiconanimation">
                                                        <i class="am-icon-upload-03"></i>
                                                    </span>
                                                    {{ __('general.drop_file_here') }}
                                                </span>
                                                <em>
                                                    <i class="am-icon-export-03"></i>
                                                </em>
                                                <span>{{ __('general.drop_file_here_or') }}
                                                    <i>{{ __('general.click_here_file') }}</i>
                                                    {{ __('general.to_upload') }}<em>{{ $fileExt }} (max.
                                                        {{ $allowImageSize }} MB)</em></span>
                                            </label>
                                        </div>
                                        @if (!empty($form->transcript))
                                            <div class="am-uploadedfile">
                                                @if (method_exists($form->transcript, 'temporaryUrl'))
                                                    <img src="{{ $form->transcript->temporaryUrl() }}">
                                                @else
                                                    <img src="{{ url(Storage::url($form->transcript)) }}">
                                                @endif
                                                @if (method_exists($form->transcript, 'temporaryUrl'))
                                                    <span>{{ basename(parse_url($form->transcript->temporaryUrl(), PHP_URL_PATH)) }}</span>
                                                @endif
                                                <a href="#" wire:click.prevent="removeMedia('transcript')"
                                                    class="am-delitem">
                                                    <i class="am-icon-trash-02"></i>
                                                </a>
                                            </div>
                                        @endif
                                        <x-input-error field_name="form.transcript" />
                                    </div>
                                </div>



                            @endif




                            {{-- Campo: Dirección y país/estado/ciudad/código postal --}}
                            <div class="form-group am-addressform group-date-photo"
                                wire:key="address-and-location-fields-container"
                                style="background-color: {{ empty($form->country) || (!empty($states) && count($states) > 0 && empty($form->state)) || $errors->has('form.address') || $errors->has('form.country') || $errors->has('form.state') ? 'var(--secundary-color)' : 'var(--primary-color)' }} !important; border-radius: 12px; padding: 20px 10px; transition: all 0.3s ease;"
                                :class="{
                                    'prereq-card-flash': flashErrors &&
                                        {{ $errors->has('form.address') || $errors->has('form.country') || $errors->has('form.state') ? 'true' : 'false' }}
                                }">

                                {{-- Forzamos color blanco al label principal --}}
                                <x-input-label style="color: #fff !important;" for="address"
                                    class="am-important fw-bold" :value="__('profile.address')" />

                                <div class="am-user-location w-100">
                                    @if ($enableGooglePlaces == '1')
                                        {{-- Autocompletado con Google Places --}}
                                        <div class="form-group">
                                            <div @class([
                                                'form-control_wrap',
                                                'am-invalid' => $errors->has('form.address'),
                                            ]) style="position: relative;">
                                                <x-text-input id="tutor_location_field"
                                                    placeholder="{{ __('profile.address_placeholder') }}"
                                                    type="text" autofocus autocomplete="name"
                                                    style="font-weight: 600; color: var(--primary-color) !important;" />
                                            </div>
                                            @error('form.address')
                                                <span
                                                    style="color: #fff !important; background-color: rgba(239, 68, 68, 0.45); padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; margin-top: 6px; display: inline-block;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        {{-- Contenedor flexible adaptativo para País y Estado --}}
                                        <div class="d-flex flex-column flex-sm-row gap-3 w-100 align-items-start mb-0">

                                            {{-- SELECTOR SEARCHABLE: PAÍS --}}
                                            @if (!empty($countries))
                                                <div x-data="{ open: false, search: '', dropUp: false }" @click.outside="open = false"
                                                    class="position-relative flex-grow-1 w-100 text-start">

                                                    <x-input-label style="color: #fff !important;" :value="__('profile.country')" />

                                                    {{-- Botón disparador del Selector --}}
                                                    <div class="custom-select-trigger" x-ref="triggerCountry"
                                                        @click="
                                open = !open; 
                                if (open) { 
                                    $nextTick(() => { 
                                        const rect = $refs.triggerCountry.getBoundingClientRect(); 
                                        dropUp = (window.innerHeight - rect.bottom) < 250; 
                                    }); 
                                }
                            ">
                                                        <span class="text-dark fw-semibold">
                                                            {{ $form->country ? $countries->firstWhere('id', $form->country)?->name ?? __('profile.select_a_country') : __('profile.select_a_country') }}
                                                        </span>
                                                        <svg class="custom-select-arrow"
                                                            :class="{ 'rotate-180': open }"
                                                            xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </div>

                                                    {{-- Panel Desplegable Flotante --}}
                                                    <div x-show="open" class="custom-select-dropdown shadow-sm"
                                                        :class="{ 'drop-up': dropUp }" x-transition
                                                        style="display: none;">
                                                        <div class="p-2 border-bottom">
                                                            <input type="text" x-model="search"
                                                                placeholder="Buscar país..."
                                                                class="custom-select-search-input">
                                                        </div>
                                                        <div class="custom-select-options-list">
                                                            @foreach ($countries as $country)
                                                                <div class="custom-select-item"
                                                                    x-show="'{{ strtolower($country->name) }}'.includes(search.toLowerCase())"
                                                                    @click="$wire.set('form.country', '{{ $country->id }}', true); open = false; search = '';">
                                                                    {{ $country->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- SELECTOR SEARCHABLE: ESTADO/DEPARTAMENTO --}}
                                            @if (!empty($form->country) && !empty($states) && count($states) > 0)
                                                <div x-data="{ open: false, search: '', dropUp: false }" @click.outside="open = false"
                                                    class="position-relative flex-grow-1 w-100 text-start"
                                                    wire:key="state-selector-dropdown-field">

                                                    <x-input-label style="color: #fff !important;" :value="__('profile.state')" />

                                                    {{-- Botón disparador del Selector --}}
                                                    <div class="custom-select-trigger" x-ref="triggerState"
                                                        @click="
                                open = !open; 
                                if (open) { 
                                    $nextTick(() => { 
                                        const rect = $refs.triggerState.getBoundingClientRect(); 
                                        dropUp = (window.innerHeight - rect.bottom) < 250; 
                                    }); 
                                }
                            ">
                                                        <span class="text-dark fw-semibold">
                                                            {{ $form->state ? $states->firstWhere('id', $form->state)?->name ?? __('profile.select_a_state') : __('profile.select_a_state') }}
                                                        </span>
                                                        <svg class="custom-select-arrow"
                                                            :class="{ 'rotate-180': open }"
                                                            xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                    </div>

                                                    {{-- Panel Desplegable Flotante --}}
                                                    <div x-show="open" class="custom-select-dropdown shadow-sm"
                                                        :class="{ 'drop-up': dropUp }" x-transition
                                                        style="display: none;">
                                                        <div class="p-2 border-bottom">
                                                            <input type="text" x-model="search"
                                                                placeholder="Buscar estado..."
                                                                class="custom-select-search-input">
                                                        </div>
                                                        <div class="custom-select-options-list">
                                                            @foreach ($states as $state)
                                                                <div class="custom-select-item"
                                                                    x-show="'{{ strtolower(addslashes($state->name)) }}'.includes(search.toLowerCase())"
                                                                    @click="$wire.set('form.state', '{{ $state->id }}'); open = false; search = '';">
                                                                    {{ $state->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>


                                                </div>
                                            @endif

                                        </div>
                                    @endif
                                </div>
                            </div>

                            <style>
                                /* =========================================================================
       SELECTORES SEARCHABLES PERSONALIZADOS (PAÍS Y ESTADO)
       ========================================================================= */
                                .custom-select-trigger {
                                    display: flex;
                                    align-items: center;
                                    box-sizing: border-box;
                                    justify-content: space-between;
                                    background: #ffffff;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    padding: 0.5rem 0.85rem;
                                    cursor: pointer;
                                    min-height: 42px;
                                    transition: all 0.15s ease-in-out;
                                }

                                .custom-select-trigger:hover {
                                    border-color: #9ca3af;
                                    background-color: #ffffef;
                                }

                                .custom-select-arrow {
                                    color: #6b7280;
                                    transition: transform 0.2s ease;
                                }

                                .custom-select-arrow.rotate-180 {
                                    transform: rotate(180deg);
                                }

                                /* Posicionamiento base (Hacia abajo) */
                                .custom-select-dropdown {
                                    position: absolute;
                                    top: 100%;
                                    left: 0;
                                    width: 100%;
                                    background: #ffffff;
                                    border: 1px solid #e5e7eb;
                                    border-radius: 10px;
                                    margin-top: 5px;
                                    z-index: 1060;
                                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                                    overflow: hidden;
                                }

                                /* Posicionamiento reactivo (Hacia arriba cuando falta espacio abajo) */
                                .custom-select-dropdown.drop-up {
                                    top: auto !important;
                                    bottom: 100% !important;
                                    margin-top: 0 !important;
                                    margin-bottom: 5px !important;
                                }

                                .custom-select-search-input {
                                    width: 100%;
                                    border: 1px solid #e5e7eb;
                                    border-radius: 6px;
                                    padding: 0.45rem 0.6rem;
                                    font-size: 0.875rem;
                                    background-color: #f9fafb;
                                }

                                .custom-select-search-input:focus {
                                    outline: none;
                                    border-color: #3b82f6;
                                    background-color: #ffffff;
                                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
                                }

                                .custom-select-options-list {
                                    max-height: 190px;
                                    overflow-y: auto;
                                }

                                .custom-select-options-list::-webkit-scrollbar {
                                    width: 6px;
                                }

                                .custom-select-options-list::-webkit-scrollbar-track {
                                    background: #f1f1f1;
                                }

                                .custom-select-options-list::-webkit-scrollbar-thumb {
                                    background: #c1c1c1;
                                    border-radius: 4px;
                                }

                                .custom-select-item {
                                    padding: 0.55rem 0.85rem;
                                    font-size: 0.875rem;
                                    color: #374151;
                                    cursor: pointer;
                                    text-align: left;
                                    transition: background 0.1s ease;
                                }

                                .custom-select-item:hover {
                                    background-color: #f3f4f6;
                                    color: #111827;
                                    font-weight: 500;
                                }

                                .btn-photo {
                                    background-color: var(--secundary-color);
                                }
                            </style>


                            {{-- Botón para guardar cambios --}}
                            <div class="form-group am-form-btns" style="padding:1rem 0 !important">
                                <div style="color: black">{{ __('profile.latest_changes_the_live') }}</div>
                                <x-primary-button type="submit" wire:target="updateInfo"
                                    wire:loading.class="am-btn_disable" wire:loading.attr="disabled">

                                    {{-- Spinner animado que aparece solo al cargar --}}
                                    <span wire:loading wire:target="updateInfo"
                                        class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true"></span>

                                    {{-- Texto del botón --}}
                                    <span>{{ __('profile.save_update') }}</span>
                                </x-primary-button>
                            </div>
                        </fieldset>
                    @endif
                </form>
            </div>


            @if (session()->has('error'))
                <div class="alert alert-danger"
                    style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px;margin-top:10px; margin-bottom: 20px;">
                    {{ session('error') }}
                </div>
            @endif
            @if (session()->has('message'))
                <div class="alert alert-success"
                    style="background: #d1fae5; color: #065f46; padding: 12px; border-radius: 6px;margin-top:10px; margin-bottom: 20px;">
                    {{ session('message') }}
                </div>
            @endif
            {{-- Si el usuario ya está verificado --}}
        @elseif(!empty($profile->verified_at))
            <div class="am-successmsg-wrap">
                <div class="am-success-msg">
                    <h5>{{ __('identity.hurray') }}</h5>
                    <p>{{ __('identity.complete_verification') }}</p>
                </div>
            </div>
            {{-- Si la verificación está pendiente --}}
        @else
            <div class="am-submitsmsg-wrap">
                <div class="am-success-msg">
                    <h5>{{ __('identity.woohoo') }}</h5>
                    <p>{{ __('identity.pending_submit_doc') }}</p>
                    <a href="javascript:void(0);"
                        @click="$wire.dispatch('showConfirm', { content: `{{ __('identity.action_warning') }}`,  icon: 'warning', action : `cancel-identity` })">{{ __('identity.cancel_reupload') }}</a>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Prerrequisitos de Verificación (Animaciones Corregidas) -->
    <div class="modal fade" id="prerequisitesModal" tabindex="-1" aria-labelledby="prerequisitesModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">

            {{-- Inicializamos Alpine con variables para controlar los giros y destellos --}}
            <div class="modal-content" x-data="{ isSpinning: false, flashErrors: false }"
                style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); overflow: hidden;">

                <!-- Cabecera -->
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; border-bottom: none; padding: 20px 24px;">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="prerequisitesModalLabel"
                        style="font-weight: 700; font-size: 1.15rem; margin: 0; color: #ffffff;">
                        <i class="fas fa-exclamation-circle text-warning" style="font-size: 1.25rem;"></i>
                        Completar requisitos obligatorios
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"
                        style="background-color: transparent; border: none; font-size: 1.25rem; color: #fff; opacity: 0.8; transition: opacity 0.2s;"
                        onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">&times;</button>
                </div>

                <div class="modal-body" style="padding: 10px; background-color: #f8fafc;">
                    <p style="font-size: 0.95rem; color: #475569; margin-bottom: 20px; line-height: 1.5;">
                        Para poder continuar con la verificación de tu identidad, necesitas completar la
                        configuración de los siguientes requisitos en tu perfil de tutor:
                    </p>

                    <div class="d-flex flex-column gap-3">

                        <!-- Requisito: Número de Teléfono -->
                        @if (isset($prerequisite_errors['phone_number']))
                            <div x-data="{ accepted: false }"
                                x-show="true"
                                x-transition:leave="prereq-fade-leave"
                                x-transition:leave-start="opacity: 1; transform: scale(1)"
                                x-transition:leave-end="opacity: 0; transform: scale(0.95)"
                                class="prereq-card-premium prereq-card-transition"
                                :class="{
                                    'prereq-card-pending': !accepted,
                                    'prereq-card-accepted': accepted,
                                    'prereq-card-flash': flashErrors && !accepted
                                }">

                                {{-- Fila Superior: Título, Icono y Estado --}}
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="prereq-icon-box">
                                            <i class="fas" :class="accepted ? 'fa-check' : 'fa-times'"></i>
                                        </span>
                                        <strong class="prereq-title">Número de teléfono</strong>
                                    </div>
                                    <span class="prereq-badge" x-text="accepted ? 'Aceptado ✓' : 'Pendiente'"></span>
                                </div>

                                {{-- Fila Inferior: Formulario de Entrada --}}
                                <div class="prereq-form-divider" x-show="!accepted" x-transition>
                                    <label for="pre_phone" class="prereq-label-premium mb-2 d-block">Ingresa tu número
                                        de teléfono:</label>

                                    <div class="position-relative d-flex align-items-center w-100">
                                        <input type="text" id="pre_phone" wire:model="prerequisite_phone_number"
                                            class="prereq-input-premium" placeholder="Ej. +591 70000000" />
                                    </div>

                                    {{-- Fila del Botón de Confirmación Local --}}
                                    <div class="d-flex justify-content-end align-items-center w-100 mt-2">
                                        <button type="button"
                                            @click="accepted = true; setTimeout(() => $wire.savePrerequisiteOption('phone_number'), 700)"
                                            class="btn-prereq-section-accept">
                                            <i class="fas fa-check-circle me-1"></i> Aceptar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Requisito: Género de Perfil -->
                        @if (isset($prerequisite_errors['gender']))
                            <div x-data="{ accepted: false, selectedGender: @entangle('prerequisite_gender') }"
                                x-show="true"
                                class="prereq-card-premium prereq-card-transition"
                                :class="{
                                    'prereq-card-pending': !accepted,
                                    'prereq-card-accepted': accepted,
                                    'prereq-card-flash': flashErrors && !accepted
                                }"
                                x-transition:leave-start="opacity: 1; transform: scale(1)"
                                x-transition:leave-end="opacity: 0; transform: scale(0.95)">

                                {{-- Fila Superior: Título, Icono y Estado --}}
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="prereq-icon-box">
                                            <i class="fas" :class="accepted ? 'fa-check' : 'fa-times'"></i>
                                        </span>
                                        <strong class="prereq-title">Género de perfil</strong>
                                    </div>
                                    <span class="prereq-badge" x-text="accepted ? 'Aceptado ✓' : 'Pendiente'"></span>
                                </div>

                                {{-- Fila Inferior: Formulario por Chips --}}
                                <div class="prereq-form-divider mt-3 pt-3" x-show="!accepted" x-transition>
                                    <label class="prereq-label-premium mb-2 d-block">Selecciona tu género:</label>

                                    {{-- Grid de Chips Remasterizado --}}
                                    <div class="gender-chips-grid mb-3">
                                        <button type="button" @click="selectedGender = 'male'"
                                            class="gender-chip-button"
                                            :class="{ 'is-active': selectedGender === 'male' }">
                                            <i class="fas fa-mars"></i> <span>Masculino</span>
                                        </button>

                                        <button type="button" @click="selectedGender = 'female'"
                                            class="gender-chip-button"
                                            :class="{ 'is-active': selectedGender === 'female' }">
                                            <i class="fas fa-venus"></i> <span>Femenino</span>
                                        </button>

                                        <button type="button" @click="selectedGender = 'not_specified'"
                                            class="gender-chip-button"
                                            :class="{ 'is-active': selectedGender === 'not_specified' }">
                                            <i class="fas fa-genderless"></i> <span>Otro</span>
                                        </button>
                                    </div>

                                    {{-- Fila del Botón de Confirmación Local --}}
                                    <div class="d-flex justify-content-end align-items-center w-100 mt-2">
                                        <button type="button"
                                            @click="accepted = true; setTimeout(() => $wire.savePrerequisiteOption('gender'), 700)"
                                            class="btn-prereq-section-accept">
                                            <i class="fas fa-check-circle me-1"></i> Aceptar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->hasRole('tutor'))
                            <!-- Requisito: Precio de Sesión -->
                            @if (isset($prerequisite_errors['price']))
                                <div x-data="{ accepted: false }"
                                    x-show="true"
                                    class="prereq-card-premium prereq-card-transition"
                                    :class="{
                                        'prereq-card-pending': !accepted,
                                        'prereq-card-accepted': accepted,
                                        'prereq-card-flash': flashErrors && !accepted
                                    }"
                                    x-transition:leave-start="opacity: 1; transform: scale(1)"
                                    x-transition:leave-end="opacity: 0; transform: scale(0.95)">

                                    {{-- Fila Superior: Título, Icono y Estado --}}
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="prereq-icon-box">
                                                <i class="fas" :class="accepted ? 'fa-check' : 'fa-times'"></i>
                                            </span>
                                            <strong class="prereq-title">Precio de tutoría (Bs)</strong>
                                        </div>
                                        <span class="prereq-badge" x-text="accepted ? 'Aceptado ✓' : 'Pendiente'"></span>
                                    </div>

                                    {{-- Fila Inferior: Formulario de Entrada --}}
                                    <div class="prereq-form-divider mt-3 pt-3" x-show="!accepted" x-transition>
                                        <label for="pre_price" class="prereq-label-premium mb-2 d-block">Ingresa tu
                                            precio por hora:</label>

                                        {{-- Caja de Texto Premium con Sufijo Integrado --}}
                                        <div class="position-relative d-flex align-items-center mb-3 w-100">
                                            <input type="number" id="pre_price" step="0.01" min="0"
                                                wire:model="prerequisite_price" class="prereq-input-premium"
                                                placeholder="Ej. 120" />
                                            <span class="prereq-input-suffix">Bs/20 min</span>
                                        </div>

                                        {{-- Fila del Botón de Confirmación Local --}}
                                        <div class="d-flex justify-content-end align-items-center w-100 mt-2">
                                            <button type="button"
                                                @click="accepted = true; setTimeout(() => $wire.savePrerequisiteOption('price'), 700)"
                                                class="btn-prereq-section-accept">
                                                <i class="fas fa-check-circle me-1"></i> Aceptar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <style>
                                /* =========================================================================
   12. ENTRADA DE TEXTO PREMIUM DE ALTO CONTRASTE (PRECIO)
   ========================================================================= */
                                .prereq-input-premium {
                                    width: 100% !important;
                                    background-color: var(--white) !important;
                                    border: 1px solid var(--secundary-color2) !important;
                                    border-radius: 12px !important;
                                    padding: 12px 70px 12px 16px !important;
                                    font-size: 0.95rem !important;
                                    font-weight: 600 !important;
                                    color: var(--primary-color) !important;
                                    outline: none !important;
                                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
                                    transition: all 0.2s ease-in-out !important;
                                }

                                .prereq-input-premium:focus {
                                    border-color: var(--primary-color) !important;
                                    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.35) !important;
                                }

                                .prereq-input-suffix {
                                    position: absolute;
                                    right: 16px;
                                    font-size: 0.82rem;
                                    font-weight: 700;
                                    color: var(--primary-color);
                                    background-color: var(--panel-background);
                                    padding: 4px 10px;
                                    border-radius: 8px;
                                    pointer-events: none;
                                    text-transform: uppercase;
                                    letter-spacing: 0.3px;
                                }

                                .prereq-input-premium::-webkit-outer-spin-button,
                                .prereq-input-premium::-webkit-inner-spin-button {
                                    -webkit-appearance: none;
                                    margin: 0;
                                }

                                .prereq-input-premium[type=number] {
                                    -moz-appearance: textfield;
                                }
                            </style>

                            <!-- Requisito: Materias de Enseñanza -->
                            @if (isset($prerequisite_errors['subjects']))
                                <div x-data="{ accepted: false }"
                                    x-show="true"
                                    class="prereq-card-premium prereq-card-transition"
                                    :class="{
                                        'prereq-card-pending': !accepted,
                                        'prereq-card-accepted': accepted,
                                        'prereq-card-flash': flashErrors && !accepted
                                    }"
                                    x-transition:leave-start="opacity: 1; transform: scale(1)"
                                    x-transition:leave-end="opacity: 0; transform: scale(0.95)">

                                    {{-- Fila Superior: Título, Icono y Estado --}}
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="prereq-icon-box">
                                                <i class="fas" :class="accepted ? 'fa-check' : 'fa-times'"></i>
                                            </span>
                                            <strong class="prereq-title">Materias de enseñanza</strong>
                                        </div>
                                        <span class="prereq-badge" x-text="accepted ? 'Aceptado ✓' : 'Pendiente'"></span>
                                    </div>

                                    {{-- Fila Inferior: Panel de Gestión de Materias --}}
                                    <div class="prereq-form-divider mt-3 pt-3" x-show="!accepted" x-transition>
                                        <label class="prereq-label-premium d-block">Tus materias
                                            seleccionadas:</label>

                                        {{-- Contenedor de Chips de Materias ya Asignadas --}}
                                        <div class="d-flex flex-wrap gap-2 mb-3 min-h-chips-container">
                                            @if (count($selectedSubjects) > 0)
                                                @foreach ($selectedSubjects as $sub)
                                                    <span class="prereq-subject-chip">
                                                        {{ $sub['name'] }}
                                                        <button type="button"
                                                            wire:click="removeSubjectFromModal({{ $sub['subject_id'] }})"
                                                            class="prereq-subject-chip-remove" title="Quitar materia">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </span>
                                                @endforeach
                                            @else
                                                <p class="prereq-placeholder-text">Aún no tienes materias asignadas
                                                    para enseñar.</p>
                                            @endif
                                        </div>

                                        {{-- Buscador Premium Integrado --}}
                                        <div class="position-relative w-100">
                                            <div class="prereq-search-container-premium">
                                                <i class="fas fa-search prereq-search-icon"></i>
                                                <input type="text" wire:model.live.debounce.300ms="subjectSearch"
                                                    placeholder="Buscar y agregar materia..."
                                                    class="prereq-search-input-premium" autocomplete="off" />
                                            </div>

                                            {{-- Dropdown de Resultados Flotante Premium --}}
                                            @if (count($subjectSearchResults) > 0)
                                                <div class="prereq-search-dropdown-premium shadow-lg">
                                                    @foreach ($subjectSearchResults as $result)
                                                        <button type="button"
                                                            wire:click="addSubjectFromModal({{ $result['id'] }})"
                                                            class="prereq-search-result-item">
                                                            <i class="fas fa-plus-circle text-secundary"></i>
                                                            <span>{{ $result['name'] }}</span>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @elseif(strlen(trim($subjectSearch)) >= 1)
                                                <div
                                                    class="prereq-search-dropdown-premium p-3 text-center text-muted small shadow-sm">
                                                    No se encontraron materias con "{{ $subjectSearch }}"
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Fila del Botón de Confirmación Local --}}
                                        <div class="d-flex justify-content-end align-items-center w-100 mt-3">
                                            <button type="button"
                                                @click="accepted = true; setTimeout(() => $wire.savePrerequisiteOption('subjects'), 700)"
                                                class="btn-prereq-section-accept">
                                                <i class="fas fa-check-circle me-1"></i> Aceptar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <style>
                                /* =========================================================================
   13. COMPONENTES PREMIUM PARA LA GESTIÓN DE MATERIAS
   ========================================================================= */
                                .min-h-chips-container {
                                    min-height: 34px;
                                    align-items: center;
                                }

                                .prereq-placeholder-text {
                                    font-size: 0.85rem;
                                    color: rgba(255, 255, 255, 0.75);
                                    font-weight: 500;
                                    margin: 0;
                                    font-style: italic;
                                }

                                .prereq-subject-chip {
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 8px;
                                    background-color: rgba(255, 255, 255, 0.2) !important;
                                    color: var(--white) !important;
                                    border: 1px solid rgba(255, 255, 255, 0.35) !important;
                                    border-radius: 20px !important;
                                    padding: 6px 14px !important;
                                    font-size: 0.82rem !important;
                                    font-weight: 700 !important;
                                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
                                    transition: var(--transition);
                                }

                                .prereq-subject-chip:hover {
                                    background-color: rgba(255, 255, 255, 0.28) !important;
                                    border-color: rgba(255, 255, 255, 0.5) !important;
                                }

                                .prereq-subject-chip-remove {
                                    background: none !important;
                                    border: none !important;
                                    color: var(--white) !important;
                                    cursor: pointer;
                                    padding: 0 !important;
                                    font-size: 0.75rem;
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    opacity: 0.75;
                                    transition: opacity 0.15s ease;
                                }

                                .prereq-subject-chip-remove:hover {
                                    opacity: 1;
                                    transform: scale(1.1);
                                }

                                .prereq-search-container-premium {
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                    background-color: var(--white) !important;
                                    border: 1px solid var(--secundary-color2) !important;
                                    border-radius: 12px !important;
                                    padding: 4px 14px !important;
                                    transition: var(--transition);
                                }

                                .prereq-search-container-premium:focus-within {
                                    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.35) !important;
                                }

                                .prereq-search-icon {
                                    color: var(--secundary-color) !important;
                                    font-size: 0.9rem;
                                }

                                .prereq-search-input-premium {
                                    border: none !important;
                                    background: transparent !important;
                                    outline: none !important;
                                    font-size: 0.92rem !important;
                                    font-weight: 600 !important;
                                    color: var(--primary-color) !important;
                                    width: 100% !important;
                                    padding: 8px 0 !important;
                                }

                                .prereq-search-input-premium::placeholder {
                                    color: #a0aec0;
                                    font-weight: 500;
                                }

                                .prereq-search-dropdown-premium {
                                    position: absolute;
                                    top: calc(100% + 6px);
                                    left: 0;
                                    right: 0;
                                    background-color: var(--white) !important;
                                    border-radius: 12px !important;
                                    box-shadow: 0 10px 25px -5px rgba(2, 48, 71, 0.25), 0 8px 10px -6px rgba(2, 48, 71, 0.15) !important;
                                    z-index: 2000;
                                    max-height: 210px;
                                    overflow-y: auto;
                                    border: 1px solid rgba(2, 48, 71, 0.08);
                                }

                                .prereq-search-result-item {
                                    display: flex;
                                    align-items: center;
                                    gap: 10px;
                                    width: 100%;
                                    text-align: left;
                                    padding: 12px 16px;
                                    background: none !important;
                                    border: none !important;
                                    border-bottom: 1px solid #f1f5f9 !important;
                                    font-size: 0.9rem;
                                    font-weight: 600;
                                    color: var(--primary-color) !important;
                                    cursor: pointer;
                                    transition: background 0.15s ease;
                                }

                                .prereq-search-result-item:last-child {
                                    border-bottom: none !important;
                                }

                                .prereq-search-result-item:hover {
                                    background-color: #f8fafc !important;
                                    color: var(--secundary-color) !important;
                                }

                                .prereq-search-result-item i {
                                    font-size: 0.85rem;
                                    transition: transform 0.15s ease;
                                }

                                .prereq-search-result-item:hover i {
                                    transform: scale(1.15);
                                }

                                .prereq-search-dropdown-premium::-webkit-scrollbar {
                                    width: 6px;
                                }

                                .prereq-search-dropdown-premium::-webkit-scrollbar-track {
                                    background: #f1f5f9;
                                    border-radius: 0 12px 12px 0;
                                }

                                .prereq-search-dropdown-premium::-webkit-scrollbar-thumb {
                                    background: #cbd5e1;
                                    border-radius: 4px;
                                }

                                .prereq-card-prem {
                                    border-radius: 16px !important;
                                    padding: 24px !important;
                                    display: flex;
                                    flex-direction: column;
                                    /* gap: 16px; */
                                    box-shadow: 0 4px 15px rgba(2, 48, 71, 0.06);
                                    border: 1px solid rgba(255, 255, 255, 0.1);
                                }
                            </style>

                            <!-- Requisito: Términos y Condiciones -->
                            @if (isset($prerequisite_errors['terms']))
                                <div x-data="{ accepted: false }"
                                    x-show="true"
                                    class="prereq-card-premium prereq-card-transition"
                                    :class="{
                                        'prereq-card-pending': !accepted,
                                        'prereq-card-accepted': accepted,
                                        'prereq-card-flash': flashErrors && !accepted
                                    }"
                                    x-transition:leave-start="opacity: 1; transform: scale(1)"
                                    x-transition:leave-end="opacity: 0; transform: scale(0.95)">

                                    {{-- Fila Superior: Título, Icono y Estado --}}
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="prereq-icon-box">
                                                <i class="fas" :class="accepted ? 'fa-check' : 'fa-times'"></i>
                                            </span>
                                            <strong class="prereq-title">Términos y condiciones (Tutorías al
                                                instante)</strong>
                                        </div>
                                        <span class="prereq-badge" x-text="accepted ? 'Aceptado ✓' : 'Pendiente'"></span>
                                    </div>

                                    {{-- Fila Inferior: Checkbox y Confirmación --}}
                                    <div class="prereq-form-divider mt-3 pt-3" x-show="!accepted" x-transition>
                                        <div class="d-flex align-items-start gap-2 mb-2">
                                            <input type="checkbox" id="pre_terms" wire:model="prerequisite_terms"
                                                class="form-check-input mt-1"
                                                style="width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;" />
                                            <label for="pre_terms" class="prereq-label-premium mb-0 cursor-pointer"
                                                style="font-size: 0.88rem; line-height: 1.4; font-weight: 500;">
                                                Acepto los <a href="https://www.classgoapp.com/terminos"
                                                    target="_blank" class="text-decoration-underline fw-bold"
                                                    style="color: #ffffff !important;">términos y condiciones</a> para
                                                impartir tutorías al instante.
                                            </label>
                                        </div>

                                        {{-- Fila del Botón de Confirmación Local --}}
                                        <div class="d-flex justify-content-end align-items-center w-100 mt-3">
                                            <button type="button"
                                                @click="accepted = true; setTimeout(() => $wire.savePrerequisiteOption('terms'), 700)"
                                                class="btn-prereq-section-accept">
                                                <i class="fas fa-check-circle me-1"></i> Aceptar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Requisito: Google Calendar -->
                            @if (app()->environment('production') && isset($prerequisite_errors['calendar']))
                                <div class="form-group mb-2 prereq-card-transition prereq-card-pending"
                                    wire:key="google-calendar-prereq-container"
                                    style="background-color: var(--secundary-color, #fff) !important; border-radius: 12px; padding: 16px 20px; transition: all 0.3s ease; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02);"
                                    :class="{
                                        'prereq-card-flash': flashErrors
                                    }">

                                    {{-- Encabezado de Estado --}}
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-flex align-items-center justify-content-center"
                                                style="width: 28px; height: 28px; border-radius: 50%; background-color: #fef2f2; color: #ef4444; font-size: 0.9rem; background-color: rgba(255, 255, 255, 0.2); color: var(--white);">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <strong style="color: #ffffff; font-size: 0.95rem;">
                                                Google Calendar vinculado
                                            </strong>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-1.5 fw-bold"
                                            style="font-size: 0.8rem; background-color: rgba(239, 68, 68, 0.2); color: #ffffff;">
                                            Pendiente
                                        </span>
                                    </div>

                                    {{-- Contenido de Vinculación --}}
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 id-upload-container pt-2"
                                        style="border-top: 1px dashed rgba(226, 232, 240, 0.4);">

                                        <div class="d-flex align-items-center gap-3 w-100-mobile">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm p-2"
                                                style="width: 40px; height: 40px; flex-shrink: 0;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z"
                                                        stroke="#4285F4" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M16 2V6" stroke="#EA4335" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M8 2V6" stroke="#34A853" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M3 10H21" stroke="#FBBC05" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="small d-block"
                                                    style="color: rgba(255, 255, 255, 0.9); font-size: 0.85rem;">
                                                    Vincula tu calendario para sincronizar citas de forma automática.
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="d-flex align-items-center w-100-mobile justify-content-end action-buttons-wrapper">
                                            <button type="button" wire:click="connectCalendarFromPrerequisites"
                                                wire:loading.attr="disabled"
                                                wire:target="connectCalendarFromPrerequisites"
                                                class="btn btn-light btn-sm rounded-pill px-4 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm fw-bold text-dark"
                                                style="border: none !important; font-size: 0.85rem; transition: transform 0.15s ease;"
                                                onmousedown="this.style.transform='scale(0.96)'"
                                                onmouseup="this.style.transform='scale(1)'">
                                                <i class="fab fa-google text-danger"></i>
                                                <span wire:loading.remove wire:target="connectCalendarFromPrerequisites">Conectar Calendar</span>
                                                <span wire:loading wire:target="connectCalendarFromPrerequisites">Conectando...</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            {{-- Banner cuando TODOS los requisitos están completados --}}
                            @if (empty($prerequisite_errors))
                                <div class="alert alert-success text-center border-0 shadow-sm rounded-3 p-3 mb-0"
                                    style="background-color: #ecfdf5; color: #065f46;">
                                    <i class="fas fa-check-circle me-2"
                                        style="font-size: 1.25rem; color: #10b981;"></i>
                                    <strong>¡Todos los requisitos obligatorios han sido completados!</strong>
                                    <p class="mb-0 mt-1 small" style="color: #047857;">Haz clic en
                                        <strong>Guardar</strong> para continuar con la verificación.</p>
                                </div>
                            @endif

                            <style>
                                /* Animación de Parpadeo de Error */
                                @keyframes prereq-pulse-error {
                                    0% {
                                        border-color: rgba(255, 255, 255, 0.1);
                                        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                    }

                                    25% {
                                        border-color: #ff0000;
                                        box-shadow: 0 0 0 8px rgba(255, 0, 0, 0.65);
                                    }

                                    50% {
                                        border-color: rgba(255, 255, 255, 0.1);
                                        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                    }

                                    75% {
                                        border-color: #ff0000;
                                        box-shadow: 0 0 0 8px rgba(255, 0, 0, 0.65);
                                    }

                                    100% {
                                        border-color: rgba(255, 255, 255, 0.1);
                                        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
                                    }
                                }

                                .prereq-card-flash {
                                    animation: prereq-pulse-error 1.3s ease-in-out infinite !important;
                                }

                                /* Adaptación Móvil */
                                @media (max-width: 576px) {
                                    .id-upload-container {
                                        flex-direction: column !important;
                                        align-items: flex-start !important;
                                        gap: 0.8rem !important;
                                    }

                                    .w-100-mobile {
                                        width: 100% !important;
                                    }

                                    .action-buttons-wrapper {
                                        justify-content: center !important;
                                    }

                                    .action-buttons-wrapper button {
                                        width: 100% !important;
                                        padding: 0.6rem 1rem !important;
                                    }
                                }
                            </style>
                        @endif
                    </div>
                </div>

                <!-- Footer con Activadores de Animación Cruzados -->
                <div class="modal-footer"
                    style="background-color: #f1f5f9; border-top: none; padding: 16px 24px; display: flex; justify-content: space-between; gap: 10px;">

                    {{-- Botón de Actualizar Estado (Ahora usa la clase de giro garantizado) --}}
                    <button type="button"
                        @click="isSpinning = true; $wire.recheckPrerequisites().then(() => isSpinning = false)"
                        class="btn btn-link text-secondary text-decoration-none small d-flex align-items-center gap-1 p-0"
                        style="font-size: 0.85rem; font-weight: 600;">
                        <i class="fas fa-sync-alt" :class="{ 'icon-spin-active': isSpinning }"></i> Actualizar estado
                    </button>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            style="border-radius: 8px; font-weight: 600; font-size: 0.9rem; padding: 8px 16px; border: 1px solid #cbd5e1; color: #475569;">Cancelar</button>

                        {{-- Botón Guardar: Protegido con clases CSS para que no pierda su forma redondeada --}}
                        <button type="button"
                            @click="if($wire.prerequisites_validated) { 
                                    $wire.savePrerequisites() 
                                } else { 
                                    flashErrors = true; 
                                    isSpinning = true; 
                                    $wire.recheckPrerequisites().then(() => isSpinning = false);
                                    setTimeout(() => flashErrors = false, 2000);
                                }"
                            class="btn btn-guardar-premium"
                            :class="{ 'is-disabled': !$wire.prerequisites_validated }">
                            Guardar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        /* =========================================================================
   7. ANIMACIONES DE ADVERTENCIA PARA PRERREQUISITOS (PULSACIÓN ROJA)
   ========================================================================= */
        @keyframes prereq-pulse-error {
            0% {
                border-color: #e2e8f0;
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }

            25% {
                border-color: #ef4444;
                box-shadow: 0 0 0 5px rgba(239, 68, 68, 0.25);
                background-color: #fef2f2;
            }

            50% {
                border-color: #e2e8f0;
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }

            75% {
                border-color: #ef4444;
                box-shadow: 0 0 0 5px rgba(239, 68, 68, 0.25);
                background-color: #fef2f2;
            }

            100% {
                border-color: #e2e8f0;
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        /* Clase dinámica que hace parpadear los campos vacíos */
        .prereq-card-flash {
            animation: prereq-pulse-error 1.2s ease-in-out infinite;
            border-width: 1px !important;
        }

        /* Suaviza las transiciones de color de fondo y bordes */
        .prereq-card-transition {
            transition: all 0.3s ease-in-out;
        }

        /* =========================================================================
   8. ESTILOS SEGUROS PARA EL BOTÓN GUARDAR Y ANIMACIÓN DE GIRO
   ========================================================================= */

        /* Botón Guardar con forma garantizada */
        .btn-guardar-premium {
            border-radius: 8px !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 8px 16px;
            background-color: #fb8500;
            color: white !important;
            border: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-guardar-premium:hover {
            background-color: #e57b02;
        }

        /* Estado bloqueado del botón Guardar */
        .btn-guardar-premium.is-disabled {
            opacity: 0.45;
            cursor: not-allowed !important;
        }

        /* Evita que el botón bloqueado cambie de color al pasar el ratón */
        .btn-guardar-premium.is-disabled:hover {
            background-color: #fb8500 !important;
        }

        /* Animación de giro forzado para el icono de actualizar */
        @keyframes icon-spin-custom {
            100% {
                transform: rotate(360deg);
            }
        }

        .icon-spin-active {
            animation: icon-spin-custom 0.8s linear infinite;
            color: #3b82f6 !important;
            /* Se pinta azul mientras gira para destacar */
        }

        /* =========================================================================
   9. TARJETAS DE PRERREQUISITOS EVOLUCIONADAS (UX/UI PREMIUM)
   ========================================================================= */

        /* Estructura base de la tarjeta con padding generoso */
        .prereq-card-premium {
            border-radius: 16px !important;
            padding: 24px !important;
            display: flex;
            flex-direction: column;
            gap: 3px;
            box-shadow: 0 4px 15px rgba(2, 48, 71, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ESTADO 1: Faltan rellenar campos (Fondo Color Secundario) */
        .prereq-card-pending {
            background-color: var(--secundary-color) !important;
            color: var(--white) !important;
        }

        .prereq-card-pending .prereq-title {
            color: var(--white) !important;
        }

        .prereq-card-pending .prereq-icon-box {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
        }

        .prereq-card-pending .prereq-badge {
            background-color: rgba(255, 255, 255, 0.25);
            color: var(--white);
        }

        /* ESTADO 2: Requisito rellenado con éxito (Fondo Color Primario) */
        .prereq-card-completed {
            background-color: var(--primary-color) !important;
            color: var(--white) !important;
        }

        .prereq-card-completed .prereq-title {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        .prereq-card-completed .prereq-icon-box {
            background-color: rgba(46, 204, 113, 0.25);
            color: #2ecc71;
            /* Verde esmeralda brillante */
        }

        .prereq-card-completed .prereq-badge {
            background-color: rgba(33, 158, 188, 0.25);
            color: var(--terciary-color);
        }

        /* ESTADO 3: Aceptado momentáneamente (Color Primario antes del fade-out) */
        .prereq-card-accepted {
            background-color: var(--primary-color) !important;
            color: var(--white) !important;
            transition: background 0.3s ease, opacity 0.6s ease, transform 0.6s ease !important;
        }

        .prereq-card-accepted .prereq-title {
            color: rgba(255, 255, 255, 0.95) !important;
        }

        .prereq-card-accepted .prereq-icon-box {
            background-color: rgba(46, 204, 113, 0.25) !important;
            color: #2ecc71 !important;
        }

        .prereq-card-accepted .prereq-badge {
            background-color: rgba(33, 158, 188, 0.25) !important;
            color: var(--terciary-color) !important;
            font-weight: 800 !important;
        }

        /* Duración de la transición de salida para Alpine.js */
        [x-transition\:leave] {
            transition-property: opacity, transform !important;
            transition-duration: 600ms !important;
            transition-timing-function: ease-in-out !important;
        }

        /* Tipografías y Componentes Internos */
        .prereq-title {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin: 0;
        }

        .prereq-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .prereq-badge {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* Separador y etiquetas del formulario interno */
        .prereq-form-divider {
            border-top: 1px dashed rgba(255, 255, 255, 0.2);
            /* padding-top: 16px; */
        }

        .prereq-label-premium {
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            /* margin-bottom: 8px; */
            display: block;
        }

        /* Selector Select Premium Redondeado y Estilizado */
        .prereq-select-premium {
            background-color: var(--white);
            border: 1px solid var(--secundary-color2);
            border-radius: 10px;
            font-size: 0.92rem;
            padding: 10px 14px;
            color: var(--primary-color);
            font-weight: 600;
            width: 100%;
            outline: none;
            transition: var(--transition);
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .prereq-select-premium:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4);
        }

        .prereq-error-message {
            color: #fff;
            background-color: rgba(239, 68, 68, 0.3);
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 6px;
            display: inline-block;
        }

        /* =========================================================================
   10. SELECTOR DE GÉNERO PREMIUM (INTERFAZ DE CHIPS COMPACTA)
   ========================================================================= */

        /* Rejilla adaptativa para los botones */
        .gender-chips-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            width: 100%;
        }

        /* Botón/Chip en estado base (Cuando la tarjeta está pendiente) */
        .gender-chip-button {
            flex: 1;
            min-width: 130px;
            background-color: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: var(--white) !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            outline: none;
        }

        /* Efecto Hover sutil */
        .gender-chip-button:hover {
            background-color: rgba(255, 255, 255, 0.22) !important;
            border-color: rgba(255, 255, 255, 0.4) !important;
            transform: translateY(-1px);
        }

        /* ESTADO SELECCIONADO: Resalta con fondo blanco y letras oscuras */
        .gender-chip-button.is-active {
            background-color: var(--white) !important;
            color: var(--primary-color) !important;
            border-color: var(--white) !important;
            box-shadow: 0 4px 12px rgba(2, 48, 71, 0.15);
            transform: translateY(0);
        }

        /* Iconos dentro de los chips */
        .gender-chip-button i {
            font-size: 1.05rem;
            opacity: 0.85;
            transition: transform 0.2s ease;
        }

        .gender-chip-button.is-active i {
            opacity: 1;
            transform: scale(1.1);
        }
    </style>

</div>
{{-- Estilos para Flatpickr --}}
@push('styles')
    @vite(['public/css/flatpicker.css', 'public/css/flatpicker-month-year-plugin.css'])
@endpush

{{-- Carga de librerías externas --}}
@push('scripts')
    @if ($enableGooglePlaces == '1')
        <script async
            src="https://maps.googleapis.com/maps/api/js?key={{ $googleApiKey }}&libraries=places&loading=async&callback=initializePlaceApi">
        </script>
    @endif
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
@endpush

{{-- Scripts de lógica de formulario, Places, Modal y Google Calendar --}}
@push('scripts')
    <script>
        var component = '';

        // 1. Inicializaciones generales
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        }, {
            once: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Reajuste inicial de coords
            if (typeof @this !== 'undefined') {
                @this.set('form.lat', null);
                @this.set('form.lng', null);
            }

            // Inicializar Modal de Prerrequisitos (Bootstrap)
            const modalEl = document.getElementById('prerequisitesModal');
            if (modalEl) {
                window.prerequisitesModal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });

        // 2. Eventos de Livewire
        document.addEventListener('livewire:initialized', function() {
            Livewire.on('openPrerequisitesModal', function() {
                if (!window.prerequisitesModal) {
                    const modalEl = document.getElementById('prerequisitesModal');
                    if (modalEl) window.prerequisitesModal = new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });
                }
                if (window.prerequisitesModal) window.prerequisitesModal.show();
            });

            Livewire.on('closePrerequisitesModal', function() {
                if (window.prerequisitesModal) window.prerequisitesModal.hide();
            });
        });

        document.addEventListener('loadPageJs', (event) => {
            if (component) {
                component.dispatch('initSelect2', {
                    target: '.am-select2'
                });
            }
            setTimeout(() => {
                if (typeof initializeDatePicker === 'function') {
                    initializeDatePicker();
                }
                @if ($enableGooglePlaces == '1')
                    if (typeof initializePlaceApi === 'function') initializePlaceApi();
                @endif
            }, 1000);
        });

        document.addEventListener('showConfirmAndRedirect', function(event) {
            const data = event.detail[0];
            if (confirm(data.message + '\n\n¿Desea completar su perfil ahora?')) {
                window.location.href = data.url;
            }
        });

        // 3. Google Places API
        @if ($enableGooglePlaces == '1')
            function initializePlaceApi() {
                var tutorAddress = document.getElementById('tutor_location_field');
                if (tutorAddress) {
                    tutorAddress.addEventListener('input', function(e) {
                        if (e.target.value == '') {
                            @this.set('form.address', '');
                        }
                    });
                    if (typeof google !== 'undefined' && typeof google.maps.places !== 'undefined') {
                        var autocompleteTutor = new google.maps.places.Autocomplete(tutorAddress);
                        google.maps.event.addListener(autocompleteTutor, 'place_changed', function() {
                            var place = autocompleteTutor.getPlace();
                            var address = place.formatted_address ?? null;
                            var lat = place.geometry?.location?.lat() ?? null;
                            var lng = place.geometry?.location?.lng() ?? null;
                            var countryName = null;

                            place.address_components?.forEach((item) => {
                                if (item.types.includes('country')) {
                                    countryName = item.short_name;
                                }
                            });

                            if (address) @this.set('form.address', address);
                            if (lat !== null && lng !== null) {
                                @this.set('form.lat', lat);
                                @this.set('form.lng', lng);
                            } else {
                                @this.set('form.lat', null);
                                @this.set('form.lng', null);
                            }
                            if (countryName) @this.set('form.countryName', countryName);
                        });
                    }
                }
            }
        @endif

        // 4. Google Calendar — Escucha el evento Livewire con la URL real del servicio
        //    y la abre en un popup sin perder el estado del formulario.
        function openGoogleCalendarPopupWithUrl(authUrl) {
            const width = 600;
            const height = 650;
            const left = Math.round((window.screen.width - width) / 2);
            const top = Math.round((window.screen.height - height) / 2);

            const popup = window.open(
                authUrl,
                'GoogleCalendarAuth',
                `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes,status=yes`
            );

            let checkCount = 0;
            const poller = setInterval(function() {
                checkCount++;
                // Si la ventana se cerró o pasa más de 3 minutos, consulta el estado
                if (!popup || popup.closed || checkCount > 225) {
                    clearInterval(poller);
                    window.removeEventListener('focus', onFocusCheck);
                    @this.recheckPrerequisites();
                }
            }, 800);

            // Respaldo para móviles: Si el usuario vuelve a la pestaña principal del navegador
            function onFocusCheck() {
                if (popup && popup.closed) {
                    clearInterval(poller);
                    window.removeEventListener('focus', onFocusCheck);
                    @this.recheckPrerequisites();
                }
            }
            window.addEventListener('focus', onFocusCheck);
        }

        // Listener del evento despachado por Livewire con la URL de OAuth generada por GoogleCalender service
        window.addEventListener('openGoogleCalendarPopup', (e) => {
            openGoogleCalendarPopupWithUrl(e.detail.url);
        });

        // Alias para compatibilidad con cualquier llamada directa que pudiera quedar en el DOM
        function openGoogleCalendarAuthPopup() {
            openGoogleCalendarPopupWithUrl('/google/authenticate');
        }
    </script>
@endpush
