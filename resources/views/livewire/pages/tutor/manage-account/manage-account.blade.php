<div class="dashboard-container" style="min-height:100vh" wire:init="loadData">
    @slot('title')
        {{ __('general.dashboard') }}
    @endslot
    {{-- @if ($isLoading)
    @include('skeletons.manage-account')
    @else --}}
    <div class="am-section-load" wire:loading wire:target="refresh">
        @include('skeletons.manage-account')
    </div>
    <div>
        {{--
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Ganancias totales</div>
                <div class="stat-value amount">1,250 Bs</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Ganancias este mes</div>
                <div class="stat-value amount">380 Bs</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Tutorías completadas</div>
                <div class="stat-value">82</div>
            </div>
        </div>  --}}

        <!-- Price section: nuevo input para el campo price en profiles -->
        <div class="price-section" style="margin: 1.25rem 0; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <label for="price" style="min-width:180px; font-weight:600;" data-translate="manage_account_price_question">
                ¿Cuánto deseas cobrar por tutoría?
            </label>

            <input id="price" type="number" step="0.01" min="0" max="999999.99" class="form-control"
                style="max-width:240px;" wire:model.defer="price"
                placeholder="Ej. 120.00" data-translate-placeholder="manage_account_price_placeholder">

            <div>
                <button class="btn btn-primary" wire:click="savePrice" data-translate="manage_account_save_price">
                    Guardar precio
                </button>
            </div>
            @error('price')
                <div style="width:100%; color: #dc2626; margin-top:6px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Payment Methods Section -->
        <div class="payment-methods-section">
            <div class="section-header" data-translate="manage_account_payment_methods">
                Métodos de pago
            </div>

            <div class="payment-methods-grid">

                @if ($bank && !empty($bank->payout_details))
                    <div class="payment-method-card active"
                        style="display: flex; flex-direction: column; padding: 24px 20px; border-color: var(--secundary-color); width: 100%; max-width: 385px; box-sizing: border-box;">
                        <div
                            style="display: flex; width: 100%; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="method-icon bank"
                                    style="background: #e0f2fe; color: #219EBC; width: 48px; height: 48px; min-width: 48px; border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-secondary">
                                        <path
                                            d="M12 21v-5.172a2 2 0 0 0-.586-1.414L5.414 8.414A2 2 0 0 1 5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2a2 2 0 0 1-.414 1.414l-6 6A2 2 0 0 0 12 21z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"
                                        data-translate="manage_account_bank_transfer">
                                        Transferencia bancaria
                                    </h3>
                                    <span class="method-status active" style="margin-top: 2px;" data-translate="manage_account_active">
                                        Activo
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 16px; width: 100%;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <tbody>
                                    <tr>
                                        <td class="titulo-metodo-banco" data-translate="manage_account_bank">Banco:</td>
                                        <td class="info-metodo-banco">
                                            {{ $bank->payout_details['bankName'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="titulo-metodo-banco" data-translate="manage_account_account_type">
                                            Tipo de cuenta:
                                        </td>
                                        <td class="info-metodo-banco">
                                            {{ $bank->payout_details['title'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="titulo-metodo-banco" data-translate="manage_account_account_number">
                                            Número de cuenta:
                                        </td>
                                        <td class="info-metodo-banco">
                                            {{ $bank->payout_details['accountNumber'] ?? 'N/A' }}</td>
                                    </tr>
                                    @if (!empty($bank->payout_details['bankRoutingNumber']))
                                        <tr>
                                            <td class="titulo-metodo-banco" data-translate="manage_account_cci_route">
                                                CCI / Ruta:
                                            </td>
                                            <td class="info-metodo-banco">
                                                {{ $bank->payout_details['bankRoutingNumber'] }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @php
                            $savedBankName = trim($bank->payout_details['bankName'] ?? 'Banco');
                            $normalizedBank = mb_strtolower($savedBankName, 'UTF-8');

                            $boliviaBanksCatalog = [
                                [
                                    'match' => ['union', 'unión', 'banco union'],
                                    'logo' => asset('images/bancos/banco-union-logo.png'),
                                    'bg' => '#ffffff',
                                ],
                                [
                                    'match' => ['mercantil', 'bmsc', 'mercantil santa cruz'],
                                    'logo' => asset('images/bancos/bmsc-logo.png'),
                                    'bg' => '#00593B',
                                ],
                                [
                                    'match' => ['nacional', 'bnb', 'banco nacional de bolivia'],
                                    'logo' => asset('images/bancos/bnb_logo_portada.jpg'),
                                    'bg' => '#00a837',
                                ],
                                [
                                    'match' => ['bisa', 'banco bisa'],
                                    'logo' => asset('images/bancos/bisa-logo.jpeg'),
                                    'bg' => '#002D62',
                                ],
                                [
                                    'match' => ['ganadero', 'banco ganadero', 'bg'],
                                    'logo' => asset('images/bancos/ganadero-logo.png'),
                                    'bg' => '#ffffff',
                                ],
                                [
                                    'match' => ['economico', 'económico', 'banco economico', 'baneco'],
                                    'logo' => asset('images/bancos/banco-economico-logo.png'),
                                    'bg' => '#ffffff',
                                ],
                                [
                                    'match' => ['fie', 'banco fie'],
                                    'logo' => asset('images/bancos/fie-logo.png'),
                                    'bg' => '#ffffff',
                                ],
                                [
                                    'match' => ['sol', 'bancosol', 'banco sol'],
                                    'logo' => asset('images/bancos/bancosol-logo.jpeg'),
                                    'bg' => '#EA580C',
                                ],
                                [
                                    'match' => ['fortaleza', 'banco fortaleza'],
                                    'logo' => asset('images/bancos/fortaleza-logo.png'),
                                    'bg' => '#1E3A8A',
                                ],
                                [
                                    'match' => ['prodem', 'banco prodem'],
                                    'logo' => asset('images/bancos/prodem-logo.png'),
                                    'bg' => '#065F46',
                                ],
                                [
                                    'match' => ['ecofuturo', 'banco ecofuturo'],
                                    'logo' => asset('images/bancos/ecofuturo-logo.png'),
                                    'bg' => '#14532D',
                                ],
                                [
                                    'match' => ['jesus nazareno', 'jesús nazareno', 'cooperativa'],
                                    'logo' => asset('images/bancos/jesus-nazareno-logo.png'),
                                    'bg' => '#047857',
                                ],
                                [
                                    'match' => ['yape', 'tigo money', 'billetera'],
                                    'logo' => asset('images/bancos/yape-logo.png'),
                                    'bg' => '#742384',
                                ],
                            ];

                            $matchedBankInfo = null;
                            foreach ($boliviaBanksCatalog as $item) {
                                foreach ($item['match'] as $kw) {
                                    if (str_contains($normalizedBank, $kw)) {
                                        $matchedBankInfo = $item;
                                        break 2;
                                    }
                                }
                            }

                            $bannerLogo = $matchedBankInfo['logo'] ?? null;
                            $bannerBg = $matchedBankInfo['bg'] ?? 'var(--secundary-color)';
                        @endphp

                        <div style="background-color: {{ $bannerBg }}; border-radius: inherit; height: 100%; min-height: 165px; width: 100%; margin-bottom: 16px; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0; box-sizing: border-box;">
                            @if ($bannerLogo)
                                <img src="{{ $bannerLogo }}"
                                     alt="{{ $savedBankName }}"
                                     style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
                            @else
                                <span style="font-size: 20px; font-weight: 700; color: #ffffff; text-align: center; padding: 16px;">
                                    {{ $savedBankName }}
                                </span>
                            @endif
                        </div>
                        <div style="display: flex; gap: 8px; justify-content: flex-end; width: 100%; margin-top: auto;">
                            <button class="btn btn-secondary" style="padding: 6px 12px; font-size: 13px;"
                                wire:click="openPayout('cuentabancaria', 'setupaccountpopup')">
                                <i class="fas fa-edit me-1"></i>
                                <span data-translate="general_edit">Editar</span>
                            </button>
                            <button class="btn btn-danger" style="padding: 6px 12px; font-size: 13px;"
                                wire:click="openPayout('cuentabancaria', 'deletepopup')">
                                <i class="fas fa-trash-alt me-1"></i>
                                <span data-translate="general_delete">Eliminar</span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="payment-method-card"
                        style="display: flex; flex-flow: row wrap; justify-content: center; align-items: center; min-height: 250px;">
                        <div class="method-left">
                            <div class="method-icon bank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-secondary">
                                    <path
                                        d="M12 21v-5.172a2 2 0 0 0-.586-1.414L5.414 8.414A2 2 0 0 1 5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2a2 2 0 0 1-.414 1.414l-6 6A2 2 0 0 0 12 21z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="method-right" style="justify-content: center;">
                            <div class="method-header"
                                style="display: flex; justify-content: center; margin-bottom: 8px;">
                                <div class="method-info" style="text-align: center;">
                                    <h3 data-translate="manage_account_bank_transfer">Transferencia bancaria</h3>
                                    <div class="no-account-message" style="font-size: 13px;" data-translate="manage_account_no_bank_account">
                                        Aún no se ha agregado ninguna cuenta.
                                    </div>
                                </div>
                            </div>
                            <div class="method-actions" class="method-controls"
                                style="display: flex; justify-content: center; margin-top: 10px;">
                                <button class="btn btn-primary"
                                    wire:click="openPayout('cuentabancaria', 'setupaccountpopup')">
                                    <span data-translate="manage_account_setup_account">Configurar cuenta</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif


                @if ($qr && $currentQRPath)
                    <div class="payment-method-card active"
                        style="display: flex; flex-direction: column; padding: 24px 20px; border-color: #10b981;">
                        <div
                            style="display: flex; width: 100%; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="method-icon qr"
                                    style="background: #d1fae5; color: #059669; width: 48px; height: 48px; min-width: 48px; border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="h-6 w-6 text-green-600">
                                        <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                        <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                        <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                        <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                        <path d="M21 21v.01"></path>
                                        <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                        <path d="M3 12h.01"></path>
                                        <path d="M12 12h.01"></path>
                                        <path d="M12 18h.01"></path>
                                        <path d="M7 12h.01"></path>
                                        <path d="M7 18h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;"
                                        data-translate="manage_account_qr_payment">
                                        Pago con QR
                                    </h3>
                                    <span class="method-status active" style="margin-top: 2px;" data-translate="manage_account_active">
                                        Activo
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            style="background: white; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 16px; width: 100%; display: flex; justify-content: center; align-items: center;">
                            {{-- <div class="qr-container"
                                style="position: relative; cursor: pointer; text-align: center; width:20rem;height:20rem;"
                                onclick="openQrFullScreen(this)">
                                <img src="{{ asset('storage/' . $currentQRPath) }}" alt="Código QR de Pago" data-translate-alt="manage_account_payment_qr_alt"
                                    style="height: 20rem;width: 20rem; object-fit: contain; border: 1px solid #f1f5f9; padding: 4px; border-radius: 6px; background: white;">
                            </div> --}}

                            <div class="qr-container" onclick="openQrFullScreen(this)">

                                <img src="{{ asset('storage/' . $currentQRPath) }}" alt="Código QR de Pago" data-translate-alt="manage_account_payment_qr_alt"
                                    class="qr-preview-image">
                            </div>
                        </div>
                        <div
                            style="display: flex; gap: 8px; justify-content: flex-end; width: 100%; margin-top: auto;">
                            <button class="btn btn-secondary" style="padding: 6px 12px; font-size: 13px;"
                                wire:click="openPayout('QR', 'modalQR')">
                                <i class="fas fa-sync-alt me-1"></i>
                                <span data-translate="manage_account_manage_qr">Gestionar QR</span>
                            </button>
                            <button class="btn btn-danger" style="padding: 6px 12px; font-size: 13px;"
                                wire:click="openPayout('QR', 'deletepopup')">
                                <i class="fas fa-trash-alt me-1"></i>
                                <span data-translate="general_delete">Eliminar</span>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="payment-method-card"
                        style="display: flex; flex-flow: row wrap; justify-content: center; align-items: center; min-height: 250px;">
                        <div class="method-left">
                            <div class="method-icon qr">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-green-600">
                                    <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                    <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                    <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                    <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                    <path d="M21 21v.01"></path>
                                    <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                    <path d="M3 12h.01"></path>
                                    <path d="M12 12h.01"></path>
                                    <path d="M12 18h.01"></path>
                                    <path d="M7 12h.01"></path>
                                    <path d="M7 18h.01"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="method-right" style="justify-content: center;">
                            <div class="method-header"
                                style="display: flex; justify-content: center; margin-bottom: 8px;">
                                <div class="method-info" style="text-align: center;">
                                    <h3 data-translate="manage_account_qr_payment">Pago con QR</h3>
                                    <div class="no-account-message" style="font-size: 13px;" data-translate="manage_account_no_qr_uploaded">
                                        Aún no se ha subido ningún código QR.
                                    </div>
                                </div>
                            </div>
                            <div class="method-actions"
                                style="display: flex; flex-wrap: wrap; justify-content: center; margin-top: 10px;">
                                <button class="btn btn-primary" wire:click="openPayout('QR', 'modalQR')">
                                    <span data-translate="manage_account_setup_qr">Configurar QR</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>


        </div>

        <!-- Transaction History -->
        {{-- <div class="transaction-history">
            <div class="section-header">
                <h2 class="section-title">Historial de Transacciones</h2>
            </div>

            <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <table class="transaction-table" >
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if ($pagos && $pagos->count() > 0)
                           
                            @foreach ($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->payment_date ? \Carbon\Carbon::parse($pago->payment_date)->format('d M, Y') : 'N/A' }}</td>
                                    <td class="transaction-amount">{{ number_format($pago->amount, 2) }} Bs</td>
                                    <td class="transaction-method">{{ $pago->payment_method ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $statusText = '';
                                            $statusClass = '';
                                            switch($pago->status) {
                                                case 1:
                                                    $statusText = 'Pendiente';
                                                    $statusClass = 'pendiente';
                                                    break;
                                                case 2:
                                                    $statusText = 'Pagado';
                                                    $statusClass = 'pagado';
                                                    break;
                                                default:
                                                    $statusText = 'Desconocido';
                                                    $statusClass = 'desconocido';
                                            }
                                        @endphp
                                        <span class="transaction-status {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; font-style: italic; color: #6b7280;">
                                    No hay transacciones registradas
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    
                </table>
                
                
            </div>
               <div class="pagination-wrapper" style="padding: 10px">
                {{ $pagos->links('livewire::simple-bootstrap') }}
            </div>
            
        </div>   --}}
        @include('livewire.pages.tutor.manage-account.components.modal-por-definir')
        @include('livewire.pages.tutor.manage-account.components.modal-cuenta-bancaria')
        @include('livewire.pages.tutor.manage-account.components.modal-qr-nuevo')
        @include('livewire.pages.tutor.manage-account.components.delete-modal')
        @include('livewire.pages.tutor.manage-account.components.verified-modal', [
            'title' => '¡Cuenta verificada!',
            'message' => 'Tu cuenta ha sido verificada exitosamente.',
            'showSocialShare' => true,
        ])
    </div>
    {{-- @endif --}}
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/livewire/pages/tutor/manage-account/components/modal-qr-fixed.css') }}">
    <link rel="stylesheet" href="{{ asset('css/livewire/pages/tutor/manage-account/manage-account.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/livewire/pages/tutor/manage-account/components/modal-cuenta-bancaria.css') }}">
@endpush
@push('scripts')
    <script type="text/javascript" data-navigate-once>
        // Función para limpiar completamente cualquier modal
        function forceCleanupModals() {
            // Remover todos los backdrops
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            // Limpiar clases del body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';

            // Cerrar todos los modales abiertos
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                modal.classList.remove('show');
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            });
        }

        // Listener para manejar modales
        Livewire.on('toggleModel', (data) => {
            console.log('toggleModel event received:', data);

            // Manejar tanto si viene como objeto directo o como array con el objeto
            let event = data;
            if (Array.isArray(data) && data.length > 0) {
                event = data[0];
            }

            console.log('Processed event:', event);

            const modalId = event.id;
            const action = event.action;

            console.log('Modal ID:', modalId, 'Action:', action);

            const modal = document.getElementById(modalId);

            console.log('Modal element found:', modal);

            if (modal) {
                if (action === 'show') {
                    // Limpiar antes de abrir
                    forceCleanupModals();

                    setTimeout(() => {
                        const bootstrapModal = new bootstrap.Modal(modal, {
                            backdrop: true,
                            keyboard: true,
                            focus: true
                        });
                        bootstrapModal.show();
                        console.log('Modal shown:', modalId);
                    }, 100);

                } else if (action === 'hide') {
                    const bootstrapModal = bootstrap.Modal.getInstance(modal);
                    if (bootstrapModal) {
                        bootstrapModal.hide();
                        console.log('Modal hidden:', modalId);
                    } else {
                        // Forzar cierre si no hay instancia
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                        modal.setAttribute('aria-hidden', 'true');
                        console.log('Modal force hidden:', modalId);
                    }

                    // Limpiar después de cerrar
                    setTimeout(forceCleanupModals, 300);
                }
            } else {
                console.error('Modal not found:', modalId);
            }
        });

        // Listener para cuando se cierra un modal desde Livewire
        Livewire.on('modalClosed', () => {
            console.log('Modal closed event from Livewire');
            forceCleanupModals();
        });

        function showVerifiedModalIfNeeded() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('verified') === '1') {
                const modal = document.getElementById('verifiedModal');
                if (modal) {
                    $('#verifiedModal').modal('show');
                }
            }
        }

        // Limpiar al navegar
        document.addEventListener('livewire:navigated', function() {
            forceCleanupModals();
            showVerifiedModalIfNeeded();
        });

        document.addEventListener('DOMContentLoaded', function() {
            showVerifiedModalIfNeeded();

            // Agregar event listeners a todos los modales para cleanup
            const allModals = document.querySelectorAll('.modal');
            allModals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', forceCleanupModals);
            });
        });

        // function openQrFullScreen(container) {
        //     const img = container.querySelector('img');
        //     if (img) {
        //         if (img.requestFullscreen) {
        //             img.requestFullscreen();
        //         } else if (img.webkitRequestFullscreen) {
        //             img.webkitRequestFullscreen();
        //         }
        //     }
        // }

        function openQrFullScreen(container) {
            const img = container.querySelector('img');

            if (!img) return;

            // Evitar duplicar el visor si ya existe
            const existingViewer = document.getElementById('qrFloatingViewer');
            if (existingViewer) {
                existingViewer.remove();
            }

            const overlay = document.createElement('div');
            overlay.id = 'qrFloatingViewer';
            overlay.className = 'qr-floating-overlay';

            overlay.innerHTML = `
    <div class="qr-floating-box">
        <button type="button" class="qr-floating-close" onclick="closeQrFloatingViewer()">
            &times;
        </button>

        <div class="qr-floating-image-wrapper">
            <img src="${img.src}" alt="Código QR ampliado" class="qr-floating-image">
        </div>

        <div class="qr-floating-text" data-translate="manage_account_payment_qr_text">
            ${window.translateText ? window.translateText('manage_account_payment_qr_text', 'Código QR de pago') : 'Código QR de pago'}
        </div>
    </div>
`;

            document.body.appendChild(overlay);

            // Cerrar al hacer clic fuera de la imagen
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeQrFloatingViewer();
                }
            });
        }

        function closeQrFloatingViewer() {
            const viewer = document.getElementById('qrFloatingViewer');
            if (viewer) {
                viewer.remove();
            }
        }

        const BOLIVIA_BANKS_LIST = [
            { name: 'Banco Unión S.A.', keywords: 'banco union sa estatal', short: 'UNIÓN', color: '#004B87', logo: "{{ asset('images/bancos/banco-union-logo.png') }}" },
            { name: 'Banco Mercantil Santa Cruz (BMSC)', keywords: 'banco mercantil santa cruz bmsc', short: 'BMSC', color: '#00593B', logo: "{{ asset('images/bancos/bmsc-logo.png') }}" },
            { name: 'Banco Nacional de Bolivia (BNB)', keywords: 'banco nacional de bolivia bnb', short: 'BNB', color: '#14532D', logo: "{{ asset('images/bancos/bnb_logo_portada.jpg') }}" },
            { name: 'Banco BISA S.A.', keywords: 'banco bisa sa', short: 'BISA', color: '#003366', logo: "{{ asset('images/bancos/bisa-logo.jpeg') }}" },
            { name: 'Banco Ganadero S.A.', keywords: 'banco ganadero sa bg', short: 'BG', color: '#15803D', logo: "{{ asset('images/bancos/ganadero-logo.png') }}" },
            { name: 'Banco Económico S.A.', keywords: 'banco economico sa baneco', short: 'BANECO', color: '#B91C1C', logo: "{{ asset('images/bancos/banco-economico-logo.png') }}" },
            { name: 'Banco FIE S.A.', keywords: 'banco fie sa', short: 'FIE', color: '#9D174D', logo: "{{ asset('images/bancos/fie-logo.png') }}" },
            { name: 'BancoSol S.A.', keywords: 'bancosol banco sol solidario', short: 'SOL', color: '#C2410C', logo: "{{ asset('images/bancos/bancosol-logo.jpeg') }}" },
            { name: 'Banco Fortaleza S.A.', keywords: 'banco fortaleza sa', short: 'FORT', color: '#1E3A8A', logo: "{{ asset('images/bancos/fortaleza-logo.png') }}" },
            { name: 'Banco Prodem S.A.', keywords: 'banco prodem sa', short: 'PRODEM', color: '#065F46', logo: "{{ asset('images/bancos/prodem-logo.png') }}" },
            { name: 'Banco PyME Ecofuturo', keywords: 'banco pyme ecofuturo', short: 'ECO', color: '#166534', logo: "{{ asset('images/bancos/ecofuturo-logo.png') }}" },
            { name: 'Cooperativa Jesús Nazareno', keywords: 'cooperativa jesus nazareno cjn', short: 'CJN', color: '#047857', logo: "{{ asset('images/bancos/jesus-nazareno-logo.png') }}" },
            { name: 'Yape / Billetera Móvil', keywords: 'yape tigo money billetera movil', short: 'YAPE', color: '#6B21A8', logo: "{{ asset('images/bancos/yape-logo.png') }}" }
        ];

        function normalizeBankSearch(str) {
            return (str || '')
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .trim();
        }

        function renderBoliviaBankDropdown(query = '') {
            const dropdown = document.getElementById('boliviaBankDropdownList');
            const input = document.getElementById('bankname');
            if (!dropdown || !input) return;

            const currentVal = normalizeBankSearch(input.value);
            const normQuery = normalizeBankSearch(query);

            // Ordenar para que las coincidencias aparezcan primero al escribir con el teclado
            let sortedBanks = [...BOLIVIA_BANKS_LIST];
            if (normQuery.length > 0) {
                sortedBanks.sort((a, b) => {
                    const aName = normalizeBankSearch(a.name);
                    const bName = normalizeBankSearch(b.name);
                    const aKey = normalizeBankSearch(a.keywords);
                    const bKey = normalizeBankSearch(b.keywords);

                    const aStarts = aName.startsWith(normQuery) || aKey.split(' ').some(w => w.startsWith(normQuery));
                    const bStarts = bName.startsWith(normQuery) || bKey.split(' ').some(w => w.startsWith(normQuery));
                    if (aStarts && !bStarts) return -1;
                    if (!aStarts && bStarts) return 1;

                    const aContains = aName.includes(normQuery) || aKey.includes(normQuery);
                    const bContains = bName.includes(normQuery) || bKey.includes(normQuery);
                    if (aContains && !bContains) return -1;
                    if (!aContains && bContains) return 1;
                    return 0;
                });
            }

            let html = '';
            sortedBanks.forEach((bank) => {
                const normBankName = normalizeBankSearch(bank.name);
                const isSelected = currentVal.length > 0 && normBankName === currentVal;
                const escapedName = bank.name.replace(/'/g, "\\'");

                html += `
                    <div onclick="selectBoliviaBank('${escapedName}', false)"
                         onmouseover="this.style.backgroundColor='#f3f4f6'"
                         onmouseout="this.style.backgroundColor='#ffffff'"
                         style="display: flex; align-items: center; justify-content: space-between; padding: 9px 14px; cursor: pointer; background-color: #ffffff; font-size: 14px; color: #333333; ${isSelected ? 'font-weight: 600;' : 'font-weight: 400;'}">
                        <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                            <img src="${bank.logo}" alt="${bank.short}" style="width: 20px; height: 20px; min-width: 20px; object-fit: contain; border-radius: 4px;"
                                 onerror="this.style.display='none';">
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${bank.name}</span>
                        </div>
                        <span style="color: #333333; font-size: 13px; margin-left: 8px;">${isSelected ? '&#10003;' : ''}</span>
                    </div>
                `;
            });

            // Opción "Otro" al final con el mismo color y estilo simple que las demás opciones
            html += `
                <div onclick="selectBoliviaBank('', true)"
                     onmouseover="this.style.backgroundColor='#f3f4f6'"
                     onmouseout="this.style.backgroundColor='#ffffff'"
                     style="display: flex; align-items: center; justify-content: space-between; padding: 9px 14px; cursor: pointer; background-color: #ffffff; font-size: 14px; color: #333333;">
                    <span>Otro</span>
                </div>
            `;

            dropdown.innerHTML = html;
            dropdown.scrollTop = 0;
        }

        function openBoliviaBankDropdown() {
            const dropdown = document.getElementById('boliviaBankDropdownList');
            const chevron = document.getElementById('bankDropdownChevron');
            const input = document.getElementById('bankname');
            if (!dropdown) return;

            renderBoliviaBankDropdown(input ? input.value : '');
            dropdown.style.display = 'block';
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }

        function closeBoliviaBankDropdown() {
            const dropdown = document.getElementById('boliviaBankDropdownList');
            const chevron = document.getElementById('bankDropdownChevron');
            if (dropdown) dropdown.style.display = 'none';
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }

        function toggleBoliviaBankDropdown(event) {
            if (event) event.stopPropagation();
            const dropdown = document.getElementById('boliviaBankDropdownList');
            if (!dropdown) return;
            if (dropdown.style.display === 'block') {
                closeBoliviaBankDropdown();
            } else {
                openBoliviaBankDropdown();
                const input = document.getElementById('bankname');
                if (input) input.focus();
            }
        }

        function filterBoliviaBankDropdown(value) {
            const hint = document.getElementById('customBankHint');
            if (hint) hint.style.display = 'none';
            openBoliviaBankDropdown();
            renderBoliviaBankDropdown(value);
        }

        function selectBoliviaBank(bankName, isOther = false) {
            const input = document.getElementById('bankname');
            const hint = document.getElementById('customBankHint');
            if (!input) return;

            if (isOther) {
                input.value = '';
                input.placeholder = 'Escriba aquí el nombre de su banco...';
                input.dispatchEvent(new Event('input', { bubbles: true }));
                if (hint) hint.style.display = 'block';
                closeBoliviaBankDropdown();
                setTimeout(() => input.focus(), 50);
            } else {
                input.value = bankName;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                if (hint) hint.style.display = 'none';
                closeBoliviaBankDropdown();
            }
        }

        // Cerrar la lista al hacer clic fuera del selector
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('bolivia-bank-selector-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                closeBoliviaBankDropdown();
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .titulo-metodo-banco {
            padding: 4px 0;
            color: #64748b;
            font-weight: 500;

        }

        .info-metodo-banco {
            padding: 4px 0;
            color: #1e293b;
            font-weight: 600;
            text-align: right;
        }

        /* Paginación */
        .pagination-wrapper {
            margin-top: 18px;
            text-align: center;
        }

        .pagination {
            display: inline-flex;
            gap: 4px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline;
        }

        .pagination .active span,
        .pagination li a {
            padding: 6px 12px;
            border-radius: 6px;
            background: #f7f7f7;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }

        .pagination .active span {
            background: #e38705ff;
            color: #fff;
        }

        .pagination li a:hover {
            background: #e3f2fd;
            color: var(--primary-color);
        }

        .pagination .disabled span {
            background: #eee;
            color: #aaa;
            cursor: not-allowed;
        }


        .page-link {
            background: #FB8500;
            color: white;
        }

        .page-link:hover {
            background: #e57b02ff !important;
            color: white;
        }

        /*estilos para la visualizacion de la imagen flotante*/
        /* ==========================================================================
        ESTILOS OPTIMIZADOS PARA EL VISOR DE QR FLOTANTE (MÁXIMO TAMAÑO DISPONIBLE)
        ========================================================================== */
        .qr-floating-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            backdrop-filter: blur(5px);
            box-sizing: border-box;
        }

        .qr-floating-box {
            position: relative;
            background: #ffffff;
            border-radius: 16px;
            padding: 44px 24px 20px 24px;
            /* Más espacio arriba para que la 'X' no pise la imagen */
            width: 100%;
            max-width: 420px;
            max-height: 90vh;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            animation: qrFloatIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .qr-floating-image-wrapper {
            width: 100%;
            flex: 1;
            /* Ocupa todo el espacio vertical disponible de forma estricta */
            min-height: 0;
            /* Permite a flexbox colapsar el contenedor si la pantalla es baja */
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            padding: 6px;
            /* Colchón de seguridad para evitar que los bordes de la imagen se recorten */
            box-sizing: border-box;
        }

        .qr-floating-image {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
            /* ELIMINA el espacio fantasma inferior que causaba el recorte en PC */
            margin: 0 auto;
            background: #ffffff;
        }

        .qr-floating-close {
            position: absolute;
            top: 12px;
            right: 12px;
            border: none;
            background: #f1f5f9;
            color: #334155;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-size: 22px;
            font-weight: bold;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: background 0.2s, transform 0.1s;
        }

        .qr-floating-close:hover {
            background: #e2e8f0;
            transform: scale(1.05);
        }

        .qr-floating-text {
            margin-top: 14px;
            font-size: 14px;
            color: #475569;
            font-weight: 600;
            flex-shrink: 0;
            /* Evita que el texto se achique o desaparezca */
        }

        @keyframes qrFloatIn {
            from {
                opacity: 0;
                transform: scale(0.97);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        .qr-container {
            position: relative;
            cursor: pointer;
            text-align: center;
            width: 20rem;
            height: 20rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .qr-preview-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            background: #ffffff;
        }

        /* Ajustes específicos para pantallas muy altas o tablets (Opcional) */
        /* ==========================================================================
               MEDIA QUERY PARA TABLETS (Solución al tamaño pequeño)
               ========================================================================== */
        @media (min-width: 600px) and (max-width: 1024px) {
            .qr-floating-box {
                max-width: 520px;
                max-height: 85vh;
            }
        }

        /* ==========================================================================
                    MEDIA QUERIES PARA PANTALLAS GRANDES (WEB / ESCRITORIO)
                   ========================================================================== */
        @media (min-width: 768px) {
            .qr-floating-box {
                /* Si la pantalla es grande y la imagen es vertical, permitimos más ancho dinámico */
                max-width: 520px;
            }

            .qr-floating-image-wrapper {
                /* Incremento de rango de visibilidad vertical en computadoras */
                max-height: 82vh;
            }
        }

        /* ==========================================================================
               MEDIA QUERY PARA PC / ESCRITORIO (Ajuste fino de proporciones)
               ========================================================================== */
        @media (min-width: 1025px) {
            .qr-floating-box {
                max-width: 410px;
                /* max-height: 80vh; */
                /* Bajado a 80vh para asegurar que quepa en cualquier monitor sin rozar los bordes */
            }

            .qr-floating-image-wrapper {
                padding: 8px;
                /* Un poco más de aire en PC para asegurar visualización completa */
            }
        }
    </style>
@endpush
