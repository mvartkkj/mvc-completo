<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Sabor & Cia</title>

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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.2s;
        }

        .stat-card:hover {
            border-color: #ea580c;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .stat-title {
            font-size: 13px;
            color: #737373;
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.primary {
            background: #fff7ed;
            color: #ea580c;
        }

        .stat-icon.secondary {
            background: #eff6ff;
            color: #3b82f6;
        }

        .stat-icon.success {
            background: #f0fdf4;
            color: #22c55e;
        }

        .stat-icon.warning {
            background: #fef3c7;
            color: #f59e0b;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #0a0a0a;
            margin-bottom: 4px;
        }

        .stat-description {
            font-size: 12px;
            color: #737373;
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

        .info-box {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .info-box h3 {
            font-size: 14px;
            font-weight: 600;
            color: #0a0a0a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-box p {
            font-size: 13px;
            color: #737373;
            margin: 0;
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
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
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
                <h1 class="text-xl font-semibold text-foreground">Bem-vindo de volta! 👋</h1>
                <p class="text-sm text-muted-foreground">Aqui está o resumo do seu negócio</p>
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
            <!-- Estatísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total de Clientes</span>
                        <div class="stat-icon primary">👥</div>
                    </div>
                    <div class="stat-number">{{ number_format($stats['total_clientes'] ?? 0) }}</div>
                    <div class="stat-description">Clientes cadastrados</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Clientes Ativos</span>
                        <div class="stat-icon success">✓</div>
                    </div>
                    <div class="stat-number">{{ number_format($stats['clientes_ativos'] ?? 0) }}</div>
                    <div class="stat-description">Com e-mail cadastrado</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Cadastros no Mês</span>
                        <div class="stat-icon secondary">📅</div>
                    </div>
                    <div class="stat-number">{{ number_format($stats['cadastros_mes'] ?? 0) }}</div>
                    <div class="stat-description">Mês atual</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total de Cargos</span>
                        <div class="stat-icon warning">🏷️</div>
                    </div>
                    <div class="stat-number">{{ number_format($stats['total_cargos'] ?? 0) }}</div>
                    <div class="stat-description">Cargos cadastrados</div>
                </div>
            </div>

            <!-- Visão Geral -->
            <h2>Visão Geral do Sistema</h2>
            <p>
                Bem-vindo ao painel administrativo do Sabor & Cia! Aqui você pode gerenciar todos os aspectos do seu restaurante,
                desde clientes e pedidos até fornecedores e ingredientes. Use o menu lateral para navegar entre as diferentes
                seções do sistema.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; margin-top: 20px;">
                <div class="info-box">
                    <h3>📱 Pedidos em Tempo Real</h3>
                    <p>Acompanhe todos os pedidos que chegam no sistema em tempo real</p>
                </div>
                <div class="info-box">
                    <h3>📊 Relatórios Detalhados</h3>
                    <p>Análises completas de vendas e desempenho do restaurante</p>
                </div>
                <div class="info-box">
                    <h3>🔔 Notificações</h3>
                    <p>Alertas automáticos de estoque baixo e novos pedidos</p>
                </div>
            </div>
        </div>

        <!-- Últimos Clientes -->
        @if(isset($clientes) && $clientes->isNotEmpty())
        <div class="content-card">
            <h2>Últimos Clientes Cadastrados</h2>
            <p>Visualização rápida dos últimos clientes registrados no sistema</p>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Cidade</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td class="font-semibold">#{{ $cliente->cod_cliente }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->e_mail ?? '-' }}</td>
                            <td>{{ $cliente->celular ?? '-' }}</td>
                            <td>{{ $cliente->cod_cidade ?? '-' }}</td>
                            <td>
                                @if($cliente->cargo)
                                    <span style="padding: 4px 12px; background: #fff7ed; color: #ea580c; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                        {{ $cliente->cargo->nome }}
                                    </span>
                                @else
                                    <span style="color: #737373;">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px; text-align: center;">
                <a href="{{ route('admin.clientes') }}" 
                   style="display: inline-block; padding: 10px 20px; background: #ea580c; color: white; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.2s;"
                   onmouseover="this.style.background='#dc2626'" 
                   onmouseout="this.style.background='#ea580c'">
                    Ver Todos os Clientes →
                </a>
            </div>
        </div>
        @endif

        <!-- Últimos Pratos -->
        @if(isset($pratos) && $pratos->isNotEmpty())
        <div class="content-card">
            <h2>Últimos Pratos Cadastrados</h2>
            <p>Visualização rápida dos últimos pratos adicionados ao cardápio</p>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                            <th style="text-align: right;">Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pratos as $prato)
                        <tr>
                            <td class="font-semibold">#{{ $prato->cod_prato }}</td>
                            <td>
                                <img src="{{ $prato->foto_url }}" alt="{{ $prato->descricao }}" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e5e5;">
                            </td>
                            <td>{{ $prato->descricao }}</td>
                            <td>
                                @if($prato->categoria)
                                    <span style="padding: 4px 12px; background: #eff6ff; color: #3b82f6; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                        {{ $prato->categoria->descricao }}
                                    </span>
                                @else
                                    <span style="color: #737373;">-</span>
                                @endif
                            </td>
                            <td style="text-align: right;" class="font-semibold">R$ {{ number_format($prato->valor_unitario, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 16px; text-align: center;">
                <a href="{{ route('admin.pratos.index') }}" 
                   style="display: inline-block; padding: 10px 20px; background: #ea580c; color: white; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 500; transition: background 0.2s;"
                   onmouseover="this.style.background='#dc2626'" 
                   onmouseout="this.style.background='#ea580c'">
                    Ver Todos os Pratos →
                </a>
            </div>
        </div>
        @endif
    </div>
</body>
</html>