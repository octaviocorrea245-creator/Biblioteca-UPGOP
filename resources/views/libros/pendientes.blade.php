<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Libros sin Código de Barras Definitivo</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-700 px-4 py-3 rounded">
            📋 Estos libros se importaron sin código de barras real y recibieron uno temporal. Escanea o captura el código real de cada uno cuando lo tengas a la mano.
        </div>

        <form method="GET" action="{{ route('libros.pendientes') }}" class="mb-4">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                   placeholder="Buscar por título o autor... (Enter para buscar)"
                   class="w-full border-gray-300 rounded shadow-sm p-2">
        </form>

        @if($libros->isEmpty())
            <p class="text-green-600">🎉 No hay libros pendientes, todos tienen código de barras real.</p>
        @else
        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Código temporal</th>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Autor</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Nuevo código de barras</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                <tr class="border-t">
                    <td class="p-3 text-sm text-gray-500">{{ $libro->codigo_barras }}</td>
                    <td class="p-3">{{ $libro->titulo }}</td>
                    <td class="p-3">{{ $libro->autor }}</td>
                    <td class="p-3">{{ $libro->carrera->nombre ?? '—' }}</td>
                    <td class="p-3">
                        <form action="{{ route('libros.actualizarCodigoBarras', $libro) }}" method="POST" class="flex gap-2">
                            @csrf @method('PATCH')
                            <input type="text" name="codigo_barras" placeholder="Escanea o escribe el código real"
                                   class="border-gray-300 rounded shadow-sm p-1 text-sm" required>
                            <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Guardar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $libros->links() }}
        </div>
        @endif
    </div>
</x-app-layout>