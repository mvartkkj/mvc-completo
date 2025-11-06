<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $primaryKey = 'cod_fornecedor';
    public $timestamps = false;

    protected $fillable = [
        'nome_social',
        'nome_fantasia',
        'cnpj',
        'endereco',
        'numero',
        'bairro',
        'cod_cidade',
        'cep',
        'celular',
        'e_mail',
    ];

    // Relacionamento com Cidade (se existir)
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cod_cidade', 'cod_cidade');
    }
}