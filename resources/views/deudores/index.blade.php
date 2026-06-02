<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deudores y Rezagados</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- DEUDORES --}}
        <div class="bg-white shadow rounded p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-lg text-yellow-700">
                    ⚠ Deudores
                    <span class="ml-2 bg-yellow-100 text-yellow-700 text-sm px-2 py-1 rounded">
                        {{ $deudores->count() }}
                    </span>
                </h3>
            </div>

            @if($deudores->isEmpty())
                <p class="text-green-600 text-sm">No hay deudores activos.</p>
            @else
            <table class="w-full">
                <thead class="bg-yellow-50">
                    <tr>
                        <th class="p-3 text-left text-sm">Matrícula</th>
                        <th class="p-3 text-left text-sm">Nombre</th>
                        <th class="p-3 text-left text-sm">Carrera</th>
                        <th class="p-3 text-left text-sm">Cuatrimestre</th>
                        <th class="p-3 text-left text-sm">Préstamos vencidos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deudores as $alumno)
                    <tr class="border-t">
                        <td class="p-3 text-sm">{{ $alumno->matricula }}</td>
                        <td class="p-3 text-sm">{{ $alumno->nombre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->carrera->nombre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->cuatrimestre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->prestamos->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- REZAGADOS --}}
        <div class="bg-white shadow rounded p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-lg text-red-700">
                    🚫 Rezagados
                    <span class="ml-2 bg-red-100 text-red-700 text-sm px-2 py-1 rounded">
                        {{ $rezagados->count() }}
                    </span>
                </h3>
            </div>

            @if($rezagados->isEmpty())
                <p class="text-green-600 text-sm">No hay rezagados activos.</p>
            @else
            <table class="w-full">
                <thead class="bg-red-50">
                    <tr>
                        <th class="p-3 text-left text-sm">Matrícula</th>
                        <th class="p-3 text-left text-sm">Nombre</th>
                        <th class="p-3 text-left text-sm">Carrera</th>
                        <th class="p-3 text-left text-sm">Cuatrimestre</th>
                        <th class="p-3 text-left text-sm">Préstamos vencidos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rezagados as $alumno)
                    <tr class="border-t">
                        <td class="p-3 text-sm">{{ $alumno->matricula }}</td>
                        <td class="p-3 text-sm">{{ $alumno->nombre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->carrera->nombre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->cuatrimestre }}</td>
                        <td class="p-3 text-sm">{{ $alumno->prestamos->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
</x-app-layout>