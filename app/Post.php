<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public function packages()
    {
        return $this->belongsToMany(Package::class,'post_package');
    }
}
