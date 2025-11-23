<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
Schema::create('saidas', function (Blueprint $table) {
$table->id();
$table->foreignId('funcionario_id')->constrained('funcionarios')->cascadeOnDelete();
$table->date('data_saida');
$table->text('observacao')->nullable();
$table->timestamps();
});
}


public function down(): void
{
Schema::dropIfExists('saidas');
}
};
