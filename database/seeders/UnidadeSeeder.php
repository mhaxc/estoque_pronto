<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    public function run()
    {
        $unidades = [
            ['nome' => 'Unidade', 'sigla' => 'UN'],
            ['nome' => 'Peça', 'sigla' => 'PC'],
            ['nome' => 'Metro', 'sigla' => 'MT'],
            ['nome' => 'Quilograma', 'sigla' => 'KG'],
            ['nome' => 'Litro', 'sigla' => 'LT'],
            ['nome' => 'Caixa', 'sigla' => 'CX'],
            ['nome' => 'Pacote', 'sigla' => 'PT'],
            ['nome' => 'Canos', 'sigla' => 'CN'],
        ];

        foreach ($unidades as $unidade) {
            Unidade::create($unidade);
        }
    }
}