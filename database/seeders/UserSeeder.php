<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@alfasoft.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
