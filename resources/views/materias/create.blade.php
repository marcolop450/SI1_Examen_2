
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nueva Materia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Información de la Materia</h3>
                    <p class="text-sm text-gray-600 mt-1">Complete los datos para crear una nueva materia en el sistema</p>
                </div>

                <form action="{{ route('materias.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Código -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Código <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="codigo" 
                                   value="{{ old('codigo') }}" 
                                   required
                                   placeholder="Ej: SIS-101"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione...</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>{{ $i }}º Semestre</option>
                                @endfor
                            </select>
                            @error('semestre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Sistemas de Información I"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Horas Teóricas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Horas Teóricas <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="horas_teoricas" 
                                   value="{{ old('horas_teoricas', 0) }}" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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
                                   value="{{ old('horas_practicas', 0) }}" 
                                   min="0" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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
                                   value="{{ old('creditos') }}" 
                                   min="1" 
                                   max="10" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('creditos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contenido -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Contenido</label>
                            <textarea name="contenido" 
                                      rows="3"
                                      placeholder="Descripción del contenido de la materia"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('contenido') }}</textarea>
                            @error('contenido')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex items-center gap-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar Materia
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