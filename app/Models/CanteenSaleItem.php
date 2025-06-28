<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class CanteenSaleItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['canteen_sale_id', 'canteen_product_id', 'quantity', 'price', 'subtotal'];

    public function sale() {
        return $this->belongsTo(CanteenSale::class);
    }

    public function product() {
        return $this->belongsTo(CanteenProduct::class);
    }
}