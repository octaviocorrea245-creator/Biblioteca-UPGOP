<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Adquisiciones</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('adquisiciones.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nueva Adquisición
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <input type="text" id="buscador" placeholder="Buscar por título, proveedor o carrera..."
                class="w-full border-gray-300 rounded shadow-sm p-2"
                onkeyup="buscarEnTabla()">
        </div>

        <table class="w-full bg-white shadow rounded mt-4">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Autor</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Cantidad</th>
                    <th class="p-3 text-left">Proveedor</th>
                    <th class="p-3 text-left">Factura</th>
                    <th class="p-3 text-left">Costo</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($adquisiciones as $adquisicion)
                <tr class="border-t">
                    <td class="p-3">{{ $adquisicion->titulo }}</td>
                    <td class="p-3">{{ $adquisicion->autor }}</td>
                    <td class="p-3">{{ $adquisicion->carrera->nombre }}</td>
                    <td class="p-3">{{ $adquisicion->cantidad }}</td>
                    <td class="p-3">{{ $adquisicion->proveedor }}</td>
                    <td class="p-3">{{ $adquisicion->factura }}</td>
                    <td class="p-3">${{ number_format($adquisicion->costo, 2) }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('adquisiciones.edit', $adquisicion) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded text-sm">Editar</a>
                        <form action="{{ route('adquisiciones.destroy', $adquisicion) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta adquisición?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $adquisiciones->links() }}
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