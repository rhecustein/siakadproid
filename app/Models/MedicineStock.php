<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineStock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicine_name',
        'unit',
        'quantity',
        'expiry_date',
        'description',
    ];
}
