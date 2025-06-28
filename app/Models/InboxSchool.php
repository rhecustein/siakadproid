<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InboxSchool extends Model
{
    use HasFactory;

    protected $table = 'inbox_schools';

    protected $fillable = [
        'uuid', 'student_id', 'receiver_id', 'subject', 'message', 'status'
    ];

    protected static function booted()
    {
        static::creating(function ($inbox) {
            $inbox->uuid = (string) Str::uuid();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
