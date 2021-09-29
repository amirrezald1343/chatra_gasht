<?php

namespace App\Http\Controllers\admin;;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    private $model = 'App\Permission';
    private $paginate = 15;
    const NAME = 'Permission';
    const FANAME = 'سطح دسترسی';

    public function index()
    {

        $items = $this->model::canAccess();
        $items = $items->with('sections')->paginate($this->paginate);
        return view(findView(), [
            'items' => $items,
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,

        ]);
    }

    public function create()
    {

        if (auth()->user()->role == 'superAdmin') {
            $items = Section::with([
                'permissions' => function ($query) {
                    $query->where('name', Auth::user()->permission->name);
                }
            ])->get();
        } else {
            $items = Section::whereIn('id', collect(Auth::user()->permission->sections)->pluck('id'))->with([
                'permissions' => function ($query) {
                    $query->where('name', Auth::user()->permission->name);
                }
            ])->get();
        }




        return view(findView(), [
            'items' => $items,
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,

        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        if ($this->model::create(['name' => $request->name])->sections()->sync($request->section_id)) {
            redirect()->back()->with(['success' =>  self::FANAME . ' ' . 'با موفقیت ایجاد شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function show(Permission $permission)
    {
        //
    }

    public function edit($id)
    {


        // $items = Section::whereIn('id', collect(Auth::user()->permission->sections)->pluck('id'))->with([
        //     'permissions' => function ($query) {
        //         $query->where('name', Auth::user()->permission->name);
        //     }])->get();

        if (auth()->user()->role == 'superAdmin') {
            $items = Section::with([
                'permissions' => function ($query) {
                    $query->where('name', Auth::user()->permission->name);
                }
            ])->get();
        } else {
            $items = Section::whereIn('id', collect(Auth::user()->permission->sections)->pluck('id'))->with([
                'permissions' => function ($query) {
                    $query->where('name', Auth::user()->permission->name);
                }
            ])->get();
        }




        $model = $this->model::with('sections')->canAccess()->findOrFail($id);
        return view(findView(), [
            'items' => $items,
            'model' => $model,
            'NAME' => self::NAME,
            'FANAME' => self::FANAME,

        ]);
        
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $find = $this->model::find($id);
        $find->update(['name' => $request->name]);
        if ($find->sections()->detach() && $find->sections()->syncWithoutDetaching($request->section_id)) {
            redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ویرایش شد!']);
        }
        return back()->with(['error', __('admin.failed!')]);
    }

    public function destroy(Permission $permission)
    {
        //
    }
}
