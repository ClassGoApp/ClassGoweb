@extends('vistas.view.layouts.blank')

@section('content')
<link rel="stylesheet" href="{{ asset('css/estilos/tutoria-instantanea.css') }}?v={{ filemtime(public_path('css/estilos/tutoria-instantanea.css')) }}">

<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }
    
    .waiting-tutor-section {
        min-height: 100dvh;
        height: 100dvh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .waiting-card {
        background: white;
        border-radius: 1.25rem;
        max-width: 300px;
        width: 100%;
        max-height: calc(100dvh - 0.8rem);
        box-shadow: 0 25px 50px -12px rgba(2, 48, 71, 0.15);
        overflow: visible;
        border: 1px solid #e2e8f0;
        position: relative;
    }
    
    .waiting-header {
        background: linear-gradient(135deg, #023047 0%, #219EBC 100%);
        padding: 0.8rem 0.8rem 1.25rem;
        text-align: center;
        color: white;
        position: relative;
        border-radius: 1.25rem 1.25rem 0 0;
        overflow: hidden;
    }
    
    .waiting-header::after {
        content: '';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
    }
    
    .pulse-ring {
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.5);
        animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
    
    @keyframes pulse-ring {
        0% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 1;
        }
        80%, 100% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 0;
        }
    }
    
    .tutor-avatar-wrapper {
        position: relative;
        width: 62px;
        height: 62px;
        margin: 0 auto 0.35rem;
    }
    
    .tutor-avatar {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        border: 3px solid white;
        object-fit: cover;
        position: relative;
        z-index: 2;
    }
    
    .waiting-content {
        padding: 1.9rem 1rem 1rem;
        text-align: center;
        border-radius: 0 0 1.25rem 1.25rem;
        overflow: visible;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #fef3c7;
        color: #92400e;
        padding: 0.4rem 0.9rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid #fbbf24;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .subject-tag {
        display: inline-block;
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        color: #075985;
        padding: 0.35rem 0.8rem;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .countdown-box {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 0.9rem;
        padding: 0.75rem;
        margin-bottom: 0.9rem;
        border: 2px solid #e2e8f0;
    }
    
    .countdown-time {
        font-size: 1.5rem;
        font-weight: 800;
        color: #023047;
        font-family: 'Courier New', monospace;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.6rem;
        flex-direction: column;
        position: relative;
        z-index: 10;
    }
    
    .btn-cancel {
        width: 100%;
        padding: 0.8rem;
        background: white;
        color: #64748b;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        z-index: 30;
        pointer-events: auto;
    }
    
    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
    
    .tutor-info {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        background: #f8fafc;
        padding: 0.65rem;
        border-radius: 0.75rem;
        margin-bottom: 0.9rem;
        text-align: left;
    }
    
    .tutor-info-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    
    @media (max-width: 640px) {
        .waiting-tutor-section {
            padding: 0.75rem;
        }
        .waiting-content {
            padding: 2.6rem 1.25rem 1.25rem;
        }
        .waiting-card {
            max-width: 100%;
        }
    }
</style>

<section class="waiting-tutor-section">
    <div class="waiting-card">
        <div class="waiting-header">
            <div class="tutor-avatar-wrapper" style="z-index:2;position:relative;">
                <div class="pulse-ring" style="width:74px;height:74px;"></div>
                <div class="pulse-ring" style="animation-delay: 0.5s;width:74px;height:74px;"></div>
                @if($tutor && $tutor->image)
                    <img src="{{ asset('storage/'.$tutor->image) }}" alt="{{ $tutor->first_name }}" class="tutor-avatar">
                @else
                    <div class="tutor-avatar" style="background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center;">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                @endif
            </div>
            <h1 style="font-size: 1.08rem; font-weight: 800; margin-bottom: 0.12rem; position: relative; z-index: 1;" data-translate="waiting_tutor_title">Esperando respuesta</h1>
            <p style="opacity: 0.9; font-size: 0.78rem; position: relative; z-index: 1;" data-translate="waiting_tutor_subtitle">Tu solicitud ha sido enviada</p>
        </div>
        
        <div class="waiting-content" style="position:relative;z-index:5;">
            @if($tutor)
            <div class="tutor-info" style="padding:0.5rem;margin-bottom:0.6rem;">
                <img src="{{ $tutor->image ? asset('storage/'.$tutor->image) : asset('images/default-avatar.png') }}" alt="{{ $tutor->first_name }}" class="tutor-info-avatar" style="width:40px;height:40px;">
                <div style="flex: 1; min-width: 0;">
                    <p style="font-weight: 700; color: #023047; margin-bottom: 0.08rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.86rem;">
                        {{ $tutor->first_name }} {{ $tutor->last_name }}
                    </p>
                    <p style="font-size: 0.7rem; color: #64748b;" data-translate="waiting_tutor_professional">Tutor profesional</p>
                </div>
            </div>
            @endif
            
            @if($subject)
            <div class="subject-tag" style="font-size:0.73rem;padding:0.25rem 0.6rem;margin-bottom:0.6rem;">
                {{ $subject->name }}
            </div>
            @endif
            
            <div class="status-badge" style="padding:0.3rem 0.7rem;font-size:0.74rem;margin-bottom:0.6rem;">
                <div class="spinner" style="width:12px;height:12px;"></div>
                <span data-translate="waiting_tutor_waiting_accept">Esperando a que acepte...</span>
            </div>
            
            <p style="color: #64748b; margin-bottom: 0.6rem; line-height: 1.4; font-size: 0.8rem;" data-translate="waiting_tutor_desc">
                {{ $tutor ? $tutor->first_name.' '.$tutor->last_name : 'El tutor' }} recibirá una notificación instantánea. Te avisaremos cuando acepte tu solicitud.
            </p>
            
            <div class="countdown-box" style="padding:0.5rem;margin-bottom:0.6rem;">
                <p style="font-size: 0.76rem; color: #64748b; margin-bottom: 0.28rem;" data-translate="waiting_tutor_expires_in">Expira en</p>
                <div class="countdown-time" id="countdown" style="font-size:1.25rem;">05:00</div>
            </div>
            
            <div class="action-buttons" id="normal-actions">
                <button type="button" onclick="cancelRequest()" class="btn-cancel" data-translate="waiting_tutor_cancel" style="position:relative;z-index:40;pointer-events:auto;padding:0.6rem;font-size:0.88rem;">Cancelar solicitud</button>
            </div>
            <div class="action-buttons" id="expired-actions" style="display:none;">
                <button onclick="window.location.href='{{ $tutor && isset($tutor->slug) ? route('tutor', ['slug' => $tutor->slug]) : route('buscar') }}'" style="width:100%;padding:0.7rem;background:linear-gradient(135deg,#FB8500 0%,#FF6B00 100%);color:white;border:none;border-radius:0.75rem;font-weight:700;cursor:pointer;" data-translate="waiting_tutor_try_again">Intentar de nuevo</button>
                <button type="button" onclick="handleFindAnotherTutor()" class="btn-cancel" style="padding:0.7rem;" data-translate="waiting_tutor_find_another">Buscar otro tutor</button>
            </div>
        </div>
    </div>
</section>

<!-- Cancel Modal -->
<div id="cancel-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.6);z-index:10000;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:white;border-radius:1.5rem;max-width:400px;width:100%;position:relative;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
        <div style="padding:2rem;text-align:center;">
            <div style="width:60px;height:60px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <h3 style="font-size:1.25rem;font-weight:800;color:#023047;margin-bottom:0.5rem;" data-translate="waiting_tutor_cancel_title">Cancelar solicitud</h3>
            <p style="color:#64748b;margin-bottom:1.5rem;" data-translate="waiting_tutor_cancel_confirm">¿Estás seguro de cancelar esta solicitud?</p>
            <div style="display:flex;gap:0.75rem;">
                <button onclick="closeCancelModal()" style="flex:1;padding:0.75rem;background:white;color:#64748b;border:2px solid #e2e8f0;border-radius:0.75rem;font-weight:600;cursor:pointer;" data-translate="cancel">Cancelar</button>
                <button onclick="confirmCancel()" style="flex:1;padding:0.75rem;background:#dc2626;color:white;border:none;border-radius:0.75rem;font-weight:700;cursor:pointer;" data-translate="confirm">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const batchId = {{ $batch->id }};
    let expiresAt = new Date('{{ $batch->expires_at }}').getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const diff = expiresAt - now;
        
        if (diff <= 0) {
            document.getElementById('countdown').textContent = '00:00';
            document.querySelector('.status-badge span').textContent = window.translateText ? window.translateText('waiting_tutor_expired', 'Solicitud expirada') : 'Solicitud expirada';
            document.querySelector('.status-badge').style.background = '#fee2e2';
            document.querySelector('.status-badge').style.color = '#991b1b';
            document.querySelector('.spinner').style.borderColor = '#fca5a5';
            document.querySelector('.spinner').style.borderTopColor = 'transparent';
            
            document.getElementById('normal-actions').style.display = 'none';
            document.getElementById('expired-actions').style.display = 'flex';
            return;
        }
        
        const minutes = Math.floor(diff / 60000);
        const seconds = Math.floor((diff % 60000) / 1000);
        document.getElementById('countdown').textContent = 
            String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
    }
    
    setInterval(updateCountdown, 1000);
    updateCountdown();
    
    setInterval(async () => {
        try {
            const res = await fetch(`/student/batches/${batchId}/accepted-tutors?limit=50`, {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const json = await res.json();
            if (json.data && json.data.length > 0) {
                window.location.href = '{{ route("tutorias-instantaneas") }}?batch=' + batchId;
            }
        } catch (e) {
            console.error(e);
        }
    }, 3000);
    
    function cancelRequest() {
        document.getElementById('cancel-modal').style.display = 'flex';
    }
    
    async function handleFindAnotherTutor() {
        try {
            const res = await fetch('/student/batches/active', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const json = await res.json().catch(() => ({}));
            if (json.active && json.batch_id) {
                const confirmMsg = window.translateText 
                    ? window.translateText('waiting_tutor_active_batch_confirm', 'Tienes una tutoría al instante en curso. ¿Quieres ir a verla o cancelar esta solicitud para buscar otro tutor?')
                    : 'Tienes una tutoría al instante en curso. ¿Quieres ir a verla o cancelar esta solicitud para buscar otro tutor?';
                if (confirm(confirmMsg)) {
                    window.location.href = '{{ route("tutorias-instantaneas") }}?batch=' + json.batch_id;
                    return;
                }
                // If user cancels confirm, let them go to search after cancelling current? Or just go to search
                // Better: show choice by going to search is not ideal, just redirect to search
                window.location.href = '{{ route("buscar") }}';
                return;
            }
        } catch (e) {
            console.error(e);
        }
        window.location.href = '{{ route("buscar") }}';
    }
    
    function closeCancelModal() {
        document.getElementById('cancel-modal').style.display = 'none';
    }
    
    async function confirmCancel() {
        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const res = await fetch(`/student/batches/${batchId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf
                },
                credentials: 'same-origin'
            });
            const json = await res.json();
            if (json.ok) {
                window.location.href = '{{ route("buscar") }}';
            }
        } catch (e) {
            alert('Error al cancelar');
        }
    }
    
    document.getElementById('cancel-modal')?.addEventListener('click', function(e) {
        if (e.target.id === 'cancel-modal') {
            closeCancelModal();
        }
    });

    // Prevenir volver atrás mientras hay solicitud activa
    try {
        history.pushState(null, '', location.href);
        window.addEventListener('popstate', function () {
            history.pushState(null, '', location.href);
        });
    } catch(e) {}
</script>
@endsection
