<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    // Listar fornecedores
    public function index(Request $request)
    {
        $search = $request->get('search');
        $fornecedoresQuery = Fornecedor::orderBy('cod_fornecedor', 'desc');
        
        if ($search) {
            $fornecedoresQuery->where(function($query) use ($search) {
                $query->where('nome_social', 'like', "%{$search}%")
                    ->orWhere('nome_fantasia', 'like', "%{$search}%")
                    ->orWhere('cnpj', 'like', "%{$search}%")
                    ->orWhere('e_mail', 'like', "%{$search}%")
                    ->orWhere('celular', 'like', "%{$search}%");
            });
        }
        
        $fornecedores = $fornecedoresQuery->paginate(10)->appends(['search' => $search]);
        
        return view('admin.fornecedores', compact('fornecedores', 'search'));
    }
    
    // Mostrar formulário de criação
    public function create()
    {
        return view('admin.create-fornecedor');
    }
    
    // Salvar novo fornecedor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|size:14|regex:/^[0-9]{14}$/',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:100',
            'cod_cidade' => 'nullable|integer',
            'cep' => 'nullable|string|size:8|regex:/^[0-9]{8}$/',
            'celular' => 'nullable|string|min:10|max:11|regex:/^[0-9]{10,11}$/',
            'e_mail' => 'nullable|email|max:255',
        ], [
            'nome_social.required' => 'O nome social é obrigatório.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.regex' => 'O CNPJ deve conter apenas números.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'cep.regex' => 'O CEP deve conter apenas números.',
            'celular.min' => 'O celular deve ter no mínimo 10 dígitos.',
            'celular.max' => 'O celular deve ter no máximo 11 dígitos.',
            'celular.regex' => 'O celular deve conter apenas números.',
            'e_mail.email' => 'Digite um e-mail válido.',
        ]);

        Fornecedor::create($validated);

        return redirect()->route('admin.fornecedores')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }
    
    // Editar fornecedor
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        
        // Carregar apenas a cidade atual do fornecedor
        $cidadeAtual = null;
        if ($fornecedor->cod_cidade) {
            $cidadeAtual = \DB::table('cidades')
                ->where('cod_cidade', $fornecedor->cod_cidade)
                ->first();
        }
        
        // Buscar todas as cidades
        $cidades = \DB::table('cidades')->orderBy('nome')->get();
        
        return view('admin.edit-fornecedor', compact('fornecedor', 'cidadeAtual', 'cidades'));
    }
    
    // Atualizar fornecedor
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        
        $validated = $request->validate([
            'nome_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|size:14|regex:/^[0-9]{14}$/',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:100',
            'cod_cidade' => 'nullable|integer',
            'cep' => 'nullable|string|size:8|regex:/^[0-9]{8}$/',
            'celular' => 'nullable|string|min:10|max:11|regex:/^[0-9]{10,11}$/',
            'e_mail' => 'nullable|email|max:255',
        ], [
            'nome_social.required' => 'O nome social é obrigatório.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.regex' => 'O CNPJ deve conter apenas números.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'cep.regex' => 'O CEP deve conter apenas números.',
            'celular.min' => 'O celular deve ter no mínimo 10 dígitos.',
            'celular.max' => 'O celular deve ter no máximo 11 dígitos.',
            'celular.regex' => 'O celular deve conter apenas números.',
            'e_mail.email' => 'Digite um e-mail válido.',
        ]);

        $fornecedor->update($validated);

        return redirect()->route('admin.fornecedores')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }
    
    // Deletar fornecedor
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->delete();
        
        return redirect()->route('admin.fornecedores')
            ->with('success', 'Fornecedor excluído com sucesso!');
    }
}