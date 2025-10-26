<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Información del Rol</h3>
                    <p class="text-sm text-gray-600 mt-1">Complete los datos para crear un nuevo rol en el sistema</p>
                </div>

                <form action="{{ route('roles.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Nombre del Rol -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nombre del Rol <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Secretaria, Jefe de Carrera"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                            <textarea name="descripcion" 
                                      rows="3"
                                      placeholder="Breve descripción del rol y sus responsabilidades"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permisos -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Permisos del Rol
                            </label>
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 max-h-80 overflow-y-auto">
                                @forelse($permisos as $permiso)
                                    <label class="flex items-start p-3 hover:bg-white rounded-lg cursor-pointer transition group">
                                        <input type="checkbox" 
                                               name="permisos[]" 
                                               value="{{ $permiso->id }}"
                                               {{ in_array($permiso->id, old('permisos', [])) ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <div class="ml-3 flex-1">
                                            <div class="font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                                {{ $permiso->nombre }}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-0.5">
                                                {{ $permiso->descripcion }}
                                            </div>
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <p class="mt-2 text-gray-600">No hay permisos disponibles</p>
                                        <a href="{{ route('permisos.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 font-medium">
                                            Crear nuevo permiso
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex items-center gap-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar Rol
                        </button>
                        <a href="{{ route('roles.index') }}" 
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