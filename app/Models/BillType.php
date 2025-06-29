<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BillType extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'code',
        'description',
        'is_active',
        'is_monthly',
        'is_online_payment',
        'is_cash_payment',
        'is_installment_payment',
        
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
    public function billType()
    {
        return $this->belongsTo(BillType::class);
    }
}
