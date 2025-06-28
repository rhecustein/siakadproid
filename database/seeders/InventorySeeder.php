<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Room;
use App\Models\InventoryType;
use App\Models\InventoryCondition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();
        $types = InventoryType::all();
        $conditions = InventoryCondition::all();

        if ($rooms->isEmpty() || $types->isEmpty()) return;

        $items = [
            'Meja Siswa', 'Kursi Guru', 'Proyektor Epson', 'Lemari Arsip', 'Whiteboard Magnetik',
            'Speaker Aktif', 'TV LED 32\"', 'AC Split', 'Komputer All-in-One', 'Printer Canon',
            'Router Mikrotik', 'Rak Buku', 'Scanner Epson', 'Kabel HDMI', 'Laptop Dell',
            'Stop Kontak', 'Kipas Angin', 'Mikrofon Wireless', 'Rak Sepatu', 'Bangku Besi',
            'Dispenser', 'Meja Rapat', 'Lampu LED', 'Smart TV', 'Modem Internet', 'Switch Hub',
            'Papan Tulis Kaca', 'Jam Dinding', 'Scanner Barcode', 'Alarm Sekolah'
        ];

        foreach ($items as $i => $name) {
            $type = $types->random();
            $condition = $conditions->random();
            $room = $rooms->random();

            $isElectronic = $type->is_electronic;
            $economicLife = $type->economic_life ?? rand(3, 8);

            Inventory::create([
                'name' => $name,
                'code' => strtoupper(Str::slug($name, '-') . '-' . ($i + 100)),
                'room_id' => $room->id,
                'inventory_type_id' => $type->id,
                'inventory_condition_id' => $condition->id,
                'quantity' => rand(1, 10),
                'is_electronic' => $isElectronic,
                'acquired_at' => now()->subYears(rand(0, $economicLife)),
                'economic_life' => $economicLife,
            ]);
        }
    }
}
