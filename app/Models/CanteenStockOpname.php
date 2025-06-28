<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanteenStockOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'opname_date',
        'system_stock',
        'real_stock',
        'difference',
        'note',
        'created_by'
    ];

    // Relasi ke produk kantin
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke user pencatat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
