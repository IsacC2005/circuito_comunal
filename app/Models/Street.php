<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = ['community_id', 'leader_id', 'name'];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function leader()
    {
        return $this->belongsTo(Person::class, 'leader_id');
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }
}
