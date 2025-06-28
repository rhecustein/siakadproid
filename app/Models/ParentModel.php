<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'uuid', 'user_id', 'nik', 'name', 'gender',
        'relationship', 'phone', 'email', 'address', 'is_active'
    ];

    protected static function booted()
    {
        static::creating(function ($parent) {
            $parent->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }
}
