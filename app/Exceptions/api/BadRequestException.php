<?php

namespace App\Exceptions\api;

use Exception;

class BadRequestException extends Exception
{
    public function render($request){
        return response()->json([
            'error'=>'bad request',
            'http_code'=>'400'
        ],400);
    }
}
