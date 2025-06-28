<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentArchive extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'description',
        'file_path',
        'archived_at',
        'uploaded_by',
    ];

    protected $dates = ['archived_at'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
