<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeDetail extends Model
{
    protected $fillable = [
        'grade_input_id',
        'student_id',
        'score',
        'note',
    ];

    public function gradeInput()
    {
        return $this->belongsTo(GradeInput::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
