<x-app-layout>
    <x-slot name="header">Editar Donación</x-slot>

    <style>
        .fw{max-width:680px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden}
        .fh{background:#0D1B35;padding:.7rem 1.1rem;display:flex;align-items:center;gap:.6rem}
        .fh svg{opacity:.75;flex-shrink:0}
        .fh h2{font-size:.82rem;font-weight:700;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.07em}
        .fb{padding:1.25rem 1.5rem}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
        @media(max-width:580px){.g2{grid-template-columns:1fr}}
        .f{margin-bottom:.85rem}
        .f label{display:block;font-size:.68rem;font-weight:700;color:#8496B0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.28rem}
        .f input,.f select{width:100%;border:1.5px solid #E0E8F4;border-radius:8px;padding:.48rem .8rem;font-size:.82rem;color:#2D3E58;background:#fff;outline:none;transition:border .2s;box-sizing:border-box}
        .f input:focus,.f select:focus{border-color:#1A56B0}
        .fe{display:block;font-size:.7rem;color:#C0392B;margin-top:.22rem}
        .divider{font-size:.68rem;font-weight:700;color:#0D1B35;text-transform:uppercase;letter-spacing:.07em;padding:.5rem 0 .6rem;border-bottom:1px solid #F0F4FA;margin-bottom:.85rem}
        .ff{display:flex;align-items:center;justify-content:space-between;margin-top:1.1rem;padding-top:1rem;border-top:1px solid #F0F4FA}
        .fl{display:flex;gap:.6rem;align-items:center}
        .btn{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem .9rem;border-radius:8px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s,transform .15s}
        .btn:hover{opacity:.88;transform:translateY(-1px)}
        .bs{background:#1A56B0;color:#fff}
        .bcan{background:#F4F6FB;color:#2D3E58;border:1px solid #E0E8F4}
        .bdel{background:#FDF0EF;color:#C0392B;border:1px solid #F5C6C2}
        .bdel:hover{background:#C0392B;color:#fff;opacity:1}
    </style>

    <div class="fw">
        <div class="fc">
            <div class="fh">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <h2>Editar Donación</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('donaciones.update', $donacion) }}">
                    @csrf @method('PUT')
                    <div class="divider">Datos del libro</div>
                    <div class="f">
                        <label>Título del libro</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $donacion->titulo) }}">
                        @error('titulo')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Autor</label>
                            <input type="text" name="autor" value="{{ old('autor', $donacion->autor) }}">
                            @error('autor')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Editorial</label>
                            <input type="text" name="editorial" value="{{ old('editorial', $donacion->editorial) }}">
                            @error('editorial')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">— Selecciona —</option>
                                @foreach($carreras as $c)
                                    <option value="{{ $c->id }}" {{ old('carrera_id', $donacion->carrera_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Código de barras</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $donacion->codigo_barras) }}">
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Costo estimado</label>
                            <input type="number" step="0.01" name="costo" value="{{ old('costo', $donacion->costo) }}">
                        </div>
                        <div class="f">
                            <label>Fecha de donación</label>
                            <input type="date" name="fecha" value="{{ old('fecha', $donacion->fecha?->format('Y-m-d')) }}">
                            @error('fecha')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="divider">Datos del donante</div>
                    <div class="g2">
                        <div class="f">
                            <label>Nombre del alumno donante</label>
                            <input type="text" name="alumno_donante" value="{{ old('alumno_donante', $donacion->alumno_donante) }}">
                            @error('alumno_donante')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Matrícula del donante</label>
                            <input type="text" name="matricula_donante" value="{{ old('matricula_donante', $donacion->matricula_donante) }}">
                            @error('matricula_donante')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Cuatrimestre</label>
                            <input type="text" name="cuatrimestre" value="{{ old('cuatrimestre', $donacion->cuatrimestre) }}" placeholder="Ej: 2026-1">
                            @error('cuatrimestre')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Generación (año de ingreso)</label>
                            <input type="number" name="generacion" value="{{ old('generacion', $donacion->generacion) }}" min="2000" max="2099">
                            @error('generacion')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Actualizar</button>
                            <a href="{{ route('donaciones.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                        <form action="{{ route('donaciones.destroy', $donacion) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta donación?')">
                            @csrf @method('DELETE')
                            <button class="btn bdel">Eliminar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
