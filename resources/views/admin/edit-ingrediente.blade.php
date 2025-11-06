<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Ingrediente - Sabor & Cia</title>

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
            max-width: 1200px;
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
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #0a0a0a;
        }

        .form-input, .form-select {
            height: 40px;
            padding: 0 12px;
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            font-size: 14px;
            color: #0a0a0a;
            transition: all 0.2s ease;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }

        .form-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 4px;
        }

        .form-hint {
            font-size: 11px;
            color: #737373;
            margin-top: 2px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
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

        .btn-primary {
            background: #ea580c;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-primary:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #0a0a0a;
            border: 1px solid #e5e5e5;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #e5e5e5;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e5e5;
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
                <h1 class="text-xl font-semibold text-foreground">Editar Ingrediente</h1>
                <p class="text-sm text-muted-foreground">Atualize as informações do ingrediente</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <div class="content-card">
            <h2>Dados do Ingrediente #{{ str_pad($ingrediente->cod_ingrediente, 3, '0', STR_PAD_LEFT) }}</h2>
            <p>Preencha os campos abaixo para atualizar as informações</p>

            @if($errors->any())
            <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.ingredientes.update', $ingrediente->cod_ingrediente) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Descrição -->
                    <div class="form-group full-width">
                        <label class="form-label" for="descricao">Nome do Ingrediente *</label>
                        <input 
                            type="text" 
                            id="descricao" 
                            name="descricao" 
                            class="form-input" 
                            value="{{ old('descricao', $ingrediente->descricao) }}" 
                            required
                            maxlength="100"
                        />
                        @error('descricao')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Unidade -->
                    <div class="form-group">
                        <label class="form-label" for="cod_unidade">Unidade de Medida *</label>
                        <select 
                            id="cod_unidade" 
                            name="cod_unidade" 
                            class="form-select"
                            required
                        >
                            <option value="">Selecione...</option>
                            @foreach($unidades as $unidade)
                                <option value="{{ $unidade->cod_unidade }}" 
                                    {{ old('cod_unidade', $ingrediente->cod_unidade) == $unidade->cod_unidade ? 'selected' : '' }}>
                                    {{ $unidade->descricao }} ({{ $unidade->sigla }})
                                </option>
                            @endforeach
                        </select>
                        @error('cod_unidade')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Valor Unitário -->
                    <div class="form-group">
                        <label class="form-label" for="valor_unitario">Valor Unitário (R$)</label>
                        <input 
                            type="number" 
                            id="valor_unitario" 
                            name="valor_unitario" 
                            class="form-input" 
                            value="{{ old('valor_unitario', number_format($ingrediente->valor_unitario ?? 0, 2, '.', '')) }}"
                            step="0.01"
                            min="0"
                        />
                        <span class="form-hint">Valor por unidade de medida</span>
                        @error('valor_unitario')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Controla Estoque -->
                    <div class="form-group">
                        <label class="form-label" for="controla_estoque">Controle de Estoque</label>
                        <div class="checkbox-group">
                            <input 
                                type="checkbox" 
                                id="controla_estoque" 
                                name="controla_estoque" 
                                class="checkbox-input"
                                value="1"
                                {{ old('controla_estoque', $ingrediente->controla_estoque) ? 'checked' : '' }}
                            />
                            <label for="controla_estoque" style="cursor: pointer;">Ativar controle de estoque</label>
                        </div>
                        <span class="form-hint">Marque para controlar a quantidade em estoque</span>
                    </div>

                    <!-- Quantidade Estoque -->
                    <div class="form-group">
                        <label class="form-label" for="quantidade_estoque">Quantidade em Estoque</label>
                        <input 
                            type="number" 
                            id="quantidade_estoque" 
                            name="quantidade_estoque" 
                            class="form-input" 
                            value="{{ old('quantidade_estoque', $ingrediente->quantidade_estoque ?? 0) }}"
                            step="0.1"
                            min="0"
                        />
                        <span class="form-hint">Quantidade atual disponível</span>
                        @error('quantidade_estoque')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.ingredientes') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>