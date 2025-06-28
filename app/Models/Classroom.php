<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classrooms';

    protected $fillable = [
        'uuid',
        'level_id',
        'academic_year_id',
        'curriculum_id',
        'grade_level_id', // ✅ tambahkan ini
        'name',
        'alias',
        'room',
        'order',
        'is_active',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($classroom) {
            $classroom->uuid = (string) Str::uuid();
        });
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function nextClass()
    {
        return $this->belongsTo(self::class, 'next_class_id');
    }

    public function nextClassroom()
    {
        return $this->belongsTo(self::class, 'next_classroom_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classroom_subjects')
                    ->withPivot('teacher_id')
                    ->withTimestamps();
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }
}
