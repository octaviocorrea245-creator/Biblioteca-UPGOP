<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reposiciones</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('reposiciones.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Reposición
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
         <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow rounded p-6 mb-4">
            <h3 class="font-semibold text-lg mb-3">Carga masiva de reposiciones</h3>
            <form action="{{ route('reposiciones.importar') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                @csrf
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-medium text-gray-700">Archivo XML</label>
                    <input type="file" name="xml_file" accept=".xml" class="mt-1 block w-full border-gray-300 rounded shadow-sm" />
                    @error('xml_file') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 mt-1">El archivo debe tener un elemento raíz <code>&lt;reposiciones&gt;</code> y elementos <code>&lt;reposicion&gt;</code> con <code>prestamo_id</code>, <code>tipo</code>, <code>monto</code> y <code>fecha_reporte</code>.</p>
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Importar XML</button>
            </form>
        </div>

        <div class="mb-4">
            <input type="text" id="buscador" placeholder="Buscar por alumno o libro..."
                class="w-full border-gray-300 rounded shadow-sm p-2"
                onkeyup="buscarEnTabla()">
        </div>
        <table class="w-full bg-white shadow rounded mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Alumno</th>
                    <th class="p-3 text-left">Libro</th>
                    <th class="p-3 text-left">Tipo</th>
                    <th class="p-3 text-left">Monto</th>
                    <th class="p-3 text-left">Estado pago</th>
                    <th class="p-3 text-left">Fecha reporte</th>
                    <th class="p-3 text-left">Fecha pago</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reposiciones as $reposicion)
                <tr class="border-t">
                    <td class="p-3">{{ $reposicion->alumno->nombre }}</td>
                    <td class="p-3">{{ $reposicion->libro->titulo }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $reposicion->tipo === 'Perdida' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $reposicion->tipo === 'Perdida' ? 'Pérdida' : 'Daño' }}
                        </span>
                    </td>
                    <td class="p-3">${{ number_format($reposicion->monto, 2) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $reposicion->estado_pago === 'Pendiente' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                            {{ $reposicion->estado_pago }}
                        </span>
                    </td>
                    <td class="p-3">{{ $reposicion->fecha_reporte->format('d/m/Y') }}</td>
                    <td class="p-3">{{ $reposicion->fecha_pago ? $reposicion->fecha_pago->format('d/m/Y') : '—' }}</td>
                    <td class="p-3 flex gap-2">
                        @if($reposicion->estado_pago === 'Pendiente')
                        <form action="{{ route('reposiciones.pago', $reposicion) }}" method="POST"
                              onsubmit="return confirm('¿Registrar pago de esta reposición?')">
                            @csrf @method('PATCH')
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">Registrar Pago</button>
                        </form>
                        @endif
                        <a href="{{ route('reposiciones.comprobante', $reposicion) }}"
                           class="bg-gray-500 text-white px-3 py-1 rounded text-sm" target="_blank">Comprobante</a>
                        <form action="{{ route('reposiciones.destroy', $reposicion) }}" method="POST"
                            onsubmit="return confirm('¿Eliminar esta reposición?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $reposiciones->links() }}
        </div>
    </div>
    <script>
        function buscarEnTabla() {
            const input = document.getElementById('buscador').value.toLowerCase();
            const filas = document.querySelectorAll('tbody tr');
            filas.forEach(fila => {
                const texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(input) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>