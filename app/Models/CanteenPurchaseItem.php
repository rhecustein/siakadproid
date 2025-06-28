<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenPurchaseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['canteen_purchase_id', 'canteen_product_id', 'quantity', 'unit_price', 'subtotal'];

    public function purchase() {
        return $this->belongsTo(CanteenPurchase::class);
    }

    public function product()
    {
        return $this->belongsTo(CanteenProduct::class, 'canteen_product_id');
    }
}