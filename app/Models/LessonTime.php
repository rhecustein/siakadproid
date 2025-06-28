<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonTime extends Model
{
    protected $fillable = ['order', 'start', 'end'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function getLabelAttribute()
    {
        return 'Jam ' . $this->order . ' (' . substr($this->start, 0, 5) . ' - ' . substr($this->end, 0, 5) . ')';
    }

    public function school() { return $this->belongsTo(School::class); }
    public function academicYear() { return $this->belongsTo(AcademicYear::class); }
}
