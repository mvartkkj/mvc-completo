<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clientes | Sabor & Cia</title>

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
                <a href="{{ route('admin.clientes') }}" class="menu-item active">
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
                <h1 class="text-xl font-semibold text-foreground">Gerenciar Clientes</h1>
                <p class="text-sm text-muted-foreground">Lista de todos os clientes cadastrados</p>
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
                        <h2>Lista de Clientes</h2>
                        <p>Total: {{ $clientes->total() }} clientes cadastrados</p>
                    </div>
                    <div class="flex gap-3 items-center ml-5">
                        <!-- Botão de Cadastrar Novo Cliente -->
                        <a href="{{ route('admin.clientes.create') }}" 
                            style="background: #ef4444; color: white; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s;"
                            onmouseover="this.style.background='#dc2626'" 
                            onmouseout="this.style.background='#ef4444'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Novo Cliente
                        </a>
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.clientes') }}" class="flex gap-2">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search ?? '' }}"
                            placeholder="Buscar por nome, email, celular..." 
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
                    <a href="{{ route('admin.clientes') }}" class="px-4 h-10 bg-muted text-foreground rounded-lg hover:bg-muted/80 transition-colors font-medium flex items-center">
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
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Cargo</th>
                            <th>CEP</th>
                            <th style="text-align: center; width: 150px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                        <tr>
                            <td>#{{ $cliente->cod_cliente }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->e_mail ?? '-' }}</td>
                            <td>{{ $cliente->celular ?? '-' }}</td>
                            <td>
                                @if($cliente->cargo)
                                    <span class="px-2 py-1 bg-primary/10 text-primary rounded text-xs font-medium">
                                        {{ $cliente->cargo->nome }}
                                    </span>
                                @else
                                    <span class="text-muted-foreground">-</span>
                                @endif
                            </td>
                            <td>{{ $cliente->cep ?? '-' }}</td>
                            <td>
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.clientes.edit', $cliente->cod_cliente) }}" 
                                    style="background: #0a0a0a; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s;"
                                    onmouseover="this.style.background='#3a3939ff'" 
                                    onmouseout="this.style.background='#0a0a0a'">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.clientes.delete', $cliente->cod_cliente) }}" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-delete" 
                                                data-cliente-nome="{{ $cliente->nome }}"
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
                                    Nenhum cliente encontrado com "{{ $search }}"
                                @else
                                    Nenhum cliente cadastrado
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
                // Seleciona TODOS os botões de exclusão
                document.querySelectorAll('.btn-delete').forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        
                        const form = this.closest('.delete-form');
                        const clienteNome = this.getAttribute('data-cliente-nome');

                        Swal.fire({
                            title: 'Você tem certeza?',
                            html: `Deseja realmente excluir o cliente <strong>${clienteNome}</strong>?<br><span style="color: #dc2626; font-size: 14px;">Esta ação não pode ser desfeita!</span>`,
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
            @if($clientes->hasPages())
            <div class="mt-6 flex items-center justify-between border-t border-border pt-4">
                <div class="text-sm text-muted-foreground">
                    Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} clientes
                </div>
                <div class="flex gap-2">
                    @if ($clientes->onFirstPage())
                        <span class="px-3 py-2 bg-muted/50 text-muted-foreground rounded cursor-not-allowed">Anterior</span>
                    @else
                        <a href="{{ $clientes->previousPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Anterior</a>
                    @endif

                    <div class="flex gap-1">
                        @if($clientes->currentPage() > 3)
                            <a href="{{ $clientes->url(1) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">1</a>
                            @if($clientes->currentPage() > 4)
                                <span class="px-3 py-2 text-muted-foreground">...</span>
                            @endif
                        @endif

                        @for($i = max(1, $clientes->currentPage() - 2); $i <= min($clientes->lastPage(), $clientes->currentPage() + 2); $i++)
                            @if ($i == $clientes->currentPage())
                                <span class="px-3 py-2 bg-primary text-white rounded font-medium">{{ $i }}</span>
                            @else
                                <a href="{{ $clientes->url($i) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($clientes->currentPage() < $clientes->lastPage() - 2)
                            @if($clientes->currentPage() < $clientes->lastPage() - 3)
                                <span class="px-3 py-2 text-muted-foreground">...</span>
                            @endif
                            <a href="{{ $clientes->url($clientes->lastPage()) }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">{{ $clientes->lastPage() }}</a>
                        @endif
                    </div>

                    @if ($clientes->hasMorePages())
                        <a href="{{ $clientes->nextPageUrl() }}" class="px-3 py-2 bg-white border border-border text-foreground rounded hover:bg-muted transition-colors">Próximo</a>
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