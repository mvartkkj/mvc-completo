<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar se está logado com o guard 'cliente'
        if (!Auth::guard('cliente')->check()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado!');
        }
        
        $user = Auth::guard('cliente')->user();
        
        if ($user->cargo_id != 2) {
            return redirect()->route('menu')    
                ->with('error', 'Acesso negado! Apenas administradores.');
        }
        
        return $next($request);
    }
}