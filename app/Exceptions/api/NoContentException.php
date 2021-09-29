<?php

namespace App\Exceptions\api;

use Exception;

class NoContentException extends Exception
{
    public function render($request){
        return response()->json([
            'error'=>'no data available',
            'http_code'=>'204'
        ],404);
    }


    
}
