<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Horarios Asignados
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Información del Docente -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</h3>
                            <p class="text-blue-100 mt-1">Registro: {{ $docente->registro }} | Carrera: {{ $docente->carrera ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-blue-100">Carga Horaria</p>
                            <p class="text-3xl font-bold">{{ $docente->carga_horaria_actual }}h / {{ $docente->carga_horaria_maxima }}h</p>
                            <div class="mt-2 w-48 bg-blue-400 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full" 
                                     style="width: {{ ($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($horarios->count() > 0)
                <!-- Vista de Grilla Semanal -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Horario Semanal
                        </h3>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border">Hora</th>
                                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border">{{ $dia }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Obtener todas las horas únicas
                                        $horas = $horarios->map(function($h) {
                                            return \Carbon\Carbon::parse($h->hora_inicio)->format('H:i');
                                        })->unique()->sort()->values();
                                    @endphp

                                    @foreach($horas as $hora)
                                        <tr>
                                            <td class="px-4 py-3 border bg-gray-50 font-semibold text-gray-700">
                                                {{ $hora }}
                                            </td>
                                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                                @php
                                                    $horarioDia = $horarios->first(function($h) use ($dia, $hora) {
                                                        return $h->dia === $dia && 
                                                               \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') === $hora;
                                                    });
                                                @endphp
                                                <td class="px-4 py-3 border {{ $horarioDia ? 'bg-blue-50' : '' }}">
                                                    @if($horarioDia)
                                                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-3 shadow-md">
                                                            <p class="font-bold text-sm">{{ $horarioDia->materia->nombre }}</p>
                                                            <p class="text-xs mt-1">{{ $horarioDia->grupo->nombre }}</p>
                                                            <div class="flex items-center justify-between mt-2 text-xs">
                                                                <span class="flex items-center">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    {{ \Carbon\Carbon::parse($horarioDia->hora_inicio)->format('H:i') }} - 
                                                                    {{ \Carbon\Carbon::parse($horarioDia->hora_final)->format('H:i') }}
                                                                </span>
                                                            </div>
                                                            @if($horarioDia->aula)
                                                                <p class="text-xs mt-1 flex items-center">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                                    </svg>
                                                                    {{ $horarioDia->aula->nombre }}
                                                                </p>
                                                            @else
                                                                <p class="text-xs mt-1 flex items-center">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                                    </svg>
                                                                    Virtual
                                                                </p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Lista Detallada por Día -->
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Detalle por Día
                        </h3>
                    </div>

                    <div class="p-6">
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            @if(isset($horariosPorDia[$dia]) && $horariosPorDia[$dia]->count() > 0)
                                <div class="mb-6">
                                    <h4 class="text-lg font-bold text-gray-700 mb-3 flex items-center">
                                        <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">
                                            {{ substr($dia, 0, 1) }}
                                        </span>
                                        {{ $dia }}
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($horariosPorDia[$dia] as $horario)
                                            <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                                                <div class="flex items-start justify-between mb-3">
                                                    <h5 class="text-lg font-bold text-gray-800">{{ $horario->materia->nombre }}</h5>
                                                    @if($horario->es_virtual)
                                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Virtual</span>
                                                    @else
                                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Presencial</span>
                                                    @endif
                                                </div>

                                                <div class="space-y-2 text-sm text-gray-600">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span class="font-semibold">
                                                            {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                                            {{ \Carbon\Carbon::parse($horario->hora_final)->format('H:i') }}
                                                        </span>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        {{ $horario->grupo->nombre }}
                                                    </div>

                                                    @if($horario->aula)
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                            </svg>
                                                            {{ $horario->aula->nombre }}
                                                        </div>
                                                    @endif

                                                    @if($horario->observaciones)
                                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                                            <p class="text-xs text-gray-500 italic">{{ $horario->observaciones }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">No tienes horarios asignados</h3>
                        <p class="text-gray-600">Actualmente no tienes clases programadas en el sistema</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>