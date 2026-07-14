<div class="cg-ma-container">
    <div class="cg-ma-header">
        <h1 class="cg-ma-title">{{ auth()->user()->hasRole("tutor") ? "Mis Tutorías" : "Tutorías"  }}</h1>
        {!! auth()->user()->hasRole('student') ? '<p class="cg-ma-subtitle">Selecciona una tutoría para gestionar sus archivos adjuntos.</p>' : '' !!}
    </div>

    <div class="cg-ma-layout">
        
        <aside class="cg-ma-sidebar">
            <div class="cg-ma-sidebar-header">
            </div>
            
            <div class="cg-ma-booking-list">
                @forelse($slotBookings as $booking)
                    <div 
                        wire:click="selectBooking({{ $booking->id }})" 
                        class="cg-ma-booking-item {{ $selectedBookingId == $booking->id ? 'is-active' : '' }}"
                    >   
                        <div style="position: relative; margin-bottom: 4px; display: flex; align-items: center; min-height: 20px;">
                            <span class="cg-ma-date">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}</span>
                            
                            {{-- PUNTO VERDE Y TEXTO DINÁMICO --}}
                            @if($firstBooking == $booking->id)
                                <div class="cg-ma-next-badge">
                                    <span class="cg-ma-dot"></span>
                                    <p>Tú próxima tutoría.</p>
                                </div>
                            @endif
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

        <main class="cg-ma-workspace">
            @if($selectedBooking)
                <div class="cg-ma-workspace-content">
                    <div class="cg-ma-detail-header">
                        <span class="cg-ma-badge">{{ $selectedBooking->subject->name ?? 'Materia ID: ' . $selectedBooking->subject_id }}</span>
                        <p class="cg-ma-detail-meta">
                            Día: {{ \Carbon\Carbon::parse($selectedBooking->start_time)->translatedFormat('l, d \d\e F, Y') }} | 
                            Horario: {{ \Carbon\Carbon::parse($selectedBooking->start_time)->format('H:i') }} a {{ \Carbon\Carbon::parse($selectedBooking->end_time)->format('H:i') }} hrs
                        </p>
                        <p style="color: #666; font-weight: 500; font-size: 0.9rem; margin-top: 10px; margin-bottom: 5px;">
                            Estado: <span style="margin-left: 4px; color: #0284c7; font-weight: 600">{{ $selectedBooking->status }}</span>
                        </p>
                    </div>

                    @if (auth()->user()->hasRole('student'))
                        <div class="cg-ma-upload-box">
                            <label class="cg-ma-dropzone">
                                <span class="cg-ma-dropzone-icon">☁️</span>
                                <span class="cg-ma-dropzone-text">
                                        {{ $selectedBooking->supporting_material ? 'Haz clic aquí para reemplazar el archivo actual' : 'Haz clic aquí para subir el archivo' }}
                                </span>
                                {{-- {{ dd($selectedBooking) }} --}}
                                <span class="cg-ma-dropzone-hint">Soporta PDF, Excel, Word e Imágenes (Máx. 5 MB)</span>
                                
                                    {{-- Si NO hay archivo: input tipo botón que dispara el evento para abrir el modal --}}
                                <input type="button" 
                                    wire:click="$dispatch('openModalMaterialApoyo', { modalUpdat:true } )" 
                                    class="cg-ma-file-input" />
                            </label>                            
                                
                            <div wire:loading wire:target="newMaterial" class="cg-ma-loading">
                                Subiendo archivo, por favor espera...
                            </div>
                                
                            @error('newMaterial') <span style="color: red; font-size: 0.8rem; display: block; margin-top: 5px;">No se pudo cargar el archivo</span> @enderror
                        </div>
                        <livewire:modal-material-apoyo/>
                    @endif
                    
                    <div class="cg-ma-files-section">
                        <h3 class="cg-ma-section-title">Archivo adjunto para esta clase</h3>
                        
                        <div class="cg-ma-files-grid">
                            @if($selectedBooking->supporting_material)
                                @php
                                    $fileName = basename($selectedBooking->originName ?? $selectedBooking->supporting_material);
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
                                <p class="cg-ma-empty">Sin Material Adjuntado.</p>
                            @endif
                        </div>
                        
                        {{-- CAJA DE CONTEXTO AJUSTADA PARA TEXTOS LARGOS --}}
                        <div class="cg-ma-description-box">
                            {!! $selectedBooking->description ? '<strong style="display:block; margin-bottom: 8px; color: #334155;">Contexto:</strong>' . $selectedBooking->description : '<em>Sin descripción</em>' !!}
                        </div>

                    </div>
                </div>
            @else
                <div class="cg-ma-no-selection">
                    <p>👈 Selecciona una tutoría de la lista para gestionar su material de apoyo.</p>
                </div>
            @endif
        </main>
    </div>

<style>
/* ==========================================================================
   Contenedor Principal y Adaptabilidad (Viewport Fit)
   ========================================================================== */
.cg-ma-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #333333;
    box-sizing: border-box;
    height: calc(100vh - 100px); 
    min-height: 500px; 
    display: flex;
    flex-direction: column;
}

