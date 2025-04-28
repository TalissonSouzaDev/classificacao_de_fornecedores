<?php
namespace App\Http\Repositories;

use App\Models\classificacao_fornecedor;
use App\Models\Servico;
use App\Services\GoogleMapsService;

class ClassificacaofornecedorRepository {

    protected $servico,$classificacao_fornecedor;
    public function __construct(Servico $servico,classificacao_fornecedor $classificacao_fornecedor)
    {
        $this->servico = $servico;
        $this->classificacao_fornecedor = $classificacao_fornecedor;
    }

    public function ETLFornecedors($request){
        $googleapi = new GoogleMapsService();
        $servico = $this->servico->where("id",$request["servico_id"])->first();
        $fornecedors = $servico->Fornecedor->all();
        if(!$fornecedors) {
            dd("não ha fornecedor para esse serviço");
        }
        $arrayfornecedor = [];
        foreach($fornecedors as $fornecedorss) {
            $array = [];
            $ApiGoogleMaps = $googleapi->getDistance($fornecedorss->cep_sede,$request['cep_demanda']);
            $array["fornecedor_id"] = $fornecedorss->id;
            $array["distanciavalue"] = $ApiGoogleMaps["rows"][0]["elements"][0]["distance"]["value"];
            $array["distanciakm"]= $ApiGoogleMaps["rows"][0]["elements"][0]["distance"]["text"];
            $arrayfornecedor[] = $array;
        }

        $response = collect($arrayfornecedor)->sortBy("distanciavalue")->groupBy('distanciavalue')
                                             ->map(function ($group) {
                                                if ($group->count() > 1) {
                                                    return $group->shuffle();
                                                }
                                                return $group;
                                             })->flatten(1);
        return $response;
    }

    public function createclassificacaofornecedor($request) {
        $fornecedors = $this->ETLFornecedors($request);
        foreach($fornecedors as $key => $fornecedor) {
            $this->classificacao_fornecedor->create([
                "fornecedor_id" => $fornecedor["fornecedor_id"],
                "demanda_id"    => $request["id"],
                "posicao"       => $key + 1,
                "justificativa" => "???????",
                "distancia_km"  => $fornecedor["distanciakm"],
                "distancia_value"=> $fornecedor["distanciavalue"]
            ]);
        }
    }

    public function GetClassificacaoFornecedor($demandaId) {
        $classificacao = $this->classificacao_fornecedor
    ->with(["demanda", "fornecedor"])
    ->where("demanda_id", $demandaId)
    ->orderBy("posicao", "asc")
    ->get();
    return $classificacao;
    }
}
