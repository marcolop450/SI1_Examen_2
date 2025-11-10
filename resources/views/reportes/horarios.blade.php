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
                    📅 Reporte de Horarios
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('reportes.exportar.horarios-excel', request()->all()) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('reportes.exportar.horarios-pdf', request()->all()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
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
                <form method="GET" action="{{ route('reportes.horarios') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Docente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Docente</label>
                        <select name="docente" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
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
                        <select name="grupo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Todos</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}" {{ $filtroGrupo == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Día -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Día</label>
                        <select name="dia" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Todos</option>
                            @foreach($diasSemana as $dia)
                                <option value="{{ $dia }}" {{ $filtroDia == $dia ? 'selected' : '' }}>
                                    {{ $dia }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-end space-x-3">
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar
                        </button>
                        <a href="{{ route('reportes.horarios') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <!-- Total Horarios -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Horarios</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['total_horarios'] }}</h3>
                </div>

                <!-- Presenciales -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-100 text-sm font-medium mb-1">Presenciales</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['horarios_presenciales'] }}</h3>
                </div>

                <!-- Virtuales -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Virtuales</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['horarios_virtuales'] }}</h3>
                </div>

                <!-- Docentes -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-yellow-100 text-sm font-medium mb-1">Docentes</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['docentes_con_horarios'] }}</h3>
                </div>

                <!-- Grupos -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Grupos</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['grupos_con_horarios'] }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Distribución por Día -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Distribución por Día de la Semana</h3>
                    <div class="space-y-3">
                        @foreach($diasSemana as $dia)
                            @php
                                $total = $distribucionPorDia[$dia] ?? 0;
                                $maxValue = $distribucionPorDia->max() ?: 1;
                                $porcentaje = ($total / $maxValue) * 100;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $dia }}</span>
                                    <span class="text-sm font-bold text-gray-800">{{ $total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-full rounded-full flex items-center justify-end pr-2" 
                                         style="width: {{ $porcentaje }}%">
                                        @if($porcentaje > 15)
                                            <span class="text-white text-xs font-semibold">{{ $total }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Docentes con Más Horas -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">👨‍🏫 Top 10 Docentes con Más Horas</h3>
                    <div class="space-y-3">
                        @forelse($docentesConMasHoras as $index => $docente)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}
                                </p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        @php
                                            $porcentajeCarga = $docente->carga_horaria_maxima > 0 
                                                ? ($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100 
                                                : 0;
                                        @endphp
                                        <div class="h-2 rounded-full {{ $porcentajeCarga >= 90 ? 'bg-red-500' : ($porcentajeCarga >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                             style="width: {{ $porcentajeCarga }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 w-16 text-right">{{ round($porcentajeCarga) }}%</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-blue-600">{{ $docente->carga_horaria_actual }}</p>
                                <p class="text-xs text-gray-500">/ {{ $docente->carga_horaria_maxima }} hrs</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-8">No hay datos disponibles</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Aulas Más Utilizadas -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🏫 Top 10 Aulas Más Utilizadas</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @forelse($aulasMasUsadas as $aula)
                    <div class="bg-gradient-to-br from-purple-50 to-white border-2 border-purple-200 rounded-xl p-4 text-center hover:shadow-lg transition-shadow">
                        <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-800">{{ $aula->aula->nombre }}</h4>
                        <p class="text-xs text-gray-600 mt-1">{{ $aula->aula->tipo }}</p>
                        <div class="mt-2 bg-purple-100 rounded-full px-2 py-1 inline-block">
                            <span class="text-purple-700 font-bold text-sm">{{ $aula->total }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-gray-500 py-8">No hay datos disponibles</div>
                    @endforelse
                </div>
            </div>

            <!-- Tabla de Horarios Detallada -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">📋 Detalle de Horarios</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Día</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aula/Modalidad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($horarios as $horario)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $horario->dia }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_final, 0, 5) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $horario->docente->usuario->nombre }} {{ $horario->docente->usuario->apellido }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $horario->materia->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $horario->grupo->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($horario->es_virtual)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            💻 Virtual
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            🏫 {{ $horario->aula->nombre }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="font-medium">No se encontraron horarios con los filtros aplicados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($horarios->hasPages())
                <div class="p-6 border-t border-gray-200">
                    {{ $horarios->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>