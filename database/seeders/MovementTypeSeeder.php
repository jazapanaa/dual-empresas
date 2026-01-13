<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('movement_types')->insert([
            [
                'name' => 'Entrada',
                'description' => 'Entrada de productos',
            ],
            [
                'name' => 'Salída',
                'description' => 'Saída de productos',
            ],
        ]);
    }
}
