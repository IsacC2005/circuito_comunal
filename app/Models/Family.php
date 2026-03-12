<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    protected $fillable = ['house_id', 'house_status', 'food_module', 'gas_cylinder'];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
