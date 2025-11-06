<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'cod_cat';
    public $timestamps = false;

    protected $fillable = [
        'descricao'
    ];

    public function pratos()
    {
        return $this->hasMany(Prato::class, 'cod_cat', 'cod_cat');
    }
}