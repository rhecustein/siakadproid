<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\User;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'owner_type',
        'owner_id',
        'balance',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($wallet) {
            $wallet->uuid = (string) Str::uuid();

            // Set default status if not provided
            if (!$wallet->status) {
                $wallet->status = 'active';
            }
        });
    }

    // Relasi ke entitas pemilik wallet (wali santri, siswa, dll)
    public function owner()
    {
        return $this->morphTo();
    }

    // Relasi ke transaksi dompet
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // Relasi ke user yang membuat wallet (admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
