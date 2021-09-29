<?php

namespace App\Http\Controllers\admin;

use App\Agency;
use App\Media;
use App\Permission;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Ipecompany\Smsirlaravel\Smsirlaravel;


class AgencyController extends Controller
{
    private $model = 'App\Agency';
    private $paginate = 15;
    const NAME = 'Agency';
    const FANAME = 'آژانس';

    public function index(Request $req)
    {

        $items = $this->model::with(['media', 'permission']);

        if ($req->sendFilter) {
           
            
            if ($req->agency) {
                $items->where('id', $req->agency);
            }

            if ($req->tourStatus == 'n') {
                $items->where('status', '0');
            } elseif ($req->tourStatus == 'y') {
                $items->where('status', '1');
            }

            $getAgencyName = Agency::where('id', $req->agency)->pluck('company')->first();

            $filterParams = [
                'agency' => $req->agency,
                'agencyName' => $getAgencyName,
                'status' => $req->tourStatus
            ];

            $paginate = 1000;

        } else {
            $paginate = $this->paginate;
            $filterParams = null;
            
        }

        $items = $items->paginate($paginate);

    
        
        return view(findView(), [
            'items' => $items,
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'filterParams' => $filterParams?'':'',
        ]);
    }

    public function create()
    {
        $permissions = Permission::CanAccess()->pluck('name', 'id') ?? '';
        return view(findView(), [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {

        //dd($request);


        $this->validate($request, [
            'name' => 'required',
            'nationalNumber' => 'required',
            'domain' => 'nullable|unique:agencies,domain',
            'company' => 'required',
            'tellPhone' => 'required',
            'expDate' => 'required',
            'cellPhone' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'permission_id' => 'required|exists:.permissions,id|notIn:' . Permission::whereName('Administrator')->first()->id,
        ]);
        $agencyRules = '';
        if ($request->agencyRules) $agencyRules = implode(',', $request->agencyRules);


        if (!$request->has('status')) $request->merge(['status' => '0']);
        if ($model = $this->model::create([
            'name' => $request['name'],
            'nationalNumber' => $request['nationalNumber'],
            'domain' => $request['domain'],
            'company' => $request['company'],
            'tellPhone' => $request['tellPhone'],
            'cellPhone' => $request['cellPhone'],
            'email' => $request['email'],
            'expDate' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', ($request->expDate . ' 00:00:00')),
            'agencyLicense' => $request['agencyLicense'],
            'address' => $request['address'],
            'permission_id' => $request['permission_id'],
            'agencyRules' => "$agencyRules",
            'status' => $request['status'],
            'internalCode'=>$request['internalCode']
        ])) { //($request->except(['file']
            $userAgency = [
                'name' => $request->name,
                'username' => $request->email,
                'nationalNumber' => $request->nationalNumber,
                'email_verified_at' => now()->toDateTimeString(),
                'cellphone' => $request->cellPhone,
                'email' => $request->email,
               
                'role' => 'admin',
                'status' => $request->status,
                'permission_id' => $request->permission_id,
            ];


            if($request->password and $request->password!=''){
               $userAgency=array_merge($userAgency,['password' => bcrypt($request->password)]);
            }


            $user = User::create($userAgency);
            $model->update(['user_id' => $user->id]);
            if ($request->hasFile('file')) {
                $File_Name = $model->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
                $path = 'Agency' . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
                if ($request->file->storeAs($path, $File_Name, 'public')) {
                    $media = new Media();
                    $media->name = $request->file('file')->getClientOriginalName();
                    $media->path = 'storage/' . $path . '/' . $File_Name;
                    $media->user_id = Auth::user()->id;
                    $media->save();
                    $model->update(['media_id' => $media->id]);
                }
            }

            if($request->sendSms){
                $smsMsg="اطلاعات ورود به پنل مدیریت آزانس : "."\n".
                "نام کاربری : ".$request->email."\n".
                "رمز عبور :".$request->password."\n"."\n".
                "کلیک سفر";
                Smsirlaravel::send([$smsMsg],[$request->cellPhone]);
            }

          return  redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ایجاد شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function show(Agency $agency)
    {

    }

    public function edit($id)
    {


        $model = $this->model::with(['permission', 'media'])->findOrFail($id);
        $permissions = Permission::CanAccess()->pluck('name', 'id') ?? '';
        if ($model['agencyRules']) {
            $agencyRules = $model['agencyRules'];
            $model["agencyRules"] = explode(',', $model['agencyRules']);
        }

        return view(findView(), [
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,
            'permissions' => $permissions,
            'model' => $model,
            'onEdit' => true
        ]);
    }

    public function update(Request $request, $id)
    {

       
        
        $find = $this->model::find($id);
        $this->validate($request, [
            'name' => 'required',
            'nationalNumber' => 'required',
            'domain' => 'nullable|unique:agencies,domain,' . $id,
            'company' => 'required',
            'tellPhone' => 'required',
            'cellPhone' => 'required', //|unique:users
            'expDate' => 'required',
            'email' => 'required|email|unique:users,email,' . $find->user_id,
            'address' => 'required',
            'permission_id' => 'required|exists:.permissions,id|notIn:' . Permission::whereName('Administrator')->first()->id,
        ]);

        $agencyRules = '';
        if ($request->agencyRules) $agencyRules = implode(',', $request->agencyRules);

        if (!$request->has('status')) $request->merge(['status' => '0']);
        if ($find->update([
            'name' => $request['name'],
            'nationalNumber' => $request['nationalNumber'],
            'domain' => $request['domain'],
            'company' => $request['company'],
            'tellPhone' => $request['tellPhone'],
            'cellPhone' => $request['cellPhone'],
            'email' => $request['email'],
            'expDate' => \Morilog\Jalali\CalendarUtils::createDatetimeFromFormat('Y/m/d H:i:s', ($request->expDate . ' 00:00:00')),
            'agencyLicense' => $request['agencyLicense'],
            'address' => $request['address'],
            'permission_id' => $request['permission_id'],
            'agencyRules' => "$agencyRules",
            'status' => $request['status'],
            'internalCode'=>$request['internalCode']
        ])) {
            $userAgency = [
                'name' => $request->name,
                'nationalNumber' => $request->nationalNumber,
                'cellPhone' => $request->cellPhone,
                'email' => $request->email,
                'username' => $request->email,
                'status' => $request->status,
                'permission_id' => $request->permission_id,
            ];

            if($request->password and $request->password!=''){
               $userAgency=array_merge($userAgency,['password' => bcrypt($request->password)]);
            }

            User::where('id', $find->user_id)->update($userAgency);
            if ($request->hasFile('file')) {
                $File_Name = $find->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
                $path = 'Agency' . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
                if ($request->file->storeAs($path, $File_Name, 'public')) {
                    $prePath = $find->media->path ?? false;
                    $media = new Media();
                    $media->name = $request->file('file')->getClientOriginalName();
                    $media->path = 'storage/' . $path . '/' . $File_Name;
                    $media->user_id = Auth::user()->id;
                    $media->save();
                    $find->update(['media_id' => $media->id]);
                    if ($prePath) File::delete($prePath);
                }
            }

            if($request->sendSms){
                $smsMsg="اطلاعات ورود به پنل مدیریت آزانس : "."\n".
                "نام کاربری : ".$request->email."\n".
                "رمز عبور :".$request->password."\n"."\n".
                "کلیک سفر";
                Smsirlaravel::send([$smsMsg],[$request->cellPhone]);
            }

        return    redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ویرایش شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function destroy(Agency $agency)
    {

    }

    public function editUserPassword(Request $req){
      
        return view('admin.Agency.editUserPassword');
    }

    public function updateUserPassword(Request $req){
      
        $this->validate($req,[
            'password'=>'required|confirmed|min:8'
        ]);

        $userID=auth()->user()->id;

        $a=User::find($userID)->update(['password'=> bcrypt($req->password)]);

        

      return  redirect()->back()->with(['success' => ' ' . 'رمزعبور شما با موفقیت ویرایش']);
        
    }


}
