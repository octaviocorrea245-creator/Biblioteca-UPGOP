<x-app-layout>
    <x-slot name="header">Editar Carrera</x-slot>

    <style>
        .fw{max-width:520px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden}
        .fh{background:#0D1B35;padding:.7rem 1.1rem;display:flex;align-items:center;gap:.6rem}
        .fh svg{opacity:.75;flex-shrink:0}
        .fh h2{font-size:.82rem;font-weight:700;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.07em}
        .fb{padding:1.25rem 1.5rem}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
        @media(max-width:480px){.g2{grid-template-columns:1fr}}
        .f{margin-bottom:.85rem}
        .f label{display:block;font-size:.68rem;font-weight:700;color:#8496B0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.28rem}
        .f input,.f select{width:100%;border:1.5px solid #E0E8F4;border-radius:8px;padding:.48rem .8rem;font-size:.82rem;color:#2D3E58;background:#fff;outline:none;transition:border .2s;box-sizing:border-box}
        .f input:focus,.f select:focus{border-color:#1A56B0}
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
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <h2>Editar Carrera</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('carreras.update', $carrera) }}">
                    @csrf @method('PUT')
                    <div class="g2">
                        <div class="f">
                            <label>Clave</label>
                            <input type="text" name="clave" value="{{ old('clave', $carrera->clave) }}">
                            @error('clave')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Estado</label>
                            <select name="activa">
                                <option value="1" {{ old('activa', $carrera->activa) == 1 ? 'selected' : '' }}>Activa</option>
                                <option value="0" {{ old('activa', $carrera->activa) == 0 ? 'selected' : '' }}>Inactiva</option>
                            </select>
                        </div>
                    </div>
                    <div class="f">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $carrera->nombre) }}">
                        @error('nombre')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Actualizar</button>
                            <a href="{{ route('carreras.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                        <form action="{{ route('carreras.destroy', $carrera) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta carrera?')">
                            @csrf @method('DELETE')
                            <button class="btn bdel">Eliminar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
