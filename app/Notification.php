<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $guarded = [];



    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function packages()
    {
        return $this->belongsTo(Package::class);
    }

    public function agencies()
    {
        return $this->belongsTo(Agency::class);
    }
}
