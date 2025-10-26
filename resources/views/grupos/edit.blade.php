<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Grupo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('grupos.update', $grupo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $grupo->nombre) }}" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('nombre')
                            <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Turno *</label>
                        <select name="turno" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            <option value="Mañana" {{ old('turno', $grupo->turno) == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                            <option value="Tarde" {{ old('turno', $grupo->turno) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            <option value="Noche" {{ old('turno', $grupo->turno) == 'Noche' ? 'selected' : '' }}>Noche</option>
                        </select>
                        @error('turno')
                            <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Capacidad Máxima *</label>
                        <input type="number" name="capacidad_maxima" value="{{ old('capacidad_maxima', $grupo->capacidad_maxima) }}" min="1" required
                               style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                        @error('capacidad_maxima')
                            <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            Actualizar Grupo
                        </button>
                        <a href="{{ route('grupos.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>