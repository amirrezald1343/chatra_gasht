<?php

namespace App\Http\Controllers\admin;

use App\Agency;
use App\City;
use App\Destination;
use App\Image;
use App\Level;
use App\Map;
use App\Package;
use App\Price;
use App\Service;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TmpSession;
use App\TmpImage;
use App\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as ImageThumb;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use Illuminate\Support\Facades\Input;


class PackageController extends Controller
{
    private $model = 'App\Package';
    private $paginate = 5;
    const NAME = 'Package';
    const FANAME = 'تور';


    public function index(Request $req)
    {
        if (auth()->user()->isSuperAdmin()) {
            $items = $this->model::with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->orderBy('id', 'desc');
        } else {
            @$agcID = Agency::where('user_id', auth()->user()->id)->first();
            @$agency_id = $agcID->id;

            $items = $this->model::with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->where('agency_id', $agency_id)->orderBy('id', 'desc');
        }


        /*      $items = $items->paginate($this->paginate);
             dd($items[0]->cities);*/

        if ($req->sendFilter) {




            if ($req->agency) {
                $items->where('agency_id', $req->agency);
            }

            if ($req->tourType) {
                $items->where('tourType', $req->tourType);
            }


            if ($req->origin != null) {
                @$originID = json_decode($req->origin)->id;
                $items->where('origin', $originID);
            }

            if ($req->destination != null) {
                @$destinationID = json_decode($req->destination)->id;
                $items->whereHas('cities', function ($query) use ($destinationID) {
                    $query->where('city_id', $destinationID);
                });
            }



            if ($req->tourStatus) {
                if ($req->tourStatus == 'n') {
                    $items->where('status', '0');
                }

                if ($req->tourStatus == 'y') {
                    $items->where('status', '1');
                }
            }


            if($req->hideExpires){
                $items->where('start_in', '>=', date(Carbon::now()->format('Y-m-d')));
            }

            $getAgencyName = Agency::where('id', $req->agency)->pluck('company')->first();

            $filterParams = [
                'agency' => $req->agency,
                'agencyName' => $getAgencyName,
                'tourType' => $req->tourType,
                'tourStatus' => $req->tourStatus,
                'hideExpires' => $req->hideExpires ?? null
            ];


            if ($req->origin != 'null') {
                @$filterParams['originId'] = json_decode($req->origin)->id;
                @$filterParams['originTitle'] = json_decode($req->origin)->title_fa;
            } else {
                $filterParams['originId'] = null;
                $filterParams['originTitle'] = null;
            }

            if ($req->destination != 'null') {
                @$filterParams['destinationId'] = json_decode($req->destination)->id;
                @$filterParams['destinationTitle'] = json_decode($req->destination)->title_fa;
            } else {
                $filterParams['destinationId'] = null;
                $filterParams['destinationTitle'] = null;
            }


            /*           'originId' => json_decode($req->origin)->id,
                           'originTitle' => json_decode($req->origin)->title_fa,
                           'destinationId' => json_decode($req->destination)->id,
                           'destinationTitle' => json_decode($req->destination)->title_fa,*/

            $peginate = 1000;
        } else {
            $filterParams = [
                'agency' => null,
                'agencyName' => null,
                'tourType' => null,
                'originId' => null,
                'originTitle' => null,
                'destinationId' => null,
                'destinationTitle' => null,
                'tourStatus' => null,
                'hideExpires' => null
            ];

            $peginate = $this->paginate;
        }

        $items = $items->paginate(5);


        //  dd($items->toArray());

        return view(findView(), [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'items' =>   $items->appends(Input::except('page')),
            'cUrl' => URL::full(),
            'filterParams' => $filterParams
        ]);
    }

