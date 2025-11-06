<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function status($orderId)
    {
        // Em produção, você buscar do banco de dados:
        // $order = Order::with('items')->findOrFail($orderId);
        
        // Mock data para demonstração
        $status = 'preparing'; // pending, preparing, ready, delivered, cancelled
        
        // Dados dos itens do pedido
        $items = [
            ['name' => 'Picanha na Brasa', 'quantity' => 1, 'price' => 89.90],
            ['name' => 'Espaguete Carbonara', 'quantity' => 2, 'price' => 54.90],
            ['name' => 'Refrigerante Lata', 'quantity' => 2, 'price' => 6.90],
        ];
        
        $subtotal = array_reduce($items, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
        $serviceCharge = $subtotal * 0.1;
        $total = $subtotal + $serviceCharge;
        
        // Configuração de status
        $statusConfig = [
            'pending' => [
                'label' => 'Pedido Recebido',
                'color' => 'yellow-500',
                'description' => 'Seu pedido foi recebido e está sendo processado',
                'icon' => '<svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            ],
            'preparing' => [
                'label' => 'Em Preparo',
                'color' => 'blue-500',
                'description' => 'Nossa cozinha está preparando seu pedido',
                'icon' => '<svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" x2="18" y1="17" y2="17"/></svg>',
            ],
            'ready' => [
                'label' => 'Pronto',
                'color' => 'green-500',
                'description' => 'Seu pedido está pronto e será entregue em breve',
                'icon' => '<svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>',
            ],
            'delivered' => [
                'label' => 'Entregue',
                'color' => 'green-600',
                'description' => 'Seu pedido foi entregue. Bom apetite!',
                'icon' => '<svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            ],
            'cancelled' => [
                'label' => 'Cancelado',
                'color' => 'red-500',
                'description' => 'Seu pedido foi cancelado',
                'icon' => '<svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
            ],
        ];
        
        $currentStatus = $statusConfig[$status];
        
        // Steps para o progresso
        $steps = [
            [
                'label' => 'Recebido',
                'color' => 'bg-yellow-500',
                'active' => in_array($status, ['pending', 'preparing', 'ready', 'delivered']),
                'icon' => '<svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            ],
            [
                'label' => 'Preparando',
                'color' => 'bg-blue-500',
                'active' => in_array($status, ['preparing', 'ready', 'delivered']),
                'icon' => '<svg class="w-6 h-6 ' . (in_array($status, ['preparing', 'ready', 'delivered']) ? 'text-white' : 'text-muted-foreground') . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/><line x1="6" x2="18" y1="17" y2="17"/></svg>',
            ],
            [
                'label' => 'Pronto',
                'color' => 'bg-green-500',
                'active' => in_array($status, ['ready', 'delivered']),
                'icon' => '<svg class="w-6 h-6 ' . (in_array($status, ['ready', 'delivered']) ? 'text-white' : 'text-muted-foreground') . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg>',
            ],
            [
                'label' => 'Entregue',
                'color' => 'bg-green-600',
                'active' => $status === 'delivered',
                'icon' => '<svg class="w-6 h-6 ' . ($status === 'delivered' ? 'text-white' : 'text-muted-foreground') . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            ],
        ];
        
        return view('order-status', [
            'orderId' => $orderId,
            'status' => $status,
            'statusLabel' => $currentStatus['label'],
            'statusColor' => $currentStatus['color'],
            'statusDescription' => $currentStatus['description'],
            'statusIcon' => $currentStatus['icon'],
            'items' => $items,
            'subtotal' => $subtotal,
            'serviceCharge' => $serviceCharge,
            'total' => $total,
            'paymentMethod' => 'Cartão de Crédito',
            'deliveryLocation' => 'Mesa 12',
            'observations' => null,
            'steps' => $steps,
        ]);
    }
    
    public function cancel($orderId)
    {
        // Em produção, você cancelar o pedido no banco:
        // $order = Order::findOrFail($orderId);
        // $order->update(['status' => 'cancelled']);
        
        return redirect()->route('order.status', $orderId)
            ->with('success', 'Pedido cancelado com sucesso!');
    }
}