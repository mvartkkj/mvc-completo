<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Pedido #{{ $pedido->cod_pedido }} | Sabor & Cia</title>
    
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #0a0a0a;
            margin-bottom: 8px;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
        }

        .btn-primary {
            background: #ea580c;
            color: white;
            border: none;
            padding: 10px 20px;
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
            background: #0a0a0a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-secondary:hover {
            background: #3a3a3a;
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

        .item-card {
            background: #fafafa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e5e5;
        }

        .item-info {
            flex: 1;
        }

        .item-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .btn-remove:hover {
            background: #dc2626;
        }

        .quantity-input {
            width: 80px;
            padding: 8px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            text-align: center;
        }

        .add-item-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            border: 2px dashed #e5e5e5;
        }

        .prato-select {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .prato-option {
            background: white;
            border: 2px solid #e5e5e5;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .prato-option:hover {
            border-color: #ea580c;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .prato-option.selected {
            border-color: #ea580c;
            background: #fff7ed;
        }

        .prato-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .summary-box {
            background: #fff7ed;
            border: 1px solid #ea580c;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .summary-total {
            font-size: 20px;
            font-weight: 700;
            color: #ea580c;
            border-top: 2px solid #ea580c;
            padding-top: 12px;
            margin-top: 12px;
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
                <h1 class="text-xl font-semibold text-foreground">Editar Pedido #{{ $pedido->cod_pedido }}</h1>
                <p class="text-sm text-muted-foreground">Modifique os itens e informações do pedido</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        </div>

        <div style="padding: 24px; max-width: 1200px; margin: 0 auto;">
            <!-- Voltar -->
            <div style="margin-bottom: 20px;">
                <a href="{{ route('admin.pedidos.show', $pedido->cod_pedido) }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; color: #737373; text-decoration: none; font-size: 14px; transition: color 0.2s;"
                   onmouseover="this.style.color='#0a0a0a'" 
                   onmouseout="this.style.color='#737373'">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Voltar
                </a>
            </div>

            @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="list-style: disc; margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.pedidos.update', $pedido->cod_pedido) }}" id="editForm">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                    <!-- Coluna Esquerda -->
                    <div>
                        <!-- Informações Básicas -->
                        <div class="content-card">
                            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Informações do Pedido</h2>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="form-group">
                                    <label class="form-label">Tipo de Pedido *</label>
                                    <select name="tipo_pedido" class="form-select" required>
                                        <option value="mesa" {{ $pedido->tipo_pedido == 1 ? 'selected' : '' }}>🍽️ Mesa</option>
                                        <option value="balcao" {{ $pedido->tipo_pedido == 2 ? 'selected' : '' }}>🪑 Balcão</option>
                                        <option value="delivery" {{ $pedido->tipo_pedido == 3 ? 'selected' : '' }}>🚚 Delivery</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Mesa/Local</label>
                                    <input type="text" name="cod_mesa" class="form-input" value="{{ old('cod_mesa', $pedido->cod_mesa) }}" placeholder="Ex: Mesa 5">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Método de Pagamento *</label>
                                <select name="forma_pagamento" class="form-select" required>
                                    <option value="dinheiro" {{ $pedido->forma_pagamento == 1 ? 'selected' : '' }}>Dinheiro</option>
                                    <option value="credito" {{ $pedido->forma_pagamento == 2 ? 'selected' : '' }}>Cartão de Crédito</option>
                                    <option value="debito" {{ $pedido->forma_pagamento == 3 ? 'selected' : '' }}>Cartão de Débito</option>
                                    <option value="pix" {{ $pedido->forma_pagamento == 4 ? 'selected' : '' }}>PIX</option>
                                </select>
                            </div>
                        </div>

                        <!-- Itens do Pedido -->
                        <div class="content-card">
                            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Itens do Pedido</h2>
                            
                            <div id="itens-container">
                                @foreach($pedido->itens as $index => $item)
                                <div class="item-card" data-item-index="{{ $index }}">
                                    <img src="{{ $item->prato->foto_url }}" alt="{{ $item->prato->descricao }}" class="item-image">
                                    <div class="item-info">
                                        <div style="font-weight: 600; margin-bottom: 4px;">{{ $item->prato->descricao }}</div>
                                        <div style="font-size: 12px; color: #737373;">{{ $item->prato->categoria->descricao ?? '' }}</div>
                                        <div style="font-size: 14px; color: #ea580c; font-weight: 600; margin-top: 4px;">
                                            R$ {{ number_format($item->prato->valor_unitario, 2, ',', '.') }} / unidade
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <input type="hidden" name="itens[{{ $index }}][cod_prato]" value="{{ $item->cod_prato }}">
                                        <input type="number" 
                                               name="itens[{{ $index }}][quantidade]" 
                                               class="quantity-input" 
                                               value="{{ $item->quantidade }}" 
                                               min="1" 
                                               required
                                               onchange="calcularTotal()">
                                        <button type="button" class="btn-remove" onclick="removerItem(this)">
                                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Adicionar Novo Item -->
                            <div class="add-item-section" style="margin-top: 20px;">
                                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">Adicionar Novo Item</h3>
                                <div class="prato-select">
                                    @foreach($pratos as $prato)
                                    <div class="prato-option" onclick="adicionarItem({{ $prato->cod_prato }}, '{{ $prato->descricao }}', '{{ $prato->foto_url }}', '{{ $prato->categoria->descricao ?? '' }}', {{ $prato->valor_unitario }})">
                                        <img src="{{ $prato->foto_url }}" alt="{{ $prato->descricao }}" class="prato-img">
                                        <div style="font-size: 13px; font-weight: 600; margin-bottom: 4px;">{{ $prato->descricao }}</div>
                                        <div style="font-size: 11px; color: #737373; margin-bottom: 4px;">{{ $prato->categoria->descricao ?? '' }}</div>
                                        <div style="font-size: 14px; color: #ea580c; font-weight: 600;">R$ {{ number_format($prato->valor_unitario, 2, ',', '.') }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Direita - Resumo -->
                    <div>
                        <div class="content-card" style="position: sticky; top: 20px;">
                            <h2 style="font-size: 18px; font-weight: 600; margin-bottom: 20px;">Valores Adicionais</h2>
                            
                            <div class="form-group">
                                <label class="form-label">Taxa de Serviço (10%)</label>
                                <input type="number" name="taxa_servico" class="form-input" value="{{ old('taxa_servico', $pedido->taxa_servico) }}" step="0.01" min="0" placeholder="0.00" onchange="calcularTotal()">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Taxa de Entrega</label>
                                <input type="number" name="valor_entrega" class="form-input" value="{{ old('valor_entrega', $pedido->valor_entrega) }}" step="0.01" min="0" placeholder="0.00" onchange="calcularTotal()">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Desconto</label>
                                <input type="number" name="desconto" class="form-input" value="{{ old('desconto', $pedido->desconto) }}" step="0.01" min="0" placeholder="0.00" onchange="calcularTotal()">
                            </div>

                            <div class="summary-box">
                                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 12px;">Resumo do Pedido</h3>
                                <div class="summary-row">
                                    <span>Subtotal:</span>
                                    <span id="subtotal-display">R$ 0,00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Taxa de Serviço:</span>
                                    <span id="taxa-servico-display">R$ 0,00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Taxa de Entrega:</span>
                                    <span id="taxa-entrega-display">R$ 0,00</span>
                                </div>
                                <div class="summary-row">
                                    <span>Desconto:</span>
                                    <span id="desconto-display" style="color: #22c55e;">- R$ 0,00</span>
                                </div>
                                <div class="summary-row summary-total">
                                    <span>TOTAL:</span>
                                    <span id="total-display">R$ 0,00</span>
                                </div>
                            </div>

                            <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
                                <button type="submit" class="btn-primary" style="width: 100%;">
                                    💾 Salvar Alterações
                                </button>
                                <a href="{{ route('admin.pedidos.show', $pedido->cod_pedido) }}" class="btn-secondary" style="width: 100%; text-align: center; text-decoration: none; display: block;">
                                    ❌ Cancelar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let itemIndex = {{ count($pedido->itens) }};
        const pratosData = @json($pratos->keyBy('cod_prato'));

        function adicionarItem(codPrato, descricao, foto, categoria, valorUnitario) {
            const container = document.getElementById('itens-container');
            const itemHtml = `
                <div class="item-card" data-item-index="${itemIndex}">
                    <img src="${foto}" alt="${descricao}" class="item-image">
                    <div class="item-info">
                        <div style="font-weight: 600; margin-bottom: 4px;">${descricao}</div>
                        <div style="font-size: 12px; color: #737373;">${categoria}</div>
                        <div style="font-size: 14px; color: #ea580c; font-weight: 600; margin-top: 4px;">
                            R$ ${valorUnitario.toFixed(2).replace('.', ',')} / unidade
                        </div>
                    </div>
                    <div class="item-actions">
                        <input type="hidden" name="itens[${itemIndex}][cod_prato]" value="${codPrato}">
                        <input type="number" 
                               name="itens[${itemIndex}][quantidade]" 
                               class="quantity-input" 
                               value="1" 
                               min="1" 
                               required
                               onchange="calcularTotal()">
                        <button type="button" class="btn-remove" onclick="removerItem(this)">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
            itemIndex++;
            calcularTotal();
        }

        function removerItem(button) {
            if (document.querySelectorAll('.item-card').length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    text: 'O pedido deve ter pelo menos um item!',
                    confirmButtonColor: '#ea580c',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            Swal.fire({
                title: 'Remover item?',
                text: 'Deseja realmente remover este item do pedido?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#0a0a0a',
                confirmButtonText: 'Sim, remover',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('.item-card').remove();
                    calcularTotal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Removido!',
                        text: 'Item removido com sucesso',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }

        function calcularTotal() {
            let subtotal = 0;
            
            document.querySelectorAll('.item-card').forEach(card => {
                const codPrato = card.querySelector('input[name*="[cod_prato]"]').value;
                const quantidade = parseInt(card.querySelector('input[name*="[quantidade]"]').value) || 0;
                const prato = pratosData[codPrato];
                if (prato) {
                    subtotal += prato.valor_unitario * quantidade;
                }
            });

            const taxaServico = parseFloat(document.querySelector('input[name="taxa_servico"]').value) || 0;
            const valorEntrega = parseFloat(document.querySelector('input[name="valor_entrega"]').value) || 0;
            const desconto = parseFloat(document.querySelector('input[name="desconto"]').value) || 0;
            
            const total = subtotal + taxaServico + valorEntrega - desconto;

            document.getElementById('subtotal-display').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            document.getElementById('taxa-servico-display').textContent = `R$ ${taxaServico.toFixed(2).replace('.', ',')}`;
            document.getElementById('taxa-entrega-display').textContent = `R$ ${valorEntrega.toFixed(2).replace('.', ',')}`;
            document.getElementById('desconto-display').textContent = `- R$ ${desconto.toFixed(2).replace('.', ',')}`;
            document.getElementById('total-display').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }

        // Calcular total ao carregar a página
        document.addEventListener('DOMContentLoaded', calcularTotal);
    </script>
</body>
</html>