<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FavoriteTour;
use App\City;

use Intervention\Image\ImageManagerStatic as ImageThumb;
use Illuminate\Support\Facades\DB;

class FavoriteToursController extends Controller
{

    private $model = 'App\FavoriteTour';
    const NAME = 'SiteData';
    const FANAME = 'تورهای محبوب';


    public function index()
    {
        $favTours = $this->model::with('countries')->paginate(10);


        return view('admin.site.favoriteTour', ['favTours' => $favTours, 'NAME' => self::NAME, 'FANAME' => self::FANAME]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getCountries = City::where('types', 'country')->pluck('title_fa', 'id');

        return view('admin.site.favoriteTourCreate', ['countries' => $getCountries, 'NAME' => self::NAME, 'FANAME' => self::FANAME]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //  dd($request);

        $this->validate($request, [
            'title' => 'required',
            'country' => 'required',
            'details' => 'required',
            'file' => 'required'
        ]);


        // $File_Name = time() . '.' . getFileExtension($request->file('file')->getClientOriginalName());
        // $path = 'FavoriteTour' . '/' . Carbon::now()->addDay()->year . '/' . Carbon::now()->addDay()->month . '/' . Carbon::now()->addDay()->day;
      


        if ($request->file) {
            $saveImageName=time().$request->file->getClientOriginalName();
            $image=ImageThumb::make($request->file('file')->getRealPath())->resize(500, 400)->save('storage/'.'FavoriteTour/'.$saveImageName);
            $imageThumbForDb='storage/'.'FavoriteTour/'.$image->basename;
        }
      

            $this->model::create([
                'title' => $request->title,
                'details' => $request->details,
                'origin' => $request->country,
                'image' => $imageThumbForDb ?? null
            ]);


            return redirect()->back()->with(['success' => self::FANAME . ' با موفقیت ثبت شد']);

      

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getCountries = City::where('types', 'country')->pluck('title_fa', 'id');
        $getFavTour = $this->model::find($id);

        return view('admin.site.favoriteTourEdit', ['favTour' => $getFavTour, 'countries' => $getCountries, 'NAME' => self::NAME, 'FANAME' => self::FANAME]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'title' => 'required',
            'country' => 'required',
            'details' => 'required',
            'file' => 'mimes:jpg,jpeg,png'
        ]);


        if ($request->status == 'Y') {
            $statusQ = 'Y';
        } else {
            $statusQ = 'N';
        }

        if ($request->file) {
            $saveImageName=time().$request->file->getClientOriginalName();
            $image=ImageThumb::make($request->file('file')->getRealPath())->resize(500, 400)->save('storage/'.'FavoriteTour/'.$saveImageName);
            $imageThumbForDb='storage/'.'FavoriteTour/'.$image->basename;
        }else{
            $imageThumbForDb=DB::table('favorite_tours')->select()->where('id',$id)->first()->image;
        }

        $find = $this->model::find($id);
        $find->update([
            'title' => $request->title,
            'details' => $request->details,
            'origin' => $request->country,
            'status' => $statusQ,
            'image' => $imageThumbForDb ?? null
        ]);



        return redirect()->back()->with(['success' => self::FANAME . ' ' . 'با موفقیت ویرایش شد!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model::findOrFail($id)->delete();
        return redirect()->route('admin.FavoriteTours.index')->with(['success' => 'تور محبوب با موفقیت حدف شد']);
    }
}
