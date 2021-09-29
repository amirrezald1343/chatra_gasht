<?php

namespace App\Http\Controllers\admin;

use App\Http\Middleware\Language;
use App\Permission;
use App\Country;
use App\Http\Controllers\Controller;
use App\Media;
use App\Section;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminController extends Controller {
    private $model = 'App\Admin';
    private $paginate = 15;
    const NAME = 'Admin';

    function index() {
        $this->isAgencyMakeSession();
        $items = $this->model::with(['permission', 'country', 'media'])
            ->whereHas('permission',function ($query){
                $query->where('invisible','0');
            })
            ->paginate($this->paginate);
        $this->removeSession();
        return view(findView(), ['items' => $items, 'NAME' => self::NAME]);
    }

    function create() {
        $countries = Country::pluck('name', 'id') ?? '';
        $permissions = Permission::on(connectionName())->canAccess()->pluck('name', 'id') ?? '';
        return view(findView(), [
            'NAME' => self::NAME,
            'countries' => $countries,
            'permissions' => $permissions,
        ]);
    }

    function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'country_id' => 'requires|exists:'.env('DB_CONNECTION').'.countries,id',
            'nationalNumber' => 'required',
            'permission_id' => 'requires|exists:' . connectionName() . '.permissions,id|in:' . implode(',',Permission::on(connectionName())->canAccess()->pluck('id')->toArray()),
            'cellphone' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'sex' => 'nullable|in:male,female',
        ]);
        if (!$request->has('status')) $request->merge(['status' => '0']);
        $request->merge([
            'email_verified_at' => now()->toDateTimeString(),
            'password' => bcrypt($request->nationalNumber),
            'username'=>$request->email,
            'role'=>'admin'
        ]);
        if ($model = $this->model::create($request->except('file'))) {
            if ($request->hasFile('file')) {
                $File_Name = $model->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
                $path = DBName(siteUrl()) . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
                if ($request->file->storeAs($path, $File_Name, 'public')) {
                    $media = new Media();
                    $media->name = $request->file('file')->getClientOriginalName();
                    $media->path = 'storage/' . $path . '/' . $File_Name;
                    $media->user_id = Auth::user()->id;
                    $media->save();
                    Image::make($media->path)->resize(350,350)->save(getFileResize($media->path,350,350));
                    $model->update(['media_id' => $media->id]);
                }
            }
            redirect()->back()->with(['success' => __('admin.' . self::NAME) . ' ' . __('admin.was created successfully!')]);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    function edit($lang, $id) {
        $model = $this->model::with(['permission', 'country', 'media'])->findOrFail($id);
        $countries = Country::pluck('name', 'id') ?? '';
        $permissions = Permission::on(connectionName())->canAccess()->pluck('name', 'id') ?? '';
        return view(findView(), [
            'NAME' => self::NAME,
            'countries' => $countries,
            'permissions' => $permissions,
            'model'=>$model
        ]);
    }

    function update(Request $request, $lang, $id) {
        $this->validate($request, [
            'name' => 'required',
            'country_id' => 'requires|exists:'.env('DB_CONNECTION').'.countries,id',
            'nationalNumber' => 'required',
            'permission_id' => 'requires|exists:' . connectionName() . '.permissions,id|in:' . implode(',',Permission::on(connectionName())->canAccess()->pluck('id')->toArray()),
            'cellphone' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'required',
            'sex' => 'nullable|in:male,female',
        ]);
        if (!$request->has('status')) $request->merge(['status' => '0']);
        $request->merge([
            'email_verified_at' => now()->toDateTimeString(),
            'password' => bcrypt($request->nationalNumber),
            'username'=>$request->email,
            'role'=>'admin'
        ]);
        return $this->updateData($request,$id);
    }

    function destroy($lang, $id) {
        $find = $this->model::findOrFail($id);
        $media = $find->media ?? false;
        if ($find->delete()) {
            if ($media) {
                File::delete($media->path);
                $media->delete();
            }
            return redirect()->back()->with('success', __('admin.' . self::NAME) . ' ' . __('admin.was deleted successfully!'));
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    function myProfile($lang) {
        $model = $this->model::with(['permission', 'country', 'media'])->findOrFail(Auth::user()->id);
        $countries = Country::pluck('name', 'id') ?? '';
        $permissions = Permission::on(connectionName())->canAccess()->pluck('name', 'id') ?? '';
        return view('admin.Admin.create', [
            'NAME' => self::NAME,
            'countries' => $countries,
            'permissions' => $permissions,
            'model'=>$model
        ]);
    }
    function updateMyProfile(Request $request,$lang,$id){
        if ($id != Auth::user()->id) abort(404);
        $this->validate($request, [
            'name' => 'required',
            'country_id' => 'requires|numeric',
            'cellphone' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'sex' => 'nullable|in:male,female',
            'password'=>'nullable|min:6',
            'file'=>'nullable|mimes:jpeg,jpg,png|max:1200'
        ]);
        $request->merge(['password' => bcrypt($request->password)]);
        return $this->updateData($request,$id);
    }
    private function updateData(Request $request,$id){
        $find = $this->model::findOrFail($id);
        if ($find->update($request->except('file'))) {
            if ($request->hasFile('file')) {
                $File_Name = $find->id . time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
                $path = DBName(siteUrl()). '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
                if ($request->file->storeAs($path, $File_Name, 'public')) {
                    $prePath = $find->media->path ?? false;
                    $media = ($prePath) ? $find->media : new Media();
                    $media->name = $request->file('file')->getClientOriginalName();
                    $media->path = 'storage/' . $path . '/' . $File_Name;
                    $media->user_id = Auth::user()->id;
                    $media->save();
                    if(!$prePath) $find->update(['media_id' => $media->id]);
                    if($prePath) File::delete($prePath);

                    Image::make($media->path)->resize(350,350)->save(getFileResize($media->path,350,350));
                    if($prePath) File::delete(getFileResize($prePath,350,350));
                }
            }
            redirect()->back()->with(['success' => __('admin.' . self::NAME) . ' ' . __('admin.was created successfully!')]);
        }
        return back()->with(['error', __('admin.failed!')]);
    }
    private function isAgencyMakeSession(){
        if (isAgency()) session(['permissionListAgency' => true]);
    }
    private function removeSession() {
        if (session()->has('permissionListAgency')) session()->forget('permissionListAgency');
    }
}
