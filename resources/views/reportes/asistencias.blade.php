<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('reportes.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    📊 Reporte de Asistencias
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('reportes.exportar.asistencias-excel', request()->all()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('reportes.exportar.asistencias-pdf', request()->all()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🔍 Filtros de Búsqueda</h3>
                <form method="GET" action="{{ route('reportes.asistencias') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Fecha Inicio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ $fechaInicio }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    </div>

                    <!-- Fecha Fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                        <input type="date" name="fecha_fin" value="{{ $fechaFin }}" 
                               class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    </div>

                    <!-- Docente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Docente</label>
                        <select name="docente" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            <option value="">Todos</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->registro }}" {{ $filtroDocente == $docente->registro ? 'selected' : '' }}>
                                    {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grupo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grupo</label>
                        <select name="grupo" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            <option value="">Todos</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $filtroGrupo == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <select name="estado" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                            <option value="">Todos</option>
                            <option value="A tiempo" {{ $filtroEstado == 'A tiempo' ? 'selected' : '' }}>A tiempo</option>
                            <option value="Tardanza" {{ $filtroEstado == 'Tardanza' ? 'selected' : '' }}>Tardanza</option>
                            <option value="Falta" {{ $filtroEstado == 'Falta' ? 'selected' : '' }}>Falta</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="md:col-span-5 flex items-center space-x-3">
                        <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar
                        </button>
                        <a href="{{ route('reportes.asistencias') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- KPIs del Período -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Asistencias -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Registros</p>
                    <h3 class="text-4xl font-bold">{{ number_format($estadisticas['total']) }}</h3>
                </div>

                <!-- A Tiempo -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-100 text-sm font-medium mb-1">A Tiempo</p>
                    <div class="flex items-baseline space-x-2">
                        <h3 class="text-4xl font-bold">{{ number_format($estadisticas['a_tiempo']) }}</h3>
                        <span class="text-xl font-semibold">{{ $estadisticas['porcentaje_a_tiempo'] }}%</span>
                    </div>
                </div>

                <!-- Tardanzas -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Tardanzas</p>
                    <div class="flex items-baseline space-x-2">
                        <h3 class="text-4xl font-bold">{{ number_format($estadisticas['tardanzas']) }}</h3>
                        <span class="text-xl font-semibold">{{ $estadisticas['porcentaje_tardanzas'] }}%</span>
                    </div>
                </div>

                <!-- Faltas -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-red-100 text-sm font-medium mb-1">Faltas</p>
                    <div class="flex items-baseline space-x-2">
                        <h3 class="text-4xl font-bold">{{ number_format($estadisticas['faltas']) }}</h3>
                        <span class="text-xl font-semibold">{{ $estadisticas['porcentaje_faltas'] }}%</span>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Ranking de Docentes -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">🏆 Ranking de Puntualidad</h3>
                    <div class="space-y-3">
                        @forelse($rankingDocentes as $index => $item)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-8 text-center">
                                @if($index == 0)
                                    <span class="text-2xl">🥇</span>
                                @elseif($index == 1)
                                    <span class="text-2xl">🥈</span>
                                @elseif($index == 2)
                                    <span class="text-2xl">🥉</span>
                                @else
                                    <span class="text-gray-600 font-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $item['docente']->usuario->nombre }} {{ $item['docente']->usuario->apellido }}
                                </p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" 
                                             style="width: {{ $item['porcentaje_puntualidad'] }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 w-12 text-right">{{ $item['porcentaje_puntualidad'] }}%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-green-600">{{ $item['a_tiempo'] }}</p>
                                <p class="text-xs text-gray-500">de {{ $item['total'] }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-8">No hay datos disponibles</p>
                        @endforelse
                    </div>
                </div>

                <!-- Distribución por Día -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📅 Asistencias por Día de la Semana</h3>
                    <div class="space-y-3">
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            @php
                                $datos = $asistenciasPorDia[$dia] ?? ['total' => 0, 'a_tiempo' => 0, 'tardanzas' => 0, 'faltas' => 0];
                                $porcentajeATiempo = $datos['total'] > 0 ? ($datos['a_tiempo'] / $datos['total']) * 100 : 0;
                                $porcentajeTardanzas = $datos['total'] > 0 ? ($datos['tardanzas'] / $datos['total']) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $dia }}</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $datos['total'] }}</span>
                                </div>
                                <div class="flex h-6 rounded-full overflow-hidden bg-gray-200">
                                    <div class="bg-green-500" style="width: {{ $porcentajeATiempo }}%" title="A tiempo: {{ $datos['a_tiempo'] }}"></div>
                                    <div class="bg-yellow-500" style="width: {{ $porcentajeTardanzas }}%" title="Tardanzas: {{ $datos['tardanzas'] }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 flex items-center justify-center space-x-4 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                            <span class="text-gray-600">A tiempo</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></div>
                            <span class="text-gray-600">Tardanzas</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-300 rounded-full mr-1"></div>
                            <span class="text-gray-600">Faltas</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Asistencias -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">📋 Detalle de Asistencias</h3>
                    <p class="text-sm text-gray-600 mt-1">Período: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora Llegada</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($asistencias as $asistencia)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $asistencia->docente->usuario->nombre }} {{ $asistencia->docente->usuario->apellido }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $asistencia->horario->materia->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $asistencia->horario->grupo->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($asistencia->hora_llegada)->format('H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asistencia->estado == 'A tiempo')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            ✓ A tiempo
                                        </span>
                                    @elseif($asistencia->estado == 'Tardanza')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            ⏱ Tardanza
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            ✗ Falta
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-medium">No se encontraron asistencias con los filtros aplicados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($asistencias->hasPages())
                <div class="p-6 border-t border-gray-200">
                    {{ $asistencias->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>