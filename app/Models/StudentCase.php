<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'reported_at',
        'case_type',
        'description',
        'status',
        'reported_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
