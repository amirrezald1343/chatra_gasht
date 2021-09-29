<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GashtSell extends Model
{
    //
    protected $guarded = [];
    protected  $table = 'gasht_sells';

    public function gasht()
    {
        return $this->belongsTo(Gasht::class,'gasht_id','id')->with('agency');
    }
}
