<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vale de Préstamo #{{ $prestamo->folio }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-4 border-b pb-2">Datos del Préstamo</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="font-medium">Folio:</span> #{{ $prestamo->folio }}</div>
                <div><span class="font-medium">Estado:</span> {{ $prestamo->estado }}</div>
                <div><span class="font-medium">Alumno:</span> {{ $prestamo->alumno->nombre }}</div>
                <div><span class="font-medium">Matrícula:</span> {{ $prestamo->alumno->matricula }}</div>
                <div><span class="font-medium">Carrera:</span> {{ $prestamo->carrera->nombre }}</div>
                <div><span class="font-medium">Cuatrimestre:</span> {{ $prestamo->cuatrimestre }}</div>
                <div><span class="font-medium">Libro:</span> {{ $prestamo->libro->titulo }}</div>
                <div><span class="font-medium">Código:</span> {{ $prestamo->libro->codigo }}</div>
                <div><span class="font-medium">F. Préstamo:</span> {{ $prestamo->fecha_prestamo->format('d/m/Y') }}</div>
                <div><span class="font-medium">F. Esperada:</span> {{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</div>
                @if($prestamo->fecha_devolucion_real)
                <div><span class="font-medium">F. Devolución:</span> {{ $prestamo->fecha_devolucion_real->format('d/m/Y') }}</div>
                @endif
                @if($prestamo->observaciones)
                <div class="col-span-2"><span class="font-medium">Observaciones:</span> {{ $prestamo->observaciones }}</div>
                @endif
            </div>
            <div class="mt-6 flex gap-3">
                @if($prestamo->estado === 'Activo')
                <form action="{{ route('prestamos.devolver', $prestamo) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="bg-green-500 text-white px-4 py-2 rounded">Registrar Devolución</button>
                </form>
                @endif
                <a href="{{ route('prestamos.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Regresar</a>
            </div>
        </div>
    </div>
</x-app-layout>