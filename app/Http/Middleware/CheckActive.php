<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActive
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->is_admin == 0 && $user->is_active == 0) {
                Auth::logout();
                return redirect('/login')->withErrors(['email' => 'Votre compte n’est pas encore activé par un administrateur.']);
            }
        }

        return $next($request);
    }
}
