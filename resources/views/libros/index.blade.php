<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catálogo de Libros</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('libros.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nuevo Libro
        </a>
        <a href="{{ route('libros.importar.form') }}"
        class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded ml-2">
            📊 Carga Masiva Excel
        </a>
        <a href="{{ route('libros.pendientes') }}"
            class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded ml-2">
                ⚠️ Pendientes Código de Barras
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('libros.index') }}" class="mb-4">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
            placeholder="Buscar por título, autor, código o código de barras... (Enter para buscar)"
            class="w-full border-gray-300 rounded shadow-sm p-2">
        </form>

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Código</th>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Autor</th>
                    <th class="p-3 text-left">Tipo</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Disponibles</th>
                    <th class="p-3 text-left">Localización</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                <tr class="border-t">
                    <td class="p-3">{{ $libro->codigo }}</td>
                    <td class="p-3">{{ $libro->titulo }}</td>
                    <td class="p-3">{{ $libro->autor }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $libro->tipo === 'Regular' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $libro->tipo === 'Donado' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $libro->tipo === 'Adquirido' ? 'bg-purple-100 text-purple-700' : '' }}">
                            {{ $libro->tipo }}
                        </span>
                    </td>
                    <td class="p-3">{{ $libro->carrera->nombre }}</td>
                    <td class="p-3">{{ $libro->cantidad_disponible }} / {{ $libro->cantidad_total }}</td>
                    <td class="p-3">{{ $libro->localizacion ?: '—' }}</td>                    <td class="p-3 flex gap-2">
                        <a href="{{ route('libros.edit', $libro) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Editar</a>
                        <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este libro?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $libros->links() }}
        </div>
    </div>
</x-app-layout>