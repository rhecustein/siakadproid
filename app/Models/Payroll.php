<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'pay_date',
        'basic_salary',
        'allowance',
        'bonus',
        'deduction',
        'net_salary',
        'status',
        'notes',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
