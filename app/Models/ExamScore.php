<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'student_id',
        'subject_id',
        'type',
        'score',
    ];

    /**
     * Relasi ke semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Relasi ke siswa
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke mata pelajaran
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Format nilai ujian jika diperlukan (opsional)
     */
    public function getFormattedScoreAttribute()
    {
        return number_format($this->score, 2);
    }

    /**
     * Scope untuk jenis ujian tertentu
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
