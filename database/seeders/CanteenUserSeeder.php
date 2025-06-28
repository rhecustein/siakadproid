<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CanteenUserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $assignments = [
            [
                'user_id' => 1, // super admin
                'canteen_id' => 1,
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2, // manajer putra
                'canteen_id' => 1,
                'role' => 'manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 3, // kasir 1
                'canteen_id' => 1,
                'role' => 'cashier',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 4, // kasir 2
                'canteen_id' => 2,
                'role' => 'cashier',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 5, // manajer SMP
                'canteen_id' => 3,
                'role' => 'manager',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('canteen_users')->insert($assignments);
    }
}
