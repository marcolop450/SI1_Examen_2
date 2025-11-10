<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('reportes.carga-horaria-docente') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    👨‍🏫 Carga Horaria - {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir
                </button>
                <a href="{{ route('reportes.exportar.carga-horaria-excel', $docente->registro) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('reportes.exportar.carga-horaria-pdf', $docente->registro) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
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

            <!-- Información del Docente -->
            <div class="bg-gradient-to-r from-yellow-500 via-yellow-600 to-orange-500 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="bg-white/20 backdrop-blur-sm rounded-2xl w-24 h-24 flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                            {{ strtoupper(substr($docente->usuario->nombre, 0, 1)) }}{{ strtoupper(substr($docente->usuario->apellido, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold mb-2">
                                {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}
                            </h3>
                            <div class="space-y-1 text-yellow-100">
                                <p><span class="font-semibold">Registro:</span> {{ $docente->registro }}</p>
                                <p><span class="font-semibold">Carrera:</span> {{ $docente->carrera }}</p>
                                <p><span class="font-semibold">Especialidad:</span> {{ $docente->especialidad }}</p>
                                <p><span class="font-semibold">Email:</span> {{ $docente->usuario->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-semibold">
                            Gestión {{ now()->year }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Resumen de Carga Horaria -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Horas Semanales -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Horas Semanales</p>
                    <h3 class="text-4xl font-bold">{{ $totalHorasSemanales }}</h3>
                </div>

                <!-- Carga Actual -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-100 text-sm font-medium mb-1">Carga Actual</p>
                    <h3 class="text-4xl font-bold">{{ $docente->carga_horaria_actual }}</h3>
                    <p class="text-green-100 text-xs mt-1">de {{ $docente->carga_horaria_maxima }} hrs</p>
                </div>

                <!-- Porcentaje de Carga -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Porcentaje</p>
                    @php
                        $porcentaje = $docente->carga_horaria_maxima > 0 
                            ? round(($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100, 2) 
                            : 0;
                    @endphp
                    <h3 class="text-4xl font-bold">{{ $porcentaje }}%</h3>
                </div>

                <!-- Total de Clases -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-orange-100 text-sm font-medium mb-1">Total Clases</p>
                    <h3 class="text-4xl font-bold">{{ $horarios->count() }}</h3>
                </div>
            </div>

            <!-- Horas por Día de la Semana -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Distribución Horaria Semanal</h3>
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                        @php
                            $horas = $horasPorDia[$dia] ?? 0;
                        @endphp
                        <div class="bg-gradient-to-br from-blue-50 to-white border-2 border-blue-200 rounded-xl p-4 text-center">
                            <p class="text-sm font-semibold text-gray-700 mb-2">{{ $dia }}</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $horas }}</p>
                            <p class="text-xs text-gray-500 mt-1">horas</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tabla de Horarios -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">📅 Horario Detallado</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Día</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
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
                                    {{ $horario->materia->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $horario->grupo->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="font-medium">Este docente no tiene horarios asignados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Estadísticas de Asistencia del Mes -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Asistencia del Mes ({{ now()->format('F Y') }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Total -->
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-600 mb-1">Total</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $estadisticasAsistencia['total'] }}</p>
                    </div>
                    <!-- A Tiempo -->
                    <div class="bg-green-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-green-700 mb-1">A Tiempo</p>
                        <p class="text-3xl font-bold text-green-600">{{ $estadisticasAsistencia['a_tiempo'] }}</p>
                    </div>
                    <!-- Tardanzas -->
                    <div class="bg-yellow-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-yellow-700 mb-1">Tardanzas</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $estadisticasAsistencia['tardanzas'] }}</p>
                    </div>
                    <!-- Faltas -->
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <p class="text-sm text-red-700 mb-1">Faltas</p>
                        <p class="text-3xl font-bold text-red-600">{{ $estadisticasAsistencia['faltas'] }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>