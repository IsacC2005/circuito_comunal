<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable = ['circuit_id', 'name', 'code_citur'];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    public function streets()
    {
        return $this->hasMany(Street::class);
    }
}
