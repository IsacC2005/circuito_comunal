<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodModule extends Model
{
    protected $fillable = ['name'];

    public function families()
    {
        return $this->belongsToMany(Family::class, 'family_food_module')
            ->withPivot('count')
            ->withTimestamps();
    }
}
