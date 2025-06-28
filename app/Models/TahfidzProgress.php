<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahfidzProgress extends Model
{
    use SoftDeletes;

    protected $table = 'tahfidz_progress';

    protected $fillable = [
        'student_id',
        'recorded_at',
        'juz',
        'from_surah',
        'to_surah',
        'from_verse',
        'to_verse',
        'remarks',
        'status',
        'validated_by',
        'semester_id',
        'is_final',
    ];

    protected $casts = [
        'recorded_at' => 'date',
        'is_final' => 'boolean',
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke user yang memvalidasi
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Relasi ke semester
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
