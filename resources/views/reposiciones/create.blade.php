<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Reposición</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('reposiciones.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Préstamo</label>
                <select name="prestamo_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona el préstamo --</option>
                    @foreach($prestamos as $prestamo)
                        <option value="{{ $prestamo->id }}" {{ old('prestamo_id') == $prestamo->id ? 'selected' : '' }}>
                            #{{ $prestamo->folio }} — {{ $prestamo->alumno->nombre }} — {{ $prestamo->libro->titulo }}
                        </option>
                    @endforeach
                </select>
                @error('prestamo_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipo de reposición</label>
                <select name="tipo" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="Perdida" {{ old('tipo') === 'Perdida' ? 'selected' : '' }}>Pérdida</option>
                    <option value="Daño" {{ old('tipo') === 'Daño' ? 'selected' : '' }}>Daño</option>
                </select>
                @error('tipo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Monto a reponer</label>
                <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" min="0"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('monto') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha de reporte</label>
                <input type="date" name="fecha_reporte" value="{{ old('fecha_reporte', date('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha_reporte') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('observaciones') }}</textarea>
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Registrar Reposición</button>
            <a href="{{ route('reposiciones.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>