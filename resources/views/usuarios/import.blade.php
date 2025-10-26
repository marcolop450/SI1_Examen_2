<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Carga Masiva de Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Instrucciones -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-6 shadow-sm">
                <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Instrucciones para la Carga Masiva
                </h3>
                <ol class="ml-6 space-y-2 text-sm text-blue-800 list-decimal">
                    <li>Descarga la plantilla Excel haciendo clic en el botón de abajo</li>
                    <li>Completa los datos de los usuarios (nombre, apellido, CI, correo, teléfono, sexo, rol)</li>
                    <li>El campo <strong>rol</strong> debe ser exactamente: "Coordinador", "Docente" o "Autoridad"</li>
                    <li>El campo <strong>sexo</strong> debe ser: "M" o "F"</li>
                    <li>Guarda el archivo y cárgalo usando el formulario</li>
                    <li>La contraseña por defecto será <strong>123456</strong> para todos los usuarios</li>
                </ol>
            </div>

            <!-- Descargar Plantilla -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Descargar Plantilla</h3>
                    <p class="text-sm text-gray-600 mb-4">Descarga la plantilla de Excel para cargar usuarios masivamente</p>
                    <a href="{{ route('usuarios.template') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Plantilla Excel
                    </a>
                </div>
            </div>

            <!-- Formulario de Carga -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Cargar Archivo</h3>
                    <p class="text-sm text-gray-600 mt-1">Seleccione el archivo Excel o CSV con los datos de los usuarios</p>
                </div>
                
                <form action="{{ route('usuarios.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Seleccionar archivo Excel/CSV <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                        <span>Selecciona un archivo</span>
                                        <input id="file-upload" name="archivo" type="file" accept=".xlsx,.xls,.csv" required class="sr-only">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-gray-500">XLSX, XLS o CSV hasta 5MB</p>
                            </div>
                        </div>
                        @error('archivo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            Importar Usuarios
                        </button>
                        <a href="{{ route('usuarios.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Ejemplo Visual -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mt-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Ejemplo de Formato</h3>
                    <p class="text-sm text-gray-600 mt-1">Así debe verse tu archivo Excel</p>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">apellido</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">ci</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">correo</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">telefono</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">sexo</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 border border-gray-300">rol</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">Juan</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">Pérez</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">12345678</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">juan@ejemplo.com</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">70123456</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">M</td>
                                <td class="px-4 py-2 text-sm text-gray-600 border border-gray-300">Docente</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>