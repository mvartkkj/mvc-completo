<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se está autenticado com o guard 'cliente'
        if (!Auth::guard('cliente')->check()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        $user = Auth::guard('cliente')->user();

        // Verificar se o cargo_id é de admin (ajuste conforme seu banco)
        // Cargo IDs comuns:
        // 1 = Cliente
        // 2 = Garçom
        // 3 = Cozinha
        // 4 ou 5 = Admin/Gerente
        
        $adminCargoIds = [4, 5, 6]; // Ajuste esses IDs conforme sua tabela 'cargos'
        
        if (!in_array($user->cargo_id, $adminCargoIds)) {
            return redirect()->route('menu')
                ->with('error', 'Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}