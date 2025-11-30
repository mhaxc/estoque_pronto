<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrada_produtos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('entrada_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade');

            $table->timestamps();

            $table->foreign('entrada_id')
                  ->references('id')->on('entradas')
                  ->onDelete('cascade');

            $table->foreign('produto_id')
                  ->references('id')->on('produtos')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrada_produtos');
    }
};