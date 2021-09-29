<?php

namespace App\Http\Controllers;

use App\Gasht;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

use Illuminate\Support\Facades\Input;


class GashtController extends Controller
{


    public function gashtList(Request $request)
    {

        //dd();


        $getGasht = Gasht::with('agency', 'city')->where('status', '1');

        $cityForm = null;

        if (@json_decode($request->destination)->id) {
            $getGasht->where('city_id', json_decode($request->destination)->id);
            $destinationBack = $request->destination;
        } else {
            $destinationBack = null;
        }


        if ($request->start_in) {
            $fromDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in), 01))->toCarbon()->format('Y-m-d'));
            $toDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in) + 1, 01))->addDays(-1)->toCarbon()->format('Y-m-d'));
            $getGasht->whereBetween('date', [$fromDate, $toDate]);
            $monthNumber = getMonthNumber($request->start_in);
        } else {
            $monthNumber = null;
        }


        $getGasht = $getGasht->orderBy('date', 'ASC')->orderBy('adult', 'asc')
            ->paginate(10);

//dd();
            
        return view('site.gasht.gashtList', [
            'gashts' =>   $getGasht->appends(Input::except('page')),
            'monthNumber' => $monthNumber,
            'destinationBack'=>$destinationBack
        ]);
    }
}
