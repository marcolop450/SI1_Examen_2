<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Grupo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Editar Grupo: {{ $grupo->nombre }}</h3>
                    <p class="text-sm text-gray-600 mt-1">Modifique los datos del grupo según sea necesario</p>
                </div>

                <form action="{{ route('grupos.update', $grupo->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre', $grupo->nombre) }}" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Turno -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Turno <span class="text-red-500">*</span>
                            </label>
                            <select name="turno" 
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                                <option value="Mañana" {{ old('turno', $grupo->turno) == 'Mañana' ? 'selected' : '' }}>🌅 Mañana</option>
                                <option value="Tarde" {{ old('turno', $grupo->turno) == 'Tarde' ? 'selected' : '' }}>☀️ Tarde</option>
                                <option value="Noche" {{ old('turno', $grupo->turno) == 'Noche' ? 'selected' : '' }}>🌙 Noche</option>
                            </select>
                            @error('turno')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacidad Máxima -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Capacidad Máxima <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="capacidad_maxima" 
                                   value="{{ old('capacidad_maxima', $grupo->capacidad_maxima) }}" 
                                   min="1" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                            @error('capacidad_maxima')
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
                            Actualizar Grupo
                        </button>
                        <a href="{{ route('grupos.index') }}" 
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