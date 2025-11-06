<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    protected $table = 'itens_pedido';
    protected $primaryKey = 'cod_item';
    public $timestamps = false;

    protected $fillable = [
        'cod_pedido',
        'cod_prato',
        'quantidade',
        'valor_unitario',
        'cod_garcom',
        'data_hora',
    ];

    protected $casts = [
        'valor_unitario' => 'decimal:2',
        'quantidade' => 'integer',
        'data_hora' => 'datetime',
    ];

    // Relacionamento com Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'cod_pedido', 'cod_pedido');
    }

    // Relacionamento com Prato
    public function prato()
    {
        return $this->belongsTo(Prato::class, 'cod_prato', 'cod_prato');
    }

    // Calcular subtotal do item
    public function getSubtotalAttribute()
    {
        return $this->valor_unitario * $this->quantidade;
    }
}

// ===== ADICIONAR NO Model Pedido.php =====
// Adicione este método no arquivo Pedido.php que você já tem:

/*
public function itens()
{
    return $this->hasMany(PedidoItem::class, 'cod_pedido', 'cod_pedido');
}
*/