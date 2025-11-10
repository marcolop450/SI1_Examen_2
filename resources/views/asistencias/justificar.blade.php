<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Justificar Asistencia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la Asistencia -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Información de la Asistencia</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Materia</label>
                            <p class="mt-1 text-gray-900 font-semibold">{{ $asistencia->horario->materia->nombre ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">{{ $asistencia->horario->materia->sigla ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Grupo</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $asistencia->horario->grupo->nombre ?? 'N/A' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hora de Llegada</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                {{ \Carbon\Carbon::parse($asistencia->hora_llegada)->format('H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado Actual -->
            @php
                $estadoColor = match($asistencia->estado) {
                    'Tardanza' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-500', 'text' => 'text-yellow-700'],
                    'Falta' => ['bg' => 'bg-red-50', 'border' => 'border-red-500', 'text' => 'text-red-700'],
                    default => ['bg' => 'bg-gray-50', 'border' => 'border-gray-500', 'text' => 'text-gray-700'],
                };
            @endphp

            <div class="{{ $estadoColor['bg'] }} border-l-4 {{ $estadoColor['border'] }} {{ $estadoColor['text'] }} p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <strong>Estado Actual:</strong> {{ $asistencia->estado }}
                    </div>
                </div>
            </div>

            <!-- Formulario de Justificación -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Justificar Asistencia</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Por favor, proporcione una justificación detallada para su {{ strtolower($asistencia->estado) }}.
                    </p>
                </div>

                <form action="{{ route('asistencias.justificar.store', $asistencia->id) }}" method="POST" class="p-6">
                    @csrf

                    <!-- Campo de Observaciones/Justificación -->
                    <div class="mb-6">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Justificación
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="observaciones" 
                                  name="observaciones" 
                                  rows="6" 
                                  maxlength="500"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('observaciones') border-red-500 @enderror"
                                  placeholder="Ejemplo: Retraso debido a problemas de transporte público, tráfico excepcional, emergencia familiar, etc."
                                  required
                                  autofocus>{{ old('observaciones', $asistencia->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Máximo 500 caracteres. Sea específico y claro en su justificación.
                        </p>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('asistencias.historial') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enviar Justificación
                        </button>
                    </div>
                </form>
            </div>

            <!-- Información Adicional -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Información importante:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>La justificación debe ser clara y detallada</li>
                            <li>Una vez enviada, la justificación quedará registrada en el sistema</li>
                            <li>La justificación será revisada por el coordinador o autoridad correspondiente</li>
                            <li>Proporcionar información falsa puede tener consecuencias disciplinarias</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>