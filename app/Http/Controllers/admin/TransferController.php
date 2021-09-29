<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transfer;
use App\TransferItem;

use Carbon\Carbon;

class TransferController extends Controller
{


    private $model = 'App\Transfer';
    private $paginate = 5;
    const NAME = 'Transfer';
    const FANAME = 'ترانسفر';


    public function index()
    {

        if (auth()->user()->isSuperAdmin()) {
            $items = Transfer::with('titems', 'agency', 'city')->latest()->paginate($this->paginate);
        } else {
            $items = Transfer::where('agency_id', auth()->user()->agency->id)->with('titems', 'agency', 'city')->latest()->paginate($this->paginate);
        }



        return view('admin.transfer.index', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'items' => $items
        ]);
    }


    public function create()
    {
        return view('admin.transfer.create', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME
        ]);
    }

    public function store(Request $req)
    {

        $this->validate($req, [
            'city' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'title.*' => 'required',
            'desc.*' => 'required',
            'capacity.*' => 'required',
            'price.*' => 'required'
        ]);


        if (!@auth()->user()->agency->id) {
            return  redirect()->back()->with(['error' => ' امکان ثبت برای شما وجود ندارد ']);
        }


        if (!$req->title) {
            return  redirect()->back()->with(['error' => 'برای تراسنفر حداقل یک ردیف ثبت کنید']);
        }


        // Get Diff Days 
        $startDate = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($req->start_date));
        $endDate = \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($req->end_date));
        $startDate = $startDate->format('Y-m-d');
        $endDate = $endDate->format('Y-m-d');
        $startD = Carbon::parse($startDate);
        $endD = Carbon::parse($endDate);
        $diffDays = $endD->diffInDays($startD);
        // End 


        $dateDiffArray = array();
        for ($i = 0; $i <= $diffDays; $i++) {
            $dateDiffArray[] = date("Y-m-d", strtotime($startD . " + $i days"));
        }

        foreach ($dateDiffArray as $rowDiffDay) {

            $checkHasThisCity = Transfer::where('agency_id', auth()->user()->agency->id)
                ->where('city_id', json_decode($req->city)->id)
                ->where('date', $rowDiffDay)
                ->get();

            if (count($checkHasThisCity) > 0) {
                return  redirect()->back()->with(['error' => ' برای این شهر در این تاریخ از پیش ترانسفر ثبت شده است ']);
            }
        }


        foreach ($dateDiffArray as $rowDiffDay) {

            $arrayTransfer_items = array();


            $transfer_id = Transfer::create([
                'agency_id' => auth()->user()->agency->id,
                'city_id' => json_decode($req->city)->id,
                'rand' => time() . rand(1000, 9999),
                'date' => $rowDiffDay
            ]);



            foreach ($req->title as $keys => $vals) {
                $arrayTransfer_items[] = [
                    'transfer_id' => $transfer_id->id,
                    'title' => $vals,
                    'desc' => $req->desc[$keys],
                    'price' => $req->price[$keys],
                    'capacity' => $req->capacity[$keys],
                    'accompanimentType' => $req->accompanimentType[$keys],
                    'vehicleType' => $req->vehicleType[$keys],
                    'locationType' => $req->locationType[$keys],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }


            if ($transfer_id->id) {
                TransferItem::insert($arrayTransfer_items);
            }
        }

        return  redirect()->back()->with(['success' => ' ترانسفر جدید با موفقیت ثبت شد ']);
    }



    public function edit(Transfer $transfer)
    {
        //  dd($transfer);

        return view('admin.transfer.edit', [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'transfer' => $transfer
        ]);
    }


    public function update(Request $request, $id)
    {

        //  dd($request);


        $this->validate($request, [
            'city' => 'required',
            'date' => 'required',
            'title.*' => 'required',
            'desc.*' => 'required',
            'price.*' => 'required',
            'capacity.*' => 'required'
        ]);

        $checkHasThisCity = Transfer::where('id', '!=', $id)
            ->where('agency_id', auth()->user()->agency->id)
            ->where('city_id', json_decode($request->city)->id)
            ->where('date', \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($request->date)))
            ->get();


        if (count($checkHasThisCity) > 0) {
            return  redirect()->back()->with(['error' => ' برای این شهر در این تاریخ از پیش تراسفر ثبت شده است ']);
        }


        if (auth()->user()->isSuperAdmin()) {

            Transfer::find($id)->update([
                'status' => $request->status ? "1" : "0"
            ]);
        }

        Transfer::find($id)->update([
            'city_id' => json_decode($request->city)->id,
            'date' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d', ($request->date))
        ]);

        TransferItem::where('transfer_id', $id)->delete();



        if (!$request->title) {
            return  redirect()->back()->with(['errorForm' => 'برای تراسنفر حداقل یک ردیف ثبت کنید']);
        }


        foreach ($request->title as $keys => $vals) {
            $arrayTransfer_items[] = [
                'transfer_id' => $id,
                'title' => $vals,
                'desc' => $request->desc[$keys],
                'price' => $request->price[$keys],
                'capacity' => $request->capacity[$keys],
                'accompanimentType' => $request->accompanimentType[$keys],
                'vehicleType' => $request->vehicleType[$keys],
                'locationType' => $request->locationType[$keys],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }


        if ($id) {
            TransferItem::insert($arrayTransfer_items);
        }

        return  redirect()->back()->with(['success' => ' ترانسفر  با موفقیت ویرایش  شد ']);
    }
}
