<div class="cg-ma-container">
    <div class="cg-ma-header">
        <h1 class="cg-ma-title">Materiales de Apoyo</h1>
        <p class="cg-ma-subtitle">Selecciona una tutoría para gestionar sus archivos adjuntos.</p>
    </div>

    <div class="cg-ma-layout">
        
        <aside class="cg-ma-sidebar">
            <div class="cg-ma-sidebar-header">
                Próximas Tutorías ({{ count($slotBookings) }})
            </div>
            
            <div class="cg-ma-booking-list">
                @forelse($slotBookings as $booking)
                    <div 
                        wire:click="selectBooking({{ $booking->id }})" 
                        class="cg-ma-booking-item {{ $selectedBookingId == $booking->id ? 'is-active' : '' }}"
                    >
                        <div class="cg-ma-booking-top">
                            <span class="cg-ma-subject">{{ $booking->subject ?? 'Materia General' }}</span>
                            <span class="cg-ma-date">{{ \Carbon\Carbon::parse($booking->date)->format('d M') }}</span>
                        </div>
                        <h4 class="cg-ma-tutor">Prof. {{ $booking->tutor_name ?? 'Asignado' }}</h4>
                        <p class="cg-ma-info">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} hrs • {{ $booking->materials_count ?? 0 }} archivos</p>
                    </div>
                @empty
                    <div class="cg-ma-empty">No tienes tutorías futuras programadas.</div>
                @endforelse
            </div>
        </aside>

        <main class="cg-ma-workspace">
            @if($selectedBooking)
                <div class="cg-ma-detail-header">
                    <span class="cg-ma-badge">{{ $selectedBooking->subject ?? 'Materia' }}</span>
                    <h2 class="cg-ma-detail-title">Tutoría con Prof. {{ $selectedBooking->tutor_name }}</h2>
                    <p class="cg-ma-detail-meta">
                        📅 {{ \Carbon\Carbon::parse($selectedBooking->date)->translatedFormat('l, d \d\e F, Y') }} | 
                        ⏰ {{ \Carbon\Carbon::parse($selectedBooking->start_time)->format('H:i') }} hrs
                    </p>
                </div>

                <div class="cg-ma-upload-box">
                    <label class="cg-ma-dropzone">
                        <span class="cg-ma-dropzone-icon">☁️</span>
                        <span class="cg-ma-dropzone-text">Haz clic aquí para subir o arrastra tu archivo</span>
                        <span class="cg-ma-dropzone-hint">Soporta PDF, Word e Imágenes (Máx. 10 MB)</span>
                        <input type="file" wire:model="newMaterial" class="cg-ma-file-input" />
                    </label>
                    
                    <div wire:loading wire:target="newMaterial" class="cg-ma-loading">
                        Subiendo archivo, por favor espera...
                    </div>
                </div>

                <div class="cg-ma-files-section">
                    <h3 class="cg-ma-section-title">Archivos actuales</h3>
                    
                    <div class="cg-ma-files-grid">
                        @forelse($selectedBooking->materials as $file)
                            <div class="cg-ma-file-card">
                                <div class="cg-ma-file-info">
                                    <span class="cg-ma-file-icon">
                                        {{ str_contains($file->type, 'pdf') ? '📄' : '🖼️' }}
                                    </span>
                                    <div class="cg-ma-file-details">
                                        <p class="cg-ma-file-name" title="{{ $file->name }}">{{ $file->name }}</p>
                                        <p class="cg-ma-file-size">{{ round($file->size / 1024 / 1024, 2) }} MB</p>
                                    </div>
                                </div>
                                <div class="cg-ma-file-actions">
                                    <button wire:click="downloadMaterial({{ $file->id }})" class="cg-ma-btn-view">Ver</button>
                                    <button wire:click="deleteMaterial({{ $file->id }})" wire:confirm="¿Estás seguro de eliminar este material?" class="cg-ma-btn-delete" title="Eliminar">🗑️</button>
                                </div>
                            </div>
                        @empty
                            <p class="cg-ma-empty">Aún no has subido material para esta clase.</p>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="cg-ma-no-selection">
                    <p>👈 Selecciona una tutoría de la lista para gestionar su material de apoyo.</p>
                </div>
            @endif
        </main>

    </div>

    
</div>

@once
    @push('styles')
        <style>
            @include('livewire.student.material-apoyo.css')
        </style>
    @endpush
@endonce