<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Centro de Reportes Académicos
            </h2>
            <div class="flex items-center space-x-2">
                <div class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm text-gray-600">{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- KPIs Principales -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Docentes -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Total Docentes</p>
                            <h3 class="text-4xl font-bold">{{ $estadisticas['total_docentes'] }}</h3>
                        </div>
                        <div class="bg-white/20 rounded-full p-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <div class="bg-white/20 rounded-full px-3 py-1">
                            <span class="font-semibold">{{ $estadisticas['docentes_activos_hoy'] }}</span> activos hoy
                        </div>
                    </div>
                </div>

                <!-- Total Horarios -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Total Horarios</p>
                            <h3 class="text-4xl font-bold">{{ $estadisticas['total_horarios'] }}</h3>
                        </div>
                        <div class="bg-white/20 rounded-full p-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <div class="bg-white/20 rounded-full px-3 py-1">
                            {{ $estadisticas['total_grupos'] }} grupos
                        </div>
                    </div>
                </div>

                <!-- Asistencias del Mes -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Asistencias Mes</p>
                            <h3 class="text-4xl font-bold">{{ $estadisticas['asistencias_mes'] }}</h3>
                        </div>
                        <div class="bg-white/20 rounded-full p-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <div class="bg-white/20 rounded-full px-3 py-1">
                            {{ $estadisticas['promedio_puntualidad'] }}% puntualidad
                        </div>
                    </div>
                </div>

                <!-- Total Aulas -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium mb-1">Total Aulas</p>
                            <h3 class="text-4xl font-bold">{{ $estadisticas['total_aulas'] }}</h3>
                        </div>
                        <div class="bg-white/20 rounded-full p-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <div class="bg-white/20 rounded-full px-3 py-1">
                            {{ $estadisticas['total_materias'] }} materias
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos a Reportes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Dashboard Tiempo Real -->
                <a href="{{ route('reportes.dashboard-tiempo-real') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-red-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-red-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-4 group-hover:from-red-200 group-hover:to-red-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">EN VIVO</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-red-700 transition-colors">Dashboard en Tiempo Real</h3>
                    <p class="text-sm text-gray-600 mb-4">Monitoreo de clases en curso y próximas actividades</p>
                    <div class="flex items-center text-red-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Ver ahora</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                <!-- Reporte de Horarios -->
                <a href="{{ route('reportes.horarios') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 group-hover:from-blue-200 group-hover:to-blue-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-700 transition-colors">Reporte de Horarios</h3>
                    <p class="text-sm text-gray-600 mb-4">Análisis de carga académica y distribución</p>
                    <div class="flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Ver reporte</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                <!-- Reporte de Asistencias -->
                <a href="{{ route('reportes.asistencias') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 group-hover:from-green-200 group-hover:to-green-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-700 transition-colors">Reporte de Asistencias</h3>
                    <p class="text-sm text-gray-600 mb-4">Estadísticas de puntualidad y asistencia docente</p>
                    <div class="flex items-center text-green-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Ver reporte</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                <!-- Reporte de Aulas -->
                <a href="{{ route('reportes.aulas') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-purple-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-4 group-hover:from-purple-200 group-hover:to-purple-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors">Reporte de Aulas</h3>
                    <p class="text-sm text-gray-600 mb-4">Ocupación y disponibilidad de espacios físicos</p>
                    <div class="flex items-center text-purple-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Ver reporte</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                <!-- Aulas Disponibles -->
                <a href="{{ route('reportes.aulas-disponibles') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-indigo-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-indigo-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl p-4 group-hover:from-indigo-200 group-hover:to-indigo-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-700 transition-colors">Buscar Aulas Disponibles</h3>
                    <p class="text-sm text-gray-600 mb-4">Consulta disponibilidad por franja horaria</p>
                    <div class="flex items-center text-indigo-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Buscar ahora</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>

                <!-- Carga Horaria Docente -->
                <a href="{{ route('reportes.carga-horaria-docente') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-yellow-50 hover:to-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 border-2 border-gray-100 hover:border-yellow-300 transform hover:-translate-y-2">
                    <div class="flex items-start justify-between mb-4">
                        <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-xl p-4 group-hover:from-yellow-200 group-hover:to-yellow-100 transition-colors shadow-md">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-yellow-700 transition-colors">Carga Horaria por Docente</h3>
                    <p class="text-sm text-gray-600 mb-4">Detalle individual de horarios asignados</p>
                    <div class="flex items-center text-yellow-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Consultar</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Gráficos y Estadísticas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Tendencia de Asistencias -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">📈 Tendencia de Asistencias (Últimos 7 días)</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach($tendenciaAsistencias as $dia)
                        <div class="flex items-center">
                            <div class="w-24 text-sm font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($dia->dia)->format('d/m') }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 bg-gray-200 rounded-full h-6 overflow-hidden">
                                        @php
                                            $porcentajeATiempo = $dia->total > 0 ? ($dia->a_tiempo / $dia->total) * 100 : 0;
                                            $porcentajeTardanzas = $dia->total > 0 ? ($dia->tardanzas / $dia->total) * 100 : 0;
                                        @endphp
                                        <div class="h-full flex">
                                            <div class="bg-green-500 h-full" style="width: {{ $porcentajeATiempo }}%"></div>
                                            <div class="bg-yellow-500 h-full" style="width: {{ $porcentajeTardanzas }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 w-12 text-right">{{ $dia->total }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 flex items-center space-x-4 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">A tiempo</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                            <span class="text-gray-600">Tardanzas</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-300 rounded-full mr-2"></div>
                            <span class="text-gray-600">Faltas</span>
                        </div>
                    </div>
                </div>

                <!-- Top Docentes Más Puntuales -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">🏆 Top 5 Docentes Más Puntuales del Mes</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($topDocentes as $index => $item)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if($index == 0)
                                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        🥇
                                    </div>
                                @elseif($index == 1)
                                    <div class="w-10 h-10 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        🥈
                                    </div>
                                @elseif($index == 2)
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        🥉
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $item['docente']->usuario->nombre }} {{ $item['docente']->usuario->apellido }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $item['a_tiempo'] }} de {{ $item['total'] }} asistencias a tiempo
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl font-bold text-green-600">{{ $item['porcentaje'] }}%</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Aulas Más Utilizadas -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800">🏫 Top 5 Aulas Más Utilizadas</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @foreach($topAulas as $aula)
                    <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl p-5 border-2 border-purple-200 hover:shadow-lg transition-shadow">
                        <div class="text-center">
                            <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-800 text-lg">{{ $aula->aula->nombre }}</h4>
                            <p class="text-sm text-gray-600 mt-1">Edificio {{ $aula->aula->edificio }}</p>
                            <div class="mt-3 bg-purple-100 rounded-full px-3 py-1 inline-block">
                                <span class="text-purple-700 font-bold text-sm">{{ $aula->total }} horarios</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>