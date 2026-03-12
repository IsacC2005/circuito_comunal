<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $fillable = ['street_id', 'number'];

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }
}
