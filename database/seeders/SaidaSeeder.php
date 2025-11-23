<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Saida;
use App\Models\SaidaItem;
use App\Models\Produto;
use App\Models\Funcionario;


class SaidaSeeder extends Seeder
{
public function run(): void
{
$produtos = Produto::all();
$funcionarios = Funcionario::all();


Saida::factory()->count(10)->create()->each(function($saida) use ($produtos) {
foreach (range(1, rand(1,4)) as $i) {
SaidaItem::create([
'saida_id' => $saida->id,
'produto_id' => $produtos->random()->id,
'quantidade' => rand(1, 10),
]);
}
});
}
};