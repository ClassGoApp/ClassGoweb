


<!-- Datos personales -->
<div class="tutor-profile-section">
    <form wire:submit.prevent="updateInfo" class="tutor-profile-section row g-4 am-themeform am-themeform_personalinfo">
        <div class="tutor-profile-data-card">
            <h2 class="tutor-profile-title"> {{ __('profile.personal_details') }} </h2>
            <p class="tutor-profile-sub"> {{ __('profile.personal_detail_desc') }} </p>
            <div class="tutor-profile-grid">
                <div class="tutor-profile-field">
                    <label>{{ __('profile.first_name') }} </label>
                    <input type="text" class="tutor-profile-input" wire:model="first_name">
                    @error('first_name')
                        <span style="color:rgb(251,133,0); font-size: medium;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="tutor-profile-field">
                    <label> {{ __('profile.last_name') }} </label>
                    <input type="text" class="tutor-profile-input" wire:model="last_name">
                    @error('last_name')
                        <span style="color:rgb(251,133,0);font-size: medium;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="tutor-profile-field">
                    <label> {{ __('profile.email') }} </label>
                    <input type="email" class="tutor-profile-input" wire:model="email" disabled>
                    @error('email')
                        <span style="color:rgb(251,133,0);font-size: medium;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="tutor-profile-field">
                    <label> {{ __('profile.phone_number') }} </label>
                    <input type="text" class="tutor-profile-input" wire:model="phone_number">
                    @error('phone_number')
                        <span style="color:rgb(251,133,0);font-size: medium;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @include('livewire.pages.common.profile-settings.components.genero')
            <div class="tutor-profile-field">
                <label> {{ __('profile.description') }} </label>
                <textarea class="tutor-profile-input-textarea" rows="3" wire:model="description"></textarea>
            </div>
            <div class="tutor-profile-grid">

                {{-- lengua nativa --}}
                <div class="tutor-profile-field" style="margin-bottom: 0rem;">
                    <label for="native_language" class="form-label m-2 text-black" style="margin-bottom: 0.5rem;">
                        {{ __('profile.native_language') }} <span class="text-red-500"></span>
                    </label>
                    <div class="modern-dropdown" tabindex="0">
                        <div class="modern-dropdown-toggle" onclick="toggleModernDropdown(this)"
                            id="nativeDropdownLabel">
                            <span class="{{ $native_language ? '' : 'modern-dropdown-placeholder' }}">
                                {{ $native_language ? __('lenguajes.' . $native_language) : __('profile.select_language') }}
                            </span>
                            <span class="modern-dropdown-arrow"></span>
                        </div>
                        <div class="modern-dropdown-menu">
                            <div class="modern-dropdown-search">
                                <input type="text"
                                    placeholder="{{ __('profile.search_language') }}"
                                    data-translate-placeholder="profile_search_language"
                                    onkeyup="filterModernLanguage(this)">
                            </div>
                            <div class="modern-dropdown-options" id="native-languages-list">
                                <div class="modern-dropdown-option" onclick="document.getElementById('lang0').click()">
                                    <input type="radio" name="native_language" wire:model="native_language"
                                        value="" id="lang0" onchange="selectModernOption(this)">
                                    <label for="lang0" style="width:100%;cursor:pointer;" data-translate="profile_select_language">
                                        {{ __('profile.select_language') }}
                                    </label>
                                </div>
                                @foreach ($languages as $id => $name)
                                    <div class="modern-dropdown-option {{ $native_language === $name ? 'selected' : '' }}"
                                        onclick="document.getElementById('lang{{ $id }}').click()">
                                        <input type="radio" name="native_language" wire:model="native_language"
                                            value="{{ $name }}" id="lang{{ $id }}"
                                            onchange="selectModernOption(this)">
                                        <label for="lang{{ $id }}"
                                            style="width:100%;cursor:pointer;">{{ __('lenguajes.' . $name) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>







                    </div>
                    @error('native_language')
                        <span style="color: #ef4444; font-size: 14px; margin-top: 4px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                {{-- /*******************************************************************/ --}}

                <div class="tutor-profile-field" style="margin-bottom: 0rem;">
                    <label for="languages" class="form-label m-2 text-black" style="margin-bottom: 0.5rem;">
                        <span data-translate="profile_choose_motto">
                            {{ __('profile.choose_motto') }}
                        </span><span class="text-danger"></span>
                    </label>

                    <div class="modern-dropdown" tabindex="0">
                        <div class="modern-dropdown-toggle" onclick="toggleModernDropdown(this)">
                            <span class="modern-dropdown-placeholder" data-translate="profile_select_motto">
                                {{ __('profile.select_motto') }}
                            </span>
                            <span class="modern-dropdown-arrow"></span>
                        </div>

                        <div id="selected-lema" @if (!$selected_lema) style="display:none" @endif
                            class="lema-box"
                            style="display: {{ $selected_lema ? 'flex' : 'none' }};margin-top:8px;padding:6px 10px;background:#f0f0f0;border-radius:6px;width:100%;align-items:center;gap:10px;">
                            <div
                                style="display: flex;
                                      justify-content: space-between;
                                     align-items: center; width:100%;">
                                @php
                                    $mottoIndex = $selected_lema
                                        ? array_search($selected_lema, $personalStatements, true)
                                        : false;
                                @endphp
                                <span id="selected-lema-text"
                                      style="font-size:20px;"
                                      @if($mottoIndex !== false)
                                          data-translate="profile_motto_{{ $mottoIndex }}"
                                      @endif>
                                    {{ $selected_lema }}
                                </span>

                                <span style="cursor:pointer;color:red;font-weight:bold; "
                                    wire:click="removeLema">×</span>
                            </div>

                        </div>

                        <div class="modern-dropdown-menu">
                            <div class="modern-dropdown-search">
                                <input type="text"
                                    placeholder="{{ __('profile.search_motto') }}"
                                    data-translate-placeholder="profile_search_motto"
                                    onkeyup="filterModernLanguage(this)">
                            </div>

                            <div class="modern-dropdown-options">
                                @foreach ($personalStatements as $index => $statement)
                                    <label class="modern-dropdown-option" style="cursor:pointer;">
                                        <span style="width:100%;font-weight:bold;"
                                            wire:click="selectLema({{ $index }})"
                                            data-translate="profile_motto_{{ $index }}">
                                            {{ $statement }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>



                </div>



                {{-- /******************************************************************************/ --}}









                {{-- idiomas adicionales --}}
                <div class="tutor-profile-field" style="margin-bottom: 0rem;">
                    <label for="languages" class="form-label m-2 text-black" style="margin-bottom: 0.5rem;">
                        {{ __('profile.other_languages') }} <span class="text-danger"></span>
                    </label>

                    <div class="modern-dropdown" tabindex="0">
                        <div class="modern-dropdown-toggle" onclick="toggleModernDropdown(this)">
                            <span class="modern-dropdown-placeholder" data-translate="profile_select_languages">
                                {{ __('profile.select_languages') }}
                            </span>
                            <span class="modern-dropdown-arrow"></span>
                        </div>
                        <div class="modern-dropdown-menu">
                            <div class="modern-dropdown-search">
                                <input type="text"
                                    placeholder="{{ __('profile.search_languages') }}"
                                    data-translate-placeholder="profile_search_languages"
                                    onkeyup="filterModernLanguage(this, 'languages-list')">
                            </div>
                            <div class="modern-dropdown-options" id="languages-list">
                                @foreach ($languages as $id => $name)
                                    @if (!in_array($id, $user_languages) && $id != $native_language)
                                        <label class="modern-dropdown-option" for="lang{{ $id }}_chk"
                                            style="width:100%;cursor:pointer;">
                                            <input type="checkbox" wire:model.live="selected_languages"
                                                value="{{ $id }}" id="lang{{ $id }}_chk"
                                                onchange="selectModernMultiOption(this)">
                                            {{ __('lenguajes.' . $name) }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>










                <div class="d-flex flex-wrap gap-2 mt-3">
                    @if (count($user_languages) > 0)
                        @foreach ($user_languages as $langId)
                            @if (isset($languages[$langId]))
                                <div class="badge bg-primary p-2 d-flex align-items-center"
                                    style="font-size: 0.9rem;height:2rem;">
                                    <span class="text-white">{{ __('lenguajes.' . $languages[$langId]) }}</span>
                                    <button type="button" class="btn-close btn-close-white ms-2"
                                        style="font-size: 0.7rem;" wire:click="removeLanguage({{ $langId }})">
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-white-50">
                            <span data-translate="profile_selected_languages">
                                {{ __('profile.selected_languages') }}
                            </span>
                        </div>
                    @endif
                </div>



            </div>




        </div>
        <!-- Imagen y video -->
        <div class="tutor-profile-media-row">


            <div class="tutor-profile-media-card">
                @include('livewire.pages.common.profile-settings.components.imagenes')
            </div>

            <div class="tutor-profile-media-card">
                @include('livewire.pages.common.profile-settings.components.videos')
            </div>


        </div>

        @role('tutor')
         <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('passwords.link_google_calendar') }}</h2>
                <p>{{ __('passwords.link__google_calendar_schedule') }}</p>
            </div>
        </div> 
        <div class="am-linkaccount">
            @if(!empty($getAccountSetting['google_access_token']))
            <div class="am-linkaccount_option">
                <div class="am-linkaccount_option_title">
                    <span>{{ __('passwords.connected_account') }}</span>
                    @if(isset($getAccountSetting['google_calendar_info']['summary']))
                        <h4>{{ $getAccountSetting['google_calendar_info']['summary'] }}</h4>
                    @endif
                </div>
                <a wire:click.prevent="disconnectCalender" href="#" wire:target="disconnectCalender"  wire:loading.class="am-btn_disable" class="am-linkbtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_689_18487)"><path d="M23.7663 12.2765C23.7663 11.4608 23.7001 10.6406 23.559 9.83813H12.2402V14.4591H18.722C18.453 15.9495 17.5888 17.2679 16.3233 18.1056V21.104H20.1903C22.4611 19.014 23.7663 15.9274 23.7663 12.2765Z" fill="#4285F4"/><path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/><path d="M5.50277 14.3002C5.00011 12.8099 5.00011 11.196 5.50277 9.70569V6.61475H1.51674C-0.185266 10.0055 -0.185266 14.0004 1.51674 17.3912L5.50277 14.3002Z" fill="#FBBC04"/><path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/></g><defs><clipPath id="clip0_689_18487"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                    {{ __('passwords.disconnect_google_calendar') }}
                    
                </a>
            </div>
            @else
            <div class="am-linkaccount_option">
                <div class="am-linkaccount_option_title">
                    <span>{{ __('passwords.no_calendar_linked') }}</span>
                </div>
                <a wire:click.prevent="connectCalender" href="#" wire:target="connectCalender"  wire:loading.class="am-btn_disable" class="am-linkbtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_689_18487)"><path d="M23.7663 12.2765C23.7663 11.4608 23.7001 10.6406 23.559 9.83813H12.2402V14.4591H18.722C18.453 15.9495 17.5888 17.2679 16.3233 18.1056V21.104H20.1903C22.4611 19.014 23.7663 15.9274 23.7663 12.2765Z" fill="#4285F4"/><path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3276 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/><path d="M5.50277 14.3002C5.00011 12.8099 5.00011 11.196 5.50277 9.70569V6.61475H1.51674C-0.185266 10.0055 -0.185266 14.0004 1.51674 17.3912L5.50277 14.3002Z" fill="#FBBC04"/><path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.61481L5.50264 9.70575C6.45064 6.86173 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/></g><defs><clipPath id="clip0_689_18487"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                    {{ __('passwords.connect_google_calendar') }}
                </a>
            </div>
            @endif  
        </div> 
       @endrole
       
        @if(session()->get('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Livewire.dispatch('showAlertMessage', {
                        type: 'error',
                        title: @json(__('passwords.failed_google_calendar')),
                        message: @json(__('passwords.failed_google_token'))
                    });
                });
            </script>
        @endif
        @if(session()->get('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Livewire.dispatch('showAlertMessage', {
                        type: 'success',
                        title: @json(__('passwords.connect_google_calendar')),
                        message: @json(__('passwords.connect_calender'))
                    });
                });
            </script>
        @endif     


        <div class="profile-details-actions">
            <x-primary-button class="button_save" type="submit" wire:loading.class="am-btn_disable"
                wire:target="updateInfo">
                {{ __('general.save_changes') }}
            </x-primary-button>
        </div>
    </form>

