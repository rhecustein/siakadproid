<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';

    protected $fillable = [
        'uuid',
        'level_id',
        'school_id',
        'name',
        'slug',
        'code',
        'type',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($major) {
            $major->uuid = (string) Str::uuid();

            // Generate slug jika belum diisi
            if (empty($major->slug)) {
                $major->slug = Str::slug($major->name);
            }
        });
    }

    // Relasi ke level (jenjang)
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relasi ke sekolah (jika jurusan dikaitkan langsung)
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
