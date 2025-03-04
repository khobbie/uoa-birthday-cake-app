<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = ['upload_id', 'name', 'date_of_birth', 'cake_day', 'off_day', 'is_weekend', 'is_holiday', 'next_working_day', 'birthday'];
}
