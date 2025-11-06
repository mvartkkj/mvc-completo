<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;
use App\Models\Unidade;

class IngredienteController extends Controller
{
    // Listar ingredientes
    public function index(Request $request)
    {
        $search = $request->get('search');
        $ingredientesQuery = Ingrediente::with('unidade')->orderBy('cod_ingrediente', 'desc');
        
        if ($search) {
            $ingredientesQuery->where(function($query) use ($search) {
                $query->where('descricao', 'like', "%{$search}%");
            });
        }
        
        $ingredientes = $ingredientesQuery->paginate(10)->appends(['search' => $search]);
        
        return view('admin.ingredientes', compact('ingredientes', 'search'));
    }
    
    // Mostrar formulário de criação
    public function create()
    {
        $unidades = Unidade::orderBy('descricao')->get();
        return view('admin.create-ingrediente', compact('unidades'));
    }
    
    // Salvar novo ingrediente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descricao' => 'required|string|max:100',
            'cod_unidade' => 'required|integer|exists:unidades,cod_unidade',
            'controla_estoque' => 'nullable|boolean',
            'quantidade_estoque' => 'nullable|numeric|min:0',
            'valor_unitario' => 'nullable|numeric|min:0',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição deve ter no máximo 100 caracteres.',
            'cod_unidade.required' => 'A unidade é obrigatória.',
            'cod_unidade.exists' => 'Unidade inválida.',
            'quantidade_estoque.numeric' => 'A quantidade deve ser um número.',
            'quantidade_estoque.min' => 'A quantidade não pode ser negativa.',
            'valor_unitario.numeric' => 'O valor deve ser um número.',
            'valor_unitario.min' => 'O valor não pode ser negativo.',
        ]);

        // Converte controla_estoque para boolean (0 ou 1)
        $validated['controla_estoque'] = $request->has('controla_estoque') ? 1 : 0;

        Ingrediente::create($validated);

        return redirect()->route('admin.ingredientes')
            ->with('success', 'Ingrediente cadastrado com sucesso!');
    }
    
    // Editar ingrediente
    public function edit($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $unidades = Unidade::orderBy('descricao')->get();
        
        return view('admin.edit-ingrediente', compact('ingrediente', 'unidades'));
    }
    
    // Atualizar ingrediente
    public function update(Request $request, $id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        
        $validated = $request->validate([
            'descricao' => 'required|string|max:100',
            'cod_unidade' => 'required|integer|exists:unidades,cod_unidade',
            'controla_estoque' => 'nullable|boolean',
            'quantidade_estoque' => 'nullable|numeric|min:0',
            'valor_unitario' => 'nullable|numeric|min:0',
        ], [
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição deve ter no máximo 100 caracteres.',
            'cod_unidade.required' => 'A unidade é obrigatória.',
            'cod_unidade.exists' => 'Unidade inválida.',
            'quantidade_estoque.numeric' => 'A quantidade deve ser um número.',
            'quantidade_estoque.min' => 'A quantidade não pode ser negativa.',
            'valor_unitario.numeric' => 'O valor deve ser um número.',
            'valor_unitario.min' => 'O valor não pode ser negativo.',
        ]);

        // Converte controla_estoque para boolean (0 ou 1)
        $validated['controla_estoque'] = $request->has('controla_estoque') ? 1 : 0;

        $ingrediente->update($validated);

        return redirect()->route('admin.ingredientes')
            ->with('success', 'Ingrediente atualizado com sucesso!');
    }
    
    // Deletar ingrediente
    public function destroy($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->delete();
        
        return redirect()->route('admin.ingredientes')
            ->with('success', 'Ingrediente excluído com sucesso!');
    }
    
    // Adicionar quantidade ao estoque
    public function adicionarEstoque(Request $request, $id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        
        $validated = $request->validate([
            'quantidade_adicionar' => 'required|numeric|min:0.01',
        ], [
            'quantidade_adicionar.required' => 'A quantidade é obrigatória.',
            'quantidade_adicionar.numeric' => 'A quantidade deve ser um número.',
            'quantidade_adicionar.min' => 'A quantidade deve ser maior que zero.',
        ]);

        // Soma a quantidade atual com a nova quantidade
        $quantidade_atual = $ingrediente->quantidade_estoque ?? 0;
        $nova_quantidade = $quantidade_atual + $validated['quantidade_adicionar'];
        
        $ingrediente->update([
            'quantidade_estoque' => $nova_quantidade
        ]);

        return redirect()->route('admin.ingredientes')
            ->with('success', 'Estoque atualizado com sucesso! Adicionado: ' . number_format($validated['quantidade_adicionar'], 1, ',', '.') . ' ' . ($ingrediente->unidade->sigla ?? ''));
    }
}