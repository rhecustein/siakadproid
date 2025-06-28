<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BsiVaLog extends Model
{
    protected $fillable = ['type', 'request_data', 'response_data', 'status'];
}
