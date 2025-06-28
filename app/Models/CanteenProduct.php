<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'canteen_id',
        'category_id',
        'supplier_id',
        'parent_product_id',
        'name',
        'sku',
        'barcode',
        'external_code',
        'description',
        'price',
        'cost_price',
        'discount',
        'tax_percent',
        'stock',
        'reorder_point',
        'stock_alert',
        'stock_tracking',
        'unit',
        'status_label',
        'min_order_qty',
        'max_order_qty',
        'sales_limit_daily',
        'weight_grams',
        'stock_location',
        'expired_at',
        'composition',
        'tags',
        'labels',
        'available_days',
        'orderable_until',
        'purchase_frequency',
        'visibility',
        'is_featured',
        'is_serialized',
        'is_active',
        'photo_path',
    ];

    protected $casts = [
        'composition' => 'array',
        'tags' => 'array',
        'labels' => 'array',
        'available_days' => 'array',
        'expired_at' => 'datetime',
        'orderable_until' => 'datetime:H:i',
        'stock_alert' => 'boolean',
        'stock_tracking' => 'boolean',
        'is_featured' => 'boolean',
        'is_serialized' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'float',
        'cost_price' => 'float',
        'discount' => 'float',
        'tax_percent' => 'float',
    ];

    // Relasi ke unit kantin
    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(CanteenProductCategory::class, 'category_id');
    }

    // Relasi ke supplier utama
    public function supplier()
    {
        return $this->belongsTo(CanteenSupplier::class);
    }

    // Relasi ke produk induk (jika varian)
    public function parent()
    {
        return $this->belongsTo(CanteenProduct::class, 'parent_product_id');
    }

    public function variants()
    {
        return $this->hasMany(CanteenProduct::class, 'parent_product_id');
    }

    // Relasi ke histori stok
    public function stocks()
    {
        return $this->hasMany(CanteenProductStock::class);
    }

    // Relasi ke item penjualan
    public function saleItems()
    {
        return $this->hasMany(CanteenSaleItem::class);
    }

    // Relasi ke item pembelian
    public function purchaseItems()
    {
        return $this->hasMany(CanteenPurchaseItem::class);
    }


}
