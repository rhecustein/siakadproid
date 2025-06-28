<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtracurricularScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'student_id',
        'extracurricular_id',
        'score',
        'note',
    ];

    /**
     * Relasi ke siswa
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke ekstrakurikuler
     */
    public function extracurricular()
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Relasi ke semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
