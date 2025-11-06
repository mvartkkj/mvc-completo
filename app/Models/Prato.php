<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prato extends Model
{
    protected $table = 'pratos';
    protected $primaryKey = 'cod_prato';
    public $timestamps = false; // Desabilita created_at e updated_at

    protected $fillable = [
        'descricao',
        'cod_cat',
        'valor_unitario',
        'foto_prato'
    ];

    protected $casts = [
        'valor_unitario' => 'decimal:2',
    ];

    // Relacionamento com a tabela categorias
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'cod_cat', 'cod_cat');
    }

    // Retorna a URL completa da foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto_prato) {
            return asset('images/pratos/' . $this->foto_prato);
        }
        return asset('images/placeholder.png');
    }

    // Scope para ordenar
    public function scopeOrdenados($query)
    {
        return $query->orderBy('descricao', 'asc');
    }
}