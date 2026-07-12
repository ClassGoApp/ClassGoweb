


<div class="cg-ma-container">
    <div class="cg-ma-header">
        <h1 class="cg-ma-title">{{ auth()->user()->hasRole("tutor")?"Mis Tutorías" : "Tutorías"  }}</h1>
        {!! auth()->user()->hasRole('student') ? '<p class="cg-ma-subtitle">Selecciona una tutoría para gestionar sus archivos adjuntos.</p>' : '' !!}

    </div>

        <div class="cg-ma-layout">
            
            <aside class="cg-ma-sidebar">
                <div class="cg-ma-sidebar-header">
                    {{-- Próximas Tutorías ({{ count($slotBookings) }}) --}}
                </div>
                
                <div class="cg-ma-booking-list">
                    @forelse($slotBookings as $booking)
                        <div 
                            wire:click="selectBooking({{ $booking->id }})" 
                            class="cg-ma-booking-item {{ $selectedBookingId == $booking->id ? 'is-active' : '' }}"
                        >   
                            <div style="position: relative;">
                                <div class="cg-ma-booking-top" >
                                    <span class="cg-ma-date">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M') }}</span>
                                    <p style="font-size:.8em; font-weight: 700; position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: #22ad2f; ">{{ $firstBooking == $booking->id ? "Tú próxima tutoría." : "" }}</p>
                                </div>  
                            </div>
                            <span class="cg-ma-subject">{{ $booking->subject->name ?? $booking->description ?? 'Sesión #' . $booking->id }}</span>
                            <h4 class="cg-ma-tutor">{{auth()->user()->hasRole("student") ? 'Tutor: ' . ($this->UserData($booking->tutor_id)->first_name ?? 'ID ' . $booking->tutor_id) : 'Estudiante: ' . ($this->UserData($booking->student_id)->first_name ?? 'ID ' . $booking->student_id)}}</h4>
                            <p class="cg-ma-info">
                                Horarios: {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }} 
                                • {{ $booking->supporting_material ? '1 archivo' : 'Sin material' }}
                            </p>
                        </div>
                    @empty
                        <div class="cg-ma-empty">No tienes tutorías futuras programadas.</div>
                    @endforelse
                </div>
            </aside>
            {{-- {{ dd($slotBookings) }} --}}
            <main class="cg-ma-workspace">
                @if($selectedBooking)
                    <div class="cg-ma-detail-header">
                        <span class="cg-ma-badge">{{ $selectedBooking->subject->name ?? 'Materia ID: ' . $selectedBooking->subject_id }}</span>
                        <p class="cg-ma-detail-meta">
                            Día: {{ \Carbon\Carbon::parse($selectedBooking->start_time)->translatedFormat('l, d \d\e F, Y') }} | 
                            Horario: {{ \Carbon\Carbon::parse($selectedBooking->start_time)->format('H:i') }} a {{ \Carbon\Carbon::parse($selectedBooking->end_time)->format('H:i') }} hrs
                        </p>
                        <p style=" color: #666; font-weight: 500; font-size: 0.9rem; margin-top: 10px; margin-bottom: 5px;">Estado: <span style=" margin-left: 4px; color: #0284c7; font-weight: 600">{{ $selectedBooking->status }}</span></p>
                    </div>

                    @if (auth()->user()->hasRole('student'))
                        <div class="cg-ma-upload-box">
                            <label class="cg-ma-dropzone">
                                <span class="cg-ma-dropzone-icon">☁️</span>
                                <span class="cg-ma-dropzone-text">
                                    {{ $selectedBooking->supporting_material ? 'Haz clic aquí para reemplazar el archivo actual' : 'Haz clic aquí para subir o arrastra tu archivo' }}
                                </span>
                                <span class="cg-ma-dropzone-hint">Soporta PDF, Word e Imágenes (Máx. 10 MB)</span>
                                <input type="file" wire:model="newMaterial" class="cg-ma-file-input" />
                            </label>
                            
                            <div wire:loading wire:target="newMaterial" class="cg-ma-loading">
                                Subiendo archivo, por favor espera...
                            </div>
                            
                            @error('newMaterial') <span style="color: red; font-size: 0.8rem; display: block; margin-top: 5px;">No se pudo cargar el archivo</span> @enderror
                        </div>
                    @endif
                    
                    <div class="cg-ma-files-section">
                        <h3 class="cg-ma-section-title">Archivo adjunto para esta clase</h3>
                        
                        <div class="cg-ma-files-grid">
                            @if($selectedBooking->supporting_material)
                                @php
                                    // Extraer el nombre real del archivo desde la ruta guardada
                                    $fileName = basename($selectedBooking->originName);
                                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                                @endphp
                                <div class="cg-ma-file-card">
                                    <div class="cg-ma-file-info">
                                        <span class="cg-ma-file-icon">
                                            {{ in_array($extension, ['pdf', 'doc', 'docx']) ? '📄' : '🖼️' }}
                                        </span>
                                        <div class="cg-ma-file-details">
                                            <p class="cg-ma-file-name" title="{{ $fileName }}">{{ $fileName }}</p>
                                            <p class="cg-ma-file-size">Guardado</p>
                                        </div>
                                    </div>
                                    <div class="cg-ma-file-actions">
                                        <button wire:click="downloadMaterial" class="cg-ma-btn-view">Descargar</button>
                                        @if (auth()->user()->hasRole('student'))
                                            <button wire:click="deleteMaterial" wire:confirm="¿Estás seguro de eliminar este material de apoyo?" class="cg-ma-btn-delete" title="Eliminar">🗑️</button>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p class="cg-ma-empty">Aún no han subido material para esta clase.</p>
                            @endif
                        </div>
                        <p class="cg-ma-detail-title" style="width: 30%">{!! $selectedBooking->description ? 'Contexto: ' . $selectedBooking->description : 'Sin descripción' !!} </p>
                           {{-- <span style="padding: 5px">   'Sin descripción' }} </span> --}}
                        </p>

                    </div>
                @else
                    <div class="cg-ma-no-selection">
                        <p>👈 Selecciona una tutoría de la lista para gestionar su material de apoyo.</p>
                    </div>
                @endif
            </main>
            {{-- <x-detalles-tutorias saludo="SALUDANDO" :datos="['rol'=>3, 'nombre'=> 'John Doe']" /> --}}
        </div>

        <style>
            /* ==========================================================================
   Contenedor Principal y Encabezado
   ========================================================================== */
