<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4B5563;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .info {
            margin-bottom: 15px;
            font-size: 11px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4B5563;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge-green { color: green; font-weight: bold; }
        .badge-red { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Usuarios - Sistema GoWeb</h1>
        <p>Generado automáticamente</p>
    </div>

    <div class="info">
        <strong>Fecha:</strong> {{ date('d/m/Y H:i') }} <br>
        <strong>Total Registros:</strong> {{ $count }} <br>
        <strong>Filtro aplicado:</strong> {{ $reportType }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Teléfono</th>
                
                @if($reportType === 'incomplete')
                    <th style="color: #b91c1c; background-color: #fee2e2;">Faltantes</th>
                @else
                    <th>Estado</th>
                @endif
                
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->profile?->full_name ?? 'N/A' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                
                {{-- CORRECCIÓN CRÍTICA: Se agregó ?-> para evitar el error con usuarios sin perfil --}}
                <td>{{ $user->profile?->phone_number ?? '-' }}</td>
                
                @if($reportType === 'incomplete')
                    <td style="color: #b91c1c; font-size: 10px;">
                        @php
                            $missing = [];
                            
                            // Validaciones seguras
                            if (!$user->profile?->phone_number) $missing[] = 'Teléfono';
                            if (!$user->profile?->image) $missing[] = 'Foto';
                            
                            // CAMBIO 1: Coincidir con Excel (Descripción en vez de Bio)
                            if (!$user->profile?->description) $missing[] = 'Descripción';
                            
                            // CAMBIO 2: Agregar aviso si no existe perfil (Igual que Excel)
                            if (!$user->profile) $missing[] = '(Perfil no creado)';

                            if ($user->roles->contains('name', 'tutor') && $user->userSubjects->isEmpty()) $missing[] = 'Materias';
                        @endphp
                        {{ implode(', ', $missing) }}
                    </td>
                @else
                    <td>
                        @if($user->profile?->verified_at)
                            <span class="badge-green">Verificado</span>
                        @else
                            <span class="badge-red">Pendiente</span>
                        @endif
                    </td>
                @endif

                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>