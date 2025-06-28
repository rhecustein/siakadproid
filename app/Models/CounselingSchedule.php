<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselingSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'counselor_id',
        'scheduled_at',
        'topic',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
