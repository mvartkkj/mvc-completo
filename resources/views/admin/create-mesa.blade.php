<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nova Mesa | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: #fafafa;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            padding: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #0a0a0a;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #ea580c;
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
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
            width: 100%;
        }

        .btn-primary:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: transparent;
            color: #737373;
            padding: 12px 24px;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            margin-top: 12px;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            color: #0a0a0a;
        }

        .error-message {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .header {
            margin-bottom: 32px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0a0a0a;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 14px;
            color: #737373;
        }

        .help-text {
            font-size: 13px;
            color: #737373;
            margin-top: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>🪑 Nova Mesa</h1>
                <p>Adicione uma nova mesa ao sistema</p>
            </div>

            @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.mesas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="descricao">Nome/Identificação da Mesa *</label>
                    <input 
                        type="text" 
                        id="descricao" 
                        name="descricao" 
                        value="{{ old('descricao') }}" 
                        placeholder="Ex: Mesa 01, Mesa VIP, Mesa Varanda..."
                        required
                        autofocus
                    />
                    <p class="help-text">💡 Este nome será usado no QR Code e identificação dos pedidos</p>
                </div>

                <button type="submit" class="btn-primary">
                    ✓ Criar Mesa
                </button>

                <a href="{{ route('admin.mesas.index') }}" style="text-decoration: none;">
                    <button type="button" class="btn-secondary">
                        ← Voltar
                    </button>
                </a>
            </form>
        </div>
    </div>
</body>
</html>