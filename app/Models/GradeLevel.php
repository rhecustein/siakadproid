<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $fillable = [
        'level_id',
        'grade',
        'label',
        'description',
        'is_active',
    ];

    // Relasi ke Level (misal: SD, SMP, SMA)
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Accessor: tampilkan label gabungan
    public function getFullLabelAttribute()
    {
        return $this->label 
            ?? 'Kelas ' . ($this->grade ?? '-') . ($this->level ? ' - ' . $this->level->name : '');
    }

    //classrooms
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
