<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Level;
use App\Models\Major;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::first();
        $academicYear = AcademicYear::where('is_active', true)->first();
        $teacher = Teacher::first();

        if (!$school || !$academicYear) {
            throw new \Exception("Seeder gagal: Pastikan ada data sekolah dan tahun ajaran aktif.");
        }

        $levels = Level::all();
        $majors = Major::all();

        $samples = [
            ['name' => '7A', 'level_slug' => 'smp', 'major_slug' => null],
            ['name' => '7B', 'level_slug' => 'smp', 'major_slug' => null],
            ['name' => '10 IPA 1', 'level_slug' => 'sma', 'major_slug' => 'ipa'],
            ['name' => '10 IPS 1', 'level_slug' => 'sma', 'major_slug' => 'ips'],
            ['name' => '12-Tafsir', 'level_slug' => 'pondok', 'major_slug' => 'tahfidz'],
        ];

        foreach ($samples as $index => $data) {
            $level = $levels->firstWhere('slug', $data['level_slug']);
            $major = $data['major_slug'] ? $majors->firstWhere('slug', $data['major_slug']) : null;

            Grade::create([
                'uuid' => Str::uuid(),
                'level_id' => $level->id,
                'school_id' => $school->id,
                'major_id' => $major?->id,
                'academic_year_id' => $academicYear->id,
                'homeroom_teacher_id' => $teacher?->id,

                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'capacity' => rand(25, 40),
                'description' => 'Kelas ' . $data['name'],
                'is_active' => true,
                'order' => $index + 1,
            ]);
        }
    }
}
