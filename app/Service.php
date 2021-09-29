<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded=[];

    function media(){
        return $this->belongsTo(Media::class);
    }
}
