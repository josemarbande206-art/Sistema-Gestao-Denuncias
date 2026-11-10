<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPerfil
{
    public function handle(Request $request, Closure $next, ...$perfis): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $perfil = Auth::user()->perfil;

        if (!in_array($perfil, $perfis)) {
            abort(403, 'Não tem autorização para aceder a esta área.');
        }

        return $next($request);
    }
}
