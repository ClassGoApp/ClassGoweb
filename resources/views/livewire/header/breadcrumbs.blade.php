@unless($breadcrumbs->isEmpty())
    <ol class="am-breadcrumb">
        
        @foreach($breadcrumbs as $breadcrumb)

            @php
                $breadcrumbTitle = trim($breadcrumb->title);

                $breadcrumbTranslations = [
                    'Tutorias' => 'breadcrumb_tutoring',
                    'Tutorías' => 'breadcrumb_tutoring',
                    'Tutoring' => 'breadcrumb_tutoring',
                    'Tutorias' => 'breadcrumb_tutoring',

                    'Configuración de perfil' => 'breadcrumb_profile_settings',
                    'Profile Settings' => 'breadcrumb_profile_settings',
                    'Configurações de perfil' => 'breadcrumb_profile_settings',

                    'Detalles personales' => 'profile_personal_details',
                    'Personal Details' => 'profile_personal_details',
                    'Detalhes pessoais' => 'profile_personal_details',

                    'Configuraciones de la cuenta' => 'profile_account_settings',
                    'Account Settings' => 'profile_account_settings',
                    'Configurações da conta' => 'profile_account_settings',

                    'Reservas' => 'breadcrumb_bookings',
                    'Bookings' => 'breadcrumb_bookings',
                ];

                $translateKey = $breadcrumbTranslations[$breadcrumbTitle] ?? null;
            @endphp

            @if(!is_null($breadcrumb->url) && !$loop->last)
                <li>
                    <a
                        style="color: black; font-size: 20px"
                        href="{{ $breadcrumb->url }}"
                        wire:navigate.remove
                        @if($translateKey) data-translate="{{ $translateKey }}" @endif>
                        {{ $breadcrumbTitle }}
                    </a>
                </li>

                <li>
                    <em style="color: black; font-size: 20px;">/</em>
                </li>
                
            @else
                <li class="active">
                    <span
                        style="color:#219EBC; font-size: 20px"
                        @if($translateKey) data-translate="{{ $translateKey }}" @endif>
                        {{ $breadcrumbTitle }}
                    </span>
                </li>
            @endif

        @endforeach
    </ol>
@endunless
