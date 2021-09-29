<?php

namespace App\Http\Controllers;

use App\Media;
use App\Permission;
use App\SiteData;
use App\Agency;
use App\City;
use App\Package;
use App\Price;
use App\User;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Morilog\Jalali\Jalalian;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Illuminate\Support\Facades\Session;

class TourController extends Controller
{
    private $paginate = 40;


    function search(Request $request, $typeRoute = null, $valueRoute = null)
    {

        $tourInOut = 'n';
        $tourTypeToCeck = 'none';
        /*---------------create-session-request--------------*/
        if ($request->has('destination') && $request->has('destination')) {
            $model = $request->all();
            session(['search' => $request->all()]);
        }

        
        if (!$request->has('destination') && !$request->has('destination') && session()->has('search')) {

            $request->merge(['start_in' => session()->get('search.start_in')]);

            $request->merge(['destination' => session()->get('search.destination')]);


            $model = $request->all();
        }

        if (!$request->page) {
            session(['statusFilter' => 0]);
        }
        if (session()->has('filter') && session()->has('statusFilter') && (session()->get('statusFilter') == 1) && $request->page) {
            $modelFilter = session()->get('filter');
            
        }
        

        $agencies = Agency::where('status', '1')->pluck('id')->toArray();
        $Tours = Package::where('start_in', '>=', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1');
        
        /*-----start_in----*/
        if ($request->start_in) {
            $fromDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in), 01))->toCarbon()->format('Y-m-d'));
            $toDate = date(
                (
                    new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(),
                    getMonthNumber($request->start_in), 01))
                    ->addMonths(1)->subDays(1)->format('Y-m-d')
            );
            $Tours->whereBetween('start_in', [$fromDate, $toDate]);
        }
        /*-----destination----*/
        if ($request->destination) {
            $packages = City::where('id', json_decode($request->destination)->id)->with('packages')->first()->packages;
            $packages = explode(',', collect($packages)->implode('id', ','));
            $Tours->whereIn('packages.id', $packages);
        }


        /*-----Tour(internal,foreign)---*/
        if ($typeRoute == 'destination' && $valueRoute != null) {
            $packages = City::where('id', $valueRoute)->with('packages')->first();
            if ($packages) {
                $packages = explode(',', collect($packages->packages)->implode('id', ','));
                $Tours->whereIn('packages.id', $packages);
            }
        }
        /*-----Tour-Indoors(one,several)---*/
        if ($typeRoute == 'indoors' && $valueRoute != null) {
            if ($valueRoute == 'one') {
                $Tours->where('indoors', '1')->where('number_nights', '=', 1);
            } elseif ($valueRoute == 'several') {
                $Tours->where('indoors', '1')->where('number_nights', '>', 1);
            }
        }
        /*-----Tour-Moment---*/
        if ($typeRoute == 'moment') {
            $Date = date(Carbon::now()->addDays(7)->format('Y-m-d'));
            $Tours->Where('start_in', '<=', $Date);
        }

        if ($typeRoute == 'internal') {
            $Tours->Where('tourType', 'internal');
            $tourInOut = 'y';
            $tourTypeToCeck = 'internal';
        }

        if ($typeRoute == 'foreign') {
            $Tours->Where('tourType', 'foreign');
            $tourInOut = 'y';
            $tourTypeToCeck = 'foreign';
        }


        /*---------------Filter--------------*/
        $Tours_filter = $Tours->with('city')->get();
        $numberNights = array();
        $origins = array();
        foreach ($Tours_filter as $key => $value) {
            if (!key_exists($value->city->id, $origins)) {
                $origins[$value->city->id] = $value->city->title_fa;
            }
            if (!key_exists($value->number_nights, $numberNights)) {
                $numberNights[$value->number_nights] = $key;
            }
        }
        if (isset($modelFilter)) {
            if (key_exists('origins', $modelFilter)) $Tours->whereIn('origin', $modelFilter['origins']);
            if (key_exists('numberNights', $modelFilter)) $Tours->whereIn('number_nights', $modelFilter['numberNights']);
            if (key_exists('typeTrip', $modelFilter)) $Tours->whereIn('travel_method', $modelFilter['typeTrip']);
            if (key_exists('typeTour', $modelFilter)) $Tours->whereIn('tourType', $modelFilter['typeTour']);
            if (key_exists('stars', $modelFilter)) {
                $packages_id_star = Price::whereIn('star', $modelFilter['stars'])->distinct()->pluck('package_id')->toArray();
                $Tours->whereIn('packages.id', $packages_id_star);
            }
        }

        //   $Tours = $Tours
        //->select('packages.id as a_ID','packages.title as a_title','packages.start_in as a_start_in','packages.number_nights as a_number_nights','packages.travel_method as a_travel_method','packages.vehicle_type as a_vehicle_type','packages.tourType as a_tourType')
        //  ->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')
        // ->leftJoin('prices','prices.package_id','=','packages.id')
        //  ->paginate($this->paginate);


        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        $getUsd = $getUsd ?? 1;
        $getEuro = $getEuro ?? 1;

        $Tours = $Tours
            ->select(
                'packages.id',
                'packages.title',
                'packages.start_in',
                'packages.number_nights',
                'packages.travel_method',
                'packages.vehicle_type',
                'packages.tourType',
                'packages.origin',
                'packages.agency_id',
                'packages.country_id',
                'packages.imageThumb',
                DB::raw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as minPrice"),
                DB::raw("MAX(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as maxPrice")
            )
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')
            ->groupBy('packages.id')
            ->orderBy('minPrice')
            ->paginate($this->paginate);




        return view('site.tour.tourList', [
            'Tours' => $Tours,
            'minPirce' => 0,
            'maxPirce' => $Tours->last()->minPrice ?? 1,
            'maxPirceTotal' => $Tours->last()->minPrice ?? 1,
            'model' => $model ?? null,
            'origins' => $origins,
            'numberNights' => $numberNights,
            'tourInOuts' => $tourInOut,
            'tourTypeToChecks' => $tourTypeToCeck,
            'modelFilter' => $modelFilter ?? '',
        ]);
    }

    function details($id)
    {
        $tour = Package::where(['status' => '1'])->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->findOrFail($id);

        Package::where('id', $id)->update(['visitCount' => $tour->visitCount + 1]);

        if ($tour->agency->status == '1') {
            return view('site.tour.tourDetails', [
                'tour' => $tour,
            ]);
        } else {
            abort('404');
        }
    }

    public function filter(Request $request, $typeRoute = null, $valueRoute = null)
    {

        // dd('hello commander');
        //  dd($request);

        $tourInOut = 'n';
        $tourTypeToCeck = 'none';
        $model = session()->get('search');
        /*-filter-origin-*/
        $agencies = Agency::where('status', '1')->pluck('id')->toArray();
        $Tours = Package::where('start_in', '>=', date(Carbon::now()->format('Y-m-d')))->whereIn('agency_id', $agencies)->where('status', '1');
        /*-----start_in----*/
        if ($model['start_in']) {

            if (getMonthNumber($request->start_in) != '') {
                $fromDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in), 01))->toCarbon()->format('Y-m-d'));
            }

            if (getMonthNumber($request->start_in) != '') {
                $toDate = date((new Jalalian(\Morilog\Jalali\Jalalian::now()->getYear(), getMonthNumber($request->start_in) + 1, 01))->addDays(-1)->toCarbon()->format('Y-m-d'));
            }

            if (@$fromDate and @$toDate) {
                $Tours->whereBetween('start_in', [$fromDate, $toDate]);
            }
        }
        /*-----destination----*/
        if (@$model['destination']) {
            $packages = City::where('id', json_decode($model['destination'])->id)->with('packages')->first()->packages;
            $packages = explode(',', collect($packages)->implode('id', ','));
            $Tours->whereIn('packages.id', $packages);
        }
        /*-----Tour(internal,foreign)---*/
        if ($typeRoute == 'destination' && $valueRoute != null) {
            $packages = City::where('id', $valueRoute)->with('packages')->first();
            if ($packages) {
                $packages = explode(',', collect($packages->packages)->implode('id', ','));
                $Tours->whereIn('packages.id', $packages);
            }
        }
        /*-----Tour-Indoors(one,several)---*/
        if ($typeRoute == 'indoors' && $valueRoute != null) {
            if ($valueRoute == 'one') {
                $Tours->where('indoors', '1')->where('number_nights', '=', 1);
            } elseif ($valueRoute == 'several') {
                $Tours->where('indoors', '1')->where('number_nights', '>', 1);
            }
        }
        /*-----Tour-Moment---*/
        if ($typeRoute == 'moment') {
            $Date = date(Carbon::now()->addDays(7)->format('Y-m-d'));
            $Tours->Where('start_in', '<=', $Date);
        }
        /*---------------Filter--------------*/
        $Tours_model = $Tours->with('city')->get();
        $numberNights = array();
        $origins = array();
        foreach ($Tours_model as $key => $value) {
            if (!key_exists($value->city->id, $origins)) {
                $origins[$value->city->id] = $value->city->title_fa;
            }
            if (!key_exists($value->number_nights, $numberNights)) {
                $numberNights[$value->number_nights] = $key;
            }
        }
        if ($request->origins) $Tours->whereIn('origin', $request->origins);
        if ($request->numberNights) $Tours->whereIn('number_nights', $request->numberNights);
        if ($request->typeTrip) $Tours->whereIn('travel_method', $request->typeTrip);
        if ($request->typeTour) $Tours->whereIn('tourType', $request->typeTour);
        if ($request->stars) {
            $packages_id_star = Price::whereIn('star', $request->stars)->distinct()->pluck('package_id')->toArray();
            $Tours->whereIn('packages.id', $packages_id_star);
        }






        //     $Tours = $Tours->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderby('id', 'DESC')->paginate($this->paginate);

        $getUsd = Currency::where('type', 'usd')->first()->amount;
        $getEuro = Currency::where('type', 'euro')->first()->amount;

        $getUsd = $getUsd ?? 1;
        $getEuro = $getEuro ?? 1;

        $Tours->select(
            'packages.id',
            'packages.title',
            'packages.start_in',
            'packages.number_nights',
            'packages.travel_method',
            'packages.vehicle_type',
            'packages.tourType',
            'packages.origin',
            'packages.agency_id',
            'packages.country_id',
            'packages.imageThumb',
            DB::raw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as minPrice"),
            DB::raw("MAX(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) as maxPrice")
        )
            ->leftJoin('prices', 'prices.package_id', '=', 'packages.id')
            ->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')
            ->groupBy('packages.id');

        @$minAndMax = @$Tours->orderBy('minPrice')->paginate($this->paginate)->last()->minPrice;

        //dd($minAndMax);

        // if (isset($request->minPriceFilter) and isset($request->maxPriceFilter) and @$request->minPriceFilter > 0) {
        //     $Tours->havingRaw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) between ? AND ?", [$request->minPriceFilter, $request->maxPriceFilter]);
        // }

        if (isset($request->minPriceFilter) and isset($request->maxPriceFilter) and @$request->minPriceFilter > 0) {

            $Tours->havingRaw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) >= ? AND MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) <= ?", [$request->minPriceFilter, $request->maxPriceFilter]);
        } elseif (isset($request->minPriceFilter) and isset($request->maxPriceFilter) and @$request->minPriceFilter <= 0) {

            $Tours->havingRaw("MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) <= $request->maxPriceFilter  OR  MIN(prices.price + IF(prices.price_dollar,(prices.price_dollar  * IF(prices.currency='usd',$getUsd,$getEuro) ),0)) IS NULL");
        }

        $Tours = $Tours->orderBy('minPrice')->paginate($this->paginate);

        $modelFilter = $request->all();
        session(['filter' => $modelFilter]);
        session(['statusFilter' => 1]);


        if ($typeRoute == 'internal') {
            $tourInOut = 'y';
            $tourTypeToCeck = 'internal';
        }

        if ($typeRoute == 'foreign') {
            $tourInOut = 'y';
            $tourTypeToCeck = 'foreign';
        }


        if (isset($request->minPriceFilter)) {
            $minPriceFil = $request->minPriceFilter;
        } elseif ($Tours->last()->maxPrice) {
            $minPriceFil = $Tours->last()->maxPrice;
        } else {
            $minPriceFil = 0;
        }

        if (isset($request->maxPriceFilter)) {
            $maxPriceFil = $request->maxPriceFilter;
        } elseif ($Tours->last()->maxPrice) {
            $maxPriceFil = $Tours->last()->maxPrice;
        } else {
            $maxPriceFil = 0;
        }

        
        return view('site.tour.tourList', [
            'Tours' => $Tours,
            'minPirce' => $minPriceFil,
            'maxPirce' => $maxPriceFil,
            'maxPirceTotal' => $minAndMax ?? 1,
            'model' => $model,
            'modelFilter' => $modelFilter,
            'origins' => $origins,
            'tourInOuts' => $tourInOut,
            'tourTypeToChecks' => $tourTypeToCeck,
            'numberNights' => $numberNights,
        ]);
    }

    public function lisCity(Request $request)
    {
        $cities = City::where('title_fa', 'like', '%' . $request->search . '%')->select('id', 'title_fa')->get();
        return response()->json($cities);
    }
    
    
    public function aboutPage()
    {
        $about = SiteData::where('type', 'about')->first();
        return view('site.about', compact('about'));
    }
    
    public function contactPage()
    {
        $contact = SiteData::where('type', 'contact')->first();
        return view('site.contact', compact('contact'));
    }
    
    public function rulesPage()
    {
        $rules = SiteData::where('type', 'rules')->first();
        return view('site.rules', compact('rules'));
    }


    public function createAgency()
    {
        return view('site.createAgency');
    }

    public function createAgencyPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'nationalNumber' => 'required',
            'domain' => 'nullable|unique:agencies,domain',
            'company' => 'required',
            'tellPhone' => 'required',
            'cellPhone' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'captcha' => 'required|captcha'
            ]);
            
        $agencyRules = '';
        if ($model = Agency::create([
            'name' => $request['name'],
            'nationalNumber' => $request['nationalNumber'],
            'domain' => $request['domain'],
            'company' => $request['company'],
            'tellPhone' => $request['tellPhone'],
            'cellPhone' => $request['cellPhone'],
            'email' => $request['email'],
            'expDate' => now()->toDateTimeString(),
            'agencyLicense' => $request['agencyLicense'],
            'address' => $request['address'],
            'permission_id' => '2',
            'status' => '0',
            'agencyRules' => "$agencyRules"
        ])) { //($request->except(['file']
            $userAgency = [
                'name' => $request->name,
                'username' => $request->email,
                'nationalNumber' => $request->nationalNumber,
                'email_verified_at' => now()->toDateTimeString(),
                'cellphone' => $request->cellPhone,
                'email' => $request->email,
                'password' => bcrypt($request->nationalNumber),
                'role' => 'admin',
                'permission_id' => 2,
                'status' => '0',
            ];
            $user = User::create($userAgency);
            $model->update(['user_id' => $user->id]);
            
            return redirect()->back()->with(['success' => 'با موفقیت ایجاد شد!']);
        }
        return back()->with(['error', 'خطا در ثبت']);
    }


    /*   public function internalTours()
       {
           $tour = Package::where('status', '1')->where('tourType', 'internal')->where('start_in', '>=', date(Carbon::now()->format('Y-m-d')))
               ->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city');

           $tour->whereHas('cities', function ($query) {
               $query->where('status', '1');
           });


           $Tours_filter = $tour->with('city')->get();
           $numberNights = array();
           $origins = array();
           foreach ($Tours_filter as $key => $value) {
               if (!key_exists($value->city->id, $origins)) {
                   $origins[$value->city->id] = $value->city->title_fa;
               }
               if (!key_exists($value->number_nights, $numberNights)) {
                   $numberNights[$value->number_nights] = $key;
               }
           }

           $Tours = $tour->paginate(15);


           return view('site.tour.tourList', [
               'Tours' => $Tours,
               'model' => $model ?? null,
               'origins' => $origins,
               'numberNights' => $numberNights,
               'modelFilter' => $modelFilter ?? '',
               'noFilter' => 'yes'
           ]);

       }*/


    /*    public function foreignTours()
        {
            $tour = Package::where('status', '1')->where('tourType', 'foreign')->where('start_in', '>=', date(Carbon::now()->format('Y-m-d')))
                ->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city');

            $tour->whereHas('cities', function ($query) {
                $query->where('status', '1');
            });


            $Tours_filter = $tour->with('city')->get();
            $numberNights = array();
            $origins = array();
            foreach ($Tours_filter as $key => $value) {
                if (!key_exists($value->city->id, $origins)) {
                    $origins[$value->city->id] = $value->city->title_fa;
                }
                if (!key_exists($value->number_nights, $numberNights)) {
                    $numberNights[$value->number_nights] = $key;
                }
            }

            $Tours = $tour->paginate(15);


            return view('site.tour.tourList', [
                'Tours' => $Tours,
                'model' => $model ?? null,
                'origins' => $origins,
                'numberNights' => $numberNights,
                'modelFilter' => $modelFilter ?? '',
                'noFilter' => 'yes'
            ]);

        }*/


    public function searchAgency(Request $req)
    {







        $getAgencies = Agency::where('status', '1');

        if ($req->search) {
            $searchPost = $req->search;
            $getAgencies->where(function ($q) use ($searchPost) {
                $q->where('company', 'LIKE', "%$searchPost%")->orWhere('address', 'LIKE', "%$searchPost%");
            });
        } else {
            $searchPost = '';
        }

        $getAgencies = $getAgencies->paginate(100);

        return view('site.searchAgency', compact('getAgencies', 'searchPost'));
    }


    public function sendTicket(Request $req)
    {

        date_default_timezone_set('Asia/Tehran');

        $this->validate($req, [
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha'
        ]);

        $idInsert = DB::table('site_tickets')->insertGetId([
            'name' => $req->name,
            'subject' => $req->subject,
            'phone_number' => $req->tell,
            'mail' => $req->email,
            'message' => $req->message,
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!empty($idInsert)) {
            return redirect()->back()->with(['success' => 'تیکت پشتیبانی شما با موفقیت ثبت شد']);
        }
    }



    public function favTourAdd(Request $req)
    {

        if (session()->has('tourCompare') and count(Session::get('tourCompare')) >= 3) {
            echo "moreThenLimit";
            exit;
        } else {
            echo "ok";
        }

        Session::push('tourCompare', $req->tourID);
    }


    public function favTourRemove(Request $req)
    {
        $compareItems = Session::pull('tourCompare', []); // Second argument is a default value
        if (($key = array_search($req->tourID, $compareItems)) !== false) {
            unset($compareItems[$key]);
        }
        Session::put('tourCompare', $compareItems);

        if (session()->has('tourCompare') and count(Session::get('tourCompare')) == 0) {
            echo "isZero";
        }
    }


    public function favTourList(Request $req)
    {

        if (!session()->has('tourCompare')) {
            $favTours = null;
        } else {
            $favToursSession = Session::get('tourCompare');
            $favTours = Package::whereIn('id', $favToursSession)->with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->get();
        }

        return view('site.compare', ['favTours' => $favTours]);
    }


    public function removeFilterCityDates(Request $req)
    {
        session()->put('search.start_in', null);
        //   dd(session()->get('search')['start_in']);

        return $req->url;
    }
}
