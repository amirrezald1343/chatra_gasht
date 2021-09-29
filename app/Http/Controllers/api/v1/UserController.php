<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ipecompany\Smsirlaravel\Smsirlaravel;

use App\User;
use App\Notification;
use App\ResetPasswordMobile;

class UserController extends Controller
{
    public function register(Request $req)
    {

        $valdiator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'cellphone' => 'required|unique:users',
            'password' => 'required'
        ]);

        //dd(json_decode($valdiator->messages()));

        if ($valdiator->fails()) {

            $errorArrays = array();

            foreach (json_decode($valdiator->messages()) as $row => $val) {
                $errorArrays[$row] = $val[0];
            }

            return response()->json(['errors' => $errorArrays, 'status' => 0], 400);
        }



        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'username' => $req->email,
            'cellphone' => $req->cellphone,
            'password' => bcrypt($req->password),
            'status' => '1',
            'role' => 'user'
        ]);

        if ($user) {

            $message = "عضویت شما در سیستم با موفقیت ثبت شد" . "\n" . " کلیک سفر ";

            Smsirlaravel::send([$message], [$req->cellphone]);
            return response()->json(['success' => 'ثبت نام با موفقیت انجام شد', 'status' => 1], 200);
        }
    }


    public function login(Request $req)
    {

//dd(auth()->check());

        $valdiator = Validator::make($req->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($valdiator->fails()) {
            return response()->json(['errors' => $valdiator->messages()], 400);
        }


        //cellphone
        if (auth()->attempt(['cellphone' => $req->username, 'password' => $req->password, 'status' => '1', 'role' => 'user'])) {

            $token = Str::random(70);

            $useras = User::find(auth()->user()->id)->update(['api_token' => $token]);


            if (!$useras) {
                return response()->json(['error', 'serverError'], 500);
            }


//            Auth::loginUsingId(auth()->user()->id);



            $userDetails = [
                'id' => auth()->user()->id,
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'mobile' => auth()->user()->cellphone,
                'api_token' => $token
            ];

            return response()->json([
                'status' => \auth()->check(),
                'success' => 'ورود به سیستم با موفقیت انجام شد',
                'user_data' => $userDetails
            ], 200);
        } else {
            return response()->json(['error' => 'نام کاربری یا رمز عبور اشتباه میباشد'], 403);
        }
    }


    public function sendNotify(Request $req)
    {
        //dd($req);

        $this->validate($req, [
            'user_id' => 'required',
            'agency_id' => 'required',
            'package_id' => 'required'
        ]);

        $notify = Notification::where('user_id', $req->user_id)
            ->where('package_id', $req->package_id)
            ->where('agency_id', $req->agency_id)->get();


        if ($notify->count()) {
            return response()->json(['errors' => 'برای این تور از پیش اعلان ارسال کرده اید'], 409);
        }


        $insertNewNotify = Notification::create([
            'user_id' => $req->user_id,
            'package_id' => $req->package_id,
            'agency_id' => $req->agency_id
        ]);

        if ($insertNewNotify) {
            return response()->json(
                ['success' => ['message' => 'ّآژانس به زودی با شما تماس خواهد گرفت', 'notify_id' => $insertNewNotify->id]],
                200
            );
        }
    }


    public function resetPassword(Request $req)
    {
        if (!$req->cellphone) {
            return response()->json(['error' => 'mobile number not entered'], 400);
        }

        $getUser = User::where('cellphone', $req->cellphone)->where('role', 'user')->first();


        if (!$getUser) {
            return response()->json(['error' => 'User not availble'], 404);
        }


        $code = mt_rand(10000, 99999);

        ResetPasswordMobile::where('user_id', $getUser->id)->delete();

        ResetPasswordMobile::create([
            'user_id' => $getUser->id,
            'cellphone' => $req->cellphone,
            'code' => $code
        ]);

        Smsirlaravel::send(["$code"], [$req->cellphone]);

        return response()->json(['status' => 'sendcode'], 200);
    }



    public function resetPasswordGetCode(Request $req)
    {

        if (!$req->code or !$req->cellphone) {
            return response()->json(['error' => 'code not entered'], 400);
        }

        $checkHasCode = ResetPasswordMobile::where('code', $req->code)
            ->where('cellphone', $req->cellphone)->first();

        if (!$checkHasCode) {
            return response()->json(['error' => 'code is invalid'], 404);
        }

        $sms_token = Str::random(75);

        ResetPasswordMobile::where('cellphone', $req->cellphone)
            ->where('code', $req->code)->update(['token' => $sms_token]);

        return response()->json(['status' => true, 'token' => $sms_token]);
    }


    public function resetPasswordNewPass(Request $req)
    {

        if (!$req->password) {
            return response()->json(['error' => 'new password not entered'], 403);
        }

        if (!$req->token) {
            return response()->json(['error' => 'token not entered'], 403);
        }

        $getUserFromResetTable = ResetPasswordMobile::where('token', $req->token)->first();

        if (!$getUserFromResetTable) {
            return response()->json(['error' => 'token is invalid'], 403);
        }

        $updated=User::find($getUserFromResetTable->user_id)
        ->update(['password'=>bcrypt($req->password)]);
                
        return response()->json(['message'=>'password changed'],200);

    }
}
