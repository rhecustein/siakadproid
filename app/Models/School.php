<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'branch_id',
        'name',
        'slug',
        'npsn',
        'type',
        'address',
        'phone',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($school) {
            $school->uuid = Str::uuid();
            $school->slug = Str::slug($school->name);
        });

        static::updating(function ($school) {
            $school->slug = Str::slug($school->name);
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
