<?php

namespace Database\Seeders;

use App\Models\DataPadi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPadiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datapadi = [
            [
                'nama' => 'Padi Rias',
                'jumlah_padi' => '200',
                'jenis_padi' => 'Padi Cianjur',
                'latitude' => '19002322',
                'longitude' => '876456456',
                'foto_padi' => null,
            ],
            [
                'nama' => 'Padi Cianjur',
                'jumlah_padi' => '900',
                'jenis_padi' => 'Padi Bangka',
                'latitude' => '19002322',
                'longitude' => '876456456',
                'foto_padi' => null,
            ],
        ];

        foreach ($datapadi as $padi) {
            DataPadi::create($padi);
        }
    }
}
