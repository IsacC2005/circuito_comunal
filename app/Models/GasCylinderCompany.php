<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCylinderCompany extends Model
{
    protected $fillable = ['name'];

    public function gasCylinders()
    {
        return $this->hasMany(GasCylinder::class, 'company_id');
    }
}
