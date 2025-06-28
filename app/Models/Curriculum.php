<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'uuid',
        'name',
        'code',
        'description',
        'start_year',
        'end_year',
        'is_active',
        'level_group',
        'applicable_grades',
        'reference_document',
        'regulation_number',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'applicable_grades' => 'array',
        'start_year' => 'integer',
        'end_year' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($curriculum) {
            $curriculum->uuid = (string) Str::uuid();
        });
    }
}
