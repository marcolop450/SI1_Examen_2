<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Aula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('aulas.update', $aula->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $aula->nombre) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('nombre')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Tipo *</label>
                            <select name="tipo" required
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="Aula Tradicional" {{ old('tipo', $aula->tipo) == 'Aula Tradicional' ? 'selected' : '' }}>Aula Tradicional</option>
                                <option value="Laboratorio" {{ old('tipo', $aula->tipo) == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                <option value="Auditorio" {{ old('tipo', $aula->tipo) == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
                            </select>
                            @error('tipo')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Capacidad *</label>
                            <input type="number" name="capacidad" value="{{ old('capacidad', $aula->capacidad) }}" min="1" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('capacidad')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Piso</label>
                            <input type="text" name="piso" value="{{ old('piso', $aula->piso) }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('piso')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="grid-column: span 2;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Equipamiento</label>
                            <textarea name="equipamiento" rows="3"
                                      style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('equipamiento', $aula->equipamiento) }}</textarea>
                            @error('equipamiento')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            Actualizar Aula
                        </button>
                        <a href="{{ route('aulas.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>