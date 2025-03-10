<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $userData = [
            [
                'name' => 'Pembeli 1',
                'email' => 'pembeli1@gmail.com',
                'role' => 'pembeli',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Petani 1',
                'email' => 'petani1@gmail.com',
                'role' => 'petani',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('123456')
            ],
            [
                'name' => 'superAdmin 1',
                'email' => 'superadmin1@gmail.com',
                'role' => 'superadmin',
                'password' => bcrypt('123456')
            ],
        ];
        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
