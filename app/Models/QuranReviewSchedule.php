<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuranReviewSchedule extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'day',
        'time',
        'target_surah',
        'ayat_start',
        'ayat_end',
        'note',
        'status',
        'semester_id',
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function semester() { return $this->belongsTo(Semester::class); }
}
