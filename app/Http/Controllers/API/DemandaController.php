<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ClassificacaofornecedorRepository;
use App\Http\Repositories\DemandaRepository;
use App\Http\Requests\DemandaRequest;
use App\Http\Resources\ClassificacaoFornecedorResource;
use App\Http\Resources\DemandaResource;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    protected $DemandaRepository,$ClassificacaofornecedorRepository;

    public function __construct(DemandaRepository $DemandaRepository,ClassificacaofornecedorRepository $ClassificacaofornecedorRepository)
    {
        $this->DemandaRepository = $DemandaRepository;
        $this->ClassificacaofornecedorRepository = $ClassificacaofornecedorRepository;
    }

    public function index(Request $request) {
        try {
            $Demanda = $this->DemandaRepository->listAndfilter();
            return DemandaResource::collection($Demanda);

         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao exibir a lista',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function show(string | int $id) {
        try {
            $Demanda = $this->DemandaRepository->GetByIdDemanda($id);
            return new DemandaResource($Demanda);

         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao exibir a Demanda',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function store(DemandaRequest $request) {
        try {
            $this->DemandaRepository->CreateDemanda($request->all());
            return response()->json(["success"=>"Demanda adicionado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao cadastrar Demanda',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function classificacaofornecedor(string | int $idDemanda) {
        if(empty($idDemanda)) {

        }
        $classificacao = $this->ClassificacaofornecedorRepository->GetClassificacaoFornecedor($idDemanda);
        return ClassificacaoFornecedorResource::collection($classificacao);

    }
}
