<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Crear un nuevo usuario (sin necesidad de cerrar sesión).
     */
    public function crearUsuario(Request $request): RedirectResponse
    {
        $request->validate([
            'new_name'     => ['required', 'string', 'max:255'],
            'new_email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'new_password' => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
        ], [
            'new_name.required'      => 'El nombre es obligatorio.',
            'new_email.required'     => 'El correo es obligatorio.',
            'new_email.unique'       => 'Ya existe una cuenta con ese correo.',
            'new_email.email'        => 'Ingresa un correo válido.',
            'new_password.required'  => 'La contraseña es obligatoria.',
            'new_password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'name'     => $request->new_name,
            'email'    => strtolower($request->new_email),
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'user-created');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
