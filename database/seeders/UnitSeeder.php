<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('units')->insert([
            [
                'code' => 'unit',
                'description' => 'Unidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'kg',
                'description' => 'Kilogramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'g',
                'description' => 'Gramo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'l',
                'description' => 'Litro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ml',
                'description' => 'Mililitro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'box',
                'description' => 'Caja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'pack',
                'description' => 'Paquete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'm',
                'description' => 'Metro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'cm',
                'description' => 'Centímetro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'pair',
                'description' => 'Par',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
