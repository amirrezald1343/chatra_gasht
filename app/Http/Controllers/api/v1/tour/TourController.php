<?php

namespace App\Http\Controllers\api\v1\tour;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

use App\Package;
use App\FavoriteTour;
use App\City;
use App\WebService;
use App\Currency;

use App\Http\Resources\tour\TourResource;
use App\Http\Resources\tour\TourDetailsResource;
use App\Http\Resources\FavCountries;

use App\Exceptions\api\NoContentException;
use App\Exceptions\api\BadRequestException;

class TourController extends Controller
{
    public function getAllTours(Request $req)
    {



        $allTours = Package::where('status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('tourType', 'internal')
            ->where('isOnline', '1')
            ->whereNotNull('capacity')
            ->where('capacity', '>', 0)
            ->with('agency', 'city', 'levels', 'maps', 'prices', 'pricesDesc', 'images', 'services', 'justCities')
            ->get();


        if (count($allTours)) {
            return new TourResource($allTours);
        } else {
            throw new NoContentException();
        }
    }

    public function tourDetails(Request $req)
    {
        if (!$req->id) {
            throw new BadRequestException();
        }

        $getTourDetails = Package::where('id', $req->id)
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('status', '1')
            ->where('isOnline', '1')
            ->with('agency', 'city', 'levels', 'maps', 'prices', 'pricesDesc', 'images', 'services', 'justCities')->first();


        if ($getTourDetails) {
            return new TourDetailsResource($getTourDetails);
        } else {
            throw new NoContentException();
        }
    }

    public function searchTour(Request $req)
    {

        if (!$req->city_id) {
            throw new BadRequestException();
        }


        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        $city_id = $req->city_id;

        $clinetAccess = $this->dataFilter($req->token);


        $dateYear = Jalalian::now()->format("Y");
        if ($req->month) {
            if ($req->month < 10) {
                $dateMonth = '0' . '' . $req->month;
            } else {
                $dateMonth = $req->month;
            }

            $monthMaxDay = (new Jalalian($dateYear, $dateMonth, 01))->getMonthDays();

            $date1 = (new Jalalian($dateYear, $dateMonth, 01))->toCarbon()->toDateTimeString();
            $date2 = (new Jalalian($dateYear, $dateMonth, $monthMaxDay))->toCarbon()->toDateTimeString();

            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = date('Y-m-d', strtotime($date2));
        }




        $Tours = Package::select(
            'packages.id',
            'packages.title',
            'packages.tourType',
            'packages.origin',
            'packages.additional_services',
            'cities.title_fa',
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.number_nights',
            'packages.travel_method',
            'packages.vehicle_type',
            'packages.start_in',
            'packages.imageThumb',
            'packages.isOnline',
            'media.path',
            DB::raw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as minPrice"),
            DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d') as sDate")
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('packages.isOnline', '1');

        if ($req->city_id != "all") $Tours = $Tours->whereHas('cities', function ($q) use ($city_id) {
                                                $q->where('cities.id', '=', $city_id);
                                            });
        
//        dd($city_id);

        if ($req->month) {
            $Tours->where(function ($q) use ($date1, $date2) {
                $q
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', $date1)
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '<=', $date2)
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
            });
        } else {
            $Tours->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
        }

        if ($req->agency_id) {
            $Tours->where('agency_id', $req->agency_id);
        }

        // if ($clinetAccess['access'] != 'all') {
        //     if ($req->agency_id) {
        //         $Tours->where('agency_id', $req->agency_id);
        //     } else {
        //         return response()->json(['data' => 'No Data available'], 204);
        //     }
        // }





        $Tours = $Tours->with('agency', 'city', 'levels', 'maps', 'prices', 'pricesDesc', 'images', 'services', 'justCities')->orderBy('minPrice')->paginate($req->limit ?? 50);



        if (count($Tours)) {
            return new TourResource($Tours);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }

    public function dataFilter($token)
    {
        $client_data = WebService::where('token', $token)->first();
        return ['access' => $client_data->access, 'agency_id' => $client_data->agency_id];
    }
}