</div>







<!-- Botón guardar -->
@push('styles')
    <style>
        .am-linkaccount{
margin-bottom:20px;
margin-top:0px;

        }
        .modern-dropdown-options input[type="checkbox"] {
            accent-color: #3b82f6;
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .modern-dropdown-option.selected {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 500;
        }

        .modern-dropdown-option.selected::after {
            content: '✓';
            margin-left: auto;
            font-weight: bold;
            color: #3b82f6;
        }
    </style>
@endpush




@push('styles')
    <link rel="stylesheet" href="{{ asset('css/livewire/pages/common/profile-settings/components/tutor.css') }}">
@endpush


@push('scripts')
    <script>
        /* window.filterModernLanguage = function(input, listId = null) {
                                                                                                    console.log('llega al filtro');
                                                                                                    const filter = input.value.toLowerCase();
                                                                                                    const listSelector = listId ? '#' + listId + ' .modern-dropdown-option' : '.modern-dropdown-option';
                                                                                                    const options = input.closest('.modern-dropdown-menu').querySelectorAll(listSelector);
                                                                                                    options.forEach(function(option) {
                                                                                                        const label = option.querySelector('label');
                                                                                                        if (label) {
                                                                                                            const text = label.textContent.toLowerCase();
                                                                                                            option.style.display = text.includes(filter) ? '' : 'none';
                                                                                                        }
                                                                                                    });
                                                                                                } */
        // Selección múltiple visual
        window.selectModernMultiOption = function(input) {
            const option = input.closest('.modern-dropdown-option');
            if (input.checked) {
                option.classList.add('selected');
            } else {
                option.classList.remove('selected');
            }
        }
    </script>
@endpush



@push('scripts')
    <script>
        // Función para alternar el dropdown
        window.toggleModernDropdown = function(toggle) {
            const dropdown = toggle.closest('.modern-dropdown');
            const isOpen = dropdown.classList.contains('open');

            // Cerrar todos los otros dropdowns abiertos
            document.querySelectorAll('.modern-dropdown.open').forEach(function(openDropdown) {
                if (openDropdown !== dropdown) {
                    openDropdown.classList.remove('open');
                }
            });

            // Alternar el dropdown actual
            dropdown.classList.toggle('open', !isOpen);

            // Focus en el input de búsqueda cuando se abre
            if (!isOpen) {
                setTimeout(() => {
                    const searchInput = dropdown.querySelector('.modern-dropdown-search input');
                    if (searchInput) {
                        searchInput.focus();
                    }
                }, 150);
            }
        }

        // Función para filtrar idiomas
        window.filterModernLanguage = function(input) {
            //console.log('llega al filtro',input);
            const filter = input.value.toLowerCase();
            console.log('Filtrando idiomas con:', filter);
            const options = input.closest('.modern-dropdown-menu').querySelectorAll('.modern-dropdown-option');
            console.log('idiomas encontrados ', options);
            let hasVisibleOptions = false;
            options.forEach(function(option) {
                // Si option es un label (otros idiomas), úsalo directamente
                // Si option es un div (idioma nativo), busca el label hijo
                let label;
                if (option.tagName.toLowerCase() === 'label') {
                    label = option;
                } else {
                    label = option.querySelector('label');
                }
                console.log('que es esto', label);
                if (label) {
                    const text = label.textContent.toLowerCase();
                    const isVisible = text.includes(filter);
                    option.style.display = isVisible ? '' : 'none';
                    if (isVisible) hasVisibleOptions = true;
                }
            });
        }

        // Función para seleccionar una opción
        window.selectModernOption = function(input) {
            console.log('Selecting option:', input.value);
            const dropdown = input.closest('.modern-dropdown');
            const toggle = dropdown.querySelector('.modern-dropdown-toggle span:first-child');
            const label = input.nextElementSibling;

            // Actualizar el texto del toggle
            if (input.value === '') {
                toggle.textContent = 'Selecciona un idioma';
                toggle.classList.add('modern-dropdown-placeholder');
            } else {
                toggle.textContent = label.textContent;
                toggle.classList.remove('modern-dropdown-placeholder');
            }

            // Remover clase 'selected' de todas las opciones y agregarla a la actual
            dropdown.querySelectorAll('.modern-dropdown-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            if (input.checked) {
                input.closest('.modern-dropdown-option').classList.add('selected');
            }

            // Cerrar el dropdown
            dropdown.classList.remove('open');

            // Limpiar el filtro de búsqueda
            const searchInput = dropdown.querySelector('.modern-dropdown-search input');
            if (searchInput) {
                searchInput.value = '';
                filterModernLanguage(searchInput);
            }
        }

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.modern-dropdown').forEach(function(dropdown) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        // Navegación con teclado
        document.addEventListener('keydown', function(e) {
            const openDropdown = document.querySelector('.modern-dropdown.open');
            if (!openDropdown) return;

            const options = Array.from(openDropdown.querySelectorAll(
                '.modern-dropdown-option:not([style*="display: none"])'));
            const currentSelected = openDropdown.querySelector('.modern-dropdown-option.selected');
            let currentIndex = options.indexOf(currentSelected);

            switch (e.key) {
                case 'Escape':
                    openDropdown.classList.remove('open');
                    openDropdown.querySelector('.modern-dropdown-toggle').focus();
                    e.preventDefault();
                    break;

                case 'ArrowDown':
                    e.preventDefault();
                    currentIndex = Math.min(currentIndex + 1, options.length - 1);
                    if (options[currentIndex]) {
                        const radio = options[currentIndex].querySelector('input[type="radio"]');
                        radio.checked = true;
                        selectModernOption(radio);
                    }
                    break;

                case 'ArrowUp':
                    e.preventDefault();
                    currentIndex = Math.max(currentIndex - 1, 0);
                    if (options[currentIndex]) {
                        const radio = options[currentIndex].querySelector('input[type="radio"]');
                        radio.checked = true;
                        selectModernOption(radio);
                    }
                    break;

                case 'Enter':
                case ' ':
                    if (currentSelected) {
                        e.preventDefault();
                        const radio = currentSelected.querySelector('input[type="radio"]');
                        radio.checked = true;
                        selectModernOption(radio);
                    }
                    break;
            }
        });
        /*****************************oscar js********************/

        // --- Abrir o cerrar (solo dropdown de LEMA) ---
        function toggleModernDropdown(el) {

            // Verificar si este dropdown es el del lema
            const dropdown = el.closest(".modern-dropdown");

            // Cerrar los otros dropdowns
            document.querySelectorAll(".modern-dropdown.open").forEach(d => {
                if (d !== dropdown) d.classList.remove("open");
            });

            // Abrir o cerrar este
            dropdown.classList.toggle("open");
        }



        // --- Filtro de lemas ---
        function filterModernLanguage(input) {
            const filter = input.value.toLowerCase();
            const options = input.closest(".modern-dropdown-menu").querySelectorAll(".modern-dropdown-option");

            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(filter) ? "" : "none";
            });
        }

        // --- Cerrar dropdown si se hace click afuera ---
        document.addEventListener("click", function(e) {
            document.querySelectorAll(".modern-dropdown").forEach(dd => {
                if (!dd.contains(e.target)) dd.classList.remove("open");
            });
        });
    </script>
@endpush
