<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class IncomingTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'method',
        'reference_number',
        'note',
        'received_by',
        'source_type',
        'source_id',
        'status',
    ];

    /**
     * Wallet tujuan penerimaan dana.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * User/operator yang menerima transaksi.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Sumber polymorphic (misal: Invoice, TopupRequest, dll).
     */
    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
