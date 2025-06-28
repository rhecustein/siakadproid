<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnouncementUser extends Model
{
    use HasFactory;

    protected $table = 'announcement_users';

    protected $fillable = [
        'announcement_id',
        'user_id',
        'is_read',
        'read_at',
        'is_notified',
        'notified_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_notified' => 'boolean',
        'read_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
