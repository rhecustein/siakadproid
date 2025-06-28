<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenPurchaseItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $items = [
            // Pembelian ID 1 - Sudah diterima
            [
                'canteen_purchase_id' => 1,
                'canteen_product_id' => 1, // Es Teh Manis
                'quantity' => 100,
                'unit_price' => 2500.00,
                'subtotal' => 250000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'canteen_purchase_id' => 1,
                'canteen_product_id' => 2, // Mie Goreng
                'quantity' => 50,
                'unit_price' => 2000.00,
                'subtotal' => 100000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Pembelian ID 2 - Disetujui tapi belum diterima
            [
                'canteen_purchase_id' => 2,
                'canteen_product_id' => 3, // Nasi Kuning
                'quantity' => 30,
                'unit_price' => 7000.00,
                'subtotal' => 210000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Pembelian ID 3 - Draft
            [
                'canteen_purchase_id' => 3,
                'canteen_product_id' => 4, // Aqua Botol
                'quantity' => 20,
                'unit_price' => 4750.00,
                'subtotal' => 95000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_purchase_items')->insert($items);
    }
}
