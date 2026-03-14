<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GasCilinderTypeConnection extends Model
{
    protected $fillable = ['name'];

    public function gasCilinders()
    {
        return $this->hasMany(GasCilinder::class, 'type_connection_id');
    }
}
