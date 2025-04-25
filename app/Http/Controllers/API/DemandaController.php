<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\DemandaRepository;
use App\Http\Requests\DemandaRequest;
use App\Http\Resources\DemandaResource;
use Illuminate\Http\Request;

class DemandaController extends Controller
{
    protected $DemandaRepository;

    public function __construct(DemandaRepository $DemandaRepository)
    {
        $this->DemandaRepository = $DemandaRepository;
    }

    public function index(Request $request) {
        try {
            $Demanda = $this->DemandaRepository->listAndfilter($request->filter);
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

    public function update(DemandaRequest $request, string | int $id) {
        try {
            $this->DemandaRepository->updateDemanda($request->all(),$id);
            return response()->json(["success"=>"Demanda atualizado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao atualizar demanda',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function destroy(string | int $id) {
        try {
            $this->DemandaRepository->DeleteDemanda($id);
            return response()->json(["success"=>"Demanda Deletado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao deleta demanda',
                 'message' => $e->getMessage()
             ], 500);
         }
    }
}