.cg-ma-container *, .cg-ma-container *::before, .cg-ma-container *::after {
    box-sizing: inherit;
}

.cg-ma-header {
    flex-shrink: 0;
    margin-bottom: 20px;
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
   Estructura Layout (Responsivo)
   ========================================================================== */
.cg-ma-layout {
    display: flex;
    flex-direction: column;
    gap: 20px;
    flex-grow: 1;
    overflow: hidden; 
    min-height: 0; 
}

@media (min-width: 992px) {
    .cg-ma-layout {
        display: grid;
        grid-template-columns: 360px 1fr;
        height: 100%;
    }
}

/* ==========================================================================
   Columna Izquierda: Barra Lateral
   ========================================================================== */
.cg-ma-sidebar {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    overflow: hidden; 
    max-height: 40vh; 
}

@media (min-width: 992px) {
    .cg-ma-sidebar {
        max-height: 100%; 
    }
}

.cg-ma-sidebar-header {
    padding: 14px 18px;
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.cg-ma-booking-list {
    flex-grow: 1;
    overflow-y: auto; 
    height: 100%;
}

/* ==========================================================================
   Elemento de Tutoría y Punto Verde
   ========================================================================== */
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

.cg-ma-date {
    font-size: 0.75rem;
    color: #94a3b8;
}

.cg-ma-next-badge {
    position: absolute;
    right: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

.cg-ma-next-badge p {
    font-size: 0.75rem;
    font-weight: 700;
    color: #22ad2f;
    margin: 0;
}

.cg-ma-dot {
    width: 8px;
    height: 8px;
    background-color: #22ad2f;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 2px rgba(34, 173, 47, 0.2);
}

.cg-ma-subject {
    display: block;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
}

.cg-ma-booking-item.is-active .cg-ma-subject {
    color: #0284c7;
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
   Columna Derecha: Área de Trabajo
   ========================================================================== */
.cg-ma-workspace {
    background: #ffffff;
    border: 1px solid #8aaef7;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    flex-grow: 1;
    overflow-y: auto; 
    height: auto;
    min-height: 0; 
}

@media (min-width: 992px) {
    .cg-ma-workspace {
        height: 100%;
    }
}

.cg-ma-workspace-content {
    padding: 24px;
    display: flex;
    flex-direction: column;
}

.cg-ma-no-selection {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #64748b;
    font-size: 0.95rem;
    padding: 40px 20px;
}

/* Detalles del área de trabajo */
.cg-ma-detail-header {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 16px;
    margin-bottom: 20px;
    flex-shrink: 0;
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

/* Componente Dropzone */
.cg-ma-upload-box {
    margin-bottom: 24px;
    flex-shrink: 0;
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
    transition: all 0.2s ease;
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

.cg-ma-file-input { display: none; }

/* Grilla de Archivos */
.cg-ma-files-section {
    flex-shrink: 0;
}

.cg-ma-section-title {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #94a3b8;
    margin: 0 0 12px 0;
}

.cg-ma-files-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
}

@media (min-width: 768px) {
    .cg-ma-files-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    flex-wrap: wrap; 
    gap: 10px;
}

.cg-ma-file-info {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0; 
    flex: 1;
}

.cg-ma-file-icon { font-size: 1.5rem; flex-shrink: 0; }

.cg-ma-file-details {
    min-width: 0;
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
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #475569;
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    cursor: pointer;
}

.cg-ma-btn-delete {
    padding: 6px;
    font-size: 0.95rem;
    background: transparent;
    border: none;
    cursor: pointer;
    opacity: 0.7;
}

.cg-ma-btn-delete:hover { opacity: 1; }


/* ==========================================================================
   CAJA DE CONTEXTO / DESCRIPCIÓN (Romper palabras y scroll)
   ========================================================================== */
.cg-ma-description-box {
    margin-top: 24px;
    padding: 16px;
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #475569;
    line-height: 1.6;
    
    /* 1. Obligar a romper palabras gigantes (pepedpeeeee...) */
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-word;
    
    /* 2. Respetar los saltos de línea (párrafos) que escriba el usuario */
    white-space: pre-wrap; 
    
    /* 3. Evitar que crezca infinitamente (Scroll interno) */
    max-height: 200px;
    overflow-y: auto;
    
    width: 100%;
    box-sizing: border-box;
}


/* Scrollbars Personalizados para todos los contenedores */
.cg-ma-booking-list::-webkit-scrollbar,
.cg-ma-workspace::-webkit-scrollbar,
.cg-ma-description-box::-webkit-scrollbar {
    width: 6px;
}
.cg-ma-booking-list::-webkit-scrollbar-track,
.cg-ma-workspace::-webkit-scrollbar-track,
.cg-ma-description-box::-webkit-scrollbar-track {
    background: transparent;
}
.cg-ma-booking-list::-webkit-scrollbar-thumb,
.cg-ma-workspace::-webkit-scrollbar-thumb,
.cg-ma-description-box::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 10px;
}
</style>
</div>