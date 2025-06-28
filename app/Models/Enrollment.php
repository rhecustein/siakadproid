<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Enrollment extends Model
{
    protected $table = 'enrollments';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'student_id',
        'subject_id',
        'class_id',
        'academic_year_id',
        'semester'
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = $model->id ?? Str::uuid()->toString();
        });
    }

    // RELATIONS
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class); // jika Anda buat 1 grade per enrollment
    }
}
