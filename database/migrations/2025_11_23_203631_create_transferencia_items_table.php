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
        Schema::create('transferencia_items', function (Blueprint $table) {
            
        $table->id();
        $table->foreignId('transferencia_id')->constrained('transferencias')->onDelete('cascade');
        $table->foreignId('produto_id')->constrained('produtos');
        $table->integer('quantidade');
        $table->timestamps();
        $table->foreign('transferencia_id')->references('id')->on('transferencias')->onDelete('cascade');
        $table->foreign('produto_id')->references('id')->on('produtos');
        });
          
    
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencia_items');
    }
};
