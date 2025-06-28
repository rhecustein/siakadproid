<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradePromotion extends Model
{
    protected $fillable = [
        'student_id', 'from_classroom_id', 'to_classroom_id', 'promoted_at'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fromClassroom()
    {
        return $this->belongsTo(Classroom::class, 'from_classroom_id');
    }

    public function toClassroom()
    {
        return $this->belongsTo(Classroom::class, 'to_classroom_id');
    }
}
