<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Docente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div style="background-color: #ef4444; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('docentes.update', $docente->registro) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Registro (solo lectura) -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Registro</label>
                            <input type="text" value="{{ $docente->registro }}" disabled
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #f3f4f6;">
                        </div>

                        <!-- CI (solo lectura) -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">CI</label>
                            <input type="text" value="{{ $docente->usuario->ci }}" disabled
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; background-color: #f3f4f6;">
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre', $docente->usuario->nombre) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('nombre')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Apellido *</label>
                            <input type="text" name="apellido" value="{{ old('apellido', $docente->usuario->apellido) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('apellido')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $docente->usuario->telefono) }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('telefono')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Carrera -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Carrera</label>
                            <input type="text" name="carrera" value="{{ old('carrera', $docente->carrera) }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('carrera')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Especialidad</label>
                            <input type="text" name="especialidad" value="{{ old('especialidad', $docente->especialidad) }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('especialidad')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Carga Horaria Máxima -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Carga Horaria Máxima *</label>
                            <input type="number" name="carga_horaria_maxima" 
                                   value="{{ old('carga_horaria_maxima', $docente->carga_horaria_maxima) }}" 
                                   min="1" max="80" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('carga_horaria_maxima')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb; display: flex; gap: 1rem;">
                        <button type="submit" 
                                style="background-color: #10b981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                            Actualizar Docente
                        </button>
                        <a href="{{ route('docentes.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>