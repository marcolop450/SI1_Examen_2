<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aulas Inactivas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))<div style="background-color:#10b981;color:white;padding:1rem;border-radius:0.5rem;">{{ session('success') }}</div>@endif
            @if(session('error'))<div style="background-color:#ef4444;color:white;padding:1rem;border-radius:0.5rem;">{{ session('error') }}</div>@endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;">
                    <h3 class="text-lg font-bold">Lista de Aulas Inactivas</h3>
                    <a href="{{ route('aulas.index') }}" style="background-color:#6b7280;color:white;padding:0.5rem 1rem;border-radius:0.375rem;">← Volver a Activas</a>
                </div>

                @if($aulas->count() > 0)
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background-color:#f3f4f6;">
                                <th style="padding:0.75rem;">Nombre</th>
                                <th style="padding:0.75rem;">Tipo</th>
                                <th style="padding:0.75rem;">Capacidad</th>
                                <th style="padding:0.75rem;">Piso</th>
                                <th style="padding:0.75rem;">Equipamiento</th>
                                <th style="padding:0.75rem;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aulas as $aula)
                                <tr style="border-bottom:1px solid #e5e7eb;background-color:#fef2f2;">
                                    <td style="padding:0.75rem;">{{ $aula->nombre }}</td>
                                    <td style="padding:0.75rem;">{{ $aula->tipo }}</td>
                                    <td style="padding:0.75rem;">{{ $aula->capacidad }}</td>
                                    <td style="padding:0.75rem;">{{ $aula->piso }}</td>
                                    <td style="padding:0.75rem;">{{ $aula->equipamiento }}</td>
                                    <td style="padding:0.75rem;">
                                        <div style="display:flex;gap:0.5rem;">
                                            <form action="{{ route('aulas.reactivar', $aula->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background-color:#10b981;color:white;padding:0.375rem 0.75rem;border-radius:0.375rem;"
                                                        onclick="return confirm('¿Reactivar esta aula?')">✓ Reactivar</button>
                                            </form>
                                            <form action="{{ route('aulas.forceDestroy', $aula->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="background-color:#dc2626;color:white;padding:0.375rem 0.75rem;border-radius:0.375rem;"
                                                        onclick="return confirm('⚠️ Eliminar permanentemente esta aula?')">🗑️ Eliminar Permanente</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="background-color:#dbeafe;color:#1e40af;padding:1rem;border-radius:0.5rem;text-align:center;">
                        ✓ No hay aulas inactivas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
