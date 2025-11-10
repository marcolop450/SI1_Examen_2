<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('horarios.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    📅 Detalle del Horario
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                @can('editar-horarios')
                <a href="{{ route('horarios.edit', $horario->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- Información Principal -->
            <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-lg p-8 text-white">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-3xl font-bold mb-4">{{ $horario->materia->nombre }}</h3>
                        <div class="space-y-2 text-blue-100">
                            <p><span class="font-semibold">Grupo:</span> {{ $horario->grupo->nombre }}</p>
                            <p><span class="font-semibold">Día:</span> {{ $horario->dia }}</p>
                            <p><span class="font-semibold">Horario:</span> {{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_final, 0, 5) }}</p>
                            <p><span class="font-semibold">Duración:</span> {{ $horasAcademicas }} horas académicas</p>
                            <p><span class="font-semibold">Gestión:</span> {{ $horario->gestion }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold mb-3">Docente</h4>
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                            <p class="font-bold text-lg mb-2">
                                {{ $horario->docente->usuario->nombre }} {{ $horario->docente->usuario->apellido }}
                            </p>
                            <p class="text-sm text-blue-100">Registro: {{ $horario->docente->registro }}</p>
                            <p class="text-sm text-blue-100">Email: {{ $horario->docente->usuario->email }}</p>
                        </div>

                        <h4 class="text-xl font-bold mb-3 mt-4">Aula / Modalidad</h4>
                        @if($horario->es_virtual)
                            <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                💻 Clase Virtual
                            </span>
                        @else
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                <p class="font-bold">{{ $horario->aula->nombre }}</p>
                                <p class="text-sm text-blue-100">{{ $horario->aula->tipo }} - Piso {{ $horario->aula->piso }}</p>
                                <p class="text-sm text-blue-100">Capacidad: {{ $horario->aula->capacidad }} personas</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($horario->observaciones)
                <div class="mt-6 pt-6 border-t border-blue-400">
                    <h4 class="text-lg font-semibold mb-2">Observaciones</h4>
                    <p class="text-blue-100">{{ $horario->observaciones }}</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>