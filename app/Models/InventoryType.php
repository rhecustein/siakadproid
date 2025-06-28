<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    protected $fillable = ['name', 'is_electronic', 'economic_life'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
