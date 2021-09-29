<?php

namespace App\Http\Controllers\api\v1\gasht;
use App\Agency;
use App\Gasht;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exceptions\api\BadRequestException;
use App\GashtSell;
use App\City;
use App\WebService;
use App\Http\Resources\gasht\GashtResource;
use App\Http\Resources\gasht\GashtSingleResource;

use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\DB;
use Ipecompany\Smsirlaravel\Smsirlaravel;


class GashtController extends Controller
{


    public function searchCities(Request $req)
    {

        if (!$req->word) {
            throw new BadRequestException();
        }
        if ($req->word) {
            $searchCity = City::where('title_fa', 'LIKE', "%" . $req->word . "%")
                //->where('title_fa','NOT LIKE',"استان%")
                ->where('types', 'city')
                ->limit(15)->get();
            //$citiesJson = json_encode($searchCity, JSON_UNESCAPED_UNICODE);

            return response()->json($searchCity, 200);
        }
    }


    public function allGashts(Request $req)
    {



        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }


        $getAllGasht = Gasht::with('agency', 'city')
            ->where('status', 'active')
            ->skip($skip)
            ->take(10)
            ->orderBy('id', 'desc')
            ->get();




        if (count($getAllGasht)) {
            return response()->json(['data' => new GashtResource($getAllGasht)], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }


    public function searchGashts(Request $req)
    {
        if (isset($req->skip)) {
            $skip = $req->skip * 10;
        } else {
            $skip = 0;
        }




        if (!$req->city_id) {
            throw new BadRequestException();
        }


        $clinetAccess = $this->dataFilter($req->token);




        /*     $dateYear = Jalalian::now()->format("Y");

        if ($req->month) {
            if ($req->month < 10) {
                $dateMonth = '0' . '' . $req->month;
            } else {
                $dateMonth = $req->month;
            }

            $monthMaxDay = (new Jalalian($dateYear, $dateMonth, 01))->getMonthDays();

            $date1 = (new Jalalian($dateYear, $dateMonth, 01))->toCarbon()->toDateTimeString();
            $date2 = (new Jalalian($dateYear, $dateMonth, $monthMaxDay))->toCarbon()->toDateTimeString();

            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = date('Y-m-d', strtotime($date2));
        } */


        $getGasht = Gasht::with('agency', 'city')
            ->where('status', 'active')
            ->where('city_id', $req->city_id);

        if ($clinetAccess['access'] != 'all') {
            $getGasht->where('agency_id', $clinetAccess['agency_id']);
        }






        /*  if ($req->month) {
            $getGasht->where(function ($q) use ($date1, $date2) {
                $q
                    ->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '>=', $date1)
                    ->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '<=', $date2)
                    ->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
            });
        } else {
            $getGasht->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'));
        } */

        $getGasht->where('date', '=', $req->date);


        $getGasht = $getGasht->skip($skip)
            ->take(10)
            ->orderBy('id', 'desc')
            ->paginate(10);



        if (count($getGasht)) {
            return new GashtResource($getGasht);
            //return response()->json(['data' => new GashtResource($getGasht)], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }


    public function singleGasht(Request $req)
    {

        if (!$req->id) {
            throw new BadRequestException();
        }


        $getGasht = Gasht::with('agency', 'city')
            ->where('id', $req->id)
            ->where('status', 'active')
            ->first();



        if ($getGasht) {
            return response()->json(['data' => new GashtSingleResource($getGasht)], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }
    }


    public function checkSelectRequest(Request $req)
    {
        if (!$req->id) {
            throw new BadRequestException();
        }

        if (!$req->adult and !$req->child) {
            throw new BadRequestException();
        }



        $getGasht = Gasht::with('agency', 'city')
            ->where('id', $req->id)
            ->where('status', 'active')
            ->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'))
            ->first();


        if (!$getGasht) {
            return response()->json(['data' => null, 'error' => "Gahst Not Found", 'errorMessage' => 'گشت مورد نظر پیدا نشد'], 400);
        }


        $responseData = array();
        $totalPrice = 0;

        $allReserveCount = $req->adult + $req->child;


        if ($getGasht->capacity <= 0) {
            return response()->json(['data' => null, 'error' => "Gahst Is full", 'errorMessage' => 'ظرفیت این گشت تکمیل شده است'], 400);
        }


        if ($getGasht->capacity < $allReserveCount) {
            return response()->json(['data' => null, 'error' => "Reserve Count Is More Then Capacity", 'errorMessage' => 'تعداد رزرو انتخاب شده از ظرفیت موجود بیشتر میباشد'], 400);
        }


        if ($getGasht->minCount and $getGasht->minCount > 0) {
            if ($allReserveCount < $getGasht->minCount) {
                return response()->json(['data' => null, 'error' => "invalid MinCount", 'errorMessage' => 'تعداد رزرو از حداقل مجاز  کمتر است'], 400);
            }
        }


        if ($req->adult) {
            $totalPrice += $req->adult * $getGasht->adult;
        }

        if ($req->child) {
            $totalPrice += $req->child * $getGasht->child;
        }



        if ($totalPrice <= 0) {
            return response()->json(['data' => null, 'error' => 'invalid price', 'errorMessage' => 'قیمت نامعتبر میباشد'], 400);
        }


        $responseData = [
            'reserve_id' => $req->id,
            'adult_count' => $req->adult,
            'child_count' => $req->child,
            'total_price' => $totalPrice,
            'total_count' => $allReserveCount
        ];

        //  dd($responseData);


        if ($getGasht) {
            return response()->json(['data' => new GashtSingleResource($getGasht), 'reserveData' => $responseData], 200);
        } else {
            return response()->json(['data' => 'No Data available'], 204);
        }

        return response()->json(['data' => $req], 200);
    }


    public function buyReserve(Request $req)
    {
        if (!$req->gasht_id) {
            throw new BadRequestException();
        }

        if (!$req->adult_count and !$req->child_count) {
            //  throw new BadRequestException();
            return response()->json(['data' => null, 'error' => "Gahst Is full", 'errorMessage' => 'تعداد رزرو باید بیشتر از یک نفر باشد'], 400);
        }


        $getGasht = Gasht::with('agency', 'city')
            ->where('id', $req->gasht_id)
            ->where('status', 'active')
            ->where(DB::raw("DATE_FORMAT(date,'%Y-%m-%d')"), '>=', Carbon::now()->format('Y-m-d'))
            ->first();


        if (!$getGasht) {
            //  throw new BadRequestException();
            return response()->json(['data' => null, 'error' => "Gahst Is full", 'errorMessage' => 'خطا در رزرو گشت'], 400);
        }


        $responseData = array();
        $totalPrice = 0;

        $allReserveCount = $req->adult_count + $req->adult_child;


        if ($getGasht->capacity <= 0) {
            return response()->json(['data' => null, 'error' => "Gahst Is full", 'errorMessage' => 'ظرفیت این گشت تکمیل شده است'], 400);
        }


        if ($getGasht->capacity < $allReserveCount) {
            return response()->json(['data' => null, 'error' => "Reserve Count Is More Then Capacity", 'errorMessage' => 'تعداد رزرو انتخاب شده از ظرفیت موجود بیشتر میباشد'], 400);
        }


        if ($getGasht->minCount and $getGasht->minCount > 0) {
            if ($allReserveCount < $getGasht->minCount) {
                return response()->json(['data' => null, 'error' => "invalid MinCount", 'errorMessage' => 'تعداد رزرو از حداقل مجاز  کمتر است'], 400);
            }
        }


        if ($req->adult_count) {
            $totalPrice += $req->adult_count * $getGasht->adult;
        }

        if ($req->child_count) {
            $totalPrice += $req->child_count * $getGasht->child;
        }



        if ($totalPrice <= 0) {
            return response()->json(['data' => null, 'error' => 'invalid price', 'errorMessage' => 'قیمت نامعتبر میباشد'], 400);
        }



        $responseData = [
            'gasht_id' => $req->gasht_id,
            'adult_count' => $req->adult_count,
            'child_count' => $req->child_count,
            'total_price' => $totalPrice,
            'adult_price' => $getGasht->adult,
            'child_price' => $getGasht->child,
            'total_count' => $allReserveCount
        ];

        return response()->json($responseData, 200);
    }


    public function buyResponse(Request $req)
    {
        if (!$req->gasht_id) {
            throw new BadRequestException();
        }

        if (!$req->adult_count and !$req->child_count) {
            throw new BadRequestException();
        }

        if (!$req->reserve_id) {
            throw new BadRequestException();
        }

        $allReserveCount = $req->adult_count + $req->child_count;

        $getGasht = Gasht::find($req->gasht_id);


        if ($getGasht->capacity <= 0) {
            return response()->json(['data' => null, 'error' => "Gahst Is full", 'errorMessage' => 'ظرفیت این گشت تکمیل شده است'], 400);
        }

        if ($getGasht->capacity < $allReserveCount) {
            return response()->json(['data' => null, 'error' => "Reserve Count Is More Then Capacity", 'errorMessage' => 'تعداد رزرو انتخاب شده از ظرفیت موجود بیشتر میباشد'], 400);
        }



        $getGasht->update([
            'capacity' => $getGasht->capacity - $allReserveCount
        ]);

        GashtSell::create([
            'gasht_id' => $req->gasht_id,
            'reserve_id' => $req->reserve_id,
            'adult_count' => $req->adult_count,
            'child_count' => $req->child_count,
            'total_count' => $allReserveCount,
            'price' => $req->price,
            'customer_name' => $req->name,
            'customer_mobile' => $req->mobile,
            'ip' => request()->ip()
        ]);

        $getGashtItems = Gasht::where('id', $req->gasht_id)->with('city')->first();
        $getAgency = Agency::where('id', $getGashtItems->agency_id)->first();

        $reserve_data = [
            'gasht' => $getGashtItems,
            'reserve' => [
                'gasht_id' => $req->gasht_id,
                'reserve_id' => $req->reserve_id,
                'adult_count' => $req->adult_count,
                'child_count' => $req->child_count,
                'total_count' => $allReserveCount,
                'api_price' => $req->price,
            ]
        ];

        if ($reserve_data) {
            Smsirlaravel::ultraFastSend(['gashtName'=>$getGashtItems->title,'code'=>$req->reserve_id],19389,$getAgency->cellPhone);
            return response()->json($reserve_data, 200);
        } else {
            return response()->json(['data' => null, 'error' => "Response Error", 'errorMessage' => 'خطا در دریافت اطلاعات'], 400);
        }
    }


    public function dataFilter($token)
    {
        $client_data = WebService::where('token', $token)->first();
        return ['access' => $client_data->access, 'agency_id' => $client_data->agency_id];
    }
}
