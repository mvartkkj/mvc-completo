<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'cod_pedido';
    public $timestamps = false;

    protected $fillable = [
        'cod_cliente',
        'cod_mesa',
        'tipo_pedido',
        'datahora',
        'encerrado',
        'datahora_encerramento',
        'cancelado',
        'forma_pagamento',  // ALTERADO: era 'pago'
        'valor_pago',
        'data_pago',
        'taxa_servico',
        'valor_entrega',
        'desconto',
        'valor_total',
    ];

    protected $casts = [
        'valor_entrega' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'taxa_servico' => 'decimal:2',
        'desconto' => 'decimal:2',
        'encerrado' => 'boolean',
        'cancelado' => 'boolean',
        'datahora' => 'datetime',
        'datahora_encerramento' => 'datetime',
        'data_pago' => 'datetime',
    ];

    // Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cod_cliente', 'cod_cliente');
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class, 'cod_pedido', 'cod_pedido');
    }

    // Métodos auxiliares
    public function getStatusLabelAttribute()
    {
        if ($this->cancelado) {
            return 'Cancelado';
        }
        if ($this->encerrado) {
            return 'Entregue';
        }
        return 'Pendente';
    }

    public function getStatusColorAttribute()
    {
        if ($this->cancelado) {
            return 'red';
        }
        if ($this->encerrado) {
            return 'green';
        }
        return 'yellow';
    }

    // NOVO: Converter tipo_pedido numérico para texto
    public function getTipoPedidoAttribute($value)
    {
        $tipos = [
            1 => 'mesa',
            2 => 'balcao',
            3 => 'delivery',
        ];
        return $tipos[$value] ?? 'mesa';
    }

    // NOVO: Label amigável para tipo de pedido
    public function getTipoPedidoLabelAttribute()
    {
        $labels = [
            'mesa' => 'Entregar na Mesa',
            'balcao' => 'Retirar no Balcão',
            'delivery' => 'Entrega em Casa',
        ];
        return $labels[$this->tipo_pedido] ?? $this->tipo_pedido;
    }
    
    // Converter forma_pagamento numérico para texto
    public function getFormaPagamentoAttribute($value)
    {
        $formas = [
            1 => 'dinheiro',
            2 => 'credito',
            3 => 'debito',
            4 => 'pix',
        ];
        return $formas[$value] ?? 'dinheiro';
    }

    public function getPagamentoLabelAttribute()
    {
        $labels = [
            'dinheiro' => 'Dinheiro',
            'credito' => 'Cartão de Crédito',
            'debito' => 'Cartão de Débito',
            'pix' => 'PIX',
        ];
        return $labels[$this->forma_pagamento] ?? 'Não informado';
    }
}