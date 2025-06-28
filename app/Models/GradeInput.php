<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeInput extends Model
{
    protected $fillable = [
        'semester_id',
        'teacher_id',
        'subject_id',
        'classroom_id',
        'date',
        'topic',
    ];

    public function details()
    {
        return $this->hasMany(GradeDetail::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
