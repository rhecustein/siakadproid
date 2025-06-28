<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataVisualization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data_source',
        'image_path',
        'description',
        'conversation_id',
    ];

    protected $casts = [
        'data_source' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
