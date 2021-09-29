<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GashtItem extends Model
{
    //
    protected $guarded = [];


    public function gasht()
    {
        return $this->belongsTo(Gasht::class);
    }
}
