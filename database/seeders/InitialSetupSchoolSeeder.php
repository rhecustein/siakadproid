<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Branch;
use App\Models\School;
use App\Models\Room;

class InitialSetupSchoolSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat cabang utama
        $branch = Branch::firstOrCreate([
            'name' => 'Cabang Utama',
        ], [
            'uuid' => Str::uuid(),
            'center_id' => null,
            'slug' => 'cabang-utama',
            'address' => 'Jl. Pendidikan No.1, Cirebon',
        ]);

        // 2. Buat sekolah SMP Al Bahjah
        $smp = School::firstOrCreate([
            'name' => 'SMP Al Bahjah',
        ], [
            'uuid' => Str::uuid(),
            'branch_id' => $branch->id,
            'slug' => 'smp-al-bahjah',
            'npsn' => '12345678',
            'type' => 'formal',
            'address' => 'Jl. Pendidikan No.2, Cirebon',
            'phone' => '082112345678',
            'email' => 'smp@albahjah.sch.id',
        ]);

        // 3. Buat sekolah SMA Al Bahjah
        $sma = School::firstOrCreate([
            'name' => 'SMA Al Bahjah',
        ], [
            'uuid' => Str::uuid(),
            'branch_id' => $branch->id,
            'slug' => 'sma-al-bahjah',
            'npsn' => '87654321',
            'type' => 'formal',
            'address' => 'Jl. Pendidikan No.3, Cirebon',
            'phone' => '082212345678',
            'email' => 'sma@albahjah.sch.id',
        ]);

        // 4. Buat ruangan-ruangan untuk SMP
        $smpRooms = ['Kelas 7A', 'Kelas 7B', 'Kelas 8A', 'Kelas 9B', 'Lab IPA', 'Perpustakaan', 'Kantor Guru'];
        foreach ($smpRooms as $nama) {
            Room::firstOrCreate([
                'name' => $nama,
                'school_id' => $smp->id,
            ]);
        }

        // 5. Buat ruangan-ruangan untuk SMA
        $smaRooms = ['Kelas 10A', 'Kelas 11A', 'Kelas 12A', 'Lab Kimia', 'Perpustakaan SMA', 'Kantor Guru SMA'];
        foreach ($smaRooms as $nama) {
            Room::firstOrCreate([
                'name' => $nama,
                'school_id' => $sma->id,
            ]);
        }
    }
}
