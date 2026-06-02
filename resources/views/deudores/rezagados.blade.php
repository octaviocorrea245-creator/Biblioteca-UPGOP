<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rezagados</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <a href="{{ route('deudores.index') }}"
           class="mb-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded">
            Ver Deudores
        </a>

        @if($alumnos->isEmpty())
            <div class="mt-4 text-green-600">No hay rezagados activos.</div>
        @else
        <table class="w-full bg-white shadow rounded mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Matrícula</th>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Préstamos vencidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                <tr class="border-t">
                    <td class="p-3">{{ $alumno->matricula }}</td>
                    <td class="p-3">{{ $alumno->nombre }}</td>
                    <td class="p-3">{{ $alumno->carrera->nombre }}</td>
                    <td class="p-3">{{ $alumno->prestamos->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-app-layout>