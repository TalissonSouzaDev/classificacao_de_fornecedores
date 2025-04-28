<?php

use App\Http\Controllers\API\DemandaController;
use App\Http\Controllers\API\FornecedorController;
use App\Http\Controllers\API\ServiceController;
use App\Services\GoogleMapsService;
use App\Services\ViaCep;
use Illuminate\Support\Facades\Route;


Route::prefix("/fornecedor")->group(function() {
    Route::get("/index",[FornecedorController::class,"index"]);
    Route::post("/store",[FornecedorController::class,"store"]);
    Route::put("/update/{id}",[FornecedorController::class,"update"]);
    Route::delete("/destroy/{id}",[FornecedorController::class,"destroy"]);
    Route::get("/{id}/servicos",[FornecedorController::class,"fornecedorservicosall"]);
    Route::post("/attach/{id}",[FornecedorController::class,"attach"]);
    Route::delete("/{id}/detach/{servico_id}",[FornecedorController::class,"detach"]);
});

 Route::prefix("/servico")->group(function() {
     Route::get("/index",[ServiceController::class,"index"]);
     Route::post("/store",[ServiceController::class,"store"]);
     Route::put("/update/{id}",[ServiceController::class,"update"]);
     Route::delete("/destroy/{id}",[ServiceController::class,"destroy"]);
 });

Route::prefix("/demanda")->group(function() {
    Route::get("/index",[DemandaController::class,"index"]);
    Route::get("/{id}",[DemandaController::class,"show"]);
    Route::post("/store",[DemandaController::class,"store"]);
    Route::put("/update/{id}",[DemandaController::class,"update"]);
    Route::delete("/destroy/{id}",[DemandaController::class,"destroy"]);

    /** Classificação dos forncedores para demanda */
    Route::get("/{iddemanda}/classificacao",[DemandaController::class,"classificacaofornecedor"]);
});

Route::get("/viacep/{cep}",function($cep){
    $viacep = ViaCep::GetCep($cep);
    return response()->json($viacep);
});
Route::get("/google/{cep}/{rr}",function($oo,$rr){
    $google = new GoogleMapsService();
    $response = $google->getDistance($oo,$rr);
    return response()->json($response);
});

