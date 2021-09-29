<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $guarded = [];


    public function titems()
    {
        return $this->hasMany(TransferItem::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
