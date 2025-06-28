<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'canteen_id',
        'student_id',
        'user_id',
        'type',
        'transaction_date',
        'amount',
        'total_amount',
        'items',
        'note',
        'processed_by',
        'created_by',
    ];

    protected $casts = [
        'items' => 'array',
        'transaction_date' => 'datetime',
    ];

    // Relasi ke unit kantin
    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    // Relasi ke santri (jika ada)
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke user umum (wali, guru, dll)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kasir / yang memproses transaksi
    public function cashier()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Pembuat transaksi (admin/sistem)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
