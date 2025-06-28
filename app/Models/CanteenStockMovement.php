<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CanteenStockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'canteen_product_id',
        'type',
        'quantity',
        'unit_price',
        'reference_type',
        'reference_id',
        'moved_at',
    ];

    protected $casts = [
        'moved_at' => 'datetime',
    ];

    // Relasi ke produk kantin
    public function product()
    {
        return $this->belongsTo(CanteenProduct::class, 'canteen_product_id');
    }

    // Polymorphic reference ke transaksi pembelian/penjualan/opname
    public function reference()
    {
        return $this->morphTo(null, 'reference_type', 'reference_id');
    }

    // Akses total nilai pergerakan stok
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
