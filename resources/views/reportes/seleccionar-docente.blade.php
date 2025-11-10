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
                    👨‍🏫 Carga Horaria por Docente
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Instrucción -->
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-8 mb-8 text-white text-center">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-2xl font-bold mb-2">Selecciona un Docente</h3>
                <p class="text-yellow-100">Consulta la carga horaria detallada y estadísticas de asistencia</p>
            </div>

            <!-- Lista de Docentes -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">📋 Lista de Docentes Activos</h3>
                    <p class="text-sm text-gray-600 mt-1">Haz clic en un docente para ver su carga horaria completa</p>
                </div>
                <div class="divide-y divide-gray-200" id="listaDocentes">
                    @forelse($docentes as $docente)
                    <a href="{{ route('reportes.carga-horaria-docente', $docente->registro) }}" 
                       class="docente-item block hover:bg-yellow-50 transition-colors p-6"
                       data-nombre="{{ strtolower($docente->usuario->nombre) }}"
                       data-apellido="{{ strtolower($docente->usuario->apellido) }}"
                       data-registro="{{ $docente->registro }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 flex-1">
                                <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full w-12 h-12 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ strtoupper(substr($docente->usuario->nombre, 0, 1)) }}{{ strtoupper(substr($docente->usuario->apellido, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-gray-800 text-lg">
                                        {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}
                                    </h4>
                                    <p class="text-sm text-gray-600">Registro: {{ $docente->registro }} | {{ $docente->especialidad }}</p>
                                    <div class="mt-2 flex items-center space-x-2">
                                        <div class="flex-1 max-w-xs bg-gray-200 rounded-full h-2">
                                            @php
                                                $porcentaje = $docente->carga_horaria_maxima > 0 
                                                    ? ($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100 
                                                    : 0;
                                            @endphp
                                            <div class="h-2 rounded-full {{ $porcentaje >= 90 ? 'bg-red-500' : ($porcentaje >= 70 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                                 style="width: {{ $porcentaje }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600 font-medium">
                                            {{ $docente->carga_horaria_actual }}/{{ $docente->carga_horaria_maxima }} hrs
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="font-medium">No hay docentes activos</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>