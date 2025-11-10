<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Materia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Editar Materia: {{ $materia->codigo }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Modifique los datos de la materia según sea necesario</p>
                </div>

                <form action="{{ route('materias.update', $materia->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre', $materia->nombre) }}" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Código <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="codigo" 
                                   value="{{ old('codigo', $materia->codigo) }}" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('codigo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Semestre <span class="text-red-500">*</span>
                            </label>
                            <select name="semestre" 
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('semestre', $materia->semestre) == $i ? 'selected' : '' }}>
                                        {{ $i }}º Semestre
                                    </option>
                                @endfor
                            </select>
                            @error('semestre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Materia (Electiva o Normal) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo de Materia <span class="text-red-500">*</span>
                            </label>
                            <select name="es_electiva" 
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="0" {{ old('es_electiva', $materia->es_electiva) == 0 ? 'selected' : '' }}>Normal (4h 30min/semana)</option>
                                <option value="1" {{ old('es_electiva', $materia->es_electiva) == 1 ? 'selected' : '' }}>Electiva (3h/semana)</option>
                            </select>
                            @error('es_electiva')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Las materias normales tienen 4h 30min semanales, las electivas 3h</p>
                        </div>

                        <!-- Días por semana -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Días por Semana <span class="text-red-500">*</span>
                            </label>
                            <select name="dias_semana" 
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="1" {{ old('dias_semana', $materia->dias_semana) == 1 ? 'selected' : '' }}>1 día por semana</option>
                                <option value="2" {{ old('dias_semana', $materia->dias_semana) == 2 ? 'selected' : '' }}>2 días por semana</option>
                                <option value="3" {{ old('dias_semana', $materia->dias_semana) == 3 ? 'selected' : '' }}>3 días por semana</option>
                            </select>
                            @error('dias_semana')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">La carga horaria se distribuirá en estos días</p>
                        </div>

                        <!-- Horas Teóricas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Horas Teóricas <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="horas_teoricas" 
                                   value="{{ old('horas_teoricas', $materia->horas_teoricas) }}" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('horas_teoricas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Horas Prácticas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Horas Prácticas <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="horas_practicas" 
                                   value="{{ old('horas_practicas', $materia->horas_practicas) }}" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('horas_practicas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Créditos -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Créditos <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="creditos" 
                                   value="{{ old('creditos', $materia->creditos) }}" 
                                   min="1" 
                                   max="10" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('creditos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contenido -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Contenido</label>
                            <textarea name="contenido" 
                                      rows="3"
                                      placeholder="Descripción del contenido de la materia..."
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">{{ old('contenido', $materia->contenido) }}</textarea>
                            @error('contenido')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex items-center gap-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Actualizar Materia
                        </button>
                        <a href="{{ route('materias.index') }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>