    public function create()
    {

        /*------------check_TmpImage-----------------*/
        $images = TmpImage::where('user_id', auth()->user()['id'])->distinct()->get('package_id'); //changeObject to array - id
        foreach ($images as $key => $value) {
            $image = TmpImage::where('package_id', $value->package_id)->first();
            $time1 = \Carbon\Carbon::parse($image->created_at);
            $time2 = \Carbon\Carbon::now()->addDay(-1);
            if ($time1->timestamp < $time2->timestamp) {
                $images_past_history = TmpImage::where('package_id', $value->package_id)->get();
                foreach ($images_past_history as $value_images_past_history) {
                    File::delete($value_images_past_history); //changeObject to array - path
                    Media::where('id', $value_images_past_history)->delete(); //changeObject to array - id
                }
            }
        }
        /*------------Create_Session_TmpTime-----------------*/
        $tmptime = array();
        if (\Session()->exists('tmptime')) {
            $tmptime = session()->get('tmptime');
            array_unshift($tmptime, time());
            \Session(['tmptime' => $tmptime]);
        } else {
            array_unshift($tmptime, time());
            \Session(['tmptime' => $tmptime]);
        }
        /*------------Service-----------------*/
        $Service = Service::where(['status' => '1'])->get();
        /*------------Service-----------------*/
        if (auth()->user()->role == 'superAdmin') {
            $agencies = Agency::where(['status' => '1'])->pluck('company', 'id')->ToArray();
        } else {
            $agencies = null;
        }


        return view(findView(), [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'tmptime' => $tmptime,
            'Service' => $Service,
            'agencies' => $agencies
        ]);
    }

    public function uploadimg(Request $request, $tmptime)
    {
        $model = TmpImage::create([
            'user_id' => auth()->user()->id,
            'package_id' => $tmptime,
        ]);
        $File_Name = $model->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
        $path = 'Package' . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
        if ($request->file->storeAs($path, $File_Name, 'public')) {
            $media = new Media();
            $media->name = $request->file('file')->getClientOriginalName();
            $media->path = 'storage/' . $path . '/' . $File_Name;
            $media->user_id = Auth::user()->id;
            $media->save();
            $model->update(['media_id' => $media->id]);
        }
        return $model->id;
    }

    public function deletimg(Request $request)
    {
        $first = TmpImage::where(['id' => $request->id, 'user_id' => auth()->user()->id])->first();
        File::delete($first->media->path);
        Media::where('id', $first->media->id)->delete();
        return 'ok';
    }

