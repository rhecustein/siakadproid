<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'student_id',
        'bill_type_id',
        'bill_group_id',
        'title',
        'total_amount',
        'due_date',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }

    public function payments()
    {
        return $this->hasMany(BillPayment::class);
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\BillGroup::class, 'bill_group_id');
    }
}
