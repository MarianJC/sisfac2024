<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Eu Prueba',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password')
            ]
        ]);
    }
}
