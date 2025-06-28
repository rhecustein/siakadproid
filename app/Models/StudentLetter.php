<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'letter_type',
        'issued_at',
        'letter_number',
        'description',
        'issued_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
