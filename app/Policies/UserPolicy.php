<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    function index(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->x ?? false;
    }
    function create(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->w ?? false;
    }
    function store(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->w ?? false;
    }
    function show(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->x ?? false;
    }
    function edit(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->w ?? false;
    }
    function update(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->w ?? false;
    }
    function destroy(User $user, $model)
    {
        return collect(\Auth::user()->permission->sections)->where('model', $model)->first()->pivot->d ?? false;
    }
    function checkTransaction()
    {
        return 1;
    }
    function myProfile()
    {
        return Auth::check();
    }
    function createMap()
    {
        return Auth::user()->role == 'admin';
    }
    function deletecheck()
    {
        return Auth::user()->role == 'admin' ||  Auth::user()->role == 'superAdmin';
    }
    function statuscronjob()
    {
        return Auth::user()->role == 'admin' ||  Auth::user()->role == 'superAdmin';
    }
    function activestatus()
    {
        return  Auth::user()->role == 'superAdmin';
    }
    function unactivestatus()
    {
        return  Auth::user()->role == 'superAdmin';
    }
    function uploadimg()
    {
        return Auth::check();
    }
    function updateMyProfile()
    {
        return Auth::check();
    }
    function deletimg()
    {
        return Auth::check();
    }
    function  lisCity()
    {
        return Auth::check();
    }
    function listCountries()
    {
        return Auth::check();
    }

    function listContinents()
    {
        return Auth::check();
    }

    function listAgencies()
    {
        return Auth::check();
    }

    function listTours()
    {
        return Auth::check();
    }

    function MainUploadImg()
    {
        return Auth::check();
    }
    function MainDeleteImg()
    {
        return Auth::check();
    }
    function isSuperAdmin()
    {
        return \auth()->user()->role == 'superAdmin' ? true : false;
    }

    function editUserPassword()
    {
        return Auth::check();
    }

    function updateUserPassword()
    {
        return Auth::check();
    }

    function sellList()
    {
        return Auth::check();
    }
}
