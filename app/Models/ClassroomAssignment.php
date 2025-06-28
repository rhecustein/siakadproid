<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomAssignment extends Model
{
    protected $fillable = [
        'grade_level_id',
        'name',
        'homeroom_teacher_id',
        'class_enrollments_id',
        'classroom_id',
    ];

    // relasi bisa ditambahkan juga
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function classEnrollment()
    {
        return $this->belongsTo(ClassEnrollment::class);
    }
}