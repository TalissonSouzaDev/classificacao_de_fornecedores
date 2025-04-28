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
            return [];
        }
        $arrayfornecedor = [];
        foreach($fornecedors as $fornecedorss) {
            $array = [];
            $classificacao = $this->classificacao_fornecedor->where('fornecedor_id', $fornecedorss->id)->latest('created_at')->first();
            $ApiGoogleMaps = $googleapi->getDistance($fornecedorss->cep_sede,$request['cep_demanda']);
            $array["fornecedor_id"] = $fornecedorss->id;
            $array["distanciavalue"] = $ApiGoogleMaps["rows"][0]["elements"][0]["distance"]["value"];
            $array["distanciakm"] = $ApiGoogleMaps["rows"][0]["elements"][0]["distance"]["text"];
            if ($classificacao && $classificacao->created_at) {
                $array["justificativa"] = "Ultima demanda realizada em ". $classificacao->created_at->format('Y-m-d');
                $array["data_demanda"] = $classificacao->created_at->format('Y-m-d');
            }  else {
                $array["justificativa"] = "Ainda não foi classificado.";
                $array["data_demanda"] = "0000/00/00";
            }
            $array["posicao"] = $classificacao->posicao ?? 0;
            $arrayfornecedor[] = $array;
        }

        $datasdistancia = collect($arrayfornecedor)
                                ->sortByDesc('data_demanda')
                                ->sortBy('distanciavalue')
                                ->groupBy('distanciavalue')
                                ->filter(function ($group) {
                                    return $group->count() > 1;
                                })->flatten(1);

        $nãodatasdistancia = collect($arrayfornecedor)
                                ->sortByDesc('data_demanda')
                                ->sortBy('distanciavalue')
                                ->groupBy('distanciavalue')
                                ->filter(function ($group) {
                                    return $group->count() == 1;
                                })
                                ->flatten(1);


            $countelement = count($datasdistancia) + 1;
            $arrayelemente = [];
            foreach ($datasdistancia as $distancia) {
                $distancia["posicao"] = $countelement - $distancia["posicao"];
                $arrayelemente[] = $distancia;
            }
        $arrysuni = array_merge($arrayelemente, $nãodatasdistancia->toArray());
        $collectionresponse = collect($arrysuni)->sortBy('posicao');

        return $collectionresponse;
    }

    public function createclassificacaofornecedor($request) {
        $fornecedors = $this->ETLFornecedors($request);
        foreach($fornecedors as $key => $fornecedor) {
            $posicao = $fornecedor["posicao"] == 0 ? $key+1 : $fornecedor["posicao"];
            $this->classificacao_fornecedor->create([
                "fornecedor_id" => $fornecedor["fornecedor_id"],
                "demanda_id"    => $request["id"],
                "posicao"       => $posicao,
                "justificativa" => $fornecedor["justificativa"],
                "distancia_km"  => $fornecedor["distanciakm"],
                "distancia_value"=> $fornecedor["distanciavalue"]
            ]);
        }
    }

    public function GetClassificacaoFornecedor($demandaId) {
        $classificacao = $this->classificacao_fornecedor->with(["demanda", "fornecedor"])->where("demanda_id", $demandaId)
                                                        ->orderBy("posicao", "asc")->get();
        return $classificacao;
    }
}
