<?php

namespace App\Http\Controllers\api\v1\transfer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Transfer;

use App\Exceptions\api\BadRequestException;

use App\Http\Resources\transfer\TransferResource;
use App\Http\Resources\transfer\TransferSingleResource;


class TransferController extends Controller
{

    public function allTransfers(Request $req)
    {
        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }


        $getAllTransfer = Transfer::with('titems', 'agency', 'city')
            ->where('status', '1')
            ->skip($skip)
            ->take(10)
            ->orderBy('id', 'desc')
            ->get();




        if (count($getAllTransfer)) {
            return new TransferResource($getAllTransfer);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }


    public function searchTransfers(Request $req)
    {

        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }



        if (!$req->city_id) {
            throw new BadRequestException();
        }


        $getGasht = Transfer::with('titems', 'agency', 'city')
            ->where('city_id', $req->city_id)
            ->where('status', '1')
            ->skip($skip)
            ->take(10)
            ->orderBy('id', 'desc')
            ->get();


        if (count($getGasht)) {
            return response()->json(['data' => new TransferResource($getGasht)], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }

    public function singleTransfer(Request $req)
    {


        if (!$req->id) {
            throw new BadRequestException();
        }


        $getGasht = Transfer::with('titems', 'agency', 'city')
            ->where('id', $req->id)
            ->where('status', '1')
            ->first();

        if ($getGasht) {
            return response()->json(['data' => new TransferSingleResource($getGasht)], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }
}
