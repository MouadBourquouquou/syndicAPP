<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyndicOrAssistantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $isSyndic = in_array($user->statut, ['professionnel', 'benevolat']) && !$user->is_admin;
        $isAssistant = $user->statut === 'assistant_syndic';

        if ($isSyndic || $isAssistant) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors([
            'access' => 'Accès réservé aux assistants ou syndics.'
        ]);
    }
}
