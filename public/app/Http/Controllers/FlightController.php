<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Sodium\compare;
use Ixudra\Curl\Facades\Curl;

class FlightController extends Controller
{
   public function index(Request $request)

   {

       $this->validate($request, [
           'fromCityFlight' => 'required',
           'toCityFlight' => 'required',
           'fromDateFlight' => 'required'
       ]);

//dd($request->all());

       $route = 'http://127.0.0.1:8000/Api/flights';
       $response = Curl::to($route)
           ->withData($request->all())->get();


      echo $response;die;


       return view('site.flights',compact('request'));
   }
}
