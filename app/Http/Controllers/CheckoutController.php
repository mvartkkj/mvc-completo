<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Prato;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        Log::info('=== CHECKOUT INDEX CHAMADO ===');
        Log::info('Método: ' . $request->method());
        Log::info('Tem cart no POST? ' . ($request->has('cart') ? 'SIM' : 'NÃO'));
        
        $tableCode = session('table_code', 'Mesa 12');
        
        // Receber carrinho do POST
        if ($request->has('cart')) {
            $cartData = json_decode($request->input('cart'), true);
            Log::info('Carrinho recebido do POST:', $cartData);
            session(['cart' => $cartData]);
        }
        
        $cart = session('cart', []);
        Log::info('Carrinho na sessão:', $cart);
        
        if (empty($cart)) {
            Log::warning('Carrinho vazio! Redirecionando...');
            return redirect()->route('menu')->with('error', 'Seu carrinho está vazio!');
        }

        // Buscar pratos do carrinho
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $pratoId => $quantidade) {
            $prato = Prato::find($pratoId);
            if ($prato) {
                $cartItems[] = [
                    'id' => $prato->cod_prato,
                    'name' => $prato->descricao,
                    'price' => $prato->valor_unitario,
                    'quantity' => $quantidade,
                    'image' => $prato->foto_url,
                ];
                $subtotal += $prato->valor_unitario * $quantidade;
            }
        }

        Log::info('Total de itens processados: ' . count($cartItems));
        Log::info('Subtotal: ' . $subtotal);

        $serviceCharge = $subtotal * 0.1;
        $total = $subtotal + $serviceCharge;

        // Verificar se está logado
        $user = Auth::guard('cliente')->user();

        return view('checkout', compact('tableCode', 'cartItems', 'subtotal', 'serviceCharge', 'total', 'user'));
    }

    public function store(Request $request)
    {
        Log::info('=== CHECKOUT STORE CHAMADO ===');
        Log::info('Dados recebidos:', $request->all());
        
        $validated = $request->validate([
            'payment_method' => 'required|in:credito,debito,pix,dinheiro',
            'delivery_option' => 'required|in:mesa,balcao,delivery',
            'observations' => 'nullable|string|max:500',
            'change_for' => 'nullable|numeric|min:0',
            
            // Campo de nome para balcão
            'nome_cliente_balcao' => 'required_if:delivery_option,balcao|nullable|string|max:100',
            
            // Campos de delivery
            'endereco' => 'required_if:delivery_option,delivery|nullable|string|max:255',
            'numero' => 'required_if:delivery_option,delivery|nullable|string|max:10',
            'bairro' => 'required_if:delivery_option,delivery|nullable|string|max:100',
            'cidade' => 'required_if:delivery_option,delivery|nullable|string|max:100',
            'cep' => 'required_if:delivery_option,delivery|nullable|string|size:8',
            'complemento' => 'nullable|string|max:255',
        ], [
            'nome_cliente_balcao.required_if' => 'O nome é obrigatório para retirada no balcão',
            'endereco.required_if' => 'O endereço é obrigatório para delivery',
            'numero.required_if' => 'O número é obrigatório para delivery',
            'bairro.required_if' => 'O bairro é obrigatório para delivery',
            'cidade.required_if' => 'A cidade é obrigatória para delivery',
            'cep.required_if' => 'O CEP é obrigatório para delivery',
        ]);

        $cart = session('cart', []);
        Log::info('Carrinho na store:', $cart);
        
        if (empty($cart)) {
            Log::error('Carrinho vazio na store!');
            return redirect()->route('menu')->with('error', 'Seu carrinho está vazio!');
        }

        DB::beginTransaction();
        
        try {
            // Mapear tipo de pedido para código numérico
            $tipoPedidoMap = [
                'mesa' => 1,      // Mesa
                'balcao' => 2,    // Balcão
                'delivery' => 3,  // Delivery
            ];

            // Mapear forma de pagamento para código numérico
            $pagamentoMap = [
                'credito' => 2,   // Crédito
                'debito' => 3,    // Débito
                'pix' => 4,       // PIX
                'dinheiro' => 1,  // Dinheiro
            ];

            // Determinar cod_cliente
            $codCliente = Auth::guard('cliente')->id();

            // Se não estiver logado como cliente
            if (!$codCliente) {
                // Verificar se é mesa logada
                if (session()->has('mesa_logada')) {
                    // Criar cliente temporário para a mesa
                    $mesaDescricao = session('table_code', 'Mesa Temporária');
                    
                    $clienteTemp = Cliente::create([
                        'nome' => $mesaDescricao,
                        'e_mail' => null,
                        'passwd' => null,
                        'celular' => null,
                    ]);
                    
                    $codCliente = $clienteTemp->cod_cliente;
                    Log::info('Cliente temporário criado para mesa: ' . $mesaDescricao);
                }
                // Se for balcão
                elseif ($validated['delivery_option'] === 'balcao') {
                    // Seu código existente de balcão
                }
            }
            
            // Se for balcão e não estiver logado, criar cliente temporário
            if ($validated['delivery_option'] === 'balcao' && !$codCliente) {
                $nomeBalcao = $validated['nome_cliente_balcao'];
                
                // Buscar se já existe um cliente temporário com este nome
                $clienteTemp = Cliente::where('nome', $nomeBalcao)
                    ->whereNull('e_mail')
                    ->whereNull('passwd')
                    ->first();
                
                if (!$clienteTemp) {
                    // Criar cliente temporário
                    $clienteTemp = Cliente::create([
                        'nome' => $nomeBalcao,
                        'e_mail' => null,
                        'passwd' => null,
                        'celular' => null,
                    ]);
                    
                    Log::info('Cliente temporário criado: ' . $clienteTemp->cod_cliente);
                }
                
                $codCliente = $clienteTemp->cod_cliente;
            }

            // Calcular valores
            $subtotal = 0;
            $pratosDados = [];

            foreach ($cart as $pratoId => $quantidade) {
                $prato = Prato::findOrFail($pratoId);
                $pratosDados[] = [
                    'prato' => $prato,
                    'quantidade' => $quantidade,
                    'subtotal' => $prato->valor_unitario * $quantidade,
                ];
                $subtotal += $prato->valor_unitario * $quantidade;
            }

            $taxaServico = $subtotal * 0.1;
            $taxaEntrega = $validated['delivery_option'] === 'delivery' ? 10.00 : 0;
            $total = $subtotal + $taxaServico + $taxaEntrega;

            Log::info('Criando pedido com total: ' . $total);

            // Buscar mesa (se necessário)
            $codMesa = null;
            if ($validated['delivery_option'] === 'mesa') {
                $tableCode = session('table_code', 'Mesa 12');
                
                $mesa = DB::table('mesas')
                    ->where('descricao', $tableCode)
                    ->first();
                
                if ($mesa) {
                    $codMesa = $mesa->cod_mesa;
                } else {
                    Log::warning('Mesa não encontrada: ' . $tableCode);
                    $codMesa = $tableCode; // Salva o nome como fallback
                }
            }

            // Preparar dados do pedido
            $pedidoData = [
                'cod_cliente' => $codCliente,
                'tipo_pedido' => $tipoPedidoMap[$validated['delivery_option']],
                'valor_entrega' => $taxaEntrega,
                'taxa_servico' => $taxaServico,
                'valor_total' => $total,
                'forma_pagamento' => $pagamentoMap[$validated['payment_method']],
                'encerrado' => 0,
                'datahora' => now(),
            ];

            // Adicionar cod_mesa se não for delivery
            if ($validated['delivery_option'] !== 'delivery') {
                $pedidoData['cod_mesa'] = $codMesa;
            }

            Log::info('Dados do pedido:', $pedidoData);

            // Criar pedido
            $pedido = Pedido::create($pedidoData);

            Log::info('Pedido criado com ID: ' . $pedido->cod_pedido);

            // Atualizar endereço do cliente se for delivery
            if ($validated['delivery_option'] === 'delivery' && Auth::guard('cliente')->check()) {
                $cliente = Auth::guard('cliente')->user();
                $cliente->update([
                    'endereco' => $validated['endereco'],
                    'numero' => $validated['numero'],
                    'bairro' => $validated['bairro'],
                    'cep' => $validated['cep'],
                ]);
            }

            // Criar itens do pedido
            foreach ($pratosDados as $item) {
                PedidoItem::create([
                    'cod_pedido' => $pedido->cod_pedido,
                    'cod_prato' => $item['prato']->cod_prato,
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['prato']->valor_unitario,
                    'data_hora' => now(),
                ]);
            }

            Log::info('Itens do pedido criados');

            DB::commit();

            // Limpar carrinho da sessão
            session()->forget('cart');
            Log::info('Carrinho limpo da sessão');

            return redirect()->route('order.success', ['orderId' => $pedido->cod_pedido])
                ->with('success', 'Pedido realizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao processar pedido: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao processar pedido: ' . $e->getMessage());
        }
    }
}