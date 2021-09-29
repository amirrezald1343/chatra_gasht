<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $guarded=[];


public function agencies(){
    return $this->belongsTo(Agency::class)->orderBy('price','DESC');
}

}
