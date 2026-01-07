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
    protected $reportType; // Variable nueva

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
        $commonData = [
            $user->profile->full_name ?? 'N/A',
            $user->email,
            $user->roles->pluck('name')->implode(', '),
            $user->profile->phone_number ?? 'Sin teléfono',
        ];

        if ($this->reportType === 'incomplete') {
            $missing = [];
            if (!$user->profile->phone_number) $missing[] = 'Teléfono';
            if (!$user->profile->image) $missing[] = 'Foto';
            if (!$user->profile->description) $missing[] = 'Descripción';
            if ($user->hasRole('tutor') && $user->userSubjects->isEmpty()) $missing[] = 'Materias';

            return array_merge($commonData, [
                implode(', ', $missing), 
                $user->created_at->format('d/m/Y'),
            ]);
        } 
        else {
            return array_merge($commonData, [
                $user->created_at->format('d/m/Y'),
                $user->profile->verified_at ? 'Verificado' : 'Pendiente', // Estado
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