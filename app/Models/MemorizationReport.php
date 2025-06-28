<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemorizationReport extends Model
{
    protected $fillable = [
        'student_id', 'date', 'surah', 'ayat_start', 'ayat_end', 'juz', 'note', 'teacher_id'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }
}
