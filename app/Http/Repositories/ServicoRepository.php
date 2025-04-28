<?php
namespace App\Http\Repositories;

use App\Models\Servico;

class ServicoRepository {

    public $servico;

    public function __construct(Servico $servico)
    {
        $this->servico = $servico;
    }

    public function listAndfilter(string $filter = "") {
        if(empty($filter)) {
            $response = $this->servico->latest()->paginate(10);
            return $response;
        }
        $response = $this->servico->where("name","LIKE","%{$filter}%")
                                    ->where("description","LIKE","%{$filter}%")
                                    ->paginate(10);
        return $response;                       
    }

    public function GetByIdServico(string | int $idservico) {
        if(!empty($idservico)) {
            $getservico = $this->servico->find($idservico);
            return $getservico;
        }
    }

    public function CreateServico(array $request) {
        $servicocreate = $this->servico->create([
            "name" => $request["name"],
            "description" => $request["description"],
        ]);

        return $servicocreate ? true : false;
    }

    public function UpdateServico(array $request, string | int $id) {
        $servicoupdate = false;
        $servico = $this->GetByIdservico($id);
        if(!empty($servico)) {
            $servicoupdate = $servico->update([
                "name" => $request["name"] ?? $servico->name,
                "description" => $request["description"] ?? $servico->description,
            ]);
        }
        return $servicoupdate ? true : false;
    }

    public function DeleteServico(string | int $id) {
        $servicodelete = false;
        $servico = $this->GetByIdservico($id);
        if(!empty($servico)) {
            $servicodelete = $servico->delete();
        }
        return $servicodelete ? true : false;
    }

}