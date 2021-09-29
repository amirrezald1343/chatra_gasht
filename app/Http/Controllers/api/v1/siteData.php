<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Agency;

use App\SiteData as SiteDataModel;

class siteData extends Controller
{

    public function about()
    {

        $getAbout = SiteDataModel::where('type', 'about')->first();

        return response()->json($getAbout, 200);
    }

    public function rules()
    {

        $getAbout = SiteDataModel::where('type', 'rules')->first();

        return response()->json($getAbout, 200);
    }

    public function storeTicket(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $idInsert = DB::table('site_tickets')->insertGetId([
            'name' => $req->name,
            'subject' => $req->subject,
            'phone_number' => $req->mobile,
            'mail' => $req->email,
            'message' => $req->message,
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!empty($idInsert)) {
            return response()->json(['success' => 'پیام شما با موفقیت ثبت شد'], 200);
        }
    }


    public function agencyList(Request $req)
    {
        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }


        $getAllAgencies = Agency::where('status', '1')->skip($skip)
            ->take(10)
            ->get();


        return response()->json(['agencies'=>$getAllAgencies], 200);
    }
}
