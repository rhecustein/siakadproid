<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Jadwal Kegiatan Malam Jumat',
            'Pengumuman Ujian Tengah Semester',
            'Informasi Uang Laundry Belum Dibayar',
            'Libur Idul Adha',
            'Pemberitahuan Ghoib Santri',
            'Perubahan Jadwal Tahfidz',
            'Piket Santri Hari Ini',
            'Reminder Hafalan Pekanan',
            'Tagihan SPP Bulan Ini',
            'Kegiatan Outbond Santri Kelas 9'
        ];

        foreach ($titles as $i => $title) {
            Announcement::create([
                'uuid'         => Str::uuid(),
                'school_id'    => 1,
                'user_id'      => 1, // misal admin

                'title'        => $title,
                'content'      => fake()->paragraphs(3, true),

                'category'     => fake()->randomElement(['informasi', 'jadwal', 'keuangan', 'darurat', 'lainnya']),
                'priority'     => fake()->randomElement(['normal', 'tinggi', 'mendesak']),
                'is_pinned'    => fake()->boolean(20),
                'is_active'    => true,
                'is_public'    => fake()->boolean(30),
                'target'       => fake()->randomElement(['all', 'guru', 'ortu', 'siswa']),

                'published_at' => now()->subDays(rand(0, 10)),
                'expired_at'   => now()->addDays(rand(1, 15)),

                'created_at'   => now()->subDays(rand(0, 10)),
                'updated_at'   => now(),
            ]);
        }
    }
}
