<?php

namespace Database\Seeders;

use App\Models\Ricesales\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        // Buat produk contoh
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

        // Insert semua produk ke database
        DB::table('products')->insert($products);
        
        // Ambil ID metode pembayaran yang ada
        $paymentMethodIds = DB::table('payment_methods')->pluck('id')->toArray();
        
        // Ambil ID produk yang baru dimasukkan
        $productIds = DB::table('products')->pluck('id')->toArray();

        // Hubungkan setiap produk dengan metode pembayaran yang tersedia
        $productPaymentData = [];
        foreach ($productIds as $productId) {
            foreach ($paymentMethodIds as $paymentMethodId) {
                $productPaymentData[] = [
                    'product_id' => $productId,
                    'payment_method_id' => $paymentMethodId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        // Insert ke tabel product_payment_methods
        DB::table('product_payment_methods')->insert($productPaymentData);
    }
}
