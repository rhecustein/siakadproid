<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemorizationSubmission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recorded_at',
        'student_id',
        'teacher_id',
        'surah',
        'ayat_start',
        'ayat_end',
        'type',
        'status',
        'score',
        'note',
        'attachment_path',
        'semester_id',
        'validated_by',
        'is_validated',
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

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
