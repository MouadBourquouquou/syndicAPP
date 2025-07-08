<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 🔒 Bloquer les utilisateurs non activés (sauf les admins)
            if (!$user->is_admin && $user->is_active != 1) {
                Auth::logout(); // déconnecter l'utilisateur
                return back()->withErrors([
                    'email' => 'Votre compte est en attente d’activation par un administrateur.',
                ])->withInput();
            }

            // 🎯 Redirection selon le rôle
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput();
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
