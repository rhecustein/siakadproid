<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenCashShift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'canteen_id',
        'cashier_id',
        'shift_start',
        'shift_end',
        'opening_cash',
        'closing_cash',
        'system_sales',
        'difference',
        'note',
    ];

    protected $dates = ['shift_start', 'shift_end'];

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
