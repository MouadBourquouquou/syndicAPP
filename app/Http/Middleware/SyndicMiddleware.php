<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyndicMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $estSyndicValide = in_array($user->statut, ['professionnel', 'benevolat']);
        $estAdmin        = (bool) $user->is_admin;

        if (! $estSyndicValide || $estAdmin) {
            return redirect()->route('login')->withErrors([
                'access' => 'Accès réservé aux syndics.'
            ]);
        }

        return $next($request);
    }
}
