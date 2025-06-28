<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenPurchaseRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'canteen_id',
        'requester_id',
        'description',
        'status',
        'requested_date',
        'quantity',
        'total_price',
    ];

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
