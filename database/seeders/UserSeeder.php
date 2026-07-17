<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@coole-bill.local',
            'username' => 'admin',
            'password' => Hash::make('1'),
            'role' => 'admin',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@coole-bill.local',
            'username' => 'kasir',
            'password' => Hash::make('1'),
            'role' => 'kasir',
        ]);
    }
}