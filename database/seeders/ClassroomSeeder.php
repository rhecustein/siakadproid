<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Classroom;
use App\Models\GradeLevel;
use App\Models\Level;
use App\Models\AcademicYear;
use App\Models\Curriculum;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = AcademicYear::where('is_active', true)->first();
        $curriculum = Curriculum::where('is_active', true)->first();

        if (!$academicYear || !$curriculum) {
            throw new \Exception('Tahun ajaran & kurikulum aktif harus tersedia.');
        }

        $counter = 1;
        $gradeLevels = GradeLevel::with('level')->get();

        foreach ($gradeLevels as $gradeLevel) {
            foreach (range('A', 'F') as $suffix) {
                Classroom::create([
                    'uuid' => Str::uuid(),
                    'grade_level_id' => $gradeLevel->id,
                    'level_id' => $gradeLevel->level_id,
                    'academic_year_id' => $academicYear->id,
                    'curriculum_id' => $curriculum->id,
                    'name' => $gradeLevel->label . ' ' . $suffix,
                    'alias' => $gradeLevel->label . '-' . $suffix,
                    'room' => 'Ruang ' . $suffix,
                    'order' => $counter++,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Seeder Classroom berhasil membuat kelas per GradeLevel.');
    }
}
