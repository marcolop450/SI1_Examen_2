<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Consulta de Asistencias
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver al Panel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Estadísticas Globales -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center border-l-4 border-blue-500">
                        <svg class="mx-auto h-10 w-10 text-blue-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="text-2xl font-bold text-gray-800">{{ $estadisticas['total'] }}</h5>
                        <small class="text-gray-600">Total Registros</small>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center border-l-4 border-green-500">
                        <svg class="mx-auto h-10 w-10 text-green-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="text-2xl font-bold text-gray-800">{{ $estadisticas['a_tiempo'] }}</h5>
                        <small class="text-gray-600">A Tiempo</small>
                        @if($estadisticas['total'] > 0)
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ ($estadisticas['a_tiempo']/$estadisticas['total'])*100 }}%"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center border-l-4 border-yellow-500">
                        <svg class="mx-auto h-10 w-10 text-yellow-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="text-2xl font-bold text-gray-800">{{ $estadisticas['tardanzas'] }}</h5>
                        <small class="text-gray-600">Tardanzas</small>
                        @if($estadisticas['total'] > 0)
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-yellow-500 h-1.5 rounded-full" style="width: {{ ($estadisticas['tardanzas']/$estadisticas['total'])*100 }}%"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center border-l-4 border-red-500">
                        <svg class="mx-auto h-10 w-10 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <h5 class="text-2xl font-bold text-gray-800">{{ $estadisticas['faltas'] }}</h5>
                        <small class="text-gray-600">Faltas</small>
                        @if($estadisticas['total'] > 0)
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ ($estadisticas['faltas']/$estadisticas['total'])*100 }}%"></div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Filtros Avanzados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                    <h6 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filtros de Búsqueda
                    </h6>
                    <form method="GET" action="{{ route('asistencias.consulta-autoridad') }}">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_inicio') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" value="{{ request('fecha_fin') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Docente</label>
                                <select name="id_docente" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Todos</option>
                                    @foreach($docentes as $docente)
                                    <option value="{{ $docente->registro }}" {{ request('id_docente') == $docente->registro ? 'selected' : '' }}>
                                        {{ $docente->usuario->nombre ?? '' }} {{ $docente->usuario->apellido ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Grupo</label>
                                <select name="id_grupo" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Todos</option>
                                    @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ request('id_grupo') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select name="estado" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Todos</option>
                                    <option value="A tiempo" {{ request('estado') == 'A tiempo' ? 'selected' : '' }}>A tiempo</option>
                                    <option value="Tardanza" {{ request('estado') == 'Tardanza' ? 'selected' : '' }}>Tardanza</option>
                                    <option value="Falta" {{ request('estado') == 'Falta' ? 'selected' : '' }}>Falta</option>
                                </select>
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Buscar
                                </button>
                                <a href="{{ route('asistencias.consulta-autoridad') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Resultados -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h6 class="font-semibold text-gray-800">Registros de Asistencia</h6>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $asistencias->total() }} registros
                        </span>
                    </div>
                </div>

                @if($asistencias->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h5 class="mt-3 text-lg font-medium text-gray-500">No se encontraron registros</h5>
                        <p class="text-gray-400">Intente ajustar los filtros de búsqueda</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Docente</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Materia</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Grupo</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aula</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Observaciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($asistencias as $asistencia)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $asistencia->fecha->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $asistencia->fecha->locale('es')->isoFormat('dddd') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($asistencia->hora_llegada)->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Clase: {{ \Carbon\Carbon::parse($asistencia->horario->hora_inicio)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $asistencia->docente->usuario->nombre ?? 'N/A' }} {{ $asistencia->docente->usuario->apellido ?? '' }}
                                        </div>
                                        <div class="text-xs text-gray-500">Reg: {{ $asistencia->id_docente }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $asistencia->horario->materia->nombre ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $asistencia->horario->materia->sigla ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            {{ $asistencia->horario->grupo->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($asistencia->horario->es_virtual)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Virtual
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-600">
                                                {{ $asistencia->horario->aula->nombre ?? 'N/A' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($asistencia->estado == 'A tiempo')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                A tiempo
                                            </span>
                                        @elseif($asistencia->estado == 'Tardanza')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                Tardanza
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                Falta
                                            </span>
                                        @endif
                                        
                                        @if($asistencia->justificada)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-1">
                                                Justif.
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($asistencia->observaciones)
                                            <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $asistencia->observaciones }}">
                                                {{ $asistencia->observaciones }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($asistencias->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $asistencias->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>