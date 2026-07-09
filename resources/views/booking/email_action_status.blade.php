@extends('layouts.app')

@push('styles')
<style>
    .status-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 200px);
        padding: 4rem 1rem;
        background-color: #f8fafc;
    }
    .status-card {
        background: #ffffff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        max-width: 500px;
        width: 100%;
        padding: 3rem 2.5rem;
        text-align: center;
    }
    .status-icon-box {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
    }
    .icon-success {
        background-color: #d1fae5;
        color: #10b981;
    }
    .icon-error {
        background-color: #fee2e2;
        color: #ef4444;
    }
    .status-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    .status-message {
        font-size: 1rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    .booking-details-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        text-align: left;
        margin-bottom: 2rem;
    }
    .booking-details-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }
    .booking-details-item:last-child {
        margin-bottom: 0;
    }
    .details-label {
        font-weight: 600;
        color: #64748b;
    }
    .details-val {
        color: #1e293b;
        font-weight: 600;
    }
    .status-btn {
        display: inline-block;
        width: 100%;
        background-color: #0284c7;
        color: #ffffff;
        font-weight: 600;
        padding: 0.85rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        transition: background-color 0.2s;
        border: none;
        cursor: pointer;
    }
    .status-btn:hover {
        background-color: #0369a1;
        color: #ffffff;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="status-container">
    <div class="status-card">
        @if($type === 'success' || $type === 'accept')
            <div class="status-icon-box icon-success">
                <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="status-title">¡Solicitud Aceptada!</h2>
            <p class="status-message">
                Has aceptado la tutoría con éxito. Se ha enviado una notificación al estudiante solicitando que suba su comprobante de pago.
            </p>
        @else
            <div class="status-icon-box icon-error">
                <svg style="width: 48px; height: 48px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="status-title">Solicitud Rechazada</h2>
            <p class="status-message">
                Has rechazado la solicitud de tutoría. El estudiante ha sido notificado y el horario seleccionado vuelve a estar libre.
            </p>
        @endif

        <div class="booking-details-box">
            <div class="booking-details-item">
                <span class="details-label">Estudiante:</span>
                <span class="details-val">{{ $booking->booker->profile->full_name ?? 'Estudiante' }}</span>
            </div>
            <div class="booking-details-item">
                <span class="details-label">Materia:</span>
                <span class="details-val">{{ $booking->subject->name ?? 'Materia no definida' }}</span>
            </div>
            <div class="booking-details-item">
                <span class="details-label">Fecha:</span>
                <span class="details-val">{{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}</span>
            </div>
            <div class="booking-details-item">
                <span class="details-label">Horario:</span>
                <span class="details-val">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
            </div>
        </div>

        <a href="{{ route('bookings') }}" class="status-btn">Ir a Mis Tutorías</a>
    </div>
</div>
@endsection
