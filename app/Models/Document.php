<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'file_mime_type',
        'is_public',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
