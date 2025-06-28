<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class JournalEntry extends Model
{
    protected $fillable = [
        'date',
        'description',
        'reference_type',
        'reference_id',
        'created_by',
    ];

    /**
     * Detail baris jurnal (debit/kredit).
     */
    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    /**
     * Polymorphic relasi ke transaksi sumber (misal: IncomingTransaction).
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User yang membuat jurnal.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Hitung total debit.
     */
    public function totalDebit()
    {
        return $this->lines->sum('debit');
    }

    /**
     * Hitung total kredit.
     */
    public function totalCredit()
    {
        return $this->lines->sum('credit');
    }
}
