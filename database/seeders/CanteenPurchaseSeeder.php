<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenPurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $purchases = [
            [
                'canteen_id' => 1,
                'supplier_id' => 1, // contoh supplier ID 1
                'total_price' => 350000.00,
                'status' => 'received',
                'created_by' => 1,
                'approved_by' => 2,
                'received_date' => $now->subDays(3),
                'note' => 'Pembelian awal untuk stok Es Teh dan Mie',
                'created_at' => $now->subDays(4),
                'updated_at' => $now->subDays(3),
            ],
            [
                'canteen_id' => 2,
                'supplier_id' => 2,
                'total_price' => 210000.00,
                'status' => 'approved',
                'created_by' => 1,
                'approved_by' => 2,
                'received_date' => null,
                'note' => 'Pesanan Nasi Kuning belum diterima',
                'created_at' => $now->subDays(2),
                'updated_at' => $now->subDays(1),
            ],
            [
                'canteen_id' => 3,
                'supplier_id' => 3,
                'total_price' => 95000.00,
                'status' => 'draft',
                'created_by' => 1,
                'approved_by' => null,
                'received_date' => null,
                'note' => 'Rencana pengadaan Aqua Botol',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_purchases')->insert($purchases);
    }
}
