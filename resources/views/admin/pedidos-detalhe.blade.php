<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido #{{ $pedido->cod_pedido }} | Sabor & Cia</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Figtree', sans-serif; }

        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #e5e5e5;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e5e5;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .menu-section {
            margin-bottom: 24px;
        }

        .menu-section-title {
            padding: 0 16px;
            font-size: 11px;
            text-transform: uppercase;
            color: #737373;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .menu-item {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            color: #0a0a0a;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
            font-size: 14px;
        }

        .menu-item:hover {
            background: #f5f5f5;
            border-left-color: #ea580c;
        }

        .menu-item.active {
            background: #fff7ed;
            border-left-color: #ea580c;
            color: #ea580c;
            font-weight: 500;
        }

        .menu-item-icon {
            margin-right: 12px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: #fafafa;
        }

        .top-bar {
            background: white;
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            margin-bottom: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .info-item {
            padding: 12px;
            background: #fafafa;
            border-radius: 6px;
        }

        .info-label {
            font-size: 12px;
            color: #737373;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #0a0a0a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        table th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #0a0a0a;
            border-bottom: 1px solid #e5e5e5;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e5e5;
            color: #0a0a0a;
            font-size: 14px;
        }

        .btn-logout {
            background: #ea580c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-logout:hover {
            background: #dc2626;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #ea580c;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: #0a0a0a;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
    </style>
</head>
<body class="bg-background">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                        <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                        <path d="m2.1 21.8 6.4-6.3"/>
                        <path d="m19 5-7 7"/>
                    </svg>
                </div>
                <span class="logo-text">Sabor & Cia</span>
            </div>
            <p class="text-xs text-muted-foreground mt-1">Painel Administrativo</p>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Principal</div>
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <span class="menu-item-icon">📊</span>
                    Dashboard
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Gestão</div>
                <a href="{{ route('admin.clientes') }}" class="menu-item">
                    <span class="menu-item-icon">👥</span>
                    Gerenciar Clientes
                </a>
                <a href="{{ route('admin.pratos.index') }}" class="menu-item">
                    <span class="menu-item-icon">🍕</span>
                    Gerenciar Pratos
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="menu-item active">
                    <span class="menu-item-icon">🛒</span>
                    Gerenciar Pedidos
                </a>
                <a href="{{ route('admin.mesas.index') }}" class="menu-item">
                    <span class="menu-item-icon">🪑</span>
                    Gerenciar Mesas
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Estoque</div>
                <a href="{{ route('admin.fornecedores') }}" class="menu-item">
                    <span class="menu-item-icon">🚚</span>
                    Fornecedores
                </a>
                <a href="{{ route('admin.ingredientes') }}" class="menu-item">
                    <span class="menu-item-icon">🧀</span>
                    Ingredientes
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="text-xl font-semibold text-foreground">Detalhes do Pedido</h1>
                <p class="text-sm text-muted-foreground">Informações completas do pedido #{{ $pedido->cod_pedido }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if(!$pedido->encerrado && !$pedido->cancelado)
                <form method="POST" action="{{ route('admin.pedidos.encerrar', $pedido->cod_pedido) }}">
                    @csrf
                    <button type="button" 
                        style="background: #22c55e; color: white; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; border: none; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#16a34a'" 
                        onmouseout="this.style.background='#22c55e'"
                        onclick="confirmarEntrega(this, {{ $pedido->cod_pedido }})">
                        ✓ Marcar como Entregue
                </form>
                @elseif($pedido->cancelado)
                <div style="background: #fee2e2; color: #991b1b; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; border: 1px solid #fca5a5;">
                    ❌ Pedido Cancelado
                </div>
                @else
                <div style="background: #dcfce7; color: #166534; padding: 8px 16px; border-radius: 6px; font-size: 14px; font-weight: 500; border: 1px solid #bbf7d0;">
                    ✓ Pedido Entregue
                </div>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Sair</button>
                </form>
            </div>
        </div>

        <div style="padding: 24px; max-w-6xl; margin: 0 auto;">
            <!-- Voltar -->
            <div style="margin-bottom: 20px;">
                <a href="{{ route('admin.pedidos.index') }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; color: #737373; text-decoration: none; font-size: 14px; transition: color 0.2s;"
                   onmouseover="this.style.color='#0a0a0a'" 
                   onmouseout="this.style.color='#737373'">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar para Pedidos
                </a>
            </div>

            <!-- Informações do Pedido -->
            <div class="content-card">
                <h2 style="font-size: 20px; font-weight: 600; color: #0a0a0a; margin-bottom: 4px;">
                    Informações do Pedido #{{ $pedido->cod_pedido }}
                </h2>
                <p style="font-size: 14px; color: #737373; margin-bottom: 16px;">
                    Realizado em {{ $pedido->datahora->format('d/m/Y \à\s H:i') }}
                </p>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Cliente</div>
                        <div class="info-value">
                            {{ $pedido->cliente ? $pedido->cliente->nome : 'Não identificado' }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Tipo de Pedido</div>
                        <div class="info-value">
                            {{ $pedido->tipo_pedido_label }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Mesa/Local</div>
                        <div class="info-value">{{ $pedido->cod_mesa ?? '-' }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            @if($pedido->cancelado)
                                <span style="color: #ef4444;">❌ Cancelado</span>
                            @elseif($pedido->encerrado)
                                <span style="color: #22c55e;">✓ Entregue</span>
                            @else
                                <span style="color: #f59e0b;">⏳ Pendente</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($pedido->encerrado && $pedido->datahora_encerramento)
                    <div class="info-item">
                        <div class="info-label">Entregue em</div>
                        <div class="info-value">
                            {{ $pedido->datahora_encerramento->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Itens do Pedido -->
            <div class="content-card">
                <h2 style="font-size: 20px; font-weight: 600; color: #0a0a0a; margin-bottom: 4px;">Itens do Pedido</h2>
                <p style="font-size: 14px; color: #737373; margin-bottom: 16px;">Produtos solicitados neste pedido</p>
                
                <table>
                    <thead>
                        <tr>
                            <th>Prato</th>
                            <th style="text-align: center; width: 100px;">Quantidade</th>
                            <th style="text-align: right; width: 120px;">Valor Unit.</th>
                            <th style="text-align: right; width: 120px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedido->itens as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($item->prato)
                                        <img src="{{ $item->prato->foto_url }}" alt="{{ $item->prato->descricao }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e5e5;">
                                        <div>
                                            <div style="font-weight: 600;">{{ $item->prato->descricao }}</div>
                                            <div style="font-size: 12px; color: #737373;">
                                                {{ $item->prato->categoria->descricao ?? '' }}
                                            </div>
                                        </div>
                                    @else
                                        <div style="color: #737373;">Prato não encontrado</div>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <span style="font-weight: 600;">{{ $item->quantidade }}x</span>
                            </td>
                            <td style="text-align: right;">
                                R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right; font-weight: 600;">
                                R$ {{ number_format($item->subtotal, 2, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #737373;">
                                Nenhum item encontrado
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Resumo Financeiro -->
                <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #e5e5e5;">
                    <div style="max-width: 400px; margin-left: auto;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #737373;">Subtotal:</span>
                            <span style="font-weight: 600;">R$ {{ number_format($pedido->itens->sum('subtotal'), 2, ',', '.') }}</span>
                        </div>
                        
                        @if($pedido->taxa_servico > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #737373;">Taxa de Serviço (10%):</span>
                            <span style="font-weight: 600;">R$ {{ number_format($pedido->taxa_servico, 2, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        @if($pedido->valor_entrega > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #737373;">Taxa de Entrega:</span>
                            <span style="font-weight: 600;">R$ {{ number_format($pedido->valor_entrega, 2, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        @if($pedido->desconto > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                            <span style="color: #737373;">Desconto:</span>
                            <span style="font-weight: 600; color: #22c55e;">- R$ {{ number_format($pedido->desconto, 2, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px solid #e5e5e5; font-size: 18px; font-weight: 700;">
                            <span>TOTAL:</span>
                            <span style="color: #ea580c;">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações de Pagamento -->
            <div class="content-card">
                <h2 style="font-size: 20px; font-weight: 600; color: #0a0a0a; margin-bottom: 16px;">Pagamento</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Método de Pagamento</div>
                        <div class="info-value">{{ $pedido->pagamento_label }}</div>
                    </div>
                    
                    @if($pedido->valor_pago)
                    <div class="info-item">
                        <div class="info-label">Valor Pago</div>
                        <div class="info-value">R$ {{ number_format($pedido->valor_pago, 2, ',', '.') }}</div>
                    </div>
                    @endif
                    
                    @if($pedido->data_pago)
                    <div class="info-item">
                        <div class="info-label">Data do Pagamento</div>
                        <div class="info-value">{{ $pedido->data_pago->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarEntrega(button, pedidoId) {
            Swal.fire({
                title: 'Confirmar entrega?',
                html: `Deseja marcar o pedido <strong>#${pedidoId}</strong> como entregue?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#0a0a0a',
                confirmButtonText: 'Sim, entregar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processando...',
                        text: 'Aguarde',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    button.closest('form').submit();
                }
            });
        }
    </script>
</body>
</html>