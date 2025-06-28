<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PromotionLog extends Model
{
    protected $table = 'promotion_logs';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'student_id', 'from_class_id', 'to_class_id', 'academic_year_id', 'promoted_at'
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function fromClass(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'from_class_id');
    }

    public function toClass(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'to_class_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
