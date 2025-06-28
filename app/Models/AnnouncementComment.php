<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementComment extends Model
{
    protected $fillable = ['announcement_id', 'user_id', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
