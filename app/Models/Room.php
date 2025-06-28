<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'school_id', 'description'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
