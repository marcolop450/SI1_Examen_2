<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga Horaria - {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #f59e0b;
        }
        .header h1 {
            color: #92400e;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #64748b;
            font-size: 13px;
            font-weight: normal;
        }
        .docente-info {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #f59e0b;
        }
        .docente-info h3 {
            color: #92400e;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .docente-info p {
            margin: 3px 0;
            font-size: 10px;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .stat-item .number {
            font-size: 20px;
            font-weight: bold;
            color: #f59e0b;
            display: block;
        }
        .stat-item .label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
        }
        .dias-semana {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .dia-box {
            display: table-cell;
            width: 16.66%;
            text-align: center;
            padding: 10px;
            background: #fef3c7;
            border: 1px solid #fbbf24;
        }
        .dia-box .dia-nombre {
            font-size: 9px;
            color: #92400e;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .dia-box .dia-horas {
            font-size: 18px;
            color: #f59e0b;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: #f59e0b;
            color: white;
        }
        th {
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        td {
            padding: 7px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
        }
        tbody tr:nth-child(even) {
            background: #fffbeb;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-virtual {
            background: #e9d5ff;
            color: #6b21a8;
        }
        .badge-presencial {
            background: #dcfce7;
            color: #166534;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            font-size: 9px;
            color: #64748b;
        }
        .footer .info {
            margin-bottom: 15px;
        }
        .footer .signatures {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        .footer .signature {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 0 15px;
        }
        .footer .signature-line {
            border-top: 1px solid #333;
            margin-top: 45px;
            padding-top: 5px;
            font-size: 9px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 5px;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
            text-align: center;
            color: white;
            font-size: 10px;
            font-weight: bold;
            line-height: 20px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>CARGA HORARIA DOCENTE</h1>
        <h2>Gestión {{ now()->year }} - Facultad de Ciencias y Tecnología</h2>
    </div>

    <!-- Información del Docente -->
    <div class="docente-info">
        <h3>{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</h3>
        <p><strong>Registro:</strong> {{ $docente->registro }} | <strong>Carrera:</strong> {{ $docente->carrera }}</p>
        <p><strong>Especialidad:</strong> {{ $docente->especialidad }}</p>
        <p><strong>Email:</strong> {{ $docente->usuario->email }}</p>
        <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        
        @php
            $porcentaje = $docente->carga_horaria_maxima > 0 
                ? round(($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100, 2) 
                : 0;
        @endphp
        <div style="margin-top: 8px;">
            <div style="width: 100%; height: 20px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ min($porcentaje, 100) }}%; height: 100%; background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%); float: left;"></div>
            </div>
            <p style="margin-top: 3px; font-size: 9px; text-align: center;">
                <strong>{{ $docente->carga_horaria_actual }} / {{ $docente->carga_horaria_maxima }} hrs académicas ({{ $porcentaje }}%)</strong>
            </p>
        </div>
    </div>

    <!-- Estadísticas Resumidas -->
    <div class="stats">
        <div class="stat-item">
            <span class="number">{{ $totalHorasSemanales }}</span>
            <span class="label">Horas Semanales</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $docente->carga_horaria_actual }}</span>
            <span class="label">Carga Actual</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $porcentaje }}%</span>
            <span class="label">Porcentaje</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $horarios->count() }}</span>
            <span class="label">Total Clases</span>
        </div>
    </div>

    <!-- Distribución por Día -->
    <h3 style="color: #92400e; margin-bottom: 10px; font-size: 12px;">Distribución Horaria Semanal</h3>
    <div class="dias-semana">
        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
            @php
                $horas = $horasPorDia[$dia] ?? 0;
            @endphp
            <div class="dia-box">
                <div class="dia-nombre">{{ $dia }}</div>
                <div class="dia-horas">{{ $horas }}</div>
            </div>
        @endforeach
    </div>

    <!-- Tabla de Horarios Detallada -->
    <h3 style="color: #92400e; margin: 20px 0 10px 0; font-size: 12px;">Horario Detallado</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Día</th>
                <th style="width: 15%;">Horario</th>
                <th style="width: 33%;">Materia</th>
                <th style="width: 15%;">Grupo</th>
                <th style="width: 12%;">Aula</th>
                <th style="width: 13%;">Modalidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $horario)
            <tr>
                <td><strong>{{ $horario->dia }}</strong></td>
                <td>{{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_final, 0, 5) }}</td>
                <td>{{ $horario->materia->nombre }}</td>
                <td>{{ $horario->grupo->nombre }}</td>
                <td>
                    @if($horario->es_virtual)
                        -
                    @else
                        {{ $horario->aula->nombre }}
                    @endif
                </td>
                <td>
                    @if($horario->es_virtual)
                        <span class="badge badge-virtual">Virtual</span>
                    @else
                        <span class="badge badge-presencial">Presencial</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 25px; color: #64748b;">
                    No hay horarios asignados
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>