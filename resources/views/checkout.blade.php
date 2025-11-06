<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout | Sabor & Cia</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background"
    x-data="{
        paymentMethod: 'credito',
        deliveryOption: '{{ $defaultDeliveryOption ?? 'balcao' }}',
        observations: '',
        changeFor: '',
        isProcessing: false,
        showLoginModal: false,
        
        async submitOrder() {
            // Se escolheu delivery e não está logado
            if (this.deliveryOption === 'delivery' && !{{ Auth::guard('cliente')->check() ? 'true' : 'false' }}) {
                this.showLoginModal = true;
                return;
            }
            
            this.isProcessing = true;
            document.getElementById('checkout-form').submit();
        }
    }">

    <!-- Header -->
    <header class="border-b border-border bg-card sticky top-0 z-40">
        <div class="px-4 py-4 flex items-center justify-between">
            <a href="{{ route('menu') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
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
                <h1 class="text-lg font-bold text-foreground">Finalizar Pedido</h1>
            </div>
            <div class="w-16"></div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6 max-w-4xl">
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Local de Entrega -->
                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <h2 class="text-xl font-bold text-foreground">Local de Entrega</h2>
                        </div>
                        
                        <div class="space-y-3">
                            @php
                                $isMesa = session('mesa_logada', false);
                                $isLoggedIn = Auth::guard('cliente')->check();
                                // Define valor padrão baseado no tipo de acesso
                                $defaultDeliveryOption = $isMesa ? 'mesa' : 'balcao';
                            @endphp

                            {{-- Opção MESA: Só aparece se escaneou QR Code --}}
                            @if($isMesa)
                                <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                    :class="deliveryOption === 'mesa' ? 'border-primary bg-primary/5' : ''">
                                    <input type="radio" name="delivery_option" value="mesa" x-model="deliveryOption" class="text-primary focus:ring-primary" required />
                                    <div class="flex-1">
                                        <p class="font-semibold">Entregar na Mesa</p>
                                        <p class="text-sm text-muted-foreground">{{ $tableCode }}</p>
                                    </div>
                                </label>
                            @endif

                            {{-- Opção BALCÃO: Só aparece se NÃO for mesa --}}
                            @if(!$isMesa)
                                <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                    :class="deliveryOption === 'balcao' ? 'border-primary bg-primary/5' : ''">
                                    <input type="radio" name="delivery_option" value="balcao" x-model="deliveryOption" class="text-primary focus:ring-primary" {{ !$isMesa ? 'required' : '' }} />
                                    <div class="flex-1">
                                        <p class="font-semibold">Retirar no Balcão</p>
                                        <p class="text-sm text-muted-foreground">Chamaremos quando estiver pronto</p>
                                    </div>
                                </label>

                                {{-- Campo de nome para balcão --}}
                                <div x-show="deliveryOption === 'balcao'" class="space-y-2 pt-4 border-t border-border" style="display: none;">
                                    <label for="nome_cliente_balcao" class="text-sm font-medium text-foreground">Seu nome *</label>
                                    <input 
                                        type="text" 
                                        name="nome_cliente_balcao" 
                                        id="nome_cliente_balcao"
                                        value="{{ old('nome_cliente_balcao', Auth::guard('cliente')->user()->nome ?? '') }}"
                                        placeholder="Digite seu nome para identificação"
                                        class="w-full h-12 px-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                                        :required="deliveryOption === 'balcao'"
                                    />
                                    <p class="text-xs text-muted-foreground">Usaremos este nome para te chamar quando o pedido estiver pronto</p>
                                </div>
                            @endif

                            {{-- Opção DELIVERY: Só aparece se NÃO for mesa --}}
                            @if(!$isMesa)
                                <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                    :class="deliveryOption === 'delivery' ? 'border-primary bg-primary/5' : ''">
                                    <input type="radio" name="delivery_option" value="delivery" x-model="deliveryOption" class="text-primary focus:ring-primary" />
                                    <div class="flex-1">
                                        <p class="font-semibold">Entrega em Casa</p>
                                        <p class="text-sm text-muted-foreground">Taxa de entrega: R$ 10,00</p>
                                    </div>
                                </label>

                                {{-- Campos de Endereço (aparecem só no delivery) --}}
                                <div x-show="deliveryOption === 'delivery'" class="space-y-4 pt-4 border-t border-border" style="display: none;">
                                    <h3 class="font-semibold text-foreground">Endereço de Entrega</h3>
                                    
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="col-span-2">
                                            <label class="text-sm font-medium text-foreground">Endereço *</label>
                                            <input type="text" name="endereco" value="{{ old('endereco', $user->endereco ?? '') }}" placeholder="Rua, Avenida..." class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" :required="deliveryOption === 'delivery'" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-foreground">Número *</label>
                                            <input type="text" name="numero" value="{{ old('numero', $user->numero ?? '') }}" placeholder="123" class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" :required="deliveryOption === 'delivery'" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-sm font-medium text-foreground">Bairro *</label>
                                            <input type="text" name="bairro" value="{{ old('bairro', $user->bairro ?? '') }}" placeholder="Centro" class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" :required="deliveryOption === 'delivery'" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-foreground">Cidade *</label>
                                            <input type="text" name="cidade" value="{{ old('cidade') }}" placeholder="São Paulo" class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" :required="deliveryOption === 'delivery'" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-sm font-medium text-foreground">CEP *</label>
                                            <input type="text" name="cep" value="{{ old('cep', $user->cep ?? '') }}" placeholder="12345678" maxlength="8" class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" :required="deliveryOption === 'delivery'" />
                                        </div>
                                        <div>
                                            <label class="text-sm font-medium text-foreground">Complemento</label>
                                            <input type="text" name="complemento" value="{{ old('complemento') }}" placeholder="Apto 101" class="w-full h-10 px-4 mt-1 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Forma de Pagamento -->
                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="5" rx="2"/>
                                <line x1="2" x2="22" y1="10" y2="10"/>
                            </svg>
                            <h2 class="text-xl font-bold text-foreground">Forma de Pagamento</h2>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                   :class="paymentMethod === 'credito' ? 'border-primary bg-primary/5' : ''">
                                <input type="radio" name="payment_method" value="credito" x-model="paymentMethod" class="text-primary focus:ring-primary" required />
                                <svg class="w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                                    <line x1="2" x2="22" y1="10" y2="10"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-semibold">Cartão de Crédito</p>
                                    <p class="text-sm text-muted-foreground">Visa, Mastercard, Elo</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                   :class="paymentMethod === 'debito' ? 'border-primary bg-primary/5' : ''">
                                <input type="radio" name="payment_method" value="debito" x-model="paymentMethod" class="text-primary focus:ring-primary" />
                                <svg class="w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                                    <line x1="2" x2="22" y1="10" y2="10"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-semibold">Cartão de Débito</p>
                                    <p class="text-sm text-muted-foreground">Visa, Mastercard, Elo</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                   :class="paymentMethod === 'pix' ? 'border-primary bg-primary/5' : ''">
                                <input type="radio" name="payment_method" value="pix" x-model="paymentMethod" class="text-primary focus:ring-primary" />
                                <svg class="w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
                                    <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-semibold">PIX</p>
                                    <p class="text-sm text-muted-foreground">Pagamento instantâneo</p>
                                </div>
                            </label>

                            <label class="flex items-center space-x-3 p-4 border border-border rounded-lg cursor-pointer hover:bg-muted/50 transition-colors"
                                   :class="paymentMethod === 'dinheiro' ? 'border-primary bg-primary/5' : ''">
                                <input type="radio" name="payment_method" value="dinheiro" x-model="paymentMethod" class="text-primary focus:ring-primary" />
                                <svg class="w-5 h-5 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="12" x="2" y="6" rx="2"/>
                                    <circle cx="12" cy="12" r="2"/>
                                    <path d="M6 12h.01M18 12h.01"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-semibold">Dinheiro</p>
                                    <p class="text-sm text-muted-foreground">Pagar na entrega</p>
                                </div>
                            </label>
                        </div>

                        <div x-show="paymentMethod === 'dinheiro'" class="space-y-2 pt-2">
                            <label for="change_for" class="text-sm font-medium text-foreground">Troco para quanto?</label>
                            <input 
                                type="number" 
                                name="change_for" 
                                id="change_for"
                                x-model="changeFor"
                                step="0.01"
                                placeholder="Ex: 200.00"
                                class="w-full h-12 px-4 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring"
                            />
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="bg-card border border-border rounded-lg p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            <h2 class="text-xl font-bold text-foreground">Observações</h2>
                        </div>
                        <div class="space-y-2">
                            <label for="observations" class="text-sm font-medium text-foreground">Alguma observação sobre o pedido?</label>
                            <textarea
                                name="observations"
                                id="observations"
                                x-model="observations"
                                rows="4"
                                placeholder="Ex: Sem cebola, ponto da carne mal passado..."
                                class="w-full px-4 py-3 bg-background border border-input rounded-lg focus:outline-none focus:ring-2 focus:ring-ring resize-none"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-card border border-border rounded-lg p-6 space-y-4 sticky top-24">
                        <h2 class="text-xl font-bold text-foreground">Resumo do Pedido</h2>

                        <!-- Items -->
                        <div class="space-y-3 border-b border-border pb-4">
                            @foreach($cartItems as $item)
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

                        <!-- Total -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Subtotal</span>
                                <span class="font-semibold">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Taxa de serviço (10%)</span>
                                <span class="font-semibold">R$ {{ number_format($serviceCharge, 2, ',', '.') }}</span>
                            </div>
                            <div x-show="deliveryOption === 'delivery'" class="flex justify-between text-sm">
                                <span class="text-muted-foreground">Taxa de entrega</span>
                                <span class="font-semibold">R$ 10,00</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-2 border-t border-border">
                                <span>Total</span>
                                <span class="text-primary" x-text="'R$ ' + (deliveryOption === 'delivery' ? {{ $total + 10 }} : {{ $total }}).toFixed(2).replace('.', ',')"></span>
                            </div>
                        </div>

                        <button 
                            type="button"
                            @click="submitOrder()"
                            :disabled="isProcessing"
                            class="w-full bg-primary text-primary-foreground hover:bg-primary/90 h-12 rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span x-show="!isProcessing">Confirmar Pedido</span>
                            <span x-show="isProcessing" class="flex items-center justify-center gap-2">
                                <div class="w-4 h-4 border-2 border-primary-foreground border-t-transparent rounded-full animate-spin"></div>
                                Processando...
                            </span>
                        </button>

                        <p class="text-xs text-muted-foreground text-center leading-relaxed">
                            Ao confirmar, você concorda com os termos de serviço
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- Modal de Login -->
    <div x-show="showLoginModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
        <div @click="showLoginModal = false" class="absolute inset-0 bg-black/50"></div>
        <div class="relative bg-card border border-border rounded-lg p-8 max-w-md w-full space-y-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-foreground mb-2">Login Necessário</h3>
                <p class="text-muted-foreground">Para solicitar entrega, você precisa estar logado.</p>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('login') }}" class="block w-full bg-primary text-primary-foreground hover:bg-primary/90 h-12 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    Fazer Login
                </a>
                <a href="{{ route('register') }}" class="block w-full bg-transparent border border-border hover:bg-muted text-foreground h-12 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    Criar Conta
                </a>
                <button @click="showLoginModal = false; deliveryOption = 'mesa'" class="block w-full text-muted-foreground hover:text-foreground transition-colors text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

</body>
</html>