<x-app-layout>
    <x-slot name="header">Nuevo Préstamo</x-slot>

    <style>
        .fw{max-width:680px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden;margin-bottom:1rem}
        .fh{background:#0D1B35;padding:.7rem 1.1rem;display:flex;align-items:center;gap:.6rem}
        .fh svg{opacity:.75;flex-shrink:0}
        .fh h2{font-size:.82rem;font-weight:700;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.07em}
        .fb{padding:1.25rem 1.5rem}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
        @media(max-width:580px){.g2{grid-template-columns:1fr}}
        .f{margin-bottom:.85rem}
        .f label{display:block;font-size:.68rem;font-weight:700;color:#8496B0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.28rem}
        .f input,.f select,.f textarea{width:100%;border:1.5px solid #E0E8F4;border-radius:8px;padding:.48rem .8rem;font-size:.82rem;color:#2D3E58;background:#fff;outline:none;transition:border .2s;box-sizing:border-box}
        .f input:focus,.f select:focus,.f textarea:focus{border-color:#1A56B0}
        .f textarea{resize:vertical;min-height:72px}
        .fe{display:block;font-size:.7rem;color:#C0392B;margin-top:.22rem}
        .scan-input{background:#EBF5FB;border-color:#AED6F1}
        .scan-input:focus{background:#fff;border-color:#1A56B0}
        .scan-msg{font-size:.73rem;margin-top:.3rem;min-height:1.1em}
        .scan-ok{color:#27AE60}
        .scan-err{color:#C0392B}
        .scan-hint{color:#8496B0}
        .ff{display:flex;align-items:center;justify-content:space-between;margin-top:1.1rem;padding-top:1rem;border-top:1px solid #F0F4FA}
        .fl{display:flex;gap:.6rem;align-items:center}
        .btn{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem .9rem;border-radius:8px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s,transform .15s}
        .btn:hover{opacity:.88;transform:translateY(-1px)}
        .bs{background:#1A56B0;color:#fff}
        .bcan{background:#F4F6FB;color:#2D3E58;border:1px solid #E0E8F4}
    </style>

    <div class="fw">
        <div class="fc">
            <div class="fh">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M9 17H5a2 2 0 0 0-2 2"/><path d="M21 17h-4a2 2 0 0 1-2-2V5"/><rect x="9" y="3" width="6" height="14" rx="1"/></svg>
                <h2>Nuevo Préstamo</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('prestamos.store') }}">
                    @csrf
                    <div class="f">
                        <label>Alumno</label>
                        <select name="alumno_id">
                            <option value="">— Selecciona alumno —</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->nombre }} — {{ $alumno->matricula }}
                                </option>
                            @endforeach
                        </select>
                        @error('alumno_id')<span class="fe">{{ $message }}</span>@enderror
                    </div>

                    {{-- Escáner de código de barras --}}
                    <div class="f">
                        <label>
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:3px"><rect x="1" y="4" width="3" height="16"/><rect x="6" y="4" width="1" height="16"/><rect x="9" y="4" width="3" height="16"/><rect x="14" y="4" width="1" height="16"/><rect x="17" y="4" width="4" height="16"/></svg>
                            Escanear código de barras
                        </label>
                        <input type="text" id="escanerCodigoBarras" placeholder="Da clic aquí y escanea el código..." class="scan-input">
                        <div class="scan-msg scan-hint" id="mensajeEscaneo">Presiona Enter después de escanear para seleccionar el libro automáticamente</div>
                    </div>

                    <div class="f">
                        <label>Libro</label>
                        <select name="libro_id">
                            <option value="">— Selecciona libro —</option>
                            @foreach($libros as $libro)
                                <option value="{{ $libro->id }}" {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                                    {{ $libro->titulo }} — {{ $libro->codigo }} ({{ $libro->cantidad_disponible }} disp.)
                                </option>
                            @endforeach
                        </select>
                        @error('libro_id')<span class="fe">{{ $message }}</span>@enderror
                    </div>

                    <div class="g2">
                        <div class="f">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">— Selecciona —</option>
                                @foreach($carreras as $c)
                                    <option value="{{ $c->id }}" {{ old('carrera_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Cuatrimestre</label>
                            <input type="text" name="cuatrimestre" value="{{ old('cuatrimestre') }}" placeholder="Ej: 2026-1">
                            @error('cuatrimestre')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Fecha de préstamo</label>
                            <input type="date" name="fecha_prestamo" value="{{ old('fecha_prestamo', date('Y-m-d')) }}">
                            @error('fecha_prestamo')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Fecha esperada de devolución</label>
                            <input type="date" name="fecha_devolucion_esperada" value="{{ old('fecha_devolucion_esperada') }}">
                            @error('fecha_devolucion_esperada')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Año</label>
                            <input type="number" name="anio" value="{{ old('anio', date('Y')) }}" min="2000" max="2099">
                            @error('anio')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="f">
                        <label>Observaciones</label>
                        <textarea name="observaciones">{{ old('observaciones') }}</textarea>
                    </div>
                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Registrar préstamo</button>
                            <a href="{{ route('prestamos.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('escanerCodigoBarras').addEventListener('keypress', function(e) {
        if (e.key !== 'Enter') return;
        e.preventDefault();
        const codigo = this.value.trim();
        if (!codigo) return;
        const msg = document.getElementById('mensajeEscaneo');
        msg.textContent = 'Buscando...';
        msg.className = 'scan-msg scan-hint';
        fetch(`{{ route('libros.buscarPorCodigoBarras') }}?codigo_barras=${encodeURIComponent(codigo)}`)
            .then(r => r.json())
            .then(data => {
                if (data.encontrado) {
                    document.querySelector('select[name="libro_id"]').value = data.id;
                    msg.className = 'scan-msg scan-ok';
                    msg.textContent = `✓ ${data.titulo} (${data.disponible} disponibles)`;
                } else {
                    msg.className = 'scan-msg scan-err';
                    msg.textContent = '✗ No se encontró un libro con ese código de barras.';
                }
                this.value = '';
            })
            .catch(() => {
                msg.className = 'scan-msg scan-err';
                msg.textContent = '⚠ Error al buscar el libro.';
            });
    });
    </script>
</x-app-layout>
