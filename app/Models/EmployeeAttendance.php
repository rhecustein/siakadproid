<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeeAttendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'remarks',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
