<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Schedule extends Model
{
    protected $fillable = [
        'uuid',
        'teacher_id',
        'school_id',
        'subject_id',
        'classroom_id',
        'room_id',
        'lesson_time_id',
        'day',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto generate UUID saat membuat record
        static::creating(function ($model) {
            $model->uuid = $model->uuid ?? Str::uuid();
        });
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function lessonTime()
    {
        return $this->belongsTo(LessonTime::class);
    }

    public function gradeInputs()
    {
        return $this->hasMany(GradeInput::class, 'classroom_id', 'classroom_id')
            ->where('subject_id', $this->subject_id)
            ->where('teacher_id', $this->teacher_id);
    }
}
