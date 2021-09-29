<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class SearchCityController extends Controller
{

    public function search(Request $req){

        if($req->word){
        $searchCity=City::where('title_fa','LIKE',"%".$req->word."%")
        //->where('title_fa','NOT LIKE',"استان%")
        ->where('types','city')
        ->limit(15)->get();

        return response()->json(['cities'=>$searchCity],200);

        }

    }
}
