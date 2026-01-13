<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
                'name' => 'Luis Mayta',
                'email' => 'luis.mayta@gmail.com',
                'active' => true,
                'password' => Hash::make('41887192')
            ]
        )->assignRole('administrator');
        User::Create([
                'name' => 'Jesus Zapana',
                'email' => 'jazapanaa@gmail.com',
                'active' => true,
                'password' => Hash::make('40269628')

            ]
        )->assignRole('administrator');

        User::Create([
                'name' => 'Lucy Sanchez',
                'email' => 'lucy@gmail.com',
                'active' => true,
                'password' => Hash::make('41253675')

            ]
        )->assignRole('Warehouse Clerk');



    }
}
