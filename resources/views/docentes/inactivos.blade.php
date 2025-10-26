<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Docentes Inactivos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div style="background-color: #10b981; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #ef4444; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-lg font-bold">Lista de Docentes Inactivos</h3>
                    <a href="{{ route('docentes.index') }}" 
                       style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                        ← Volver a Activos
                    </a>
                </div>

                @if($docentes->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f3f4f6;">
                                <th style="padding: 0.75rem; text-align: left;">Registro</th>
                                <th style="padding: 0.75rem; text-align: left;">Usuario</th>
                                <th style="padding: 0.75rem; text-align: left;">Carrera</th>
                                <th style="padding: 0.75rem; text-align: left;">Especialidad</th>
                                <th style="padding: 0.75rem; text-align: left;">Carga Horaria</th>
                                <th style="padding: 0.75rem; text-align: left;">Fecha Ingreso</th>
                                <th style="padding: 0.75rem; text-align: left;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docentes as $docente)
                                <tr style="border-bottom: 1px solid #e5e7eb; background-color: #fef2f2;">
                                    <td style="padding: 0.75rem; font-weight: 600; color: #991b1b;">{{ $docente->registro }}</td>
                                    <td style="padding: 0.75rem; color: #991b1b;">{{ $docente->usuario->username ?? 'Sin usuario' }}</td>
                                    <td style="padding: 0.75rem; color: #991b1b;">{{ $docente->carrera }}</td>
                                    <td style="padding: 0.75rem; color: #991b1b;">{{ $docente->especialidad }}</td>
                                    <td style="padding: 0.75rem; color: #991b1b;">
                                        {{ $docente->carga_horaria_actual }} / {{ $docente->carga_horaria_maxima }}
                                    </td>
                                    <td style="padding: 0.75rem; color: #991b1b;">{{ $docente->fecha_ingreso->format('d/m/Y') }}</td>
                                    <td style="padding: 0.75rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <form action="{{ route('docentes.reactivar', $docente->registro) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background-color: #10b981; color: white; padding: 0.375rem 0.75rem; border-radius: 0.375rem;"
                                                        onclick="return confirm('¿Reactivar este docente?')">✓ Reactivar</button>
                                            </form>
                                            <form action="{{ route('docentes.forceDestroy', $docente->registro) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="background-color: #dc2626; color: white; padding: 0.375rem 0.75rem; border-radius: 0.375rem;"
                                                        onclick="return confirm('⚠️ Eliminar permanentemente este docente?')">🗑️ Eliminar Permanente</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="background-color: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 0.5rem; text-align: center;">
                        ✓ No hay docentes inactivos.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
