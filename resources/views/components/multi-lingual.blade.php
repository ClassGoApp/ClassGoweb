@if(!empty(setting('_general.enable_multi_language')))
    @if(!empty(setting('_general.multi_language_list')))
        @php
            $selectedLang = request()->cookie(
                'selectedLanguage',
                app()->getLocale() ?? 'es'
            );

            if (!in_array($selectedLang, ['es', 'en', 'pt'], true)) {
                $selectedLang = 'es';
            }
        @endphp
        <form class="am-switch-language am-multi-lang" action="{{ route('switch-lang') }}" method="POST">
            @csrf
            <div>
                <input type="hidden" name="am-locale">
                <div class="am-language-select">
                    <a href="javascript:void(0);" class="am-lang-anchor" style="color: black">
                        <img src="{{ getLangFlag($selectedLang) }}" alt="{{ $selectedLang }}">

                        <span class="am-current-language-name"
                            data-language-code="{{ $selectedLang }}">
                        </span>
                    </a>
                    <ul class="sub-menutwo locale-menu">
                        @foreach(setting('_general.multi_language_list') as $lang)
                            <li data-lang="{{ $lang }}"
                                class="{{ $selectedLang == $lang ? 'active' : '' }}">

                                <span>
                                    <img src="{{ getLangFlag($lang) }}" alt="{{ $lang }}">

                                    <span class="am-language-name"
                                        data-language-code="{{ $lang }}">
                                    </span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </form>
        <script>
            function getCookieValue(name) {
                const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                return match ? decodeURIComponent(match[2]) : null;
            }

            function updateLanguageSwitcherView(lang) {
                const activeItem = document.querySelector(
                    `.locale-menu li[data-lang="${lang}"]`
                );

                const anchor = document.querySelector('.am-lang-anchor');

                if (!activeItem || !anchor) {
                    return;
                }

                const itemImg = activeItem.querySelector('img');
                const anchorImg = anchor.querySelector('img');
                const anchorName = anchor.querySelector('.am-current-language-name');

                if (itemImg && anchorImg) {
                    anchorImg.src = itemImg.src;
                    anchorImg.alt = lang;
                }

                if (anchorName) {
                    anchorName.setAttribute('data-language-code', lang);
                    anchorName.textContent = getTranslatedLanguageName(lang);
                }

                document.querySelectorAll('.locale-menu li[data-lang]').forEach(function(li) {
                    li.classList.remove('active');
                });

                activeItem.classList.add('active');

                applyTranslatedLanguageNames();
            }

            window.initLanguageSwitcher = function () {
                const backendLang = @json($selectedLang);

                let currentLang =
                    getCookieValue('selectedLanguage') ||
                    localStorage.getItem('selectedLanguage') ||
                    backendLang ||
                    'es';

                if (!['es', 'en', 'pt'].includes(currentLang)) {
                    currentLang = 'es';
                }

                localStorage.setItem('selectedLanguage', currentLang);
                document.cookie = `selectedLanguage=${currentLang}; path=/; max-age=31536000; SameSite=Lax`;

                applyTranslatedLanguageNames();
                updateLanguageSwitcherView(currentLang);

                if (typeof selectLanguage === 'function') {
                    selectLanguage(currentLang, false);
                }

                document.querySelectorAll('.locale-menu li[data-lang]').forEach(function (item) {
                    item.onclick = function (event) {
                        event.preventDefault();

                        const lang = this.getAttribute('data-lang');

                        localStorage.setItem('selectedLanguage', lang);
                        document.cookie = `selectedLanguage=${lang}; path=/; max-age=31536000; SameSite=Lax`;

                        const input = document.querySelector('input[name="am-locale"]');

                        if (input) {
                            input.value = lang;
                        }

                        updateLanguageSwitcherView(lang);

                        if (typeof selectLanguage === 'function') {
                            selectLanguage(lang, false);
                        }

                        document.dispatchEvent(new CustomEvent('languageChanged', {
                            detail: { lang: lang }
                        }));
                        setTimeout(function () {
                            window.location.reload();
                        }, 150);
                    };
                });
            };

            document.addEventListener('DOMContentLoaded', window.initLanguageSwitcher);
            document.addEventListener('livewire:navigated', window.initLanguageSwitcher);

            function getTranslatedLanguageName(languageCode) {
                const currentLang =
                    localStorage.getItem('selectedLanguage') ||
                    getCookieValue('selectedLanguage') ||
                    'es';

                const languageKeys = {
                    es: 'language_spanish',
                    en: 'language_english',
                    pt: 'language_portuguese'
                };

                const fallbackNames = {
                    es: 'Español',
                    en: 'Inglés',
                    pt: 'Portugués'
                };

                if (typeof translations === 'undefined') {
                    return fallbackNames[languageCode] || languageCode;
                }

                const currentTranslations =
                    translations[currentLang] ||
                    translations.es ||
                    {};

                const key = languageKeys[languageCode];

                return currentTranslations[key]
                    || fallbackNames[languageCode]
                    || languageCode;
            }

            function applyTranslatedLanguageNames() {
                document.querySelectorAll('[data-language-code]').forEach(function(element) {
                    const languageCode = element.getAttribute('data-language-code');

                    element.textContent = getTranslatedLanguageName(languageCode);
                });
            }

            document.addEventListener('languageChanged', function() {
                applyTranslatedLanguageNames();

                const currentLang =
                    localStorage.getItem('selectedLanguage') ||
                    'es';

                updateLanguageSwitcherView(currentLang);
            });
        </script>
    @endif
@endif