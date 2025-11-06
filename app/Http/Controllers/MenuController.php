<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prato;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('add_to_cart')) {
            $cart = session('cart', []);
            $pratoId = $request->input('prato_id');
            $quantidade = $request->input('quantidade', 1);
            
            if (!isset($cart[$pratoId])) {
                $cart[$pratoId] = 0;
            }
            $cart[$pratoId] += $quantidade;
            
            session(['cart' => $cart]);
        }

        // Lógica para determinar o identificador
        $tableCode = 'Visitante'; // Padrão
        
        // Prioridade 1: Verificar se há mesa escaneada (QR Code)
        if (session()->has('table_code')) {
            $tableCode = session('table_code');
        }
        // Prioridade 2: Verificar se há usuário logado
        elseif (Auth::guard('cliente')->check()) {
            $user = Auth::guard('cliente')->user();
            $tableCode = $user->nome;
        }
        
        // Buscar categorias do banco
        $categoriasDB = Categoria::orderBy('descricao')->get();
        
        // Mapear categorias com ícones
        $iconesCategoria = [
            'Pizza' => '🍕',
            'Lanche' => '🍔',
            'Prato Feito' => '🍽️',
            'Porção' => '🍖',
            'Petisco' => '🥗',
            'Refrigerante' => '🥤',
            'Doce' => '�',
            'Bebida alcoólica' => '🍺',
            'Açaite' => '🥙',
        ];

        // Montar array de categorias para o frontend
        $categories = [
            ['id' => 'all', 'name' => 'Todos', 'icon' => '🍽️']
        ];

        foreach ($categoriasDB as $cat) {
            $categories[] = [
                'id' => $cat->cod_cat,
                'name' => $cat->descricao,
                'icon' => $iconesCategoria[$cat->descricao] ?? '🍽️'
            ];
        }

        // Buscar pratos do banco com a categoria relacionada
        $menuItems = Prato::with('categoria')
            ->ordenados()
            ->get()
            ->map(function ($prato) {
                return [
                    'id' => $prato->cod_prato,
                    'name' => $prato->descricao,
                    'description' => $prato->categoria ? $prato->categoria->descricao : 'Sem categoria',
                    'price' => (float) $prato->valor_unitario,
                    'category' => $prato->cod_cat,
                    'image' => $prato->foto_url,
                    'available' => true,
                ];
            })
            ->toArray();

        return view('menu', compact('tableCode', 'categories', 'menuItems'));
    }
}