<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"            => $this->resource["id"] ?? "id não Identificado",
            "name"          => $this->resource["name"] ?? "Serviço não Identificado",
            "description"   => $this->resource["description"] ?? "Sem descrição",
        ];
    }
}
