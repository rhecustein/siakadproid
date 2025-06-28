<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'room_id',
        'inventory_type_id',
        'inventory_condition_id',
        'quantity',
        'is_electronic',
        'acquired_at',
        'economic_life',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function type()
    {
        return $this->belongsTo(InventoryType::class, 'inventory_type_id');
    }

    public function condition()
    {
        return $this->belongsTo(InventoryCondition::class, 'inventory_condition_id');
    }

    public function getRemainingLifeAttribute()
    {
        if (!$this->is_electronic || !$this->economic_life || !$this->acquired_at) {
            return null;
        }

        $yearsUsed = Carbon::parse($this->acquired_at)->diffInYears(now());
        return max(0, $this->economic_life - $yearsUsed);
    }
}
