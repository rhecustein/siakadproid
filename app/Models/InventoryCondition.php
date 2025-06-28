<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryCondition extends Model
{
    protected $fillable = ['name', 'description'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
