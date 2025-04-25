<?php
namespace App\Http\Repositories;

use App\Models\Demanda;

class DemandaRepository {

    protected $demanda,$ServicoRepository;

    public function __construct(Demanda $demanda, ServicoRepository $ServicoRepository)
    {
        $this->demanda = $demanda;
        $this->ServicoRepository = $ServicoRepository;
    }

    public function listAndfilter(string $filter = "") {
        if(empty($filter)) {
            $response = $this->demanda->latest()->paginate(10);
            return $response;
        }
        $response = $this->demanda->where("name","LIKE","%{$filter}%")
                                    ->where("cep_demanda","LIKE","%{$filter}%")
                                    ->paginate(10);
        return $response;                       
    }

    public function GetByIddemanda(string | int $iddemanda) {
        if(!empty($iddemanda)) {
            $getdemanda = $this->demanda->where("id",$iddemanda)->first();
            return $getdemanda;
        }
    }

    public function Createdemanda(array $request) {
        $service = $this->ServicoRepository->GetByIdServico($request["service_id"]);
        if(empty($service)) {
            return false;
        }
        $demandacreate = $this->demanda->create([
            "name" => $request["name"],
            "cep_demanda" => $request["cep_demanda"],
            "service_id" => $service["id"]
        ]);

        return $demandacreate ? true : false;
    }

    public function Updatedemanda(array $request, string | int $id) {
        $demandaupdate = false;
        $service = $this->ServicoRepository->GetByIdServico($request["service_id"]);
        if(empty($service)) {
            return false;
        }
        $demanda = $this->GetByIddemanda($id);
        if(!empty($demanda)) {
            $demandaupdate = $demanda->update([
                "name" => $request["name"],
                "cep_demanda" => $request["cep_demanda"],
                "service_id" => $service["id"]
            ]);
        }
        return $demandaupdate ? true : false;
    }

    public function Deletedemanda(string | int $id) {
        $demandadelete = false;
        $demanda = $this->GetByIddemanda($id);
        if(!empty($demanda)) {
            $demandadelete = $demanda->delete();
        }
        return $demandadelete ? true : false;
    }

}