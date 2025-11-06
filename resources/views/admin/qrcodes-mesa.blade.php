<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Codes das Mesas | Sabor & Cia</title>
    
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            
            .qr-card {
                page-break-after: always;
                page-break-inside: avoid;
                border: 2px dashed #e5e5e5 !important;
            }
            
            body {
                background: white !important;
            }
        }
        
        body {
            font-family: 'Figtree', sans-serif;
        }
        
        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 24px;
            padding: 24px;
        }
        
        .qr-card {
            background: white;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .qr-card h3 {
            font-size: 28px;
            font-weight: 700;
            color: #ea580c;
            margin-bottom: 8px;
        }
        
        .qr-card .subtitle {
            font-size: 14px;
            color: #737373;
            margin-bottom: 24px;
        }
        
        .qr-wrapper {
            background: white;
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 0 auto 20px;
            border: 1px solid #e5e5e5;
        }
        
        .qr-card svg {
            width: 220px;
            height: 220px;
            display: block;
            margin: 0 auto;
        }
        
        .qr-card .instructions {
            background: #f5f5f5;
            padding: 16px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .qr-card .instructions p {
            font-size: 13px;
            color: #0a0a0a;
            margin: 4px 0;
        }
        
        .header {
            background: white;
            padding: 24px;
            border-bottom: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .btn-primary {
            background: #ea580c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background: #dc2626;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #e5e5e5;
            color: #0a0a0a;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-outline:hover {
            background: #f5f5f5;
        }
        
        .url-display {
            background: #f5f5f5;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 11px;
            color: #737373;
            word-break: break-all;
            margin-top: 12px;
            font-family: monospace;
        }
    </style>
</head>
<body style="background: #fafafa;">
    <div class="header no-print">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #0a0a0a; margin-bottom: 4px;">🪑 QR Codes das Mesas</h1>
            <p style="font-size: 14px; color: #737373;">Escaneie com a câmera do celular para fazer pedidos</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <button onclick="window.print()" class="btn-primary">
                🖨️ Imprimir Todos
            </button>
            <a href="{{ route('admin.mesas.index') }}" class="btn-outline">
                ← Voltar
            </a>
        </div>
    </div>

    <div class="qr-grid">
        @foreach($mesas as $mesa)
        @php
            $url = route('scan') . '?mesa=' . urlencode($mesa->descricao);
        @endphp
        <div class="qr-card">
            <h3>🪑 {{ $mesa->descricao }}</h3>
            <p class="subtitle">Mesa #{{ $mesa->cod_mesa }}</p>
            
            <div class="qr-wrapper">
                <!-- QR Code gerado com SimpleSoftwareIO -->
                {!! QrCode::size(220)
                    ->margin(1)
                    ->merge('images/logo.png', 0.3, true)
                    ->generate($url) 
                !!}
            </div>
            
            <div class="instructions">
                <p><strong>📱 Como fazer seu pedido:</strong></p>
                <p>1. Abra a câmera do celular</p>
                <p>2. Aponte para este QR Code</p>
                <p>3. Toque na notificação que aparecer</p>
                <p>4. Escolha seus pratos favoritos!</p>
            </div>
            
            <div class="url-display no-print">
                🔗 {{ $url }}
            </div>
        </div>
        @endforeach
    </div>

    @if($mesas->isEmpty())
    <div style="text-align: center; padding: 80px 20px;">
        <svg style="width: 80px; height: 80px; margin: 0 auto 24px; opacity: 0.3;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
        </svg>
        <p style="font-size: 18px; color: #737373; margin-bottom: 8px;">Nenhuma mesa cadastrada ainda</p>
        <p style="font-size: 14px; color: #a3a3a3; margin-bottom: 24px;">Crie mesas para gerar os QR Codes</p>
        <a href="{{ route('admin.mesas.create') }}" class="btn-primary">
            + Criar Primeira Mesa
        </a>
    </div>
    @endif

    <script>
        document.querySelectorAll('.url-display').forEach(el => {
            el.style.cursor = 'pointer';
            el.title = 'Clique para copiar';
            el.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent.trim().replace('🔗 ', ''));
                const original = this.textContent;
                this.textContent = '✓ URL copiada!';
                setTimeout(() => {
                    this.textContent = original;
                }, 2000);
            });
        });
    </script>
</body>
</html>