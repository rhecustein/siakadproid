<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineExam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subject_id',
        'classroom_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'instructions',
        'status',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
