<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create(['nome' => 'Eletrônicos']);
        Categoria::create(['nome' => 'Móveis']);
        Categoria::create(['nome' => 'Alimento']);
        Categoria::create(['nome' => 'Canos']);
        Categoria::create(['nome' => 'Cimento']);
        Categoria::create(['nome' => 'Pvc']);

    }
}
