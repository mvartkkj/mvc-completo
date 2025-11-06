<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Prato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    // Listar todos os pedidos com filtros
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'todos');
        
        $pedidosQuery = Pedido::with('cliente')
            ->orderBy('datahora', 'desc');
        
        // Filtro por status
        if ($status !== 'todos') {
            if ($status === 'pendente') {
                $pedidosQuery->where('encerrado', 0)
                            ->where(function($q) {
                                $q->where('cancelado', 0)
                                  ->orWhereNull('cancelado');
                            });
            } elseif ($status === 'entregue') {
                $pedidosQuery->where('encerrado', 1);
            } elseif ($status === 'cancelado') {
                $pedidosQuery->where('cancelado', 1);
            }
        }
        
        // Filtro por busca
        if ($search) {
            $pedidosQuery->where(function($query) use ($search) {
                $query->where('cod_pedido', 'like', "%{$search}%")
                    ->orWhere('cod_mesa', 'like', "%{$search}%")
                    ->orWhereHas('cliente', function($q) use ($search) {
                        $q->where('nome', 'like', "%{$search}%");
                    });
            });
        }
        
        $pedidos = $pedidosQuery->paginate(15)->appends([
            'search' => $search,
            'status' => $status
        ]);
        
        // Estatísticas
        $stats = [
            'total' => Pedido::count(),
            'pendente' => Pedido::where('encerrado', 0)
                               ->where(function($q) {
                                   $q->where('cancelado', 0)
                                     ->orWhereNull('cancelado');
                               })
                               ->count(),
            'entregue' => Pedido::where('encerrado', 1)->count(),
            'preparando' => 0,
            'pronto' => 0,
            'cancelado' => Pedido::where('cancelado', 1)->count(),
        ];
        
        return view('admin.pedidos', compact('pedidos', 'search', 'status', 'stats'));
    }
    
    // Ver detalhes de um pedido
    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.prato.categoria'])
            ->findOrFail($id);
        
        return view('admin.pedidos-detalhe', compact('pedido'));
    }
    
    // Mostrar formulário de edição
    public function edit($id)
    {
        $pedido = Pedido::with(['cliente', 'itens.prato'])->findOrFail($id);
        
        // Não permitir edição de pedidos entregues ou cancelados
        if ($pedido->encerrado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível editar um pedido já entregue!');
        }
        
        if ($pedido->cancelado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível editar um pedido cancelado!');
        }
        
        $pratos = Prato::with('categoria')->ordenados()->get();
        
        return view('admin.edit-pedido', compact('pedido', 'pratos'));
    }
    
    // Atualizar pedido
    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        
        // Não permitir edição de pedidos entregues ou cancelados
        if ($pedido->encerrado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível editar um pedido já entregue!');
        }
        
        if ($pedido->cancelado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível editar um pedido cancelado!');
        }
        
        // Validação
        $validated = $request->validate([
            'cod_mesa' => 'nullable|string|max:50',
            'tipo_pedido' => 'required|in:mesa,balcao,delivery',
            'forma_pagamento' => 'required|in:dinheiro,credito,debito,pix',
            'nome_cliente_balcao' => 'required_if:tipo_pedido,balcao|nullable|string|max:100',
            'taxa_servico' => 'nullable|numeric|min:0',
            'valor_entrega' => 'nullable|numeric|min:0',
            'desconto' => 'nullable|numeric|min:0',
            'itens' => 'required|array|min:1',
            'itens.*.cod_prato' => 'required|exists:pratos,cod_prato',
            'itens.*.quantidade' => 'required|integer|min:1',
        ], [
            'itens.required' => 'Adicione pelo menos um item ao pedido',
            'itens.min' => 'Adicione pelo menos um item ao pedido',
            'nome_cliente_balcao.required_if' => 'O nome é obrigatório para retirada no balcão',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Deletar itens antigos
            PedidoItem::where('cod_pedido', $pedido->cod_pedido)->delete();
            
            // Calcular novo subtotal
            $subtotal = 0;
            foreach ($validated['itens'] as $itemData) {
                $prato = Prato::findOrFail($itemData['cod_prato']);
                $quantidade = $itemData['quantidade'];
                $valorUnitario = $prato->valor_unitario;
                
                // Criar novo item
                PedidoItem::create([
                    'cod_pedido' => $pedido->cod_pedido,
                    'cod_prato' => $itemData['cod_prato'],
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'data_hora' => now(),
                ]);
                
                $subtotal += $valorUnitario * $quantidade;
            }
            
            // Mapear tipo de pedido
            $tipoPedidoMap = [
                'mesa' => 1,
                'balcao' => 2,
                'delivery' => 3,
            ];

            // Mapear forma de pagamento
            $pagamentoMap = [
                'dinheiro' => 1,
                'credito' => 2,
                'debito' => 3,
                'pix' => 4,
            ];
            
            // Calcular valor total
            $taxaServico = $validated['taxa_servico'] ?? 0;
            $valorEntrega = $validated['valor_entrega'] ?? 0;
            $desconto = $validated['desconto'] ?? 0;
            $valorTotal = $subtotal + $taxaServico + $valorEntrega - $desconto;
            
            // Atualizar pedido
            $pedido->update([
                'cod_mesa' => $validated['cod_mesa'],
                'tipo_pedido' => $tipoPedidoMap[$validated['tipo_pedido']],
                'forma_pagamento' => $pagamentoMap[$validated['forma_pagamento']], // ALTERADO
                'taxa_servico' => $taxaServico,
                'valor_entrega' => $valorEntrega,
                'desconto' => $desconto,
                'valor_total' => $valorTotal,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pedidos.show', $pedido->cod_pedido)
                ->with('success', 'Pedido #' . $pedido->cod_pedido . ' atualizado com sucesso!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Erro ao atualizar pedido: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Erro ao atualizar pedido: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    // Encerrar/Entregar pedido
    public function encerrar($id)
    {
        $pedido = Pedido::findOrFail($id);
        
        if ($pedido->cancelado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível entregar um pedido cancelado!');
        }
        
        if ($pedido->encerrado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Este pedido já foi entregue!');
        }
        
        $pedido->update([
            'encerrado' => 1,
            'datahora_encerramento' => now(),
        ]);
        
        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido #' . $pedido->cod_pedido . ' marcado como entregue!');
    }
    
    // Cancelar pedido
    public function cancelar($id)
    {
        $pedido = Pedido::findOrFail($id);
        
        if ($pedido->encerrado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Não é possível cancelar um pedido já entregue!');
        }
        
        if ($pedido->cancelado) {
            return redirect()->route('admin.pedidos.index')
                ->with('error', 'Este pedido já está cancelado!');
        }
        
        $pedido->update([
            'cancelado' => 1,
        ]);
        
        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido #' . $pedido->cod_pedido . ' cancelado com sucesso!');
    }
}