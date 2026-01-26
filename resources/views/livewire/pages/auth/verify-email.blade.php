<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\RegisterService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    protected $registerService;

    public function boot(){
        $this->registerService = new RegisterService();
    }

    public function mount(){
        if (Auth::user()->hasVerifiedEmail()) {
            return $this->redirectIntended(default: auth()->user()->redirect_after_login, navigate: true);
        }
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: auth()->user()->redirect_after_login, navigate: true);
            
            return;
        }

        $this->registerService->sendEmailVerificationNotification(Auth::user());

        $this->dispatch('showAlertMessage', type: 'success', message: __('auth.verify_email_link'));
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        
        $this->redirect('/');
    }
}; ?>

<div>
    {{-- 1. ESTILOS (Mismo CSS que el Login) --}}
    <style>
        :root {
            --cg-primary: #219EBC;
            --cg-primary-dark: #023047;
            --cg-accent: #FB8500;
            --cg-accent-hover: #FB8500;
            --cg-bg-input: #f0f4f8; 
        }

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

        .cg-card {
            background-color: #fff;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 600px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        }

        /* Panel Principal (Izquierda) */
        .cg-form-panel {
            position: absolute; top: 0; height: 100%;
            transition: all 0.6s ease-in-out;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            text-align: center;
        }

        /* En esta vista solo usamos el panel "login" (izquierda) por defecto */
        .cg-login { left: 0; width: 50%; z-index: 2; opacity: 1; }

        .cg-title { font-weight: 700; color: var(--cg-primary); font-size: 2.0rem; margin: 0 0 15px; }
        .cg-desc { font-size: 0.9rem; color: #666; margin: 10px 0 20px; line-height: 1.5; }
        
        /* Botones */
        .cg-btn-primary {
            border-radius: 50px; border: none; background-color: var(--cg-accent); color: #ffffff;
            font-size: 12px; font-weight: bold; padding: 12px 45px; letter-spacing: 1px;
            text-transform: uppercase; transition: transform 80ms ease-in, box-shadow 0.3s;
            margin-top: 15px; cursor: pointer; box-shadow: 0 4px 6px rgba(255, 140, 0, 0.2);
            font-family: inherit; width: 100%;
        }
        .cg-btn-primary:hover { background-color: var(--cg-accent-hover); transform: translateY(-2px); }
        .cg-btn-primary:active { transform: scale(0.95); }

        /* Botón Logout (Estilo secundario) */
        .cg-btn-secondary {
            background: none; border: none; color: #888;
            font-size: 0.9rem; font-weight: 600; cursor: pointer;
            margin-top: 20px; text-decoration: underline;
            transition: color 0.3s;
        }
        .cg-btn-secondary:hover { color: var(--cg-primary); }

        /* Overlay (Derecha) */
        .cg-overlay-container {
            position: absolute; top: 0; left: 50%; width: 50%; height: 100%;
            overflow: hidden; z-index: 100;
        }
        .cg-overlay {
            background: linear-gradient(to right, var(--cg-primary-dark), var(--cg-primary));
            color: #ffffff; position: relative; left: -100%; height: 100%; width: 200%;
        }
        .cg-overlay-panel {
            position: absolute; display: flex; align-items: center; justify-content: center;
            flex-direction: column; padding: 0 40px; text-align: center; top: 0; height: 100%; width: 50%;
        }
        .cg-overlay-right { right: 0; transform: translateX(0); } /* Siempre visible a la derecha */

        .cg-logo-overlay { width: 120px; margin-bottom: 0px; filter: brightness(0) invert(1); }
        
        .cg-overlay-img {
            max-width: 200px; height: auto;
            margin-top: 10px; margin-bottom: 20px;
            filter: drop-shadow(0 5px 5px rgba(0,0,0,0.2));
        }

        .cg-mobile-logo { display: none; }

        /* Responsive */
        @media (max-width: 768px) {
            .cg-auth-wrapper { padding: 0; background-color: #fff; align-items: flex-start; }
            .cg-card { width: 100%; max-width: 100%; min-height: 100vh; height: auto; border-radius: 0; box-shadow: none; }
            .cg-overlay-container { display: none; }
            
            .cg-form-panel { 
                width: 100%; position: relative; height: auto; 
                padding: 40px 30px; top: auto;
            }
            .cg-login { width: 100%; }

            .cg-mobile-logo { 
                display: block; width: 150px; height: auto; margin: 0 auto 20px auto; 
            }
        }
    </style>

    {{-- 2. ESTRUCTURA HTML --}}
    <div class="cg-auth-wrapper">
        <div class="cg-card">
            
            {{-- PANEL DE CONTENIDO (IZQUIERDA) --}}
            <div class="cg-form-panel cg-login">
                
                {{-- Logo solo móvil --}}
                <x-application-logo class="cg-mobile-logo" />

                <h2 class="cg-title">{{ __('auth.verify_title') }}</h2>
                
                {{-- Mensajes de texto --}}
                <div style="text-align: left; width: 100%;">
                    <p class="cg-desc">
                        {{ __('auth.verify_email_msg') }}
                    </p>
                    <p class="cg-desc" style="margin-top: 0;">
                        {{ __('auth.verify_email_msg2') }}
                    </p>
                </div>

                {{-- Botón Reenviar --}}
                <button wire:click="sendVerification" wire:loading.attr="disabled" class="cg-btn-primary">
                    <span wire:loading.remove wire:target="sendVerification">{{ __('auth.resend_verification_email') }}</span>
                    <span wire:loading wire:target="sendVerification">ENVIANDO...</span>
                </button>

                {{-- Botón Cerrar Sesión --}}
                <button wire:click="logout" class="cg-btn-secondary">
                    {{ __('auth.log_out') }}
                </button>
            </div>

            {{-- OVERLAY DECORATIVO (DERECHA - SOLO PC) --}}
            <div class="cg-overlay-container">
                <div class="cg-overlay">
                    <div class="cg-overlay-panel cg-overlay-right">
                        <x-application-logo class="cg-logo-overlay"/>
                        
                        {{-- Mascota --}}
                        <img src="{{ asset('images/login/Tugosistemas.png') }}" class="cg-overlay-img" alt="Mascota Tugo">

                        <h1 style="color: #fff; font-size: 2rem; font-weight: 700; margin: 0;">ClassGo!</h1>
                        <p style="color: #fff; font-size: 14px; margin-top: 10px;">Tu comunidad educativa</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
