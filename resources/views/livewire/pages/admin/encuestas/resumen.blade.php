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
                    <div class="row mb-5 mt-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-primary">
                                <div class="stats-card-icon">
                                    <i class="icon-clipboard"></i>
                                </div>
                                <div class="stats-card-body">
                                    <h3>150</h3>
                                    <p>{{ __('general.total_surveys') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-success">
                                <div class="stats-card-icon">
                                    <i class="icon-calendar"></i>
                                </div>
                                <div class="stats-card-body">
                                    <h3>12</h3>
                                    <p>{{ __('general.surveys_today') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-warning">
                                <div class="stats-card-icon">
                                    <i class="icon-trending-up"></i>
                                </div>
                                <div class="stats-card-body">
                                    <h3>45</h3>
                                    <p>{{ __('general.surveys_this_week') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="stats-card stats-card-info">
                                <div class="stats-card-icon">
                                    <i class="icon-bar-chart"></i>
                                </div>
                                <div class="stats-card-body">
                                    <h3>98</h3>
                                    <p>{{ __('general.surveys_this_month') }}</p>
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
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        border-left: 4px solid;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }

    .stats-card-primary {
        border-left-color: #FF3D00;
    }

    .stats-card-success {
        border-left-color: #28a745;
    }

    .stats-card-warning {
        border-left-color: #ffc107;
    }

    .stats-card-info {
        border-left-color: #17a2b8;
    }

    .stats-card-icon {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
    }

    .stats-card-primary .stats-card-icon {
        background: linear-gradient(135deg, #FF3D00 0%, #ff6b3d 100%);
    }

    .stats-card-success .stats-card-icon {
        background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%);
    }

    .stats-card-warning .stats-card-icon {
        background: linear-gradient(135deg, #ffc107 0%, #ffd454 100%);
    }

    .stats-card-info .stats-card-icon {
        background: linear-gradient(135deg, #17a2b8 0%, #5bc0de 100%);
    }

    .stats-card-body {
        flex: 1;
    }

    .stats-card-body h3 {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .stats-card-body p {
        margin: 5px 0 0 0;
        color: #7f8c8d;
        font-size: 14px;
        font-weight: 500;
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
        margin-top: 5px;
        font-size: 14px;
    }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos estáticos para demostración
            const encuestasPorDia = [
                { fecha: '02/12', count: 8 },
                { fecha: '03/12', count: 12 },
                { fecha: '04/12', count: 6 },
                { fecha: '05/12', count: 15 },
                { fecha: '06/12', count: 10 },
                { fecha: '07/12', count: 14 },
                { fecha: '08/12', count: 12 }
            ];

            const encuestasPorMes = [
                { mes: 'Jul', count: 45 },
                { mes: 'Ago', count: 52 },
                { mes: 'Sep', count: 38 },
                { mes: 'Oct', count: 67 },
                { mes: 'Nov', count: 73 },
                { mes: 'Dic', count: 98 }
            ];

            const estadisticas = {
                hoy: 12,
                esta_semana: 45,
                este_mes: 98
            };

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
