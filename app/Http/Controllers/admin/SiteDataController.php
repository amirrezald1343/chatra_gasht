<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteData;
use App\User;
use App\City;
use App\Notification;
use App\Post;
use App\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as ImageThumb;

class SiteDataController extends Controller
{

    private $model = 'App\SiteData';
    const NAME = 'Dashboard';
    const FANAME = 'اصلاعات صفحات سایت';

    public function editAbout()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $model = $this->model::where('type', 'about')->first();

        //  dd($model);

        $NAME = self::NAME;
        $FANAME = 'صفحه درباره ما سایت';
        return view('admin.site.about', compact('model', 'NAME', 'FANAME'));
    }


    public function updateAbout(Request $request)
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $this->validate($request, [
            'description' => 'required'
        ]);

        $this->model::where('type', 'about')->delete();

        $this->model::create([
            'title' => 'درباره ما سایت',
            'adminID' => auth()->user()->id,
            'body' => $request->description,
            'type' => 'about'
        ]);

        return redirect()->route('admin.adminAbout')->with(['success' => 'متن درباره ما سایت با موفقیت ویرایش شد']);
    }


    public function editContact()
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $model = $this->model::where('type', 'contact')->first();

        //  dd($model);

        $NAME = self::NAME;
        $FANAME = 'صفحه تماس با ما سایت';
        return view('admin.site.contact', compact('model', 'NAME', 'FANAME'));
    }


    public function updateContact(Request $request)
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $this->validate($request, [
            'description' => 'required'
        ]);

        $this->model::where('type', 'contact')->delete();

        $this->model::create([
            'title' => 'ارتباط با ما سایت',
            'adminID' => auth()->user()->id,
            'body' => $request->description,
            'type' => 'contact'
        ]);

        return redirect()->route('admin.adminContact')->with(['success' => 'متن ارتباط با ما  با موفقیت ویرایش شد']);
    }


    public function editRules()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $model = $this->model::where('type', 'rules')->first();

        //  dd($model);

        $NAME = self::NAME;
        $FANAME = 'صفحه قوانین سایت';
        return view('admin.site.rules', compact('model', 'NAME', 'FANAME'));
    }


    public function updateRules(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $this->validate($request, [
            'description' => 'required'
        ]);

        $this->model::where('type', 'rules')->delete();

        $this->model::create([
            'title' => 'قوانین سایت',
            'adminID' => auth()->user()->id,
            'body' => $request->description,
            'type' => 'rules'
        ]);

        return redirect()->route('admin.adminRules')->with(['success' => 'قوانین سایت با موفقیت ویرایش شد']);
    }


    public function showTickets()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this module ');
        }

        $model = DB::table('site_tickets')->select()->orderBy('created_at', 'desc')->paginate(15);



        //  dd($model);

        $NAME = self::NAME;
        $FANAME = 'لیست تیکت ها';
        return view('admin.site.ticketList', compact('model', 'NAME', 'FANAME'));
    }


    public function showCityForm()
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $cities = City::where('types', 'city')->pluck('title_fa', 'id');

        return view('admin.dynamicData.insertCity', compact('cities'));
    }

    public function storeNewCity(Request $req)
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }


        $this->validate($req, [
            'title_fa' => 'required'
        ]);

        $newCity = City::create([
            'title_fa' => $req->title_fa,
            'type' => 'location',
            'types' => 'city',
            'slug_fa' => $req->title_fa
        ]);

        if ($newCity) {
            return redirect()->back()->with(['success' => ' شهر جدید با موفقیت ثبت شد ']);
        }
    }

    public function NotificationList(Request $req)
    {
        $model = DB::table('notifications')
            ->select('packages.title', 'users.name', 'users.cellphone', 'users.email', 'notifications.status', 'notifications.created_at')
            ->leftJoin('packages', 'notifications.package_id', '=', 'packages.id')
            ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
            ->where('notifications.agency_id', auth()->user()->agency)->orderBy('notifications.id', 'DESC')->paginate(50);


        // dd($model);

        $NAME = self::NAME;
        $FANAME = 'لیست اعلانات';

        Notification::where('agency_id', auth()->user()->agency)->update(['status' => 'read']);

        return view('admin.site.notificationList', compact('model', 'NAME', 'FANAME'));
    }


    public function checkHasNotifications(Request $req)
    {


        $model = DB::table('notifications')
            ->select('packages.title', 'users.name', 'users.cellphone', 'users.email', 'notifications.status', 'notifications.created_at')
            ->leftJoin('packages', 'notifications.package_id', '=', 'packages.id')
            ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
            ->where('notifications.status', 'unread')
            ->where('notifications.agency_id', auth()->user()->agency['id'])->orderBy('notifications.id', 'DESC')->paginate(50);

        $count = count($model);

        return response()->json($count);
    }


    public function createPost()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $NAME = self::NAME;
        $FANAME = 'ثبت مطلب جدید';

        return view('admin.site.postCreate', compact('NAME', 'FANAME'));
    }

    public function storePost(Request $req)
    {



        $this->validate($req, [
            'title' => 'required|max:250',
            'body' => 'required',
            'summary' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);

        $tours = array();
        if ($req->tours) {
            // dd(json_decode($req->tours));

            foreach (json_decode($req->tours) as $tour) {
                $tours[] = $tour->id;
            }
            // dd($tours);
        }


        $postStoreArray = [
            'user_id' => auth()->user()->id,
            'title' => $req->title,
            'body' => $req->body,
            'summary' => $req->summary,
        ];

        if ($req->tags) {
            $tags = '';
            foreach (json_decode($req->tags) as $rowt => $tag) {
                $tags .= $tag->value . ',';
            }
            $tags = trim($tags, ',');
            $postStoreArray = array_merge($postStoreArray, ['tags' => $tags]);
        }

        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(300, 250)->save('storage/' . 'blog/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'blog/' . $image->basename;

            $postStoreArray = array_merge($postStoreArray, ['image_thumb' => $imageThumbForDb]);
        }

        $posted = Post::create($postStoreArray);


        if (@$tours) {
            Post::find($posted->id)->packages()->attach($tours);
        }


        if ($posted) {
            return Redirect()->back()->with(['success' => ' پست جدید با موفقیت ثبت شد ']);
        }
    }


    public function listPost()
    {
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->paginate(15);

        $NAME = self::NAME;
        $FANAME = 'لیست مطالب';

        return view('admin.site.psotList', compact('posts', 'NAME', 'FANAME'));
    }


    public function editPost(Request $req, $id)
    {
        $NAME = self::NAME;
        $FANAME = 'ویرایش مطلب';

        $post = Post::find($id);

        //  Dd($post->packages);


        return view('admin.site.postEdit', compact('post', 'NAME', 'FANAME'));
    }


    public function updatePost(Request $req, $id)
    {

        $this->validate($req, [
            'title' => 'required|max:250',
            'body' => 'required',
            'summary' => 'required|max:200',
            'file' => 'mimes:jpg,jpeg,png'
        ]);


        if ($req->tours) {
            // dd(json_decode($req->tours));
            $tours = array();
            foreach (json_decode($req->tours) as $tour) {
                $tours[] = $tour->id;
            }
        }

        $postStoreArray = [
            'user_id' => auth()->user()->id,
            'title' => $req->title,
            'body' => $req->body,
            'summary' => $req->summary,
        ];

        if ($req->tags) {
            $tags = '';
            foreach (json_decode($req->tags) as $rowt => $tag) {
                $tags .= $tag->value . ',';
            }
            $tags = trim($tags, ',');
            $postStoreArray = array_merge($postStoreArray, ['tags' => $tags]);
        }

        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(300, 250)->save('storage/' . 'blog/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'blog/' . $image->basename;

            $postStoreArray = array_merge($postStoreArray, ['image_thumb' => $imageThumbForDb]);
        }

        $posted = Post::find($id)->update($postStoreArray);



        Post::find($id)->packages()->sync($tours);



        if ($posted) {
            return Redirect()->back()->with(['success' => ' ویرایش با موفقیت انجام شد ']);
        }
    }


    public function deletePost(Request $req)
    {
        $deleted = Post::destroy($req->id);

        if ($deleted) {
            return redirect()->back()->with(['success' => ' مطلب مورد نظر با موفقیت حذف شد ']);
        } else {
            return redirect()->back();
        }
    }


    public function createVideo()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $NAME = self::NAME;
        $FANAME = 'ویدیو مطلب جدید';

        return view('admin.site.videoCreate', compact('NAME', 'FANAME'));
    }


    public function storeVideo(Request $req)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $this->validate($req, [
            'title' => 'required|max:250',
            'body' => 'required',
            'url' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);


        $videoStoreArray = [
            'user_id' => auth()->user()->id,
            'title' => $req->title,
            'body' => $req->body,
            'url' => $req->url,
        ];



        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(400, 350)->save('storage/' . 'blog/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'blog/' . $image->basename;

            $videoStoreArray = array_merge($videoStoreArray, ['image_thumb' => $imageThumbForDb]);
        }

        $videoed = Video::create($videoStoreArray);


        if ($videoed) {
            return Redirect()->back()->with(['success' => ' ویدیو جدید با موفقیت ثبت شد ']);
        }
    }


    public function listVideo()
    {

        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $videos = Video::where('status', 'active')->orderBy('id', 'DESC')->paginate(15);

        $NAME = self::NAME;
        $FANAME = 'لیست ویدیو ها';

        return view('admin.site.videoList', compact('videos', 'NAME', 'FANAME'));
    }


    public function editVideo(Request $req, $id)
    {
        $NAME = self::NAME;
        $FANAME = 'ویرایش ویدیو';

        $video = Video::find($id);

        return view('admin.site.videoEdit', compact('video', 'NAME', 'FANAME'));
    }

    public function updateVideo(Request $req, $id)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(401, 'you do not have access to this madule ');
        }

        $this->validate($req, [
            'title' => 'required|max:250',
            'body' => 'required',
            'url' => 'required',
            'file' => 'mimes:jpg,jpeg,png'
        ]);


        $videoStoreArray = [
            'user_id' => auth()->user()->id,
            'title' => $req->title,
            'body' => $req->body,
            'url' => $req->url,
        ];



        if ($req->file) {
            $saveImageName = time() . $req->file->getClientOriginalName();
            $image = ImageThumb::make($req->file('file')->getRealPath())->resize(400, 350)->save('storage/' . 'blog/' . $saveImageName);
            $imageThumbForDb = 'storage/' . 'blog/' . $image->basename;

            $videoStoreArray = array_merge($videoStoreArray, ['image_thumb' => $imageThumbForDb]);
        }

        $videoed = video::find($id)->update($videoStoreArray);


        if ($videoed) {
            return Redirect()->back()->with(['success' => ' ویرایش با موفقیت انجام شد ']);
        }
    }


    public function deleteVideo(Request $req)
    {
        $deleted = video::destroy($req->id);

        if ($deleted) {
            return redirect()->back()->with(['success' => ' ویدیو مورد نظر با موفقیت حذف شد ']);
        } else {
            return redirect()->back();
        }
    }

    public function uploadImage(Request $request)
    {

        $this->validate($request, [
            'upload' => 'image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);

        $CKEditor = $request->CKEditor;
        $funcNum = $request->CKEditorFuncNum;

        //  $file = $request->file('upload')->store('ckPosts');

       // dd($request->file('upload')->getClientOriginalName());

       $File_Name =  time() . '.' . getFileExtension($request->file('upload')->getClientOriginalName());


        $file =  $request->upload->storeAs('ckPosts',$File_Name, 'public');


        if ($file) {
            $url = public_path() . '/' . $file;
            return "<script>window.parent.CKEDITOR.tools.callFunction(1,'/storage/{$file}','')</script>";
        }
    }
}
