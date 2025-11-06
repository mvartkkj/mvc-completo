<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cargo;
use App\Models\Prato;

class AdminController extends Controller
{
    // Dashboard principal
    public function index(Request $request)
    {
        // Estatísticas
        $totalClientes = Cliente::count();
        $clientesAtivos = Cliente::whereNotNull('e_mail')->count();
        
        // Busca com filtro de clientes
        $search = $request->get('search');
        $clientesQuery = Cliente::with('cargo')
            ->orderBy('cod_cliente', 'desc');
        
        if ($search) {
            $clientesQuery->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('e_mail', 'like', "%{$search}%")
                    ->orWhere('celular', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%");
            });
        }
        
        $clientes = $clientesQuery->take(10)->get();
        
        // Buscar pratos para preview no dashboard
        $pratos = Prato::with('categoria')
            ->orderBy('descricao')
            ->take(10)
            ->get();

        // Dados para os cards do dashboard
        $stats = [
            'total_clientes' => $totalClientes,
            'clientes_ativos' => $clientesAtivos,
            'cadastros_mes' => Cliente::whereYear('data_nasc', now()->year)
                                    ->whereMonth('data_nasc', now()->month)
                                    ->count(),
            'total_cargos' => Cargo::count(),
        ];

        return view('admin.dashboard', compact('clientes', 'pratos', 'stats', 'search'));
    }
    
    // Listar clientes
    public function clientes(Request $request)
    {
        $search = $request->get('search');
        $clientesQuery = Cliente::with('cargo')->orderBy('cod_cliente', 'desc');
        
        if ($search) {
            $clientesQuery->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                    ->orWhere('e_mail', 'like', "%{$search}%")
                    ->orWhere('celular', 'like', "%{$search}%")
                    ->orWhere('cpf', 'like', "%{$search}%");
            });
        }
        
        $clientes = $clientesQuery->paginate(10)->appends(['search' => $search]);
        
        return view('admin.clientes', compact('clientes', 'search'));
    }
    
    // Mostrar formulário de criação
    public function createCliente()
    {
        $cargos = Cargo::all();
        return view('admin.create-cliente', compact('cargos'));
    }
    
    // Salvar novo cliente
    public function storeCliente(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|regex:/^[0-9]{11}$/',
            'rg' => 'nullable|string|max:12|regex:/^[0-9]{1,12}$/',
            'data_nasc' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:100',
            'cod_cidade' => 'nullable|integer',
            'cep' => 'nullable|string|size:8|regex:/^[0-9]{8}$/',
            'celular' => 'nullable|string|min:10|max:11|regex:/^[0-9]{10,11}$/',
            'e_mail' => 'required|email|max:255|unique:clientes,e_mail',
            'cargo_id' => 'required|exists:cargos,id',
            'passwd' => 'required|string|min:6',
        ], [
            'e_mail.required' => 'O e-mail é obrigatório.',
            'e_mail.email' => 'Digite um e-mail válido.',
            'e_mail.unique' => 'Este e-mail já está cadastrado.',
            'cargo_id.required' => 'Selecione um cargo.',
            'cargo_id.exists' => 'Cargo inválido.',
            'passwd.required' => 'A senha é obrigatória.',
            'passwd.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex' => 'O CPF deve conter apenas números.',
            'rg.max' => 'O RG deve ter no máximo 12 dígitos.',
            'rg.regex' => 'O RG deve conter apenas números.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'cep.regex' => 'O CEP deve conter apenas números.',
            'celular.min' => 'O celular deve ter no mínimo 10 dígitos.',
            'celular.max' => 'O celular deve ter no máximo 11 dígitos.',
            'celular.regex' => 'O celular deve conter apenas números.',
        ]);

        Cliente::create($validated);

        return redirect()->route('admin.clientes')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }
    
    // Editar cliente
    public function editCliente($id)
    {
        $cliente = Cliente::with('cargo')->findOrFail($id);
        $cargos = Cargo::all();
        
        // Carregar apenas a cidade atual do cliente para otimização
        $cidadeAtual = null;
        if ($cliente->cod_cidade) {
            $cidadeAtual = \DB::table('cidades')
                ->where('cod_cidade', $cliente->cod_cidade)
                ->first();
        }
        
        // Buscar todas as cidades
        $cidades = \DB::table('cidades')->orderBy('nome')->get();
        
        return view('admin.edit-cliente', compact('cliente', 'cargos', 'cidadeAtual', 'cidades'));
    }
    
    // Buscar cidades via AJAX
    public function buscarCidades(Request $request)
    {
        $search = $request->get('q', '');
        
        $cidades = \DB::table('cidades')
            ->where(function($query) use ($search) {
                $query->where('nome', 'like', "%{$search}%")
                      ->orWhere('uf', 'like', "%{$search}%");
            })
            ->orderBy('nome')
            ->limit(50)
            ->get();
        
        return response()->json($cidades);
    }
    
    // Atualizar cliente
    public function updateCliente(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|regex:/^[0-9]{11}$/',
            'rg' => 'nullable|string|max:12|regex:/^[0-9]{1,12}$/',
            'data_nasc' => 'nullable|date',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'bairro' => 'nullable|string|max:100',
            'cod_cidade' => 'nullable|integer',
            'cep' => 'nullable|string|size:8|regex:/^[0-9]{8}$/',
            'celular' => 'nullable|string|size:11|regex:/^[0-9]{10,11}$/',
            'e_mail' => 'required|email|max:255|unique:clientes,e_mail,' . $id . ',cod_cliente',
            'cargo_id' => 'required|exists:cargos,id',
            'passwd' => 'nullable|string|min:6',
        ], [
            'e_mail.required' => 'O e-mail é obrigatório.',
            'e_mail.email' => 'Digite um e-mail válido.',
            'e_mail.unique' => 'Este e-mail já está cadastrado.',
            'cargo_id.required' => 'Selecione um cargo.',
            'cargo_id.exists' => 'Cargo inválido.',
            'passwd.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex' => 'O CPF deve conter apenas números.',
            'rg.max' => 'O RG deve ter no máximo 12 dígitos.',
            'rg.regex' => 'O RG deve conter apenas números.',
            'cep.size' => 'O CEP deve ter exatamente 8 dígitos.',
            'cep.regex' => 'O CEP deve conter apenas números.',
            'celular.regex' => 'O celular deve conter apenas números (10 ou 11 dígitos).',
        ]);

        // Se não alterou a senha, remove do array
        if (empty($validated['passwd'])) {
            unset($validated['passwd']);
        }

        $cliente->update($validated);

        return redirect()->route('admin.clientes')
            ->with('success', 'Cliente atualizado com sucesso!');
    }
    
    // Deletar cliente
    public function deleteCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        
        return redirect()->route('admin.clientes')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}