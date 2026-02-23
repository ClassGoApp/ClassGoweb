<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\RegisterService;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Url;

new #[Layout('layouts.guest')] class extends Component
{
    #[Url] 
    public $mode = '';
    
    // --- 1. LÓGICA LOGIN ---
    public LoginForm $form;


    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title'), message: __('general.login_success'));
        usleep(500);
        $this->redirect(auth()->user()->redirect_after_login);
    }

    // --- 2. LÓGICA REGISTRO ---
    public string $reg_first_name = '';
    public string $reg_last_name = '';
    public string $reg_email = '';
    public string $reg_password = '';
    public string $reg_password_confirmation = '';
    public string $user_role = 'student';
    public bool $terms = false;
    public string $phone_number = '';
    public bool $isProfilePhoneMendatory = true;
    
    public $tutor_name = '';
    public $student_name = '';

    // --- 3. LÓGICA RECUPERAR CONTRASEÑA ---
    public string $forgot_email = ''; 
    public string $forgot_status = ''; 

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'forgot_email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(['email' => $this->forgot_email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->forgot_status = __($status);
            $this->forgot_email = ''; 
            $this->dispatch('showAlertMessage', type: 'success', title: 'Enviado', message: __($status));
        } else {
            $this->addError('forgot_email', __($status));
        }
    }

    public function mount(): void
    {
        $this->tutor_name = !empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor');
        $this->student_name = !empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student');
        $this->isProfilePhoneMendatory = setting('_lernen.phone_number_on_signup') === 'yes' ? true : false;
    }

    public function register(): void
    {
        if (isDemoSite()) {
            $this->dispatch('showAlertMessage', type: 'error', title: __('general.demosite_res_title'), message: __('general.demosite_res_txt'));
            return;
        }

        $this->validate([
            'reg_first_name' => ['required', 'string', 'max:255'],
            'reg_last_name'  => ['required', 'string', 'max:255'],
            'reg_email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email'],
            'reg_password'   => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'user_role'      => ['required', 'in:student,tutor'],
            'terms'          => ['accepted'],
            'phone_number'   => $this->isProfilePhoneMendatory ? ['required'] : ['nullable'],
        ], [
            'reg_password.confirmed' => __('Las contraseñas no coinciden'),
        ]);

        $data = [
            'first_name'    => $this->reg_first_name,
            'last_name'     => $this->reg_last_name,
            'email'         => $this->reg_email,
            'password'      => $this->reg_password,
            'user_role'     => $this->user_role,
            'phone_number' => $this->phone_number,
        ];

        $user = (new RegisterService)->registerUser($data);
        Auth::login($user);
        $this->redirect(route('tutor.profile.personal-details', absolute: false), navigate: true);
    }

    public function redirectGoogle()
    {
        if (isDemoSite()) { return; }
        return $this->redirect(route('social.redirect', ['provider' => 'google']));
    }
};
?>

