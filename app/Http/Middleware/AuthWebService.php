<?php

namespace App\Http\Middleware;

use Closure;
use App\WebService;

class AuthWebService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

     //   return response()->json(\Request::ip(),200);


        if (!$request->token) {
            return response()->json(['data' => ['error' => 'Bad Request', 'errorMessage' => 'token is missing']], 400);
        }

        $ip = \Request::ip();


        $WsUsers = WebService::where('token', $request->token)->first(); //where('ip', $ip)->

        if (!$WsUsers) {
            return response()->json(['data' => ['error' => 'Unauthorized', 'errorMessage' => 'Unauthorized Account']], 401);
        }

        if ($WsUsers->status == '0') {
            return response()->json(['data' => ['error' => 'Forbidden', 'errorMessage' => 'Forbidden Account']], 403);
        }

        return $next($request);
    }
}
