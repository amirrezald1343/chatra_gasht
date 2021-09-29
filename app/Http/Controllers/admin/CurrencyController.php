<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


use App\User;
use App\Package;
use App\Currency;


class CurrencyController extends Controller
{

    private $model = 'App\Currency';
    const NAME = 'Dashboard';
    const FANAME = 'مدیریت ارزها';

     public function edit(){

        $getTours=Currency::all();

        $arrayCurrencies=array();
        foreach($getTours as $row){
            $arrayCurrencies[$row['type']]=$row['amount'];
        }

      //  dd($arrayCurrencies);


        return view('admin.Currency.edit',['currencies'=>$arrayCurrencies]);
    }


    public function update(Request $req){


        $this->validate($req,[
            'currency.*'=>'required'
        ]);

        $deleteC=DB::table('currencies')->delete();


        foreach($req->currency as $key=>$val){
                Currency::create([
                    'type'=>$key,
                    'amount'=>$val,
                    'created_at'=>Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }

      
    return redirect()->back()->with(['success'=>'ویرایش با موفقیت انجام شد']);
        
    }

}
