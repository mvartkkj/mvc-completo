<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $table = 'ingredientes';
    protected $primaryKey = 'cod_ingrediente';
    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'cod_unidade',
        'controla_estoque',
        'quantidade_estoque',
        'valor_unitario',
    ];

    protected $casts = [
        'controla_estoque' => 'boolean',
        'quantidade_estoque' => 'float',
        'valor_unitario' => 'float',
    ];

    // Relacionamento com Unidade
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'cod_unidade', 'cod_unidade');
    }

    // Método para verificar o status do estoque
    public function getStatusEstoqueAttribute()
    {
        if (!$this->controla_estoque) {
            return 'sem_controle';
        }

        $quantidade = $this->quantidade_estoque ?? 0;

        if ($quantidade > 20) {
            return 'ok';
        } elseif ($quantidade >= 10 && $quantidade <= 20) {
            return 'baixo';
        } else {
            return 'critico';
        }
    }

    // Método para retornar a cor do status
    public function getCorStatusAttribute()
    {
        $status = $this->status_estoque;

        return match($status) {
            'ok' => 'green',
            'baixo' => 'yellow',
            'critico' => 'red',
            default => 'gray'
        };
    }

    // Método para retornar o texto do status
    public function getTextoStatusAttribute()
    {
        $status = $this->status_estoque;

        return match($status) {
            'ok' => '✓ Estoque OK',
            'baixo' => '⚠ Estoque Baixo',
            'critico' => '✕ Crítico',
            default => 'Sem Controle'
        };
    }
}