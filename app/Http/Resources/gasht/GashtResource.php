<?php

namespace App\Http\Resources\gasht;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Morilog\Jalali\Jalalian;

use App\Http\Resources\gasht\city;
use App\Http\Resources\gasht\agency;

class GashtResource extends ResourceCollection
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
                'title'=>$items->title,
                'agency_id'=>$items->agency_id,
                'city_id'=>$items->city_id,
                'date'=>Jalalian::forge(strtotime($items->date))->format('Y/m/d'),
                'desc'=>$items->desc,
                'adult'=>$items->adult,
                'child'=>$items->child,
                'services'=>$items->services,
                'supplies'=>$items->supplies,
                'capacity'=>$items->capacity,
                'minCount'=>$items->minCount,
                'rand'=>$items->rand,
                //'image' => $this->when($items['image'], 'http://clicksafar.com/' . $items['image'], null),
                'image' => $this->when($items['image'], url('/').'/' . $items['image'], null),
                'city'=>new city($items->city),
                'agency'=> new agency($items->agency),
            ];
        });
    }


}