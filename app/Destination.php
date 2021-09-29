<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $guarded=[];

    function city(){
        return $this->belongsTo(City::class);
    }

}
