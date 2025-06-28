<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceRecord extends Model
{
    protected $fillable = [
        'student_id',
        'absence_type_id',
        'date',
        'time_segment',
        'status',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function type()
    {
        return $this->belongsTo(AbsenceType::class, 'absence_type_id');
    }
}
