<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
Schema::create('saida_items', function (Blueprint $table) {
$table->id();
$table->foreignId('saida_id')->constrained('saidas')->cascadeOnDelete();
$table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
$table->integer('quantidade');
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('saida_items');
}
};