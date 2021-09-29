<?php

namespace App\Http\Resources\transfer;

use Illuminate\Http\Resources\Json\ResourceCollection;

use Morilog\Jalali\Jalalian;


use App\Http\Resources\transfer\city;
use App\Http\Resources\transfer\agency;

class TransferResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($items) {
            return [
                'id'=>$items->id,
                'agency_id'=>$items->agency_id,
                'city_id'=>$items->city_id,
                'date'=>Jalalian::forge(strtotime($items->date))->format('Y/m/d'),
                'rand'=>$items->rand,
                'city'=>new city($items->city),
                'agency'=> new agency($items->agency),
                'items'=> $items->titems
               

            ];
        });
    }
}
