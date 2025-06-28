<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects'; 

    protected $fillable = [
        'uuid',
        'curriculum_id',
        'level_id',
        'major_id',
        'name',
        'slug',
        'code',
        'type',
        'is_religious',
        'order',
        'description',
        'kkm',
        'group',
        'is_active',
    ];

    protected $casts = [
        'is_religious' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate UUID & slug on creating
     */
    protected static function booted()
    {
        static::creating(function ($subject) {
            $subject->uuid = (string) Str::uuid();

            // generate slug only if not provided
            if (empty($subject->slug)) {
                $subject->slug = Str::slug($subject->name);
            }
        });
    }

    // Relationships
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_subjects')
                    ->withPivot('teacher_id')
                    ->withTimestamps();
    }
}
