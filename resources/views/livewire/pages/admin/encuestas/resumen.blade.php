<div>
    <main class="tb-main am-dispute-system am-user-system">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tb-dhb-mainheading">
                    <div class="tb-dhb-mainheading__title">
                        <h4>{{ __('general.survey_statistics') }}</h4>
                        <p>{{ __('general.surveys_overview_description') }}</p>
                    </div>
                    
                    {{-- Tarjetas de Estadísticas --}}
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-success">
                                <div class="stats-card-body-full">
                                    <div class="stats-header">
                                        <span class="stats-title">ÉXITO EN BÚSQUEDA</span>
                                    </div>
                                    <h2 class="stats-number">{{ $metricas['exito_busqueda'] }}%</h2>
                                    <p class="stats-description">Usuarios que encontraron la materia fácilmente.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-primary">
                                <div class="stats-card-body-full">
                                    <div class="stats-header">
                                        <span class="stats-title">PROMEDIO DE RECOMENDACIÓN</span>
                                    </div>
                                    <h2 class="stats-number">{{ $metricas['promedio_recomendacion'] }} / 5</h2>
                                    <p class="stats-description">Calificación promedio de los usuarios (1-5).</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-danger">
                                <div class="stats-card-body-full">
                                    <div class="stats-header">
                                        <span class="stats-title">USUARIOS DETRACTORES (1-2)</span>
                                    </div>
                                    <h2 class="stats-number">{{ $metricas['usuarios_detractores'] }}%</h2>
                                    <p class="stats-description">Alerta de usuarios con insatisfacción grave.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-warning">
                                <div class="stats-card-body-full">
                                    <div class="stats-header">
                                        <span class="stats-title">FOCO DE MEJORA</span>
                                    </div>
                                    <h2 class="stats-number" style="font-size: {{ strlen($metricas['foco_mejora']) > 20 ? '24px' : '42px' }}">
                                        {{ $metricas['foco_mejora'] }}
                                    </h2>
                                    <p class="stats-description">Comentario negativo más frecuente.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gráfico de Barras - Últimos 7 días --}}
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h5>{{ __('general.surveys_last_7_days') }}</h5>
                                </div>
                                <div class="chart-body">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Gráfico de Torta - Distribución por periodo --}}
                        <div class="col-lg-4 mb-4">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h5>{{ __('general.distribution_by_period') }}</h5>
                                </div>
                                <div class="chart-body">
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gráfico de Líneas - Últimos 6 meses --}}
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="chart-container">
                                <div class="chart-header">
                                    <h5>{{ __('general.surveys_last_6_months') }}</h5>
                                </div>
                                <div class="chart-body">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>


    

    @push('styles')
    <style>
    .stats-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border-left: 4px solid;
        height: 100%;
        min-height: 180px;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .stats-card-success {
        border-left-color: #28a745;
    }

    .stats-card-primary {
        border-left-color: #2196F3;
    }

    .stats-card-danger {
        border-left-color: #dc3545;
    }

    .stats-card-warning {
        border-left-color: #ffc107;
    }

    .stats-card-body-full {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .stats-header {
        margin-bottom: 15px;
    }

    .stats-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: block;
    }

    .stats-card-success .stats-title {
        color: #28a745;
    }

    .stats-card-primary .stats-title {
        color: #2196F3;
    }

    .stats-card-danger .stats-title {
        color: #dc3545;
    }

    .stats-card-warning .stats-title {
        color: #ffc107;
    }

    .stats-number {
        font-size: 42px;
        font-weight: 700;
        margin: 10px 0;
        line-height: 1;
        color: #2c3e50;
    }

    .stats-description {
        margin: 8px 0 0 0;
        color: #6c757d;
        font-size: 13px;
        line-height: 1.4;
    }

    .chart-container {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        height: 100%;
    }

    .chart-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .chart-header h5 {
        margin: 0;
        color: #2c3e50;
        font-weight: 600;
        font-size: 18px;
    }

    .chart-body {
        position: relative;
        height: 300px;
    }

    .tb-dhb-mainheading__title p {
        color: #7f8c8d;
        font-size: 14px;
    }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos desde el backend
            const encuestasPorDia = @json($encuestasPorDia);
            const encuestasPorMes = @json($encuestasPorMes);
            const estadisticas = @json($estadisticas);

            // Colores del tema
            const colors = {
                primary: '#FF3D00',
                success: '#28a745',
                warning: '#ffc107',
                info: '#17a2b8',
                gradient: {
                    primary: 'rgba(255, 61, 0, 0.2)',
                    success: 'rgba(40, 167, 69, 0.2)',
                    warning: 'rgba(255, 193, 7, 0.2)',
                    info: 'rgba(23, 162, 184, 0.2)',
                }
            };

            // Configuración común de gráficos
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    }
                }
            };

            // Gráfico de Barras - Últimos 7 días
            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: encuestasPorDia.map(d => d.fecha),
                    datasets: [{
                        label: '{{ __("general.surveys") }}',
                        data: encuestasPorDia.map(d => d.count),
                        backgroundColor: colors.gradient.primary,
                        borderColor: colors.primary,
                        borderWidth: 2,
                        borderRadius: 6,
                    }]
                },
                options: {
                    ...commonOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Gráfico de Torta - Distribución
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: [
                        '{{ __("general.surveys_today") }}',
                        '{{ __("general.surveys_this_week") }}',
                        '{{ __("general.surveys_this_month") }}'
                    ],
                    datasets: [{
                        data: [
                            estadisticas.hoy,
                            estadisticas.esta_semana,
                            estadisticas.este_mes
                        ],
                        backgroundColor: [
                            colors.success,
                            colors.warning,
                            colors.info
                        ],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    ...commonOptions,
                    cutout: '60%',
                }
            });

            // Gráfico de Líneas - Últimos 6 meses
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: encuestasPorMes.map(m => m.mes),
                    datasets: [{
                        label: '{{ __("general.surveys") }}',
                        data: encuestasPorMes.map(m => m.count),
                        backgroundColor: colors.gradient.primary,
                        borderColor: colors.primary,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: colors.primary,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    ...commonOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</div>
