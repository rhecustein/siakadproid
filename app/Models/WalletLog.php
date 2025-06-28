<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'action',
        'before',
        'after',
        'performed_by',
        'ip',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function actor()
    {
        return $this->belongsTo(\App\Models\User::class, 'performed_by');
    }
}
