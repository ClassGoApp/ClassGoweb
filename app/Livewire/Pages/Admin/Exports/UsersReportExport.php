<?php

namespace App\Livewire\Pages\Admin\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersReportExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;
    protected $reportType;

    public function __construct($query, $reportType)
    {
        $this->query = $query;
        $this->reportType = $reportType;
    }

    public function query()
    {
        return $this->query;
    }

    public function map($user): array
    {
        // CORRECCIÓN 1: Usamos ?-> en full_name y phone_number
        // Si no hay perfil, devuelve 'N/A' y 'Sin teléfono' sin romper el excel
        $commonData = [
            $user->profile?->full_name ?? 'N/A', 
            $user->email,
            $user->roles->pluck('name')->implode(', '),
            $user->profile?->phone_number ?? 'Sin teléfono',
        ];

        if ($this->reportType === 'incomplete') {
            $missing = [];
            
            // CORRECCIÓN 2: Validaciones seguras con ?->
            // Si $user->profile es null, la expresión devuelve null y el if lo toma como "faltante" (true)
            if (!$user->profile?->phone_number) $missing[] = 'Teléfono';
            if (!$user->profile?->image) $missing[] = 'Foto';
            if (!$user->profile?->description) $missing[] = 'Descripción';
            
            // Opcional: Si no tiene perfil del todo, podrías indicarlo explícitamente:
            if (!$user->profile) $missing[] = '(Perfil no creado)';

            if ($user->hasRole('tutor') && $user->userSubjects->isEmpty()) $missing[] = 'Materias';

            return array_merge($commonData, [
                implode(', ', $missing), 
                $user->created_at->format('d/m/Y'),
            ]);
        } 
        else {
            return array_merge($commonData, [
                $user->created_at->format('d/m/Y'),
                // CORRECCIÓN 3: Validación segura en verified_at
                $user->profile?->verified_at ? 'Verificado' : 'Pendiente', 
            ]);
        }
    }

    public function headings(): array
    {
        $headers = ['Nombre Completo', 'Email', 'Rol', 'Teléfono'];

        if ($this->reportType === 'incomplete') {
            $headers[] = 'INFORMACIÓN FALTANTE'; 
            $headers[] = 'Fecha Registro';
        } else {
            $headers[] = 'Fecha Registro';
            $headers[] = 'Estado';
        }

        return [
            ['REPORTE: ' . strtoupper(str_replace('_', ' ', $this->reportType))],
            ['Generado el:', date('d/m/Y H:i')],
            [''], 
            $headers 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            4 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 
                  'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF4B5563']]],
        ];
    }
}