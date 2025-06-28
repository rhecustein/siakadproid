<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenSaleItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            // Transaksi 1: Es Teh + Mie Goreng
            [
                'canteen_sale_id' => 1,
                'canteen_product_id' => 1, // Es Teh Manis
                'quantity' => 1,
                'price' => 3000.00,
                'subtotal' => 3000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'canteen_sale_id' => 1,
                'canteen_product_id' => 2, // Mie Goreng
                'quantity' => 1,
                'price' => 10000.00,
                'subtotal' => 10000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Transaksi 2: Nasi Kuning ×2
            [
                'canteen_sale_id' => 2,
                'canteen_product_id' => 3, // Nasi Kuning
                'quantity' => 2,
                'price' => 12500.00,
                'subtotal' => 25000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Transaksi 3: Snack Taro
            [
                'canteen_sale_id' => 3,
                'canteen_product_id' => 5, // Snack Taro
                'quantity' => 2,
                'price' => 5000.00,
                'subtotal' => 10000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_sale_items')->insert($items);
    }
}
