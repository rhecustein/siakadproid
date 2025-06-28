<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentIllness extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'reported_at',
        'illness_type',
        'severity',
        'symptoms',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
