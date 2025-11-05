<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Asegúrate de importar el facade Auth

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) { // Usa Auth::check() para verificar si el usuario está autenticado
            return redirect()->route('login');
        }

        return $next($request);
    }
}