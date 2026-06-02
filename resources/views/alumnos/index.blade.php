<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alumnos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('alumnos.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nuevo Alumno
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Matrícula</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Cuatrimestre</th>
                    <th class="p-3 text-left">Turno</th>
                    <th class="p-3 text-left">Estado</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                <tr class="border-t">
                    <td class="p-3">{{ $alumno->matricula }}</td>
                    <td class="p-3">{{ $alumno->nombre }}</td>
                    <td class="p-3">{{ $alumno->carrera->nombre }}</td>
                    <td class="p-3">{{ $alumno->cuatrimestre }}</td>
                    <td class="p-3">{{ $alumno->turno }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $alumno->estado === 'Activo' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $alumno->estado === 'Deudor' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $alumno->estado === 'Rezagado' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $alumno->estado }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('alumnos.edit', $alumno) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Editar</a>
                        <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este alumno?')">
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