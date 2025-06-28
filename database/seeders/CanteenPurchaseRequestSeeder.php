<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenPurchaseRequestSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $requests = [
            [
                'canteen_id' => 1,
                'requester_id' => 1, // ID user/kasir
                'description' => 'Permintaan stok Es Teh dan Mie tambahan untuk liburan',
                'status' => 'approved',
                'requested_date' => $now->subDays(5),
                'created_at' => $now->subDays(5),
                'updated_at' => $now->subDays(3),
            ],
            [
                'canteen_id' => 2,
                'requester_id' => 2,
                'description' => 'Stok Nasi Kuning habis, mohon pengadaan 30 porsi',
                'status' => 'pending',
                'requested_date' => $now->subDays(2),
                'created_at' => $now->subDays(2),
                'updated_at' => $now->subDays(2),
            ],
            [
                'canteen_id' => 3,
                'requester_id' => 3,
                'description' => 'Permintaan Aqua Botol 600ml tidak disetujui karena anggaran',
                'status' => 'rejected',
                'requested_date' => $now->subDays(1),
                'created_at' => $now->subDays(1),
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_purchase_requests')->insert($requests);
    }
}
