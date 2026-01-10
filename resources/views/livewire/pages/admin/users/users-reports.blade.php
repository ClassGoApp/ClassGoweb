<div> 
    <style>
        /* ========================================= */
        /* CONFIGURACIÓN BASE Y LAYOUT               */
        /* ========================================= */
        .reports-container * { box-sizing: border-box; }

        .reports-container {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #1e293b;
            min-height: 100vh;
            padding: 1.5rem;
        }

        @media (min-width: 768px) {
            .reports-container { padding: 2.5rem; }
        }

        .reports-wrapper {
            max-width: 1280px;
            margin: 0 auto;
        }

        .space-y-8 > * + * { margin-top: 2rem; }

        /* ========================================= */
        /* HEADER SECTION                            */
        /* ========================================= */
        .reports-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (min-width: 768px) {
            .reports-header { flex-direction: row; align-items: center; }
        }

        @media (max-width: 767px) {
            .reports-header { flex-direction: column; }
        }

        .header-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 0.25rem 0;
        }

        .header-title p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0.25rem 0 0 0;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        /* Botones */
        .reports-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid;
            transition: all 0.2s;
        }

        .reports-btn-primary {
            background: #4f46e5;
            border-color: #4f46e5;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }

        .reports-btn-primary:hover {
            background: #4338ca;
            box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.3);
        }

        /* Dropdown */
        .reports-dropdown { position: relative; }

        .dropdown-menu {
            /* Estilos base, la visibilidad se controla inline/JS */
            position: absolute;
            right: 0;
            top: calc(100% + 0.5rem);
            width: 12rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #f3f4f6;
            overflow: hidden;
            z-index: 50;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            width: 100%;
            border: none;
            background: white;
            cursor: pointer;
            transition: background 0.15s;
            text-align: left;
        }

        .dropdown-item:not(:last-child) { border-bottom: 1px solid #f3f4f6; }
        .dropdown-item:hover { background: #f3f4f6; }

        .dropdown-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            /* El color de fondo y texto vienen definidos inline en tu HTML o por SVG */
            background: #f9fafb; 
        }

        .rotate-180 { transform: rotate(180deg); }
        .transition-transform { transition: transform 0.2s; }

        /* ========================================= */
        /* STATS GRID (TARJETAS)                     */
        /* ========================================= */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

        .stat-card {
            position: relative;
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            border: 2px solid #f3f4f6;
            cursor: pointer;
            transition: all 0.3s;
            overflow: hidden;
        }

        .stat-card:hover {
            background: #f9fafb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stat-card.active-card {
            transform: scale(1.02);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Variaciones de colores de las tarjetas */
        .stat-card.verified-card { border-color: transparent; }
        .stat-card.verified-card:hover { border-color: #f3f4f6; }
        .stat-card.verified-card.active-card { border-color: #10b981; background: rgba(236, 253, 245, 0.4); }

        .stat-card.incomplete-card { border-color: transparent; }
        .stat-card.incomplete-card:hover { border-color: #f3f4f6; }
        .stat-card.incomplete-card.active-card { border-color: #f59e0b; background: rgba(255, 251, 235, 0.4); }

        .stat-card.area-card { border-color: transparent; }
        .stat-card.area-card:hover { border-color: #f3f4f6; }
        .stat-card.area-card.active-card { border-color: #3b82f6; background: rgba(239, 246, 255, 0.4); }

        .stat-card.empty-card { border-color: transparent; }
        .stat-card.empty-card:hover { border-color: #f3f4f6; }
        .stat-card.empty-card.active-card { border-color: #f43f5e; background: rgba(255, 241, 242, 0.4); }

        /* Línea inferior de la tarjeta activa */
        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 0.375rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card.verified-card::after { background: #10b981; }
        .stat-card.incomplete-card::after { background: #f59e0b; }
        .stat-card.area-card::after { background: #3b82f6; }
        .stat-card.empty-card::after { background: #f43f5e; }
        .stat-card.active-card::after { opacity: 1; }

        /* Contenido de la tarjeta */
        .stat-header { display: flex; justify-content: space-between; align-items: flex-start; }
        
        .stat-info small {
            font-size: 0.688rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 0.25rem;
        }

        .stat-info h3 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #374151;
            margin: 0;
        }

        .stat-info p {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 500;
            color: #9ca3af;
        }

        /* Colores del texto en tarjeta activa */
        .stat-card.verified-card.active-card .stat-info p { color: #047857; }
        .stat-card.incomplete-card.active-card .stat-info p { color: #b45309; }
        .stat-card.area-card.active-card .stat-info p { color: #1d4ed8; }
        .stat-card.empty-card.active-card .stat-info p { color: #be123c; }

        /* Iconos de las tarjetas */
        .stat-icon {
            padding: 0.75rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }

        /* Iconos inactivos */
        .stat-card:not(.active-card) .stat-icon.verified-icon { background: #d1fae5; color: #059669; }
        .stat-card:not(.active-card) .stat-icon.incomplete-icon { background: #fef3c7; color: #d97706; }
        .stat-card:not(.active-card) .stat-icon.area-icon { background: #dbeafe; color: #2563eb; }
        .stat-card:not(.active-card) .stat-icon.empty-icon { background: #ffe4e6; color: #e11d48; }

        /* Iconos activos */
        .stat-card.active-card .stat-icon.verified-icon { background: #10b981; color: white; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.4); }
        .stat-card.active-card .stat-icon.incomplete-icon { background: #f59e0b; color: white; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.4); }
        .stat-card.active-card .stat-icon.area-icon { background: #3b82f6; color: white; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4); }
        .stat-card.active-card .stat-icon.empty-icon { background: #f43f5e; color: white; box-shadow: 0 4px 6px -1px rgba(244, 63, 94, 0.4); }

        /* ========================================= */
        /* TABLE SECTION                             */
        /* ========================================= */
        .table-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        .table-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
            background: rgba(249, 250, 251, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) { .table-header { flex-direction: column; align-items: flex-start; } }

        .table-title-wrapper { display: flex; align-items: center; gap: 0.75rem; }

        /* Iconos pequeños en el título de la tabla */
        .table-icon { padding: 0.625rem; border-radius: 0.75rem; }
        .table-icon.verified-icon { background: #d1fae5; color: #047857; }
        .table-icon.incomplete-icon { background: #fef3c7; color: #b45309; }
        .table-icon.area-icon { background: #dbeafe; color: #1d4ed8; }
        .table-icon.empty-icon { background: #ffe4e6; color: #be123c; }
        .table-icon.default-icon { background: #f3f4f6; color: #4b5563; }

        .table-title-wrapper h2 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #374151;
            margin: 0;
        }

        .count-badge {
            padding: 0.125rem 0.625rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6b7280;
        }

        /* Grid de la tabla */
        .table-overflow { width: 100%; overflow: hidden; }

        .table-grid-header, .table-row {
            display: grid;
            grid-template-columns: 28% 42% 18% 12%;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
        }

        .table-grid-header {
            background: #f9fafb;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-grid-header div {
            font-size: 0.625rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .table-grid-header div:last-child { text-align: center; }

        .table-row {
            border-bottom: 1px solid #f9fafb;
            align-items: center;
            transition: background 0.15s;
        }
        .table-row:hover { background: rgba(249, 250, 251, 0.8); }

        /* Celdas de Usuario */
        .user-cell { display: flex; align-items: center; gap: 0.75rem; min-width: 0; }
        
        .user-avatar {
            width: 2.25rem; height: 2.25rem;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.875rem;
            flex-shrink: 0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .user-avatar.verified-avatar { background: #d1fae5; color: #047857; }
        .user-avatar.incomplete-avatar { background: #fef3c7; color: #b45309; }
        .user-avatar.area-avatar { background: #dbeafe; color: #1d4ed8; }
        .user-avatar.empty-avatar { background: #ffe4e6; color: #be123c; }

        .user-info-cell { min-width: 0; flex: 1; }
        .user-name {
            font-weight: 600; color: #111827; font-size: 0.875rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0;
        }
        .user-email {
            font-size: 0.75rem; color: #6b7280;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0;
        }

        /* Celdas de Detalle */
        .detail-cell { min-width: 0; }
        .tags-wrapper { display: flex; flex-wrap: wrap; gap: 0.5rem; }

        .subject-tag {
            display: inline-flex; align-items: center;
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem; font-weight: 500;
            background: #eff6ff; color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .missing-tag {
            padding: 0.125rem 0.5rem;
            background: #fef2f2; color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 0.25rem;
            font-size: 0.625rem; font-weight: 700;
            text-transform: uppercase;
        }

        .empty-subjects { font-size: 0.75rem; color: #9ca3af; font-style: italic; }

        .date-info-wrapper { display: flex; flex-direction: column; }
        .date-info-wrapper strong { display: block; color: #374151; font-weight: 500; font-size: 0.875rem; }
        .date-info-wrapper small { font-size: 0.625rem; color: #9ca3af; }
        .time-ago { color: #6b7280; font-weight: 500; font-size: 0.875rem; }

        /* Badges de Estado */
        .status-badge {
            display: inline-flex; align-items: center; gap: 0.375rem;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem; font-weight: 700;
            border: 1px solid;
        }
        .status-badge.complete-badge { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
        .status-badge.incomplete-badge { background: #fffbeb; color: #b45309; border-color: #fef3c7; }
        .status-badge.pending-badge { background: #f3f4f6; color: #4b5563; border-color: #e5e7eb; }

        .status-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: currentColor; }

        /* Acciones y Estados Vacíos */
        .action-cell { display: flex; justify-content: center; }
        .action-btn {
            width: 2rem; height: 2rem;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 50%; border: none; background: transparent;
            color: #9ca3af; cursor: pointer; transition: all 0.15s;
            text-decoration: none;
        }
        .action-btn:hover { color: #4f46e5; background: #eef2ff; }

        .empty-state { padding: 3rem 1.5rem; text-align: center; }
        .empty-icon-wrapper {
            width: 4rem; height: 4rem;
            background: #f9fafb; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 0.75rem; color: #d1d5db;
        }
        .empty-state p { color: #6b7280; font-weight: 500; margin: 0; }

        /* Footer y Paginación */
        .table-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f3f4f6;
            background: rgba(249, 250, 251, 0.3);
        }

        /* Estilos para el paginador de Laravel (custom) */
        .table-footer nav { display: flex; justify-content: space-between; align-items: center; width: 100%; }
        
        @media (min-width: 640px) {
            .table-footer nav > div:first-child { display: none !important; }
            .table-footer nav > div:last-child {
                display: flex !important; justify-content: space-between; align-items: center; width: 100%;
            }
        }

        .table-footer p { margin: 0; font-size: 0.875rem; color: #6b7280; }
        .table-footer nav > div:last-child > div:last-child {
            display: inline-flex; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        /* General */
        svg { width: 100%; height: 100%; }
        

    </style>

    <div class="reports-container">
        <div class="reports-wrapper space-y-8">
            
            {{-- HEADER --}}
            <div class="reports-header">
                <div class="header-title">
                    <h1>Reportes</h1>
                    <p>Visualiza el estado de la verificación y métricas por área.</p>
                </div>
                <div class="header-actions">                    
                    {{-- Botón Exportar con Dropdown --}}
                    <div class="reports-dropdown" style="position: relative; display: inline-block;">
    
                        <button onclick="toggleExportMenu(event)" type="button" class="reports-btn reports-btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            
                            <span>Exportar</span>
                            
                            <svg id="exportArrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform ml-1"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        
                        <div id="exportMenu" class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; z-index: 1000; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 160px; margin-top: 8px;">
                            
                            <button wire:click="exportExcel" onclick="event.stopPropagation();" class="dropdown-item" style="display: flex; align-items: center; width: 100%; padding: 12px; border: none; background: transparent; cursor: pointer; text-align: left; border-bottom: 1px solid #eee;">
                                <div class="dropdown-icon" style="margin-right: 10px; color: #107c41;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="16" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>
                                </div>
                                <div>
                                    <strong style="display:block; color:#333;">Excel</strong>
                                    <span wire:loading.remove wire:target="exportExcel" style="font-size: 11px; color: #666;">Descargar .xlsx</span>
                                    <span wire:loading wire:target="exportExcel" style="font-size: 11px; color: #107c41;">Generando...</span>
                                </div>
                            </button>
                            
                            <button wire:click="exportPDF" onclick="event.stopPropagation();" class="dropdown-item" style="display: flex; align-items: center; width: 100%; padding: 12px; border: none; background: transparent; cursor: pointer; text-align: left;">
                                <div class="dropdown-icon" style="margin-right: 10px; color: #b40404;">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                </div>
                                <div>
                                    <strong style="display:block; color:#333;">PDF</strong>
                                    <span wire:loading.remove wire:target="exportPDF" style="font-size: 11px; color: #666;">Descargar .pdf</span>
                                    <span wire:loading wire:target="exportPDF" style="font-size: 11px; color: #b40404;">Generando...</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRID DE TARJETAS (STATS) --}}
            <div class="stats-grid">
                
                {{-- CARD 1: VERIFICADOS --}}
                <div wire:click="setReport('verified_complete')" 
                     class="stat-card verified-card {{ $reportType === 'verified_complete' ? 'active-card' : '' }}">
                    <div class="stat-header">
                        <div class="stat-info">
                            <small>Completos</small>
                            <h3>{{ $countVerifiedComplete }}</h3>
                            <p>Documentación al 100%</p>
                        </div>
                        <div class="stat-icon verified-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: INCOMPLETOS --}}
                <div wire:click="setReport('incomplete')" 
                     class="stat-card incomplete-card {{ $reportType === 'incomplete' ? 'active-card' : '' }}">
                    <div class="stat-header">
                        <div class="stat-info">
                            <small>Falta Info</small>
                            <h3>{{ $countIncomplete }}</h3>
                            <p>Requieren atención</p>
                        </div>
                        <div class="stat-icon incomplete-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: POR AREA --}}
                <div wire:click="setReport('verified_by_area')" 
                     class="stat-card area-card {{ $reportType === 'verified_by_area' ? 'active-card' : '' }}">
                    <div class="stat-header">
                        <div class="stat-info">
                            <small>Por Área</small>
                            <h3>{{ $countVerifiedByArea }}</h3>
                            <p>Tutores Activos</p>
                        </div>
                        <div class="stat-icon area-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: VACÍOS --}}
                <div wire:click="setReport('unverified_empty')" 
                     class="stat-card empty-card {{ $reportType === 'unverified_empty' ? 'active-card' : '' }}">
                    <div class="stat-header">
                        <div class="stat-info">
                            <small>Sin Verificar</small>
                            <h3>{{ $countUnverifiedEmpty }}</h3>
                            <p>Perfil incompleto</p>
                        </div>
                        <div class="stat-icon empty-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN DE DETALLE (TABLA CON GRID) --}}
            <div class="table-container">
                
                {{-- Header de la Tabla --}}
                <div class="table-header">
                    <div class="table-title-wrapper">
                        {{-- Configuración Dinámica del Header --}}
                        @php
                            $conf = match($reportType) {
                                'verified_complete' => ['icon_class'=>'verified-icon','title'=>'Verificados Completos', 'icon'=>'<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>'],
                                'incomplete'        => ['icon_class'=>'incomplete-icon','title'=>'Falta Información','icon'=>'<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>'],
                                'verified_by_area'  => ['icon_class'=>'area-icon','title'=>'Verificados por Área','icon'=>'<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>'],
                                'unverified_empty'  => ['icon_class'=>'empty-icon','title'=>'Sin Verificar (Vacíos)','icon'=>'<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>'],
                                default             => ['icon_class'=>'default-icon','title'=>'Listado','icon'=>'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>']
                            };
                        @endphp
                        <div class="table-icon {{ $conf['icon_class'] }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">{!! $conf['icon'] !!}</svg>
                        </div>
                        <h2>{{ $conf['title'] }}</h2>
                        <span class="count-badge">{{ $users->total() }}</span>
                    </div>

                    {{-- Buscador --}}
                    <div class="form-group tb-inputicon tb-inputheight">
                        <i class="icon-search"></i>
                        <input type="text" class="form-control" wire:model.live.debounce.500ms="search"
                            autocomplete="off" placeholder="{{ __('general.search') }}">
                    </div>
                </div>

                {{-- TABLA CON GRID --}}
                <div class="table-overflow">
                    
                    {{-- HEADERS CON GRID --}}
                    <div class="table-grid-header">
                        <div>Tutor</div>
                        <div>
                            @if($reportType === 'verified_by_area') Área / Materias
                            @elseif($reportType === 'incomplete') Faltantes
                            @elseif($reportType === 'unverified_empty') Registro
                            @else Fecha Verificación
                            @endif
                        </div>
                        <div>Estado</div>
                        <div></div>
                    </div>

                    {{-- FILAS CON GRID --}}
                    @forelse($users as $user)
                    <div class="table-row">
                        
                        {{-- 1. COLUMNA TUTOR --}}
                        <div class="user-cell">
                            <div class="user-avatar 
                                {{ $reportType === 'verified_complete' ? 'verified-avatar' : 
                                  ($reportType === 'incomplete' ? 'incomplete-avatar' : 
                                  ($reportType === 'unverified_empty' ? 'empty-avatar' : 'area-avatar')) }}">
                                {{ substr($user->profile->first_name ?? '?', 0, 1) }}
                            </div>
                            <div class="user-info-cell">
                                <p class="user-name">{{ $user->profile->full_name ?? 'Sin Nombre' }}</p>
                                <p class="user-email">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- 2. COLUMNA DINÁMICA (Detalle) --}}
                        <div class="detail-cell">
                            @if($reportType === 'verified_by_area')
                                <div class="tags-wrapper">
                                    @forelse($user->userSubjects as $us)
                                        <span class="subject-tag">
                                            {{ $us->subject->name ?? 'Materia' }}
                                        </span>
                                    @empty
                                        <span class="empty-subjects">Sin materias asignadas</span>
                                    @endforelse
                                </div>
                            @elseif($reportType === 'incomplete')
                                <div class="tags-wrapper">
                                    @if(!$user->profile->phone_number) <span class="missing-tag">Teléfono</span> @endif
                                    @if(!$user->profile->image) <span class="missing-tag">Foto</span> @endif
                                    @if(!$user->profile->description) <span class="missing-tag">Bio</span> @endif
                                    @if($user->userSubjects->count() == 0) <span class="missing-tag">Materias</span> @endif
                                </div>
                            @elseif($reportType === 'unverified_empty')
                                <span class="time-ago">{{ $user->created_at->diffForHumans() }}</span>
                            @else
                                <div class="date-info-wrapper">
                                    <strong>{{ $user->profile->verified_at ? \Carbon\Carbon::parse($user->profile->verified_at)->format('d M, Y') : '--' }}</strong>
                                    <small>Fecha de validación</small>
                                </div>
                            @endif
                        </div>

                        {{-- 3. COLUMNA ESTADO --}}
                        <div>
                            @if($reportType === 'incomplete' || $reportType === 'unverified_empty')
                                <span class="status-badge incomplete-badge">
                                    <div class="status-dot"></div>
                                    Incompleto
                                </span>
                            @elseif($user->profile->verified_at)
                                <span class="status-badge complete-badge">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    Completo
                                </span>
                            @else
                                <span class="status-badge pending-badge">
                                    Pendiente
                                </span>
                            @endif
                        </div>

                        {{-- 4. COLUMNA ACCIÓN 
                        <div class="action-cell">
                            <a href="{{ route('users.show', $user->id) }}" class="action-btn" title="Ver perfil">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        </div>--}}
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon-wrapper">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <p>No se encontraron resultados en esta categoría.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Footer Paginación --}}
                <div class="table-footer">
                    {{ $users->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Definimos la función en el objeto window para que sea global
    window.toggleExportMenu = function(event) {
        // Evita que el clic se propague y cierre el menú inmediatamente
        if (event) event.stopPropagation();

        var menu = document.getElementById('exportMenu');
        var arrow = document.getElementById('exportArrow');
        
        if (!menu) return; // Seguridad por si no encuentra el elemento

        // Alternar visualización
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
            if(arrow) arrow.classList.add('rotate-180');
        } else {
            menu.style.display = 'none';
            if(arrow) arrow.classList.remove('rotate-180');
        }
    };

    // Cerrar menú si se hace clic en cualquier parte de la página
    document.addEventListener('click', function(event) {
        var menu = document.getElementById('exportMenu');
        var btn = document.querySelector('button[onclick*="toggleExportMenu"]');
        var arrow = document.getElementById('exportArrow');

        if (menu && menu.style.display === 'block') {
            // Si el clic NO fue dentro del menú
            if (!menu.contains(event.target)) {
                menu.style.display = 'none';
                if(arrow) arrow.classList.remove('rotate-180');
            }
        }
    });
</script>