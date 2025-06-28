<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class AnnouncementFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'announcement_id',
        'file_path',
        'file_name',
        'mime_type',
        'file_type',
        'file_size',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'file_size' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($file) {
            $file->uuid = Str::uuid();
        });
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function fileUrl()
    {
        return asset('storage/' . $this->file_path);
    }
}
