<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'INV RODAS', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'DALIA', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'SUDAMERIS', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'CLEANING & QUALITY', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'GD HNOS SAC', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'KAZVEL', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'RIVELSA', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'TERRAPLASTIC', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'FERRETERIA JR', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'PROMART', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'LIMPIEZA UNIVERSAL B&J', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'ART LIM NEYRA MOGOLLON', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
            ['name' => 'CHASQUI', 'ruc' => null, 'phone' => null, 'email' => null, 'address' => null],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
