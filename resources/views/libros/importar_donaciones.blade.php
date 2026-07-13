<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Importar Libros Donados</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow rounded p-6">
            <p class="text-sm text-gray-600 mb-2">
                Sube el archivo Excel con las hojas de donaciones. Los libros se registrarán como tipo <strong>Donado</strong> y aparecerán en el módulo de Donaciones.
            </p>
            <p class="text-sm text-blue-600 mb-4">
                ℹ️ La hoja <strong>LIBROS DONADOS</strong> usa un importador especial por tener formato diferente.
            </p>

            <form method="POST" id="formDonaciones" action="{{ route('libros.importar.donaciones') }}" enctype="multipart/form-data" class="mt-4">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Archivo Excel (.xlsx, .xls)</label>
                    <input type="file" name="archivo" id="inputArchivo" accept=".xlsx,.xls"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    @error('archivo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4" id="contenedorHojas" style="display:none;">
                    <label class="block text-sm font-medium text-gray-700">Selecciona la hoja a importar</label>
                    <select name="hoja" id="selectHoja" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    </select>
                    <p class="text-xs mt-1" id="notaHoja"></p>
                </div>

                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded">
                    Importar Donaciones
                </button>
                <a href="{{ route('donaciones.index') }}" class="ml-3 text-gray-600">Cancelar</a>
            </form>
        </div>
    </div>

    <script>
        const rutaNormal  = "{{ route('libros.importar.donaciones') }}";
        const rutaAntigua = "{{ route('libros.importar.donaciones.antiguas') }}";

        document.getElementById('inputArchivo').addEventListener('change', function (e) {
            const archivo = e.target.files[0];
            if (!archivo) return;

            const formData = new FormData();
            formData.append('archivo', archivo);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('libros.listarHojas') }}', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('selectHoja');
                const nota   = document.getElementById('notaHoja');
                const form   = document.getElementById('formDonaciones');
                select.innerHTML = '';

                if (data.hojas && data.hojas.length > 0) {
                    data.hojas.forEach(nombreHoja => {
                        const option = document.createElement('option');
                        option.value = nombreHoja;
                        option.textContent = nombreHoja;
                        select.appendChild(option);
                    });
                    document.getElementById('contenedorHojas').style.display = 'block';
                }

                select.addEventListener('change', function() {
                    const h = this.value.trim();
                    if (h === 'LIBROS DONADOS ' || h === 'LIBROS DONADOS') {
                        form.action = rutaAntigua;
                        nota.textContent = '⚠️ Hoja con formato diferente, se usará importador especial.';
                        nota.style.color = '#C0392B';
                    } else {
                        form.action = rutaNormal;
                        nota.textContent = '✅ Hoja compatible con el importador estándar.';
                        nota.style.color = '#27AE60';
                    }
                });

                select.dispatchEvent(new Event('change'));
            })
            .catch(() => {
                document.getElementById('contenedorHojas').style.display = 'none';
            });
        });
    </script>
</x-app-layout>