@extends('layouts.app')

@section('title', 'Tu código de invitación')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/promociones.css') }}">
<link rel="stylesheet" href="{{ asset('css/estilos/variables.css') }}">
@endpush

    <main class="main-content">
        
        <div class="main-grid-container">
            <div class="coupons-section">
                <h3 class="coupons-title">Mis cupones</h3>
                <div class="coupons-list-container">
                    
                    {{-- <div class="coupon-card">
                        <div class="coupon-image-wrapper">
                            <img src="{{ asset('images/home/Tugo_With_Phone.webp') }}" alt="Tugo with Phone">
                        </div>
                        <div class="coupon-info-wrapper">
                            <div class="info-text">
                                <h2 class="coupon-value">2.00%</h2>
                                <p class="coupon-description">Tienes <strong>2.00% de regalo</strong> en tu próxima tutoría</p>
                                <p class="coupon-validity">Válido hasta el 04 de Sept, 2025</p>
                            </div>
                            <div class="info-disponibilidad">
                                <span class="coupon-status">disponible</span>
                                <p class="coupon-amount">Cantidad: 2</p>
                            </div>
                        </div>
                    </div> --}}

                    @if ($cupones->isEmpty())
                        <div class="empty-state-message">
                            <svg class="empty-state-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                            <p class="empty-state-text">No tienes cupones activos en este momento.</p>
                        </div>
                    @else
                        <div class="coupons-list-scroll">
                            @foreach ($cupones as $cupon )
                            @php
                                $vencido = $cupon->fecha_caducidad && $cupon->fecha_caducidad < now();
                                $inactivo = isset($cupon->estado) && $cupon->estado === 'inactivo';
                                $canjeado = isset($cupon->pivot->estado);
                            @endphp

                            <div class="coupon-card">
                                <div class="coupon-image-wrapper">
                                    <img src="{{ asset('images/home/Tugo_With_Phone.webp') }}" alt="Tugo with Phone">
                                </div>
                                <div class="coupon-info-wrapper">
                                    <div class="info-text">
                                        <h2 class="coupon-value">{{ round($cupon->descuento) }}%</h2>
                                        <p class="coupon-description">Tienes <strong>{{ round($cupon->descuento )}}% de descuento</strong> en tu próxima tutoría</p>
                                        <p class="coupon-validity">Válido hasta el
                                            {{ $cupon->fecha_caducidad ? \Carbon\Carbon::parse($cupon->fecha_caducidad)->format('d/m/Y') : 'Sin fecha' }}
                                            @if ($vencido) <span>(Vencido)</span> @endif
                                        </p>
                                        
                                    </div>
                                    <div class="info-disponibilidad">
                                        @if ($canjeado)
                                        <span class="coupon-status">Disponible</span>
                                        @endif
                                        <p class="coupon-amount">Cantidad: {{ $cupon->pivot->cantidad }} </p>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            
                        </div>
                    @endif
                </div>
            </div>

            <div class="redeem-invite-card">
                <div class="tab-buttons-container">
                    <button id="tabRedeem" class="tab-button ">Canjear Cupón</button>
                    <button id="tabInvite" class="tab-button">Invitar</button>
                </div>

                <div id="redeemView" class="view-content view-content-redeem">
                    <form action="{{ route('coupons.canjear') }}" class="formulario" method="POST">
                        @csrf
                        <h3 class="view-title">¿Tienes Código?</h3>
                        <p class="view-subtitle">¡Ingrésalo y obtén descuentos!</p>
                        <div class="input-wrapper">
                            <input id="codigo" name="codigo" type="text" required placeholder="ABC12345" autocomplete="off" maxlength="8" spellcheck="false">  

                        </div>
                        <div class="action-buttons-wrapper">
                            <button type="submit" id="btnCanjear" class="redeem-button">Canjear</button>
                        </div>
                        @if (session('error'))
                            <p class="message-error" style="display: block; opacity: 1;">{{ session('error') }}</p>
                        @endif

                        @if (session('success'))
                            <p class="message-success">{{ session('success') }}</p>
                        @endif
                    </form>
                </div>
                

                <div id="inviteView" class="view-content view-content-invite hidden">
                    <h3 class="view-title">Tu Código de Invitación</h3>
                    <p class="view-subtitle">¡Comparte y obtén descuentos!</p>
                    <div class="code-wrapper">
                        <div id="inv-code" class="invitation-code">
                            {{ $codigo ?? 'No Code' }}
                        </div>
                    </div>
                    <div class="action-buttons-wrapper action-buttons-invite">
                        <button id="btnCopiar" type="button" class="copy-button">
                            Copiar
                        </button>
                        <button id="compartir-button" type="button" class="share-button">
                            Compartir
                        </button>
                        <x-modal-compartir />

                    </div>
                    <div id="copy-feedback" class="copy-feedback-message">¡Copiado!</div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')

