<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'contact_person', 'phone', 'email', 'address', 'is_branch_partner'];

    public function purchases() {
        return $this->hasMany(CanteenPurchase::class, 'supplier_id');
    }
}
