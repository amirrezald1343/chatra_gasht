<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Country;
use App\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\City;
use App\FavoriteTour;
use App\Post;
use App\Video;

class SiteController extends Controller
{
    public function index()
    {

        // \Auth::loginUsingId(1, true);
        /*------ToursMoment-------*/

       $agencies = Agency::where('status', '1')->pluck('id')->toArray();
       $ToursMoment = Package::where('start_in', '>', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1');
       $Date = date(Carbon::now()->addDays(7)->format('Y-m-d'));
       $ToursMoment->Where('start_in', '<=', $Date);
       $ToursMoment->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC');
       if ($ToursMoment->count() > 6) {
           $ToursMoment = $ToursMoment->limit(6)->get();
       } else {
           $ToursMoment = $ToursMoment->limit(6)->get();
       }


        /* ----------Indoors---------- */
       $ToursIndoors = Package::where('start_in', '>', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1')->where('indoors', '1');
       $ToursIndoors->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC');
       if ($ToursIndoors->count() > 6) {
           $ToursIndoors = $ToursIndoors->get()->random(6);
       } else {
           $ToursIndoors = $ToursIndoors->get();
       }


        /* ----------Specials---------- */
       $ToursSpecials = Package::where('start_in', '>', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1')->where('special', '1');
       $ToursSpecials->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC');
       if ($ToursSpecials->count() > 6) {
           $ToursSpecials = $ToursSpecials->get()->random(6);
       } else {
           $ToursSpecials = $ToursSpecials->get();
       }



        /* ----------Internal---------- */
       $ToursInternal = Package::where('start_in', '>', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1')->where('tourType', 'internal');
       $ToursInternal->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC');
       if ($ToursInternal->count() > 6) {
           $ToursInternal = $ToursInternal->limit(6)->get();
       } else {
           $ToursInternal = $ToursInternal->limit(6)->get();
       }



        /* ----------Foreign---------- */
       $ToursForeign = Package::where('start_in', '>', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1')->where('tourType', 'foreign');
       $ToursForeign->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC');
       if ($ToursForeign->count() > 6) {
           $ToursForeign = $ToursForeign->limit(6)->get();
       } else {
           $ToursForeign = $ToursForeign->limit(6)->get();
       }




        /* ----------randomVideo---------- */
        $randomVideo=Video::where('status','active')->orderBy(DB::raw('RAND()'))->get();

        //dd($randomVideo[0]);


        $favTours = FavoriteTour::with('countries')->where('favorite_tours.status', 'Y')->get();

        $blogPosts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();

        
        return view('site.home', [
            'ToursMoment' => $ToursMoment,
            'ToursSpecials' => $ToursSpecials,
            'TourIndoors' => $ToursIndoors,
            'ToursInternal' => $ToursInternal,
            'ToursForeign' => $ToursForeign,
            'FavoriteTours' => $favTours,
            'Posts' => $blogPosts,
            'randomVideo' => $randomVideo[0]
        ]);
    }


    public function test()
    {
        //        $country=file_get_contents('https://mosaferan.net/search/suggest');
        //        $country = json_decode($country, true);
        //
        //        foreach ($country as $key=>$value){
        //            if($value['type'] == 'location'){
        //                City::create([
        //                   'title_fa'=>$value['title_fa'],
        //                   'title_en'=>$value['title_en'],
        //                   'type'=>$value['type'],
        //                   'slug_en'=>$value['slug_en'],
        //                   'slug_fa'=>$value['slug_fa'],
        //                 ]);
        //            }
        //        }
        dd('ok');
    }
}
