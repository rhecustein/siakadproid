<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi ke siswa (pivot table)
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'extracurricular_student')
                    ->withTimestamps();
    }

    /**
     * Relasi ke nilai ekstrakurikuler
     */
    public function scores()
    {
        return $this->hasMany(ExtracurricularScore::class);
    }
}
