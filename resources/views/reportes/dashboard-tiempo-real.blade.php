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
                    ⚡ Dashboard en Tiempo Real
                </h2>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center space-x-2 bg-red-100 px-4 py-2 rounded-full">
                    <div class="h-3 w-3 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-red-700">EN VIVO</span>
                </div>
                <span class="text-sm text-gray-600">{{ now()->format('H:i:s') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- KPIs del Día -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
                <!-- Clases en Curso -->
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-red-100 text-xs font-medium mb-1">Clases en Curso</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['clases_en_curso'] }}</h3>
                </div>

                <!-- Próximas Clases -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-blue-100 text-xs font-medium mb-1">Próximas (2h)</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['proximas_clases'] }}</h3>
                </div>

                <!-- Asistencias Hoy -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-100 text-xs font-medium mb-1">A Tiempo Hoy</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['asistencias_a_tiempo'] }}</h3>
                </div>

                <!-- Tardanzas Hoy -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-yellow-100 text-xs font-medium mb-1">Tardanzas Hoy</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['tardanzas_hoy'] }}</h3>
                </div>

                <!-- Alertas -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-5 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="bg-white/20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-orange-100 text-xs font-medium mb-1">Sin Asistencia</p>
                    <h3 class="text-4xl font-bold">{{ $estadisticas['alertas'] }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Clases en Curso AHORA -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Clases en Curso</h3>
                            </div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">{{ $clasesEnCurso->count() }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($clasesEnCurso->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No hay clases en curso en este momento</p>
                                <p class="text-sm text-gray-400 mt-1">{{ $diaActual }} - {{ now()->format('H:i') }}</p>
                            </div>
                        @else
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($clasesEnCurso as $clase)
                                <div class="bg-gradient-to-r from-red-50 to-white border-l-4 border-red-500 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800 text-lg">{{ $clase->materia->nombre }}</h4>
                                            <p class="text-sm text-gray-600">{{ $clase->grupo->nombre }}</p>
                                        </div>
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $clase->hora_inicio }} - {{ $clase->hora_final }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-3">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $clase->docente->usuario->nombre }} {{ $clase->docente->usuario->apellido }}</span>
                                        </div>
                                        @if(!$clase->es_virtual)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span>{{ $clase->aula->nombre }}</span>
                                        </div>
                                        @else
                                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs font-semibold">Virtual</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Próximas Clases (2 horas) -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Próximas Clases</h3>
                            </div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">{{ $proximasClases->count() }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($proximasClases->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No hay clases próximas en las siguientes 2 horas</p>
                            </div>
                        @else
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($proximasClases as $clase)
                                <div class="bg-gradient-to-r from-blue-50 to-white border-l-4 border-blue-500 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800">{{ $clase->materia->nombre }}</h4>
                                            <p class="text-sm text-gray-600">{{ $clase->grupo->nombre }}</p>
                                        </div>
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $clase->hora_inicio }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-3">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $clase->docente->usuario->nombre }} {{ $clase->docente->usuario->apellido }}</span>
                                        </div>
                                        @if(!$clase->es_virtual)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span>{{ $clase->aula->nombre }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Asistencias Registradas Hoy y Alertas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- Últimas Asistencias -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Asistencias de Hoy</h3>
                            </div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">{{ $asistenciasHoy->count() }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($asistenciasHoy->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No hay asistencias registradas hoy</p>
                            </div>
                        @else
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($asistenciasHoy->take(10) as $asistencia)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-3 flex-1">
                                        <div class="flex-shrink-0">
                                            @if($asistencia->estado == 'A tiempo')
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            @elseif($asistencia->estado == 'Tardanza')
                                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-800 truncate">
                                                {{ $asistencia->docente->usuario->nombre }} {{ $asistencia->docente->usuario->apellido }}
                                            </p>
                                            <p class="text-sm text-gray-600 truncate">{{ $asistencia->horario->materia->nombre }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <p class="text-sm font-semibold text-gray-700">{{ \Carbon\Carbon::parse($asistencia->hora_llegada)->format('H:i') }}</p>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            @if($asistencia->estado == 'A tiempo') bg-green-100 text-green-700
                                            @elseif($asistencia->estado == 'Tardanza') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                            {{ $asistencia->estado }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Alertas: Clases sin Asistencia -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Alertas</h3>
                            </div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">{{ $alertasSinAsistencia->count() }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($alertasSinAsistencia->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">¡Todo en orden!</p>
                                <p class="text-sm text-gray-400 mt-1">No hay clases sin asistencia registrada</p>
                            </div>
                        @else
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($alertasSinAsistencia as $clase)
                                <div class="bg-gradient-to-r from-orange-50 to-white border-l-4 border-orange-500 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800">{{ $clase->materia->nombre }}</h4>
                                            <p class="text-sm text-gray-600">{{ $clase->grupo->nombre }}</p>
                                        </div>
                                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">
                                            Sin asistencia
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mt-3">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $clase->docente->usuario->nombre }} {{ $clase->docente->usuario->apellido }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $clase->hora_inicio }} - {{ $clase->hora_final }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botón de Recarga Automática -->
            <div class="mt-8 text-center">
                <button onclick="location.reload()" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Actualizar Datos
                </button>
                <p class="text-sm text-gray-500 mt-2">La página se actualiza automáticamente cada 30 segundos</p>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-reload cada 30 segundos
        setTimeout(function(){
            location.reload();
        }, 30000);
    </script>
    @endpush
</x-app-layout>