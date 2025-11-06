<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gerenciar Mesas | Sabor & Cia</title>

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

        .btn-primary {
            background: #ea580c;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #dc2626;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            transition: background 0.2s;
            margin-right: 4px;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            margin-right: 4px;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .btn-activate {
            background: #22c55e;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-activate:hover {
            background: #16a34a;
        }

        .badge-status {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-active {
            background: #f0fdf4;
            color: #22c55e;
        }

        .badge-busy {
            background: #fef3c7;
            color: #f59e0b;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #ef4444;
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
                <a href="{{ route('admin.mesas.index') }}" class="menu-item active">
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
                <h1 class="text-xl font-semibold text-foreground">Gerenciar Mesas</h1>
                <p class="text-sm text-muted-foreground">Controle todas as mesas do restaurante</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="background: #ea580c; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; transition: background 0.2s ease;">
                    Sair
                </button>
            </form>
        </div>

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

        @if(session('error'))
        <div style="margin: 24px 24px 0 24px;">
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <div class="content-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 20px; font-weight: 600; color: #0a0a0a; margin-bottom: 4px;">Lista de Mesas</h2>
                    <p style="font-size: 14px; color: #737373;">Total de {{ $mesas->count() }} mesa(s) cadastrada(s)</p>
                </div>
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('admin.mesas.qrcodes') }}" class="btn-primary" style="background: #0a0a0a;">
                        📱 Ver QR Codes
                    </a>
                    <a href="{{ route('admin.mesas.create') }}" class="btn-primary">
                        + Nova Mesa
                    </a>
                </div>
            </div>

            @if($mesas->isEmpty())
            <div style="text-align: center; padding: 40px 0; color: #737373;">
                <svg style="width: 64px; height: 64px; margin: 0 auto 16px; opacity: 0.5;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <p style="font-size: 16px; margin-bottom: 8px;">Nenhuma mesa cadastrada</p>
                <p style="font-size: 14px;">Clique em "Nova Mesa" para adicionar</p>
            </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Mesa</th>
                        <th>Status</th>
                        <th>Pedidos Ativos</th>
                        <th>Total em Aberto</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesas as $mesa)
                    <tr>
                        <td style="font-weight: 600;">#{{ $mesa->cod_mesa }}</td>
                        <td style="font-weight: 500;">🪑 {{ $mesa->descricao }}</td>
                        <td>
                            @if(!$mesa->ativo)
                                <span class="badge-status badge-inactive">Inativa</span>
                            @elseif($mesa->temPedidosAtivos())
                                <span class="badge-status badge-busy">Ocupada</span>
                            @else
                                <span class="badge-status badge-active">Disponível</span>
                            @endif
                        </td>
                        <td>
                            @if($mesa->ativo && $mesa->temPedidosAtivos())
                                <span style="color: #f59e0b; font-weight: 500;">{{ $mesa->pedidosAtivos()->count() }} pedido(s)</span>
                            @else
                                <span style="color: #22c55e;">-</span>
                            @endif
                        </td>
                        <td style="font-weight: 600; color: #ea580c;">
                            @if($mesa->ativo && $mesa->totalPedidosAtivos() > 0)
                                R$ {{ number_format($mesa->totalPedidosAtivos(), 2, ',', '.') }}
                            @else
                                <span style="color: #737373;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('admin.mesas.edit', $mesa->cod_mesa) }}" 
                                style="background: #0a0a0a; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; transition: all 0.2s;"
                                onmouseover="this.style.background='#3a3939ff'" 
                                onmouseout="this.style.background='#0a0a0a'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                            </a>
                            
                            @if($mesa->ativo)
                                <form action="{{ route('admin.mesas.destroy', $mesa->cod_mesa) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="confirmarInativar(this, '{{ $mesa->descricao }}')"
                                        style="background: #dc2626; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                        onmouseover="this.style.background='#b91c1c'" 
                                        onmouseout="this.style.background='#dc2626'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inativar
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.mesas.ativar', $mesa->cod_mesa) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('POST')
                                    <button type="button" 
                                        onclick="confirmarAtivar(this, '{{ $mesa->descricao }}')"
                                        style="background: #16a34a; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; transition: all 0.2s;"
                                        onmouseover="this.style.background='#15803d'" 
                                        onmouseout="this.style.background='#16a34a'">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Ativar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmarInativar(button, nomeMesa) {
            Swal.fire({
                title: 'Inativar mesa?',
                html: `Tem certeza que deseja inativar a mesa <strong>${nomeMesa}</strong>?<br><span style="color: #dc2626; font-size: 14px;">Ela não poderá ser usada até ser reativada!</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#0a0a0a',
                confirmButtonText: 'Sim, inativar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Inativando...',
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

        function confirmarAtivar(button, nomeMesa) {
            Swal.fire({
                title: 'Ativar mesa?',
                html: `Deseja ativar a mesa <strong>${nomeMesa}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#0a0a0a',
                confirmButtonText: 'Sim, ativar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Ativando...',
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