<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'type',
        'min_grade',
        'max_grade',
        'order',
        'is_active',
        'description',
    ];
    

    /**
     * Relasi: Level memiliki banyak kelas (classrooms)
     */
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    /**
     * Scope: hanya level yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
