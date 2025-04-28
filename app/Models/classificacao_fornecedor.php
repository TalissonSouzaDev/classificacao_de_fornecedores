<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classificacao_fornecedor extends Model
{

    protected $table = "classificacao_fornecedors";
    protected $fillable = ["fornecedor_id","demanda_id","posicao","justificativa","distancia_km","distancia_value"];

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class);
    }

    public function demanda() {
        return $this->belongsTo(Demanda::class);
    }

}
