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
        Schema::create('fornecedors_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servico_id')->constrained("servicos")->onDelete('cascade');
            $table->foreignId('fornecedor_id')->constrained("fornecedors")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
