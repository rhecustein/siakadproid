<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'school_id',
        'user_id',
        'title',
        'content',
        'category',
        'priority',
        'is_pinned',
        'is_active',
        'is_public',
        'target',
        'published_at',
        'expired_at',
    ];

    protected $casts = [
        'is_pinned'    => 'boolean',
        'is_active'    => 'boolean',
        'is_public'    => 'boolean',
        'published_at' => 'datetime',
        'expired_at'   => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($announcement) {
            $announcement->uuid = Str::uuid();
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function files()
    {
        return $this->hasMany(AnnouncementFile::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'announcement_users')
                    ->withPivot('is_read', 'read_at', 'is_notified', 'notified_at')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'announcement_roles');
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\AnnouncementComment::class)->latest();
    }
}
