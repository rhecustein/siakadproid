<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlJournalType;

class GlJournalTypeSeeder extends Seeder
{
    public function run(): void
    {
        GlJournalType::insert([
            ['code' => 'TOPUP', 'name' => 'Top-Up Manual', 'is_system' => true],
            ['code' => 'BILL', 'name' => 'Billing Tagihan', 'is_system' => true],
            ['code' => 'MANUAL', 'name' => 'Jurnal Manual', 'is_system' => false],
            ['code' => 'TRANSFER', 'name' => 'Transfer Antar Wallet', 'is_system' => true],
        ]);
    }
}
