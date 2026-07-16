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
        @if($request->status === 'accepted')
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
        disableMobile: "true"
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

    function proceedToPayment() {
        // Redirigir al estudiante a la página de bookings con el token para iniciar el wizard en Step 3
        window.location.href = `/student/bookings?accept_counter=${token}`;
    }
</script>
@endsection
