<?php

namespace Database\Seeders;

use App\Models\CanteenProduct;
use App\Models\CanteenProductCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CanteenProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $categories = CanteenProductCategory::pluck('id', 'name');

        $products = [
            [
                'canteen_id' => 1,
                'name' => 'Es Teh Manis',
                'sku' => 'KMN001',
                'category_name' => 'Minuman',
                'price' => 3000.00,
                'stock' => 100,
                'reorder_point' => 20,
                'unit' => 'gelas',
            ],
            [
                'canteen_id' => 1,
                'name' => 'Mie Goreng',
                'sku' => 'KMN002',
                'category_name' => 'Makanan Berat',
                'price' => 7000.00,
                'stock' => 50,
                'reorder_point' => 10,
                'unit' => 'porsi',
            ],
            [
                'canteen_id' => 2,
                'name' => 'Nasi Kuning',
                'sku' => 'KPT001',
                'category_name' => 'Makanan Berat',
                'price' => 8000.00,
                'stock' => 30,
                'reorder_point' => 5,
                'unit' => 'bungkus',
            ],
            [
                'canteen_id' => 3,
                'name' => 'Aqua Botol 600ml',
                'sku' => 'KSMP001',
                'category_name' => 'Minuman',
                'price' => 4000.00,
                'stock' => 60,
                'reorder_point' => 10,
                'unit' => 'botol',
            ],
            [
                'canteen_id' => 4,
                'name' => 'Snack Taro',
                'sku' => 'KUM001',
                'category_name' => 'Makanan Ringan',
                'price' => 5000.00,
                'stock' => 40,
                'reorder_point' => 10,
                'unit' => 'paket',
            ],
        ];

        foreach ($products as $data) {
            $categoryId = $categories[$data['category_name']] ?? null;

            if (!$categoryId) {
                throw new \Exception("Kategori '{$data['category_name']}' tidak ditemukan. Harap jalankan seeder kategori terlebih dahulu.");
            }

            CanteenProduct::create([
                'canteen_id'     => $data['canteen_id'],
                'category_id'    => $categoryId,
                'name'           => $data['name'],
                'sku'            => $data['sku'],
                'price'          => $data['price'],
                'stock'          => $data['stock'],
                'reorder_point'  => $data['reorder_point'],
                'unit'           => $data['unit'],
                'is_active'      => true,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
