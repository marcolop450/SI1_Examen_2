<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Grupo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Información del Grupo</h3>
                    <p class="text-sm text-gray-600 mt-1">Complete los datos para crear un nuevo grupo</p>
                </div>

                <form action="{{ route('grupos.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: SA, SB, I1"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
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
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione...</option>
                                <option value="Mañana" {{ old('turno') == 'Mañana' ? 'selected' : '' }}>🌅 Mañana</option>
                                <option value="Tarde" {{ old('turno') == 'Tarde' ? 'selected' : '' }}>☀️ Tarde</option>
                                <option value="Noche" {{ old('turno') == 'Noche' ? 'selected' : '' }}>🌙 Noche</option>
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
                                   value="{{ old('capacidad_maxima', 35) }}" 
                                   min="1" 
                                   required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('capacidad_maxima')
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
                            Guardar Grupo
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