<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  



    public function up(): void
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('funcionario_id')->nullable();
            $table->string('numero_nota')->nullable();
            $table->date('data_entrada');
            $table->text('observacao')->nullable();

            $table->timestamps();

            $table->foreign('funcionario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};

