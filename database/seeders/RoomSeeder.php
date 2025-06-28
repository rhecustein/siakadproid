<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Branch;
use App\Models\School;
use App\Models\Level;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Room;
use App\Models\Classroom;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // STEP 1: Buat cabang dengan UUID
        $branchMap = [];

        $branches = [
            [
                'slug' => 'al-bahjah-cirebon',
                'name' => 'Pusat Al Bahjah Cirebon',
                'address' => 'Jln. Pangeran Cakrabuana No. 179, Cirebon',
                'is_center' => true,
            ],
            [
                'slug' => 'al-bahjah-bandung',
                'name' => 'Al Bahjah Cabang Bandung',
                'address' => 'Jl. Cibiru Hilir No.88, Bandung',
                'center_slug' => 'al-bahjah-cirebon',
            ],
            [
                'slug' => 'al-bahjah-jakarta',
                'name' => 'Al Bahjah Cabang Jakarta',
                'address' => 'Jl. Raya Kalibata Timur No.10, Jakarta',
                'center_slug' => 'al-bahjah-cirebon',
            ],
        ];

        // Simpan pusat dulu
        foreach ($branches as $branchData) {
            if (!isset($branchData['center_slug'])) {
                $branch = Branch::firstOrCreate(['slug' => $branchData['slug']], [
                    'uuid' => Str::uuid(),
                    'name' => $branchData['name'],
                    'address' => $branchData['address'],
                ]);
                $branchMap[$branchData['slug']] = $branch;
            }
        }

        // Simpan cabang
        foreach ($branches as $branchData) {
            if (isset($branchData['center_slug'])) {
                $center = $branchMap[$branchData['center_slug']] ?? null;
                if (!$center) {
                    throw new \Exception("Center branch '{$branchData['center_slug']}' tidak ditemukan.");
                }

                $branch = Branch::firstOrCreate(['slug' => $branchData['slug']], [
                    'uuid' => Str::uuid(),
                    'center_id' => $center->uuid,
                    'name' => $branchData['name'],
                    'address' => $branchData['address'],
                ]);

                $branchMap[$branchData['slug']] = $branch;
            }
        }

        // STEP 2: Buat sekolah
        $schoolMap = [];

        $schools = [
            [
                'branch_slug' => 'al-bahjah-cirebon',
                'slug' => 'sd-albahjah',
                'name' => 'SD Al-Bahjah',
                'npsn' => '12345678',
                'type' => 'formal',
                'address' => 'Jln. Pangeran Cakrabuana No.179, Cirebon',
                'phone' => '0231-123456',
                'email' => 'sd@albahjah.sch.id',
            ],
            [
                'branch_slug' => 'al-bahjah-bandung',
                'slug' => 'pondok-albahjah-bandung',
                'name' => 'Pondok Al-Bahjah Bandung',
                'npsn' => null,
                'type' => 'pondok',
                'address' => 'Jl. Cibiru Hilir No.88, Bandung',
                'phone' => '022-987654',
                'email' => 'bandung@albahjah.sch.id',
            ],
            [
                'branch_slug' => 'al-bahjah-jakarta',
                'slug' => 'smp-albahjah-jakarta',
                'name' => 'SMP Al-Bahjah Jakarta',
                'npsn' => '87654321',
                'type' => 'formal',
                'address' => 'Jl. Raya Kalibata Timur No.10, Jakarta',
                'phone' => '021-123789',
                'email' => 'smp.jakarta@albahjah.sch.id',
            ],
        ];

        foreach ($schools as $schoolData) {
            $branch = $branchMap[$schoolData['branch_slug']] ?? null;
            if (!$branch) continue;

            $school = School::firstOrCreate(['slug' => $schoolData['slug']], [
                'uuid' => Str::uuid(),
                'branch_id' => $branch->id,
                'name' => $schoolData['name'],
                'npsn' => $schoolData['npsn'],
                'type' => $schoolData['type'],
                'address' => $schoolData['address'],
                'phone' => $schoolData['phone'],
                'email' => $schoolData['email'],
            ]);

            $schoolMap[$schoolData['slug']] = $school;
        }

        // STEP 3: Level SMP
        $levelSMP = Level::firstOrCreate(['slug' => 'smp'], [
            'uuid' => Str::uuid(),
            'name' => 'Sekolah Menengah Pertama',
            'type' => 'formal',
            'min_grade' => 7,
            'max_grade' => 9,
            'order' => 1,
            'is_active' => true,
        ]);

        // STEP 4: Tahun ajaran
        foreach ([
            ['year' => '2022/2023', 'is_active' => false],
            ['year' => '2023/2024', 'is_active' => false],
            ['year' => '2024/2025', 'is_active' => true],
        ] as $year) {
            AcademicYear::firstOrCreate(['year' => $year['year']], $year);
        }

        $activeYear = AcademicYear::where('is_active', true)->first();

        // STEP 5: Grade SMP
        foreach ([7, 8, 9] as $grade) {
            GradeLevel::firstOrCreate([
                'level_id' => $levelSMP->id,
                'grade' => $grade,
            ], [
                'label' => "SMP $grade",
                'description' => "Kelas $grade tingkat SMP",
                'is_active' => true,
            ]);
        }

        $gradeLevel = GradeLevel::where('grade', 7)->where('level_id', $levelSMP->id)->first();
        $sdSchool = $schoolMap['sd-albahjah'] ?? null;

        if (!$sdSchool) {
            throw new \Exception("School 'sd-albahjah' tidak ditemukan.");
        }

        // STEP 6: Ruangan & Classroom
        foreach (range(1, 35) as $i) {
            $room = Room::firstOrCreate([
                'name' => "Ruang $i",
                'school_id' => $sdSchool->id,
            ]);

            Classroom::firstOrCreate([
                'name' => "Kelas $i",
                'room' => $room->name,
            ], [
                'uuid' => Str::uuid(),
                'level_id' => $levelSMP->id,
                'grade_level_id' => $gradeLevel->id,
                'academic_year_id' => $activeYear->id,
                'alias' => "K$i",
                'order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
