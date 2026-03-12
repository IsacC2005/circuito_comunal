<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{

    protected $fillable = ['community_id', 'house_id', 'house_status', 'food_module', 'gas_cylinder'];

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
}
