<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MurojaahSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'scheduled_at',
        'surah',
        'verses',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
