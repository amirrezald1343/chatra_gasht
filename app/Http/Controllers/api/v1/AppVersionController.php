<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppVersion;

use App\Exceptions\api\BadRequestException;


class AppVersionController extends Controller
{
  public function androidVersion(Request $req)
  {

    if (!$req->version) {
      throw  new BadRequestException;
    }

    $fromDb = AppVersion::where('status', 'active')->where('os', 'android')->latest('version')->first();

    if ($fromDb->version > $req->version) {
      return response()->json(['data' => ['version' => $fromDb->version, 'url' => $fromDb->url]]);
    } else {
      return response()->json(['data' => 'NoNewVersion']);
    }
  }
}
