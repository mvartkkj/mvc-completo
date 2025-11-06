    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pedidos | Sabor & Cia</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }

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
                margin: 24px;
            }

            .content-card h2 {
                font-size: 20px;
                font-weight: 600;
                color: #0a0a0a;
                margin-bottom: 8px;
            }

            .content-card p {
                font-size: 14px;
                color: #737373;
                line-height: 1.6;
                margin-bottom: 20px;
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

            table tr:hover {
                background: #fafafa;
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
                padding: 4px 12px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 500;
                display: inline-block;
            }

            .status-pendente {
                background: #fef3c7;
                color: #92400e;
            }

            .status-preparando {
                background: #dbeafe;
                color: #1e40af;
            }

            .status-pronto {
                background: #d1fae5;
                color: #065f46;
            }

            .status-entregue {
                background: #dcfce7;
                color: #166534;
            }

            .status-cancelado {
                background: #fee2e2;
                color: #991b1b;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 12px;
                margin-bottom: 24px;
            }

            .stat-card {
                background: white;
                border: 1px solid #e5e5e5;
                border-radius: 8px;
                padding: 16px;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s;
            }

            .stat-card:hover {
                border-color: #ea580c;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }

            .stat-card.active {
                border-color: #ea580c;
                background: #fff7ed;
            }

            .stat-number {
                font-size: 24px;
                font-weight: 700;
                color: #0a0a0a;
            }

            .stat-label {
                font-size: 12px;
                color: #737373;
                margin-top: 4px;
            }
        </style>
    </head>
    <body class="bg-background">
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

        <div class="main-content">
            <div class="top-bar">
                <div>
                    <h1 class="text-xl font-semibold text-foreground">Gerenciar Pedidos</h1>
                    <p class="text-sm text-muted-foreground">Lista de todos os pedidos cadastrados</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">Sair</button>
                </form>
            </div>

            <!-- Mensagens -->
            @if(session('success'))
            <div style="margin: 24px 24px 0 24px;">
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <div class="content-card">
                <!-- Estatísticas -->
                <div class="stats-grid">
                    <a href="{{ route('admin.pedidos.index', ['status' => 'todos']) }}" class="stat-card {{ !$status || $status === 'todos' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['total'] }}</div>
                        <div class="stat-label">Total</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index', ['status' => 'pendente']) }}" class="stat-card {{ $status === 'pendente' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['pendente'] }}</div>
                        <div class="stat-label">Pendentes</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index', ['status' => 'preparando']) }}" class="stat-card {{ $status === 'preparando' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['preparando'] }}</div>
                        <div class="stat-label">Em Preparo</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index', ['status' => 'pronto']) }}" class="stat-card {{ $status === 'pronto' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['pronto'] }}</div>
                        <div class="stat-label">Prontos</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index', ['status' => 'entregue']) }}" class="stat-card {{ $status === 'entregue' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['entregue'] }}</div>
                        <div class="stat-label">Entregues</div>
                    </a>
                    <a href="{{ route('admin.pedidos.index', ['status' => 'cancelado']) }}" class="stat-card {{ $status === 'cancelado' ? 'active' : '' }}">
                        <div class="stat-number">{{ $stats['cancelado'] }}</div>
                        <div class="stat-label">Cancelados</div>
                    </a>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2>Lista de Pedidos</h2>
                        <p>Total: {{ $pedidos->total() }} pedidos</p>
                    </div>
                    <form method="GET" action="{{ route('admin.pedidos.index') }}" class="flex gap-2">
                        <input type="hidden" name="status" value="{{ $status ?? 'todos' }}">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Buscar por pedido, mesa, cliente..." 
                                class="w-80 h-10 pl-10 pr-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50"
                            />
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <button type="submit" class="px-4 h-10 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">
                            Buscar
                        </button>
                        @if($search ?? false)
                        <a href="{{ route('admin.pedidos.index', ['status' => $status ?? 'todos']) }}" class="px-4 h-10 bg-muted text-foreground rounded-lg hover:bg-muted/80 transition-colors font-medium flex items-center">
                            Limpar
                        </a>
                        @endif
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Data/Hora</th>
                                <th>Cliente</th>
                                <th>Local</th>
                                <th>Total</th>
                                <th>Pagamento</th>
                                <th>Status</th>
                                <th style="text-align: center; width: 180px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pedidos as $pedido)
                            <tr style="{{ $pedido->cancelado ? 'opacity: 0.6; background: #fee2e2;' : '' }}">
                                <td class="font-semibold" style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">#{{ $pedido->cod_pedido }}</td>
                                <td style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">{{ $pedido->datahora->format('d/m/Y H:i') }}</td>
                                <td style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">
                                    @if($pedido->cliente)
                                        {{ $pedido->cliente->nome }}
                                    @else
                                        <span class="text-muted-foreground">Cliente não identificado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pedido->tipo_pedido === 'mesa')
                                        <span class="text-xs font-medium">🍽️ Mesa{{ $pedido->cod_mesa }}</span>
                                    @elseif($pedido->tipo_pedido === 'balcao')
                                        <span class="text-xs font-medium">🪑 Balcão</span>
                                    @else
                                        <span class="text-xs font-medium">🚚 Delivery</span>
                                    @endif
                                </td>
                                <td class="font-semibold" style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</td>
                                <td style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">
                                    <span class="text-xs">{{ ucfirst($pedido->forma_pagamento ) }}</span>
                                </td>
                                <td style="{{ $pedido->cancelado ? 'text-decoration: line-through;' : '' }}">
                                    @if($pedido->cancelado)
                                        <span class="status-badge status-cancelado">
                                            Cancelado
                                        </span>
                                    @elseif($pedido->encerrado)
                                        <span class="status-badge status-entregue">
                                            Entregue
                                        </span>
                                    @else
                                        <span class="status-badge status-pendente">
                                            Pendente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('admin.pedidos.show', $pedido->cod_pedido) }}" 
                                        style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s;"
                                        onmouseover="this.style.background='#2563eb'" 
                                        onmouseout="this.style.background='#3b82f6'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Ver
                                        </a>
                                        
                                        @if(!$pedido->encerrado && !$pedido->cancelado)
                                        <a href="{{ route('admin.pedidos.edit', $pedido->cod_pedido) }}" 
                                        style="background: #0a0a0a; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s;"
                                        onmouseover="this.style.background='#3a3939ff'" 
                                        onmouseout="this.style.background='#0a0a0a'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </a>
                                        
                                        <form method="POST" action="{{ route('admin.pedidos.encerrar', $pedido->cod_pedido) }}" style="display: inline;">
                                            @csrf
                                            <button type="button" 
                                                style="background: #22c55e; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                                onmouseover="this.style.background='#16a34a'" 
                                                onmouseout="this.style.background='#22c55e'"
                                                onclick="confirmarEntrega(this, {{ $pedido->cod_pedido }})">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Entregar
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.pedidos.cancelar', $pedido->cod_pedido) }}" style="display: inline;">
                                            @csrf
                                            <button type="button" 
                                                style="background: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                                onmouseover="this.style.background='#dc2626'" 
                                                onmouseout="this.style.background='#ef4444'"
                                                onclick="confirmarCancelamento(this, {{ $pedido->cod_pedido }})">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Cancelar
                                            </button>
                                        </form>
                                        @else
                                        <span style="color: #737373; font-size: 12px; padding: 6px 12px;">
                                            {{ $pedido->cancelado ? '❌ Cancelado' : '✅ Entregue' }}
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted-foreground py-8">
                                    @if($search ?? false)
                                        Nenhum pedido encontrado com "{{ $search }}"
                                    @else
                                        Nenhum pedido cadastrado
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- SweetAlert2 -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    document.querySelectorAll('.btn-delete').forEach(function(button) {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();
                            
                            const form = this.closest('.delete-form');
                            const pedidoId = this.getAttribute('data-pedido-id');

                            Swal.fire({
                                title: 'Você tem certeza?',
                                html: `Deseja realmente excluir o pedido <strong>#${pedidoId}</strong>?<br><span style="color: #dc2626; font-size: 14px;">Esta ação não pode ser desfeita!</span>`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#0a0a0a',
                                confirmButtonText: 'Sim, deletar!',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true,
                                focusCancel: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        title: 'Excluindo...',
                                        text: 'Por favor, aguarde',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    });
                                    form.submit();
                                }
                            });
                        });
                    });
                </script>

                <!-- Paginação -->
                @if($pedidos->hasPages())
                <div class="mt-6 flex items-center justify-between border-t border-border pt-4">
                    <div class="text-sm text-muted-foreground">
                        Mostrando {{ $pedidos->firstItem() }} a {{ $pedidos->lastItem() }} de {{ $pedidos->total() }} pedidos
                    </div>
                    <div class="flex gap-2">
                        @if ($pedidos->onFirstPage())
                            <span class="px-3 py-2 bg-muted/50 text-muted-foreground rounded cursor-not-allowed">Anterior</span>
                        @else
                            <a href="{{ $pedidos->previousPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Anterior</a>
                        @endif

                        <div class="flex gap-1">
                            @if($pedidos->currentPage() > 3)
                                <a href="{{ $pedidos->url(1) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">1</a>
                                @if($pedidos->currentPage() > 4)
                                    <span class="px-3 py-2 text-muted-foreground">...</span>
                                @endif
                            @endif

                            @for($i = max(1, $pedidos->currentPage() - 2); $i <= min($pedidos->lastPage(), $pedidos->currentPage() + 2); $i++)
                                @if ($i == $pedidos->currentPage())
                                    <span class="px-3 py-2 bg-primary text-white rounded font-medium">{{ $i }}</span>
                                @else
                                    <a href="{{ $pedidos->url($i) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $i }}</a>
                                @endif
                            @endfor

                            @if($pedidos->currentPage() < $pedidos->lastPage() - 2)
                                @if($pedidos->currentPage() < $pedidos->lastPage() - 3)
                                    <span class="px-3 py-2 text-muted-foreground">...</span>
                                @endif
                                <a href="{{ $pedidos->url($pedidos->lastPage()) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $pedidos->lastPage() }}</a>
                            @endif
                        </div>

                        @if ($pedidos->hasMorePages())
                            <a href="{{ $pedidos->nextPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Próximo</a>
                        @else
                            <span class="px-3 py-2 bg-muted/50 text-muted-foreground rounded cursor-not-allowed">Próximo</span>
                        @endif
                    </div>
                </div>
                @endif
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

            function confirmarCancelamento(button, pedidoId) {
                Swal.fire({
                    title: 'Cancelar pedido?',
                    html: `Tem certeza que deseja cancelar o pedido <strong>#${pedidoId}</strong>?<br><span style="color: #dc2626; font-size: 14px;">Esta ação não pode ser desfeita!</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#0a0a0a',
                    confirmButtonText: 'Sim, cancelar!',
                    cancelButtonText: 'Não',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Cancelando...',
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