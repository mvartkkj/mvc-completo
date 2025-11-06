<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sabor & Cia</title>

        <!-- Fontes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-background">
        <!-- Header -->
        <header class="border-b border-border bg-card">
            <div class="px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <!-- Ícone UtensilsCrossed -->
                        <svg class="w-6 h-6 text-primary-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                            <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                            <path d="m2.1 21.8 6.4-6.3"/>
                            <path d="m19 5-7 7"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-foreground">Sabor & Cia</h1>
                </div>
                <a href="{{ route('login') }}" class="text-sm px-4 py-2 rounded-md hover:bg-muted transition-colors">
                    Entrar
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="container mx-auto px-4 py-8 md:py-16">
            <div class="max-w-2xl mx-auto text-center space-y-8">
                <!-- Main CTA -->
                <div class="space-y-4">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-primary/10 rounded-full mb-4">
                        <!-- Ícone QR Code -->
                        <svg class="w-12 h-12 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="5" height="5" x="3" y="3" rx="1"/>
                            <rect width="5" height="5" x="16" y="3" rx="1"/>
                            <rect width="5" height="5" x="3" y="16" rx="1"/>
                            <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                            <path d="M21 21v.01"/>
                            <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                            <path d="M3 12h.01"/>
                            <path d="M12 3h.01"/>
                            <path d="M12 16v.01"/>
                            <path d="M16 12h1"/>
                            <path d="M21 12v.01"/>
                            <path d="M12 21v-1"/>
                        </svg>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-foreground">Peça direto da sua mesa</h2>
                    <p class="text-lg text-muted-foreground leading-relaxed">
                        Escaneie o QR code da sua mesa e faça seu pedido de forma rápida e prática
                    </p>
                </div>

                <!-- Botoes -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <!-- <a href="{{ route('scan') }}" class="w-full sm:w-auto">
                        <button class="w-full bg-primary text-primary-foreground hover:bg-primary/90 px-6 py-3 rounded-lg text-lg h-14 flex items-center justify-center gap-2 transition-colors">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="5" height="5" x="3" y="3" rx="1"/>
                                <rect width="5" height="5" x="16" y="3" rx="1"/>
                                <rect width="5" height="5" x="3" y="16" rx="1"/>
                                <path d="M21 16h-3a2 2 0 0 0-2 2v3"/>
                                <path d="M21 21v.01"/>
                                <path d="M12 7v3a2 2 0 0 1-2 2H7"/>
                                <path d="M3 12h.01"/>
                                <path d="M12 3h.01"/>
                                <path d="M12 16v.01"/>
                                <path d="M16 12h1"/>
                                <path d="M21 12v.01"/>
                                <path d="M12 21v-1"/>
                            </svg>
                            Escanear QR Code
                        </button>
                    </a> -->
                    <a href="{{ route('menu') }}" class="w-full sm:w-auto">
                        <button class="w-full bg-transparent border border-border hover:bg-muted text-foreground px-6 py-3 rounded-lg text-lg h-14 transition-colors">
                            Ver Cardápio
                        </button>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-8">
                    <div class="bg-card border border-border rounded-lg p-6 text-center space-y-3">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-accent/10 rounded-lg">
                            <svg class="w-6 h-6 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                                <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                                <path d="m2.1 21.8 6.4-6.3"/>
                                <path d="m19 5-7 7"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-foreground">Cardápio Digital</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">
                            Navegue por todas as opções com fotos e descrições detalhadas
                        </p>
                    </div>

                    <div class="bg-card border border-border rounded-lg p-6 text-center space-y-3">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-accent/10 rounded-lg">
                            <svg class="w-6 h-6 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                                <path d="M3 6h18"/>
                                <path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-foreground">Pedido Fácil</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">
                            Adicione itens ao carrinho e finalize em poucos toques
                        </p>
                    </div>

                    <div class="bg-card border border-border rounded-lg p-6 text-center space-y-3">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-accent/10 rounded-lg">
                            <svg class="w-6 h-6 text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-foreground">Acompanhamento</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">
                            Veja o status do seu pedido em tempo real
                        </p>
                    </div>
                </div>

                <!-- Instruções -->
                <div class="bg-muted/50 border border-muted rounded-lg p-6">
                    <h3 class="font-semibold text-foreground mb-4">Como funciona?</h3>
                    <ol class="text-left space-y-3 text-sm text-muted-foreground">
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-xs font-bold">
                                1
                            </span>
                            <span class="leading-relaxed">Escaneie o QR code disponível na sua mesa</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-xs font-bold">
                                2
                            </span>
                            <span class="leading-relaxed">Navegue pelo cardápio e escolha seus pratos favoritos</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-xs font-bold">
                                3
                            </span>
                            <span class="leading-relaxed">Finalize o pedido e aguarde na sua mesa</span>
                        </li>
                    </ol>
                </div>

                <!-- Delivery -->
                <div class="pt-8 border-t border-border">
                    <p class="text-muted-foreground mb-4">Prefere pedir para entrega?</p>
                    <a href="{{ route('login') }}">
                        <button class="bg-transparent border border-border hover:bg-muted text-foreground px-6 py-3 rounded-lg transition-colors">
                            Fazer Login para Delivery
                        </button>
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-border mt-16">
            <div class="container mx-auto px-4 py-6 text-center text-sm text-muted-foreground">
                <p>© 2025 Sabor & Cia. Todos os direitos reservados.</p>
            </div>
        </footer>
    </body>
</html>