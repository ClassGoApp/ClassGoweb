<div class="am-sidebar" style="background-color:white">
    <div class="am-sidebar_logo">
        <strong class="am-logo">
            <a href=" {{ route('home') }}"><img src="{{ asset('images/ClassGo-81.png')}}"></a>
            {{-- <x-application-logo /> --}}
        </strong>
        <div class="am-sidebar_toggle">
            <a href="javascript:void(0);">
                <i class="am-icon-dashbard"></i>
            </a>
        </div>
    </div>
    <nav class="am-navigation">
    <ul>
        @foreach ($menuItems as $item)
            @if(in_array($role, $item['accessibility']))
                @php
                    $isActiveParent = in_array($activeRoute, $item['onActiveRoute']);
                @endphp

                @if(isset($item['submenu']))
                    {{-- Contenedor del acordeón --}}
                    <li x-data="{ open: false }" style="list-style: none; margin: 0; padding: 0;">
                        
                        {{-- BOTÓN PADRE --}}
                        <a href="javascript:void(0);" @click="open = !open" 
                           style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-radius: 10px; width: 100%; box-sizing: border-box; background-color: {{ $isActiveParent ? '#1a9bb7' : 'transparent' }}; color: {{ $isActiveParent ? 'white' : '#585858' }}; text-decoration: none; transition: background-color 0.3s;">
                            
                            {{-- Contenedor del icono y el texto (Evita que el texto se rompa en dos líneas) --}}
                            <div style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                {!! $item['icon'] !!}
                                <span>{{ $item['title'] }}</span>
                            </div>
                            
                            {{-- Contenedor estricto para la flecha. Esto EVITA que se vuelva gigante --}}
                            <span style="display: flex; align-items: center; justify-content: center; width: 16px; height: 16px; min-width: 16px; max-width: 16px; flex-shrink: 0;">
                                <svg x-bind:style="open ? 'transform: rotate(180deg);' : ''" style="transition: transform 0.3s ease; width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </a>
                        
                        {{-- SUBMENÚ (Efecto Acordeón con max-height) --}}
                        <ul x-bind:style="open ? 'max-height: 150px; opacity: 1;' : 'max-height: 0px; opacity: 0;'" 
                            style="overflow: hidden; transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out; margin: 0; padding-left: 35px; list-style: none; display: block;">
                            
                            {{-- Espaciador superior opcional para que no quede pegado al abrir --}}
                            <div style="padding-top: 5px;"></div>

                            @foreach($item['submenu'] as $subItem)
                                @php
                                    $isActiveChild = in_array($activeRoute, $subItem['onActiveRoute']);
                                @endphp
                                <li style="margin-bottom: 4px; line-height: none; list-style: none;">
                                    <a href="{{ route($subItem['route']) }}" {{ empty($item['disableNavigate']) ? 'wire:navigate.remove' : '' }} 
                                       style="color: {{ $isActiveChild ? '#1a9bb7' : '#585858' }}; font-size: 1em; font-weight: {{ $isActiveChild ? 'bold' : 'normal' }}; display: block; text-decoration: none; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
                                        {{ $subItem['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else   
                    {{-- BOTÓN NORMAL (SIN SUBMENÚ) --}}
                    <li @class(['am-active-nav' => $isActiveParent]) style="list-style: none; width: 100%;">
                        <a href="{{ route($item['route']) }}" {{ empty($item['disableNavigate']) ? 'wire:navigate.remove' : '' }} 
                           style="display: flex; align-items: center; padding: 10px 15px; border-radius: 10px; width: 100%; box-sizing: border-box; background-color: {{ $isActiveParent ? '#1a9bb7' : 'transparent' }}; color: {{ $isActiveParent ? 'white' : '#585858' }}; text-decoration: none;">
                            <div style="display: flex; align-items: center; gap: 10px; white-space: nowrap;">
                                {!! $item['icon'] !!}
                                <span>{{ $item['title'] }}</span>
                            </div>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</nav>
    <div class="am-navigation_footer">
        <!--<div class="am-wallet">
            <div class="am-wallet_title">
                <span class="am-wallet_title_icon">
                    <i class="am-icon-invoices-01-5"></i>
                </span>
                <div class="am-wallet_balance">
                    <strong>{!! formatAmount($balance, true) !!}<span>{{ __('general.wallet_balance') }}</span></strong>
                </div>
            </div>
            <a href="javascript:void(0);" wire:click="openModel"  class="am-wallet_withdraw">
                {{ __('general.withdraw_now') }}
            </a>
        </div>><!-->
        <div class="am-signout" wire:click="logout">
            <a href="javascript:void(0);" class="am-signout_nav">
                <i class="am-icon-sign-out-02"></i>
                {{ __('general.sign_out') }}
            </a>
        </div>
    </div>
    <div wire:ignore.self class="modal fade am-setuppayoneerpopup" id="amount" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2>{{ __('tutor.setup_payoneer_account',['payout_method' => ucfirst($userPayoutMethod?->payout_method)]) }}</h2>
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <figure class="am-setup_img">
                        <img src="{{ asset('images/account-info-bg.png') }}" alt="img description">
                        <figcaption class="am-setup_img_content">
                            <span>{{ ucfirst($userPayoutMethod?->payout_method) }}</span>
                            <figure class="am-setup_img_icon">
                                @if ($userPayoutMethod?->payout_method == 'paypal')
                                    <img src="{{ asset('images/paypal.svg') }}" alt="img description">
                                @elseif ($userPayoutMethod?->payout_method == 'payoneer')
                                    <img src="{{ asset('images/payoneer.svg') }}" alt="img description">
                                @endif
                            </figure>
                        </figcaption>
                    </figure>
                    <form class="am-themeform">
                        <fieldset>
                            <div @class(['form-group', 'am-invalid' => $errors->has('amount')])>
                                <x-input-label for="amount" class="am-important" :value="__('tutor.withdraw_amount')" />
                                <div class="am-maxamount">
                                    <x-text-input id="amount" wire:model="amount" name="amount" placeholder="{{ __('tutor.withdraw_amount') }}" type="text" />
                                    <x-input-label for="maxamount" :value="__('tutor.max_limit')" />
                                    <span>{{ number_format($balance, 2) }}</span>
                                </div>
                                <x-input-error field_name="amount" />
                            </div>
                            <div class="form-group am-form-btns">
                                <button wire:target="addWithdarwals" wire:loading.class="am-btn_disable" wire:click="addWithdarwals" type="button" class="am-btn">{{ __('tutor.save_update') }} </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-sidebar').toggleClass('am-togglesidebar');
        });
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-mainwrap').toggleClass('am-mainwrap_fullwidth');
        });
    });
</script>
