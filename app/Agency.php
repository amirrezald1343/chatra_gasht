<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected  $guarded=[];

    function media(){
        return $this->belongsTo(Media::class);
    }

    function permission() {
        return $this->belongsTo(Permission::class)->with('sections');
    }

    function packages(){
        return $this->hasMany(Package::class);
    }

    public function gasht(){
        return $this->hasMany(Gasht::class);
    }

    public function transfer(){
        return $this->hasMany(Transfer::class);
    }

}
