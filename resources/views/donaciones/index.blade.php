<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donaciones</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('donaciones.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Donación
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Código</th>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Autor</th>
                    <th class="p-3 text-left">Donante</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Fecha</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donaciones as $donacion)
                <tr class="border-t">
                    <td class="p-3">{{ $donacion->codigo_donacion }}</td>
                    <td class="p-3">{{ $donacion->titulo }}</td>
                    <td class="p-3">{{ $donacion->autor }}</td>
                    <td class="p-3">{{ $donacion->alumno_donante }}</td>
                    <td class="p-3">{{ $donacion->carrera->nombre }}</td>
                    <td class="p-3">{{ $donacion->fecha->format('d/m/Y') }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('donaciones.edit', $donacion) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Editar</a>
                        <form action="{{ route('donaciones.destroy', $donacion) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta donación?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>