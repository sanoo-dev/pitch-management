<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pay_status',
    ];

    public function retailDetails() {
        return $this->hasMany(RetailDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
