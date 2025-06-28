<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = ['classroom_id', 'subject_id', 'teacher_id', 'day', 'start_time', 'end_time'];

    public function classroom() { return $this->belongsTo(Classroom::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}