    public function store(Request $request)
    {

//        dd($request->all());



        if (auth()->user()->role == 'superAdmin') {

            $agencyFieldId = $request['agency'];

            $this->validate($request, [
                'start_in' => 'required',
                'number_nights' => 'required|integer',
                'origin' => 'required|integer',
                'cities' => 'required',
                'Services' => 'nullable',
                'travel_method' => 'required|in:aerial,earthy,marine',
                'vehicle_type' => 'required',
                'agency' => 'required'

            ]);
        } else {
            $this->validate($request, [
                'start_in' => 'required',
                'number_nights' => 'required|integer',
                'origin' => 'required|integer',
                'cities' => 'required',
                'Services' => 'nullable',
                'travel_method' => 'required|in:aerial,earthy,marine',
                'vehicle_type' => 'required'
            ]);

            $agcID = Agency::where('user_id', auth()->user()->id)->first();
            @$agencyFieldId = $agcID->id;


            //Agency::where('user_id', auth()->user()->id)->first()['id'];
        }

        if ($request->isOnline) {
            $this->validate($request, [
                'capacity' => 'required',
                'amount_price_package.*' => 'required',
                'amount_price_LTF.*' => 'required',
                'amount_price_baby.*' => 'required',
                'amount_price_BSF.*' => 'required'
            ]);
        }


        if ($request->thumbnail) {
            $saveImageName = time() . $request->thumbnail->getClientOriginalName();
            $image = ImageThumb::make($request->file('thumbnail')->getRealPath())->resize(500, 400)->save('storage/' . 'thumb/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'thumb/' . $image->basename;
        }



        if (!$request->has('moment')) $request->merge(['moment' => '0']);
        if (!$request->has('indoors')) $request->merge(['indoors' => '0']);
        $title = 'تور ';
        foreach (json_decode($request->cities) as $key => $value) {
            $title = $title . $value->title_fa . ((count(json_decode($request->cities)) == ($key + 1)) ? '' : ' + ');
        }
        /*------------Create_Package-----------------*/

        $model = Package::create([
            'title' => $title,
            'start_in' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', ($request->start_in . ' 00:00:00')),
            'number_nights' => $request->number_nights,
            'origin' => $request->origin,
            'travel_method' => $request->travel_method,
            'vehicle_type' => $request->vehicle_type,
            'description' => $request->description,
            'additional_services' => $request->additional_services,
            'documents' => $request->documents,
            'rules' => $request->rules,
            'agency_id' => $agencyFieldId,
            'tourType' => $request->tourType,
            'moment' => $request->moment,
            'indoors' => $request->indoors,
            'imageThumb' => $imageThumbForDb ?? null,
            'isOnline' => $request->isOnline ?? "0",
            'capacity' => $request->capacity ?? 0,
            'special' => $request->special ?? "0"
        ]);

        if ($model) {
            /*------------Cities-----------------*/
            $Maindestinations = [];
            $destinations = [];
            $continents = [];
            if ($request->continents and (count(json_decode($request->continents)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->continents))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'continent'];
                }
            }
            $destinations = [];
            $countries = [];
            if ($request->countries and (count(json_decode($request->countries)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->countries))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'country'];
                }
            }
            $destinations = [];
            $cities = [];
            if ($request->cities and (count(json_decode($request->cities)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->cities))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'city'];
                }
            }
            if (!empty($Maindestinations)) {
                $model->cities()->sync($Maindestinations);
            }
            /*------------Services-----------------*/
            if ($request->services) {
                $services = explode(',', collect(json_decode($request->services))->implode('id', ','));
                $model->services()->sync($services);
            }
            /*------------Levels-----------------*/
            if ($request->title_level) {
                foreach ($request->title_level as $key => $value) {
                    if ($value) {
                        Level::create([
                            'title' => $value,
                            'description' => $request->description_level[$key],
                            'number' => $key + 1,
                            'package_id' => $model->id,
                        ]);
                    }
                }
            }
            /*------------Map-----------------*/
            if ($request->mapsednumber) {
                foreach ($request->mapsednumber as $key => $value) {
                    if (!$request->lat[$key] or !$request->lng[$key]) {
                        continue;
                    }
                    Map::create([
                        'number' => $value,
                        'lat' => $request->lat[$key],
                        'lon' => $request->lng[$key],
                        'title' => $request->mapsedname[$key],
                        'package_id' => $model->id,
                    ]);
                }
            }
            /*------------Prices-----------------*/
            if ($request->name_price_package) {
                foreach ($request->name_price_package as $key => $value) {
                    Price::create([
                        'name' => $value,
                        'type' => $request->type_price_package[$key],
                        'star' => $request->star_price_package[$key],
                        'price' => $request->amount_price_package[$key],
                        'baby' => $request->amount_price_baby[$key],
                        'LTF' => $request->amount_price_LTF[$key],
                        'BSF' => $request->amount_price_BSF[$key],
                        'price_dollar' => $request->amount_price_dollar_package[$key],
                        'currency' => $request->currency_price_package[$key],
                        'package_id' => $model->id,
                    ]);
                }
            }
            /*------------Images-----------------*/
            if ($request->tmptime) {
                if (key_exists($request->tmptime, array_flip(session()->get('tmptime')))) {
                    $images = TmpImage::where(['user_id' => auth()->user()->id, 'package_id' => $request->tmptime])->get();
                    if ($images->count() > 0) {
                        foreach ($images as $value) {
                            Image::create([
                                'title' => $request->titleimg[$value->id] ?? null,
                                'media_id' => $value->media_id,
                                'package_id' => $model->id,
                            ]);
                            $value->delete();
                        }
                    }
                }
            }
            return redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ایجاد شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function show(Package $package)
    { }

    public function edit($id)
    {


        $agency_id = User::with('agency')->where('id', auth()->user()->id)->first()->id;
        $model = $this->model::with('cities', 'levels', 'maps', 'prices', 'images', 'agency', 'services', 'city')->find($id);
        /*------------Service-----------------*/
        $Service = Service::where(['status' => '1'])->get();

        // if ($model->agency_id != Auth::user()->id AND !auth()->user()->isSuperAdmin()) {
        //     return abort(401);
        // }


        return view('admin.Package.edit', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'model' => $model,
            'Service' => $Service,
        ]);
    }

    public function MainUploadImg(Request $request, $id)
    {
        $model = Image::create([
            'package_id' => $id,
        ]);
        $File_Name = $model->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
        $path = 'Package' . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
        if ($request->file->storeAs($path, $File_Name, 'public')) {
            $media = new Media();
            $media->name = $request->file('file')->getClientOriginalName();
            $media->path = 'storage/' . $path . '/' . $File_Name;
            $media->user_id = Auth::user()->id;
            $media->save();
            $model->update(['media_id' => $media->id]);
        }
        return $model->id;
    }

    public function MainDeleteImg(Request $request)
    {
        if ($request->type == 'IMG') {
            $first = Image::where(['id' => $request->id])->first();
            File::delete($first->media->path);
            Image::where('id', $request->id)->delete();
            Media::where('id', $first->media->id)->delete();
            return 'ok';
        } elseif ($request->type == 'TMP') {
            $first = Image::where(['id' => $request->id])->first();
            File::delete($first->media->path);
            Image::where('id', $request->id)->delete();
            Media::where('id', $first->media->id)->delete();
            return 'ok';
        }
    }

    public function update(Request $request, $id)
    {

        if (auth()->user()->role == 'superAdmin') {

            $agencyFieldId = $request['agency'];
            $getStatus = $this->model::find($id)->status;



            $this->validate($request, [
                'start_in' => 'required',
                'number_nights' => 'required|integer',
                'origin' => 'required|integer',
                'cities' => 'required',
                'Services' => 'nullable',
                'travel_method' => 'required|in:aerial,earthy,marine',
                'vehicle_type' => 'required',
                'agency' => 'required',
            ]);
        } else {

            $this->validate($request, [
                'start_in' => 'required',
                'number_nights' => 'required|integer',
                'origin' => 'required|integer',
                'cities' => 'required',
                'Services' => 'nullable',
                'travel_method' => 'required|in:aerial,earthy,marine',
                'vehicle_type' => 'required',
            ]);

            $agcID = Agency::where('user_id', auth()->user()->id)->first();
            @$agencyFieldId = $agcID->id;

            $getStatus = "0";
        }

        if ($request->thumbnail) {
            $saveImageName = time() . $request->thumbnail->getClientOriginalName();
            $image = ImageThumb::make($request->file('thumbnail')->getRealPath())->resize(500, 400)->save('storage/' . 'thumb/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'thumb/' . $image->basename;
        } else {
            $imageThumbForDb = DB::table('packages')->select()->where('id', $id)->first()->imageThumb;
        }






        if (!$request->has('moment')) $request->merge(['moment' => '0']);
        if (!$request->has('indoors')) $request->merge(['indoors' => '0']);
        $title = 'تور ';
        foreach (json_decode($request->cities) as $key => $value) {
            $title = $title . $value->title_fa . ((count(json_decode($request->cities)) == ($key + 1)) ? '' : ' + ');
        }
        $findoStatus = $this->model::find($id);

        $find = $this->model::find($id);

        

        $update = $find->update([
            'title' => $title,
            'start_in' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', ($request->start_in . ' 00:00:00')),
            'number_nights' => $request->number_nights,
            'origin' => $request->origin,
            'travel_method' => $request->travel_method,
            'vehicle_type' => $request->vehicle_type,
            'description' => $request->description,
            'agency_id' => $agencyFieldId,
            'additional_services' => $request->additional_services,
            'documents' => $request->documents,
            'rules' => $request->rules,
            'tourType' => $request->tourType,
            'moment' => $request->moment,
            'indoors' => $request->indoors,
            'imageThumb' => $imageThumbForDb ?? null,
            'status' => (@$request->status and @$request->status == 1) ? "1" : "0",
            'isOnline' => $request->isOnline ?? "0",
            'capacity' => $request->capacity ?? 0,
            'special' => $request->special ?? "0",
            'lastUserId' => auth()->user()->id
        ]); //'status' => $getStatus,


        if ($update) {
            /*------------Cities-----------------*/
            $Maindestinations = [];
            $destinations = [];
            $continents = [];
            if ($request->continents and (count(json_decode($request->continents)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->continents))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'continent'];
                }
            }
            $destinations = [];
            $countries = [];
            if ($request->countries and (count(json_decode($request->countries)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->countries))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'country'];
                }
            }
            $destinations = [];
            $cities = [];
            if ($request->cities and (count(json_decode($request->cities)) > 0)) {
                $destinations = explode(',', collect(json_decode($request->cities))->implode('id', ','));
                foreach ($destinations as $key => $value) {
                    $Maindestinations[$value] = ['type' => 'city'];
                }
            }
            if (!empty($Maindestinations)) {
                $find->cities()->detach();
                $find->cities()->syncWithoutDetaching($Maindestinations);
            }
            /*------------Services-----------------*/


            if ($request->services) {
                $services = explode(',', collect(json_decode($request->services))->implode('id', ','));
                $find->services()->detach();
                if ($request->services != "[]") {
                    $find->services()->syncWithoutDetaching($services);
                }
            }

            /*------------Levels-----------------*/
            Level::where('package_id', $id)->delete();
            if ($request->title_level) {
                foreach ($request->title_level as $key => $value) {
                    if ($value) {
                        Level::create([
                            'title' => $value,
                            'description' => $request->description_level[$key],
                            'number' => $key + 1,
                            'package_id' => $id,
                        ]);
                    }
                }
            }
            /*------------Map-----------------*/
            Map::where('package_id', $id)->delete();
            if ($request->mapsednumber) {
                foreach ($request->mapsednumber as $key => $value) {
                    if (!$request->lat[$key] or !$request->lng[$key]) {
                        continue;
                    }
                    Map::create([
                        'number' => $value,
                        'lat' => $request->lat[$key],
                        'lon' => $request->lng[$key],
                        'title' => $request->mapsedname[$key],
                        'package_id' => $id,
                    ]);
                }
            }
            /*------------Prices-----------------*/
            Price::where('package_id', $id)->delete();
            if ($request->name_price_package) {
                foreach ($request->name_price_package as $key => $value) {
                    Price::create([
                        'name' => $value,
                        'type' => $request->type_price_package[$key],
                        'star' => $request->star_price_package[$key],
                        'price' => $request->amount_price_package[$key],
                        'baby' => $request->amount_price_baby[$key],
                        'LTF' => $request->amount_price_LTF[$key],
                        'BSF' => $request->amount_price_BSF[$key],
                        'price_dollar' => $request->amount_price_dollar_package[$key],
                        'currency' => $request->currency_price_package[$key],
                        'package_id' => $id,
                    ]);
                }
            }
            /*------------Images-----------------*/
            $images = Image::where(['package_id' => $id])->get();
            if ($images->count() > 0) {
                foreach ($images as $value) {
                    $value->update([
                        'title' => $request->titleimg[$value->id] ?? null
                    ]);
                }
            }

            // dd($findoStatus->status . ' - ' . $find->status);
            if (auth()->user()->role == 'superAdmin') {
                if ($findoStatus->status != $find->status and @$request->status == 1) {
                    //   dd('a');
                    $smsMessage = '' . $find->title . ' با موفقیت تایید شد و در سایت قابل مشاهده میباشد ' . "\n" . ' کلیک سفر ';
                    if (@$find->agency->cellPhone) {
                        $sendSms = Smsirlaravel::send([$smsMessage], [@$find->agency->cellPhone]);
                    }
                }
            }


            return redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ویرایش شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function destroy(Package $package)
    {
        //
    }


    public function lisCity(Request $request)
    {

        $cities = City::where('title_fa', 'like', '%' . $request->search . '%')
            ->where('types', 'city')
            ->select('id', 'title_fa')->get();

        return response()->json($cities);
    }

    public function listCountries(Request $request)
    {

        $cities = City::where('title_fa', 'like', '%' . $request->search . '%')
            ->where('types', 'country')
            ->select('id', 'title_fa')->get();

        return response()->json($cities);
    }

    public function listContinents(Request $request)
    {

        $cities = City::where('title_fa', 'like', '%' . $request->search . '%')
            ->where('types', 'continent')
            ->select('id', 'title_fa')->get();

        return response()->json($cities);
    }

    public function listAgencies(Request $request)
    {
        $agencies = Agency::where('company', 'like', '%' . $request->search . '%')->select('id', 'company')->get();
        return response()->json($agencies);
    }

    public function listTours(Request $request)
    {
        $cities = Package::where('title', 'like', '%' . $request->search . '%')->select('id', 'title')->get();
        return response()->json($cities);
    }
}
