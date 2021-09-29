<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    function permissions() {
        return $this->belongsToMany(Permission::class,'permission_section')->withPivot(['x', 'w', 'd']);
    }
}
