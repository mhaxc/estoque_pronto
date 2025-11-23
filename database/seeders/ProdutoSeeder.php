<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Produto;


class ProdutoSeeder extends Seeder
{
public function run(): void
{
Produto::factory()->count(10)->create();
}
};