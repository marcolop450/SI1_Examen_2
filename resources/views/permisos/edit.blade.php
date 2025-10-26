<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Permiso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('permisos.update', $permiso->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre del Permiso *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $permiso->nombre) }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('nombre')
                            <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Descripción</label>
                        <textarea name="descripcion" rows="3"
                                  style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('descripcion', $permiso->descripcion) }}</textarea>
                        @error('descripcion')
                            <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            Actualizar Permiso
                        </button>
                        <a href="{{ route('permisos.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>