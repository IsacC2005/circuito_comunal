<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'family_id',
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'cedula',
        'gender',
        'birth_date',
        'relationship',
        'nationality',
        'academy_level'
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class, 'disable_person');
    }
}
