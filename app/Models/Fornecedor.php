<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = "fornecedors";
    protected $fillable = ["razao_social","cnpj","email","telefone","cep_sede"];

    public function Servico() {
        return $this->belongsToMany(Servico::class);
    }

    public function classificacao_fornecedor() {
        return $this->hasMany(classificacao_fornecedor::class);
    }
}
