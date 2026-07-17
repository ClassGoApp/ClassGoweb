<div>
    @if($isOpen)
    <div class="modal-ma-backdrop">
        <div class="modal-ma-container">
            
            <div class="modal-ma-header">
                <h2 class="modal-ma-title">{{ $idFile?  "Editar Material": "Adjuntar Archivo"}}</h2>
                <button type="button" wire:click="$set('isOpen', false)" class="modal-ma-close-btn" aria-label="Cerrar">
                    &times;
                </button>
            </div>

            <div class="modal-ma-body">
                
                <div class="modal-ma-info-box">
                    {!!$modalUpdArchivo ? '<strong> Nota:</strong> Es opcional adjuntar material de apoyo.
                    ' : '<strong>Nota:</strong> Es opcional adjuntar material de apoyo. Si no lo tienes ahora, puedes avanzar y adjuntarlo luego usando el botón <strong>"Archivos Adjuntos"</strong>.' !!}
                    
                </div>

                <div 
                    x-data="{ isDropping: false }"
                    x-on:dragover.prevent="isDropping = true"
                    x-on:dragleave.prevent="isDropping = false"
                    x-on:drop.prevent="isDropping = false; @this.upload('archivo', $event.dataTransfer.files[0])"
                    x-bind:class="isDropping ? 'modal-ma-dropzone is-ma-dropping' : 'modal-ma-dropzone'"
                    onclick="document.getElementById('file-upload-ma').click()"
                >
                    <input 
                        type="file" 
                        id="file-upload-ma" 
                        style="display: none;" 
                        wire:model="archivo" 
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                    >
                    
                    <svg class="modal-ma-dropzone-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    
                    <p class="modal-ma-dropzone-text">
                        Arrastra tu archivo aquí o <span class="modal-ma-dropzone-link">haz clic para buscar</span>
                    </p>
                    <p class="modal-ma-dropzone-subtext">
                        DOCX, EXCEL, PDF, JPG, PNG (Max. 5MB)
                    </p>
                </div>

                <div wire:loading wire:target="archivo" class="modal-ma-upload-loading">
                    Subiendo archivo...
                </div>

                @error('archivo') 
                    <p class="modal-ma-upload-error">{{ $message }}</p> 
                @enderror

                @if($archivo && !$errors->has('archivo'))
                <div class="modal-ma-file-success-box">
                    <span class="modal-ma-file-name">📎 {{ $archivo->getClientOriginalName() }}</span>
                    <button type="button" wire:click="$set('archivo', null)" class="modal-ma-file-remove-btn" title="Eliminar archivo">
                        &times;
                    </button>
                </div>
                @endif

                <div class="modal-ma-form-group">
                    <label for="descripcion-material" class="modal-ma-form-label">¿De qué trata este material? (Opcional)</label>
                    <textarea 
                        id="descripcion-material" 
                        wire:model="descripcion" 
                        class="modal-ma-textarea" 
                        placeholder="Ej: Le adjunto los ejercicios prácticos que me cuestan resolver o el temario de mi examen..."
                    ></textarea>
                    @error('descripcion')
                        <p class="modal-ma-upload-error" style="text-align: left;">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="modal-ma-footer">
                <button type="button" wire:click="$set('isOpen', false)" class="modal-ma-btn-secondary">
                    Cancelar
                </button>
                @if($modalUpdArchivo)
                    <button type="button" wire:click="confirmarReserva" class="modal-ma-btn-primary btn_save_fill">
                        Guardar
                    </button>
                
                @else
                    <button type="button" wire:click="confirmarReserva" class="modal-ma-btn-primary">
                        {{ $archivo ? 'Guardar y Reservar' : 'Reservar sin Material' }}
                    </button>
                @endif
            </div>

        </div>
    </div>
    @endif
   <style>
        /* --- Fondo Oscuro Traslúcido --- */
        .modal-ma-backdrop {
            position: fixed;
            /* Usar inset (top, left, right, bottom 0) evita problemas de scrollbars no deseados que causan 100vw/100vh en móviles */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(6px);
            padding: 16px; /* Actúa como margen de seguridad para que el modal nunca toque los bordes de la pantalla */
            box-sizing: border-box;
        }

        /* --- Contenedor Principal Ajustado --- */
        .modal-ma-container {
            background-color: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            /* El modal crecerá según su contenido, pero nunca superará el alto de la pantalla gracias al max-height */
            max-height: 100%; 
            display: flex !important;
            flex-direction: column !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
            overflow: hidden; /* Mantiene las esquinas redondeadas y oculta el contenido que se sale */
            animation: modalMaSlideUp 0.25s ease-out;
        }

        @keyframes modalMaSlideUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Cabecera Fija --- */
        .modal-ma-header {
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            box-sizing: border-box;
            flex-shrink: 0; /* Evita que la cabecera se aplaste si el cuerpo es muy grande */
        }

        .modal-ma-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 !important;
        }

        .modal-ma-close-btn {
            background: #f1f5f9;
            border: none;
            color: #64748b;
            font-size: 1.4rem;
            font-weight: bold;
            cursor: pointer;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s ease;
            padding: 0 !important;
            margin: 0 !important;
        }

        .modal-ma-close-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        /* --- CUERPO CON SCROLL INTELIGENTE --- */
        .modal-ma-body {
            flex-grow: 1; /* Toma todo el espacio sobrante disponible */
            overflow-y: auto; /* Si el contenido sobrepasa el espacio, crea el scroll aquí */
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-sizing: border-box;
        }

        .modal-ma-body::-webkit-scrollbar {
            width: 6px;
        }
        .modal-ma-body::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .modal-ma-body::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .modal-ma-body::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* --- Componentes del Formulario --- */
        .modal-ma-info-box {
            background-color: #eff6ff;
            color: #1e40af;
            font-size: 0.875rem;
            padding: 14px;
            border-radius: 12px;
            line-height: 1.5;
            border: 1px solid #bfdbfe;
            box-sizing: border-box;
        }

        .modal-ma-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 30px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .modal-ma-dropzone:hover {
            border-color: #94a3b8;
            background-color: #f1f5f9;
        }

        .modal-ma-dropzone.is-ma-dropping {
            border-color: #f97316;
            background-color: #fff7ed;
        }

        .modal-ma-dropzone-icon {
            width: 44px;
            height: 44px;
            color: #3b82f6;
            margin-bottom: 10px;
        }

        .modal-ma-dropzone-text {
            color: #334155;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0 0 4px 0;
        }

        .modal-ma-dropzone-link {
            color: #2563eb;
            text-decoration: underline;
        }

        .modal-ma-dropzone-subtext {
            color: #64748b;
            font-size: 0.75rem;
            margin: 0;
        }

        .modal-ma-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex-shrink: 0; /* Evita que el text-area se aplaste por otros elementos */
        }

        .modal-ma-form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .modal-ma-textarea {
            width: 100%;
            min-height: 80px;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-family: inherit;
            font-size: 0.9rem;
            color: #334155;
            resize: vertical; /* Permite redimensionar solo hacia abajo */
            box-sizing: border-box;
            transition: all 0.2s ease;
        }

        .modal-ma-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .modal-ma-upload-loading {
            color: #ea580c;
            font-weight: 600;
            font-size: 0.875rem;
            text-align: center;
        }

        .modal-ma-upload-error {
            color: #dc2626;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 4px 0 0 0;
        }

        .modal-ma-file-success-box {
            padding: 12px 16px;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
            flex-shrink: 0;
        }

        .modal-ma-file-name {
            font-size: 0.875rem;
            color: #166534;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .modal-ma-file-remove-btn {
            background: none;
            border: none;
            color: #166534;
            font-weight: bold;
            font-size: 1.3rem;
            cursor: pointer;
            line-height: 1;
        }

        /* --- Botones Inferiores Fijos --- */
        .modal-ma-footer {
            display: flex;
            gap: 12px;
            padding: 16px 24px 20px 24px;
            border-top: 1px solid #f1f5f9;
            background-color: #ffffff;
            box-sizing: border-box;
            flex-shrink: 0; /* Asegura que el footer SIEMPRE esté visible y no se hunda */
        }

        .modal-ma-btn-secondary,
        .modal-ma-btn-primary {
            flex: 1;
            padding: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s ease;
            border: none;
        }

        .modal-ma-btn-secondary {
            background-color: #e2e8f0;
            color: #475569;
        }

        .modal-ma-btn-secondary:hover {
            background-color: #cbd5e1;
        }

        .modal-ma-btn-primary {
            background-color: #f97316;
            color: #ffffff;
        }

        .modal-ma-btn-primary:hover {
            background-color: #ea580c;
        }

        /* --- Ajustes Responsivos --- */
        @media (max-width: 480px) {
            .modal-ma-header { padding: 16px; }
            .modal-ma-body { padding: 16px; gap: 12px; }
            .modal-ma-dropzone { padding: 20px 12px; }
            .modal-ma-footer {
                padding: 16px;
                flex-direction: column-reverse; /* El botón principal queda arriba en móviles para mejor alcance */
            }
        }

        .btn_save_fill{
            background-color: #1e40af;
            opacity: .5;
        }
        .btn_save_fill:hover{
            opacity: 1;
            background-color: #1e40af;

        }
    </style>
</div>