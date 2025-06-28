<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'school_id',
        'name',
        'type',
    ];

    protected static function booted(): void
    {
        static::creating(function ($unit) {
            if (empty($unit->uuid)) {
                $unit->uuid = (string) Str::uuid();
            }
        });
    }

    // 🔁 Relasi ke sekolah
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // 🔁 Relasi ke absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // 🧩 Scope filter berdasarkan tipe
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
