<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuranRecitation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'date',
        'surah',
        'from_verse',
        'to_verse',
        'status',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
