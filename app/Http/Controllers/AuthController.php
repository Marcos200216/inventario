<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed|min:6',
    ], [
        'name.required' => 'El nombre es obligatorio ',
        'email.required' => 'El correo electrónico es obligatorio ',
        'email.email' => 'Debe ser un correo electrónico válido ',
        'email.unique' => 'Este correo electrónico ya está registrado ',
        'password.required' => 'La contraseña es obligatoria ',
        'password.confirmed' => 'Las contraseñas no coinciden ',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres '
    ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Eliminamos el Auth::login($user) para que no inicie sesión automáticamente
        
        if ($request->wantsJson()) {
            // Para peticiones AJAX (como las que hace SweetAlert)
            return response()->json([
                'success' => true,
                'message' => 'Registro exitoso. Por favor inicia sesión.'
            ]);
        }

        return redirect('/login')->with('success', 'Registro exitoso. Por favor inicia sesión.');
    }

}
