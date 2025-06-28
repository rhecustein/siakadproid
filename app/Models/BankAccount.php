<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankAccount extends Model
{
    protected $fillable = [
        'uuid', 'account_number', 'account_holder', 'bank_name', 'bank_code',
        'school', 'online_payment', 'for_students', 'for_teachers',
        'for_male', 'for_female', 'can_pay_bills', 'can_save', 'can_donate', 'is_active'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
