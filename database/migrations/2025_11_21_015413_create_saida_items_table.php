<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saida_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('saida_id')
                  ->constrained('saidas')
                  ->onDelete('cascade'); 
            // Se excluir a saída → exclui itens automaticamente

            $table->foreignId('produto_id')
                  ->constrained('produtos')
                  ->onDelete('restrict'); 
            // Não deixa excluir produto se tiver saída cadastrada
            // (bom para integridade)

            $table->integer('quantidade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saida_items');
    }
};
