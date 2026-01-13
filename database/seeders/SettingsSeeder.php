<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ventas, compras, inventario, usuarios
        $modules = ['sales', 'purchases', 'warehouse', 'access','reports'];

        foreach ($modules as $module) {
            Setting::create([
                'key' => "modules.$module",
                'value' => true
            ]);
        }

    }
}
