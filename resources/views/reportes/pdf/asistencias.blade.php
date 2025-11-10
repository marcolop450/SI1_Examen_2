<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencias</title>
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
            border-bottom: 3px solid #3b82f6;
        }
        .header h1 {
            color: #1e3a8a;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #64748b;
            font-size: 13px;
            font-weight: normal;
        }
        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }
        .info-box h3 {
            color: #1e3a8a;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 10px;
        }
        .info-box strong {
            color: #1e3a8a;
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
        .stat-item.success {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-color: #86efac;
        }
        .stat-item.warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #fcd34d;
        }
        .stat-item.danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #fca5a5;
        }
        .stat-item .number {
            font-size: 20px;
            font-weight: bold;
            display: block;
        }
        .stat-item .label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
        }
        .stat-item.success .number { color: #166534; }
        .stat-item.warning .number { color: #92400e; }
        .stat-item.danger .number { color: #991b1b; }
        .stat-item .number { color: #3b82f6; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: #3b82f6;
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
            background: #f1f5f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            font-size: 9px;
            color: #64748b;
        }
        .footer .info {
            text-align: center;
            margin-bottom: 10px;
        }
        .summary-section {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
        }
        .summary-section h3 {
            color: #1e3a8a;
            font-size: 11px;
            margin-bottom: 8px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 8px;
            text-align: center;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .summary-item .text {
            font-size: 8px;
            color: #64748b;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>REPORTE DE ASISTENCIAS DOCENTES</h1>
        <h2>Sistema de Gestión Académica - FICCT</h2>
    </div>

    <!-- Información del Reporte -->
    <div class="info-box">
        <h3>Información del Período</h3>
        <p><strong>Rango de Fechas:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
        <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Gestión Académica:</strong> {{ now()->year }}</p>
        <p><strong>Generado por:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
    </div>

    <!-- Estadísticas Resumidas -->
    <div class="stats">
        <div class="stat-item">
            <span class="number">{{ $estadisticas['total'] }}</span>
            <span class="label">Total Registros</span>
        </div>
        <div class="stat-item success">
            <span class="number">{{ $estadisticas['a_tiempo'] }}</span>
            <span class="label">A Tiempo</span>
        </div>
        <div class="stat-item warning">
            <span class="number">{{ $estadisticas['tardanzas'] }}</span>
            <span class="label">Tardanzas</span>
        </div>
        <div class="stat-item danger">
            <span class="number">{{ $estadisticas['faltas'] }}</span>
            <span class="label">Faltas</span>
        </div>
    </div>

    <!-- Sección de Resumen Adicional -->
    <div class="summary-section">
        <h3>Análisis de Puntualidad</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total'] > 0 ? round(($estadisticas['a_tiempo'] / $estadisticas['total']) * 100, 1) : 0 }}%</div>
                <div class="text">Porcentaje de Puntualidad</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total'] > 0 ? round(($estadisticas['tardanzas'] / $estadisticas['total']) * 100, 1) : 0 }}%</div>
                <div class="text">Porcentaje de Tardanzas</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total'] > 0 ? round(($estadisticas['faltas'] / $estadisticas['total']) * 100, 1) : 0 }}%</div>
                <div class="text">Porcentaje de Faltas</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Asistencias -->
    <h3 style="color: #1e3a8a; margin-bottom: 10px; font-size: 12px;">Detalle de Asistencias</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Fecha</th>
                <th style="width: 20%;">Docente</th>
                <th style="width: 25%;">Materia</th>
                <th style="width: 12%;">Grupo</th>
                <th style="width: 10%;">Hora Llegada</th>
                <th style="width: 13%;">Aula</th>
                <th style="width: 10%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $asistencia)
            <tr>
                <td><strong>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</strong></td>
                <td>{{ $asistencia->docente->usuario->nombre }} {{ $asistencia->docente->usuario->apellido }}</td>
                <td>{{ $asistencia->horario->materia->nombre }}</td>
                <td>{{ $asistencia->horario->grupo->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($asistencia->hora_llegada)->format('H:i') }}</td>
                <td>
                    @if($asistencia->horario->es_virtual)
                        <span style="font-style: italic; color: #6b21a8;">Virtual</span>
                    @else
                        {{ $asistencia->horario->aula->nombre ?? 'N/A' }}
                    @endif
                </td>
                <td>
                    @if($asistencia->estado == 'A tiempo')
                        <span class="badge badge-success">A tiempo</span>
                    @elseif($asistencia->estado == 'Tardanza')
                        <span class="badge badge-warning">Tardanza</span>
                    @else
                        <span class="badge badge-danger">Falta</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 25px; color: #64748b;">
                    No se encontraron registros de asistencia en el período seleccionado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="info">
            Sistema de Gestión Académica - Facultad de Ciencias y Tecnología
            <br>
            Universidad Autónoma Gabriel René Moreno
            <br>
            Este documento es de carácter oficial y confidencial
        </div>
    </div>
</body>
</html>