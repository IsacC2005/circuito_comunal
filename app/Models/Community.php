<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = ['circuit_id', 'name', 'code_citur', 'invitation_token'];

    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function streets()
    {
        return $this->hasMany(Street::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
