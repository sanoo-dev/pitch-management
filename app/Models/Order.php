<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pitch_id',
        'employee_id',
        'customer_id',
        'time_start',
        'time_end',
        'price',
        'pay_status',
    ];

    public function pitch()
    {
        return $this->belongsTo(Pitch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderServices()
    {
        return $this->hasMany(OrderService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
