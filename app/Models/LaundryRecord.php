<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'entry_date',
        'pickup_date',
        'total_items',
        'status',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
