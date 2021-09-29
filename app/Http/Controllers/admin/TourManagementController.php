<?php

namespace App\Http\Controllers\admin;;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;

use Ipecompany\Smsirlaravel\Smsirlaravel;

class TourManagementController extends Controller
{
    private $model = 'App\Package';
    private $paginate = 15;
    const NAME = 'Package';
    const FANAME = 'تور';

    public function index()
    {
        $items =  $this->model::with('cities','levels','maps','prices','images','agency','services','city')->paginate($this->paginate);
        return view('admin.TourManagement.index',[
            'NAME'=>self::NAME,
            'FANAME'=>self::FANAME,
            'items' => $items,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $find = $this->model::find($id);
        $update=$find->update([
            'status'=> (string)abs($find->status -1)
        ]);

        if($update) {
            if((string)abs($find->status -1)==0){
            $smsMessage=''.$find->title.' با موفقیت تایید شد و در سایت قابل مشاهده میباشد '."\n".' کلیک سفر ';
            if(@$find->agency->cellPhone){
            @$sendSms=Smsirlaravel::send([$smsMessage],[@$find->agency->cellPhone]);
            }
        }
           
           return  redirect()->back()->with(['success' => 'وضعیت ' . self::FANAME . ' ' . 'با موفقیت ویرایش شد!' ]);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function destroy($id)
    {
        //
    }
}
