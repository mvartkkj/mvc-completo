<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $primaryKey = 'cod_mesa';
    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento com pedidos
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cod_mesa', 'cod_mesa');
    }

    /**
     * Verifica se a mesa tem pedidos ativos
     */
    public function temPedidosAtivos()
    {
        return $this->pedidos()
            ->where('encerrado', 0)
            ->where('cancelado', 0)
            ->exists();
    }

    /**
     * Pegar pedidos ativos da mesa
     */
    public function pedidosAtivos()
    {
        return $this->pedidos()
            ->where('encerrado', 0)
            ->where('cancelado', 0)
            ->get();
    }

    /**
     * Calcular total de pedidos ativos
     */
    public function totalPedidosAtivos()
    {
        return $this->pedidos()
            ->where('encerrado', 0)
            ->where('cancelado', 0)
            ->sum('valor_total');
    }

    /**
     * Scope para buscar apenas mesas ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('ativo', 1);
    }

    /**
     * Scope para buscar apenas mesas inativas
     */
    public function scopeInativas($query)
    {
        return $query->where('ativo', 0);
    }
}