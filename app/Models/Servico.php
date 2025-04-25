<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = "servicos";
    protected $fillable = ["name","description"];

    public function Demanda() {
        return $this->hasMany(Demanda::class);
    }

    public function Fornecedor() {
        return $this->belongsToMany(Fornecedor::class);
    }
}
