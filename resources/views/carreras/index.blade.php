<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carreras</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('carreras.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Carrera
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Clave</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Activa</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carreras as $carrera)
                <tr class="border-t">
                    <td class="p-3">{{ $carrera->clave }}</td>
                    <td class="p-3">{{ $carrera->nombre }}</td>
                    <td class="p-3">{{ $carrera->activa ? 'Sí' : 'No' }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('carreras.edit', $carrera) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Editar</a>
                        <form action="{{ route('carreras.destroy', $carrera) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta carrera?')">
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