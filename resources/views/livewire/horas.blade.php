<div class="control-horas-container">
    {{-- Cabecera con título y botón de descarga integrado --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">

        @if (count($semanas) > 0)
            <button class="btn-mini btn-mini-primary" wire:click="descargarReporte"
                style="gap: 0.25rem; padding: 0.35rem 0.75rem;">
                📥 Descargar Reporte
            </button>
        @endif
    </div>
    {{-- Inicializador Global / Pantalla de Bienvenida --}}
    @if (count($semanas) === 0)
        <div class="onboarding-card">
            <div class="onboarding-hero">
                <h1>Control Avanzado de Horas Laborales</h1>
                <p class="onboarding-desc">
                    Bienvenido al gestor de asistencia optimizado para flujos de alta velocidad. Esta herramienta está
                    diseñada para procesar registros de tiempo divididos en bloques de 4 dígitos independientes (Formato
                    24h). Cuenta con un sistema de navegación inteligente que salta de casilla automáticamente al
                    escribir, retroceso fluido con la tecla borrar y herramientas de redondeo inmediato de minutos por
                    día.
                </p>
            </div>

            <div class="onboarding-action-zone">
                <label style="margin-bottom: 1.25rem;">Elige el lunes de inicio directamente en el calendario:</label>

                <div class="datepicker-wrapper" wire:ignore x-data="{
                    initCalendar() {
                        flatpickr($refs.calendarInline, {
                            inline: true,
                            dateFormat: 'Y-m-d',
                            firstDayOfWeek: 1,
                            locale: {
                                firstDayOfWeek: 1,
                                weekdays: {
                                    shorthand: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']
                                },
                                months: {
                                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
                                }
                            },
                            disable: [
                                function(date) {
                                    // Solo permite seleccionar Lunes (1)
                                    return (date.getDay() !== 1);
                                }
                            ],
                            // SOLUCIÓN: Agregamos la clase 'is-monday' físicamente a cada celda de lunes
                            onDayCreate: function(dObj, dStr, fp, dayElem) {
                                if (dayElem.dateObj.getDay() === 1) {
                                    dayElem.classList.add('is-monday');
                                }
                            },
                            onChange: (selectedDates, dateStr) => {
                                @this.set('fechaInicioGlobal', dateStr);
                            }
                        });
                    }
                }" x-init="initCalendar()">

                    {{-- Input oculto sobre el cual se monta el widget --}}
                    <input type="text" x-ref="calendarInline" style="display: none;">

                    {{-- Botón de acción ubicado perfectamente abajo --}}
                    <button class="btn-onboarding" wire:click="crearPrimeraSemana">
                        Iniciar Tablero ➔
                    </button>
                </div>
                <span class="datepicker-hint" style="margin-top: 1.25rem;">Nota: Los días con contorno y punto verde
                    indican los días Lunes disponibles para iniciar la planilla semanal.</span>
            </div>
        </div>
    @endif

    {{-- Iteración de Semanas --}}
    @foreach ($semanas as $semanaIndex => $semana)
        <div class="semana-section">
            <div class="semana-header">
                <h3>Semana {{ $semanaIndex + 1 }}</h3>
                <div class="semana-meta">
                    <strong>{{ $semana['fecha_inicio'] }}</strong> al <strong>{{ $semana['fecha_fin'] }}</strong>
                </div>
            </div>

            {{-- Grid Horizontal de Días --}}
            <div class="dias-horizontal-grid">
                @foreach ($semana['dias'] as $diaIndex => $dia)
                    <div class="dia-card">
                        <div>
                            <p class="dia-title">
                                {{-- Nombre del día y fecha abreviada --}}
                                <span>{{ ucfirst($dia['nombre']) }}. {{ substr($dia['fecha'], 5) }}</span>

                                {{-- La ✕ para eliminar el día SOLO se muestra en el último día de la lista --}}
                                @if ($loop->last)
                                    <button class="btn-mini btn-mini-text"
                                        style="color: var(--terciary-color2); padding: 0; font-weight: bold;"
                                        wire:click="eliminarDia({{ $semanaIndex }}, {{ $diaIndex }})"
                                        title="Eliminar último día">
                                        ✕
                                    </button>
                                @endif
                            </p>

                            {{-- Contenedor de Rangos con auto-blur al llegar al final absoluto de la semana --}}
                            <div class="rangos-stack">
                                @foreach ($dia['rangos'] as $rangoIndex => $rango)
                                    <div class="rango-row"
                                        wire:key="rango-row-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}"
                                        x-on:focusout="if (!$el.contains($event.relatedTarget)) { $wire.forzarGarantizarCalculo(); }">

                                        <div style="display: flex; align-items: center; gap: 0.1rem; flex-grow: 1; justify-content: center;"
                                            x-data="{
                                                navegar(e, sIdx, dIdx, rIdx, pos) {
                                                        e.target.value = e.target.value.replace(/\D/g, '');
                                            
                                                        if (e.target.value.length === 2) {
                                                            let destinoId = '';
                                                            if (pos < 4) {
                                                                destinoId = `in-${sIdx}-${dIdx}-${rIdx}-${pos + 1}`;
                                                            } else {
                                                                let siguienteRango = document.getElementById(`in-${sIdx}-${dIdx}-${rIdx + 1}-1`);
                                                                if (siguienteRango) {
                                                                    destinoId = `in-${sIdx}-${dIdx}-${rIdx + 1}-1`;
                                                                } else {
                                                                    destinoId = `in-${sIdx}-${dIdx + 1}-0-1`;
                                                                }
                                                            }
                                            
                                                            let campoDestino = document.getElementById(destinoId);
                                                            if (campoDestino) {
                                                                campoDestino.focus();
                                                                campoDestino.select();
                                                            } else {
                                                                e.target.blur();
                                                            }
                                            
                                                            if (pos === 4) {
                                                                $wire.forzarGarantizarCalculo();
                                                            }
                                                        }
                                                    },
                                                    retroceder(e, sIdx, dIdx, rIdx, pos) {
                                                        if (e.target.value.length === 0) {
                                                            let destinoId = '';
                                                            if (pos > 1) {
                                                                destinoId = `in-${sIdx}-${dIdx}-${rIdx}-${pos - 1}`;
                                                            } else if (rIdx > 0) {
                                                                destinoId = `in-${sIdx}-${dIdx}-${rIdx - 1}-4`;
                                                            } else if (dIdx > 0) {
                                                                let rAnt = 0;
                                                                while (document.getElementById(`in-${sIdx}-${dIdx - 1}-${rAnt + 1}-4`)) { rAnt++; }
                                                                destinoId = `in-${sIdx}-${dIdx - 1}-${rAnt}-4`;
                                                            }
                                            
                                                            let campoDestino = document.getElementById(destinoId);
                                                            if (campoDestino) {
                                                                e.preventDefault();
                                                                campoDestino.focus();
                                                                campoDestino.select();
                                                            }
                                                        }
                                                    }
                                            }">

                                            {{-- 1. Hora Inicio --}}
                                            <input type="text"
                                                id="in-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}-1"
                                                wire:key="input-ini-h-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}"
                                                class="input-digito" placeholder="00" maxlength="2"
                                                x-on:focus="$el.select()"
                                                x-on:keydown.backspace="retroceder($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 1)"
                                                x-on:input="navegar($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 1)"
                                                wire:model="semanas.{{ $semanaIndex }}.dias.{{ $diaIndex }}.rangos.{{ $rangoIndex }}.ini_h">
                                            <span>:</span>

                                            {{-- 2. Minuto Inicio --}}
                                            <input type="text"
                                                id="in-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}-2"
                                                wire:key="input-ini-m-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}"
                                                class="input-digito" placeholder="00" maxlength="2"
                                                x-on:focus="$el.select()"
                                                x-on:keydown.backspace="retroceder($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 2)"
                                                x-on:input="navegar($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 2)"
                                                wire:model="semanas.{{ $semanaIndex }}.dias.{{ $diaIndex }}.rangos.{{ $rangoIndex }}.ini_m">

                                            <span
                                                style="margin: 0 0.15rem; color: var(--text-muted); font-size:0.65rem;">-</span>

                                            {{-- 3. Hora Fin --}}
                                            <input type="text"
                                                id="in-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}-3"
                                                wire:key="input-fin-h-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}"
                                                class="input-digito" placeholder="00" maxlength="2"
                                                x-on:focus="$el.select()"
                                                x-on:keydown.backspace="retroceder($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 3)"
                                                x-on:input="navegar($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 3)"
                                                wire:model="semanas.{{ $semanaIndex }}.dias.{{ $diaIndex }}.rangos.{{ $rangoIndex }}.fin_h">
                                            <span>:</span>

                                            {{-- 4. Minuto Fin --}}
                                            <input type="text"
                                                id="in-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}-4"
                                                wire:key="input-fin-m-{{ $semanaIndex }}-{{ $diaIndex }}-{{ $rangoIndex }}"
                                                class="input-digito" placeholder="00" maxlength="2"
                                                x-on:focus="$el.select()"
                                                x-on:keydown.backspace="retroceder($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 4)"
                                                x-on:input="navegar($event, {{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }}, 4)"
                                                wire:model="semanas.{{ $semanaIndex }}.dias.{{ $diaIndex }}.rangos.{{ $rangoIndex }}.fin_m">
                                        </div>

                                        {{-- Botón Eliminar Rango --}}
                                        @if ($loop->last)
                                            <button class="btn-mini btn-mini-text"
                                                style="color: var(--terciary-color2); font-weight: bold; padding: 0 0.1rem;"
                                                wire:click="eliminarRango({{ $semanaIndex }}, {{ $diaIndex }}, {{ $rangoIndex }})"
                                                title="Eliminar último rango">
                                                ✕
                                            </button>
                                        @endif
                                    </div>
                                @endforeach

                                <button class="btn-mini btn-mini-outline"
                                    style="width:100%; justify-content:center; padding:0.15rem; font-size: 0.7rem;"
                                    wire:click="agregarRango({{ $semanaIndex }}, {{ $diaIndex }})">
                                    + Rango
                                </button>
                            </div>
                        </div>

                        {{-- Sección inferior de la tarjeta del Día --}}
                        <div>
                            <div class="redondeo-mini-bar">
                                <button class="btn-mini btn-mini-text"
                                    wire:click="redondearAbajo({{ $semanaIndex }}, {{ $diaIndex }})"
                                    title="Redondear abajo">⬇️</button>
                                <button class="btn-mini btn-mini-text"
                                    wire:click="redondearArriba({{ $semanaIndex }}, {{ $diaIndex }})"
                                    title="Redondear arriba">⬆️</button>
                                <button class="btn-mini btn-mini-text"
                                    wire:click="resetAjusteDia({{ $semanaIndex }}, {{ $diaIndex }})"
                                    title="Reset Ajustes">⟲</button>
                                @if ($dia['ajuste_minutos'] ?? 0)
                                    <span
                                        style="font-size:0.65rem; align-self:center; color:var(--secundary-color)">{{ $dia['ajuste_minutos'] }}m</span>
                                @endif
                            </div>

                            <div class="dia-totales">
                                <span>Total:</span>
                                <span>{{ $dia['total_texto'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Footer / Acciones de la Semana --}}
            <div class="semana-footer">
                <h4>Total Semana: <span
                        style="color: var(--secundary-color); font-weight:700;">{{ $semana['total_texto'] }}</span>
                </h4>
                <div style="display: flex; gap: 0.35rem;">
                    <button class="btn-mini btn-mini-outline" wire:click="agregarDia({{ $semanaIndex }})">
                        + Día
                    </button>
                    <button class="btn-mini btn-mini-danger" wire:click="eliminarSemana({{ $semanaIndex }})">
                        Eliminar Semana
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Botón Inferior para Añadir Semanas --}}
    @if (count($semanas) > 0)
        <div>
            <button class="btn-mini btn-mini-primary" wire:click="agregarSemana">
                + Agregar semana
            </button>
        </div>
    @endif
</div>
