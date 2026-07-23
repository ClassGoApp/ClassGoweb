<ul class="am-userperinfo_tab">
    <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.personal-details'])>
        <a href="{{ route(auth()->user()->role.'.profile.personal-details') }}" wire:navigate.remove>
            <span data-translate="profile_personal_details">
                {{ __('profile.personal_details') }}
            </span>
        </a>
    </li>

    <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.account-settings'])>
        <a href="{{ route(auth()->user()->role.'.profile.account-settings') }}" wire:navigate.remove>
            <span data-translate="profile_account_settings">
                {{ __('profile.account_settings') }}
            </span>
        </a>
    </li>

    @role('tutor')
        <li @class(['am-active'=> in_array($activeRoute , [auth()->user()->role.'.profile.resume.education', auth()->user()->role.'.profile.resume.experience', auth()->user()->role.'.profile.resume.certificate'])])>
            <a href="{{ route('tutor.profile.resume.education') }}" wire:navigate.remove>
                <span data-translate="profile_resume_highlights">
                    {{ __('profile.resume_highlights') }}
                </span>
            </a>
        </li>
    @endrole
    
    @php
        $isIdentity = setting('_lernen.identity_verification_for_role') ?? "both";
    @endphp

    @if(auth()->user()->role == 'tutor' || $isIdentity == 'both')
        <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.identification'])>
            <a href="{{ route(auth()->user()->role.'.profile.identification') }}" wire:navigate.remove>
                <span data-translate="profile_identity_verification">
                    {{ __('profile.identity_verification') }}
                </span>
            </a>
        </li>
    @endif
</ul>