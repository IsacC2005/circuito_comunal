<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

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

    public function gasCylinders()
    {
        return $this->belongsToMany(GasCylinder::class, 'family_gas_cylinder')
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
