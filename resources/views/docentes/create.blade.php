<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Docente
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
                <form action="{{ route('docentes.store') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <!-- Registro -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Registro *</label>
                            <input type="number" name="registro" value="{{ old('registro') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('registro')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- CI -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">CI *</label>
                            <input type="number" name="ci" value="{{ old('ci') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('ci')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nombre *</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('nombre')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Apellido -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Apellido *</label>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('apellido')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Correo -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Correo *</label>
                            <input type="email" name="correo" value="{{ old('correo') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('correo')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono') }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('telefono')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sexo -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Sexo *</label>
                            <select name="sexo" required
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                                <option value="">Seleccione...</option>
                                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                            @error('sexo')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Carrera -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Carrera</label>
                            <input type="text" name="carrera" value="{{ old('carrera') }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('carrera')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Especialidad -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Especialidad</label>
                            <input type="text" name="especialidad" value="{{ old('especialidad') }}"
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('especialidad')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Fecha Ingreso -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Fecha de Ingreso *</label>
                            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('fecha_ingreso')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Carga Horaria Máxima -->
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Carga Horaria Máxima *</label>
                            <input type="number" name="carga_horaria_maxima" value="{{ old('carga_horaria_maxima', 80) }}" 
                                   min="1" max="80" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;">
                            @error('carga_horaria_maxima')
                                <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                            * La contraseña temporal será: <strong>123456</strong>
                        </p>
                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" 
                                    style="background-color: #3b82f6; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer;">
                                Guardar Docente
                            </button>
                            <a href="{{ route('docentes.index') }}" 
                               style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>