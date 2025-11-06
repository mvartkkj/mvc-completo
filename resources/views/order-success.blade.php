<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido Confirmado | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background">
    <div class="container mx-auto px-4 py-12 max-w-2xl">
        <div class="bg-card border border-border rounded-lg p-8 text-center">
            <!-- Ícone de Sucesso -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-foreground mb-3">Pedido Confirmado!</h1>
            <p class="text-lg text-muted-foreground mb-2">Seu pedido foi realizado com sucesso</p>
            <p class="text-sm text-muted-foreground mb-8">Número do pedido: <span class="font-bold text-primary">#{{ $orderId }}</span></p>

            <!-- Informações -->
            <div class="bg-muted/50 rounded-lg p-6 mb-8 space-y-3">
                <div class="flex items-center justify-center gap-2 text-muted-foreground">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">Tempo estimado: 30-40 minutos</span>
                </div>
                <div class="flex items-center justify-center gap-2 text-muted-foreground">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="text-sm">Você será notificado quando estiver pronto</span>
                </div>
            </div>

            <!-- Botões -->
            <div class="space-y-3">
                <a href="{{ route('menu') }}" class="block w-full bg-primary text-primary-foreground hover:bg-primary/90 h-12 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    Fazer Novo Pedido
                </a>
                <a href="/" class="block w-full bg-transparent border border-border hover:bg-muted text-foreground h-12 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    Voltar para Início
                </a>
            </div>
        </div>
    </div>

    <script>
        localStorage.removeItem('sabor_cart');
    </script>
</body>
</html>