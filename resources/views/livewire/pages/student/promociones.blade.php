@extends('layouts.app')

@section('title', 'Tu código de invitación')

@section('content')

    @push('styles')
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Google Fonts: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/promociones.css') }}">

        <style>
            :root {
                --primary-color: #023047;
                --secondary-color: #219EBC;
                --secondary-color2: #CDD6DA;
                --tertiary-color: #8ECAE6;
                --tertiary-color2: #FB8500;
                --bg-color: #f8f9fa;
                --bg-gradient: linear-gradient(180deg, rgba(7, 59, 76, 1) 64%, rgba(24, 77, 94, 1) 77%, rgba(33, 158, 188, 1) 100%);
    --bg-gradient2: linear-gradient(135deg, #023047 0%, #219EBC 100%);
    --bg-gradient3: linear-gradient(135deg, #219EBC 0%, #023047 100%);
    --bg-gradient4: linear-gradient(180deg, rgb(16, 90, 109) 64%, rgba(24, 77, 94, 1) 77%, rgba(7, 59, 76, 1) 100%);
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--panel-background);
            }

            .bg-primary {
                background-color: var(--primary-color);
            }

            .text-primary {
                color: var(--primary-color);
            }

            .text-secondary {
                color: var(--secondary-color);
            }

            .bg-secondary {
                background-color: var(--secondary-color);
            }

            .bg-tertiary-orange {
                background-color: var(--tertiary-color2);
            }

            .text-tertiary-orange {
                color: var(--tertiary-color2);
            }

            .border-tertiary-orange {
                border-color: var(--tertiary-color2);
            }

            .ring-secondary {
                --tw-ring-color: var(--secondary-color);
            }

            .sidebar-link.active {
                background-color: var(--secondary-color);
                color: white;
                font-weight: 600;
            }

            .sidebar-link.active svg {
                stroke: white;
            }

            /* Estilo para la pestaña activa */
            .tab-active {
                border-bottom-color: #f97316;
                /* Naranja de Tailwind */
                color: #ffffff;
            }
        </style>
    @endpush
    <main class="flex-1 p-1 lg:p-8 overflow-y-auto">
        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 ">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-md">
                <h3 class="text-xl font-bold mb-4 cupon-text-cupones">Mis cupones</h3>
                <div class="space-y-4">
                    <div class="coupon-container relative max-w-2xl w-full border-3 border-[var(--secondary-color)] bg-white rounded-2xl flex overflow-hidden h-30">
    
                        <div class="bg-[linear-gradient(135deg,#023047_0%,#219EBC_100%)] text-white p-2 flex items-center justify-center w-1/3 relative">
                            <div class="w-60 h-30">
                                <img src=" {{ asset('images/home/Tugo_With_Phone.webp') }}" alt="">
                            </div>
                            <div class="absolute top-0 right-0 h-full pl-1 bg-white border-r-4 border-[#1eb2c4] border-dashed"></div>
                        </div>

                        <div class="md:p-4 flex flex-col justify-between w-2/3 py-4">
                            <div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <h2 class="text-5xl font-bold text-gray-800">2.00%</h2>
                                    <span class="text-xs font-medium bg-cyan-100 text-cyan-700 px-2 py-1 rounded-full mt-1 sm:mt-0">disponible</span>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Tienes <strong>2.00% de regalo</strong> en tu proxima tutoría</p>
                                <p class="text-xs text-gray-500 mt-1">Valido hasta el 04 de Sept, 2025</p>
                            </div>
                            <div class="text-right mt-1">
                                <p class="text-sm text-gray-600 font-medium">cantidad: 2</p>
                            </div>
                        </div>
                    </div>
                    @if ($cupones->isEmpty())
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No tienes cupones activos en este momento.</p>
                        </div>
                    @else
                        <div class="cupon-lista">
                            
                            @foreach ($cupones as $cupon)
                                @php
                                    $vencido = $cupon->fecha_caducidad && $cupon->fecha_caducidad < now();
                                    $inactivo = isset($cupon->estado) && $cupon->estado === 'inactivo';
                                    $canjeado = isset($cupon->pivot->estado);
                                @endphp
                                <div class="{{ $vencido ? 'cupon-vencido' : '' }}">
                                    <div
                                        class="cupon-item border-2 border-dashed border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row justify-between items-center sm:items-center gap-4">
                                        <div class="item-text">
                                            <p class="text-xs text-gray-500">Cupón válido hasta el
                                                {{ $cupon->fecha_caducidad ? \Carbon\Carbon::parse($cupon->fecha_caducidad)->format('d/m/Y') : 'Sin fecha' }}
                                                @if ($vencido)
                                                    <span>(Vencido)</span>
                                                @endif
                                            </p>
                                            <h4 class="font-bold text-lg cupon-text">Obtubiste un descuento del
                                                {{ $cupon->descuento }}%</h4>
                                            <p class="text-sm text-gray-600">en tu próxima tutoría - Cantidad:
                                                {{ $cupon->pivot->cantidad }}</p>
                                        </div>
                                        @if ($canjeado)
                                            <span
                                                class="bg-gray-200 text-gray-800 font-semibold px-4 py-1 rounded-full text-sm">Canjeado</span>
                                        @elseif($inactivo)
                                            <span
                                                class="bg-red-100 text-red-800 font-semibold px-4 py-1 rounded-full text-sm">Inactivo</span>
                                        @elseif($vencido)
                                            <span
                                                class="bg-red-100 text-red-800 font-semibold px-4 py-1 rounded-full text-sm">Vencido</span>
                                        @else
                                            <a href="#"><button
                                                    class="button-cupon text-white font-semibold px-6 py-2 rounded-lg hover:opacity-90 transition-all">Usar</button></a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            
                        </div>
                    @endif
                </div>
            </div>

            <div class="cards-container card-fondo w-full max-w-sm mx-auto bg-[#0f3443] text-white rounded-xl shadow-2xl overflow-hidden">
                <div class="flex">
                    <button id="tabRedeem"
                        class="w-1/2 py-3 font-semibold border-b-2 border-transparent text-gray-400 transition-colors duration-300">Canjear
                        Cupón</button>
                    <button id="tabInvite"
                        class="w-1/2 py-3 font-semibold border-b-2 border-transparent text-gray-400 transition-colors duration-300">Invitar</button>
                </div>

                <!-- CARD CANJEAR CUPON -->
                <div id="redeemView" class="h-full text-white p-6 rounded-2xl shadow-lg flex-col items-center text-center">
                    <form action="{{ route('coupons.canjear') }}" method="POST">
                        @csrf
                        <h3 class="text-xl font-bold">¿Tienes Código?</h3>
                        <p class="text-tertiary-color mt-1 text-sm">¡Ingrésalo y obtén descuentos!</p>

                        <div class="my-6 w-full">
                            <div id="cupon-code"
                                class="font-extrabold tracking-widest bg-white/20 border-2 border-dashed border-tertiary-color p-2 rounded-lg">
                                <input id="codigo" name="codigo" type="text" required placeholder=" ABC12345" autocomplete="off" maxlength="8" spellcheck="false">       
                            </div>
                        </div>

                        <div class="w-full space-y-3">
                            <button type="submit" id="btnCanjear"
                                class="w-full bg-tertiary-orange font-bold py-3 rounded-lg hover:opacity-90 transition-all">
                                Canjear
                            </button>
                            @if (session('error'))<p id="mensaje-error">{{ session('error') }}</p>@endif
                            @if (session('exito'))<p id="mensaje-success">{{ session('exito') }}</p>@endif
                        </div>
                        
                    </form>

                </div>
                

                <!-- CARD COMPARTIR CODE -->
                <div id="inviteView"
                    class="h-full text-white p-6 rounded-2xl shadow-lg flex-col items-center text-center hidden">
                    <h3 class="text-xl font-bold">Tu Código de Invitación</h3>
                    <p class="text-tertiary-color mt-1 text-sm">¡Comparte y obtén descuentos!</p>
                    <div class="my-6">
                        <div id="inv-code"
                            class="text-3xl font-extrabold tracking-widest bg-white/20 border-2 border-dashed border-tertiary-color px-4 py-2 rounded-lg ">
                            {{ $codigo ?? 'No Code' }}
                        </div>
                    </div>
                    <div class="w-full flex gap-3">
                        <button id="btnCopiar" type="button"
                            class="bg-white/90 text-primary font-bold py-3 rounded-lg hover:bg-white transition-all flex-1">
                            Copiar
                        </button>
                        <button id="compartir-button" type="button"
                            class="bg-tertiary-orange font-bold py-3 rounded-lg hover:opacity-90 transition-all flex-1">
                            Compartir
                        </button>
                        <x-modal-compartir />
                    </div>
                    <div id="copy-feedback" class="pt-3 transition-opacity" style="display:none;">¡Copiado!</div>
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

                //Logica para el mensaje de error o codigo canjeado correctamente
                const textoError = document.getElementById('mensaje-error');
                const textoCorrect = document.getElementById('mensaje-success');
                const botonCanjear = document.getElementById('btnCanjear');

                if (textoError) {
                    textoError.style.opacity = '1'
                    setTimeout(() => {
                        textoError.style.opacity = '0';
                        setTimeout(() => {
                            textoError.style.opacity = 'none'
                            textoError.style.display = 'none';
                        }, 600); 
                    }, 3000); // 5000 milisegundos = 5 segundos
                }
                if(textoCorrect){
                    textoCorrect.style.opacity = '1'
                    setTimeout(() => {
                        textoCorrect.style.opacity = '0';
                        setTimeout(() => {
                            textoCorrect.style.opacity = 'none'
                            textoCorrect.style.display = 'none';
                        }, 600); 
                    }, 3000); // 5000 milisegundos = 5 segundos
                }
            });

            
            

        </script>
    @endpush

@endsection
