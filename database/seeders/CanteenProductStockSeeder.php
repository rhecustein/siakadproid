<?php

namespace Database\Seeders;

use App\Models\CanteenProduct;
use App\Models\CanteenProductStock;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CanteenProductStockSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $creator = 1; // Misal ID user admin

        // Ambil semua produk yang sudah di-seed
        $products = CanteenProduct::all();

        foreach ($products as $product) {
            CanteenProductStock::create([
                'canteen_product_id' => $product->id,
                'stock_in' => $product->stock,
                'stock_out' => 0,
                'stock_type' => 'initial',
                'reference_type' => null,
                'reference_id' => null,
                'note' => 'Stok awal untuk produk: ' . $product->name,
                'created_by' => $creator,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
