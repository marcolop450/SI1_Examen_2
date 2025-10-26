<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Aulas
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
                <h3 class="text-lg font-bold">Lista de Aulas</h3>
                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 1.5rem;">      
                     
                    <a href="{{ route('aulas.create') }}" 
                       style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        + Nueva Aula
                    </a>
                    <a href="{{ route('aulas.inactivos') }}" style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                        🏛️ Ver Inactivas
                    </a>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f3f4f6;">
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Nombre</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Tipo</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Capacidad</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Piso</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Equipamiento</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aulas as $aula)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem; font-weight: 600;">{{ $aula->nombre }}</td>
                                <td style="padding: 0.75rem;">{{ $aula->tipo }}</td>
                                <td style="padding: 0.75rem;">{{ $aula->capacidad }} personas</td>
                                <td style="padding: 0.75rem;">{{ $aula->piso ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem;">{{ Str::limit($aula->equipamiento ?? 'Sin equipamiento', 30) }}</td>
                                <td style="padding: 0.75rem;">
                                    <a href="{{ route('aulas.show', $aula->id) }}" 
                                       style="color: #3b82f6; margin-right: 0.5rem;">Ver</a>
                                    <a href="{{ route('aulas.edit', $aula->id) }}" 
                                       style="color: #10b981; margin-right: 0.5rem;">Editar</a>
                                    <form action="{{ route('aulas.destroy', $aula->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta aula?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 2rem; text-align: center; color: #6b7280;">
                                    No hay aulas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>