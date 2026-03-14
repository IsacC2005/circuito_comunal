<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    protected $fillable = ['community_id', 'house_id', 'house_status'];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function gasCilinders()
    {
        return $this->belongsToMany(GasCilinder::class, 'family_gas_cilinder')
            ->withPivot('count')
            ->withTimestamps();
    }

    public function foodModules()
    {
        return $this->belongsToMany(FoodModule::class, 'family_food_module')
            ->withPivot('count')
            ->withTimestamps();
    }
}
