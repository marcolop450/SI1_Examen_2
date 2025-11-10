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
                    🔍 Buscar Aulas Disponibles
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Formulario de Búsqueda -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-8 mb-8 text-white">
                <h3 class="text-2xl font-bold mb-6">Consultar Disponibilidad</h3>
                <form method="GET" action="{{ route('reportes.aulas-disponibles') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Día -->
                        <div>
                            <label class="block text-sm font-medium text-indigo-100 mb-2">Día de la Semana</label>
                            <select name="dia" class="w-full rounded-lg border-0 text-gray-900 focus:ring-2 focus:ring-white">
                                @foreach($diasSemana as $diaOption)
                                    <option value="{{ $diaOption }}" {{ $dia == $diaOption ? 'selected' : '' }}>
                                        {{ $diaOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Hora Inicio -->
                        <div>
                            <label class="block text-sm font-medium text-indigo-100 mb-2">Hora Inicio</label>
                            <input type="time" name="hora_inicio" value="{{ $horaInicio }}" 
                                   class="w-full rounded-lg border-0 text-gray-900 focus:ring-2 focus:ring-white">
                        </div>

                        <!-- Hora Fin -->
                        <div>
                            <label class="block text-sm font-medium text-indigo-100 mb-2">Hora Fin</label>
                            <input type="time" name="hora_fin" value="{{ $horaFin }}" 
                                   class="w-full rounded-lg border-0 text-gray-900 focus:ring-2 focus:ring-white">
                        </div>

                        <!-- Botón -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-white text-indigo-600 font-bold py-3 px-6 rounded-lg hover:bg-indigo-50 transition-colors shadow-lg">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Resultados -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Aulas Disponibles -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Aulas Disponibles</h3>
                            </div>
                            <span class="bg-white/20 px-4 py-2 rounded-full text-lg font-bold">{{ $aulasDisponibles->count() }}</span>
                        </div>
                        <p class="text-green-100 text-sm mt-2">
                            {{ $dia }} - {{ $horaInicio }} a {{ $horaFin }}
                        </p>
                    </div>
                    <div class="p-6">
                        @if($aulasDisponibles->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <p class="text-gray-500 font-medium">No hay aulas disponibles en este horario</p>
                                <p class="text-sm text-gray-400 mt-1">Intenta con otra franja horaria</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($aulasDisponibles as $aula)
                                <div class="bg-gradient-to-br from-green-50 to-white border-2 border-green-200 rounded-xl p-4 hover:shadow-lg transition-all hover:-translate-y-1">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="bg-green-100 rounded-lg p-3">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full">
                                            Disponible
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-gray-800 text-lg mb-1">{{ $aula->nombre }}</h4>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <span>{{ $aula->tipo }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span>Capacidad: {{ $aula->capacidad }} personas</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span>Piso {{ $aula->piso }}</span>
                                        </div>
                                    </div>
                                    @if($aula->equipamiento)
                                    <div class="mt-3 pt-3 border-t border-green-100">
                                        <p class="text-xs text-gray-500 font-medium mb-1">Equipamiento:</p>
                                        <p class="text-xs text-gray-600">{{ $aula->equipamiento }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Aulas Ocupadas -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-red-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 rounded-lg p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Aulas Ocupadas</h3>
                            </div>
                            <span class="bg-white/20 px-4 py-2 rounded-full text-lg font-bold">{{ $aulasOcupadas->count() }}</span>
                        </div>
                        <p class="text-red-100 text-sm mt-2">
                            {{ $dia }} - {{ $horaInicio }} a {{ $horaFin }}
                        </p>
                    </div>
                    <div class="p-6">
                        @if($aulasOcupadas->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-green-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">¡Excelente! No hay aulas ocupadas</p>
                                <p class="text-sm text-gray-400 mt-1">Todas las aulas están disponibles</p>
                            </div>
                        @else
                            <div class="space-y-4 max-h-[600px] overflow-y-auto">
                                @foreach($aulasOcupadas as $horario)
                                <div class="bg-gradient-to-br from-red-50 to-white border-2 border-red-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-800 text-lg">{{ $horario->aula->nombre }}</h4>
                                            <p class="text-sm text-gray-600">{{ $horario->aula->tipo }} - Piso {{ $horario->aula->piso }}</p>
                                        </div>
                                        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">
                                            Ocupada
                                        </span>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 border border-red-100">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-800">
                                                {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_final, 0, 5) }}
                                            </span>
                                        </div>
                                        <div class="space-y-1 text-xs text-gray-600">
                                            <p><span class="font-semibold">Materia:</span> {{ $horario->materia->nombre }}</p>
                                            <p><span class="font-semibold">Grupo:</span> {{ $horario->grupo->nombre }}</p>
                                            <p><span class="font-semibold">Docente:</span> {{ $horario->docente->usuario->nombre }} {{ $horario->docente->usuario->apellido }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>