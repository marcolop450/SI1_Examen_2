<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Horario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Hay algunos errores:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Editar Horario: ID #{{ $horario->id }}</h3>
                    <p class="text-sm text-gray-600 mt-1">La hora final se calculará automáticamente</p>
                </div>

                <form action="{{ route('horarios.update', $horario->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Docente -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Docente <span class="text-red-500">*</span>
                            </label>
                            <select name="id_docente" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Seleccione un docente...</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->registro }}" {{ (old('id_docente', $horario->id_docente) == $docente->registro) ? 'selected' : '' }}>
                                        {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }} ({{ $docente->carga_horaria_simple }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_docente')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Materia -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Materia <span class="text-red-500">*</span>
                            </label>
                            <select name="id_materia" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Seleccione una materia...</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" {{ (old('id_materia', $horario->id_materia) == $materia->id) ? 'selected' : '' }}>
                                        {{ $materia->codigo }} - {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_materia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grupo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Grupo <span class="text-red-500">*</span>
                            </label>
                            <select name="id_grupo" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Seleccione un grupo...</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ (old('id_grupo', $horario->id_grupo) == $grupo->id) ? 'selected' : '' }}>
                                        {{ $grupo->nombre }} (Cap: {{ $grupo->capacidad_maxima }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_grupo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aula -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Aula <span class="text-gray-500 text-xs">(Opcional si es virtual)</span>
                            </label>
                            <select name="id_aula" id="aula_select"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Sin aula (Virtual)</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ (old('id_aula', $horario->id_aula) == $aula->id) ? 'selected' : '' }}>
                                        {{ $aula->nombre }} - Cap: {{ $aula->capacidad }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_aula')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Día -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Día <span class="text-red-500">*</span>
                            </label>
                            <select name="dia" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Seleccione un día...</option>
                                @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                    <option value="{{ $dia }}" {{ (old('dia', $horario->dia) == $dia) ? 'selected' : '' }}>
                                        {{ $dia }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gestión -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Gestión <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="gestion" 
                                   value="{{ old('gestion', $horario->gestion) }}" 
                                   required
                                   placeholder="Ej: 2-2025"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('gestion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hora Inicio -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Hora Inicio <span class="text-red-500">*</span>
                            </label>
                            <select name="hora_inicio" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="">Seleccione hora...</option>
                                @php
                                    $horaInicioActual = substr($horario->hora_inicio, 0, 5);
                                @endphp
                                @foreach($horariosDisponibles as $hora)
                                    <option value="{{ $hora }}" {{ (old('hora_inicio', $horaInicioActual) == $hora) ? 'selected' : '' }}>
                                        {{ $hora }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hora_inicio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-blue-600 font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                La hora final se calculará automáticamente según los 270 minutos semanales de la materia
                            </p>
                        </div>

                        <!-- Es Virtual -->
                        <div class="md:col-span-2">
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="checkbox" 
                                       name="es_virtual" 
                                       id="es_virtual"
                                       value="1"
                                       {{ old('es_virtual', $horario->es_virtual) ? 'checked' : '' }}
                                       class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">
                                    Clase Virtual (no requiere aula física)
                                </span>
                            </label>
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                            <textarea name="observaciones" 
                                      rows="3"
                                      placeholder="Observaciones adicionales..."
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">{{ old('observaciones', $horario->observaciones) }}</textarea>
                            @error('observaciones')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-semibold mb-1">Información importante:</p>
                                    <ul class="space-y-1">
                                        <li>• La hora final se calculará automáticamente según los días que tenga esta materia</li>
                                        <li>• 270 minutos semanales distribuidos entre los días asignados</li>
                                        <li>• 1 hora académica = 45 minutos</li>
                                        <li>• Se validará que no haya conflictos con otros horarios</li>
                                        <li>• Los horarios disponibles van de 7:00 AM a 21:15 PM (intervalos de 45 min)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Actualizar Horario
                            </button>
                            <a href="{{ route('horarios.index') }}" 
                               class="inline-flex items-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>