.cg-ma-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    color: #333333;
    box-sizing: border-box;
}

.cg-ma-container *, .cg-ma-container *::before, .cg-ma-container *::after {
    box-sizing: inherit;
}

.cg-ma-header {
    margin-bottom: 24px;
}

.cg-ma-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 6px 0;
}

.cg-ma-subtitle {
    font-size: 0.9rem;
    color: #666666;
    margin: 0;
}

/* ==========================================================================
   Estructura Layout (Grid Responsivo)
   ========================================================================== */
.cg-ma-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
    align-items: start;
}

@media (min-width: 992px) {
    .cg-ma-layout {
        grid-template-columns: 360px 1fr;
    }
}

/* ==========================================================================
   Columna Izquierda: Barra Lateral (Scroll independiente)
   ========================================================================== */
.cg-ma-sidebar {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
}

.cg-ma-sidebar-header {
    padding: 14px 18px;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 600;
    font-size: 0.9rem;
    color: #374151;
}

.cg-ma-booking-list {
    max-height: 600px; /* Limite vertical para activar scroll en pantallas pequeñas */
    overflow-y: auto;
}

/* Estilización discreta del scrollbar */
.cg-ma-booking-list::-webkit-scrollbar,
.cg-ma-files-grid::-webkit-scrollbar {
    width: 6px;
}
.cg-ma-booking-list::-webkit-scrollbar-thumb,
.cg-ma-files-grid::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 4px;
}

.cg-ma-booking-item {
    padding: 16px 18px;
    border-bottom: 1px solid #f1f5f9;
    border-left: 4px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
}

.cg-ma-booking-item:hover {
    background-color: #f8fafc;
}

