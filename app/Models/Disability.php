<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    protected $fillable = ['name', 'type'];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'disable_person');
    }
}
