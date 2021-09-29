<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferItem extends Model
{
    protected $guarded=[];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }


}
