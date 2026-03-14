<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCilinder extends Model
{
    protected $fillable = ['company_id', 'size', 'type_connection_id'];

    public function company()
    {
        return $this->belongsTo(GasCilinderCompany::class, 'company_id');
    }

    public function typeConnection()
    {
        return $this->belongsTo(GasCilinderTypeConnection::class, 'type_connection_id');
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, 'family_gas_cilinder')
            ->withPivot('count')
            ->withTimestamps();
    }
}
