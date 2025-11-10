<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Horarios</title>
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
            border-bottom: 3px solid #0ea5e9;
        }
        .header h1 {
            color: #0c4a6e;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #64748b;
            font-size: 13px;
            font-weight: normal;
        }
        .info-box {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #0ea5e9;
        }
        .info-box h3 {
            color: #0c4a6e;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 10px;
        }
        .info-box strong {
            color: #0c4a6e;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .stat-item .number {
            font-size: 20px;
            font-weight: bold;
            color: #0ea5e9;
            display: block;
        }
        .stat-item .label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: #0ea5e9;
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
            background: #f0f9ff;
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
        .summary-section {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
        }
        .summary-section h3 {
            color: #0c4a6e;
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
            color: #0c4a6e;
        }
        .summary-item .text {
            font-size: 8px;
            color: #64748b;
            margin-top: 3px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            font-size: 9px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>REPORTE DE HORARIOS ACADÉMICOS</h1>
        <h2>Sistema de Gestión Académica - FICCT</h2>
    </div>

    <!-- Información del Reporte -->
    <div class="info-box">
        <h3>Información del Reporte</h3>
        <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Gestión Académica:</strong> {{ now()->year }}</p>
        @if($filtroDocente || $filtroGrupo || $filtroDia)
            <p><strong>Filtros Aplicados:</strong>
                @if($filtroDocente) Docente #{{ $filtroDocente }} @endif
                @if($filtroGrupo) @if($filtroDocente) | @endif Grupo #{{ $filtroGrupo }} @endif
                @if($filtroDia) @if($filtroDocente || $filtroGrupo) | @endif Día: {{ $filtroDia }} @endif
            </p>
        @endif
        <p><strong>Generado por:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
    </div>

    <!-- Estadísticas Resumidas -->
    <div class="stats">
        <div class="stat-item">
            <span class="number">{{ $estadisticas['total_horarios'] }}</span>
            <span class="label">Total Horarios</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $estadisticas['horarios_presenciales'] }}</span>
            <span class="label">Presenciales</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $estadisticas['horarios_virtuales'] }}</span>
            <span class="label">Virtuales</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $estadisticas['docentes_con_horarios'] }}</span>
            <span class="label">Docentes</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $estadisticas['grupos_con_horarios'] }}</span>
            <span class="label">Grupos Activos</span>
        </div>
    </div>

    <!-- Resumen Adicional -->
    <div class="summary-section">
        <h3>Distribución de Modalidades</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total_horarios'] > 0 ? round(($estadisticas['horarios_presenciales'] / $estadisticas['total_horarios']) * 100, 1) : 0 }}%</div>
                <div class="text">Clases Presenciales</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total_horarios'] > 0 ? round(($estadisticas['horarios_virtuales'] / $estadisticas['total_horarios']) * 100, 1) : 0 }}%</div>
                <div class="text">Clases Virtuales</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $estadisticas['total_horarios'] > 0 ? round($estadisticas['total_horarios'] / max($estadisticas['docentes_con_horarios'], 1), 1) : 0 }}</div>
                <div class="text">Promedio Horarios/Docente</div>
            </div>
        </div>
    </div>

    <!-- Tabla de Horarios -->
    <h3 style="color: #0c4a6e; margin-bottom: 10px; font-size: 12px;">Detalle de Horarios</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Día</th>
                <th style="width: 12%;">Horario</th>
                <th style="width: 23%;">Docente</th>
                <th style="width: 25%;">Materia</th>
                <th style="width: 12%;">Grupo</th>
                <th style="width: 18%;">Aula/Modalidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($horarios as $horario)
            <tr>
                <td><strong>{{ $horario->dia }}</strong></td>
                <td>{{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_final, 0, 5) }}</td>
                <td>{{ $horario->docente->usuario->nombre }} {{ $horario->docente->usuario->apellido }}</td>
                <td>{{ $horario->materia->nombre }}</td>
                <td>{{ $horario->grupo->nombre }}</td>
                <td>
                    @if($horario->es_virtual)
                        <span class="badge badge-virtual">Virtual</span>
                    @else
                        <span class="badge badge-presencial">{{ $horario->aula->nombre }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 25px; color: #64748b;">
                    No se encontraron horarios con los filtros aplicados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Sistema de Gestión Académica - FICCT
        <br>
        Universidad Autónoma Gabriel René Moreno
    </div>
</body>
</html>