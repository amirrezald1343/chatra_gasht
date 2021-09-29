<?php

namespace App\Http\Controllers\admin;

use App\Agency;
use App\Gasht;
use App\GashtSell;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transfer;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;

use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as ImageThumb;

//use Ipecompany\Smsirlaravel\Smsirlaravel;

class GashtController extends Controller
{

    private $model = 'App\Gasht';
    private $paginate = 20;
    const NAME = 'Gasht';
    const FANAME = 'گشت و گذار';


    public function index(Request $req)
    {

        if (auth()->user()->isSuperAdmin()) {

            $items = Gasht::with('agency', 'city')->orderBy('id', 'DESC');
        } else {
            $items = Gasht::where('agency_id', auth()->user()->agency->id)->with('agency', 'city');
        }

        //  $gasht = Agency::with('gasht_city')->get();

        if ($req->sendFilter) {

            if ($req->agency) {
                $items->where('agency_id', $req->agency);
            }

            if ($req->gashtstatus) {

                if ($req->gashtstatus == 'pendding') {

                    $items->where('status', 'pendding');
                }
                if ($req->gashtstatus == 'active') {

                    $items->where('status', 'active');
                }
                if ($req->gashtstatus == 'unactive') {

                    $items->where('status', 'unactive');
                }
                if ($req->gashtstatus == 'expire') {

                    $items->where('status', 'expire');
                }
            }
            $getAgencyName = Agency::where('id', $req->agency)->pluck('company')->first();
            $filterParams = [
                'agency' => $req->agency,
                'agencyName' => $getAgencyName,
                'gashtstatus' => $req->gashtstatus,
            ];
            $peginate = 1000;
        } else {
            $filterParams = [
                'agency' => null,
                'agencyName' => null,
                'gashtstatus' => null,
            ];
            $peginate = $this->paginate;
        }


        $items = $items->paginate($this->paginate);

        return view('admin.Gasht.index', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'items' => $items->appends(Input::except('page')),
            'filterParams' => $filterParams
        ]);
    }

    public function create()
    {

        return view('admin.Gasht.create', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME
        ]);
    }

    public function store(Request $req)
    {

        //  dd($req);
        //  dd($this->changeLang($req->start_date));

        if (auth()->user()->role == 'superAdmin') {
            $this->validate($req, [
                'title' => 'required',
                'type' => 'required',
                'city' => 'required',
                'typedate' => 'required',
                'agency' => 'required',
                'start_date.*' => 'required',
                'end_date.*' => 'required',
                'adult.*' => 'required',
                'child.*' => 'required',
                'capacity.*' => 'required',
                'file' => 'mimes:jpg,jpeg,png'
            ]);
            $agencyId = $req->agency;
        } else {
            $this->validate($req, [
                'title' => 'required',
                'type' => 'required',
                'city' => 'required',
                'typedate' => 'required',
                'start_date.*' => 'required',
                'end_date.*' => 'required',
                'adult.*' => 'required',
                'child.*' => 'required',
                'capacity.*' => 'required',
                'file' => 'mimes:jpg,jpeg,png'
            ]);
            $agencyId = auth()->user()->agency->id;
        }

        $randNumbers = rand(100000, 999999);

        //Dd(@auth()->user()->agency->id);

        if (!@auth()->user()->agency->id) {
            //  return  redirect()->back()->with(['error' => ' امکان ثبت برای شما وجود ندارد ']);
        }

        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(300, 250)->save('storage/' . 'gasht/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'gasht/' . $image->basename;
        }


        if (!$req->title) {
            return redirect()->back()->with(['error' => 'برای گشت حداقل یک ردیف ثبت کنید']);
        }

        if ($req->services) {
            $services = '';
            foreach (json_decode($req->services) as $rowt => $service) {
                $services .= $service->value . ',';
            }
            $services = trim($services, ',');
        } else {
            $services = '';
        }

        if ($req->supplies) {
            $supplies = '';
            foreach (json_decode($req->supplies) as $rowt => $supply) {
                $supplies .= $supply->value . ',';
            }
            $supplies = trim($supplies, ',');
        } else {
            $supplies = '';
        }


        foreach ($req->start_date as $row => $vals) {
            $inputEndDate = $req->end_date[$row];

          //  $typeDate=$req->typedate[$row];


            $startDate = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', $this->changeLang($vals));
            $endDate = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', $this->changeLang($inputEndDate));
            $startDate = $startDate->format('Y-m-d');
            $endDate = $endDate->format('Y-m-d');
            $startD = Carbon::parse($startDate);
            $endD = Carbon::parse($endDate);
            $diffDays = $endD->diffInDays($startD);


            if (strtotime($startDate) > strtotime($endDate)) {
                return redirect()->back()->with(['error' => 'تاریخ پایان نباید از تاریخ شروع جلوتر باشد']);
            }


            $created_at = date("Y-m-d H:i:s");


            $dateDiffArray = array();
            for ($i = 0; $i <= $diffDays; $i++) {
                $dateDiffArray[] = date("Y-m-d", strtotime($startD . " + $i days"));
            }


            foreach ($dateDiffArray as $rowDiffDay) {


                if ($req->adult[$row]) {
                    $adultPrice = str_replace(',', '', $req->adult[$row]);
                } else {
                    $adultPrice = null;
                }


                if ($req->child[$row]) {
                    $childPrice = str_replace(',', '', $req->child[$row]);
                } else {
                    $childPrice = null;
                }

                if (in_array(Jalalian::forge($rowDiffDay)->format('%A') ,$req->expect)){
                    continue;
                }
                

                if ($req->typedate[$row] == 'zoj') {
                    if (Jalalian::forge($rowDiffDay)->format('%A') == 'یکشنبه' or Jalalian::forge($rowDiffDay)->format('%A') == 'سه شنبه' or Jalalian::forge($rowDiffDay)->format('%A') == 'پنجشنبه') {
                        continue;
                    }
                }

                if ($req->typedate[$row] == 'fard') {
                    if (Jalalian::forge($rowDiffDay)->format('%A') == 'شنبه' or Jalalian::forge($rowDiffDay)->format('%A') == 'دوشنبه' or Jalalian::forge($rowDiffDay)->format('%A') == 'چهارشنبه') {
                        continue;
                    }
                }




                DB::insert(
                    "insert ignore into gashts (`title`, `agency_id` , `city_id` , `date` , `typedate` , `desc` , `services` , `supplies` , `adult` , `child` , `capacity` , `minCount` , `rand` , `created_at`,`image`,`type`) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    [
                        "$req->title",
                        $agencyId,
                        json_decode($req->city)->id,
                        "$rowDiffDay",
                        $req->typedate[$row],
                        "$req->desc",
                        $services ?? NULL,
                        $supplies ?? NULL,
                        $adultPrice,
                        $childPrice,
                        $req->capacity[$row] ?? null,
                        $req->minCount[$row] ?? null,
                        "$randNumbers",
                        "$created_at",
                        $imageThumbForDb ?? null,
                        $req->type
                    ]
                );
            }


        }

        return redirect()->back()->with([
            'success' => 'گشت جدید با موفقیت ثبت شد',
            'NAME' => self::NAME,
            'FANAME' => self::FANAME
        ]);
    }

    public function edit(Gasht $gasht)
    {

        //dd($gasht);
        return view('admin.Gasht.edit', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'gasht' => $gasht
        ]);
    }

    public function update(Request $req, $id)
    {

        if (!auth()->user()->isSuperAdmin()) {
            if (Gasht::find($id)->agency_id != auth()->user()->agency->id) {
                abort(401, ' you do not have access to this Item ');
            }
        }


        $this->validate($req, [
            'title' => 'required',
            'type' => 'required',
            'adult' => 'required',
            'child' => 'required',
            'capacity' => 'required',
        ]);


        if ($req->services) {
            $services = '';
            foreach (json_decode($req->services) as $rowt => $service) {
                $services .= $service->value . ',';
            }
            $services = trim($services, ',');
        } else {
            $services = '';
        }

        if ($req->supplies) {
            $supplies = '';
            foreach (json_decode($req->supplies) as $rowt => $supply) {
                $supplies .= $supply->value . ',';
            }
            $supplies = trim($supplies, ',');
        } else {
            $supplies = '';
        }


        if (auth()->user()->isSuperAdmin()) {
            Gasht::find($id)->update([
                'status' => $req->status
            ]);
        }
        $findoStatus = $this->model::find($id);

        $find = $this->model::find($id);

        $gashtUpdateArray = [
            'title' => $req->title,
            'type' => $req->type,
            'services' => $services ?? NULL,
            'supplies' => $supplies ?? NULL,
            'desc' => $req->desc,
//            'typedate' => $req->typedate,
            'adult' => str_replace(',', '', $req->adult),
            'child' => str_replace(',', '', $req->child),
            'capacity' => $req->capacity,
            'minCount' => $req->minCount,
//           'updated_at' => $req->date
//            'updated_at' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($req->date))
        ];
        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(300, 250)->save('storage/' . 'gasht/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'gasht/' . $image->basename;

            $gashtUpdateArray = array_merge($gashtUpdateArray, ['image' => $imageThumbForDb]);
        }


        //  dd($gashtUpdateArray);


        Gasht::find($id)->update($gashtUpdateArray);


        // dd($findoStatus->status . ' - ' . $find->status);
//
//        if($req->sendSms)
//        {
//            $smsMsg="گشت شما با موفقیت ایجاد شد";
//            Smsirlaravel::send([$smsMsg],[$req->cellPhone]);
//        }
        return redirect()->back()->with([
            'success' => 'گشت  با موفقیت ویرایش شد',
            'NAME' => self::NAME,
            'FANAME' => self::FANAME
        ]);
    }

    public function sellList(Request $req)
    {
//        dd("dd");
        if (auth()->user()->isSuperAdmin()) {
            $items = GashtSell::with('gasht');
            $wordCount = $items->count();
            // return $listGasht;
        }

        else {
            $items = GashtSell::with('gasht')
                ->whereHas('gasht', function ($q) {
//                    $q->where('gasht_id', '=', auth()->user()->id);
                    $q->where('agency_id', '=', auth()->user()->agency->id);
                }
                );
            //  $items = GashtSell::with('gasht');
        }



        if ($req->sendFilter) {

//            if ($req->title) {
//                $items = GashtSell::with('gasht')->where('title', 'like', '%' . $req->title . '%');
//
//            }
            if ($req->reserve_id) {
                $items->where('reserve_id', $req->reserve_id);
            }
            if ($req->customer_name) {
                $items->where('customer_name', $req->customer_name);
            }

            if ($req->customer_mobile) {
                $items->where('customer_mobile', $req->customer_mobile);
            }
//            $items=$items->latest()->paginate(15);
//            dd($items);
//            $getAgencyName = Gasht::where('id', $req->title)->pluck('title')->first();
            if ($req->date) {
                $date = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $req->date)->format('Y-m-d');
                $items = GashtSell::whereHas('gasht', function ($query) use ($date) {
                    $query->where('date', '>', $date);
                });
            }
            if ($req->created_at) {
                $date1 = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $req->created_at)->format('Y-m-d');
                if ($req->created_at2) {
                    $date2 = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $req->created_at2)->format('Y-m-d');
                    $items = GashtSell::with('gasht')->whereBetween('created_at', [$date1, $date2]);
                } else {
                    $items = GashtSell::with('gasht')->where('created_at', '>', $date1);
                }
