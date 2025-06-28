<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Graduation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'graduation_date',
        'certificate_number',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
