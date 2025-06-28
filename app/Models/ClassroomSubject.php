<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSubject extends Model
{
    protected $table = 'classroom_subjects';

    protected $fillable = [
        'classroom_id',
        'subject_id',
        'teacher_id',
    ];

    // RELATIONS
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
