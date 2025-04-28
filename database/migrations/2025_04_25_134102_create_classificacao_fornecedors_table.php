<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classificacao_fornecedors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedor_id')->constrained("fornecedors")->onDelete('cascade');
            $table->foreignId('demanda_id')->constrained("demadas")->onDelete('cascade');
            $table->integer("posicao");
            $table->string("justificativa");
            $table->string("distancia_km");
            $table->float("distancia_value");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificacao_fornecedors');
    }
};
