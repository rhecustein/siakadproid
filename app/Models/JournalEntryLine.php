<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntryLine extends Model
{
    protected $fillable = [
        'journal_entry_id',
        'account_code',
        'account_name',
        'debit',
        'credit',
        'note',
    ];

    /**
     * Relasi ke jurnal utama.
     */
    public function journal()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }
}
