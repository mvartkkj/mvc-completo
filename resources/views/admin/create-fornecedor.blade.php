<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastrar Fornecedor - Sabor & Cia</title>

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
            position: relative;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #0a0a0a;
        }

        .form-label.required::after {
            content: ' *';
            color: #ef4444;
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

        .form-input.error, .form-select.error {
            border-color: #ef4444;
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

        .cidade-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 4px;
            display: none;
        }

        .cidade-results.show {
            display: block;
        }

        .cidade-item {
            padding: 10px 12px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
            border-bottom: 1px solid #f5f5f5;
        }

        .cidade-item:last-child {
            border-bottom: none;
        }

        .cidade-item:hover {
            background: #f5f5f5;
        }

        .cidade-item.selected {
            background: #fff7ed;
            color: #ea580c;
        }

        .cidade-item.no-results {
            color: #737373;
            cursor: default;
        }

        .cidade-item.no-results:hover {
            background: white;
        }

        .loading-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid #e5e5e5;
            border-top-color: #ea580c;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
                <a href="{{ route('admin.fornecedores') }}" class="menu-item active">
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
                <h1 class="text-xl font-semibold text-foreground">Cadastrar Fornecedor</h1>
                <p class="text-sm text-muted-foreground">Adicione um novo fornecedor ao sistema</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <div class="content-card">
            <h2>Novo Fornecedor</h2>
            <p>Preencha os campos abaixo para cadastrar um novo fornecedor. Os campos marcados com * são obrigatórios.</p>

            @if($errors->any())
            <div style="background: #fee; border: 1px solid #fcc; color: #c33; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.fornecedores.store') }}">
                @csrf

                <div class="form-grid">
                    <!-- Nome Social -->
                    <div class="form-group full-width">
                        <label class="form-label required" for="nome_social">Nome Social / Razão Social</label>
                        <input 
                            type="text" 
                            id="nome_social" 
                            name="nome_social" 
                            class="form-input @error('nome_social') error @enderror" 
                            value="{{ old('nome_social') }}" 
                            required
                        />
                        @error('nome_social')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nome Fantasia -->
                    <div class="form-group full-width">
                        <label class="form-label" for="nome_fantasia">Nome Fantasia</label>
                        <input 
                            type="text" 
                            id="nome_fantasia" 
                            name="nome_fantasia" 
                            class="form-input @error('nome_fantasia') error @enderror" 
                            value="{{ old('nome_fantasia') }}"
                        />
                        @error('nome_fantasia')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- CNPJ -->
                    <div class="form-group">
                        <label class="form-label" for="cnpj">CNPJ</label>
                        <input 
                            type="text" 
                            id="cnpj" 
                            name="cnpj" 
                            class="form-input @error('cnpj') error @enderror" 
                            value="{{ old('cnpj') }}"
                            placeholder="12345678000190"
                            maxlength="14"
                            pattern="[0-9]*"
                            inputmode="numeric"
                        />
                        <span class="form-hint">Apenas números (14 dígitos)</span>
                        @error('cnpj')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Celular -->
                    <div class="form-group">
                        <label class="form-label" for="celular">Celular / Telefone</label>
                        <input 
                            type="text" 
                            id="celular" 
                            name="celular" 
                            class="form-input @error('celular') error @enderror" 
                            value="{{ old('celular') }}"
                            placeholder="11987654321"
                            maxlength="11"
                            pattern="[0-9]*"
                            inputmode="numeric"
                        />
                        <span class="form-hint">Apenas números (10 ou 11 dígitos)</span>
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
                            class="form-input @error('e_mail') error @enderror" 
                            value="{{ old('e_mail') }}"
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
                            class="form-input @error('endereco') error @enderror" 
                            value="{{ old('endereco') }}"
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
                            class="form-input @error('numero') error @enderror" 
                            value="{{ old('numero') }}"
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
                            class="form-input @error('bairro') error @enderror" 
                            value="{{ old('bairro') }}"
                        />
                        @error('bairro')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cidade com Autocomplete -->
                    <div class="form-group">
                        <label class="form-label" for="cidade_search">Cidade</label>
                        <input 
                            type="text" 
                            id="cidade_search" 
                            class="form-input @error('cod_cidade') error @enderror" 
                            placeholder="Digite para buscar..."
                            value="{{ old('cidade_search') }}"
                            autocomplete="off"
                        />
                        <input 
                            type="hidden" 
                            id="cod_cidade" 
                            name="cod_cidade" 
                            value="{{ old('cod_cidade') }}"
                        />
                        <div id="cidade_results" class="cidade-results"></div>
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
                            class="form-input @error('cep') error @enderror" 
                            value="{{ old('cep') }}"
                            placeholder="12345678"
                            maxlength="8"
                            pattern="[0-9]*"
                            inputmode="numeric"
                        />
                        <span class="form-hint">Apenas números (8 dígitos)</span>
                        @error('cep')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.fornecedores') }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">Cadastrar Fornecedor</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Remove caracteres não numéricos em campos numéricos
        document.getElementById('cnpj').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        document.getElementById('celular').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        document.getElementById('cep').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        // Autocomplete de cidades
        const cidadeSearch = document.getElementById('cidade_search');
        const cidadeResults = document.getElementById('cidade_results');
        const codCidadeInput = document.getElementById('cod_cidade');
        let searchTimeout;
        let isLoading = false;

        cidadeSearch.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                cidadeResults.classList.remove('show');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                if (isLoading) return;
                
                isLoading = true;
                cidadeResults.innerHTML = '<div class="cidade-item no-results"><span class="loading-spinner"></span>Buscando...</div>';
                cidadeResults.classList.add('show');
                
                fetch(`{{ route('admin.buscar.cidades') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    isLoading = false;
                    
                    if (data.length === 0) {
                        cidadeResults.innerHTML = '<div class="cidade-item no-results">Nenhuma cidade encontrada</div>';
                    } else {
                        cidadeResults.innerHTML = data.map(cidade => 
                            `<div class="cidade-item" data-id="${cidade.cod_cidade}" data-nome="${cidade.nome} - ${cidade.uf}">
                                ${cidade.nome} - ${cidade.uf}
                            </div>`
                        ).join('');
                        
                        document.querySelectorAll('.cidade-item[data-id]').forEach(item => {
                            item.addEventListener('click', function() {
                                cidadeSearch.value = this.getAttribute('data-nome');
                                codCidadeInput.value = this.getAttribute('data-id');
                                cidadeResults.classList.remove('show');
                            });
                        });
                    }
                })
                .catch(err => {
                    isLoading = false;
                    console.error('Erro ao buscar cidades:', err);
                    cidadeResults.innerHTML = '<div class="cidade-item no-results">Erro ao buscar cidades</div>';
                });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!cidadeSearch.contains(e.target) && !cidadeResults.contains(e.target)) {
                cidadeResults.classList.remove('show');
            }
        });

        cidadeSearch.addEventListener('blur', function() {
            setTimeout(() => {
                if (this.value.trim() === '') {
                    codCidadeInput.value = '';
                }
            }, 200);
        });

        cidadeSearch.addEventListener('keydown', function(e) {
            const items = cidadeResults.querySelectorAll('.cidade-item[data-id]');
            if (items.length === 0) return;
            
            const selected = cidadeResults.querySelector('.cidade-item.selected');
            let index = Array.from(items).indexOf(selected);
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (selected) selected.classList.remove('selected');
                index = (index + 1) % items.length;
                items[index].classList.add('selected');
                items[index].scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (selected) selected.classList.remove('selected');
                index = (index - 1 + items.length) % items.length;
                items[index].classList.add('selected');
                items[index].scrollIntoView({ block: 'nearest' });
            } else if (e.key === 'Enter' && selected) {
                e.preventDefault();
                selected.click();
            }
        });
    </script>
</body>
</html>