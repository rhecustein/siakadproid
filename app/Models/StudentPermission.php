<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentPermission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'permission_date',
        'type',
        'reason',
        'return_date',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
