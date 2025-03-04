<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['uuid', 'count', 'status', 'user_id', 'description'];

    protected $timestamp = true;
}
