<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTransfer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'transfer_date',
        'type',
        'from_school',
        'to_school',
        'reason',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
