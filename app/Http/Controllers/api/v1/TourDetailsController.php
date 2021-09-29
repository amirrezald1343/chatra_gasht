<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

use App\Package;
use App\FavoriteTour;
use App\City;

use App\Http\Resources\TourDetails;

use App\Exceptions\api\NoContentException;
use App\Exceptions\api\BadRequestException;


class TourDetailsController extends Controller
{
    public function showTourDetails(Request $req){

        
        
        if(!$req->id){ throw  new BadRequestException; }
        
        $getToutDetails=Package::select(DB::raw("agencies.id as agency_id"),'agencies.company','agencies.domain','agencies.tellphone','agencies.internalCode','agencies.cellphone','agencies.email','agencies.address',
        'packages.id','packages.title','packages.additional_services','cities.title_fa','packages.number_nights','packages.travel_method','packages.start_in','packages.vehicle_type','packages.documents','packages.rules','packages.obligations',
        'media.path',DB::raw("MIN(prices.price) as minPrice"))
        ->leftJoin('agencies','packages.agency_id','=','agencies.id')
        ->leftJoin('prices','prices.package_id','=','packages.id')
        ->LeftJoin('cities','cities.id','=','packages.origin')
        ->leftJoin('images','images.package_id','=','packages.id')
        ->leftJoin('media','media.id','=','images.media_id')
        ->leftJoin('package_service','package_service.package_id','=','packages.id')
        ->leftJoin('services','package_service.service_id','=','services.id')
        ->where('packages.status','1')
        ->where('packages.id','=',$req->id)
        ->with('cities', 'levels', 'maps', 'prices', 'images', 'services', 'city')
        ->groupBy('packages.id')
        ->first();


       // return $getToutDetails;



        if(!$getToutDetails) { throw new NoContentException; }

        return new TourDetails($getToutDetails);
        

    }
}
