<?php
namespace App\Http\Repositories;

use App\Models\Fornecedor;

class FornecedorRepository {

    protected $fornecedor;

    public function __construct(Fornecedor $fornecedor)
    {
        $this->fornecedor = $fornecedor;
    }

    public function listAndfilter(string $filter = "") {
        if(empty($filter)) {
            $response = $this->fornecedor->latest()->paginate(10);
            return $response;
        }
        $response = $this->fornecedor->with("service")
                                ->where("razao_social","LIKE","%{$filter}%")
                                ->where("cnpj","LIKE","%{$filter}%")
                                ->where("email","LIKE","%{$filter}%")
                                ->where("telefone","LIKE","%{$filter}%")
                                ->where("cep_sede","LIKE","%{$filter}%")
                                ->paginate(10);
        return $response;
    }

    public function GetByIdFornecedor(string | int $idfornecedor) {
        if(!empty($idfornecedor)) {
            $getfornecedor = $this->fornecedor->where("id",$idfornecedor)->first();
            return $getfornecedor;
        }
        return [];
    }

    public function Create_Fornecedor(array $request) {
        $fornecedorcreate = $this->fornecedor->create([
            "razao_social" => $request["razao_social"],
            "cnpj" => $request["cnpj"],
            "email" => $request["email"],
            "telefone" => $request["telefone"],
            "cep_sede" => $request["cep_sede"],
        ]);

        return $fornecedorcreate ? true : false;
    }

    public function Update_Fornecedor(array $request, string | int $id) {
        $fornecedorupdate = false;
        $fornecedor = $this->GetByIdFornecedor($id);
        if(!empty($fornecedor)) {
            $fornecedorupdate = $fornecedor->update([
                "razao_social" => $request["razao_social"] ?? $fornecedor->razao_social,
                "cnpj" => $request["cnpj"] ?? $fornecedor->cnpj,
                "email" => $request["email"] ?? $fornecedor->email,
                "telefone" => $request["telefone"] ?? $fornecedor->telefone,
                "cep_sede" => $request["cep_sede"] ?? $fornecedor->cep_sede,
            ]);
        }
        return $fornecedorupdate ? true : false;
    }

    public function Delete_Fornecedor(string | int $id) {
        $fornecedordelete = false;
        $fornecedor = $this->GetByIdFornecedor($id);
        if(!empty($fornecedor)) {
            $fornecedordelete = $fornecedor->delete();
        }
        return $fornecedordelete ? true : false;
    }

    public function FornecedorServicosGet(string | int $id) {
        $fornecedor = $this->GetByIdFornecedor($id);
        if(empty($fornecedor)) {
            abort(404, 'Fornecedor não encontrado.');
        }
        return $fornecedor->servicos->all();
    }


    public function AttachFornecedorAndServico(string | int $id, array $request) {
        $fornecedor = $this->GetByIdFornecedor($id);
        if(empty($fornecedor)) {
            abort(404, 'Fornecedor não encontrado.');
        }
        $fornecedor->servicos()->attach($request["servicos_id"]);
        return true;
    }

    public function DetachFornecedorAndServico(string | int $id, string | int $service_id) {
        $fornecedor = $this->GetByIdFornecedor($id);
        if(empty($fornecedor)) {
            abort(404, 'Fornecedor não encontrado.');
        }
        $fornecedor->servicos()->detach($service_id);
        return true;
    }
}
