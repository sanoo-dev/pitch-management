<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'capacity',
        'description',
        'introduce',
        'image',
    ];

    public function pitches()
    {
        return $this->hasMany(Pitch::class);
    }

}
