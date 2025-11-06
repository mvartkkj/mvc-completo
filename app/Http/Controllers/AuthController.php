<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cargo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function handleGoogleCallback()
    {
        try {
            // Pegar os dados do usuário do Google
            $googleUser = Socialite::driver('google')->user();
            
            // Verificar se o usuário já existe pelo e-mail
            $cliente = Cliente::where('e_mail', $googleUser->email)->first();
            
            if (!$cliente) {
                // Se não existe, criar novo cliente
                $cliente = Cliente::create([
                    'nome' => $googleUser->name,
                    'e_mail' => $googleUser->email,
                    'passwd' => Str::random(16), // Senha aleatória (não será usada)
                    'cargo_id' => 1, // Cliente padrão
                ]);
            }
            
            // Fazer login usando o guard cliente
            Auth::guard('cliente')->login($cliente);
            
            // Também manter sessão manual para compatibilidade
            session([
                'user_id' => $cliente->cod_cliente,
                'user_name' => $cliente->nome,
                'user_email' => $cliente->e_mail,
                'user_cargo' => $cliente->cargo_id,
            ]);
            
            // Verificar se deve voltar ao checkout
            $returnToCheckout = session('return_to_checkout', false);
            session()->forget('return_to_checkout');
            
            if ($returnToCheckout && session()->has('cart')) {
                return redirect()->route('checkout.index')
                    ->with('success', 'Login com Google realizado! Complete seu pedido.');
            }
            
            // Se for admin, redirecionar para admin
            if (in_array($cliente->cargo_id, [4, 5, 6])) {
                return redirect()->route('admin.pedidos.index')
                    ->with('success', 'Bem-vindo ao painel administrativo!');
            }
            
            return redirect()->route('menu')
                ->with('success', 'Login com Google realizado com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erro ao fazer login com Google: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        // Validar os dados de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clientes,e_mail',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'email.unique' => 'Este e-mail já está cadastrado',
            'phone.required' => 'O telefone é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não conferem',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Criar um novo cliente
            $cliente = Cliente::create([
                'nome' => $request->name,
                'e_mail' => $request->email,
                'celular' => $request->phone,
                'passwd' => $request->password, // Hash automático no model
                'cargo_id' => 1, // 1 = Cliente padrão
            ]);

            // Fazer login automático após registro
            Auth::guard('cliente')->login($cliente);
            
            // Também manter sessão manual para compatibilidade
            session([
                'user_id' => $cliente->cod_cliente,
                'user_name' => $cliente->nome,
                'user_email' => $cliente->e_mail,
                'user_cargo' => $cliente->cargo_id,
            ]);
            
            // Verificar se deve voltar ao checkout
            $returnToCheckout = session('return_to_checkout', false);
            session()->forget('return_to_checkout');
            
            if ($returnToCheckout && session()->has('cart')) {
                return redirect()->route('checkout.index')
                    ->with('success', 'Cadastro realizado! Complete seu pedido.');
            }

            // Redirecionar para menu
            return redirect()->route('menu')
                ->with('success', 'Cadastro realizado com sucesso! Bem-vindo, ' . $cliente->nome . '!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar cadastro: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Digite um e-mail válido',
            'password.required' => 'A senha é obrigatória',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buscar o cliente pelo e-mail
        $cliente = Cliente::where('e_mail', $request->email)->first();

        // Verificar se existe e se a senha está correta
        if ($cliente && Hash::check($request->password, $cliente->passwd)) {
            // Login usando o guard cliente
            Auth::guard('cliente')->login($cliente, $request->filled('remember'));
            
            // Também manter sessão manual para compatibilidade (útil se tiver código legado)
            session([
                'user_id' => $cliente->cod_cliente,
                'user_name' => $cliente->nome,
                'user_email' => $cliente->e_mail,
                'user_cargo' => $cliente->cargo_id,
            ]);
            
            // Verificar se deve voltar ao checkout
            $returnToCheckout = session('return_to_checkout', false);
            session()->forget('return_to_checkout');
            
            if ($returnToCheckout && session()->has('cart')) {
                return redirect()->route('checkout.index')
                    ->with('success', 'Login realizado! Complete seu pedido.');
            }

            // Se for admin, redirecionar para admin
            if (in_array($cliente->cargo_id, [4, 5, 6])) {
                return redirect()->route('admin.pedidos.index')
                    ->with('success', 'Bem-vindo ao painel administrativo, ' . $cliente->nome . '!');
            }

            return redirect()->route('menu')
                ->with('success', 'Bem-vindo, ' . $cliente->nome . '!');
        }

        return redirect()->back()
            ->with('error', 'E-mail ou senha incorretos!')
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::guard('cliente')->logout();
        session()->flush();
        
        return redirect()->route('home')
            ->with('success', 'Você saiu com sucesso!');
    }
}