<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCylinderTypeConnection extends Model
{
    protected $fillable = ['name'];

    public function gasCylinders()
    {
        return $this->hasMany(GasCylinder::class, 'type_connection_id');
    }
}
