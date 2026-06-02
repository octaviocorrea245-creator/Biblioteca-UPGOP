<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Préstamos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('prestamos.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nuevo Préstamo
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Folio</th>
                    <th class="p-3 text-left">Alumno</th>
                    <th class="p-3 text-left">Libro</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Cuatrimestre</th>
                    <th class="p-3 text-left">F. Préstamo</th>
                    <th class="p-3 text-left">F. Esperada</th>
                    <th class="p-3 text-left">Estado</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                <tr class="border-t">
                    <td class="p-3">#{{ $prestamo->folio }}</td>
                    <td class="p-3">{{ $prestamo->alumno->nombre }}</td>
                    <td class="p-3">{{ $prestamo->libro->titulo }}</td>
                    <td class="p-3">{{ $prestamo->carrera->nombre }}</td>
                    <td class="p-3">{{ $prestamo->cuatrimestre }}</td>
                    <td class="p-3">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $prestamo->estado === 'Activo' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $prestamo->estado === 'Devuelto' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $prestamo->estado === 'Vencido' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $prestamo->estado }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('prestamos.show', $prestamo) }}"
                           class="bg-blue-400 text-white px-3 py-1 rounded text-sm">Ver</a>
                           <a href="{{ route('prestamos.vale', $prestamo) }}" class="bg-gray-500 text-white px-3 py-1 rounded text-sm" target="_blank">Vale PDF</a>
                        @if(strtolower(trim($prestamo->estado)) === 'activo')
                        <form action="{{ route('prestamos.devolver', $prestamo) }}" method="POST"
                              onsubmit="return confirm('¿Registrar devolución?')">
                            @csrf @method('PATCH')
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">Devolver</button>
                        </form>
                        @endif
                        <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este préstamo?')">
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