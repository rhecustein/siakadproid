<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuranReading extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recorded_at',
        'student_id',
        'surah',
        'ayat_start',
        'ayat_end',
        'method',
        'status',
        'note',
        'attachment_path',
        'teacher_id',
        'semester_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
