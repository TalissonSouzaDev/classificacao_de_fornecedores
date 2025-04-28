<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ServicoRepository;
use App\Http\Requests\ServicoRequest;
use App\Http\Resources\ServicoResource;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $ServicoRepository,$ClassificacaofornecedorRepository;

    public function __construct(ServicoRepository $ServicoRepository)
    {
        $this->ServicoRepository = $ServicoRepository;
    }

    public function index(Request $request) {
        try {

            $servico = isset($request->filter)
                        ? $this->ServicoRepository->listAndfilter($request->filter)
                        : $this->ServicoRepository->listAndfilter();
            return ServicoResource::collection($servico);

         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao exibir a lista',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function store(ServicoRequest $request) {
        try {
            $this->ServicoRepository->CreateServico($request->all());
            return response()->json(["success"=>"serviço adicionado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao cadastrar serviço',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function update(ServicoRequest $request, string | int $id) {
        try {
            $this->ServicoRepository->updateServico($request->all(),$id);
            return response()->json(["success"=>"serviço atualizado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao atualizar serviço',
                 'message' => $e->getMessage()
             ], 500);
         }
    }

    public function destroy(string | int $id) {
        try {
            $this->ServicoRepository->DeleteServico($id);
            return response()->json(["success"=>"serviço Deletado com sucesso"],201);
         } catch (\Exception $e) {
             return response()->json([
                 'error' => 'Erro ao deleta serviço',
                 'message' => $e->getMessage()
             ], 500);
         }
    }
}
