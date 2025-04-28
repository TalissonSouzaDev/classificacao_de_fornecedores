<?php
namespace App\Http\Repositories;

use App\Models\Demanda;

class DemandaRepository {

    protected $demanda,$ServicoRepository,$ClassificacaofornecedorRepository;

    public function __construct(Demanda $demanda, ServicoRepository $ServicoRepository,ClassificacaofornecedorRepository $ClassificacaofornecedorRepository)
    {
        $this->demanda = $demanda;
        $this->ServicoRepository = $ServicoRepository;
        $this->ClassificacaofornecedorRepository = $ClassificacaofornecedorRepository;
    }

    public function listAndfilter() {
            $response = $this->demanda->latest()->get();
            return $response;
    }

    public function GetByIddemanda(string | int $iddemanda) {
        if(!empty($iddemanda)) {
            $getdemanda = $this->demanda->where("id",$iddemanda)->first();
            return $getdemanda ?? [];
        }
    }

    public function Createdemanda($request) {
        $service = $this->ServicoRepository->GetByIdServico($request["servico_id"]);
        if(empty($service)) {
            return false;
        }
        $demandacreate = $this->demanda->create([
            "name" => $request["name"],
            "cep_demanda" => $request["cep_demanda"],
            "servico_id" => $service["id"]
        ]);
        if($demandacreate) {
            $demandacreate = $this->ClassificacaofornecedorRepository->createclassificacaofornecedor($demandacreate);
        }
        return $demandacreate ? true : false;
    }

}