.cg-ma-booking-item.is-active {
    background-color: #f0f9ff;
    border-left-color: #0284c7;
}

.cg-ma-booking-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}

.cg-ma-subject {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
}

.cg-ma-booking-item.is-active .cg-ma-subject {
    color: #0284c7;
}

.cg-ma-date {
    font-size: 0.75rem;
    color: #94a3b8;
}

.cg-ma-tutor {
    margin: 0 0 4px 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: #1e293b;
}

.cg-ma-info {
    margin: 0;
    font-size: 0.8rem;
    color: #64748b;
}

/* ==========================================================================
   Columna Derecha: Área de Trabajo (Scroll independiente)
   ========================================================================== */
.cg-ma-workspace {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    min-height: 450px;
    display: flex;
    flex-direction: column;
}

.cg-ma-no-selection {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
    color: #64748b;
    font-size: 0.95rem;
    min-height: 300px;
}

.cg-ma-detail-header {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 16px;
    margin-bottom: 20px;
}

.cg-ma-badge {
    display: inline-block;
    padding: 4px 10px;
    background-color: #e0f2fe;
    color: #0369a1;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.cg-ma-detail-title {
    margin: 0 0 6px 0;
    font-size: 1.03rem;
    color: #0f172a;
    max-width: 100%;
}

.cg-ma-detail-meta {
    margin: 0;
    font-size: 0.85rem;
    color: #64748b;
}

/* ==========================================================================
   Zona de Carga (Drag & Drop)
   ========================================================================== */
.cg-ma-upload-box {
    margin-bottom: 24px;
}

.cg-ma-dropzone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 28px 20px;
    border: 2px dashed #cbd5e1;
    border-radius: 10px;
    background-color: #f8fafc;
    cursor: pointer;
    transition: border-color 0.2s ease, background-color 0.2s ease;
    text-align: center;
}

.cg-ma-dropzone:hover {
    border-color: #0284c7;
    background-color: #f0f9ff;
}

.cg-ma-dropzone-icon {
    font-size: 2rem;
    margin-bottom: 8px;
}

.cg-ma-dropzone-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
}

.cg-ma-dropzone-hint {
    font-size: 0.75rem;
    color: #94a3b8;
    margin-top: 4px;
}

.cg-ma-file-input {
    display: none;
}

.cg-ma-loading {
    margin-top: 10px;
    font-size: 0.85rem;
    color: #0284c7;
    font-weight: 500;
    text-align: center;
}

/* ==========================================================================
   Lista de Archivos
   ========================================================================== */
.cg-ma-files-section {
    flex-grow: 1;
}

.cg-ma-section-title {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 0.5px;
    margin: 0 0 12px 0;
}

.cg-ma-files-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
    max-height: 280px; /* Evita que el contenedor crezca infinitamente y activa scroll */
    overflow-y: auto;
    padding-right: 4px;
}

@media (min-width: 640px) {
    .cg-ma-files-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.cg-ma-file-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}

.cg-ma-file-info {
    display: flex;
    align-items: center;
    gap: 12px;
    overflow: hidden;
    margin-right: 10px;
}

.cg-ma-file-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.cg-ma-file-details {
    overflow: hidden;
}

.cg-ma-file-name {
    margin: 0 0 2px 0;
    font-size: 0.85rem;
    font-weight: 600;
    color: #334155;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cg-ma-file-size {
    margin: 0;
    font-size: 0.75rem;
    color: #94a3b8;
}

.cg-ma-file-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.cg-ma-btn-view {
    padding: 4px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.15s ease;
}

.cg-ma-btn-view:hover {
    background-color: #f1f5f9;
    color: #0f172a;
}

.cg-ma-btn-delete {
    padding: 4px 6px;
    font-size: 0.85rem;
    background: transparent;
    border: none;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.15s ease;
}

.cg-ma-btn-delete:hover {
    opacity: 1;
}

.cg-ma-empty {
    font-size: 0.85rem;
    color: #94a3b8;
    font-style: italic;
    padding: 12px 0;
}
</style>
</div>