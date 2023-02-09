<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'open_time',
        'close_time',
        'location',
        'location_url',
        'phone',
        'email',
    ];
}
