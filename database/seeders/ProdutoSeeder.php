<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Produto;


use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produtos')->insert([
            [
                'nome' => 'Areia Média',
                'descricao' => 'Areia média lavada',
                'categoria_id' => 1,
                'unidade_id' => 1,
                'preco' => 150.00,
                'estoque_minimo' => 10,
                'estoque_atual' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Areia Fina',
                'descricao' => 'Areia fina peneirada',
                'categoria_id' => 1,
                'unidade_id' => 1,
                'preco' => 140.00,
                'estoque_minimo' => 8,
                'estoque_atual' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Brita 1',
                'descricao' => 'Brita 1 para concreto',
                'categoria_id' => 2,
                'unidade_id' => 1,
                'preco' => 180.00,
                'estoque_minimo' => 15,
                'estoque_atual' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Brita 0',
                'descricao' => 'Brita 0 para acabamento',
                'categoria_id' => 2,
                'unidade_id' => 1,
                'preco' => 170.00,
                'estoque_minimo' => 12,
                'estoque_atual' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Pedrisco',
                'descricao' => 'Pedrisco para drenagem',
                'categoria_id' => 2,
                'unidade_id' => 1,
                'preco' => 160.00,
                'estoque_minimo' => 10,
                'estoque_atual' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
