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


        $getGasht = Gasht::with('agency', 'city')->where('status', 'active');

        $cityForm = null;

        if (@json_decode($request->destination)->id) {
            $getGasht->where('city_id', json_decode($request->destination)->id);
            $destinationBack = $request->destination;
        } else {
            $destinationBack = null;
        }


//        if ($request->start_in) {
//            $fromDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in), 01))->toCarbon()->format('Y-m-d'));
//            $toDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in) + 1, 01))->addDays(-1)->toCarbon()->format('Y-m-d'));
//            $getGasht->whereBetween('date', [$fromDate, $toDate]);
//            $monthNumber = getMonthNumber($request->start_in);
//        } else {
//            $monthNumber = null;
//        }

        if ($request->start_in) {
            $fromDate = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($request->start_in))->format('Y-m-d');
            $getGasht->where('date','=',$fromDate);
            $monthNumber=$request->start_in;
        }else{
            $fromDate=date("Y-m-d");
            $monthNumber=null;
            $getGasht->where('date','>=',$fromDate);
        }


        $getGasht = $getGasht->orderBy('date', 'ASC')->orderBy('adult', 'asc')
            ->paginate(10);

       // dd($getGasht);
            
        return view('site.gasht.gashtList', [
            'gashts' =>   $getGasht->appends(Input::except('page')),
            'monthNumber' => $monthNumber,
            'destinationBack'=>$destinationBack
        ]);
    }

    public function statusjob(Request $request)
    {
        $gasts=Gasht::get();
        foreach ($gasts as $gast)
        {
            $date=Carbon::parse($gast['date']);
            $now=Carbon::now();
            if ($date<=$now)
            {
                Gasht::where('id', $gast['id'])->update(['status' => 'expire']);
            }

        }
    }

}
