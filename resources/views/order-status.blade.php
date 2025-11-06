<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido #{{ $orderId }} | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Auto refresh a cada 10 segundos -->
    <meta http-equiv="refresh" content="10">
</head>
<body class="font-sans antialiased bg-background">
    <!-- Header -->
    <header class="border-b border-border bg-card">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                        <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                        <path d="m2.1 21.8 6.4-6.3"/>
                        <path d="m19 5-7 7"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-foreground">Sabor & Cia</h1>
                    <p class="text-xs text-muted-foreground">Pedido #{{ $orderId }}</p>
                </div>
            </div>
            <a href="{{ route('menu') }}" class="flex items-center gap-2 px-4 py-2 border border-border hover:bg-muted rounded-lg transition-colors">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span class="text-sm font-medium">Início</span>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 max-w-3xl">
        <!-- status -->
        <div class="bg-card border border-border rounded-lg p-8 text-center space-y-6 mb-6">
            <div class="w-20 h-20 bg-{{ $statusColor }} rounded-full flex items-center justify-center mx-auto">
                {!! $statusIcon !!}
            </div>
            <div class="space-y-2">
                <h2 class="text-3xl font-bold text-foreground">{{ $statusLabel }}</h2>
                <p class="text-muted-foreground leading-relaxed">{{ $statusDescription }}</p>
            </div>

            <!-- progresso -->
            <div class="pt-6">
                <div class="relative flex items-start justify-between max-w-md mx-auto">
                    @foreach($steps as $index => $step)
                    <div class="flex flex-col items-center flex-1 relative z-10">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $step['active'] ? $step['color'] : 'bg-muted' }} transition-colors">
                            {!! $step['icon'] !!}
                        </div>
                        <p class="text-xs text-muted-foreground mt-2 text-center max-w-[80px]">{{ $step['label'] }}</p>
                    </div>
                    @if($index < count($steps) - 1)
                    <div class="absolute top-6 left-0 right-0 h-1 bg-muted" style="margin: 0 calc(50% / {{ count($steps) }});">
                        <div class="h-full {{ $step['active'] ? $step['color'] : 'bg-muted' }} transition-all" style="width: {{ $step['active'] ? '100%' : '0%' }};"></div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- detalhes do pedido -->
        <div class="bg-card border border-border rounded-lg p-6 space-y-6">
            <div>
                <h3 class="text-xl font-bold text-foreground mb-4">Detalhes do Pedido</h3>
                <div class="space-y-3">
                    @foreach($items as $item)
                    <div class="flex justify-between text-sm">
                        <div class="flex-1">
                            <p class="font-medium text-foreground">
                                {{ $item['quantity'] }}x {{ $item['name'] }}
                            </p>
                        </div>
                        <p class="font-semibold text-foreground">
                            R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-border pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Subtotal</span>
                    <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-muted-foreground">Taxa de serviço</span>
                    <span class="font-semibold">R$ {{ number_format($serviceCharge, 2, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-border">
                    <span>Total</span>
                    <span class="text-primary">R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>

            <div class="border-t border-border pt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Forma de pagamento</span>
                    <span class="font-semibold capitalize">{{ $paymentMethod }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted-foreground">Local de entrega</span>
                    <span class="font-semibold capitalize">{{ $deliveryLocation }}</span>
                </div>
                @if($observations)
                <div class="pt-2">
                    <p class="text-muted-foreground mb-1">Observações:</p>
                    <p class="font-medium text-foreground">{{ $observations }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- fazer/cancelar pedido -->
        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('menu') }}" class="flex-1">
                <button class="w-full bg-transparent border border-border hover:bg-muted text-foreground px-6 py-3 rounded-lg font-semibold transition-colors">
                    Fazer Novo Pedido
                </button>
            </a>
            @if($status === 'pending')
            <form action="{{ route('order.cancel', $orderId) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" onclick="return confirm('Tem certeza que deseja cancelar o pedido?')" class="w-full bg-destructive text-destructive-foreground hover:bg-destructive/90 px-6 py-3 rounded-lg font-semibold transition-colors">
                    Cancelar Pedido
                </button>
            </form>
            @endif
        </div>

        <!-- ajuda -->
        <div class="mt-6 bg-muted/50 border border-muted rounded-lg p-4">
            <p class="text-sm text-muted-foreground text-center leading-relaxed">
                Precisa de ajuda? Chame um garçom ou entre em contato pelo WhatsApp: (18) 99656-4297
            </p>
        </div>
    </main>
</body>
</html>