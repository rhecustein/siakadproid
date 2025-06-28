<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StudentScore extends Model
{
    use HasFactory;

    protected $table = 'student_scores';

    protected $fillable = [
        'uuid', 'student_id', 'type', 'score', 'category', 'description', 'level', 'issued_by', 'date'
    ];

    protected static function booted()
    {
        static::creating(function ($score) {
            $score->uuid = (string) Str::uuid();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
