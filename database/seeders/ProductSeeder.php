<?php

namespace Database\Seeders;

use App\Models\Ricesales\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'user_id' => '1',
                'name' => 'Padi Rias',
                'description' => 'Padi dengan pupuk kandang',
                'price' => '30000.00',
                'stock' => '80',
                'image' => null,
            ],
            [
                'user_id' => '2',
                'name' => 'Padi Bangka Selatan',
                'description' => 'Padi dengan pupuk organik',
                'price' => '50000.00',
                'stock' => '90',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
