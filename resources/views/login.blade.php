<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background">
    <!-- Header -->
    <header class="border-b border-border bg-card">
        <div class="px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                <svg class="w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>
                <span class="text-sm text-muted-foreground">Voltar</span>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m16 2-2.3 2.3a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L22 8"/>
                        <path d="M15 15 3.3 3.3a4.2 4.2 0 0 0 0 6l7.3 7.3c.7.7 2 .7 2.8 0L15 15Zm0 0 7 7"/>
                        <path d="m2.1 21.8 6.4-6.3"/>
                        <path d="m19 5-7 7"/>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-foreground">Sabor & Cia</h1>
            </div>
            <div class="w-16"></div>
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 container mx-auto px-4 py-8 flex items-center justify-center min-h-[calc(100vh-80px)]">
        <div class="w-full max-w-md bg-card border border-border rounded-lg p-8 space-y-6">
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-bold text-foreground">Bem-vindo de volta</h2>
                <p class="text-muted-foreground">Entre para fazer seu pedido</p>
            </div>

            @if(session('error'))
                <div class="bg-destructive/10 border border-destructive text-destructive px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500 text-green-600 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login -->
            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-foreground">E-mail</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="seu@email.com"
                            value="{{ old('email') }}"
                            class="w-full h-12 pl-10 pr-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring @error('email') border-destructive @enderror"
                            required
                        />
                    </div>
                    @error('email')
                        <p class="text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-foreground">Senha</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full h-12 pl-10 pr-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring @error('password') border-destructive @enderror"
                            required
                        />
                    </div>
                    @error('password')
                        <p class="text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-primary text-primary-foreground hover:bg-primary/90 h-12 rounded-lg font-semibold transition-colors"
                >
                    Entrar
                </button>
            </form>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="bg-card px-4 text-muted-foreground">Ou continue com</span>
                </div>
            </div>

            <!-- Login Google/Facebook -->
            <div class="grid gap-3">
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2 h-12 px-4 border border-border hover:bg-muted rounded-lg transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-sm font-medium">Google</span>
                </a>
            </div>

            <!-- Cadastro -->
            <div class="text-center text-sm">
                <span class="text-muted-foreground">Não tem uma conta? </span>
                <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">
                    Cadastre-se
                </a>
            </div>
        </div>
    </main>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se há dados de checkout salvos
    const checkoutData = localStorage.getItem('checkout_data');
    
    if (checkoutData) {
        // Mostrar mensagem informando que o carrinho está salvo
        const alertDiv = document.createElement('div');
        alertDiv.className = 'mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center gap-2';
        alertDiv.innerHTML = `
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                <path d="M3 6h18"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <span>Seu carrinho está salvo! Após o login, você retornará ao checkout.</span>
        `;
        
        // Inserir antes do formulário
        const form = document.querySelector('form');
        if (form && form.parentElement) {
            form.parentElement.insertBefore(alertDiv, form);
        }
    }
    
    // Marcar que veio do checkout
    if (checkoutData && checkoutData !== 'null') {
        sessionStorage.setItem('return_to_checkout', 'true');
    }
});
</script>
</html>