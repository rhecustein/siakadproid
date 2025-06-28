<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'grade_level_id',
        'classroom_id',
        'academic_year_id',
        'semester_id',
        'level_id',
        'school_id',
    ];

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke Tingkat (GradeLevel)
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    // Relasi ke Kelas (Classroom)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi ke Tahun Ajaran
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Relasi ke Semester
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    //level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Helper (Opsional): tampilkan nama siswa
    public function getStudentNameAttribute()
    {
        return $this->student->name ?? '-';
    }

    //level
    
}
