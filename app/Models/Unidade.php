<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'cod_unidade';
    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'sigla',
    ];

    // Relacionamento com Ingredientes
    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class, 'cod_unidade', 'cod_unidade');
    }
}