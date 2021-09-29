<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function permission() {
        if ($this->onMainDB) {
            return $this->belongsTo(Permission::class)->with('sections');
        }
        return $this->belongsTo(Permission::class)->with('sections');
    }

    function agency(){
        return $this->hasOne(Agency::class);
    }

    function isSuperAdmin(){
        return auth()->user()->role == 'superAdmin' ? true : false;
    }

}
