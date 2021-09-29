<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $maxAttempts=3;
    protected $redirectTo ='/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        session()->flash('tabLogin','login');
        return view('site.login');
    }
    public  function  adminForm(){
        return view('admin.login');
    }

    public function login(Request $request)
    {
        session()->flash('tabLogin','login');

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    protected function validateLogin(Request $request)
    {
        $backurl=URL::previous();


//        if($backurl==url(session()->get('isoCode').'/administrator') or $backurl==(url('').'/'))
//        {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
//        }
//        else
//        {
//            $this->validate($request, [
//                'username' => 'required',
//                'password' => 'required',
//                'g-recaptcha-response' => 'requires|captcha',
//            ]);
//        }
    }
    protected function credentials(Request $request)
    {
//        $backurl=URL::previous();
//        if($backurl==url(session()->get('isoCode').'/administrator') or $backurl==(url('').'/'))
//        {



        $array=$request->only($this->username(), 'password');
        $array['status']='1';
        return $array;
//        }
//        else
//        {
//            $array=$request->only($this->username(), 'password' );
//            $array['status']='1';
//            return $array;
//        }
    }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
    protected function authenticated(Request $request, $user)
    {
//        $backurl = URL::previous();
//        if ($backurl == url(session()->get('isoCode').'/administrator') or $backurl==(url('').'/')) {
        return redirect(session()->get('isoCode').'/admin');
//        }
//        else {
//            return redirect('/');
//        }
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
//        $backurl=URL::previous();
//        if($backurl==url(session()->get('isoCode').'/administrator') or $backurl==(url('').'/')) {
        return 'username';
//        }
//        else
//        {
//            return 'email';
//        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


}
