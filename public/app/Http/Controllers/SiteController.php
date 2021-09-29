<?php

namespace App\Http\Controllers;

use App\Agency;
use App\Country;
use App\Package;
use App\Yatacode;
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
//
//
//            foreach ($this->city() as $key => $value)
//            {
//                Yatacode::create(
//                    [
//                        'name' => $key,
//                        'code' => $value
//                    ]
//                );
//            }
//

//            dd('ok');


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


//
//        $cities  = [
//
////        $city = yatacode::Traveler('name')->get();
////
////        foreach ($city->flatMap->podcasts as $podcast)
////        {
////            echo $podcast->name;
////        }
////
//
//        ];


        $dir = 'rtl';

        return view('site.index', [
            'ToursMoment' => $ToursMoment,
            'ToursSpecials' => $ToursSpecials,
            'TourIndoors' => $ToursIndoors,
            'ToursInternal' => $ToursInternal,
            'ToursForeign' => $ToursForeign,
            'FavoriteTours' => $favTours,
            'Posts' => $blogPosts,
            'randomVideo' => $randomVideo[0],
            'cities' => $this->citis(),
            'dir' => $dir
        ]);



    }


    public function citis( )
    {
        $cities = yatacode::pluck('code','name')->toarray();
        return $cities;
    }

//
//    public function city(){
//
//        return [
//            'دوشنبه-DYU' => 'DYU',
//            'تهران-THR' => 'THR',
//            'مشهد-MHD' => 'MHD',
//            'اهواز-AWZ' => 'AWZ',
//            'کيش-KIH' => 'KIH',
//            'شيراز-SYZ' => 'SYZ',
//            'بندرعباس-BND' => 'BND',
//            'تبريز-TBZ' => 'TBZ',
//            'قشم-GSM' => 'GSM',
//            'بوشهر-BUZ' => 'BUZ',
//            'آبادان-ABD' => 'ABD',
//            'جزيره ابوموسي-AEU' => 'AEU',
//            'اراک-AJK' => 'AJK',
//            'اردبيل-ADU' => 'ADU',
//            'اروميه-OMH' => 'OMH',
//            'اصفهان-IFN' => 'IFN',
//            'آغاجاري-AKW' => 'AKW',
//            'اميديه-OMI' => 'OMI',
//            'ايران شهر-IHR' => 'IHR',
//            'ايلام-IIL' => 'IIL',
//            'بابلسر-BBL' => 'BBL',
//            'بجنورد-BJB' => 'BJB',
//            'بم-BXR' => 'BXR',
//            'بندر لنگه-BDH' => 'BDH',
//            'ماهشهر-MRX' => 'MRX',
//            'بهرگان-IAQ' => 'IAQ',
//            'بيرجند-XBJ' => 'XBJ',
//            'بيشه کولا-BSM' => 'BSM',
//            'پارس آباد-PFQ' => 'PFQ',
//            'پيرانشهر-KHA' => 'KHA',
//            'طبس-TCX' => 'TCX',
//            'توحيد-TEW' => 'TEW',
//            'خارک-KHK' => 'KHK',
//            'سيري-SXI' => 'SXI',
//            'جهرم-JAR' => 'JAR',
//            'جيرفت-JYR' => 'JYR',
//            'چابهار-ZBR' => 'ZBR',
//            'خرم اباد-KHD' => 'KHD',
//            'خوي-KHY' => 'KHY',
//            'دزفول-DEF' => 'DEF',
//            'رامسر-RZR' => 'RZR',
//            'رشت-RAS' => 'RAS',
//            'رفسنجان-RJN' => 'RJN',
//            'زابل-ACZ' => 'ACZ',
//            'زاهدان-ZAH' => 'ZAH',
//            'زنجان-JWN' => 'JWN',
//            'ساري-SRY' => 'SRY',
//            'سبزوار-AFZ' => 'AFZ',
//            'سرخس-CKT' => 'CKT',
//            'سنندج-SDG' => 'SDG',
//            'سيرجان-SYJ' => 'SYJ',
//            'شاهرود-RUD' => 'RUD',
//            'شهر کرد-CQD' => 'CQD',
//            'عسلويه-PGU' => 'PGU',
//            'قزوين-GZW' => 'GZW',
//            'کرج-PYK' => 'PYK',
//            'کرمان-KER' => 'KER',
//            'کرمانشاه-KSH' => 'KSH',
//            'کلاله-KLM' => 'KLM',
//            'گچساران-GCH' => 'GCH',
//            'گرگان-GBT' => 'GBT',
//            'لار-LRR' => 'LRR',
//            'لامرد-LFM' => 'LFM',
//            'مراغه-ACP' => 'ACP',
//            'همدان-HDM' => 'HDM',
//            'ياسوج-YES' => 'YES',
//            'يزد-AZD' => 'AZD',
//
//        ];
//
//
//    }


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
