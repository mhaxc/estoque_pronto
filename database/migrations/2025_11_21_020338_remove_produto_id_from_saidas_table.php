<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up()
{
    Schema::table('saidas', function (Blueprint $table) {
        if (Schema::hasColumn('saidas', 'produto_id')) {
            $table->dropForeign(['produto_id']);
            $table->dropColumn('produto_id');
        }
    });
}

public function down()
{
    Schema::table('saidas', function (Blueprint $table) {
        $table->foreignId('produto_id')->constrained('produtos');
    });
}

};
