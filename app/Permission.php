<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    function scopeCanAccess($query) {
        return $query->where('invisible','0');
    }

    function sections() {
        return $this->belongsToMany(Section::class)->withPivot(['x', 'w', 'd']);
    }
}
