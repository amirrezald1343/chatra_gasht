<?php

namespace App\Http\Controllers\admin;;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Media;

class ServiceController extends Controller
{

    private $model = 'App\Service';
    private $paginate = 15;
    const NAME = 'Service';
    const FANAME = 'خدمات';

    public function index()
    {
        $items = $this->model::paginate($this->paginate);
        return view(findView(),[
            'items'=>$items,
            'NAME'=>self::NAME,
            'FANAME'=>self::FANAME,
        ]);
    }

    public function create()
    {
        $storage = File::allFiles('storage/Service');
        return view(findView(), [
            'NAME' => self::NAME,
            'FANAME'=>self::FANAME,
            'storage' => $storage,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'icon'=>'required',
        ]);
        if (!$request->has('status')) $request->merge(['status'=>'0']);
        if ($this->model::create($request->all())) redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ایجاد شد!' ]);
        return back()->with(['error', __('admin.failed!')]);
    }

    public function show(Service $service)
    {
        //
    }

    public function edit($id)
    {
        $storage = File::allFiles('storage/Service');
        $model = $this->model::find($id);
        return view(findView(),[
            'storage'=>$storage,
            'model'=>$model,
            'NAME'=>self::NAME,
            'FANAME'=>self::FANAME,
        ]);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'title'=>'required',
            'icon'=>'required',
        ]);
        if (!$request->has('status')) $request->merge(['status'=>'0']);
        $find = $this->model::find($id);
        if ($find->update($request->all())) redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ویرایش شد!' ]);
        return back()->with(['error',__('admin.failed!')]);
    }

    public function destroy($id)
    {
        $find = $this->model::findOrFail($id);
        $find->delete();
        return redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت حذف شد!' ]);
    }
}
