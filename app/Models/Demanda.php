<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demanda extends Model
{
    protected $table = "demandas";
    protected $fillable = ["name","cep_demanda"];

    public function classificacao_fornecedor() {
        return $this->hasMany(classificacao_fornecedor::class);
    }

    public function Servico() {
        return $this->belongsTo(Servico::class);
    }

    
}
