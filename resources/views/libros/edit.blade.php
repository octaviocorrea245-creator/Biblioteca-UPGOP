<x-app-layout>
    <x-slot name="header">Editar Libro</x-slot>

    <style>
        .fw{max-width:680px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden;margin-bottom:1rem}
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
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <h2>Editar Libro</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('libros.update', $libro) }}">
                    @csrf @method('PUT')
                    <div class="g2">
                        <div class="f">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">— Sin carrera —</option>
                                @foreach($carreras as $c)
                                    <option value="{{ $c->id }}" {{ old('carrera_id', $libro->carrera_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Tipo</label>
                            <select name="tipo">
                                <option value="Regular" {{ old('tipo',$libro->tipo)==='Regular'?'selected':'' }}>Regular</option>
                                <option value="Donado" {{ old('tipo',$libro->tipo)==='Donado'?'selected':'' }}>Donado</option>
                                <option value="Adquirido" {{ old('tipo',$libro->tipo)==='Adquirido'?'selected':'' }}>Adquirido</option>
                            </select>
                        </div>
                    </div>
                    <div class="f">
                        <label>Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo', $libro->titulo) }}">
                        @error('titulo')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Autor</label>
                            <input type="text" name="autor" value="{{ old('autor', $libro->autor) }}">
                            @error('autor')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Editorial</label>
                            <input type="text" name="editorial" value="{{ old('editorial', $libro->editorial) }}">
                            @error('editorial')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Código</label>
                            <input type="text" name="codigo" value="{{ old('codigo', $libro->codigo) }}">
                            @error('codigo')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Código de barras</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $libro->codigo_barras) }}">
                        </div>
                    </div>
                    <div class="g3">
                        <div class="f">
                            <label>Localización</label>
                            <input type="text" name="localizacion" value="{{ old('localizacion', $libro->localizacion) }}">
                        </div>
                        <div class="f">
                            <label>Cantidad total</label>
                            <input type="number" name="cantidad_total" value="{{ old('cantidad_total', $libro->cantidad_total) }}" min="1">
                            @error('cantidad_total')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Disponibles</label>
                            <input type="number" name="cantidad_disponible" value="{{ old('cantidad_disponible', $libro->cantidad_disponible) }}" min="0">
                            @error('cantidad_disponible')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Costo</label>
                            <input type="number" step="0.01" name="costo" value="{{ old('costo', $libro->costo) }}">
                        </div>
                    </div>
                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Actualizar</button>
                            <a href="{{ route('libros.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                        <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este libro?')">
                            @csrf @method('DELETE')
                            <button class="btn bdel">Eliminar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
