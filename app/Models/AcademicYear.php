<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    protected $fillable = [
        'year',
        'is_active',
        'start_year',
        'end_year',
        'uuid',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];

    // Accessor untuk label tahun ajaran
    public function getNameAttribute()
    {
        return $this->year ?? "{$this->start_year}/{$this->end_year}";
    }

    // Scope: tahun ajaran aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
