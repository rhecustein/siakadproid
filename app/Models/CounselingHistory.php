<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselingHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'counselor_id',
        'counseling_date',
        'topic',
        'summary',
        'recommendation',
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
