<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Escanear Mesa | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background">
    <!-- Header -->
    <header class="border-b border-border bg-card">
        <div class="px-4 py-4 flex items-center gap-4">
            <a href="{{ route('home') }}" class="hover:bg-muted rounded-md p-2 transition-colors">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-foreground">Escanear Mesa</h1>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto space-y-6">
            <!-- Mensagens -->
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- QR CODE -->
            <div class="bg-card border border-border rounded-lg p-8">
                <div class="text-center space-y-6">
                    <div class="inline-flex items-center justify-center w-32 h-32 bg-primary/10 rounded-2xl">
                        <svg id="qr-icon" class="w-16 h-16 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg id="camera-icon" class="w-16 h-16 text-primary hidden animate-pulse" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                            <circle cx="12" cy="13" r="3"/>
                        </svg>
                    </div>

                    <div class="space-y-2">
                        <h2 id="scan-title" class="text-2xl font-bold text-foreground">Escaneie o QR Code</h2>
                        <p class="text-muted-foreground leading-relaxed">
                            Aponte a câmera do seu celular para o QR code disponível na sua mesa
                        </p>
                    </div>

                    <button 
                        id="scan-button"
                        class="w-full bg-primary text-primary-foreground hover:bg-primary/90 px-6 py-3 rounded-lg h-14 flex items-center justify-center gap-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="handleScan()"
                    >
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                            <circle cx="12" cy="13" r="3"/>
                        </svg>
                        <span>Abrir Câmera</span>
                    </button>
                </div>
            </div>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-border"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-background px-2 text-muted-foreground">Ou digite o código</span>
                </div>
            </div>

            <!-- Formulário Manual -->
            <div class="bg-card border border-border rounded-lg p-6">
                <form action="{{ route('mesa.login') }}" method="POST" class="space-y-4" id="manual-form">
                    @csrf
                    <div class="space-y-2">
                        <label for="tableCode" class="text-sm font-medium text-foreground">Código da Mesa</label>
                        <input
                            type="text"
                            id="tableCode"
                            name="table_code"
                            value="{{ old('table_code') }}"
                            placeholder="Ex: Mesa 01"
                            class="w-full h-12 px-4 text-lg bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                            required
                        />
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-transparent border border-border hover:bg-muted text-foreground px-6 py-3 rounded-lg h-12 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        🪑 Entrar como Mesa
                    </button>
                </form>
            </div>

            <div class="bg-muted/50 border border-muted rounded-lg p-4">
                <p class="text-sm text-muted-foreground text-center leading-relaxed">
                    <strong class="text-foreground">Dica:</strong> O código da mesa está impresso no QR code ou no cardápio físico
                </p>
            </div>
        </div>
    </main>

    <script>
        function handleScan() {
            const button = document.getElementById('scan-button');
            const qrIcon = document.getElementById('qr-icon');
            const cameraIcon = document.getElementById('camera-icon');
            const title = document.getElementById('scan-title');
            const tableCodeInput = document.getElementById('tableCode');
            
            button.disabled = true;
            qrIcon.classList.add('hidden');
            cameraIcon.classList.remove('hidden');
            title.textContent = 'Escaneando...';
            
            button.innerHTML = `
                <div class="w-5 h-5 border-2 border-primary-foreground border-t-transparent rounded-full animate-spin"></div>
                <span>Escaneando...</span>
            `;
            
            // Simula scan - em produção, integre com biblioteca de QR Code
            setTimeout(() => {
                const simulatedTableCode = 'Mesa 01';
                tableCodeInput.value = simulatedTableCode;
                
                button.disabled = false;
                qrIcon.classList.remove('hidden');
                cameraIcon.classList.add('hidden');
                title.textContent = 'Escaneie o QR Code';
                button.innerHTML = `
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                    <span>Abrir Câmera</span>
                `;
                
                document.getElementById('manual-form').submit();
            }, 2000);
        }
    </script>
</body>
</html>