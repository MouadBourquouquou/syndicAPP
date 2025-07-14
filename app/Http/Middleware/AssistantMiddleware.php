<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->statut === 'assistant_syndic') {
            return $next($request);
        }

        return redirect()->route('login')->withErrors([
            'access' => 'Accès réservé aux assistants syndic.'
        ]);
    }
}
