<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FingerprintTemplate extends Model
{
    use HasFactory;

    protected $table = 'fingerprint_templates';

    protected $fillable = [
        'user_id',
        'finger_position',
        'template_data',
        'device_type',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
