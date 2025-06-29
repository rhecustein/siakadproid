<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
    use HasFactory;

    protected $table = 'model_has_permissions'; // Nama tabel pivot
    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
