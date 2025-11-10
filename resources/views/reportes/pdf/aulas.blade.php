<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Aulas</title>
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
            border-bottom: 3px solid #8b5cf6;
        }
        .header h1 {
            color: #5b21b6;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #64748b;
            font-size: 13px;
            font-weight: normal;
        }
        .info-box {
            background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #8b5cf6;
        }
        .info-box h3 {
            color: #5b21b6;
            font-size: 12px;
            margin-bottom: 8px;
        }
        .info-box p {
            margin: 3px 0;
            font-size: 10px;
        }
        .info-box strong {
            color: #5b21b6;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }
        .stat-item .number {
            font-size: 20px;
            font-weight: bold;
            color: #8b5cf6;
            display: block;
        }
        .stat-item .label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
        }
        .aula-card {
            border: 1px solid #e2e8f0;
            margin-bottom: 15px;
            padding: 12px;
            background-color: #fafafa;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .aula-header {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            border-bottom: 2px solid #8b5cf6;
            padding-bottom: 5px;
        }
        .aula-title {
            display: table-cell;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .aula-subtitle {
            font-size: 10px;
            color: #666;
            font-weight: normal;
            margin-left: 8px;
        }
        .aula-percent {
            display: table-cell;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }
        .percent-high { color: #dc2626; }
        .percent-medium { color: #eab308; }
        .percent-low { color: #16a34a; }
        .aula-info {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            background: #f8fafc;
            padding: 8px;
            border-radius: 5px;
        }
        .info-item {
            display: table-cell;
            padding: 4px 8px;
            font-size: 9px;
            width: 33.33%;
        }
        .info-label {
            color: #64748b;
            font-weight: normal;
            display: block;
            margin-bottom: 2px;
        }
        .info-value {
            color: #333;
            font-weight: bold;
            font-size: 11px;
        }
        .progress-bar {
            width: 100%;
            height: 18px;
            background-color: #e5e7eb;
            border-radius: 9px;
            overflow: hidden;
            margin-top: 5px;
        }
        .progress-fill {
            height: 100%;
            transition: width 0.3s;
            display: table;
            width: 100%;
        }
        .progress-fill-inner {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }
        .progress-high { background: linear-gradient(to right, #dc2626, #b91c1c); }
        .progress-medium { background: linear-gradient(to right, #eab308, #ca8a04); }
        .progress-low { background: linear-gradient(to right, #16a34a, #15803d); }
        .equipamiento-section {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
        }
        .equipamiento-section .label {
            font-size: 8px;
            color: #64748b;
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }
        .equipamiento-section .text {
            font-size: 9px;
            color: #333;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #64748b;
        }
        .summary-section {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
        }
        .summary-section h3 {
            color: #5b21b6;
            font-size: 11px;
            margin-bottom: 8px;
        }
        .legend {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .legend-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            font-size: 8px;
        }
        .legend-color {
            display: inline-block;
            width: 15px;
            height: 10px;
            border-radius: 3px;
            margin-right: 4px;
        }
        .legend-color.high { background: #dc2626; }
        .legend-color.medium { background: #eab308; }
        .legend-color.low { background: #16a34a; }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>REPORTE DE OCUPACIÓN DE AULAS</h1>
        <h2>Sistema de Gestión Académica - FICCT</h2>
    </div>

    <!-- Información del Reporte -->
    <div class="info-box">
        <h3>Información del Reporte</h3>
        <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        <p><strong>Gestión Académica:</strong> {{ now()->year }}</p>
        @if($filtroAula || $filtroDia)
            <p><strong>Filtros Aplicados:</strong>
                @if($filtroAula) Aula #{{ $filtroAula }} @endif
                @if($filtroDia) @if($filtroAula) | @endif Día: {{ $filtroDia }} @endif
            </p>
        @endif
        <p><strong>Generado por:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</p>
    </div>

    <!-- Estadísticas Resumidas -->
    <div class="stats">
        <div class="stat-item">
            <span class="number">{{ $estadisticas['total_aulas'] }}</span>
            <span class="label">Total de Aulas</span>
        </div>
        <div class="stat-item">
            <span class="number">{{ $estadisticas['aulas_ocupadas'] }}</span>
            <span class="label">Aulas con Horarios Asignados</span>
        </div>
    </div>

    <!-- Leyenda de Colores -->
    <div class="summary-section">
        <h3>Leyenda de Ocupación</h3>
        <div class="legend">
            <div class="legend-item">
                <span class="legend-color low"></span>
                <span>Baja (0-39%)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color medium"></span>
                <span>Media (40-69%)</span>
            </div>
            <div class="legend-item">
                <span class="legend-color high"></span>
                <span>Alta (70-100%)</span>
            </div>
        </div>
    </div>

    <!-- Título de Sección -->
    <h3 style="color: #5b21b6; margin: 15px 0 10px 0; font-size: 12px;">Detalle de Ocupación por Aula</h3>

    <!-- Cards de Aulas -->
    @forelse($ocupacionAulas as $item)
        @php
            $porcentaje = round($item['porcentaje_ocupacion']);
            $colorClass = $porcentaje >= 70 ? 'high' : ($porcentaje >= 40 ? 'medium' : 'low');
        @endphp
        <div class="aula-card">
            <div class="aula-header">
                <div class="aula-title">
                    {{ $item['aula']->nombre }}
                    <span class="aula-subtitle">
                        - {{ $item['aula']->tipo }} (Piso {{ $item['aula']->piso }})
                    </span>
                </div>
                <div class="aula-percent percent-{{ $colorClass }}">
                    {{ $porcentaje }}%
                </div>
            </div>

            <div class="aula-info">
                <div class="info-item">
                    <span class="info-label">Total Horarios</span>
                    <span class="info-value">{{ $item['total_horarios'] }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Horas Semanales</span>
                    <span class="info-value">{{ $item['horas_semanales'] }} hrs</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Capacidad</span>
                    <span class="info-value">{{ $item['aula']->capacidad }} personas</span>
                </div>
            </div>

            <div class="progress-bar">
                <div class="progress-fill progress-{{ $colorClass }}" 
                     style="width: {{ min($item['porcentaje_ocupacion'], 100) }}%">
                    <div class="progress-fill-inner">
                        {{ $porcentaje }}% ocupado
                    </div>
                </div>
            </div>

            @if($item['aula']->equipamiento)
            <div class="equipamiento-section">
                <span class="label">EQUIPAMIENTO:</span>
                <span class="text">{{ $item['aula']->equipamiento }}</span>
            </div>
            @endif
        </div>
    @empty
        <div style="text-align: center; padding: 40px; color: #64748b; background: #f8fafc; border-radius: 8px;">
            <p style="font-size: 12px; margin-bottom: 5px;">No se encontraron aulas</p>
            <p style="font-size: 9px;">Intenta ajustar los filtros de búsqueda</p>
        </div>
    @endforelse

    <!-- Footer -->
    <div class="footer">
        Sistema de Gestión Académica - Facultad de Ciencias y Tecnología
        <br>
        Universidad Autónoma Gabriel René Moreno
        <br>
        Este documento es de carácter oficial y confidencial
    </div>
</body>
</html>