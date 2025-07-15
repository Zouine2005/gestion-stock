<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Si l'utilisateur n'est pas connecté ➔ rediriger vers /login
            return redirect()->route('login');
        }

        return $next($request);
    }
}
