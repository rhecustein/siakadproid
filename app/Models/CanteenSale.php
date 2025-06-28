<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['canteen_id', 'buyer_type', 'buyer_id', 'payment_method', 'auth_method', 'total_amount', 'paid', 'cashier_id', 'transaction_time'];

    public function canteen() {
        return $this->belongsTo(Canteen::class);
    }

    public function items() {
        return $this->hasMany(CanteenSaleItem::class);
    }
}