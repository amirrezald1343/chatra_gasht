<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasht extends Model
{
    //
    protected $guarded = [];


    public function gitems()
    {
        return $this->hasMany(GashtItem::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function gashtSell()
    {
        return $this->hasMany(GashtSell::class);
    }
}
