<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class Horas extends Component
{
    public string $fechaInicioGlobal = '';
    public array $semanas = [];
    public array $nombresDias = [
        'lunes',
        'martes',
        'miércoles',
        'jueves',
        'viernes',
        'sábado',
        'domingo',
    ];

    public function crearPrimeraSemana()
    {
        if (empty($this->fechaInicioGlobal) || count($this->semanas) > 0) return;

        $fechaInicio = Carbon::parse($this->fechaInicioGlobal);
        $this->crearSemanaDesdeFecha($fechaInicio);
    }

    public function agregarSemana()
    {
        if (count($this->semanas) === 0) {
            $this->crearPrimeraSemana();
            return;
        }

        $ultimaSemana = end($this->semanas);
        $fechaInicio = Carbon::parse($ultimaSemana['fecha_fin'])->addDay();

        $this->crearSemanaDesdeFecha($fechaInicio);
    }

    private function crearSemanaDesdeFecha(Carbon $fechaInicio)
    {
        $fechaFin = $fechaInicio->copy()->addDays(6);
        $diasIniciales = [];

        for ($i = 0; $i < 6; $i++) {
            $fechaDia = $fechaInicio->copy()->addDays($i);

            $diasIniciales[] = [
                'nombre' => $this->nombresDias[$i],
                'fecha' => $fechaDia->format('Y-m-d'),
                'ajuste_minutos' => 0,
                'redondeo' => null,
                'rangos' => [
                    [
                        // Modificado: Inicializan completamente vacíos
                        'ini_h' => '',
                        'ini_m' => '',
                        'fin_h' => '',
                        'fin_m' => '',
                        'total_minutos' => 0,
                        'total_texto' => '0h y 0m',
                    ]
                ],
                'total_minutos' => 0,
                'total_texto' => '0h y 0m',
            ];
        }

        $this->semanas[] = [
            'fecha_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'dias' => $diasIniciales,
            'total_minutos' => 0,
            'total_texto' => '0h y 0m',
        ];

        $this->calcularTodo();
    }

    public function eliminarSemana($semanaIndex)
    {
        unset($this->semanas[$semanaIndex]);
        $this->semanas = array_values($this->semanas);
        $this->recalcularFechasSemanas();
        $this->calcularTodo();
    }

    public function agregarDia($semanaIndex)
    {
        if (!isset($this->semanas[$semanaIndex])) return;

        $cantidadDias = count($this->semanas[$semanaIndex]['dias']);
        if ($cantidadDias >= 7) return;

        $fechaSemanaInicio = Carbon::parse($this->semanas[$semanaIndex]['fecha_inicio']);
        $fechaDia = $fechaSemanaInicio->copy()->addDays($cantidadDias);

        $this->semanas[$semanaIndex]['dias'][] = [
            'nombre' => $this->nombresDias[$cantidadDias],
            'fecha' => $fechaDia->format('Y-m-d'),
            'ajuste_minutos' => 0,
            'redondeo' => null,
            'rangos' => [
                [
                    'ini_h' => '',
                    'ini_m' => '',
                    'fin_h' => '',
                    'fin_m' => '',
                    'total_minutos' => 0,
                    'total_texto' => '0h y 0m',
                ]
            ],
            'total_minutos' => 0,
            'total_texto' => '0h y 0m',
        ];

        $this->calcularTodo();
    }

    public function eliminarDia($semanaIndex, $diaIndex)
    {
        unset($this->semanas[$semanaIndex]['dias'][$diaIndex]);
        $this->semanas[$semanaIndex]['dias'] = array_values($this->semanas[$semanaIndex]['dias']);
        $this->recalcularDiasSemana($semanaIndex);
        $this->calcularTodo();
    }


    public function agregarRango($semanaIndex, $diaIndex)
    {
        if (!isset($this->semanas[$semanaIndex]['dias'][$diaIndex])) return;

        // SOLUCIÓN: Apagamos el redondeo actual para mostrar la sumatoria real limpia
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['redondeo'] = null;

        $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][] = [
            'ini_h' => '',
            'ini_m' => '',
            'fin_h' => '',
            'fin_m' => '',
            'total_minutos' => 0,
            'total_texto' => '0h y 0m',
        ];

        $this->calcularTodo();

        $nuevoRangoIndex = count($this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos']) - 1;
        $this->dispatch('focus-nuevo-rango', id: "rango-{$semanaIndex}-{$diaIndex}-{$nuevoRangoIndex}");
    }

    public function eliminarRango($semanaIndex, $diaIndex, $rangoIndex)
    {
        unset($this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]);
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'] = array_values($this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos']);

        // SOLUCIÓN: También apagamos el redondeo aquí al remover filas
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['redondeo'] = null;

        if (count($this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos']) === 0) {
            $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][] = [
                'ini_h' => '',
                'ini_m' => '',
                'fin_h' => '',
                'fin_m' => '',
                'total_minutos' => 0,
                'total_texto' => '0h y 0m',
            ];
        }

        $this->calcularTodo();
    }

    public function redondearAbajo($semanaIndex, $diaIndex)
    {
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['redondeo'] = 'abajo';
        $this->calcularTodo();
    }

    public function redondearArriba($semanaIndex, $diaIndex)
    {
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['redondeo'] = 'arriba';
        $this->calcularTodo();
    }

    public function resetAjusteDia($semanaIndex, $diaIndex)
    {
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['ajuste_minutos'] = 0;
        $this->semanas[$semanaIndex]['dias'][$diaIndex]['redondeo'] = null;
        $this->calcularTodo();
    }

    // Se dispara manualmente desde la vista cuando se cambia de fila
    public function forzarGarantizarCalculo()
    {
        $this->calcularTodo();
    }

    private function normalizarCampo($val, $max): string
    {
        $val = trim($val);
        if ($val === '') {
            return '00'; // Si el usuario la activó y la dejó vacía por error, se auto-rellena con 00
        }
        if (is_numeric($val)) {
            $num = intval($val);
            if ($num > $max) $num = $max;
            return str_pad($num, 2, '0', STR_PAD_LEFT);
        }
        return '00';
    }

    private function calcularTodo()
    {
        foreach ($this->semanas as $semanaIndex => $semana) {
            $totalMinutosSemana = 0;

            foreach ($semana['dias'] as $diaIndex => $dia) {
                $totalMinutosDia = 0;

                foreach ($dia['rangos'] as $rangoIndex => $rango) {

                    $ih = $rango['ini_h'] ?? '';
                    $im = $rango['ini_m'] ?? '';
                    $fh = $rango['fin_h'] ?? '';
                    $fm = $rango['fin_m'] ?? '';

                    // NUEVO: Si la fila está completamente vacía, la respetamos sin forzar ceros
                    if ($ih === '' && $im === '' && $fh === '' && $fm === '') {
                        $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['total_minutos'] = 0;
                        $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['total_texto'] = '0h y 0m';
                        continue;
                    }

                    // Si ya se interactuó con ella, se normaliza lo que quede pendiente
                    $ini_h = $this->normalizarCampo($ih, 23);
                    $ini_m = $this->normalizarCampo($im, 59);
                    $fin_h = $this->normalizarCampo($fh, 23);
                    $fin_m = $this->normalizarCampo($fm, 59);

                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['ini_h'] = $ini_h;
                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['ini_m'] = $ini_m;
                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['fin_h'] = $fin_h;
                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['fin_m'] = $fin_m;

                    $minutosRango = $this->calcularMinutosRango("{$ini_h}:{$ini_m}", "{$fin_h}:{$fin_m}");

                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['total_minutos'] = $minutosRango;
                    $this->semanas[$semanaIndex]['dias'][$diaIndex]['rangos'][$rangoIndex]['total_texto'] = $this->formatearMinutos($minutosRango);

                    $totalMinutosDia += $minutosRango;
                }

                $ajusteMinutos = intval($dia['ajuste_minutos'] ?? 0);
                $totalMinutosDia += $ajusteMinutos;

                if ($totalMinutosDia < 0) $totalMinutosDia = 0;

                $redondeo = $dia['redondeo'] ?? null;
                if ($redondeo === 'abajo') $totalMinutosDia = intdiv($totalMinutosDia, 60) * 60;
                if ($redondeo === 'arriba') {
                    if ($totalMinutosDia % 60 !== 0) $totalMinutosDia = (intdiv($totalMinutosDia, 60) + 1) * 60;
                }

                $this->semanas[$semanaIndex]['dias'][$diaIndex]['total_minutos'] = $totalMinutosDia;
                $this->semanas[$semanaIndex]['dias'][$diaIndex]['total_texto'] = $this->formatearMinutos($totalMinutosDia);

                $totalMinutosSemana += $totalMinutosDia;
            }

            $this->semanas[$semanaIndex]['total_minutos'] = $totalMinutosSemana;
            $this->semanas[$semanaIndex]['total_texto'] = $this->formatearMinutos($totalMinutosSemana);
        }
    }

    private function calcularMinutosRango($horaInicio, $horaFin)
    {
        if ($horaInicio === '00:00' && $horaFin === '00:00') return 0;

        try {
            $inicio = Carbon::parse($horaInicio);
            $fin = Carbon::parse($horaFin);

            if ($fin->lessThan($inicio)) $fin->addDay();

            return $inicio->diffInMinutes($fin);
        } catch (\Throwable $e) {
            return 0;
        }
    }

    private function formatearMinutos($totalMinutos)
    {
        $horas = intdiv($totalMinutos, 60);
        $minutos = $totalMinutos % 60;
        return "{$horas}h y {$minutos}m";
    }

    private function recalcularFechasSemanas()
    {
        if (count($this->semanas) === 0) return;

        $fechaInicio = Carbon::parse($this->fechaInicioGlobal);
        foreach ($this->semanas as $semanaIndex => $semana) {
            $inicioSemana = $fechaInicio->copy()->addDays($semanaIndex * 7);
            $finSemana = $inicioSemana->copy()->addDays(6);

            $this->semanas[$semanaIndex]['fecha_inicio'] = $inicioSemana->format('Y-m-d');
            $this->semanas[$semanaIndex]['fecha_fin'] = $finSemana->format('Y-m-d');
            $this->recalcularDiasSemana($semanaIndex);
        }
    }

    private function recalcularDiasSemana($semanaIndex)
    {
        if (!isset($this->semanas[$semanaIndex])) return;

        $fechaSemanaInicio = Carbon::parse($this->semanas[$semanaIndex]['fecha_inicio']);
        foreach ($this->semanas[$semanaIndex]['dias'] as $diaIndex => $dia) {
            $fechaDia = $fechaSemanaInicio->copy()->addDays($diaIndex);
            $this->semanas[$semanaIndex]['dias'][$diaIndex]['nombre'] = $this->nombresDias[$diaIndex];
            $this->semanas[$semanaIndex]['dias'][$diaIndex]['fecha'] = $fechaDia->format('Y-m-d');
        }
    }

    public function descargarReporte()
{
    // Si no hay semanas creadas, no exportamos nada
    if (empty($this->semanas)) {
        return;
    }

    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="reporte_horas_semanal.csv"',
    ];

    return response()->streamDownload(function () {
        $output = fopen('php://output', 'w');
        
        // Inyectar BOM para asegurar que Excel reconozca eñes y acentos en español
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // --- SECCIÓN 1: DETALLE DIARIO ---
        fputcsv($output, ['REPORTE DETALLADO DE ASISTENCIA']);
        fputcsv($output, []);

        foreach ($this->semanas as $semanaIndex => $semana) {
            $numSemana = $semanaIndex + 1;
            fputcsv($output, ["SEMANA {$numSemana} (Del {$semana['fecha_inicio']} al {$semana['fecha_fin']})"]);
            fputcsv($output, ['Día', 'Fecha', 'Horas Calculadas']);

            foreach ($semana['dias'] as $dia) {
                // Convertimos los minutos totales a formato decimal (Ej: 8 horas y 30 mins = 8.5)
                $horasDecimal = $dia['total_minutos'] > 0 ? round($dia['total_minutos'] / 60, 2) : 0;
                fputcsv($output, [ucfirst($dia['nombre']), $dia['fecha'], $horasDecimal]);
            }
            
            $totalSemanaDecimal = $semana['total_minutos'] > 0 ? round($semana['total_minutos'] / 60, 2) : 0;
            fputcsv($output, ['TOTAL ACUMULADO SEMANA', '', $totalSemanaDecimal]);
            fputcsv($output, []); // Línea en blanco de separación
        }

        fputcsv($output, []);
        fputcsv($output, []);

        // --- SECCIÓN 2: RESUMEN HORIZONTAL (ESTILO IMAGEN) ---
        fputcsv($output, ['RESUMEN GENERAL POR SEMANAS']);
        
        $filaSemanas = [];
        $filaTotales = [];

        // Forzamos un bloque mínimo de 5 semanas como muestra tu imagen
        $columnasAMostrar = max(5, count($this->semanas));

        for ($i = 0; $i < $columnasAMostrar; $i++) {
            $filaSemanas[] = "semana " . ($i + 1);
            
            // Si la semana existe y tiene minutos calculados, guardamos sus horas decimales
            if (isset($this->semanas[$i]) && $this->semanas[$i]['total_minutos'] > 0) {
                $filaTotales[] = round($this->semanas[$i]['total_minutos'] / 60, 2);
            } else {
                $filaTotales[] = 0; // Si no hay horas o no existe la semana, fuerza el 0
            }
        }

        // Imprimimos la matriz idéntica a tu tabla
        fputcsv($output, $filaSemanas);
        fputcsv($output, $filaTotales);

        fclose($output);
    }, 'reporte_horas_semanal.csv', $headers);
}

    public function render()
    {
        return view('livewire.horas');
    }
}
