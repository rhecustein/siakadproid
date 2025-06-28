<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'transaction_type',
        'amount',
        'channel',
        'status',
        'reference_no',
        'executed_by',
        'verified_at',
        'description',
        'meta',
        'related_type',
        'related_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
        'verified_at' => 'datetime',
    ];

    // Relasi ke wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // Relasi polymorphic ke transaksi terkait (misal: pembayaran SPP, parkir, dll)
    public function related()
    {
        return $this->morphTo();
    }

    // Admin atau user yang mengeksekusi transaksi (opsional)
    public function executor()
    {
        return $this->belongsTo(\App\Models\User::class, 'executed_by');
    }

    public function target()
    {
        return $this->morphTo();
    }
}
