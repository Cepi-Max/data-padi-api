<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'foto_profil' => null,
            ],
            [
                'name' => 'Admin Desa',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'foto_profil' => null,
            ],
            [
                'name' => 'Pak Petani',
                'email' => 'petani@example.com',
                'password' => Hash::make('password123'),
                'role' => 'petani',
                'foto_profil' => null,
            ],
            [
                'name' => 'Mas Pembeli',
                'email' => 'pembeli@example.com',
                'password' => Hash::make('password123'),
                'role' => 'pembeli',
                'foto_profil' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
