<x-app-layout>
    <x-slot name="header">Editar Adquisición</x-slot>

    <style>
        .fw{max-width:680px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden}
        .fh{background:#0D1B35;padding:.7rem 1.1rem;display:flex;align-items:center;gap:.6rem}
        .fh svg{opacity:.75;flex-shrink:0}
        .fh h2{font-size:.82rem;font-weight:700;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.07em}
        .fb{padding:1.25rem 1.5rem}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
        .g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:.85rem}
        @media(max-width:580px){.g2,.g3{grid-template-columns:1fr}}
        .f{margin-bottom:.85rem}
        .f label{display:block;font-size:.68rem;font-weight:700;color:#8496B0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.28rem}
        .f input,.f select,.f textarea{width:100%;border:1.5px solid #E0E8F4;border-radius:8px;padding:.48rem .8rem;font-size:.82rem;color:#2D3E58;background:#fff;outline:none;transition:border .2s;box-sizing:border-box}
        .f input:focus,.f select:focus,.f textarea:focus{border-color:#1A56B0}
        .f textarea{resize:vertical;min-height:68px}
        .fe{display:block;font-size:.7rem;color:#C0392B;margin-top:.22rem}
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
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <h2>Editar Adquisición</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('adquisiciones.update', $adquisicion) }}">
                    @csrf @method('PUT')
                    <div class="f">
                        <label>Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $adquisicion->titulo) }}">
                        @error('titulo')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Autor</label>
                            <input type="text" name="autor" value="{{ old('autor', $adquisicion->autor) }}">
                            @error('autor')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Editorial</label>
                            <input type="text" name="editorial" value="{{ old('editorial', $adquisicion->editorial) }}">
                            @error('editorial')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g3">
                        <div class="f">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">— Selecciona —</option>
                                @foreach($carreras as $c)
                                    <option value="{{ $c->id }}" {{ old('carrera_id', $adquisicion->carrera_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Cantidad</label>
                            <input type="number" name="cantidad" value="{{ old('cantidad', $adquisicion->cantidad) }}" min="1">
                            @error('cantidad')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Costo</label>
                            <input type="number" step="0.01" name="costo" value="{{ old('costo', $adquisicion->costo) }}">
                            @error('costo')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Proveedor</label>
                            <input type="text" name="proveedor" value="{{ old('proveedor', $adquisicion->proveedor) }}">
                            @error('proveedor')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Número de factura</label>
                            <input type="text" name="factura" value="{{ old('factura', $adquisicion->factura) }}">
                            @error('factura')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Fecha de factura</label>
                            <input type="date" name="fecha_factura" value="{{ old('fecha_factura', $adquisicion->fecha_factura?->format('Y-m-d')) }}">
                            @error('fecha_factura')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Localización</label>
                            <input type="text" name="localizacion" value="{{ old('localizacion', $adquisicion->localizacion) }}">
                        </div>
                    </div>
                    <div class="f">
                        <label>Código de barras</label>
                        <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $adquisicion->codigo_barras) }}">
                    </div>
                    <div class="f">
                        <label>Observaciones</label>
                        <textarea name="observacion">{{ old('observacion', $adquisicion->observacion) }}</textarea>
                    </div>
                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Actualizar</button>
                            <a href="{{ route('adquisiciones.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                        <form action="{{ route('adquisiciones.destroy', $adquisicion) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta adquisición?')">
                            @csrf @method('DELETE')
                            <button class="btn bdel">Eliminar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
