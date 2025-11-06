<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Cliente | Sabor & Cia</title>

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
                <h1 class="text-xl font-semibold text-foreground">Editar Cliente</h1>
                <p class="text-sm text-muted-foreground">Atualize as informações do cliente</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <div class="content-card">
            <h2>Dados do Cliente #{{ $cliente->cod_cliente }}</h2>
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

            <form method="POST" action="{{ route('admin.clientes.update', $cliente->cod_cliente) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Nome -->
                    <div class="form-group full-width">
                        <label class="form-label" for="nome">Nome Completo *</label>
                        <input 
                            type="text" 
                            id="nome" 
                            name="nome" 
                            class="form-input" 
                            value="{{ old('nome', $cliente->nome) }}" 
                            required
                        />
                        @error('nome')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div class="form-group">
                        <label class="form-label" for="cpf">CPF</label>
                        <input 
                            type="text" 
                            id="cpf" 
                            name="cpf" 
                            class="form-input" 
                            value="{{ old('cpf', $cliente->cpf) }}"
                            placeholder="000.000.000-00"
                        />
                        @error('cpf')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- RG -->
                    <div class="form-group">
                        <label class="form-label" for="rg">RG</label>
                        <input 
                            type="text" 
                            id="rg" 
                            name="rg" 
                            class="form-input" 
                            value="{{ old('rg', $cliente->rg) }}"
                        />
                        @error('rg')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="form-group">
                        <label class="form-label" for="data_nasc">Data de Nascimento</label>
                        <input 
                            type="date" 
                            id="data_nasc" 
                            name="data_nasc" 
                            class="form-input" 
                            value="{{ old('data_nasc', $cliente->data_nasc) }}"
                        />
                        @error('data_nasc')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Celular -->
                    <div class="form-group">
                        <label class="form-label" for="celular">Celular</label>
                        <input 
                            type="text" 
                            id="celular" 
                            name="celular" 
                            class="form-input" 
                            value="{{ old('celular', $cliente->celular) }}"
                            placeholder="(00) 00000-0000"
                        />
                        @error('celular')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group full-width">
                        <label class="form-label" for="e_mail">E-mail</label>
                        <input 
                            type="email" 
                            id="e_mail" 
                            name="e_mail" 
                            class="form-input" 
                            value="{{ old('e_mail', $cliente->e_mail) }}"
                        />
                        @error('e_mail')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Endereço -->
                    <div class="form-group">
                        <label class="form-label" for="endereco">Endereço</label>
                        <input 
                            type="text" 
                            id="endereco" 
                            name="endereco" 
                            class="form-input" 
                            value="{{ old('endereco', $cliente->endereco) }}"
                        />
                        @error('endereco')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Número -->
                    <div class="form-group">
                        <label class="form-label" for="numero">Número</label>
                        <input 
                            type="text" 
                            id="numero" 
                            name="numero" 
                            class="form-input" 
                            value="{{ old('numero', $cliente->numero) }}"
                        />
                        @error('numero')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bairro -->
                    <div class="form-group">
                        <label class="form-label" for="bairro">Bairro</label>
                        <input 
                            type="text" 
                            id="bairro" 
                            name="bairro" 
                            class="form-input" 
                            value="{{ old('bairro', $cliente->bairro) }}"
                        />
                        @error('bairro')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cidade -->
                    <div class="form-group">
                        <label class="form-label" for="cod_cidade">Cidade</label>
                        <select 
                            id="cod_cidade" 
                            name="cod_cidade" 
                            class="form-select"
                        >
                            <option value="">Selecione...</option>
                            @foreach($cidades as $cidade)
                                <option value="{{ $cidade->cod_cidade }}" 
                                    {{ old('cod_cidade', $cliente->cod_cidade) == $cidade->cod_cidade ? 'selected' : '' }}>
                                    {{ $cidade->nome }} - {{ $cidade->uf }}
                                </option>
                            @endforeach
                        </select>
                        @error('cod_cidade')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- CEP -->
                    <div class="form-group">
                        <label class="form-label" for="cep">CEP</label>
                        <input 
                            type="text" 
                            id="cep" 
                            name="cep" 
                            class="form-input" 
                            value="{{ old('cep', $cliente->cep) }}"
                            placeholder="00000-000"
                        />
                        @error('cep')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cargo -->
                    <div class="form-group">
                        <label class="form-label" for="cargo_id">Cargo</label>
                        <select 
                            id="cargo_id" 
                            name="cargo_id" 
                            class="form-select"
                        >
                            <option value="">Selecione...</option>
                            @foreach($cargos as $cargo)
                                <option value="{{ $cargo->id }}" 
                                    {{ old('cargo_id', $cliente->cargo_id) == $cargo->id ? 'selected' : '' }}>
                                    {{ $cargo->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('cargo_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Senha -->
                    <div class="form-group full-width">
                        <label class="form-label" for="passwd">Nova Senha (deixe em branco para manter a atual)</label>
                        <input 
                            type="password" 
                            id="passwd" 
                            name="passwd" 
                            class="form-input" 
                            placeholder="Digite uma nova senha (mínimo 6 caracteres)"
                        />
                        @error('passwd')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.clientes') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>