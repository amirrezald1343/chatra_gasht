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
use App\Currency;

use App\Http\Resources\Packages as Resourcepackage;
use App\Http\Resources\FavCountries;

use App\Exceptions\api\NoContentException;
use App\Exceptions\api\BadRequestException;

class TourController extends Controller
{

    public function index(Request $req)
    {

        $returnArray = array();

        $addSevenDays = date(Carbon::now()->addDays(7)->format('Y-m-d'));
        // $getMomentTours=Package::with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')
        // ->where('start_in','<=',$addSevenDays)
        // ->where('status','1')->limit(10)->get();



        $getMomentTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice')
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where(function ($q) {
                $q->where('packages.start_in', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
                    ->Where('packages.start_in', '>=', Carbon::now());
            })->limit(10)->get();



        $getIndoorsTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice')
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('indoors', '1')
            ->limit(10)->get();


        $getFavCountries = FavoriteTour::with('countries')->where('favorite_tours.status', 'Y')->limit(10)->get();

        $getAllCities = City::where('types', 'city')->where('title_fa', 'NOT LIKE', "استان%")->get();



        $returnArray['moment'] = new Resourcepackage($getMomentTours);
        $returnArray['indoors'] = new Resourcepackage($getIndoorsTours);
        $returnArray['favCountries'] = new FavCountries($getFavCountries);
        $returnArray['cities'] = $getAllCities;



        if (count($returnArray['moment']) or count($returnArray['moment']) or count($returnArray['favCountries']) or count($returnArray['cities'])) {
            return \response()->json($returnArray, 200);
        } else {
            throw new NoContentException();
        }
    }


    public function favTours(Request $req)
    {

        if (!$req->cid) {
            throw  new BadRequestException;
        }

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        $countryID = $req->cid;

        $getInternalTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'packages.tourType',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice')
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->with('cities')
            ->whereHas('cities', function ($q) use ($countryID) {
                $q->where('cities.id', $countryID);
            })
            ->skip($skip)
            ->take(10)
            ->get();



        if (count($getInternalTours)) {
            return \response()->json(['favTours' => new Resourcepackage($getInternalTours)], 200);
        } else {
            throw new NoContentException();
        }
    }



    public function internalTours(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        $getInternalTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'packages.tourType',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.imageThumb',
            'packages.start_in',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice')
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('tourType', 'internal')
            ->skip($skip)
            ->take(10)
            ->get();



        if (count($getInternalTours)) {
            return \response()->json(['internalTours' => new Resourcepackage($getInternalTours)], 200);
        } else {
            throw new NoContentException();
        }
    }

    public function foreignTours(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        $getUsd = $getUsd ?? 1;
        $getEuro = $getEuro ?? 1;

        $getForeignTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'packages.tourType',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.imageThumb',
            'packages.start_in',
            'media.path',
            //DB::raw('MIN(prices.price) as minPrice'),
            DB::raw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as minPrice")
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('tourType', 'foreign')
            ->skip($skip)
            ->take(10)
            ->orderBy('minPrice')
            ->get();



        if (count($getForeignTours)) {
            return \response()->json(['foreignTours' => new Resourcepackage($getForeignTours)], 200);
        } else {
            throw new NoContentException();
        }
    }


    public function indoorsTours(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        $getIndoorsTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'packages.tourType',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice')
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where('start_in', '>=', Carbon::now()->format('Y-m-d'))
            ->where('indoors', '1')
            ->skip($skip)
            ->take(10)
            ->get();



        if (count($getIndoorsTours)) {
            return \response()->json(['indoorTours' => new Resourcepackage($getIndoorsTours)], 200);
        } else {
            throw new NoContentException();
        }
    }


    public function momentTours(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        $getUsd = $getUsd ?? 1;
        $getEuro = $getEuro ?? 1;

        $getMomentTours = Package::select(
            DB::raw('agencies.id as agency_id'),
            DB::raw('agencies.company as agency_name'),
            'packages.id',
            'packages.title',
            'packages.tourType',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as minPrice")
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->where('packages.status', '1')
            ->where(function ($q) {
                $q->where('packages.start_in', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
                    ->Where('packages.start_in', '>=', Carbon::now());
            })
            ->skip($skip)
            ->take(10)
            ->orderBy('minPrice')
            ->get();



        if (count($getMomentTours)) {
            return \response()->json(['momentTours' => new Resourcepackage($getMomentTours)], 200);
        } else {
            throw new NoContentException();
        }
    }

    // public function toCarbon(): Carbon
    // { }

    public function searchTours(Request $req)
    {

        $req->validate([
            'city_id' => 'required|numeric',
            //'month' => 'required|min:1|max:12|numeric'
        ]);

        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;



        // if ($req->month) {
        //     $fromDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($req->month), 01))->toCarbon()->format('Y-m-d'));
        //     $toDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($req->month) + 1, 01))->addDays(-1)->toCarbon()->format('Y-m-d'));
        //     $Tours->whereBetween('start_in', [$fromDate, $toDate]);
        // }

        // $date = Jalalian::now()->format("Y/0$req->month/01");
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

            // return  $date1.' '.$date2;
        }


        $city_id = $req->city_id;


        $getSearchedTours = Package::select(
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
            'packages.start_in',
            'packages.imageThumb',
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
            ->whereHas('cities', function ($q) use ($city_id) {
                $q->where('cities.id', '=', $city_id);
            });

        if ($req->month) {

            $getSearchedTours->where(function ($q) use ($date1, $date2) {
                $q
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', $date1)
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '<=', $date2)
                    ->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
            });
        } else {
            $getSearchedTours->where(DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
        }

        $getSearchedTours = $getSearchedTours->with('justCities')->orderBy('minPrice')->get();

        //  return $getSearchedTours;

        if (count($getSearchedTours)) {
            return response()->json(['search' => new Resourcepackage($getSearchedTours)], 200);
        } else {
            throw new NoContentException();
        }
    }



    function getAllTours(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }

        // return  $skip;


        $getAllTours = Package::select(
            'packages.id',
            'packages.title',
            'packages.tourType',
            'packages.origin',
            'packages.additional_services',
            'cities.title_fa',
            'packages.number_nights',
            'packages.travel_method',
            'packages.start_in',
            'packages.imageThumb',
            'media.path',
            DB::raw('MIN(prices.price) as minPrice'),
            DB::raw("DATE_FORMAT(packages.start_in,'%Y-%m-%d') as sDate")
        )
            ->leftJoin('agencies', 'packages.agency_id', '=', 'agencies.id')
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->LeftJoin('cities', 'cities.id', '=', 'packages.origin')
            ->leftJoin('images', 'images.package_id', '=', 'packages.id')
            ->leftJoin('media', 'media.id', '=', 'images.media_id')
            ->groupBy('packages.id')
            ->skip($skip)
            ->take(10)
            ->with('justCities')->get();


        return $getAllTours;
    }
}