<script>

//======== Script para Cambiar Pestañas, Copiar Código de Invitación y Compartir ========//

document.addEventListener('DOMContentLoaded', () => {

	// --- Lógica para Cambiar Pestañas ---

	const tabRedeem = document.getElementById('tabRedeem');

	const tabInvite = document.getElementById('tabInvite');

	const redeemView = document.getElementById('redeemView');

	const inviteView = document.getElementById('inviteView');



	function setActiveTab(activeTab, inactiveTab, activeView, inactiveView) {

		// Estilos para la pestaña activa

		activeTab.classList.remove('text-gray-400', 'border-transparent');

		activeTab.classList.add('text-white', 'border-tertiary-orange');



		// Estilos para la pestaña inactiva

		inactiveTab.classList.remove('text-white', 'border-tertiary-orange');

		inactiveTab.classList.add('text-gray-400', 'border-transparent');



		// Mostrar la vista activa y ocultar la inactiva

		activeView.classList.remove('hidden');

		activeView.classList.add('flex');

		inactiveView.classList.remove('flex');

		inactiveView.classList.add('hidden');

	}



	// Eventos de clic para las pestañas

	tabRedeem.addEventListener('click', () => {

		setActiveTab(tabRedeem, tabInvite, redeemView, inviteView);

	});



	tabInvite.addEventListener('click', () => {

		setActiveTab(tabInvite, tabRedeem, inviteView, redeemView);

	});



	// Inicializar la vista por defecto al cargar la página

	setActiveTab(tabRedeem, tabInvite, redeemView, inviteView);



	// --- Lógica para Copiar Código de Invitación ---

	const btnCopiar = document.getElementById('btnCopiar');

	const codigo = document.getElementById('inv-code');

	const feedback = document.getElementById('copy-feedback');



	if (btnCopiar && codigo && feedback) {

		btnCopiar.addEventListener('click', () => {

			const texto = codigo.textContent.trim();

			navigator.clipboard.writeText(texto).then(() => {

				feedback.style.display = 'block';

				feedback.style.opacity = '1';

				setTimeout(() => {

					feedback.style.opacity = '0';

					setTimeout(() => {

						feedback.style.display = 'none';

					}, 500); // Esperar a que la transición termine

				}, 2000);

			});

		});

	}



	// --- Lógica para el Modal de Compartir ---

	const abrirModalBtn = document.getElementById('compartir-button');

	const modal = document.getElementById('modalCompartir');

	const cerrarModalBtn = document.getElementById('cerrarModal');



	if (abrirModalBtn && modal && cerrarModalBtn) {

		abrirModalBtn.addEventListener('click', () => {

			modal.style.display = 'flex';

		});



		cerrarModalBtn.addEventListener('click', () => {

			modal.style.display = 'none';

		});



		modal.addEventListener('click', (e) => {

			if (e.target === modal) {

				modal.style.display = 'none';

			}

		});

	}

    // Lógica para mostrar y ocultar mensajes de sesión (éxito o error)
    function handleSessionMessage(messageElement, displayDuration) {
        if (messageElement) {
            // El elemento ya se renderizó visible por Blade, solo necesitamos manejar la desaparición
            setTimeout(() => {
                messageElement.style.opacity = '0';
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 500); // Esperar a que la transición termine
            }, displayDuration);
        }
    }

    const successMessage = document.querySelector('.message-success');
    const errorMessage = document.querySelector('.message-error');

    handleSessionMessage(successMessage, 2000); // Muestra el mensaje de éxito por 2 segundos
    handleSessionMessage(errorMessage, 5000);   // Muestra el mensaje de error por 5 segundos

});



</script>

@endpush
@endsection