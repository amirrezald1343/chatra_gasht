<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpImage extends Model
{
    protected $guarded=[];

    function media(){
        return $this->belongsTo(Media::class);
    }
}
