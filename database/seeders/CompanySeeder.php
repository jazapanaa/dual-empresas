<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'My Company',
            'address' => '123 Main St, Cityville',
            'phone' => '123-456-7890',
            'email' => 'luis.mayta@gmail.com',
            'website' => 'https://example.com',
            'logo' => 'https://example.com/logo.png',
        ]);
    }
}
