<?php

namespace App\Http\Resources;

use App\Http\Repositories\ServicoRepository;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemandaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->resource['id'] ?? "",
            'name'          => $this->resource['name'] ?? "",
            'cep_demanda'   => $this->resource['cep_demanda'] ?? "",
            'data_criacao'  => Carbon::parse($this->resource['created_at'])->format('d/m/Y H:i') ?? "",
            'servico'       => Servico::where("id",$this->resource['servico_id'])->first()->only(["id","name","description"]) ?? "",
        ];
    }
}
