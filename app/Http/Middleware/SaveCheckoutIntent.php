<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SaveCheckoutIntent
{
    public function handle(Request $request, Closure $next)
    {
        // Se está acessando login/register vindo do checkout
        if ($request->is('login') || $request->is('register')) {
            // Verificar se tem carrinho na sessão
            if (session()->has('cart') && !empty(session('cart'))) {
                session(['return_to_checkout' => true]);
            }
        }
        
        return $next($request);
    }
}