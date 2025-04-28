<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FornecedorRepository;
use App\Http\Requests\FornecedorRequest;
use App\Http\Resources\FornecedorResource;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    protected $fornecedor,$FornecedorRepository;

    public function __construct(Fornecedor $fornecedor, FornecedorRepository $FornecedorRepository)
    {
        $this->fornecedor = $fornecedor;
        $this->FornecedorRepository = $FornecedorRepository;
    }

    public function index(Request $request) {
        try {
            $fornecedor = isset($request->filter)
                            ? $this->FornecedorRepository->listAndfilter($request->filter)
                            : $this->FornecedorRepository->listAndfilter();
            return FornecedorResource::collection($fornecedor);

         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao exibir a lista',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function show(string | int $id) {
        try {
            $fornecedor = $this->FornecedorRepository->GetByIdFornecedor($id);
            return new FornecedorResource($fornecedor);

         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao exibir a fornecedor',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function store(FornecedorRequest $request) {
        try {
            $this->FornecedorRepository->Create_Fornecedor($request->all());
            return response()->json(["success"=>"Fornecedor adicionado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao cadastrar Fornecedor',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function update(FornecedorRequest $request, string | int $id) {
        try {
            $this->FornecedorRepository->update_Fornecedor($request->all(),$id);
            return response()->json(["success"=>"Fornecedor atualizado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao atualizar Fornecedor',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function destroy(string | int $id) {
        try {
            $this->FornecedorRepository->Delete_Fornecedor($id);
            return response()->json(["success"=>"Fornecedor Deletado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao deleta fornecedor',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function fornecedorservicosall(string | int $id) {
        try {
            $servicos = $this->FornecedorRepository->FornecedorServicosGet($id);
            return response()->json(["data"=>$servicos],200);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao Vincular',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function attach(Request $request, string | int $id) {
        try {
            $this->FornecedorRepository->AttachFornecedorAndServico($id,$request->all());
            return response()->json(["success"=>"Serviço Vinculado ao Fornecedor"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao Vincular',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function detach(string | int $id,string | int $service_id) {
        try {
            $this->FornecedorRepository->DetachFornecedorAndServico($id,$service_id);
            return response()->json(["success"=>"Serviço Desvinculado ao Fornecedor"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao Desvincular',
                 'message' => $e->getMessage()
             ], 500);
         }
    }
}
