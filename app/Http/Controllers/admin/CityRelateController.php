<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;

class CityRelateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    const NAME = 'SiteData';
    const FANAME = 'ارتباط شهر و کشور';

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=1)
    {
        $cities=City::where('types','city')->whereNull('country_id')->pluck('title_fa','id');
        $citiesSelect=City::where('types','city')->whereNotNUll('country_id')->get();
       
        $coutries=City::where('types','country')->pluck('title_fa','id');
        $coutriesSelect=City::where('types','country')->get();

        $getRelateToCountry=array();


       

            foreach($citiesSelect as $rowCity){
                foreach($coutriesSelect as $rowCountry){
                        if($rowCountry->id==$rowCity->country_id){
                            $getRelateToCountry[$rowCity->title_fa]=$rowCountry->title_fa;
                        }
                }
            }

        

          
       

        return view('admin.dynamicData.edit',compact('cities','coutries','getRelateToCountry'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=1)
    {
        $isUpdate=City::find($request->city)->update(['country_id'=>$request->country]);

        return redirect()->back()->with(['success'=>'ارتباط بین شهر و کشور با موفقیت انجام شد']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
