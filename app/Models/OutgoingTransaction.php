<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OutgoingTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'method',
        'recipient',
        'reference_number',
        'note',
        'issued_by',
        'status',
        'source_type',
        'source_id',
    ];

    /**
     * Wallet sumber dana.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * User/operator yang mengeluarkan dana.
     */
    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Polymorphic sumber transaksi (ex: Invoice, RefundRequest).
     */
    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
