<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenSaleSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sales = [
            [
                'canteen_id' => 1,
                'buyer_type' => 'student',
                'buyer_id' => 1001, // ID santri
                'payment_method' => 'wallet',
                'auth_method' => 'fingerprint',
                'total_amount' => 13000.00,
                'paid' => true,
                'cashier_id' => 1,
                'transaction_time' => $now->subMinutes(10),
                'created_at' => $now->subMinutes(10),
                'updated_at' => $now->subMinutes(10),
            ],
            [
                'canteen_id' => 2,
                'buyer_type' => 'parent',
                'buyer_id' => 2002, // ID wali murid
                'payment_method' => 'wallet',
                'auth_method' => 'rfid',
                'total_amount' => 25000.00,
                'paid' => true,
                'cashier_id' => 1,
                'transaction_time' => $now->subMinutes(5),
                'created_at' => $now->subMinutes(5),
                'updated_at' => $now->subMinutes(5),
            ],
            [
                'canteen_id' => 4,
                'buyer_type' => 'guest',
                'buyer_id' => null,
                'payment_method' => 'cash',
                'auth_method' => 'manual',
                'total_amount' => 10000.00,
                'paid' => true,
                'cashier_id' => 1,
                'transaction_time' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_sales')->insert($sales);
    }
}
