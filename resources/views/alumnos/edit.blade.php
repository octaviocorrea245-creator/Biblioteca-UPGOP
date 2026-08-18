<x-app-layout>
    <x-slot name="header">Editar Alumno</x-slot>

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
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <h2>Editar Alumno</h2>
            </div>
            <div class="fb">
                <form method="POST" action="{{ route('alumnos.update', $alumno) }}">
                    @csrf @method('PUT')
                    <div class="g2">
                        <div class="f">
                            <label>Matrícula</label>
                            <input type="text" name="matricula" value="{{ old('matricula', $alumno->matricula) }}">
                            @error('matricula')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">— Selecciona —</option>
                                @foreach($carreras as $c)
                                    <option value="{{ $c->id }}" {{ old('carrera_id', $alumno->carrera_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                            @error('carrera_id')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="f">
                        <label>Nombre completo</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $alumno->nombre) }}">
                        @error('nombre')<span class="fe">{{ $message }}</span>@enderror
                    </div>
                    <div class="g3">
                        <div class="f">
                            <label>Género</label>
                            <select name="genero">
                                <option value="M" {{ old('genero',$alumno->genero)==='M'?'selected':'' }}>Masculino</option>
                                <option value="F" {{ old('genero',$alumno->genero)==='F'?'selected':'' }}>Femenino</option>
                                <option value="Otro" {{ old('genero',$alumno->genero)==='Otro'?'selected':'' }}>Otro</option>
                            </select>
                        </div>
                        <div class="f">
                            <label>Cuatrimestre</label>
                            <input type="number" name="cuatrimestre" value="{{ old('cuatrimestre', $alumno->cuatrimestre) }}" min="1" max="12">
                            @error('cuatrimestre')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Turno</label>
                            <select name="turno">
                                <option value="M" {{ old('turno',$alumno->turno)==='M'?'selected':'' }}>Matutino</option>
                                <option value="V" {{ old('turno',$alumno->turno)==='V'?'selected':'' }}>Vespertino</option>
                                <option value="N" {{ old('turno',$alumno->turno)==='N'?'selected':'' }}>Nocturno</option>
                            </select>
                        </div>
                    </div>
                    <div class="g2">
                        <div class="f">
                            <label>Generación (año de ingreso)</label>
                            <input type="number" name="generacion" value="{{ old('generacion', $alumno->generacion) }}" min="2000" max="2099">
                            @error('generacion')<span class="fe">{{ $message }}</span>@enderror
                        </div>
                        <div class="f">
                            <label>Estado</label>
                            <select name="estado">
                                <option value="Activo" {{ old('estado',$alumno->estado)==='Activo'?'selected':'' }}>Activo</option>
                                <option value="Deudor" {{ old('estado',$alumno->estado)==='Deudor'?'selected':'' }}>Deudor</option>
                                <option value="Rezagado" {{ old('estado',$alumno->estado)==='Rezagado'?'selected':'' }}>Rezagado</option>
                            </select>
                        </div>
                    </div>
                    <div class="ff">
                        <div class="fl">
                            <button type="submit" class="btn bs">Actualizar</button>
                            <a href="{{ route('alumnos.index') }}" class="btn bcan">Cancelar</a>
                        </div>
                        <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este alumno?')">
                            @csrf @method('DELETE')
                            <button class="btn bdel">Eliminar</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