//                $items->where('created_at', $req->created_at);
            }


            $getdate = Gasht::pluck('date');
            $getcreate = Gasht::pluck('created_at');

            $filterParams = [
                'title' => $getdate,
                'reserve_id' => $req->reserve_id,
                'customer_mobile' => $req->customer_mobile,
                'customer_name' => $req->customer_name,
                'created_at' => $getcreate,
                'date' => $req->date,
            ];
            $peginate = 1000;
        }
        else {
            $filterParams = [
                'title' => null,
                'reserve_id' => null,
                'customer_mobile' => null,
                'customer_name' => null,
                'created_at' => null,
                'date' => null,
            ];
            $peginate = $this->paginate;
        }
        $items = $items->latest()->paginate(15); //  dd($items);

//        $listGasht=$items->paginate($this->paginate);

        $wordCount = $items->count();



        return view('admin.Gasht.sellList', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'items' => $items->appends(Input::except('page')),
            'wordCount' => $wordCount,
            'filterParams' => $filterParams
        ]);

    }

    public function destroy(Request $req)
    {

        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with(['success' => ' امکان حذف وجود ندارد ']);
        }

        Gasht::destroy($req->id);
        return redirect()->back()->with(['success' => 'گشت با موفقیت حذف شد']);
    }

    public function deletecheck(Request $req)
    {


        if (!auth()->user()->isSuperAdmin())
        {
            return redirect()->back()->with(['success' => ' امکان حذف وجود ندارد ']);
        }
        {
            Gasht::whereIn('id', $req->input('listGasht'))->delete();
            return redirect()->back()->with(['success' => 'گشت با موفقیت حذف شد']);

        }


    }

    public function activestatus(Request $req)
    {
        if (auth()->user()->isSuperAdmin())
        {
            Gasht::whereIn('id', $req->input('listGasht'))->update([
                'status' => $req->status = "active"
            ]);
        }
        return redirect()->back()->with(['success' => 'وضعیت گشت با موفقیت ویرایش شد']);
    }

    public function unactivestatus(Request $req)
    {
        if (auth()->user()->isSuperAdmin())
        {
            Gasht::whereIn('id', $req->input('listGasht'))->update([
                'status' => $req->status = "unactive"
            ]);
        }
        return redirect()->back()->with(['success' => 'وضعیت گشت با موفقیت ویرایش شد']);
    }

    public function changeLang($data)
    {

        // if(!is_numeric($data) || empty($data))
        // return '۰';
        $en = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $fa = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
        return str_replace($fa, $en, $data);
    }
    
}
