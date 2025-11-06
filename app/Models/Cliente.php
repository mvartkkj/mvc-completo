<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Cliente extends Authenticatable
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'cod_cliente';
    public $timestamps = false;
    
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'data_nasc',
        'endereco',
        'numero',
        'bairro',
        'cod_cidade',
        'cep',
        'celular',
        'e_mail',
        'cargo_id',
        'passwd',
    ];

    protected $casts = [
        'data_nasc' => 'date',
    ];

    protected $hidden = [
        'passwd',
    ];

    // Relacionamento com Cargo
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    // Sobrescrever métodos de autenticação para usar 'passwd' ao invés de 'password'
    public function getAuthPassword()
    {
        return $this->passwd;
    }

    // Criptografar senha automaticamente ao salvar
    public function setPasswdAttribute($value)
    {
        // Só criptografa se o valor não for null e não estiver já criptografado
        if ($value && !str_starts_with($value, '$2y$')) {
            $this->attributes['passwd'] = Hash::make($value);
        } elseif ($value) {
            $this->attributes['passwd'] = $value;
        }
    }
    
    // Relacionamento com pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cod_cliente', 'cod_cliente');
    }
}