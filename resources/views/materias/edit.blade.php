<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Materia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('materias.update', $materia->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Código *</label>
                            <input type="text" name="codigo" value="{{ old('codigo', $materia->codigo) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('codigo')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Semestre *</label>
                            <select name="semestre" required
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('semestre', $materia->semestre) == $i ? 'selected' : '' }}>
                                        {{ $i }}º Semestre
                                    </option>
                                @endfor
                            </select>
                            @error('semestre')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="grid-column: span 2;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('nombre')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Horas Teóricas *</label>
                            <input type="number" name="horas_teoricas" value="{{ old('horas_teoricas', $materia->horas_teoricas) }}" min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('horas_teoricas')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Horas Prácticas *</label>
                            <input type="number" name="horas_practicas" value="{{ old('horas_practicas', $materia->horas_practicas) }}" min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('horas_practicas')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Créditos *</label>
                            <input type="number" name="creditos" value="{{ old('creditos', $materia->creditos) }}" min="1" max="10" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('creditos')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="grid-column: span 2;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Contenido</label>
                            <textarea name="contenido" rows="3"
                                      style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">{{ old('contenido', $materia->contenido) }}</textarea>
                            @error('contenido')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            Actualizar Materia
                        </button>
                        <a href="{{ route('materias.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>