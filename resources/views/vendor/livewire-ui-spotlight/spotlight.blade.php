<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset

    <script>
        window.spotlightTranslateText = function (value, selectedLang = null) {
            const text = (value || '').trim();
            const lang = selectedLang || localStorage.getItem('selectedLanguage') || 'es';

            const keys = {
                'What do you want to do?': 'spotlight_placeholder',
                '¿Qué quieres hacer?': 'spotlight_placeholder',
                'O que você quer fazer?': 'spotlight_placeholder',

                'Cerrar sesión': 'spotlight_logout_name',
                'Sign out': 'spotlight_logout_name',
                'Sair': 'spotlight_logout_name',

                'Redirigir al usuario a la pantalla de inicio de sesión borrando la sesión del usuario': 'spotlight_logout_desc',
                'Redirect the user to the login screen by clearing the user session': 'spotlight_logout_desc',
                'Redireciona o usuário para a tela de login limpando a sessão do usuário': 'spotlight_logout_desc',

                'Buscar por nombre del tutor': 'spotlight_search_tutor_name',
                'Search by tutor name': 'spotlight_search_tutor_name',
                'Pesquisar por nome do tutor': 'spotlight_search_tutor_name',

                'Esto te redireccionará a la página de búsqueda de tutores.': 'spotlight_search_tutor_desc',
                'This will redirect you to the tutor search page.': 'spotlight_search_tutor_desc',
                'Isso redirecionará você para a página de busca de tutores.': 'spotlight_search_tutor_desc',

                'Detalles del Perfil': 'spotlight_profile_details_name',
                'Profile Details': 'spotlight_profile_details_name',
                'Detalhes do Perfil': 'spotlight_profile_details_name',

                'Redirigir a la página de detalles del perfil': 'spotlight_profile_details_desc',
                'Redirect to the profile details page': 'spotlight_profile_details_desc',
                'Redirecionar para a página de detalhes do perfil': 'spotlight_profile_details_desc',

                'Reservas': 'spotlight_bookings_name',
                'Bookings': 'spotlight_bookings_name',

                'Redirecciona a las reservas del estudiante': 'spotlight_bookings_desc',
                'Redirects to student bookings': 'spotlight_bookings_desc',
                'Redireciona para as reservas do estudante': 'spotlight_bookings_desc',

                'Favoritos': 'spotlight_favorites_name',
                'Favorites': 'spotlight_favorites_name',

                'Redirecciona a los tutores Favoritos': 'spotlight_favorites_desc',
                'Redirects to favorite tutors': 'spotlight_favorites_desc',
                'Redireciona para os tutores favoritos': 'spotlight_favorites_desc',
            };

            const spotlightTranslations = {
                es: {
                    spotlight_placeholder: "¿Qué quieres hacer?",
                    spotlight_logout_name: "Cerrar sesión",
                    spotlight_logout_desc: "Redirigir al usuario a la pantalla de inicio de sesión borrando la sesión del usuario",
                    spotlight_search_tutor_name: "Buscar por nombre del tutor",
                    spotlight_search_tutor_desc: "Esto te redireccionará a la página de búsqueda de tutores.",
                    spotlight_profile_details_name: "Detalles del Perfil",
                    spotlight_profile_details_desc: "Redirigir a la página de detalles del perfil",
                    spotlight_bookings_name: "Reservas",
                    spotlight_bookings_desc: "Redirecciona a las reservas del estudiante",
                    spotlight_favorites_name: "Favoritos",
                    spotlight_favorites_desc: "Redirecciona a los tutores Favoritos",
                },
                en: {
                    spotlight_placeholder: "What do you want to do?",
                    spotlight_logout_name: "Sign out",
                    spotlight_logout_desc: "Redirect the user to the login screen by clearing the user session",
                    spotlight_search_tutor_name: "Search by tutor name",
                    spotlight_search_tutor_desc: "This will redirect you to the tutor search page.",
                    spotlight_profile_details_name: "Profile Details",
                    spotlight_profile_details_desc: "Redirect to the profile details page",
                    spotlight_bookings_name: "Bookings",
                    spotlight_bookings_desc: "Redirects to student bookings",
                    spotlight_favorites_name: "Favorites",
                    spotlight_favorites_desc: "Redirects to favorite tutors",
                },
                pt: {
                    spotlight_placeholder: "O que você quer fazer?",
                    spotlight_logout_name: "Sair",
                    spotlight_logout_desc: "Redireciona o usuário para a tela de login limpando a sessão do usuário",
                    spotlight_search_tutor_name: "Pesquisar por nome do tutor",
                    spotlight_search_tutor_desc: "Isso redirecionará você para a página de busca de tutores.",
                    spotlight_profile_details_name: "Detalhes do Perfil",
                    spotlight_profile_details_desc: "Redirecionar para a página de detalhes do perfil",
                    spotlight_bookings_name: "Reservas",
                    spotlight_bookings_desc: "Redireciona para as reservas do estudante",
                    spotlight_favorites_name: "Favoritos",
                    spotlight_favorites_desc: "Redireciona para os tutores favoritos",
                }
            };

            const key = keys[text];
            const t = spotlightTranslations[lang] || spotlightTranslations.es;

            return key && t[key] ? t[key] : value;
        };
    </script>

    <div x-data="{
        ...LivewireUISpotlight({
            componentId: '{{ $this->id() }}',
            placeholder: '{{ trans('livewire-ui-spotlight::spotlight.placeholder') }}',
            commands: @js($commands),
            showResultsWithoutInput: '{{ config('livewire-ui-spotlight.show_results_without_input') }}',
        }),
        spotlightLang: localStorage.getItem('selectedLanguage') || 'es',
        refreshSpotlightLanguage() {
            this.spotlightLang = localStorage.getItem('selectedLanguage') || 'es';
        }
    }"
        x-init="init(); window.addEventListener('languageChanged', () => refreshSpotlightLanguage())"
        x-show="isOpen"
        x-cloak
         @foreach(config('livewire-ui-spotlight.shortcuts') as $key)
            @keydown.window.prevent.cmd.{{ $key }}="toggleOpen()"
            @keydown.window.prevent.ctrl.{{ $key }}="toggleOpen()"
         @endforeach
         @keydown.window.escape="isOpen = false"
         @toggle-spotlight.window="toggleOpen()"
         class="fixed z-50 px-4 pt-16 flex items-start justify-center inset-0 sm:pt-24">
        <div x-show="isOpen" @click="isOpen = false" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
        </div>

        <div x-show="isOpen" x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="am-search_menu relative bg-gray-900 rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
            <div class="relative">
                <div class="absolute h-full right-5 flex items-center">
                    <svg class="animate-spin h-5 w-5 text-white" fill="none"
                         viewBox="0 0 24 24" wire:loading.delay>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <input @keydown.tab.prevent="" @keydown.prevent.stop.enter="go()" @keydown.prevent.arrow-up="selectUp()"
                       @keydown.prevent.arrow-down="selectDown()" x-ref="input" x-model="input"
                       type="text"
                       style="caret-color: #6b7280;"
                       class=" am-search_input appearance-none w-full bg-transparent px-6 py-4 text-gray-300 text-lg placeholder-gray-500 focus:border-0 focus:border-transparent focus:shadow-none outline-none focus:outline-none"
                       x-bind:placeholder="window.spotlightTranslateText(inputPlaceholder, spotlightLang)">
            </div>
            <div class="am-search_menu_list border-t border-gray-800" x-show="filteredItems().length > 0" style="display: none;">
                <ul x-ref="results" style="max-height: 265px;" class="overflow-y-auto">
                    <template x-for="(item, i) in filteredItems()" :key>
                        <li>
                            <button @click="go(item[0].item.id)" class="block w-full px-6 py-3 text-left"
                                    :class="{ 'bg-[#295C51]': selected === i, 'hover:bg-[#295C51]': selected !== i }">
                                <span x-text="window.spotlightTranslateText(item[0].item.name, spotlightLang)"
                                       :class="{'text-gray-500': selected !== i, 'text-gray-500': selected === i }"></span>
                                <span x-text="window.spotlightTranslateText(item[0].item.description, spotlightLang)" class="ml-1"
                                       :class="{'text-gray-500': selected !== i, 'text-gray-500': selected === i }"></span>
                            </button>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
