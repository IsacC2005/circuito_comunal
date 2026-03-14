<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCilinderCompany extends Model
{
    protected $fillable = ['name'];

    public function gasCilinders()
    {
        return $this->hasMany(GasCilinder::class, 'company_id');
    }
}
