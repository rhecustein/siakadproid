<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Semester extends Model
{
    protected $fillable = [
        'uuid',
        'school_year_id',
        'name',
        'type',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($semester) {
            if (empty($semester->uuid)) {
                $semester->uuid = Str::uuid();
            }

            // Optional: Otomatis tentukan type jika tidak diisi
            if (empty($semester->type)) {
                $semester->type = strtolower($semester->name) === 'genap' ? 'genap' : 'ganjil';
            }
        });
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
