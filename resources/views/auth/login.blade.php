<x-guest-layout>
<<<<<<< HEAD
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
=======

    <div class="card-eyebrow">Autenticación</div>
    <h2 class="card-title">Iniciar sesión</h2>
    <p class="card-sub">Ingresa tus credenciales institucionales</p>

    <!-- Session Status -->
    @if (session('status'))
        <div style="background:rgba(39,174,96,.1);border:1px solid rgba(39,174,96,.25);border-radius:10px;padding:.65rem 1rem;margin-bottom:1rem;color:#27AE60;font-size:.8rem;">
            {{ session('status') }}
        </div>
    @endif
>>>>>>> e457021ea82fbed4256465eab0b8d4a95f667977

    <form method="POST" action="{{ route('login') }}">
        @csrf

<<<<<<< HEAD
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
=======
        <!-- Email -->
        <div class="field">
            <label for="email">Correo electrónico</label>
            <div class="input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="correo@upgop.edu.mx"
                    class="{{ $errors->get('email') ? 'error' : '' }}"
                    required autofocus autocomplete="username">
            </div>
            @foreach ($errors->get('email') as $msg)
                <div class="field-error">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $msg }}
                </div>
            @endforeach
        </div>

        <!-- Password -->
        <div class="field">
            <label for="password">Contraseña</label>
            <div class="input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input id="password" type="password" name="password"
                    placeholder="••••••••"
                    class="{{ $errors->get('password') ? 'error' : '' }}"
                    required autocomplete="current-password">
            </div>
            @foreach ($errors->get('password') as $msg)
                <div class="field-error">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $msg }}
                </div>
            @endforeach
        </div>

        <!-- Remember + Forgot -->
        <div class="check-row">
            <label class="check-label">
                <input type="checkbox" name="remember">
                Recordar sesión
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-cta">
            Entrar al sistema
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>

        <div class="card-note">Acceso exclusivo para personal autorizado de la UPGOP</div>
    </form>

>>>>>>> e457021ea82fbed4256465eab0b8d4a95f667977
</x-guest-layout>
