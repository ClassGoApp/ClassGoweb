@if(!empty(setting('_general.enable_multi_language')))
    @if(!empty(setting('_general.multi_language_list')))
        @php
            $translatedLangs = getTranslatedLanguages();
            $selectedLang = app()->getLocale() ?? 'en';
        @endphp
        <form class="am-switch-language am-multi-lang" action="{{ route('switch-lang') }}" method="POST">
            @csrf
            <div>
                <input type="hidden" name="am-locale">
                <div class="am-language-select">
                    <a href="javascript:void(0);" class="am-lang-anchor" style="color: black">
                        <img src="{{ getLangFlag($selectedLang) }}" alt="{{ $selectedLang }}">
                        {{ $translatedLangs[$selectedLang] }}</i>
                    </a>
                    <ul class="sub-menutwo locale-menu">
                        @foreach(setting('_general.multi_language_list') as $lang)
                            <li data-lang="{{ $lang }}" class="{{ $selectedLang == $lang ? 'active' : '' }}">
                                <span><img src="{{ getLangFlag($lang) }}" alt="{{ $lang }}">{{ $translatedLangs[$lang] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const currentLang = @json($selectedLang);

                localStorage.setItem('selectedLanguage', currentLang);

                if (typeof selectLanguage === 'function') {
                    selectLanguage(currentLang, false);
                }

                document.querySelectorAll('.locale-menu li[data-lang]').forEach(function (item) {
                    item.addEventListener('click', function () {
                        const lang = this.getAttribute('data-lang');

                        localStorage.setItem('selectedLanguage', lang);

                        if (typeof selectLanguage === 'function') {
                            selectLanguage(lang, false);
                        }

                        document.dispatchEvent(new CustomEvent('languageChanged', {
                            detail: { lang: lang }
                        }));
                    });
                });
            });
        </script>
    @endif
@endif