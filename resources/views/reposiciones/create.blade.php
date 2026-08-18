<x-app-layout>
    <x-slot name="header">Nueva Reposición</x-slot>

    <style>
        .fw{max-width:580px;margin:0 auto}
        .fc{background:#fff;border-radius:12px;box-shadow:0 1px 6px rgba(13,27,53,.08);overflow:hidden}
        .fh{background:#0D1B35;padding:.7rem 1.1rem;display:flex;align-items:center;gap:.6rem}
        .fh svg{opacity:.75;flex-shrink:0}
        .fh h2{font-size:.82rem;font-weight:700;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.07em}
        .fb{padding:1.25rem 1.5rem}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem}
        @media(max-width:520px){.g2{grid-template-columns:1fr}}
        .f{margin-bottom:.85rem}
        .f label{display:block;font-size:.68rem;font-weight:700;color:#8496B0;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.28rem}
        .f input,.f select,.f textarea{width:100%;border:1.5px solid #E0E8F4;border-radius:8px;padding:.48rem .8rem;font-size:.82rem;color:#2D3E58;background:#fff;outline:none;transition:border .2s;box-sizing:border-box}
        .f input:focus,.f select:focus,.f textarea:focus{border-color:#1A56B0}
        .f textarea{resize:vertical;min-height:72px}
        .fe{display:block;font-size:.7rem;color:#C0392B;margin-top:.22rem}
        .ff{display:flex;gap:.6rem;align-items:center;margin-top:1.1rem;padding-top:1rem;border-top:1px solid #F0F4FA}
        .btn{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem .9rem;border-radius:8px;font-size:.78rem;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:opacity .15s,transform .15s}
        .btn:hover{opacity:.88;transform:translateY(-1px)}
        .bs{background:#C0392B;color:#fff}
        .bcan{background:#F4F6FB;color:#2D3E58;border:1px solid #E0E8F4}
    </style>

    <div class="fw">
        <div class="fc">
            <div class="fh">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
                <h2>Nueva Reposición</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('reposiciones.store') }}">
                    @csrf
                    <div class="f">
                        <label>Préstamo</label>
                        <select name="prestamo_id">
                            <option value="">— Selecciona el préstamo —</option>
                            @foreach($prestamos as $p)
                                <option value="{{ $p->id }}" {{ old('prestamo_id') == $p->id ? 'selected' : '' }}>
                                    #{{ $p->folio }} — {{ $p->alumno->nombre }} — {{ \Illuminate\Support\Str::limit($p->libro->titulo, 35) }}
                                </option>
                            @endforeach
                        </select>
                        @error('prestamo_id')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Tipo de reposición</label>
                            <select name="tipo">
                                <option value="Perdida" {{ old('tipo')==='Perdida'?'selected':'' }}>Pérdida</option>
                                <option value="Daño" {{ old('tipo')==='Daño'?'selected':'' }}>Daño</option>
                            </select>
                            @error('tipo')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Monto a reponer</label>
                            <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" min="0" placeholder="0.00">
                            @error('monto')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="f">
                        <label>Fecha de reporte</label>
                        <input type="date" name="fecha_reporte" value="{{ old('fecha_reporte', date('Y-m-d')) }}">
                        @error('fecha_reporte')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="f">
                        <label>Observaciones</label>
                        <textarea name="observaciones">{{ old('observaciones') }}</textarea>
                    </div>
                    <div class="ff">
                        <button type="submit" class="btn bs">Registrar reposición</button>
                        <a href="{{ route('reposiciones.index') }}" class="btn bcan">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