<div>
    <style>
        /* VARIABLES */
        :root {
            --cg-primary: #219EBC;
            --cg-primary-dark: #023047;
            --cg-accent: #FB8500;
            --cg-accent-hover: #FB8500;
            --cg-bg-input: #f0f4f8; 
        }

        /* 1. WRAPPER PRINCIPAL */
        .cg-auth-wrapper {
            font-family: system-ui, -apple-system, sans-serif;
            background: radial-gradient(circle at center, #1a3c5a 0%, #000b18 100%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        /* 2. TARJETA */
        .cg-card {
            background-color: #fff;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 650px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        }

        /* 3. PANELES DESLIZANTES */
        .cg-form-panel {
            position: absolute; 
            top: 0; 
            min-height: 100%;
            height: auto;
            transition: all 0.6s ease-in-out;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            overflow-y: auto;
        }

        .cg-login { left: 0; width: 50%; z-index: 2; }
        .cg-register { left: 0; width: 50%; opacity: 0; z-index: 1; }

        .cg-card.right-panel-active .cg-login { transform: translateX(100%); opacity: 0; }
        .cg-card.right-panel-active .cg-register { transform: translateX(100%); opacity: 1; z-index: 5; animation: cg-show 0.6s; }

        @keyframes cg-show { 0%, 49.99% { opacity: 0; z-index: 1; } 50%, 100% { opacity: 1; z-index: 5; } }

        /* 4. FORMULARIO ESTILOS */
        .cg-form {
            background-color: #ffffff;
            display: flex; flex-direction: column; padding: 0 30px;
            height: 100%; width: 100%;
            text-align: center; justify-content: center;
            box-sizing: border-box;
        }

        .cg-title { font-weight: 700; color: var(--cg-primary); font-size: 2.2rem; margin: 0 0 10px; }
        .cg-desc { font-size: 1rem; color: #666; margin: 5px 0 20px; }
        
        .cg-input-row { display: flex; gap: 10px; width: 100%; margin-bottom: 0px; }
        .cg-input-group { width: 100%; text-align: left; margin-bottom: 22px; position: relative; }
        
        /* INPUT BOX */
        .cg-input-box {
            background-color: var(--cg-bg-input);
            border-radius: 50px;
            width: 100%;
            display: flex; align-items: center; padding: 0 20px;
            border: 1px solid transparent;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
            height: 38px;
            overflow: hidden;
        }
        .cg-input-box:hover { background-color: var(--cg-bg-input); border-color: #cbd5e0; }
        .cg-input-box:focus-within { 
            border-color: var(--cg-primary); 
            background-color: var(--cg-bg-input); 
            box-shadow: 0 0 0 3px rgba(0, 128, 148, 0.1); 
        }
        .cg-input-box.error { border-color: #e74c3c; background-color: #fffbfb; }

        .cg-input-box input {
            background: none; border: none; outline: none; width: 100%;
            font-weight: 500; font-size: 0.85rem; color: #555; height: 100%;
            font-family: inherit;
        }

        /* FIX CHROME AUTOFILL */
        .cg-input-box input:-webkit-autofill,
        .cg-input-box input:-webkit-autofill:hover,
        .cg-input-box input:-webkit-autofill:focus,
        .cg-input-box input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px var(--cg-bg-input) inset !important;
            box-shadow: 0 0 0 1000px var(--cg-bg-input) inset !important;
            -webkit-text-fill-color: #555 !important;
            caret-color: #555;
            background-color: transparent !important;
        }

        /* ICONOS SVG */
        .cg-icon { width: 16px; height: 16px; margin-right: 10px; fill: #aaa; transition: 0.3s; }
        .cg-icon-toggle { cursor: pointer; margin-right: 0; margin-left: 10px; }
        .cg-input-box:focus-within .cg-icon { fill: var(--cg-primary); }

        /* ERRORES */
        .cg-error-text {
            color: #e74c3c; font-size: 0.65rem; font-weight: 600; text-align: left;
            width: 100%; padding-left: 15px; position: absolute; top: 100%; left: 0;
            margin-top: 2px; display: flex; align-items: center; gap: 4px; line-height: 1; z-index: 10;
        }
        .cg-icon-error { width: 10px; height: 10px; fill: #e74c3c; margin: 0; }

        /* ROLES */
        .cg-roles-wrap { width: 100%; text-align: left; margin-bottom: 15px; margin-top: 0px; position: relative; }
        .cg-roles-title { margin: 0 0 5px 0; font-size: 0.85rem; font-weight: 600; color: #555; padding-left: 5px; }
        .cg-roles-row { display: flex; gap: 10px; justify-content: space-between; width: 100%; }
        .cg-roles-row label { flex: 1; cursor: pointer; }
        .cg-roles-row input { display: none; }
        .cg-role-card {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 5px; border: 1px solid #ddd; border-radius: 10px;
            background-color: #fff; color: #777; transition: all 0.3s ease; height: 60px;
        }
        .cg-role-card:hover { border-color: var(--cg-primary); background-color: #f8fbfc; }
        .cg-role-card .cg-role-icon { width: 24px; height: 24px; fill: #999; margin-bottom: 2px; }
        .cg-role-card span { font-weight: 700; font-size: 0.8rem; }
        .cg-roles-row input:checked + .cg-role-card { border-color: var(--cg-primary); background-color: #f0fbfc; color: var(--cg-primary); }
        .cg-roles-row input:checked + .cg-role-card .cg-role-icon { fill: var(--cg-primary); }

        /* TERMINOS Y CONDICIONES */
        .cg-terms { 
            margin: 0 0 10px 0; width: 100%; text-align: left; position: relative; 
        }
        .cg-terms label {
            display: flex; 
            align-items: center; 
            cursor: pointer;
            font-size: 0.7rem; 
            color: #666;
            line-height: 1.2;
        }
        .cg-terms input { 
            margin-right: 8px; 
            accent-color: var(--cg-primary); 
            width: 14px; 
            height: 14px;
            margin-top: 0;
        }

        /* BOTONES */
        .cg-btn-primary {
            border-radius: 50px; border: none; background-color: var(--cg-accent); color: #ffffff;
            font-size: 12px; font-weight: bold; padding: 10px 0; width: 100%; text-transform: uppercase;
            cursor: pointer; transition: 0.3s; margin-top: 5px; box-shadow: 0 4px 6px rgba(255, 140, 0, 0.2);
            font-family: inherit;
        }
        .cg-btn-primary:hover { background-color: var(--cg-accent-hover); transform: translateY(-1px); }

        .cg-btn-ghost {
            background-color: transparent; border: 2px solid #ffffff; color: #ffffff;
            border-radius: 50px; padding: 10px 35px; font-weight: 600; text-transform: uppercase;
            cursor: pointer; margin-top: 15px; font-family: inherit;
        }

        /* ESTILOS PARA BOTON GOOGLE (AÑADIDO PARA COMPATIBILIDAD) */
        .am-signinoption {
            width: 100%;
            margin-top: 10px;
        }
        .am-signinoption_br {
            display: flex;
            align-items: center;
            text-align: center;
            width: 100%;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #888;
            font-weight: 500;
        }

        .am-signinoption_br {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 15px 0;
            font-size: 0.8rem;
            color: #999;
            font-weight: 500;
            text-align: center;
        }

        .am-signinoption_br::before,
        .am-signinoption_br::after {
            content: "";
            flex: 1;
            height: 1px;
            background-color: #e5e7eb;
        }

        .am-signinoption_br em {
            padding: 0 200px;
            font-style: normal;
        }

        .am-signinoption_btn {
            width: 100%;
            height: 40px;
            padding: 0 16px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .am-signinoption_btn:hover { 
            background-color: #f9fafb;
            border-color: #d1d5db; 
        }
        .am-btn_disable { opacity: 0.6; pointer-events: none; }

        .cg-divider { margin: 15px 0 10px; width: 100%; border-bottom: 1px solid #eee; }
        
        .cg-forgot { color: var(--cg-primary); font-size: 0.8rem; text-decoration: none; font-weight: 600; align-self: flex-end; margin-bottom: 10px; margin-top: 5px; cursor: pointer; }
        .cg-forgot:hover { text-decoration: underline; }
        
        .cg-mobile-toggle { display: none; }
        
        /* LOGO MÓVIL */
        .cg-mobile-logo { display: none; }

        .cg-success-box {
            background-color: #e6fffa; color: #047481; border: 1px solid #b2f5ea;
            padding: 10px; border-radius: 10px; font-size: 0.8rem; margin-bottom: 15px; width: 100%; text-align: center;
        }

        /* 5. OVERLAY */
        .cg-overlay-container {
            position: absolute; top: 0; left: 50%; width: 50%; height: 100%;
            overflow: hidden; transition: transform 0.6s ease-in-out; z-index: 100;
        }
        .cg-card.right-panel-active .cg-overlay-container { transform: translateX(-100%); }

        .cg-overlay {
            background: linear-gradient(to right, var(--cg-primary-dark), var(--cg-primary));
            color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%;
            transform: translateX(0); transition: transform 0.6s ease-in-out;
        }
        .cg-card.right-panel-active .cg-overlay { transform: translateX(50%); }

        .cg-overlay-panel {
            position: absolute; display: flex; align-items: center; justify-content: center;
            flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%;
            transform: translateX(0); transition: transform 0.6s ease-in-out;
        }
        
        .cg-overlay-panel h1 { color: #ffffff !important; font-size: 2rem; margin: 0; font-weight: 700; }
        .cg-overlay-panel p { color: #ffffff !important; font-size: 14px; margin: 20px 0 30px; }

        .cg-overlay-left { transform: translateX(-20%); }
        .cg-card.right-panel-active .cg-overlay-left { transform: translateX(0); }
        .cg-overlay-right { right: 0; transform: translateX(0); }
        .cg-card.right-panel-active .cg-overlay-right { transform: translateX(20%); }
        
        .cg-logo-overlay { width: 120px; margin-bottom: 0px; filter: brightness(0) invert(1); }
        
        .cg-overlay-img {
            max-width: 200px;      
            height: auto;
            margin-top: 10px;      
            margin-bottom: 20px;   
            filter: drop-shadow(0 5px 5px rgba(0,0,0,0.2)); 
        }

        .cg-input-box input {
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .cg-input-box input:focus { background-color: transparent !important; }

        /* 6. RESPONSIVO */
        @media (max-width: 768px) {
            .cg-auth-wrapper { padding: 0; background-color: #fff; align-items: flex-start; }
            .cg-card { width: 100%; max-width: 100%; min-height: 100vh; height: auto; padding-bottom: 30px; border-radius: 0; box-shadow: none; }
            .cg-overlay-container { display: none; }

            .cg-form-panel {
                width: 100%; position: relative; height: auto; padding: 40px 20px; top: auto;
                display: none; opacity: 1 !important; transform: none !important; flex-direction: column;
            }

            .cg-card:not(.right-panel-active) .cg-login { display: flex; }
            .cg-card.right-panel-active .cg-register { display: flex; }

            .cg-mobile-toggle { display: block; margin-top: 25px; font-size: 0.9rem; color: #666; }
            .cg-mobile-toggle a { color: var(--cg-primary); font-weight: bold; text-decoration: none; }


            .cg-mobile-logo {
                display: block; 
                width: 150px;
                height: auto;
                margin: 0 auto 10px auto; 
            }
        }
    </style>

    @php
        $hasRegErrors = $errors->has('reg_first_name') || $errors->has('reg_last_name') || $errors->has('reg_email') || $errors->has('reg_password') || $errors->has('user_role') || $errors->has('terms') || $errors->has('phone_number') || $this->mode === 'register';
    @endphp
    
    <div class="cg-auth-wrapper" x-data="{ isRegister: @json($hasRegErrors), showForgot: false }">
        
        <div class="cg-card" :class="{ 'right-panel-active': isRegister }" id="auth-card">
            
            {{-- REGISTER FORM --}}
            <div class="cg-form-panel cg-register">
                <form class="cg-form" wire:submit.prevent="register">
                    
                    <x-application-logo class="cg-mobile-logo" />

                    <h2 class="cg-title">Crear Cuenta</h2>
                    <p class="cg-desc">Únase a nuestra comunidad educativa</p>
                    
                    <div class="cg-input-row">
                        <div class="cg-input-group">
                            <div class="cg-input-box {{ $errors->has('reg_first_name') ? 'error' : '' }}">
                                <svg class="cg-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                <input type="text" wire:model="reg_first_name" placeholder="Nombre" />
                            </div>
                            @error('reg_first_name') <span class="cg-error-text">{{ $message }}</span> @enderror
                        </div>
                        <div class="cg-input-group">
                            <div class="cg-input-box {{ $errors->has('reg_last_name') ? 'error' : '' }}">
                                <svg class="cg-icon" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                <input type="text" wire:model="reg_last_name" placeholder="Apellido" />
                            </div>
                            @error('reg_last_name') <span class="cg-error-text">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="cg-input-group">
                        <div class="cg-input-box {{ $errors->has('reg_email') ? 'error' : '' }}">
                            <svg class="cg-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <input type="email" wire:model="reg_email" placeholder="Correo electrónico" />
                        </div>
                        @error("reg_email") <span class="cg-error-text">El email ya esta en uso</span> @enderror
                    </div>

                    @if($isProfilePhoneMendatory)
                    <div class="cg-input-group">
                        <div class="cg-input-box {{ $errors->has('phone_number') ? 'error' : '' }}">
                            <svg class="cg-icon" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            <input type="text" wire:model="phone_number" placeholder="Teléfono" />
                        </div>
                        @error('phone_number') <span class="cg-error-text">{{ $message }}</span> @enderror
                    </div>
                    @endif
                    
                    <div class="cg-input-group">
                        <div class="cg-input-box {{ $errors->has('reg_password') ? 'error' : '' }}">
                            <svg class="cg-icon" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            <input type="password" wire:model="reg_password" id="reg-pass" placeholder="Contraseña" />
                            <svg class="cg-icon cg-icon-toggle" id="toggleRegPass" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </div>
                        @error('reg_password') <span class="cg-error-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="cg-input-group">
                        <div class="cg-input-box">
                            <svg class="cg-icon" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            <input type="password" wire:model="reg_password_confirmation" id="reg-pass-confirm" placeholder="Confirmar Contraseña" />
                            <svg class="cg-icon cg-icon-toggle" id="toggleRegConfirm" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </div>
                    </div>

                    <div class="cg-roles-wrap">
                        <p class="cg-roles-title">Quiero ser:</p>
                        <div class="cg-roles-row">
                            <label>
                                <input type="radio" wire:model="user_role" value="student">
                                <div class="cg-role-card">
                                    <svg class="cg-role-icon" viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
                                    <span>Estudiante</span>
                                </div>
                            </label>
                            
                            <label>
                                <input type="radio" wire:model="user_role" value="tutor">
                                <div class="cg-role-card">
                                    <svg class="cg-role-icon" viewBox="0 0 24 24"><path d="M20 17.17L18.83 16H4V4h16v13.17zM20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4v2h8v-2h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 10h6v2H9z"/></svg>
                                    <span>Tutor</span>
                                </div>
                            </label>
                        </div>
                        @error('user_role') <span class="cg-error-text" style="top: 100%;"><svg class="cg-icon-error" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg> {{ $message }}</span> @enderror
                    </div>

                    <div class="cg-terms">
                        <label>
                            <input type="checkbox" wire:model="terms">
                            <span>{!! __('auth.register_terms') !!}</span>
                        </label>
                        @error('terms') <span class="cg-error-text" style="top: 100%;"><svg class="cg-icon-error" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg> {{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="cg-btn-primary" wire:loading.attr="disabled" wire:target="register">
                        <span wire:loading.remove wire:target="register">REGISTRARME</span>
                        <span wire:loading wire:target="register">...</span>
                    </button>

                    @if (!empty(setting('_api.enable_social_login')) && ((!empty(setting('_api.social_google_client_id')) && !empty(setting('_api.social_google_client_secret')))))    
                            <div class="am-signinoption">
                                <span class="am-signinoption_br"><em>{{ __('auth.or') }}</em></span>
                                <a href="#" wire:click.prevent="redirectGoogle" wire:target="redirectGoogle" wire:loading.class="am-btn_disable" class="am-signinoption_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                        <path d="M19.3 10.708C19.3 10.058 19.2417 9.43301 19.1333 8.83301H10.5V12.3788H15.4333C15.2208 13.5247 14.575 14.4955 13.6042 15.1455V17.4455H16.5667C18.3 15.8497 19.3 13.4997 19.3 10.708Z" fill="#4285F4"/>
                                        <path d="M10.5003 19.6662C12.9753 19.6662 15.0503 18.8454 16.5669 17.4454L13.6044 15.1454C12.7836 15.6954 11.7336 16.0204 10.5003 16.0204C8.11276 16.0204 6.09193 14.4079 5.37109 12.2412H2.30859V14.6162C3.81693 17.612 6.91693 19.6662 10.5003 19.6662Z" fill="#34A853"/>
                                        <path d="M5.37148 12.2411C5.18815 11.6911 5.08399 11.1036 5.08399 10.4995C5.08399 9.89531 5.18815 9.30781 5.37148 8.75781V6.38281H2.30899C1.66732 7.66019 1.33342 9.06999 1.33399 10.4995C1.33399 11.9786 1.68815 13.3786 2.30899 14.6161L5.37148 12.2411Z" fill="#FBBC05"/>
                                        <path d="M10.5003 4.97884C11.8461 4.97884 13.0544 5.44134 14.0044 6.34967L16.6336 3.72051C15.0461 2.24134 12.9711 1.33301 10.5003 1.33301C6.91693 1.33301 3.81693 3.38717 2.30859 6.38301L5.37109 8.75801C6.09193 6.59134 8.11276 4.97884 10.5003 4.97884Z" fill="#EA4335"/>
                                    </svg>
                                    {{ __('auth.sign_in_with_google') }}
                                </a>
                            </div>
                        @endif
                    
                    <p class="cg-mobile-toggle">¿Ya tienes cuenta? <a href="#" @click.prevent="isRegister = false; showForgot = false">Inicia Sesión</a></p>
                </form>
            </div>

            

            {{-- LOGIN FORM --}}
            <div class="cg-form-panel cg-login">
                
                {{-- VISTA 1: LOGIN --}}
                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center;"
                     x-show="!showForgot" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    
                    <form class="cg-form" wire:submit.prevent="login" x-data="{ form: @entangle('form') }">
                        
                        <x-application-logo class="cg-mobile-logo" />

                        <h2 class="cg-title">¡Bienvenido!</h2>
                        <p class="cg-desc">Ingresa tus datos para continuar</p>
                        
                        <div class="cg-input-group">
                            <div class="cg-input-box {{ $errors->get('form.email') ? 'error' : '' }}">
                                <svg class="cg-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                <input x-model="form.email" wire:model="form.email" type="email" placeholder="Correo electrónico" />
                            </div>
                            <x-input-error field_name="form.email" class="cg-error-text" style="position:absolute; top:100%; left:0;" />
                        </div>
    
                        <div class="cg-input-group">
                            <div class="cg-input-box {{ $errors->get('form.password') ? 'error' : '' }}">
                                <svg class="cg-icon" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                <input x-model="form.password" wire:model="form.password" id="login-password" type="password" placeholder="Contraseña" />
                                <svg class="cg-icon cg-icon-toggle" id="toggleLoginPass" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                            </div>
                            <x-input-error field_name="form.password" class="cg-error-text" style="position:absolute; top:100%; left:0;" />
                        </div>

                        <a href="#" @click.prevent="showForgot = true" class="cg-forgot">¿Olvidaste tu contraseña?</a>

                        <x-primary-button wire:loading.class="am-btn_disable" wire:target="login"><span>{{ __('auth.login_btn') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                        
                        @if (!empty(setting('_api.enable_social_login')) && ((!empty(setting('_api.social_google_client_id')) && !empty(setting('_api.social_google_client_secret')))))    
                            <div class="am-signinoption">
                                <span class="am-signinoption_br"><em>{{ __('auth.or') }}</em></span>
                                <a href="#" wire:click.prevent="redirectGoogle" wire:target="redirectGoogle" wire:loading.class="am-btn_disable" class="am-signinoption_btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                                        <path d="M19.3 10.708C19.3 10.058 19.2417 9.43301 19.1333 8.83301H10.5V12.3788H15.4333C15.2208 13.5247 14.575 14.4955 13.6042 15.1455V17.4455H16.5667C18.3 15.8497 19.3 13.4997 19.3 10.708Z" fill="#4285F4"/>
                                        <path d="M10.5003 19.6662C12.9753 19.6662 15.0503 18.8454 16.5669 17.4454L13.6044 15.1454C12.7836 15.6954 11.7336 16.0204 10.5003 16.0204C8.11276 16.0204 6.09193 14.4079 5.37109 12.2412H2.30859V14.6162C3.81693 17.612 6.91693 19.6662 10.5003 19.6662Z" fill="#34A853"/>
                                        <path d="M5.37148 12.2411C5.18815 11.6911 5.08399 11.1036 5.08399 10.4995C5.08399 9.89531 5.18815 9.30781 5.37148 8.75781V6.38281H2.30899C1.66732 7.66019 1.33342 9.06999 1.33399 10.4995C1.33399 11.9786 1.68815 13.3786 2.30899 14.6161L5.37148 12.2411Z" fill="#FBBC05"/>
                                        <path d="M10.5003 4.97884C11.8461 4.97884 13.0544 5.44134 14.0044 6.34967L16.6336 3.72051C15.0461 2.24134 12.9711 1.33301 10.5003 1.33301C6.91693 1.33301 3.81693 3.38717 2.30859 6.38301L5.37109 8.75801C6.09193 6.59134 8.11276 4.97884 10.5003 4.97884Z" fill="#EA4335"/>
                                    </svg>
                                    {{ __('auth.sign_in_with_google') }}
                                </a>
                            </div>
                        @endif
                        

                        <p class="cg-mobile-toggle">¿Nuevo aquí? <a href="#" @click.prevent="isRegister = true">Crea una cuenta</a></p>
                    </form>
                </div>

                {{-- VISTA 2: RECUPERAR CONTRASEÑA --}}
                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center;"
                     x-show="showForgot" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     style="display: none;">
                     
                    <form class="cg-form" wire:submit.prevent="sendPasswordResetLink">
                        
                        <x-application-logo class="cg-mobile-logo" />

                        <h2 class="cg-title">Recuperar Cuenta</h2>
                        <p class="cg-desc">Introduce tu correo y te enviaremos un enlace de recuperación.</p>
                        
                        @if($forgot_status)
                            <div class="cg-success-box">{{ $forgot_status }}</div>
                        @endif

                        <div class="cg-input-group">
                            <div class="cg-input-box {{ $errors->has('forgot_email') ? 'error' : '' }}">
                                <svg class="cg-icon" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                <input type="email" wire:model="forgot_email" placeholder="Correo electrónico" autofocus />
                            </div>
                            @error('forgot_email') 
                                <span class="cg-error-text">{{ $message }}</span> 
                            @enderror
                        </div>

                        <button type="submit" class="cg-btn-primary" wire:loading.attr="disabled" wire:target="sendPasswordResetLink">
                            <span wire:loading.remove wire:target="sendPasswordResetLink">ENVIAR ENLACE</span>
                            <span wire:loading wire:target="sendPasswordResetLink">ENVIANDO...</span>
                        </button>
                        
                        <a href="#" @click.prevent="showForgot = false; $wire.set('forgot_status', '')" class="cg-forgot" style="align-self: center; margin-top: 20px;">
                            ← Volver a Iniciar Sesión
                        </a>
                    </form>
                </div>

            </div>

            {{-- OVERLAY (SOLO PC) --}}
            <div class="cg-overlay-container">
                <div class="cg-overlay">
                    <div class="cg-overlay-panel cg-overlay-left">
                        <x-application-logo class="cg-logo-overlay"/>
                        
                        <h1>¿Ya eres parte?</h1>
                        <p>Inicia sesión con tu cuenta personal</p>
                        <button class="cg-btn-ghost" @click="isRegister = false; showForgot = false">INICIAR SESIÓN</button>
                    </div>
                    <div class="cg-overlay-panel cg-overlay-right">
                        <x-application-logo class="cg-logo-overlay"/>
                        
                        <img src="{{ asset('images/login/Tugosistemas.png') }}" class="cg-overlay-img" alt="Mascota Tugo">

                        <h1>¿Eres Nuevo?</h1>
                        <p>Regístrate y comienza tu aventura</p>
                        <button class="cg-btn-ghost" @click="isRegister = true">CREAR CUENTA</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleInput = (btnId, inputId) => {
        const btn = document.getElementById(btnId);
        const inp = document.getElementById(inputId);
        if(btn && inp){
            btn.addEventListener('click', () => {
                const type = inp.getAttribute('type') === 'password' ? 'text' : 'password';
                inp.setAttribute('type', type);
                // Toggle para SVG: Cambia opacidad para simular on/off
                btn.style.opacity = type === 'text' ? '1' : '0.5';
            });
        }
    }
    toggleInput('toggleLoginPass', 'login-password');
    toggleInput('toggleRegPass', 'reg-pass');
    toggleInput('toggleRegConfirm', 'reg-pass-confirm');
});
</script>
@endpush
