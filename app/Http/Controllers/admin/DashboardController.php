<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\City;

class DashboardController extends Controller {
    private $model = 'App\Permission';
    private $paginate = 15;
    const NAME = 'Dashboard';

    public function index() {
        return view('admin.index');
    }
}
