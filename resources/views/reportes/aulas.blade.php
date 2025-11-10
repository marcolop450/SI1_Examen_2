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
                    🏫 Reporte de Aulas
                </h2>
            </div>           
                <div class="flex items-center space-x-2">
                    <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Imprimir
                    </button>
                    <a href="{{ route('reportes.exportar.aulas-excel') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel
                    </a>
                    <a href="{{ route('reportes.exportar.aulas-pdf', request()->all()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
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
                <form method="GET" action="{{ route('reportes.aulas') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Aula -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Aula</label>
                        <select name="aula" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
                            <option value="">Todas</option>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}" {{ $filtroAula == $aula->id ? 'selected' : '' }}>
                                    {{ $aula->nombre }} - {{ $aula->tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Día -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Día</label>
                        <select name="dia" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200">
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
                        <button type="submit" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg transition-all">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar
                        </button>
                        <a href="{{ route('reportes.aulas') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Total Aulas -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Aulas</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['total_aulas'] }}</h3>
                </div>

                <!-- Aulas Ocupadas -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Aulas con Horarios</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['aulas_ocupadas'] }}</h3>
                </div>
            </div>

            <!-- Aulas Libres por Día -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Aulas Libres por Día</h3>
                <div class="space-y-3">
                    @foreach($diasSemana as $dia)
                        @php
                            $libres = $aulasLibresPorDia[$dia] ?? 0;
                            $ocupadas = $estadisticas['total_aulas'] - $libres;
                            $porcentajeLibres = $estadisticas['total_aulas'] > 0 
                                ? ($libres / $estadisticas['total_aulas']) * 100 
                                : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $dia }}</span>
                                <span class="text-sm text-gray-600">
                                    <span class="font-bold text-green-600">{{ $libres }}</span> libres / 
                                    <span class="font-bold text-red-600">{{ $ocupadas }}</span> ocupadas
                                </span>
                            </div>
                            <div class="flex h-6 rounded-full overflow-hidden bg-gray-200">
                                <div class="bg-green-500" style="width: {{ $porcentajeLibres }}%" title="Libres: {{ $libres }}"></div>
                                <div class="bg-red-500" style="width: {{ 100 - $porcentajeLibres }}%" title="Ocupadas: {{ $ocupadas }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-center space-x-4 text-xs">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                        <span class="text-gray-600">Aulas libres</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                        <span class="text-gray-600">Aulas ocupadas</span>
                    </div>
                </div>
            </div>

            <!-- Ocupación Detallada por Aula -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">📋 Ocupación por Aula</h3>
                    <p class="text-sm text-gray-600 mt-1">Análisis de uso de cada espacio físico</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($ocupacionAulas as $item)
                        <div class="bg-gradient-to-br from-purple-50 to-white border-2 border-purple-200 rounded-xl p-6 hover:shadow-xl transition-all hover:-translate-y-1">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="bg-purple-100 rounded-lg p-3">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                @php
                                    $color = $item['porcentaje_ocupacion'] >= 70 ? 'red' : ($item['porcentaje_ocupacion'] >= 40 ? 'yellow' : 'green');
                                @endphp
                                <span class="bg-{{ $color }}-100 text-{{ $color }}-700 text-xs font-bold px-3 py-1 rounded-full">
                                    {{ round($item['porcentaje_ocupacion']) }}%
                                </span>
                            </div>

                            <!-- Información del Aula -->
                            <h4 class="font-bold text-gray-800 text-xl mb-1">{{ $item['aula']->nombre }}</h4>
                            <p class="text-sm text-gray-600 mb-4">{{ $item['aula']->tipo }} - Piso {{ $item['aula']->piso }}</p>

                            <!-- Estadísticas -->
                            <div class="space-y-3 mb-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Total horarios:</span>
                                    <span class="font-bold text-gray-800">{{ $item['total_horarios'] }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Horas semanales:</span>
                                    <span class="font-bold text-gray-800">{{ $item['horas_semanales'] }} hrs</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Capacidad:</span>
                                    <span class="font-bold text-gray-800">{{ $item['aula']->capacidad }} personas</span>
                                </div>
                            </div>

                            <!-- Barra de Ocupación -->
                            <div class="mb-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-600 font-medium">Ocupación</span>
                                    <span class="text-xs text-gray-600 font-bold">{{ round($item['porcentaje_ocupacion']) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r {{ $color === 'red' ? 'from-red-400 to-red-600' : ($color === 'yellow' ? 'from-yellow-400 to-yellow-600' : 'from-green-400 to-green-600') }}" 
                                         style="width: {{ $item['porcentaje_ocupacion'] }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- Equipamiento (si existe) -->
                            @if($item['aula']->equipamiento)
                            <div class="pt-3 border-t border-purple-100">
                                <p class="text-xs text-gray-500 font-medium mb-1">Equipamiento:</p>
                                <p class="text-xs text-gray-600">{{ Str::limit($item['aula']->equipamiento, 60) }}</p>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No hay aulas registradas</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>