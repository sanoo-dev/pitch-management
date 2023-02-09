<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'price',
        'service_type_id',
        'status',
        'inventory',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function orderServices()
    {
        return $this->hasMany(Order::class);
    }

    public function retailDetails()
    {
        return $this->hasMany(RetailRetail::class);
    }
}
