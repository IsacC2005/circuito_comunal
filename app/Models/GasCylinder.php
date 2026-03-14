<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCylinder extends Model
{
    protected $fillable = ['company_id', 'size', 'type_connection_id'];

    public function company()
    {
        return $this->belongsTo(GasCylinderCompany::class, 'company_id');
    }

    public function typeConnection()
    {
        return $this->belongsTo(GasCylinderTypeConnection::class, 'type_connection_id');
    }

    public function families()
    {
        return $this->belongsToMany(Family::class, 'family_gas_cylinder')
            ->withPivot('count')
            ->withTimestamps();
    }
}
