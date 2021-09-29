<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
   protected $guarded=[];

    function levels(){
        return $this->hasMany(Level::class);
    }

    function maps(){
        return $this->hasMany(Map::class);
    }

    function prices(){
        return $this->hasMany(Price::class)->orderBy('price','ASC');
    }

    function pricesDesc(){
        return $this->hasMany(Price::class)->orderBy('price','ASC');
    }

    function images(){
        return $this->hasMany(Image::class)->with('media');
    }

    function agency(){
        return $this->belongsTo(Agency::class)->with('media');
    }

    function agencyCunstom(){
        return $this->belongsTo(Agency::class,'agency_id');
    }

    function services() {
        return $this->belongsToMany(Service::class);
    }

    function cities() {
        return $this->belongsToMany(City::class)->withPivot(['type']);
    }

    function justCities() {
        return $this->belongsToMany(City::class)->where('types','city')->withPivot(['type']);
    }

    function city(){
        return $this->belongsTo(City::class,'origin');
    }

    public function posts(){
        return $this->belongsToMany(Post::class,'post_package');
    }


}
