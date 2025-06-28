<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'address',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            $branch->uuid = (string) Str::uuid();
        });
    }

    // Relasi ke Sekolah
    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
