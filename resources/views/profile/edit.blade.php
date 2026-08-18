<x-app-layout>
    <x-slot name="header">Mi Perfil</x-slot>

    <style>
        .prof-page { max-width: 740px; margin: 0 auto; }

        /* ── Hero bar ── */
        .prof-hero {
            background: #fff; border-radius: 12px;
            box-shadow: 0 1px 6px rgba(13,27,53,.08);
            padding: 1.25rem 1.75rem;
            display: flex; align-items: center; gap: 1.25rem;
            margin-bottom: 1rem;
        }
        .prof-avatar {
            width: 62px; height: 62px; border-radius: 50%;
            background: linear-gradient(135deg, #1A56B0, #0D1B35);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.45rem; font-weight: 700;
            flex-shrink: 0; border: 3px solid #E0E8F4;
        }
        .prof-hero-name  { font-size: 1.1rem; font-weight: 700; color: #0D1B35; }
        .prof-hero-email { font-size: .77rem; color: #8496B0; margin-top: .1rem; }
        .prof-hero-role  {
            display: inline-block; margin-top: .4rem;
            font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em;
            background: rgba(26,86,176,.09); color: #1A56B0;
            padding: .18rem .6rem; border-radius: 20px;
        }

        /* ── Card with rows ── */
        .prof-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 1px 6px rgba(13,27,53,.08);
            overflow: hidden; margin-bottom: 1rem;
        }

        /* ── Each row ── */
        .prof-row {
            display: flex; align-items: center;
            padding: .9rem 1.5rem;
            border-bottom: 1px solid #F0F4FA;
            cursor: pointer; transition: background .12s;
            user-select: none;
        }
        .prof-row:last-child { border-bottom: none; }
        .prof-row:hover { background: #F7F9FD; }
        .prof-row.active { background: #EBF5FB; }

        .prof-row-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: #F0F4FA;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-right: .9rem;
        }
        .prof-row-icon svg { width: 15px; height: 15px; }

        .prof-row-meta { flex: 1; min-width: 0; }
        .prof-row-label { font-size: .68rem; color: #8496B0; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
        .prof-row-value { font-size: .85rem; color: #0D1B35; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 420px; }

        .prof-row-link { font-size: .75rem; font-weight: 600; color: #1A56B0; margin-left: 1rem; flex-shrink: 0; }

        /* ── Expandable inline form ── */
        .prof-section {
            display: none;
            padding: 1.1rem 1.5rem;
            background: #F7FAFF;
            border-bottom: 1px solid #E0E8F4;
        }
        .prof-section.open { display: block; }

        /* ── Form elements ── */
        .fgrid { display: grid; grid-template-columns: 1fr 1fr; gap: .8rem; }
        @media(max-width:520px){ .fgrid { grid-template-columns: 1fr; } }
        .pf { margin-bottom: .72rem; }
        .pf label { display: block; font-size: .67rem; font-weight: 700; color: #8496B0; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .25rem; }
        .pf input { width: 100%; border: 1.5px solid #D8E2EF; border-radius: 8px; padding: .46rem .78rem; font-size: .82rem; color: #0D1B35; background: #fff; outline: none; transition: border .2s; box-sizing: border-box; }
        .pf input:focus { border-color: #1A56B0; }
        .pf input.err { border-color: #C0392B; }
        .fe { font-size: .7rem; color: #C0392B; margin-top: .2rem; }

        /* Password */
        .pw-wrap { position: relative; }
        .pw-toggle { position: absolute; right: .7rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #8496B0; padding: 0; display: flex; }
        .pw-toggle:hover { color: #1A56B0; }
        .pw-wrap input { padding-right: 2.4rem; }
        .pw-bar { display: flex; gap: 3px; margin-top: .35rem; }
        .pw-bar span { flex: 1; height: 3px; border-radius: 2px; background: #E8EDF5; transition: background .25s; }
        .pw-lbl { font-size: .67rem; color: #8496B0; margin-top: .2rem; }
        .pw-reqs { font-size: .69rem; color: #8496B0; margin-top: .4rem; }
        .req { display: flex; align-items: center; gap: .3rem; line-height: 1.7; }
        .req svg { width: 11px; height: 11px; flex-shrink: 0; }
        .req.ok { color: #27AE60; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: .35rem; padding: .4rem .88rem; border-radius: 8px; font-size: .77rem; font-weight: 600; cursor: pointer; border: none; transition: opacity .15s, transform .15s; text-decoration: none; }
        .btn:hover { opacity: .88; transform: translateY(-1px); }
        .btn-blue { background: #1A56B0; color: #fff; }
        .btn-gray { background: #F4F6FB; color: #2D3E58; border: 1px solid #D8E2EF; }
        .btn-red  { background: #FDF0EF; color: #C0392B; border: 1px solid #F5C6C2; }
        .btn-red:hover  { background: #C0392B; color: #fff; opacity: 1; }
        .btn-del  { background: #C0392B; color: #fff; }
        .pf-actions { display: flex; gap: .5rem; margin-top: .85rem; }

        /* Alerts */
        .alert { border-radius: 9px; padding: .6rem 1rem; font-size: .78rem; margin-bottom: .8rem; }
        .alert-s { background: #EAFAF1; color: #1E8449; border: 1px solid #A9DFBF; }
        .alert-e { background: #FDECEA; color: #922B21; border: 1px solid #F1948A; }

        /* User rows inside section */
        .user-row { display: flex; align-items: center; justify-content: space-between; padding: .5rem 0; border-bottom: 1px solid #E8EDF5; }
        .user-row:last-child { border-bottom: none; }
        .u-badge { font-size: .63rem; font-weight: 700; background: rgba(39,174,96,.1); color: #1E8449; padding: .13rem .42rem; border-radius: 20px; margin-left: .4rem; }

        /* Section sub-divider */
        .sec-divider { font-size: .67rem; font-weight: 700; color: #0D1B35; text-transform: uppercase; letter-spacing: .07em; padding: .6rem 0 .55rem; border-top: 1px solid #E8EDF5; margin-top: .5rem; margin-bottom: .6rem; }

        /* Danger row */
        .danger-card { background: #fff; border-radius: 12px; box-shadow: 0 1px 6px rgba(13,27,53,.08); border: 1px solid #F5C6C2; overflow: hidden; }
        .danger-row { display: flex; align-items: center; padding: .88rem 1.5rem; gap: .9rem; }
        .danger-row-icon { width: 34px; height: 34px; border-radius: 8px; background: rgba(192,57,43,.08); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .danger-row-icon svg { width: 15px; height: 15px; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(13,27,53,.5); z-index: 9999; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #fff; border-radius: 14px; padding: 1.75rem; max-width: 420px; width: 92%; box-shadow: 0 20px 60px rgba(13,27,53,.25); }
        .modal-title { font-size: .95rem; font-weight: 700; color: #0D1B35; margin-bottom: .4rem; }
        .modal-desc  { font-size: .79rem; color: #8496B0; line-height: 1.6; margin-bottom: 1rem; }
        .modal-actions { display: flex; gap: .6rem; justify-content: flex-end; margin-top: 1rem; }
    </style>

    <div class="prof-page">

        {{-- ── Alerts ── --}}
        @if(session('status') === 'profile-updated')
            <div class="alert alert-s">✅ Perfil actualizado correctamente.</div>
        @endif
        @if(session('status') === 'password-updated')
            <div class="alert alert-s">✅ Contraseña cambiada correctamente.</div>
        @endif
        @if(session('status') === 'user-created')
            <div class="alert alert-s">✅ Nueva cuenta de administrador creada.</div>
        @endif

        {{-- ── Hero ── --}}
        <div class="prof-hero">
            <div class="prof-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="prof-hero-name">{{ Auth::user()->name }}</div>
                <div class="prof-hero-email">{{ Auth::user()->email }}</div>
                <div class="prof-hero-role">Administrador · Biblioteca UPGOP</div>
            </div>
        </div>

        {{-- ── Main rows card ── --}}
        <div class="prof-card">

            {{-- Row 1: Información personal --}}
            <div class="prof-row {{ $errors->has('name') || $errors->has('email') ? 'active' : '' }}"
                 onclick="toggle('info')">
                <div class="prof-row-icon">
                    <svg fill="none" stroke="#1A56B0" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="prof-row-meta">
                    <div class="prof-row-label">Información personal</div>
                    <div class="prof-row-value">{{ Auth::user()->name }} · {{ Auth::user()->email }}</div>
                </div>
                <span class="prof-row-link">Editar ›</span>
            </div>
            <div class="prof-section {{ $errors->has('name') || $errors->has('email') ? 'open' : '' }}" id="s-info">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="fgrid">
                        <div class="pf">
                            <label>Nombre completo</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="{{ $errors->has('name') ? 'err' : '' }}" required autofocus>
                            @error('name')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                        <div class="pf">
                            <label>Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="{{ $errors->has('email') ? 'err' : '' }}" required>
                            @error('email')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="pf-actions">
                        <button type="submit" class="btn btn-blue">Guardar cambios</button>
                        <button type="button" class="btn btn-gray" onclick="toggle('info')">Cancelar</button>
                    </div>
                </form>
            </div>

            {{-- Row 2: Contraseña --}}
            <div class="prof-row {{ $errors->updatePassword->any() ? 'active' : '' }}"
                 onclick="toggle('pass')">
                <div class="prof-row-icon">
                    <svg fill="none" stroke="#27AE60" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="prof-row-meta">
                    <div class="prof-row-label">Contraseña</div>
                    <div class="prof-row-value" style="letter-spacing:.18em; color:#8496B0;">••••••••</div>
                </div>
                <span class="prof-row-link">Cambiar ›</span>
            </div>
            <div class="prof-section {{ $errors->updatePassword->any() ? 'open' : '' }}" id="s-pass">
                @if($errors->updatePassword->any())
                    <div class="alert alert-e">@foreach($errors->updatePassword->all() as $e){{ $e }}<br>@endforeach</div>
                @endif
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')
                    <div class="pf">
                        <label>Contraseña actual</label>
                        <div class="pw-wrap">
                            <input type="password" id="cur_pw" name="current_password"
                                   class="{{ $errors->updatePassword->has('current_password') ? 'err' : '' }}"
                                   autocomplete="current-password" placeholder="••••••••">
                            <button type="button" class="pw-toggle" onclick="togglePw('cur_pw',this)">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('current_password','updatePassword')<div class="fe">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgrid">
                        <div class="pf">
                            <label>Nueva contraseña</label>
                            <div class="pw-wrap">
                                <input type="password" id="new_pw" name="password"
                                       class="{{ $errors->updatePassword->has('password') ? 'err' : '' }}"
                                       autocomplete="new-password" placeholder="••••••••" oninput="evalStr(this.value)">
                                <button type="button" class="pw-toggle" onclick="togglePw('new_pw',this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="pw-bar"><span id="b1"></span><span id="b2"></span><span id="b3"></span><span id="b4"></span></div>
                            <div class="pw-lbl" id="strLbl"></div>
                            <div class="pw-reqs">
                                <div class="req" id="rl"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> 8 caracteres mínimo</div>
                                <div class="req" id="rle"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Al menos una letra</div>
                                <div class="req" id="rn"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg> Al menos un número</div>
                            </div>
                            @error('password','updatePassword')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                        <div class="pf">
                            <label>Confirmar contraseña</label>
                            <div class="pw-wrap">
                                <input type="password" id="pw_cf" name="password_confirmation"
                                       autocomplete="new-password" placeholder="••••••••" oninput="chkMatch()">
                                <button type="button" class="pw-toggle" onclick="togglePw('pw_cf',this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="pw-lbl" id="mchLbl"></div>
                        </div>
                    </div>
                    <div class="pf-actions">
                        <button type="submit" class="btn btn-blue">Actualizar contraseña</button>
                        <button type="button" class="btn btn-gray" onclick="toggle('pass')">Cancelar</button>
                    </div>
                </form>
            </div>

            {{-- Row 3: Administradores --}}
            @php $usuarios = \App\Models\User::orderBy('name')->get(); @endphp
            <div class="prof-row {{ $errors->has('new_name') || $errors->has('new_email') || $errors->has('new_password') ? 'active' : '' }}"
                 onclick="toggle('users')">
                <div class="prof-row-icon">
                    <svg fill="none" stroke="#8E44AD" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="prof-row-meta">
                    <div class="prof-row-label">Administradores del sistema</div>
                    <div class="prof-row-value">{{ $usuarios->count() }} {{ $usuarios->count() === 1 ? 'cuenta registrada' : 'cuentas registradas' }}</div>
                </div>
                <span class="prof-row-link">Gestionar ›</span>
            </div>
            <div class="prof-section {{ $errors->has('new_name') || $errors->has('new_email') || $errors->has('new_password') ? 'open' : '' }}"
                 id="s-users">
                {{-- Lista de usuarios --}}
                <div style="margin-bottom:.5rem;">
                    @foreach($usuarios as $u)
                    <div class="user-row">
                        <div>
                            <span style="font-size:.83rem;font-weight:600;color:#0D1B35;">{{ $u->name }}</span>
                            @if($u->id === Auth::id())<span class="u-badge">Tú</span>@endif
                            <div style="font-size:.72rem;color:#8496B0;">{{ $u->email }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- Crear cuenta --}}
                <div class="sec-divider">Nueva cuenta de administrador</div>
                @if($errors->has('new_name') || $errors->has('new_email') || $errors->has('new_password'))
                    <div class="alert alert-e">
                        @foreach(['new_name','new_email','new_password','new_password_confirmation'] as $f)
                            @error($f){{ $message }}<br>@enderror
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.crearUsuario') }}">
                    @csrf
                    <div class="fgrid">
                        <div class="pf">
                            <label>Nombre</label>
                            <input type="text" name="new_name" value="{{ old('new_name') }}"
                                   placeholder="Nombre del administrador"
                                   class="{{ $errors->has('new_name') ? 'err' : '' }}">
                            @error('new_name')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                        <div class="pf">
                            <label>Correo electrónico</label>
                            <input type="email" name="new_email" value="{{ old('new_email') }}"
                                   placeholder="correo@upgop.edu"
                                   class="{{ $errors->has('new_email') ? 'err' : '' }}">
                            @error('new_email')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="fgrid">
                        <div class="pf">
                            <label>Contraseña</label>
                            <div class="pw-wrap">
                                <input type="password" id="npw" name="new_password"
                                       placeholder="Mín. 8 caracteres" autocomplete="new-password"
                                       class="{{ $errors->has('new_password') ? 'err' : '' }}"
                                       oninput="evalStrN(this.value)">
                                <button type="button" class="pw-toggle" onclick="togglePw('npw',this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="pw-bar"><span id="nb1"></span><span id="nb2"></span><span id="nb3"></span><span id="nb4"></span></div>
                            <div class="pw-lbl" id="nStrLbl"></div>
                            @error('new_password')<div class="fe">{{ $message }}</div>@enderror
                        </div>
                        <div class="pf">
                            <label>Confirmar contraseña</label>
                            <div class="pw-wrap">
                                <input type="password" id="npwc" name="new_password_confirmation"
                                       placeholder="Repite la contraseña" autocomplete="new-password"
                                       oninput="chkMatchN()">
                                <button type="button" class="pw-toggle" onclick="togglePw('npwc',this)">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                            <div class="pw-lbl" id="nMchLbl"></div>
                        </div>
                    </div>
                    <div class="pf-actions">
                        <button type="submit" class="btn" style="background:#8E44AD;color:#fff;">Crear cuenta</button>
                        <button type="button" class="btn btn-gray" onclick="toggle('users')">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>{{-- /prof-card --}}

        {{-- ── Danger zone ── --}}
        <div class="danger-card">
            <div class="danger-row">
                <div class="danger-row-icon">
                    <svg fill="none" stroke="#C0392B" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </div>
                <div class="prof-row-meta">
                    <div class="prof-row-label" style="color:#C0392B;">Zona de peligro</div>
                    <div class="prof-row-value">Eliminar cuenta · Esta acción es permanente e irreversible</div>
                </div>
                <button class="btn btn-red" onclick="document.getElementById('delModal').classList.add('open')">
                    Eliminar cuenta
                </button>
            </div>
        </div>

    </div>{{-- /prof-page --}}

    {{-- ── Delete Modal ── --}}
    <div class="modal-overlay" id="delModal">
        <div class="modal-box">
            <div class="modal-title">⚠️ ¿Eliminar tu cuenta?</div>
            <div class="modal-desc">
                Esta acción es permanente. Serás desconectado y tu cuenta se eliminará.<br>
                Escribe tu contraseña actual para confirmar.
            </div>
            @if($errors->userDeletion->isNotEmpty())
                <div class="alert alert-e">@foreach($errors->userDeletion->all() as $e){{ $e }}@endforeach</div>
            @endif
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf @method('DELETE')
                <div class="pf">
                    <label>Contraseña actual</label>
                    <div class="pw-wrap">
                        <input type="password" id="del_pw" name="password" placeholder="••••••••" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('del_pw',this)">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-gray" onclick="document.getElementById('delModal').classList.remove('open')">Cancelar</button>
                    <button type="submit" class="btn btn-del">Sí, eliminar cuenta</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Toggle expandable section
    function toggle(id) {
        const sec = document.getElementById('s-'+id);
        const row = sec.previousElementSibling;
        const isOpen = sec.classList.contains('open');
        document.querySelectorAll('.prof-section').forEach(s => s.classList.remove('open'));
        document.querySelectorAll('.prof-row').forEach(r => r.classList.remove('active'));
        if (!isOpen) { sec.classList.add('open'); row.classList.add('active'); }
    }

    // Show/hide password
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const hidden = inp.type === 'password';
        inp.type = hidden ? 'text' : 'password';
        btn.querySelector('svg').innerHTML = hidden
            ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
            : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }

    // Password strength core
    function pwStrength(val, bars, lbl, reqIds) {
        const len  = val.length >= 8;
        const let_ = /[a-zA-ZáéíóúñÁÉÍÓÚÑ]/.test(val);
        const num  = /[0-9]/.test(val);
        const spec = /[^a-zA-Z0-9]/.test(val);
        const okSvg  = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        const nokSvg = '<circle cx="12" cy="12" r="10"/>';
        if (reqIds) {
            [[reqIds[0],len],[reqIds[1],let_],[reqIds[2],num]].forEach(([rid,ok]) => {
                const el = document.getElementById(rid);
                if (!el) return;
                el.classList.toggle('ok', ok);
                el.querySelector('svg').innerHTML = ok ? okSvg : nokSvg;
            });
        }
        const score = [len,let_,num,spec].filter(Boolean).length;
        const colors = ['#E8EDF5','#C0392B','#E67E22','#F1C40F','#27AE60'];
        const labels = ['','Muy débil','Débil','Regular','Fuerte'];
        bars.forEach((b,i) => { b.style.background = i < score ? colors[score] : '#E8EDF5'; });
        if (lbl) { lbl.textContent = val.length > 0 ? labels[score] : ''; lbl.style.color = colors[score]; }
    }

    // Change password section
    function evalStr(val) {
        pwStrength(val, [1,2,3,4].map(i=>document.getElementById('b'+i)), document.getElementById('strLbl'), ['rl','rle','rn']);
        chkMatch();
    }
    function chkMatch() {
        const pw=document.getElementById('new_pw').value, cf=document.getElementById('pw_cf').value, lb=document.getElementById('mchLbl');
        if (!cf) { lb.textContent=''; return; }
        lb.textContent = pw===cf ? '✓ Las contraseñas coinciden' : '✗ No coinciden';
        lb.style.color  = pw===cf ? '#27AE60' : '#C0392B';
    }

    // New user section
    function evalStrN(val) {
        pwStrength(val, [1,2,3,4].map(i=>document.getElementById('nb'+i)), document.getElementById('nStrLbl'), null);
        chkMatchN();
    }
    function chkMatchN() {
        const pw=document.getElementById('npw').value, cf=document.getElementById('npwc').value, lb=document.getElementById('nMchLbl');
        if (!cf) { lb.textContent=''; return; }
        lb.textContent = pw===cf ? '✓ Las contraseñas coinciden' : '✗ No coinciden';
        lb.style.color  = pw===cf ? '#27AE60' : '#C0392B';
    }

    // Auto-open on validation errors
    document.addEventListener('DOMContentLoaded', () => {
        @if($errors->userDeletion->isNotEmpty())
            document.getElementById('delModal').classList.add('open');
        @endif
        @if($errors->has('new_name') || $errors->has('new_email') || $errors->has('new_password'))
            toggle('users');
        @endif
        @if($errors->updatePassword->any())
            toggle('pass');
        @endif
        @if($errors->has('name') || $errors->has('email'))
            toggle('info');
        @endif

        const modal = document.getElementById('delModal');
        modal.addEventListener('click', e => { if (e.target===modal) modal.classList.remove('open'); });
        document.addEventListener('keydown', e => { if (e.key==='Escape') modal.classList.remove('open'); });
    });
    </script>
</x-app-layout>
