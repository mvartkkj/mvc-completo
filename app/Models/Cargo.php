<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';
    public $timestamps = false; // Se sua tabela NÃO tem created_at/updated_at
    
    protected $fillable = ['nome', 'descricao'];

    // Relacionamento com Clientes
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'cargo_id');
    }
}