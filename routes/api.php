<?php

use App\Http\Controllers\API\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::prefix("fornecedor")->group(function() {
//     Route::get("/list",FornecedorController::class,"index");
//     Route::get("/{id}",FornecedorController::class,"show");
//     Route::post("/store",FornecedorController::class,"store");
//     Route::put("/update/{id}",FornecedorController::class,"update");
//     Route::delete("/destroy/{id}",FornecedorController::class,"destroy");
//     Route::post("/attach/{id}",FornecedorController::class,"attach");
//     Route::delete("/{id}/detach/{service_id}",FornecedorController::class,"detach");
// });

// Route::prefix("servico")->group(function() {
//     Route::get("/list",ServicoController::class,"index");
//     Route::get("/{id}",ServicoController::class,"show");
//     Route::post("/store",ServicoController::class,"store");
//     Route::put("/update/{id}",ServicoController::class,"update");
//     Route::delete("/destroy/{id}",ServicoController::class,"destroy");
// });

// Route::prefix("demanda")->group(function() {
//     Route::get("/list",DemandaController::class,"index");
//     Route::get("/{id}",DemandaController::class,"show");
//     Route::post("/store",DemandaController::class,"store");
//     Route::put("/update/{id}",DemandaController::class,"update");
//     Route::delete("/destroy/{id}",DemandaController::class,"destroy");
// });