<div class="tutoring-panel">
    <!-- Card de Próxima Sesión -->
    @foreach ( $reservas as $reserva)
        @php
            $now = now();
            $startTime = \Carbon\Carbon::parse($reserva->start_time);
            $endTime = \Carbon\Carbon::parse($reserva->end_time);
            $isInProgress = $now->between($startTime, $endTime);
        @endphp
        <div class="upcoming-session-card">
            <div class="upcoming-session-header">
                <h3 class="upcoming-session-title">
                    <i class="fas fa-calendar-alt"></i>
                    ¿Listo para tu próxima tutoría?
                </h3>
                <span class="status-badge {{ $isInProgress ? 'status-in-progress' : '' }}">
                    {{ $isInProgress ? 'En curso' : 'Confirmada' }}
                </span>
            </div>
            
            <div class="upcoming-session-body">
                <div class="session-info">
                    <div class="session-icon {{ $isInProgress ? 'icon-active' : '' }}">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="session-details">
                        <h3>{{ $reserva->subject->name }}</h3>
                        <p>{{ \Carbon\Carbon::parse($reserva->start_time)->locale('es')->diffForHumans()}}, • 
                            <span class="session-time">
                            {{ \Carbon\Carbon::parse($reserva->start_time)->format('H:i') }}
                            </span>
                        </p>
                    </div>
                </div>

                <a href="{{ $reserva->meeting_link }}" target="_blank">
                    <button class="tutoria-btn tutoria-btn-primary {{ $isInProgress ? 'btn-pulse' : '' }}">
                        <i class="fas fa-video"></i>
                        Ir al Aula Virtual
                    </button>
                </a>
                
                <button class="tutoria-text-link">
                    Ver detalles 
                </button>
            </div>
        </div>
    @endforeach
</div>
<style>

    /* --- Estilos usados en este partial (limpios) --- */

    /* Contenedor principal */
    .tutoring-panel {
        max-width: 400px;
        margin: 0 auto;
    }

    /* Card de próxima sesión */
    .upcoming-session-card {
        background-color: white;
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        border-left: 4px solid var(--primary-color);
        overflow: hidden;
        animation: fadeInUp 0.5s ease-out;
        margin-bottom: 1rem;
    }

    .upcoming-session-header {
        padding: 0.8rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--light-border);
    }

    .upcoming-session-title {
        color: var(--primary-color);
        font-weight: bold;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-badge {
        background: var(--bg-gradient2);
        color: var(--white);
        font-size: 0.625rem;
        font-weight: bold;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
    }

    /* Estado "En curso" */
    .status-badge.status-in-progress {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Icono activo */
    .session-icon.icon-active {
        background-color: #d1fae5;
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Botón con pulso */
    .btn-pulse {
        animation: buttonPulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Animación de pulso */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }

    @keyframes buttonPulse {
        0%, 100% {
            box-shadow: 0 1px 2px 0 rgba(59, 130, 246, 0.2);
        }
        50% {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
        }
    }


    .upcoming-session-body {
        padding: 1rem 1.25rem;
    }

    .session-info {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .session-icon {
        background-color: #eff6ff;
        padding: 0.8rem 1rem;
        border-radius: 60%;
        color: var(--primary-color);
    }

    .session-details h3 {
        font-weight: bold;
        color: var(--primary-color);
    }

    .session-details p {
        justify-content: start;
        font-size: 0.875rem;
        color: var(--text-gris);
        margin-top: 0.25rem;
    }

    .session-time {
        font-weight: 500;
        color: var(--gray-700);
    }

    /* Botones usados en este partial */
    .tutoria-btn {
        width: 100%;
        padding: 1rem;
        border-radius: 10px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .tutoria-btn-primary {
        background: var(--bg-gradient2);
        color: white;
        box-shadow: 0 1px 2px 0 rgba(59, 130, 246, 0.2);
    }


    .btn:active {
        transform: scale(0.98);
    }

    .tutoria-text-link {
        width: 100%;
        margin-top: 0.5rem;
        color: var(--text-gris);
        font-size: 0.75rem;
        text-align: center;
        cursor: pointer;
        background: none;
        border: none;
    }

    .tutoria-text-link:hover {
        color: var(--primary-color);
        text-decoration: none;
    }

    /* Animación (necesaria para la card) */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(1rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (min-width: 1024px) {
        .tutoring-panel {
            max-width: 100%;
            grid-column: span 1 / span 1;
        }
    }

</style>