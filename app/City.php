<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected  $table='cities';
    protected  $guarded=[];

    function packages() {
        return $this->belongsToMany(Package::class);
    }


}
