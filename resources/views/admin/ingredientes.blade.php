<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ingredientes - Sabor & Cia</title>

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
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-ok {
            background: #f0fdf4;
            color: #22c55e;
        }

        .status-baixo {
            background: #fef3c7;
            color: #f59e0b;
        }

        .status-critico {
            background: #fee;
            color: #ef4444;
        }

        .status-sem-controle {
            background: #f5f5f5;
            color: #737373;
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
                <a href="{{ route('admin.pedidos.index') }}" class="menu-item">
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
                <a href="{{ route('admin.ingredientes') }}" class="menu-item active">
                    <span class="menu-item-icon">🧀</span>
                    Ingredientes
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <h1 class="text-xl font-semibold text-foreground">Ingredientes</h1>
                <p class="text-sm text-muted-foreground">Controle de estoque de ingredientes e alertas de reposição</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <!-- Mensagens de sucesso -->
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
            <div class="flex justify-between items-center mb-6">
                <div class="flex w-full items-center">
                    <div>
                        <h2>Lista de Ingredientes</h2>
                        <p>Total: {{ $ingredientes->total() }} ingredientes cadastrados</p>
                    </div>
                    <div class="flex gap-3 items-center ml-5">
                        <!-- Botão de Cadastrar Novo Ingrediente -->
                        <a href="{{ route('admin.ingredientes.create') }}" 
                            style="background: #ef4444; color: white; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s;"
                            onmouseover="this.style.background='#dc2626'" 
                            onmouseout="this.style.background='#ef4444'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Novo Ingrediente
                        </a>
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.ingredientes') }}" class="flex gap-2">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search ?? '' }}"
                            placeholder="Buscar ingrediente..." 
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
                    <a href="{{ route('admin.ingredientes') }}" class="px-4 h-10 bg-muted text-foreground rounded-lg hover:bg-muted/80 transition-colors font-medium flex items-center">
                        Limpar
                    </a>
                    @endif
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ingrediente</th>
                            <th>Quantidade</th>
                            <th>Unidade</th>
                            <th>Valor Unitário</th>
                            <th>Status</th>
                            <th style="text-align: center; width: 220px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ingredientes as $ingrediente)
                        <tr>
                            <td>#{{ str_pad($ingrediente->cod_ingrediente, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $ingrediente->descricao }}</td>
                            <td>{{ number_format($ingrediente->quantidade_estoque ?? 0, 1, ',', '.') }}</td>
                            <td>{{ $ingrediente->unidade->sigla ?? '-' }}</td>
                            <td>R$ {{ number_format($ingrediente->valor_unitario ?? 0, 2, ',', '.') }}</td>
                            <td>
                                @if($ingrediente->controla_estoque)
                                    <span class="status-badge status-{{ $ingrediente->status_estoque }}">
                                        {{ $ingrediente->texto_status }}
                                    </span>
                                @else
                                    <span class="status-badge status-sem-controle">Sem Controle</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2 justify-center">
                                    <!-- Botão Adicionar Estoque -->
                                    @if($ingrediente->controla_estoque)
                                    <button 
                                        type="button"
                                        class="btn-add-estoque"
                                        data-ingrediente-id="{{ $ingrediente->cod_ingrediente }}"
                                        data-ingrediente-nome="{{ $ingrediente->descricao }}"
                                        data-ingrediente-unidade="{{ $ingrediente->unidade->sigla ?? '' }}"
                                        data-ingrediente-quantidade="{{ $ingrediente->quantidade_estoque ?? 0 }}"
                                        style="background: #22c55e; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                        onmouseover="this.style.background='#16a34a'" 
                                        onmouseout="this.style.background='#22c55e'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Adicionar
                                    </button>
                                    @endif
                                    
                                    <a href="{{ route('admin.ingredientes.edit', $ingrediente->cod_ingrediente) }}" 
                                    style="background: #0a0a0a; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s;"
                                    onmouseover="this.style.background='#3a3939ff'" 
                                    onmouseout="this.style.background='#0a0a0a'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.ingredientes.destroy', $ingrediente->cod_ingrediente) }}" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete" 
                                                data-ingrediente-nome="{{ $ingrediente->descricao }}"
                                                style="background: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                                onmouseover="this.style.background='#dc2626'" 
                                                onmouseout="this.style.background='#ef4444'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted-foreground py-8">
                                @if($search ?? false)
                                    Nenhum ingrediente encontrado com "{{ $search }}"
                                @else
                                    Nenhum ingrediente cadastrado
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
                // Modal de Adicionar Estoque
                document.querySelectorAll('.btn-add-estoque').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        
                        const ingredienteId = this.getAttribute('data-ingrediente-id');
                        const ingredienteNome = this.getAttribute('data-ingrediente-nome');
                        const ingredienteUnidade = this.getAttribute('data-ingrediente-unidade');
                        const quantidadeAtual = parseFloat(this.getAttribute('data-ingrediente-quantidade'));

                        Swal.fire({
                            title: 'Adicionar ao Estoque',
                            html: `
                                <div style="text-align: left;">
                                    <p style="margin-bottom: 10px;"><strong>Ingrediente:</strong> ${ingredienteNome}</p>
                                    <p style="margin-bottom: 20px;"><strong>Quantidade Atual:</strong> ${quantidadeAtual.toFixed(1)} ${ingredienteUnidade}</p>
                                    <label for="quantidade-adicionar" style="display: block; margin-bottom: 8px; font-weight: 500;">Quantidade a Adicionar (${ingredienteUnidade}):</label>
                                    <input 
                                        type="number" 
                                        id="quantidade-adicionar" 
                                        class="swal2-input" 
                                        placeholder="Ex: 10"
                                        step="0.1"
                                        min="0.1"
                                        style="width: 100%; padding: 10px; border: 1px solid #e5e5e5; border-radius: 6px;"
                                    >
                                </div>
                            `,
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#22c55e',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Adicionar',
                            cancelButtonText: 'Cancelar',
                            focusConfirm: false,
                            preConfirm: () => {
                                const quantidade = document.getElementById('quantidade-adicionar').value;
                                if (!quantidade || parseFloat(quantidade) <= 0) {
                                    Swal.showValidationMessage('Por favor, informe uma quantidade válida');
                                    return false;
                                }
                                return { quantidade: parseFloat(quantidade) };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const quantidade = result.value.quantidade;
                                const novaQuantidade = quantidadeAtual + quantidade;
                                
                                // Criar formulário e enviar
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = `/admin/ingredientes/${ingredienteId}/adicionar-estoque`;
                                
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                                const csrfInput = document.createElement('input');
                                csrfInput.type = 'hidden';
                                csrfInput.name = '_token';
                                csrfInput.value = csrfToken;
                                form.appendChild(csrfInput);
                                
                                const quantidadeInput = document.createElement('input');
                                quantidadeInput.type = 'hidden';
                                quantidadeInput.name = 'quantidade_adicionar';
                                quantidadeInput.value = quantidade;
                                form.appendChild(quantidadeInput);
                                
                                document.body.appendChild(form);
                                
                                Swal.fire({
                                    title: 'Adicionando...',
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

                // Exclusão de ingredientes
                document.querySelectorAll('.btn-delete').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        
                        const form = this.closest('.delete-form');
                        const ingredienteNome = this.getAttribute('data-ingrediente-nome');

                        Swal.fire({
                            title: 'Você tem certeza?',
                            html: `Deseja realmente excluir o ingrediente <strong>${ingredienteNome}</strong>?<br><span style="color: #dc2626; font-size: 14px;">Esta ação não pode ser desfeita!</span>`,
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
            @if($ingredientes->hasPages())
            <div class="mt-6 flex items-center justify-between border-t border-border pt-4">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ $ingredientes->firstItem() }} a {{ $ingredientes->lastItem() }} de {{ $ingredientes->total() }} ingredientes
                </div>
                <div class="flex gap-2">
                    @if ($ingredientes->onFirstPage())
                        <span class="px-3 py-2 bg-muted/50 text-muted-foreground rounded cursor-not-allowed">Anterior</span>
                    @else
                        <a href="{{ $ingredientes->previousPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Anterior</a>
                    @endif

                    <div class="flex gap-1">
                        @if($ingredientes->currentPage() > 3)
                            <a href="{{ $ingredientes->url(1) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">1</a>
                            @if($ingredientes->currentPage() > 4)
                                <span class="px-3 py-2 text-muted-foreground">...</span>
                            @endif
                        @endif

                        @for($i = max(1, $ingredientes->currentPage() - 2); $i <= min($ingredientes->lastPage(), $ingredientes->currentPage() + 2); $i++)
                            @if ($i == $ingredientes->currentPage())
                                <span class="px-3 py-2 bg-primary text-white rounded font-medium">{{ $i }}</span>
                            @else
                                <a href="{{ $ingredientes->url($i) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($ingredientes->currentPage() < $ingredientes->lastPage() - 2)
                            @if($ingredientes->currentPage() < $ingredientes->lastPage() - 3)
                                <span class="px-3 py-2 text-muted-foreground">...</span>
                            @endif
                            <a href="{{ $ingredientes->url($ingredientes->lastPage()) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $ingredientes->lastPage() }}</a>
                        @endif
                    </div>

                    @if ($ingredientes->hasMorePages())
                        <a href="{{ $ingredientes->nextPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Próximo</a>
                    @else
                        <span class="px-3 py-2 bg-muted/50 text-muted-foreground rounded cursor-not-allowed">Próximo</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>