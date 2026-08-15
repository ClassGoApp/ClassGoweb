<div class="language-select {{ $variant ?? '' }}">
    <div class="selected-option" onclick="toggleDropdown()">
        <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f1ea-1f1f8.svg" alt="Español">
        <span>Español</span>
    </div>
    <ul class="options-dropdown" id="languageDropdown">
        <li onclick="selectLanguage('es')">
            <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f1ea-1f1f8.svg" alt="Español">
            Español
        </li>
        <li onclick="selectLanguage('en')">
            <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f1ec-1f1e7.svg" alt="English">
            English
        </li>
        <li onclick="selectLanguage('pt')">
            <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f1f5-1f1f9.svg" alt="Português">
            Português
        </li>
    </ul>
</div>
