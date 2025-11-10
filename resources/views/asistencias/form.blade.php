<script>
document.querySelector('form').addEventListener('submit', function(e) {
    console.log('📤 Formulario enviándose...');
    console.log('Username:', document.getElementById('username').value);
    console.log('ID Horario:', document.querySelector('[name="id_horario"]').value);
    console.log('Observaciones:', document.getElementById('observaciones').value);
});
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Confirmar Asistencia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Información de la Clase -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Información de la Clase</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Materia</label>
                            <p class="mt-1 text-gray-900 font-semibold">{{ $horario->materia->nombre ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">{{ $horario->materia->sigla ?? '' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Horario</label>
                            <p class="mt-1 text-gray-900 font-semibold">
                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($horario->hora_final)->format('H:i') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Grupo</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $horario->grupo->nombre ?? 'N/A' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Aula</label>
                            <p class="mt-1">
                                @if($horario->es_virtual)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Virtual
                                    </span>
                                @else
                                    <span class="text-gray-900">{{ $horario->aula->nombre ?? 'N/A' }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advertencia de Estado - CORREGIDO -->
            @php
                // Usar timezone de La Paz
                $now = \Carbon\Carbon::now('America/La_Paz');
                $horaInicio = \Carbon\Carbon::parse($horario->hora_inicio)
                    ->setDate($now->year, $now->month, $now->day)
                    ->setTimezone('America/La_Paz');
                
                // Usar el método del modelo para calcular minutos
                $minutosDiferencia = \App\Models\Asistencia::calcularMinutosDiferencia(
                    $now->format('H:i:s'),
                    $horaInicio->format('H:i:s')
                );
                
                // Calcular estado
                $estadoActual = \App\Models\Asistencia::calcularEstado(
                    $now->format('H:i:s'),
                    $horaInicio->format('H:i:s')
                );
                
                // Para mostrar en UI (solo valores positivos)
                $minutosTarde = max(0, $minutosDiferencia);
            @endphp
            
            @if($estadoActual === 'Tardanza')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong>Advertencia:</strong> Su asistencia se registrará como <strong>TARDANZA</strong> 
                            @if($minutosTarde > 0)
                                ({{ $minutosTarde }} {{ $minutosTarde == 1 ? 'minuto' : 'minutos' }} de retraso)
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($estadoActual === 'Falta')
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong>Atención:</strong> Su asistencia se registrará como <strong>FALTA</strong> 
                            (más de 20 minutos de retraso)
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <strong>Perfecto:</strong> Su asistencia se registrará como <strong>A TIEMPO</strong>
                            @if($minutosDiferencia < 0)
                                (llegó {{ abs($minutosDiferencia) }} {{ abs($minutosDiferencia) == 1 ? 'minuto' : 'minutos' }} antes)
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulario de Registro -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Confirmar Registro de Asistencia</h3>
                </div>

                <form action="{{ route('asistencias.registrar') }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="id_horario" value="{{ $horario->id }}">

                    <!-- Campo de Usuario -->
                    <div class="mb-6">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Confirme su nombre de usuario
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror" 
                               placeholder="Ingrese su nombre de usuario"
                               value="{{ old('username') }}"
                               required
                               autofocus>
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Debe coincidir con su nombre de usuario de acceso al sistema
                        </p>
                    </div>

                    <!-- Campo de Observaciones -->
                    <div class="mb-6">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Observaciones (Opcional)
                        </label>
                        <textarea id="observaciones" 
                                  name="observaciones" 
                                  rows="4" 
                                  maxlength="500"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Ejemplo: Retraso por tráfico, llegada anticipada, etc.">{{ old('observaciones') }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">Máximo 500 caracteres</p>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <a href="{{ route('asistencias.index') }}" 
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
                            Confirmar Asistencia
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
                            <li>Debe registrar su asistencia con su nombre de usuario correcto</li>
                            <li>El estado se calculará automáticamente según la hora de registro</li>
                            <li>Las observaciones son opcionales pero recomendadas en caso de tardanza</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>