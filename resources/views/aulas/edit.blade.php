<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Aula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Editar Aula: {{ $aula->nombre }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Modifique los datos del aula según sea necesario</p>
                </div>

                <form action="{{ route('aulas.update', $aula->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre', $aula->nombre) }}" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipo <span class="text-red-500">*</span>
                            </label>
                            <select name="tipo" 
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="Aula Tradicional" {{ old('tipo', $aula->tipo) == 'Aula Tradicional' ? 'selected' : '' }}>Aula Tradicional</option>
                                <option value="Laboratorio" {{ old('tipo', $aula->tipo) == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                <option value="Auditorio" {{ old('tipo', $aula->tipo) == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                            </select>
                            @error('tipo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacidad -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Capacidad <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="capacidad" 
                                   value="{{ old('capacidad', $aula->capacidad) }}" 
                                   min="1" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('capacidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Piso -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Piso</label>
                            <input type="text" 
                                   name="piso" 
                                   value="{{ old('piso', $aula->piso) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('piso')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Equipamiento -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Equipamiento</label>
                            <textarea name="equipamiento" 
                                      rows="3"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('equipamiento', $aula->equipamiento) }}</textarea>
                            @error('equipamiento')
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
                            Actualizar Aula
                        </button>
                        <a href="{{ route('aulas.index') }}" 
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