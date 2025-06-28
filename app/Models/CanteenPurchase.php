<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['canteen_id', 'supplier_id', 'total_price', 'status', 'created_by', 'approved_by', 'received_date', 'note'];

    public function canteen() {
        return $this->belongsTo(Canteen::class);
    }

    public function supplier() {
        return $this->belongsTo(CanteenSupplier::class);
    }

    public function items() {
        return $this->hasMany(CanteenPurchaseItem::class);
    }
    
}
