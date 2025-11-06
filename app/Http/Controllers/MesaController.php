<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MesaController extends Controller
{
    /**
     * Listar todas as mesas (ativas e inativas)
     */
    public function index()
    {
        $mesas = Mesa::orderBy('descricao')->get();
        return view('admin.mesas', compact('mesas'));
    }

    /**
     * Exibir QR Codes das mesas ativas
     */
    public function qrcodes()
    {
        $mesas = Mesa::where('ativo', 1)->orderBy('descricao')->get();
        return view('admin.qrcodes-mesa', compact('mesas'));
    }

    /**
     * Mostrar formulário de criação
     */
    public function create()
    {
        return view('admin.create-mesa');
    }

    /**
     * Salvar nova mesa
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:50|unique:mesas,descricao',
        ], [
            'descricao.required' => 'O nome da mesa é obrigatório',
            'descricao.unique' => 'Já existe uma mesa com este nome',
            'descricao.max' => 'O nome deve ter no máximo 50 caracteres',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Mesa::create([
                'descricao' => $request->descricao,
                'ativo' => 1, // Mesa criada como ativa por padrão
            ]);

            return redirect()->route('admin.mesas.index')
                ->with('success', 'Mesa criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar mesa: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao criar mesa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar formulário de edição
     */
    public function edit($id)
    {
        $mesa = Mesa::findOrFail($id);
        return view('admin.edit-mesa', compact('mesa'));
    }

    /**
     * Atualizar mesa
     */
    public function update(Request $request, $id)
    {
        $mesa = Mesa::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|max:50|unique:mesas,descricao,' . $id . ',cod_mesa',
        ], [
            'descricao.required' => 'O nome da mesa é obrigatório',
            'descricao.unique' => 'Já existe uma mesa com este nome',
            'descricao.max' => 'O nome deve ter no máximo 50 caracteres',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $mesa->update([
                'descricao' => $request->descricao,
            ]);

            return redirect()->route('admin.mesas.index')
                ->with('success', 'Mesa atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar mesa: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao atualizar mesa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * INATIVAR mesa ao invés de excluir
     */
    public function destroy($id)
    {
        try {
            $mesa = Mesa::findOrFail($id);
            
            // Verificar se há pedidos ativos nesta mesa
            $pedidosAtivos = $mesa->pedidos()
                ->where('encerrado', 0)
                ->where('cancelado', 0)
                ->count();
            
            if ($pedidosAtivos > 0) {
                return redirect()->back()
                    ->with('error', 'Não é possível inativar esta mesa pois há pedidos ativos!');
            }
            
            // Inativar ao invés de excluir
            $mesa->update(['ativo' => 0]);

            return redirect()->route('admin.mesas.index')
                ->with('success', 'Mesa inativada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao inativar mesa: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao inativar mesa: ' . $e->getMessage());
        }
    }

    /**
     * ATIVAR mesa novamente
     */
    public function ativar($id)
    {
        try {
            $mesa = Mesa::findOrFail($id);
            
            // Ativar a mesa
            $mesa->update(['ativo' => 1]);

            return redirect()->route('admin.mesas.index')
                ->with('success', 'Mesa ativada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao ativar mesa: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao ativar mesa: ' . $e->getMessage());
        }
    }

    /**
     * Login via QR Code da mesa
     */
    public function loginMesa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table_code' => 'required|string|max:50'
        ], [
            'table_code.required' => 'O código da mesa é obrigatório',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buscar mesa pelo código (apenas ativas)
            $mesa = Mesa::where('descricao', $request->table_code)
                       ->where('ativo', 1)
                       ->first();

            if (!$mesa) {
                return redirect()->back()
                    ->with('error', 'Mesa não encontrada ou inativa! Verifique o código.');
            }

            // Salvar na sessão
            session([
                'mesa_logada' => true,
                'mesa_id' => $mesa->cod_mesa,
                'table_code' => $mesa->descricao,
            ]);

            Log::info('Mesa logada via QR Code: ' . $mesa->descricao);

            return redirect()->route('menu')
                ->with('success', 'Bem-vindo! Mesa ' . $mesa->descricao . ' registrada.');
        } catch (\Exception $e) {
            Log::error('Erro ao fazer login da mesa: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao registrar mesa: ' . $e->getMessage());
        }
    }
}