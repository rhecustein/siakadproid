<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'check_date',
        'diagnosis',
        'treatment',
        'notes',
        'checked_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
