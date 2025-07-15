<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AppResetPasswordController extends Controller
{
    /**
     * Formulaire de réinitialisation.
     * Route: GET /reset-password/{token}
     */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Soumission du formulaire.
     * Route: POST /reset-password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        
        // Tentative de reset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );
        \Log::info('Password reset status: ' . $status);

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')
                             ->with('status', __($status));
        }

        // Échec : renvoyer une erreur
        throw ValidationException::withMessages([
            'email' => [__($status)],
        ]);
    }
}
