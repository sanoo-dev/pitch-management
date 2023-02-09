<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'retail_id',
        'service_id',
        'quantity',
        'price',
    ];

    public function retail()
    {
        return $this->belongsTo(Retail::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
