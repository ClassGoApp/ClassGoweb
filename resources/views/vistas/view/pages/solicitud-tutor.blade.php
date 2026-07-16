@extends('vistas.view.layouts.blank')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google Fonts & Flatpickr -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Premium Styling and Reset */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Outfit', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #073b4c 0%, #118ab2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #023047;
    }

    .container {
        width: 100%;
        max-width: 600px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 40px;
        animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .logo {
        font-size: 32px;
        font-weight: 700;
        color: #023047;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .logo span {
        color: #FB8500;
    }

    .subtitle {
        font-size: 16px;
        color: #64748b;
        font-weight: 400;
    }

    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        margin-top: 10px;
    }

    .status-pending { background: #e0f2fe; color: #0369a1; }
    .status-countered_tutor { background: #fef3c7; color: #b45309; }
    .status-countered_student { background: #ffedd5; color: #c2410c; }
    .status-accepted { background: #dcfce7; color: #15803d; }
    .status-rejected { background: #fee2e2; color: #b91c1c; }
    .status-paid { background: #dbeafe; color: #1e40af; }

    /* Cards */
    .info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        border-color: #219EBC;
        box-shadow: 0 8px 20px rgba(33, 158, 188, 0.1);
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #023047;
    }

    .grid-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #023047;
    }

    .proposal-box {
        background: #eef2f6;
        border-radius: 12px;
        padding: 16px;
        margin-top: 10px;
    }

    .proposal-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 15px;
    }

    .proposal-row:last-child {
        margin-bottom: 0;
    }

    .proposal-row svg {
        width: 18px;
        height: 18px;
        color: #219EBC;
    }

    .note-box {
        margin-top: 10px;
        font-style: italic;
        color: #475569;
        font-size: 14px;
        border-left: 3px solid #cbd5e1;
        padding-left: 10px;
    }

    /* Buttons */
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .btn {
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary {
        background: #219EBC;
        color: white;
    }

    .btn-primary:hover {
        background: #028090;
        transform: translateY(-2px);
    }

    .btn-orange {
        background: #FB8500;
        color: white;
    }

    .btn-orange:hover {
        background: #e07a00;
        transform: translateY(-2px);
    }

    .btn-danger-outline {
        background: transparent;
        border: 2px solid #ef4444;
        color: #ef4444;
    }

    .btn-danger-outline:hover {
        background: #fee2e2;
        transform: translateY(-2px);
    }

    .status-text {
        text-align: center;
        font-size: 16px;
        font-weight: 500;
        color: #475569;
        padding: 15px;
        background: #f1f5f9;
        border-radius: 12px;
    }

    /* Counter Offer Panel */
    .counter-panel {
        display: none;
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        margin-top: 20px;
        animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #023047;
    }

    .input-field {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s;
    }

    .input-field:focus {
        border-color: #219EBC;
    }

    /* Digital Clock Style */
    .digital-clock-picker {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .clock-select {
        flex: 1;
        padding: 12px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        outline: none;
        font-size: 15px;
        background: white;
    }

    .ampm-toggle {
        display: flex;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
    }

    .ampm-btn {
        padding: 12px 16px;
        border: none;
        background: #f1f5f9;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        color: #475569;
        transition: all 0.2s;
    }

    .ampm-btn.active {
        background: #219EBC;
        color: white;
    }

    /* Duration Chips */
    .duration-chips {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .chip {
        padding: 12px 6px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        background: white;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        color: #475569;
    }

    .chip:hover {
        border-color: #219EBC;
        color: #219EBC;
    }

    .chip.active {
        background: #219EBC;
        border-color: #219EBC;
        color: white;
    }

    /* Styling for Payment Modal */
    .pay-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .pay-modal-overlay.is-open {
        display: flex;
        opacity: 1;
    }
    .pay-modal-box {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        width: 100%;
        max-width: 600px;
        position: relative;
        padding: 30px;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: transform 0.3s ease;
        text-align: left;
    }
    .pay-modal-overlay.is-open .pay-modal-box {
        transform: translateY(0);
    }
    .pay-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .pay-modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #023047;
    }
    .pay-modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: #94a3b8;
        cursor: pointer;
        line-height: 1;
    }
    .pay-modal-close:hover {
        color: #ef4444;
    }

    /* Tabs */
    .pay-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
    }
    .pay-tab-btn {
        flex: 1;
        border: none;
        background: none;
        padding: 10px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 8px;
        cursor: pointer;
        color: #64748b;
        transition: all 0.2s ease;
    }
    .pay-tab-btn.active {
        background: #ffffff;
        color: #023047;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    /* QR Code Section */
    .pay-qr-container {
        text-align: center;
        margin-bottom: 20px;
    }
    .pay-qr-image {
        width: 180px;
        height: 180px;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 8px;
        background: #fff;
        object-fit: contain;
        margin: 0 auto 10px;
        display: block;
    }
    .pay-qr-btn-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        color: #023047;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .pay-qr-btn-download:hover {
        background: #e2e8f0;
    }

    /* Details and Totals Card */
    .pay-summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .pay-summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .pay-summary-row:last-child {
        margin-bottom: 0;
    }
    .pay-summary-label {
        color: #64748b;
    }
    .pay-summary-value {
        font-weight: 600;
        color: #023047;
    }

    /* Coupon Area */
    .pay-coupon-title {
        font-size: 14px;
        font-weight: 600;
        color: #023047;
        margin-bottom: 8px;
    }
    .pay-coupon-group {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
    }
    .pay-coupon-input {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .pay-coupon-input:focus {
        border-color: #219EBC;
    }
    .pay-coupon-btn {
        background: #023047;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-weight: 600;
        cursor: pointer;
    }
    .pay-coupon-btn:hover {
        background: #054a6b;
    }
    .pay-coupon-bar {
        display: none;
        background: #ecfdf5;
        border: 1px dashed #6ee7b7;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        color: #065f46;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .pay-coupon-msg {
        font-size: 12px;
        min-height: 15px;
        margin-bottom: 15px;
    }

    /* Receipt Upload Box */
    .pay-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 24px;
        display: block;
    }
    .pay-upload-box:hover {
        border-color: #219EBC;
        background: #f8fafc;
    }
    .pay-upload-box.input-error {
        border-color: #ef4444;
        background: #fee2e2;
    }
    .pay-upload-box.has-file {
        border-color: #10b981;
        background: #ecfdf5;
    }
    .pay-upload-text {
        font-weight: 600;
        color: #023047;
        margin-bottom: 4px;
    }
    .pay-upload-subtext {
        font-size: 12px;
        color: #64748b;
    }

    /* Footer Buttons */
    .pay-actions {
        display: flex;
        gap: 12px;
    }
    .pay-btn {
        flex: 1;
        padding: 12px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .pay-btn-secondary {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        color: #475569;
    }
    .pay-btn-secondary:hover {
        background: #e2e8f0;
    }
    .pay-btn-primary {
        background: #15803d;
        border: none;
        color: #fff;
    }
    .pay-btn-primary:hover {
        background: #166534;
    }
</style>

<div class="container">
    <div class="header">
        <h1 class="logo">Class<span>Go</span></h1>
        <p class="subtitle">Propuesta de Tutoría Personalizada</p>
        
        <!-- Status Display -->
        @if($request->status === 'pending')
            <span class="status-badge status-pending">Pendiente del Tutor</span>
        @elseif($request->status === 'countered_by_tutor')
            <span class="status-badge status-countered_tutor">Contrapropuesta del Tutor</span>
        @elseif($request->status === 'countered_by_student')
            <span class="status-badge status-countered_student">Contrapropuesta del Estudiante</span>
        @elseif($request->status === 'accepted')
            <span class="status-badge status-accepted">Aceptada</span>
        @elseif($request->status === 'rejected')
            <span class="status-badge status-rejected">Rechazada / Cancelada</span>
        @elseif($request->status === 'paid')
            <span class="status-badge status-paid">Pagada / Reservada</span>
        @endif
    </div>

    <!-- Request Details -->
    <div class="info-card">
        <h3 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
            Detalles de la Clase
        </h3>
        
        <div class="grid-details">
            <div class="detail-item">
                <span class="detail-label">Estudiante</span>
                <span class="detail-value">{{ $student->full_name ?: ($student->name ?? 'Estudiante') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Tutor</span>
                <span class="detail-value">{{ $tutor->full_name ?: ($tutor->name ?? 'Tutor') }}</span>
            </div>
            <div class="detail-item" style="grid-column: span 2;">
                <span class="detail-label">Materia</span>
                <span class="detail-value">{{ $subject->name }}</span>
            </div>
        </div>

        <div class="proposal-box">
            <div class="proposal-row">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <span><strong>Fecha propuesta:</strong> {{ $formattedDate }}</span>
            </div>
            <div class="proposal-row">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span><strong>Horario propuesto:</strong> {{ $request->current_time }}</span>
            </div>
            <div class="proposal-row">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6M12 12M12 18" />
                </svg>
                <span><strong>Duración:</strong> {{ $request->current_duration }}</span>
            </div>
            @if($request->note)
                <div class="note-box">
                    "{{ $request->note }}"
                </div>
            @endif
        </div>
    </div>

    <!-- Active Action Buttons -->
    <div class="btn-group">
        @if($request->status === 'paid')
            <div class="status-text" style="color: #1e40af; border-left: 4px solid #1e40af; background: #eff6ff; width: 100%; padding: 15px; border-radius: 12px; font-weight: 500; text-align: left; display: block !important; box-sizing: border-box; margin-bottom: 15px;">
                🎉 <strong>Tutoría Confirmada:</strong> Esta solicitud ya ha sido pagada y agendada exitosamente. ¡Buen aprendizaje!
            </div>
            @if($meetingLink)
                <a href="{{ $meetingLink }}" target="_blank" class="btn btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; width: 100%; box-sizing: border-box; font-weight: 600; padding: 12px 24px; border-radius: 12px; background-color: #219EBC; border-color: #219EBC; color: white;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px; vertical-align: middle;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    Ir a la Reunión de Google Meet
                </a>
            @else
                <div class="status-text" style="color: #64748b; font-style: italic; margin-top: 5px;">
                    El enlace de Google Meet no está disponible en este momento.
                </div>
            @endif
        @elseif($isSlotBooked)
            <div class="status-text" style="color: #b45309; border-left: 4px solid #d97706; background: #fef3c7; width: 100%; padding: 15px; border-radius: 12px; font-weight: 500; margin-bottom: 15px; text-align: left; display: block !important; box-sizing: border-box;">
                ⚠️ <strong>Horario no disponible:</strong> Este horario ya ha sido reservado. Si lo deseas, puedes proponer un nuevo horario usando el botón de abajo.
            </div>
            @if($role === 'student')
                <button class="btn btn-orange" style="margin-bottom: 10px;" onclick="toggleCounterPanel()">
                    🔄 Proponer Nuevo Horario (Contraofertar)
                </button>
            @endif
        @elseif($request->status === 'accepted')
            @if($role === 'student')
                <button class="btn btn-primary" onclick="proceedToPayment()">
                    💳 Pagar y Reservar Tutoría
                </button>
            @else
                <div class="status-text">
                    La propuesta ha sido aceptada. El estudiante está completando la reserva.
                </div>
            @endif
        @elseif($request->status === 'rejected')
            <div class="status-text" style="color: #ef4444; border-left: 4px solid #ef4444; background: #fee2e2;">
                Esta solicitud ha sido rechazada o cancelada. El enlace ya no está activo.
            </div>
        @else
            <!-- Negotiation mode -->
            @php
                $isMyTurn = false;
                if ($role === 'tutor' && ($request->status === 'pending' || $request->status === 'countered_by_student')) {
                    $isMyTurn = true;
                } elseif ($role === 'student' && $request->status === 'countered_by_tutor') {
                    $isMyTurn = true;
                }
            @endphp

            @if($isMyTurn)
                @if($role === 'tutor')
                    <button class="btn btn-primary" onclick="acceptProposal()">
                        ✅ Aceptar Horario Propuesto
                    </button>
                @else
                    <button class="btn btn-primary" onclick="proceedToPayment()">
                        💳 Aceptar y Reservar (Pagar)
                    </button>
                @endif

                <button class="btn btn-orange" onclick="toggleCounterPanel()">
                    🔄 Proponer Otro Horario (Contraofertar)
                </button>

                <button class="btn btn-danger-outline" onclick="rejectProposal()">
                    ❌ Rechazar Propuesta
                </button>
            @else
                <div class="status-text">
                    Esperando la respuesta del {{ $role === 'tutor' ? 'estudiante' : 'tutor' }}... Te notificaremos por correo electrónico una vez responda.
                </div>
            @endif
        @endif
    </div>

    <!-- Counter Offer Form Panel -->
    <div class="counter-panel" id="counterPanel">
        <h3 style="font-size:18px; font-weight:600; margin-bottom:15px; color:#023047;">Proponer nueva oferta</h3>
        
        <div class="form-group">
            <label class="form-label">Nueva Fecha</label>
            <input type="text" id="counter_date" class="input-field" placeholder="Selecciona una fecha">
        </div>

        <div class="form-group">
            <label class="form-label">Nueva Hora de Inicio</label>
            <div class="digital-clock-picker">
                <select id="clock_hour" class="clock-select">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
                <span style="font-weight:700; color:#023047;">:</span>
                <select id="clock_minute" class="clock-select">
                    <option value="00">00</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                </select>
                <div class="ampm-toggle">
                    <button id="ampm_am" class="ampm-btn active" onclick="setAmPm('AM')">AM</button>
                    <button id="ampm_pm" class="ampm-btn" onclick="setAmPm('PM')">PM</button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Duración de la Sesión</label>
            <div class="duration-chips">
                <div class="chip active" onclick="selectDuration('20 min')">20 min</div>
                <div class="chip" onclick="selectDuration('40 min')">40 min</div>
                <div class="chip" onclick="selectDuration('1 hora')">1 hora</div>
                <div class="chip" onclick="selectDuration('1h 20m')">1h 20m</div>
                <div class="chip" onclick="selectDuration('1h 40m')">1h 40m</div>
                <div class="chip" onclick="selectDuration('2 horas')">2 horas</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Mensaje / Nota explicativa</label>
            <textarea id="counter_note" class="input-field" style="height: 80px; resize: none;" placeholder="Ej. Tengo libre esta hora porque se canceló otra clase..."></textarea>
        </div>

        <button class="btn btn-orange" onclick="submitCounterOffer()">
            🚀 Enviar Nueva Propuesta
        </button>
    </div>
</div>

@if($role === 'student')
    <!-- MODAL DE PAGO PREMIUM -->
    <div id="payment-modal" class="pay-modal-overlay">
        <div class="pay-modal-box">
            <div class="pay-modal-header">
                <h3 class="pay-modal-title">Pagar y Reservar Tutoría</h3>
                <button type="button" class="pay-modal-close" onclick="closePayModal()">&times;</button>
            </div>

            <!-- Métodos de pago (Tabs) -->
            <div class="pay-tabs">
                <button type="button" id="tab-bolivia" class="pay-tab-btn active" onclick="switchPayMethod('bolivia')">
                    🇧🇴 QR Bolivia
                </button>
                <button type="button" id="tab-takenos" class="pay-tab-btn" onclick="switchPayMethod('takenos')">
                    Takenos Internacional
                </button>
            </div>

            <!-- QR code visualizer -->
            <div class="pay-qr-container">
                <img id="modal-qr-image" src="{{ asset('storage/qr/Qr-pagos.png') }}" alt="QR Bolivia" class="pay-qr-image">
                <a id="modal-qr-download" href="{{ asset('storage/qr/Qr-pagos.png') }}" download="QR-Pago-Bolivia.png" class="pay-qr-btn-download">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Descargar QR Bolivia</span>
                </a>
            </div>

            <!-- Resumen de reserva -->
            <div class="pay-summary-card">
                <div class="pay-summary-row">
                    <span class="pay-summary-label">Materia:</span>
                    <span class="pay-summary-value">{{ $subject->name }}</span>
                </div>
                <div class="pay-summary-row">
                    <span class="pay-summary-label">Tutor:</span>
                    <span class="pay-summary-value">{{ $tutor->full_name }}</span>
                </div>
                <div class="pay-summary-row">
                    <span class="pay-summary-label">Fecha:</span>
                    <span class="pay-summary-value">{{ $formattedDate }}</span>
                </div>
                <div class="pay-summary-row">
                    <span class="pay-summary-label">Horario:</span>
                    <span class="pay-summary-value">{{ $request->current_time }} ({{ $request->current_duration }})</span>
                </div>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 12px 0;">
                <div class="pay-summary-row" id="coupon-discount-row" style="display: none;">
                    <span class="pay-summary-label">Descuento (<span id="coupon-discount-pct">0</span>%):</span>
                    <span class="pay-summary-value" style="color: #ef4444;" id="coupon-discount-val">-0.00 Bs.</span>
                </div>
                <div class="pay-summary-row" style="font-size: 16px; font-weight: 700;">
                    <span class="pay-summary-label" style="color: #023047;">Total a Pagar:</span>
                    <span class="pay-summary-value" style="color: #219EBC;" id="modal-total-display">Bs. 0.00</span>
                </div>
            </div>

            <!-- Sección de Cupones -->
            <div class="pay-coupon-title">¿Tienes un cupón de descuento?</div>
            <div class="pay-coupon-group" id="coupon-input-group">
                <input type="text" id="modal-coupon-input" placeholder="Ej. classgo25" class="pay-coupon-input">
                <button type="button" class="pay-coupon-btn" onclick="validateModalCoupon()">Aplicar</button>
            </div>
            
            <div class="pay-coupon-bar" id="modal-coupon-bar">
                <span>Cupón aplicado: <strong id="modal-coupon-code-text"></strong></span>
                <button type="button" style="border: none; background: transparent; color: #065f46; font-weight: 700; cursor: pointer;" onclick="removeModalCoupon()">Quitar</button>
            </div>

            <div class="pay-coupon-msg" id="modal-coupon-msg"></div>

            <!-- Subir Comprobante -->
            <div class="pay-coupon-title">Subir comprobante de pago</div>
            <label for="modal-receipt-file" class="pay-upload-box" id="receipt-upload-box">
                <p class="pay-upload-text" id="upload-box-text">📄 Subir comprobante</p>
                <p class="pay-upload-subtext">Selecciona tu captura o imagen del pago</p>
                <input type="file" id="modal-receipt-file" accept="image/*,application/pdf" style="display: none;" onchange="handleReceiptFileSelected()">
            </label>

            <!-- Acciones -->
            <div class="pay-actions">
                <button type="button" class="pay-btn pay-btn-secondary" onclick="closePayModal()">Cancelar</button>
                <button type="button" class="pay-btn pay-btn-primary" id="confirm-payment-btn" onclick="submitPayment()">Confirmar Reserva</button>
            </div>
        </div>
    </div>
@endif

<script>
    // Variables de Estado
    const token = "{{ $token }}";
    let selectedDurationVal = '20 min';
    let selectedAmPmVal = 'AM';

    // Inicializar Flatpickr
    flatpickr("#counter_date", {
        minDate: "today",
        dateFormat: "Y-m-d",
        locale: "es",
    });

    // Abrir modal de pago automáticamente si viene el parámetro open_payment=1 y no está pagada
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('open_payment') === '1' && "{{ $request->status }}" !== 'paid') {
            openPayModal();
        }
    });

    function toggleCounterPanel() {
        const panel = document.getElementById('counterPanel');
        if(panel.style.display === 'none' || panel.style.display === '') {
            panel.style.display = 'block';
            panel.scrollIntoView({ behavior: 'smooth' });
        } else {
            panel.style.display = 'none';
        }
    }

    function setAmPm(val) {
        selectedAmPmVal = val;
        document.getElementById('ampm_am').classList.toggle('active', val === 'AM');
        document.getElementById('ampm_pm').classList.toggle('active', val === 'PM');
    }

    function selectDuration(val) {
        selectedDurationVal = val;
        const chips = document.querySelectorAll('.duration-chips .chip');
        chips.forEach(c => {
            if(c.textContent.trim() === val) {
                c.classList.add('active');
            } else {
                c.classList.remove('active');
            }
        });
    }

    async function rejectProposal() {
        const confirm = await Swal.fire({
            title: '¿Rechazar esta propuesta?',
            text: "Esta acción no se puede deshacer y cancelará la negociación.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Sí, rechazar',
            cancelButtonText: 'Cancelar'
        });

        if(!confirm.isConfirmed) return;

        Swal.showLoading();

        try {
            const res = await fetch(`/solicitud-clase/${token}/rechazar`, {
                method: 'POST',
                headers: {
                    'X-CSR-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if(data.success) {
                Swal.fire('Rechazada', 'Has rechazado la solicitud.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message || 'No se pudo rechazar.', 'error');
            }
        } catch(e) {
            Swal.fire('Error', 'Error de conexión.', 'error');
        }
    }

    async function acceptProposal() {
        const confirm = await Swal.fire({
            title: '¿Aceptar horario?',
            text: "Se notificará al estudiante para que complete el pago.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#219EBC',
            cancelButtonColor: '#cbd5e1',
            confirmButtonText: 'Sí, aceptar',
            cancelButtonText: 'Cancelar'
        });

        if(!confirm.isConfirmed) return;

        Swal.showLoading();

        try {
            const res = await fetch(`/solicitud-clase/${token}/aceptar`, {
                method: 'POST',
                headers: {
                    'X-CSR-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            if(data.success) {
                Swal.fire('Aceptada', 'Has aceptado la propuesta con éxito.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message || 'No se pudo aceptar.', 'error');
            }
        } catch(e) {
            Swal.fire('Error', 'Error de conexión.', 'error');
        }
    }

    async function submitCounterOffer() {
        const date = document.getElementById('counter_date').value;
        const hour = document.getElementById('clock_hour').value;
        const minute = document.getElementById('clock_minute').value;
        const note = document.getElementById('counter_note').value;

        if(!date) {
            Swal.fire('Campo requerido', 'Por favor selecciona la nueva fecha.', 'warning');
            return;
        }

        const formattedTime = `${hour}:${minute} ${selectedAmPmVal}`;

        Swal.showLoading();

        try {
            const res = await fetch(`/solicitud-clase/${token}/contraofertar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSR-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    counter_date: date,
                    counter_time: formattedTime,
                    counter_duration: selectedDurationVal,
                    note: note
                })
            });
            const data = await res.json();
            if(data.success) {
                Swal.fire('Contraoferta enviada', 'Nueva propuesta enviada exitosamente.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message || 'No se pudo enviar la contrapropuesta.', 'error');
            }
        } catch(e) {
            Swal.fire('Error', 'Error de conexión.', 'error');
        }
    }

    // === PAYMENT MODAL SCRIPT LOGIC ===
    let baseTutorPrice = parseFloat("{{ $tutor->price ?? 0 }}");
    let durationTxt = "{{ $request->current_duration ?? '20 min' }}";
    
    // Calculate blocks count
    let durationMins = 20;
    const dur = durationTxt.toLowerCase();
    if (dur.includes('20')) durationMins = 20;
    else if (dur.includes('40')) durationMins = 40;
    else if (dur.includes('1 hora') || dur === '1h' || dur.includes('60')) durationMins = 60;
    else if (dur.includes('1h 20') || dur.includes('1h 20m') || dur.includes('80')) durationMins = 80;
    else if (dur.includes('1h 40') || dur.includes('1h 40m') || dur.includes('100')) durationMins = 100;
    else if (dur.includes('2 hora') || dur === '2h' || dur.includes('120')) durationMins = 120;
    
    const blocksCount = durationMins / 20;
    let baseTotal = baseTutorPrice * blocksCount;
    
    let appliedDiscountDecimal = 0;
    let appliedDiscountPct = 0;
    let selectedCouponId = null;
    let isFreeBooking = false;
    let receiptFile = null;

    function openPayModal() {
        const modal = document.getElementById('payment-modal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('is-open'), 10);
            calculateAndDisplayTotals();
        }
    }

    function closePayModal() {
        const modal = document.getElementById('payment-modal');
        if (modal) {
            modal.classList.remove('is-open');
            setTimeout(() => modal.style.display = 'none', 300);
        }
    }

    function switchPayMethod(method) {
        const tabBolivia = document.getElementById('tab-bolivia');
        const tabTakenos = document.getElementById('tab-takenos');
        const qrImage = document.getElementById('modal-qr-image');
        const qrDownload = document.getElementById('modal-qr-download');

        if (method === 'bolivia') {
            tabBolivia.classList.add('active');
            tabTakenos.classList.remove('active');
            qrImage.src = "{{ asset('storage/qr/Qr-pagos.png') }}";
            qrImage.alt = "QR Bolivia";
            qrDownload.href = "{{ asset('storage/qr/Qr-pagos.png') }}";
            qrDownload.download = "QR-Pago-Bolivia.png";
            qrDownload.querySelector('span').textContent = "Descargar QR Bolivia";
        } else {
            tabBolivia.classList.remove('active');
            tabTakenos.classList.add('active');
            qrImage.src = "{{ asset('storage/qr/qr-takenos.png') }}";
            qrImage.alt = "QR Takenos";
            qrDownload.href = "{{ asset('storage/qr/qr-takenos.png') }}";
            qrDownload.download = "QR-Takenos-Internacional.png";
            qrDownload.querySelector('span').textContent = "Descargar QR Takenos";
        }
    }

    function calculateAndDisplayTotals() {
        let currentPrice = baseTotal * (1 - appliedDiscountDecimal);
        if (currentPrice < 0) currentPrice = 0;
        isFreeBooking = currentPrice <= 0.00001;
        
        document.getElementById('modal-total-display').textContent = `Bs. ${currentPrice.toFixed(2)}`;
        
        const discountRow = document.getElementById('coupon-discount-row');
        if (appliedDiscountPct > 0) {
            discountRow.style.display = 'flex';
            document.getElementById('coupon-discount-pct').textContent = appliedDiscountPct;
            const discountVal = baseTotal - currentPrice;
            document.getElementById('coupon-discount-val').textContent = `-${discountVal.toFixed(2)} Bs.`;
        } else {
            discountRow.style.display = 'none';
        }
    }

    async function validateModalCoupon() {
        const code = document.getElementById('modal-coupon-input').value.trim();
        if (!code) return;
        const msgEl = document.getElementById('modal-coupon-msg');
        msgEl.textContent = 'Validando...';
        msgEl.style.color = '#64748b';
        
        try {
            const res = await fetch('/student/booking/validar-cupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ codigo: code })
            });
            const data = await res.json();
            if (data.success) {
                selectedCouponId = data.coupon_id;
                appliedDiscountDecimal = parseFloat(data.descuento || 0);
                appliedDiscountPct = Math.round(appliedDiscountDecimal * 100);
                
                document.getElementById('coupon-input-group').style.display = 'none';
                document.getElementById('modal-coupon-bar').style.display = 'flex';
                document.getElementById('modal-coupon-code-text').textContent = code;
                
                msgEl.textContent = data.message;
                msgEl.style.color = '#28a745';
                
                calculateAndDisplayTotals();
            } else {
                msgEl.textContent = data.message;
                msgEl.style.color = '#dc3545';
            }
        } catch (e) {
            msgEl.textContent = 'Error al validar cupón';
            msgEl.style.color = '#dc3545';
        }
    }

    function removeModalCoupon() {
        selectedCouponId = null;
        appliedDiscountDecimal = 0;
        appliedDiscountPct = 0;
        
        document.getElementById('modal-coupon-input').value = '';
        document.getElementById('coupon-input-group').style.display = 'flex';
        document.getElementById('modal-coupon-bar').style.display = 'none';
        document.getElementById('modal-coupon-msg').textContent = '';
        
        calculateAndDisplayTotals();
    }

    function handleReceiptFileSelected() {
        const fileInput = document.getElementById('modal-receipt-file');
        const box = document.getElementById('receipt-upload-box');
        const text = document.getElementById('upload-box-text');
        
        if (fileInput.files.length > 0) {
            receiptFile = fileInput.files[0];
            box.classList.add('has-file');
            box.classList.remove('input-error');
            text.textContent = `✓ ${receiptFile.name}`;
        } else {
            receiptFile = null;
            box.classList.remove('has-file');
            text.textContent = '📄 Subir comprobante';
        }
    }

    function getSlotsArray() {
        const timeStr = "{{ $request->current_time }}";
        let startPart = timeStr.trim();
        if (startPart.includes(' - ')) {
            startPart = startPart.split(' - ')[0].trim();
        }
        
        const match = startPart.match(/^(\d+):(\d+)(?:\s*(AM|PM))?$/i);
        if (!match) return [];
        
        let hours = parseInt(match[1]);
        const minutes = parseInt(match[2]);
        const ampm = match[3] ? match[3].toUpperCase() : null;
        if (ampm) {
            if (ampm === 'PM' && hours !== 12) hours += 12;
            if (ampm === 'AM' && hours === 12) hours = 0;
        }
        
        const startMins = hours * 60 + minutes;
        const slots = [];
        
        for (let i = 0; i < blocksCount; i++) {
            const blockStart = startMins + i * 20;
            const blockEnd = startMins + (i + 1) * 20;
            
            const sh = Math.floor(blockStart / 60);
            const sm = blockStart % 60;
            const startFormatted = String(sh).padStart(2, '0') + ':' + String(sm).padStart(2, '0');
            
            const eh = Math.floor(blockEnd / 60);
            const em = blockEnd % 60;
            const endFormatted = String(eh).padStart(2, '0') + ':' + String(em).padStart(2, '0');
            
            slots.push(`0|${startFormatted}|${endFormatted}`);
        }
        return slots;
    }

    async function submitPayment() {
        if (!isFreeBooking && !receiptFile) {
            const box = document.getElementById('receipt-upload-box');
            box.classList.add('input-error');
            Swal.fire('Comprobante requerido', 'Por favor sube la captura de tu comprobante de pago.', 'warning');
            return;
        }
        
        const confirmBtn = document.getElementById('confirm-payment-btn');
        confirmBtn.disabled = true;
        confirmBtn.textContent = 'Procesando...';
        
        Swal.fire({
            title: 'Procesando...',
            text: 'Estamos registrando tu reserva, por favor espera.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        const slots = getSlotsArray();
        const formData = new FormData();
        formData.append('subject_id', "{{ $request->subject_id }}");
        formData.append('tutor_id', "{{ $request->tutor_id }}");
        formData.append('slot_date', "{{ $request->current_date }}");
        formData.append('is_free', isFreeBooking ? '1' : '0');
        if (selectedCouponId) {
            formData.append('coupon_id', selectedCouponId);
        }
        if (!isFreeBooking && receiptFile) {
            formData.append('comprobante', receiptFile);
        }
        formData.append('tutor_request_token', token);
        
        slots.forEach(slot => formData.append('slots[]', slot));
        
        try {
            const response = await fetch('/student/booking/reservar-multi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const data = await response.json();
            if (data.success) {
                closePayModal();
                Swal.fire({
                    title: '¡Reserva Exitosa!',
                    text: 'Tu clase ha sido agendada e ingresada correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#219EBC'
                }).then(() => {
                    location.reload();
                });
            } else {
                confirmBtn.disabled = false;
                confirmBtn.textContent = 'Confirmar Reserva';
                Swal.fire('Error', data.message || 'No se pudo completar la reserva.', 'error');
            }
        } catch (e) {
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'Confirmar Reserva';
            Swal.fire('Error', 'Error de conexión con el servidor.', 'error');
        }
    }

    function proceedToPayment() {
        openPayModal();
    }
</script>
@endsection
