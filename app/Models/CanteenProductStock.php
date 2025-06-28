<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenProductStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['canteen_product_id', 'stock_in', 'stock_out', 'stock_type', 'reference_type', 'reference_id', 'note', 'created_by'];

    public function product() {
        return $this->belongsTo(CanteenProduct::class);
    }
}