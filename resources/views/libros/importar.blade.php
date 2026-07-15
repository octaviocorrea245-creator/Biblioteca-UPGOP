<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carga Masiva de Libros</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <p class="text-sm text-gray-600 mb-4">
                Descarga la plantilla, llénala con tus libros usando el <strong>código de barras existente</strong> de cada libro como identificador, y súbela aquí. Si un código de barras ya existe en el sistema, esa fila se omite para evitar duplicados.
            </p>

            <a href="{{ route('libros.plantilla') }}"
               class="inline-block bg-green-600 text-white px-4 py-2 rounded mb-6">
                📥 Descargar plantilla Excel
            </a>

            <form method="POST" action="{{ route('libros.importar') }}" enctype="multipart/form-data" class="mt-4">
                @csrf

            <p class="text-sm text-blue-600 mb-4">
                ℹ️ La carrera se detecta automáticamente desde la columna CARRERA del Excel. Si la clave no existe en el sistema, se creará automáticamente (podrás editar su nombre completo después desde el módulo de Carreras).
            </p>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Archivo Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="archivo" accept=".xlsx,.xls,.csv"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    @error('archivo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Importar Libros
                </button>
                <a href="{{ route('libros.index') }}" class="ml-3 text-gray-600">Cancelar</a>
            </form>
        </div>
    </div>
</x-app-layout>