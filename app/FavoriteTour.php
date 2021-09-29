<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteTour extends Model
{
    protected $table='favorite_tours';
    protected $guarded=[];


    public function countries(){
      return  $this->hasOne(City::class,'id','origin');
    }

}
