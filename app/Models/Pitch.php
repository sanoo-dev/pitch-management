<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'pitch_type_id',
        'location',
        'status',
    ];

    public function pitchType()
    {
        return $this->belongsTo(PitchType::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
